<?php
require 'database.php'; // Assuming you have a database.php file for connecting to the database

if(isset($_GET['IDs']) && isset($_GET['confirm'])) {
    $host = "localhost"; // Your MySQL host (usually "localhost")
    $username = "root"; // Your MySQL username
    $password = ""; // Your MySQL password (leave empty if not set)
    $database = "nodemcu_rfidrc522_mysql"; // Your MySQL database name
    $table = "vehicle_register"; // Your MySQL table name
    
    // Connect to MySQL server
    $link = mysqli_connect($host, $username, $password, $database);
    if(!$link) {
        die('Could not connect to the database. Please try again later: ' . mysqli_connect_error());
    }
    
    // Sanitize the IDs parameter
    $IDs = mysqli_real_escape_string($link, $_GET['IDs']);
    
    // Construct the DELETE query with the provided IDs
    $delete_query = "DELETE FROM $table WHERE IDs = '$IDs'";
    
    // Execute the DELETE query
    if(mysqli_query($link, $delete_query)) {
        echo '<p class="alert alert-success">Record deleted successfully.</p>'; // Success message
    } else {
        echo '<p class="alert alert-error">Error deleting record: ' . mysqli_error($link) . '</p>'; // Error message
    }
    
    // Close the MySQL connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Vehicle Info</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Assuming you have Font Awesome for the trash icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>Delete Vehicle</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_GET['IDs'])): ?>
                        <p class="alert alert-danger">Are you sure you want to delete this record?</p>
                        <a href="vehicle_info_delete.php?IDs=<?php echo htmlspecialchars($_GET['IDs']); ?>&confirm=true" class="btn btn-danger" onclick="return confirmDelete();"><i class="fas fa-trash-alt"></i> Delete</a>
                        <?php else: ?>
                        <p class="alert alert-warning">No record selected for deletion.</p>
                        <?php endif; ?>
                        <a href="user_data.php" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
