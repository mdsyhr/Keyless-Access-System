<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Registration Keyless Access System</title>
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
            float: left;
            background: #fff;
            padding: 34px;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            margin-top: 20px;
            margin-bottom: 20px;
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
            width: 135px;
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
        form .input-box input, form .input-box select {
            height: 100%;
            width: calc(100% - 40px);
            outline: none;
            padding: 0 45px 0 40px;
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        .input-box i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #999;
        }
        .input-box input:focus,
        .input-box input:valid,
        .input-box select:focus,
        .input-box select:valid {
            border-color: #008080;
        }
        form .policy {
            display: flex;
            align-items: center;
        }
        form h3 {
            color: #707070;
            font-size: 14px;
            font-weight: 500;
            margin-left: 10px;
        }
        .input-box.button input {
            color: #fff;
            letter-spacing: 1px;
            border: none;
            background: #008080;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .input-box.button input:hover {
            background: #005252;
        }
        form .text h3 {
            color: #333;
            width: 100%;
            text-align: center;
        }
        form .text h3 a {
            color: #008080;
            text-decoration: none;
        }
        form .text h3 a:hover {
            text-decoration: underline;
        }
        .side-text {
            width: 100%;
            color: #fff;
            font-size: 90px;
            text-align: center;
            margin-top: 20px;
            line-height: 1;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
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
    <script>
        function redirectToRegistration() {
            window.location.href = "vehicle_registration.php";
        }
        function validateForm() {
            var name = document.getElementById("name").value;
            var gender = document.getElementById("gender").value;
            var email = document.getElementById("email").value;
            var mobile = document.getElementById("mobile").value;
            var icNumber = document.getElementById("icNumber").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            if (name === "") {
                alert("Please enter your name.");
                return false;
            }
            if (gender === "") {
                alert("Please select your gender.");
                return false;
            }
            if (email === "") {
                alert("Please enter your email.");
                return false;
            }
            if (mobile === "") {
                alert("Please enter your mobile number.");
                return false;
            }
            if (icNumber === "") {
                alert("Please enter your IC number.");
                return false;
            }
            if (password === "") {
                alert("Please enter your password.");
                return false;
            }
            if (confirmPassword === "") {
                alert("Please confirm your password.");
                return false;
            }
            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <h2>Registration</h2>
            <form action="insert_usertb.php" method="post" onsubmit="return validateForm()">
                <div class="input-box">
                    <i class="fas fa-user"></i>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-venus-mars"></i> <!-- Changed icon to indicate gender -->
                    <select id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-phone"></i>
                    <input type="text" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-id-card"></i>
                    <input type="text" id="icNumber" name="icNumber" placeholder="Enter your IC number" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>
                <div class="policy">
                    <input type="checkbox" required>
                    <h3>I accept all terms & condition</h3>
                </div>
                <div class="input-box button">
                    <input type="submit" value="Register Now" onclick="redirectToRegistration()">
                </div>
                <div class="text">
                    <h3>Already have an account? <a href="Login.html" onclick="goToLoginPage()">Login now</a></h3>
                </div>
            </form>
        </div>
        <div class="side-text">
            <p>KEYLESS</p>
            <p>ACCESS</p>
            <p>SYSTEM</p>
        </div>
    </div>
</body>
</html>
