<?php
    require 'database.php';
    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }

    $mysqli = Database::connect();
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $sql = "SELECT * FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    Database::disconnect();
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
    
    <title>Edit : NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</title>
    
</head>

<body>

    <h2 align="center">NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</h2>
    
    <div class="container">
        <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
            <div class="row">
                <h3 align="center">Edit User Data</h3>
                <p id="defaultGender" hidden><?php echo $data['gender']; ?></p>
            </div>
     
            <form class="form-horizontal" action="user_data_edit_tb.php?id=<?php echo $id ?>" method="post">
                <div class="control-group">
                    <label class="control-label">ID</label>
                    <div class="controls">
                        <input name="id" type="text" placeholder="" value="<?php echo $data['id']; ?>" readonly>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Name</label>
                    <div class="controls">
                        <input name="name" type="text" placeholder="" value="<?php echo $data['name']; ?>" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Gender</label>
                    <div class="controls">
                        <select name="gender" id="mySelect">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input name="email" type="text" placeholder="" value="<?php echo $data['email']; ?>" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Mobile Number</label>
                    <div class="controls">
                        <input name="mobile" type="text" placeholder="" value="<?php echo $data['mobile']; ?>" required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">IC Number</label>
                    <div class="controls">
                        <input name="icNumber" type="text" placeholder="" value="<?php echo $data['icNumber']; ?>" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a class="btn" href="admin_userdata.php">Back</a>
                </div>
            </form
