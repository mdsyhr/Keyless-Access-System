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

    $sql = "SELECT * FROM vehicle_register WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    Database::disconnect();

    $msg = null;
    if (!$data) {
        $msg = "The ID of your Card / KeyChain is not registered !!!";
        $data['id'] = $id;
        $data['email'] = "--------";
        $data['vehicle_type'] = "--------";
        $data['plate_number'] = "--------";
        $data['brand'] = "--------";
        $data['cc'] = "--------";
        $data['mode;'] = "--------";
    }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <style>
        td.lf {
            padding-left: 15px;
            padding-top: 12px;
            padding-bottom: 12px;
        }
    </style>
</head>
 
<body>    
    <div>
        <form>
            <table width="452" border="1" bordercolor="#10a0c5" align="center" cellpadding="0" cellspacing="1" bgcolor="#000" style="padding: 2px">
                <tr>
                    <td height="40" align="center" bgcolor="#10a0c5"><font color="#FFFFFF"><b>User Data</b></font></td>
                </tr>
                <tr>
                    <td bgcolor="#f9f9f9">
                        <table width="452" border="0" align="center" cellpadding="5" cellspacing="0">
                            <tr>
                                <td width="113" align="left" class="lf">ID</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['id']); ?></td>
                            </tr>
                            <tr bgcolor="#f2f2f2">
                                <td align="left" class="lf">Email</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['email']); ?></td>
                            </tr>
                            <tr>
                                <td align="left" class="lf">Vehicle Type</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['vehicle_type']); ?></td>
                            </tr>
                            <tr bgcolor="#f2f2f2">
                                <td align="left" class="lf">Plate Number</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['plate_number']); ?></td>
                            </tr>
                            <tr>
                                <td align="left" class="lf">Brand</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['brand']); ?></td>
                            </tr>
                            <tr>
                                <td align="left" class="lf">CC</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['cc']); ?></td>
                            </tr>
                            <tr>
                                <td align="left" class="lf">Model</td>
                                <td style="font-weight:bold">:</td>
                                <td align="left"><?php echo htmlspecialchars($data['model']); ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <p style="color:red;"><?php echo htmlspecialchars($msg); ?></p>
</body>
</html>
