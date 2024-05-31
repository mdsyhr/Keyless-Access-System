<?php
ob_start();

$host = "localhost"; // Your MySQL host (usually "localhost")
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password (leave empty if not set)
$database = "nodemcu_rfidrc522_mysql"; // Your MySQL database name
$table = "table_nodemcu_rfidrc522_mysql";

// Connect to MySQL server
$link = mysqli_connect($host, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Select the database
mysqli_select_db($link, $database) or die(mysqli_error($link));

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($link, $_POST["email"]);
    $password = mysqli_real_escape_string($link, $_POST["password"]);

    $login_query = "SELECT * FROM $table WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($link, $login_query) or die('Error: ' . mysqli_error($link));
    $count = mysqli_num_rows($result);

    if ($count == 1) {
        session_start();
        $_SESSION['email'] = $email;
        header('Location: user_data.php');
        exit;
    } else {
        header('Location: Login.html?error=1');
        exit;
    }
}

mysqli_close($link);
?>