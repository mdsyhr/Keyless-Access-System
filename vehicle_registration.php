<?php
    $Write="<?php $" . "UIDresult=''; " . "echo $" . "UIDresult;" . " ?>";
    file_put_contents('UIDContainer.php',$Write);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration : NodeMCU V3 ESP8266 / ESP12E with MYSQL Database</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- FontAwesome CSS -->
    <script src="js/bootstrap.min.js"></script>
    <script src="jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            // Function to fetch and update UID
            function updateUID() {
                $.ajax({
                    url: "UIDContainer.php", // URL to fetch the UID
                    success: function(data) {
                        $("#getUID").val(data); // Update input with UID
                    }
                });
            }
            
            // Initially update UID
            updateUID();
            
            // Set interval to update UID every 500 milliseconds
            setInterval(updateUID, 500);
        });
    </script>
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
            flex-wrap: wrap; /* Allow elements to wrap */
            justify-content: space-between;
            align-items: center;
            width: 90%; /* Adjusted width for better responsiveness */
            max-width: 900px;
            margin: 0 auto; /* Center container */
        }
        .wrapper {
            width: 100%; /* Adjusted width for better responsiveness */
            float: left;
            background: #fff;
            padding: 34px;
            border-radius: 6px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
            margin-top: 20px; /* Add space above the form */
            margin-bottom: 20px; /* Add space below the form */
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
        form .input-box input {
            height: 100%;
            width: calc(100% - 40px); /* Adjusted width for icon */
            outline: none;
            padding: 0 45px 0 40px; /* Adjusted padding for icon */
            font-size: 17px;
            font-weight: 400;
            color: #333;
            border: 1.5px solid #C7BEBE;
            border-bottom-width: 2.5px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .input-box i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #999; /* Icon color */
        }
        .input-box input:focus,
        .input-box input:valid {
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

        .side-text {
            width: 100%; /* Adjusted width for better responsiveness */
            color: #fff;
            font-size: 90px; /* Increased font size */
            text-align: center; /* Align text to the center */
            margin-top: 20px; /* Add space between text and the form */
            line-height: 1; /* Adjust line height */
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }

        @media screen and (min-width: 768px) {
            .container {
                width: 80%; /* Adjusted width for larger screens */
            }

            .wrapper {
                width: 48%; /* Adjusted width for larger screens */
            }

            .side-text {
                width: 48%; /* Adjusted width for larger screens */
                font-size: 100px; /* Adjusted font size for larger screens */
                text-align: right; /* Align text to the right on larger screens */
                margin-top: 0; /* Reset margin-top for larger screens */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <h2>Vehicle Registration Form</h2>
            <form action="insertDB.php" method="post">
                <div class="input-box">
                    <i class="fas fa-id-card"></i>
                    <input name="id" id="getUID" placeholder="ID (Tag your Card / Key Chain)" required readonly>
                </div>
                <div class="input-box">
                    <i class="fas fa-envelope"></i>
                    <input name="email" type="email" placeholder="Email Address" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-car"></i>
                    <input name="vehicle_type" type="text" placeholder="Vehicle Type" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-list-alt"></i>
                    <input name="plate_number" type="text" placeholder="Plate Number" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-car-side"></i>
                    <input name="brand" type="text" placeholder="Brand" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-cogs"></i>
                    <input name="cc" type="text" placeholder="CC" required>
                </div>
                <div class="input-box">
                    <i class="fas fa-car-alt"></i>
                    <input name="model" type="text" placeholder="Model" required>
                </div>
                <div class="input-box button">
                    <input type="submit" value="Save">
                </div>
            </form>
        </div>
        <div class="side-text">
            <p>KEYLESS</p>
            <p>ACCESS</p>
            <p>SYSTEM</p>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('form').submit(function(e) {
                e.preventDefault(); // Prevent form submission

                // Serialize form data
                var formData = $(this).serialize();

                // Submit form via AJAX
                $.ajax({
                    type: 'POST',
                    url: 'insertDB.php',
                    data: formData,
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if (response.success) {
                            // Registration successful, inform the user
                            alert(response.message);
                            // Redirect to Login.html
                            window.location.href = 'Login.html';
                        } else {
                            // Registration failed, inform the user
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                        alert('An error occurred while processing your request. Please try again later.');
                    }
                });
            });
        });
</script>


</body>
</html>
