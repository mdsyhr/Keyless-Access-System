<?php
// Database connection details
$host = "localhost"; // Your MySQL host
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if not set)
$database = "nodemcu_rfidrc522_mysql"; // Your MySQL database name
$table = "table_nodemcu_rfidrc522_mysql"; // Your MySQL table name

// Establish database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$name = $_POST['name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$icNumber = $_POST['icNumber'];
$password = $_POST['password'];

// Sanitize form data (prevent SQL injection)
$name = mysqli_real_escape_string($conn, $name);
$gender = mysqli_real_escape_string($conn, $gender);
$email = mysqli_real_escape_string($conn, $email);
$mobile = mysqli_real_escape_string($conn, $mobile);
$icNumber = mysqli_real_escape_string($conn, $icNumber);
$password = mysqli_real_escape_string($conn, $password);

// SQL query to insert data into the table
$sql = "INSERT INTO $table (name, gender, email, mobile, icNumber, password)
        VALUES ('$name', '$gender', '$email', '$mobile', '$icNumber', '$password')";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo '<script>alert("Registered successfully."); window.location.href = "vehicle_registration.php";</script>';
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
