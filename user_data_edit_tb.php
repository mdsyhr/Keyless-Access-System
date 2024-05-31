<?php
    require 'database.php';
 
    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if (!empty($_POST)) {
        // keep track post values
        $name = $_POST['name'];
        $id = $_POST['id'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
         
        $mysqli = Database::connect();
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $sql = "UPDATE table_nodemcu_rfidrc522_mysql SET name = ?, gender = ?, email = ?, mobile = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssssi', $name, $gender, $email, $mobile, $id);
        $stmt->execute();
        
        Database::disconnect();
        header("Location: user_data.php");
    }
?>
