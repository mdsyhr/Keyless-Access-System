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

        ul.topnav li {float: left;}

        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) {background-color: #3e8e41;}

        ul.topnav li a.active {background-color: #333;}

        ul.topnav li.right {float: right;}

        @media screen and (max-width: 600px) {
            ul.topnav li.right, 
            ul.topnav li {float: none;}
        }
    </style>
    
    <title>Forgot Password : Keyless Access System</title>
</head>

<body>

    <h2 style="text-align: center;">Keyless Access System</h2>

    <div class="container">
        <div class="center" style="margin: 0 auto; width:495px; border-style: solid; border-color: #f2f2f2;">
            <div class="row">
                <h3 style = "text-align: center;">Forgot Password</h3>
            </div>
     
            <?php
               $host = "localhost"; // Your MySQL host
               $username = "root"; // Your MySQL username
               $password = ""; // Your MySQL password (leave empty if not set)
               $database = "nodemcu_rfidrc522_mysql"; // Your MySQL database name
               $table = "table_nodemcu_rfidrc522_mysql"; // Your MySQL table name

                // Connect to MySQL server
                $link = mysqli_connect($host, $username, $password);
                if (!$link) {
                    die('Could not connect to the database. Please try again later: ' . mysqli_connect_error());
                }

                // Select the database
                mysqli_select_db($link, $database) or die(mysqli_error($link));

                // Handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Sanitize form data
                    $email = mysqli_real_escape_string($link, $_POST["email"]);
                    $new_password = mysqli_real_escape_string($link, $_POST["new_password"]);
                    $confirm_password = mysqli_real_escape_string($link, $_POST["confirm_password"]);

                    if ($new_password != $confirm_password) {
                        echo '<script>alert("Passwords do not match.");</script>';
                    } else {
                        // Check if the email exists in the database
                        $sql = "SELECT * FROM $table WHERE email = '$email'";
                        $result = mysqli_query($link, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            // Update the password in the database
                            $update_sql = "UPDATE $table SET password='$new_password' WHERE email='$email'";
                            if (mysqli_query($link, $update_sql)) {
                                echo '<script>alert("Password updated successfully."); window.location.href = "Login.html";</script>';
                                exit();
                            } else {
                                echo "Error updating password: " . mysqli_error($link);
                                mysqli_close($link);
                                exit();
                            }
                        } else {
                            echo '<script>alert("Email not found.");</script>';
                        }
                    }
                }

                // Close the MySQL connection
                mysqli_close($link);
            ?>


            <form class="form-horizontal" action="forgot_password.php" method="post" onsubmit="return validateForm()">
                <div class="control-group">
                    <label class="control-label">Email Address</label>
                    <div class="controls">
                        <input id="email" name="email" type="text" placeholder="Enter your email" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">New Password</label>
                    <div class="controls">
                        <input id="new_password" name="new_password" type="password" placeholder="Enter new password" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">Confirm New Password</label>
                    <div class="controls">
                        <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm new password" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Reset Password</button>
                    <a class="btn" href="Login.html">Back</a>
                </div>
            </form>
        </div>               
    </div> <!-- /container -->
    
    <script>
        function validateForm() {
            var email = document.getElementById("email").value;
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            
            // Regular expression for a valid email
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
            if (!email.match(emailPattern)) {
                alert("Please enter a valid email address.");
                return false;
            }
    
            if (newPassword !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }
    
            return true;
        }
    </script>
</body>
</html>
