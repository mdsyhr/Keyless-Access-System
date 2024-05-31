<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .card-container {
            margin-bottom: 30px;
        }
        .user-info, .vehicle-info {
            font-size: 24px;
            margin-bottom: 20px;
            color: #555;
        }
        .card-container {
            display: flex;
            justify-content: center;
        }
        .card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            width: calc(100% - 40px);
            max-width: 500px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card p {
            margin: 10px 0;
            color: #333;
        }
        .edit-delete-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background: linear-gradient(45deg, #008080, #4CAF50);
            box-shadow: 2px 0 5px rgba(0,0,0,0.5);
            overflow-x: hidden;
            transition: width 0.5s;
            padding-top: 60px;
        }

        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: background-color 0.3s, transform 0.3s;
            margin: 5px 10px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(10px);
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #008080;
            color: white;
            padding: 10px 15px;
            border: none;
            position: fixed;
            top: 15px;
            left: 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        @media screen and (max-height: 450px) {
            .sidebar { padding-top: 15px; }
            .sidebar a { font-size: 18px; }
        }
    </style>
    <title>Vehicle Data : Keyless Access System</title>
</head>

<body>
    <button class="openbtn" onclick="openNav()">&#9776; Menu</button>

    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="assign_card.php"><i class="fas fa-id-card"></i> Assign RFID Card</a>
        <a href="user_info.php"><i class="fas fa-users"></i> User Data</a>
        <a class="active" href="vehicle_info.php"><i class="fas fa-car"></i> Vehicle Info</a>
        <a href="vehicle_registration.php"><i class="fas fa-car-side"></i> Register Vehicle</a>
        <a href="logout_admin.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="container">
        <div class="col-md-12 text-center">
            <h2>Keyless Access System</h2>
        </div>
        <div class="row justify-content-center mb-4">
            <form class="form-inline" method="GET" action="">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="plate_number" class="sr-only">Plate Number</label>
                    <input type="text" class="form-control" id="plate_number" name="plate_number" placeholder="Search by plate number">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
        </div>
        <div class="row card-container">
        <?php
            include 'database.php';
            $mysqli = Database::connect();
            $plate_number = isset($_GET['plate_number']) ? $_GET['plate_number'] : '';

            if ($plate_number) {
                $sql_vehicle = 'SELECT * FROM vehicle_register WHERE plate_number LIKE ? ORDER BY id ASC';
                $stmt_vehicle = $mysqli->prepare($sql_vehicle);
                $searchTerm = '%' . $plate_number . '%';
                $stmt_vehicle->bind_param("s", $searchTerm);
            } else {
                $sql_vehicle = 'SELECT * FROM vehicle_register ORDER BY id ASC';
                $stmt_vehicle = $mysqli->prepare($sql_vehicle);
            }

            $stmt_vehicle->execute();
            $result_vehicle = $stmt_vehicle->get_result();

            if ($result_vehicle->num_rows > 0) {
                while ($row_vehicle = $result_vehicle->fetch_assoc()) {
                    ?>
                    <div class="card">
                        <h3><?php echo htmlspecialchars($row_vehicle['vehicle_type']); ?></h3>
                        <p><strong>ID:</strong> <?php echo htmlspecialchars($row_vehicle['IDs']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row_vehicle['email']); ?></p>
                        <p><strong>Plate Number:</strong> <?php echo htmlspecialchars($row_vehicle['plate_number']); ?></p>
                        <p><strong>UID:</strong> <?php echo htmlspecialchars($row_vehicle['id']); ?></p>
                        <p><strong>Brand:</strong> <?php echo htmlspecialchars($row_vehicle['brand']); ?></p>
                        <p><strong>CC:</strong> <?php echo htmlspecialchars($row_vehicle['cc']); ?></p>
                        <p><strong>Model:</strong> <?php echo htmlspecialchars($row_vehicle['model']); ?></p>
                        <div class="edit-delete-buttons">
                           <a href="admin_deletevehicle.php?IDs=<?php echo htmlspecialchars($row_vehicle['IDs']); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="card">
                    <p>No records found</p>
                </div>
                <?php
            }

            Database::disconnect();
        ?>
        </div>
    </div> <!-- /container -->

    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
        }
    </script>
</body>
</html>
