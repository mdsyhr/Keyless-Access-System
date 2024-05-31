<?php
$Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
file_put_contents('UIDContainer.php', $Write);

require 'database.php';
session_start();

// Check if plate_number is provided
if (isset($_GET['plate_number'])) {
    $plate_number = $_GET['plate_number'];

    // Fetch data from the database
    $mysqli = Database::connect();
    $sql = "SELECT * FROM vehicle_register WHERE plate_number = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $plate_number);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if data exists
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $id = $_POST['id'];

            // Update only the id in the database
            $sql = "UPDATE vehicle_register SET id=? WHERE plate_number=?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ss", $id, $plate_number);
            $stmt->execute();

            // Redirect to the vehicle data page after updating
            header("Location: user_data.php");
            exit();
        }
    } else {
        // Redirect to the vehicle data page if no data found for the provided plate number
        header("Location: user_data.php");
        exit();
    }

    Database::disconnect();
} else {
    // If plate_number is not provided, redirect to the vehicle data page
    header("Location: user_data.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    
    <style>
        html {
            font-family: Arial;
            display: inline-block;
            margin: 0px auto;
        }
        
        textarea {
            resize: none;
        }

        ul.topnav {
            list-style-type: none;
            margin: auto;
            padding: 0;
            overflow: hidden;
            background-color: #4CAF50;
            width: 70%;
        }

        ul.topnav li { float: left; }

        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) { background-color: #3e8e41; }

        ul.topnav li a.active { background-color: #333; }

        ul.topnav li.right { float: right; }

        @media screen and (max-width: 600px) {
            ul.topnav li.right, ul.topnav li { float: none; }
        }
    </style>
    
    <title>Edit Vehicle Registration : NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</title>
</head>

<body>
    <h2 align="center">NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</h2>
    
    <div class="container">
        <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
            <div class="row">
                <h3 align="center">Edit Vehicle Registration</h3>
            </div>
     
            <form class="form-horizontal" action="vehicle_info_edit.php?plate_number=<?php echo $plate_number ?>" method="post">
                <div class="control-group">
                    <label class="control-label">IDs</label>
                    <div class="controls">
                        <input name="IDs" type="text" placeholder="" value="<?php echo $data['IDs']; ?>" readonly>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">UID</label>
                    <div class="controls">
                        <input name="id" id="getUID" placeholder="ID (Tag your Card / Key Chain)" required readonly value="<?php echo $data['id']; ?>">
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input name="email" type="text" placeholder="" value="<?php echo $data['email']; ?>" readonly>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Vehicle Type</label>
                    <div class="controls">
                        <input name="vehicle_type" type="text" placeholder="" value="<?php echo $data['vehicle_type']; ?>" readonly>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Plate Number</label>
                    <div class="controls">
                        <input name="plate_number" type="text" placeholder="" value="<?php echo $data['plate_number']; ?>" readonly>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Brand</label>
                    <div class="controls">
                        <input name="brand" type="text" placeholder="" value="<?php echo $data['brand']; ?>" readonly>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">CC</label>
                    <div class="controls">
                        <input name="cc" type="text" placeholder="" value="<?php echo $data['cc']; ?>" readonly>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Model</label>
                    <div class="controls">
                        <input name="model" type="text" placeholder="" value="<?php echo $data['model']; ?>" readonly>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="user_data_delete_page.php?IDs=<?php echo htmlspecialchars($data['IDs']); ?>" class="btn btn-danger">Delete</a>
                    <a class="btn" href="user_data.php">Back</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Function to fetch and update UID
        function updateUID() {
            // Fetch UID from UIDContainer.php using a GET request
            fetch('UIDContainer.php')
                .then(response => response.text())
                .then(data => {
                    // Update the input field with the fetched UID
                    document.getElementById('getUID').value = data;
                })
                .catch(error => console.error('Error fetching UID:', error));
        }
        
        // Initially update UID
        updateUID();
        
        // Set interval to update UID every 500 milliseconds
        setInterval(updateUID, 500);
    </script>
</body>
</html>
