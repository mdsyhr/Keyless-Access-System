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
    <title>User Data : NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</title>
</head>

<body>
    <button class="openbtn" onclick="openNav()">&#9776; Menu</button>

    <div id="mySidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="assign_card.php"><i class="fas fa-id-card"></i> Assign RFID Card</a>
        <a class="active" href="user_info.php"><i class="fas fa-users"></i> User Data</a>
        <a href="admin_vehicledata.php"><i class="fas fa-car"></i> Vehicle Info</a>
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
                    <label for="email" class="sr-only">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Search by email">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
        </div>
        <div class="row card-container">
        <?php
            include 'database.php';
            $mysqli = Database::connect();
            $email = isset($_GET['email']) ? $_GET['email'] : '';

            if ($email) {
                $sql = 'SELECT * FROM table_nodemcu_rfidrc522_mysql WHERE email LIKE ? ORDER BY name ASC';
                $stmt = $mysqli->prepare($sql);
                $searchTerm = '%' . $email . '%';
                $stmt->bind_param("s", $searchTerm);
            } else {
                $sql = 'SELECT * FROM table_nodemcu_rfidrc522_mysql ORDER BY name ASC';
                $stmt = $mysqli->prepare($sql);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="card">
                        <h2>User Information</h2>
                        <p><strong>ID:</strong> <?php echo htmlspecialchars($row['id']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                        <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($row['mobile']); ?></p>
                        <p><strong>IC Number:</strong> <?php echo htmlspecialchars($row['icNumber']); ?></p>
                        <div class="edit-delete-buttons">
                            <a href="admin_edituser.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary"><i class="fas fa-edit"></i> Edit</a>
                            <a href="admin_deleteuser.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
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
