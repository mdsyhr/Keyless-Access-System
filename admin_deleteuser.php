<?php
    require 'database.php';
    $id = null;
    if (!empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if (!empty($_POST)) {
        // keep track post values
        $id = $_POST['id'];
         
        // delete data
        $mysqli = Database::connect();
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        $sql = "DELETE FROM table_nodemcu_rfidrc522_mysql WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        Database::disconnect();
        header("Location: admin_userdata.php");
        exit;
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Delete : User</title>
</head>
 
<body>
    <h2 align="center">Keyless Access System</h2>

    <div class="container">
     
        <div class="span10 offset1">
            <div class="row">
                <h3 align="center">Delete User</h3>
            </div>

            <form class="form-horizontal" action="admin_deleteuser.php" method="post">
                <input type="hidden" name="id" value="<?php echo $id;?>"/>
                <p class="alert alert-error">Are you sure to delete ?</p>
                <div class="form-actions">
                    <button type="submit" class="btn btn-danger">Yes</button>
                    <a class="btn" href="admin_userdata.php">Back</a>
                </div>
            </form>
        </div>
                 
    </div> <!-- /container -->
</body>
</html>
