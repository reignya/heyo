<?php
session_start();
error_reporting(0);
include('../DBconnection/dbconnection.php');
if (strlen($_SESSION['vpmsaid']==0)) {
    header('location:logout.php');
} else {
    $cid = mysqli_real_escape_string($con, $_GET['viewid']);
    $query = "
    SELECT 
        VehicleCategory, 
        VehicleCompanyname, 
        Model, 
        Color, 
        RegistrationNumber, 
        OwnerName, 
        OwnerContactNumber, 
        DATE_FORMAT(InTime, '%h:%i %p %m-%d-%Y') AS InTime
    FROM tblvehicle
    WHERE ID = '$cid'";

    $result = mysqli_query($con, $query);
    if (!$result) {
        error_log("SQL Error in REG.PHP: " . mysqli_error($con), 3, "error_log.txt");
    }
?>
  <!doctype html>
  
  <html class="no-js" lang="">
  <head>
     
      <title>VPMS - View Vehicle Detail</title>
     
  
      <link rel="apple-touch-icon" href="images/ctu.png">
      <link rel="shortcut icon" href="images/ctu.png">
  
  
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
  
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
  
  </head>
  <body>
      <!-- Left Panel -->
  
    <?php include_once('includes/sidebar.php');?>
  
      <!-- Left Panel -->
  
      <!-- Right Panel -->
  
       <?php include_once('includes/header.php');?>
  
          <div class="breadcrumbs">
              <div class="breadcrumbs-inner">
                  <div class="row m-0">
                      <div class="col-sm-4">
                          <div class="page-header float-left">
                              <div class="page-title">
                                  <h1>Dashboard</h1>
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-8">
                          <div class="page-header float-right">
                              <div class="page-title">
                                  <ol class="breadcrumb text-right">
                                      <li><a href="dashboard.php">Dashboard</a></li>
                                      <li><a href="manage-incomingvehicle.php">View Vehicle</a></li>
                                      <li class="active">Incoming Vehicle</li>
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
                        <strong class="card-title">View Incoming Vehicle</strong>
                    </div>
                    <div class="card-body">
                        <?php if ($row = mysqli_fetch_array($result)) { ?>
                        <table class="table table-bordered">
                            <tr><th>Vehicle Category</th><td><?php echo $row['VehicleCategory']; ?></td></tr>
                            <tr><th>Vehicle Company Name</th><td><?php echo $row['VehicleCompanyname']; ?></td></tr>
                            <tr><th>Model</th><td><?php echo $row['Model']; ?></td></tr>
                            <tr><th>Color</th><td><?php echo $row['Color']; ?></td></tr>
                            <tr><th>Registration Number</th><td><?php echo $row['RegistrationNumber']; ?></td></tr>
                            <tr><th>Owner Name</th><td><?php echo $row['OwnerName']; ?></td></tr>
                            <tr><th>Owner Contact Number</th><td><?php echo $row['OwnerContactNumber']; ?></td></tr>
                            <tr><th>Registration Date</th><td><?php echo $row['InTime']; ?></td></tr>
                        </table>
                        <?php } else { ?>
                        <p>No data found.</p>
                        <?php } ?>

                      </div>
                  </div>
              </div>
          </div><!-- .animated -->
      </div><!-- .content -->
  
      <div class="clearfix"></div>
      <?php include_once('includes/footer.php');?>
  
  </div><!-- /#right-panel -->
  
  <!-- Right Panel -->
  
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
  <script src="assets/js/main.js"></script>
  
  
  </body>
  </html>
  <?php }  ?>