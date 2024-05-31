<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['status'])) {
    // Handle the POST request to store UID and status
    $UIDresult = $_POST['UIDresult'];
    $status = $_POST['status']; // Receive status from POST data

    // Write UID and status to UIDContainer.php
    $Write = "<?php $" . "UIDresult='" . $UIDresult . "'; $" . "status='" . $status . "'; ?>";
    file_put_contents('UIDContainer.php', $Write);

    // Connect to the database and check UID
    $conn = Database::connect();
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM vehicle_register WHERE id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $UIDresult);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    if ($result === false) {
        die("Get result failed: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        echo "UID_FOUND";
    } else {
        echo "UID_NOT_FOUND";
    }

    $stmt->close();
    Database::disconnect();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Handle the GET request to read UID
    include 'UIDContainer.php';
    echo $UIDresult;

    // Read status from file
    include 'StatusContainer.php';
    echo "\n"; // Add a newline for separation
    echo $status;
} else {
    echo "Invalid request method.";
}
?>
