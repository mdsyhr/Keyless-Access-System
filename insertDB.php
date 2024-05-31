<?php
require 'database.php'; // Assuming you have a database.php file for connecting to the database

// Connect to the database
$mysqli = Database::connect();

// Retrieve the UID from the POST request
$uid = $_POST['id'];

// Prepare and execute the SQL statement to check if the UID exists
$sql_check = "SELECT * FROM vehicle_register WHERE id = ?";
$stmt_check = $mysqli->prepare($sql_check);
$stmt_check->bind_param("s", $uid);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

// Check if the UID exists
if ($result_check->num_rows > 0) {
    // UID already exists, return error message
    $response = array("success" => false, "message" => "This UID is already registered. Please use a different UID.");
} else {
    // UID does not exist, proceed with the registration
    $email = $_POST['email'];
    $vehicle_type = $_POST['vehicle_type'];
    $plate_number = $_POST['plate_number'];
    $brand = $_POST['brand'];
    $cc = $_POST['cc'];
    $model = $_POST['model'];

    // Prepare and execute the SQL statement to insert the new record
    $sql_insert = "INSERT INTO vehicle_register (id, email, vehicle_type, plate_number, brand, cc, model) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $mysqli->prepare($sql_insert);
    $stmt_insert->bind_param("sssssss", $uid, $email, $vehicle_type, $plate_number, $brand, $cc, $model);
    $stmt_insert->execute();

    // Set success response
    $response = array("success" => true, "message" => "Registration successful!");
}

// Close the database connection
Database::disconnect();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
