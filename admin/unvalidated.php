<?php
session_start();
include('../DBconnection/dbconnection.php');

// Fetch unvalidated clients
$queryUnvalidated = "SELECT email FROM uploads WHERE validity = 0 OR expiration_date < CURDATE()";
$resultUnvalidated = mysqli_query($con, $queryUnvalidated);

if (mysqli_num_rows($resultUnvalidated) > 0) {
    echo "<h1>Unvalidated Clients</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Email</th></tr>";

    while ($row = mysqli_fetch_assoc($resultUnvalidated)) {
        echo "<tr><td>{$row['email']}</td></tr>";
    }
    echo "</table>";
} else {
    echo "No unvalidated clients found.";
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" href="images/ctu.png">
    <link rel="shortcut icon" href="images/ctu.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

    <style>
        body{
            background: whitesmoke;
            overflow: auto;
        }
        p{
            margin-left: 10px;
        }
        </style>
    <title>Unvalidated | CTU Danao Parking System</title>
    <body>
<?php include_once('includes/sidebar.php'); ?>
    <!-- Right Panel -->

    <?php include_once('includes/header.php'); ?>

    <!-- Breadcrumbs Section -->
    <div class="breadcrumbs mb-5">
        <div class="breadcrumbs-inner">
            <div class="row m-0">
                <div class="col-sm-4">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h1>Driver's License Validation</h1>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="page-header float-right">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="dashboard.php">Dashboard</a></li>
                                <li><a href="validation.php">Unvalidated</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    <p>No unvalidated clients found.</p>
<!--<button onclick="window.history.back()">Back</button>-->
</body>
</html>
