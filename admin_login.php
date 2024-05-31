<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username === "KAS_admin" && $password === "@KAS_admin2324") {
        $_SESSION['username'] = $username;
        header('Location: admin_userdata.php'); // Redirect to the admin dashboard page
        exit;
    } else {
        $error = 'Wrong username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <title>Admin Login Keyless Access System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #008B8B;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 900px;
            margin: 0 auto;
        }

        .wrapper {
            width: 100%;
            background: #fff;
            padding: 34px;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .wrapper h2 {
            position: relative;
            font-size: 22px;
            font-weight: 600;
            color: #333;
        }

        .wrapper h2::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 60px;
            border-radius: 12px;
            background: #008080;
        }

        .wrapper form {
            margin-top: 30px;
        }

        .wrapper form .input-box {
            height: 52px;
            margin: 18px 0;
            position: relative;
        }

        form .input-box input {
            height: 100%;
            width: 100%;
            outline: none;
            padding: 0 15px 0 40px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #c7bebe;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .input-box i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
        }

        .input-box input:focus,
        .input-box input:valid {
            border-color: #008080;
        }

        .input-box.button input {
            color: #fff;
            letter-spacing: 1px;
            border: none;
            background: #008080;
            cursor: pointer;
        }

        .input-box.button input:hover {
            background: #005252;
        }

        form .text {
            color: #333;
            width: 100%;
            text-align: center;
            font-size: 14px;
        }

        form .text a {
            color: #008080;
            text-decoration: none;
        }

        form .text a:hover {
            text-decoration: underline;
        }

        form .text h3 {
            margin: 10px 0;
            font-size: 14px;
        }

        .side-text {
            width: 100%;
            color: #fff;
            font-size: 90px;
            text-align: center;
            margin-top: 20px;
            line-height: 1;
        }

        @media screen and (min-width: 768px) {
            .container {
                width: 80%;
            }
            
            .wrapper {
                width: 48%;
            }
            
            .side-text {
                width: 48%;
                font-size: 100px;
                text-align: right;
                margin-top: 0;
            }
        }
    </style>
    
</head>
<body>
<div class="container">
    <div class="wrapper">
        <h2>Admin Login</h2>
        <?php
        if (isset($error)) {
            echo '<p style="color: red; text-align: center;">' . $error . '</p>';
        }
        ?>
        <form method="post" action="">
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Enter your username" required>
            </div>
            <div class="input-box">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="input-box button">
                <input type="submit" name="submit" value="Login Now">
            </div>
            
        </form>
    </div>
    <div class="side-text">
        <p>KEYLESS</p>
        <p>ACCESS</p>
        <p>SYSTEM</p>
        <p>ADMIN</p>
    </div>
</div>
</body>
</html>
