<?php
session_start();
error_reporting(0);
include('../DBconnection/dbconnection.php');
if (strlen($_SESSION['vpmsuid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <title>CTU - Danao Parking System - View Vehicle Parking Details</title>
    <link rel="apple-touch-icon" href="images/ctu.png">
    <link rel="shortcut icon" href="images/ctu.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../admin/assets/css/style.css">
    <style>
        #printbtn:hover {
            background: orange;
            color: black;
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); 
        }
        #printbtn {
            background: yellowgreen;
            color: white;
        }
    </style>
</head>
<body>
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('userheader.php'); ?>

    <div class="breadcrumbs">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Vehicle Logs</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li><a href="view-vehicle.php">View Vehicle Parking Details</a></li>
                                <li class="active">View Vehicle Parking Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">View Vehicle Parking Details (on the basis of Registered Mobile No)</strong>
                            <a href="print.php" target="_blank" class="btn btn-success float-right" id="printbtn">🖶 Print All Records</a>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Parking Number</th>
                                        <th>Owner Name</th>
                                        <th>Vehicle Reg Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ownerno = $_SESSION['vpmsumn'];
                                    $ret = mysqli_query($con, "SELECT tblregusers.FirstName, tblregusers.LastName, tblregusers.MobileNumber, tblregusers.Email, tblvehicle.ParkingNumber, tblvehicle.VehicleCategory, tblvehicle.VehicleCompanyname, tblvehicle.RegistrationNumber, tblvehicle.OwnerName, tblvehicle.ID as vehid, tblvehicle.OwnerContactNumber, tblvehicle.InTime, tblvehicle.OutTime FROM tblvehicle JOIN tblregusers ON tblregusers.MobileNumber = tblvehicle.OwnerContactNumber WHERE tblvehicle.OwnerContactNumber = '$ownerno'");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $cnt; ?></td>
                                            <td><?php echo $row['ParkingNumber']; ?></td>
                                            <td><?php echo $row['OwnerName']; ?></td>
                                            <td><?php echo $row['RegistrationNumber']; ?></td>
                                            <td>
                                                <a href="view--detail.php?viewid=<?php echo $row['vehid']; ?>" class="btn btn-primary" id="viewbtn">🖹 View</a>
                                            </td>
                                        </tr>
                                    <?php 
                                        $cnt++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <div class="clearfix"></div>
</div><!-- /#right-panel -->

<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
