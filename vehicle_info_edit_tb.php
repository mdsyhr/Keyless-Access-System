<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plate_number = $_POST['plate_number'];
    $email = $_POST['email'];
    $vehicle_type = $_POST['vehicle_type'];
    $id = $_POST['id'];
    $brand = $_POST['brand'];
    $cc = $_POST['cc'];
    $model = $_POST['model'];

    // Database connection
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update record
    $sql = "UPDATE vehicle_register SET 
                email=?, 
                vehicle_type=?, 
                id=?, 
                brand=?, 
                cc=?, 
                model=? 
            WHERE plate_number=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $email, $vehicle_type, $id, $brand, $cc, $model, $plate_number);

    if ($stmt->execute() === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
