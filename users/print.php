<?php
session_start();
error_reporting(0);
include('../DBconnection/dbconnection.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    echo "<script>console.error('Session variable vpmsaid is not set. Redirect avoided.');</script>";
} else {
    $cid = mysqli_real_escape_string($con, $_GET['vid']);
    $source = mysqli_real_escape_string($con, $_GET['source']); // Get the source parameter

    // Build the query based on the source parameter
    if ($source == 'QR') {
        $query = "
        SELECT 
            tblqr_login.ParkingSlot, 
            tblvehicle.VehicleCategory, 
            tblvehicle.VehicleCompanyname, 
            tblvehicle.Model, 
            tblvehicle.Color, 
            tblvehicle.RegistrationNumber, 
            tblvehicle.OwnerName, 
            tblvehicle.OwnerContactNumber, 
            DATE_FORMAT(tblqr_login.TIMEIN, '%h:%i %p %m-%d-%Y') AS FormattedInTimeFromLogin, 
            DATE_FORMAT(tblqr_logout.TIMEOUT, '%h:%i %p %m-%d-%Y') AS FormattedOutTime 
        FROM 
            tblqr_login 
        INNER JOIN 
            tblvehicle ON tblqr_login.VehiclePlateNumber = tblvehicle.RegistrationNumber 
        LEFT JOIN 
            tblqr_logout ON tblqr_login.VehiclePlateNumber = tblqr_logout.VehiclePlateNumber 
            AND tblqr_login.ParkingSlot = tblqr_logout.ParkingSlot
        WHERE 
            tblqr_login.ID = '$cid'";
    } else {
        $query = "
        SELECT 
            tblmanual_login.ParkingSlot, 
            tblvehicle.VehicleCategory, 
            tblvehicle.VehicleCompanyname, 
            tblvehicle.Model, 
            tblvehicle.Color, 
            tblvehicle.RegistrationNumber, 
            tblvehicle.OwnerName, 
            tblvehicle.OwnerContactNumber, 
            DATE_FORMAT(tblmanual_login.TimeIn, '%h:%i %p %m-%d-%Y') AS FormattedInTimeFromLogin, 
            DATE_FORMAT(tblmanual_logout.TimeOut, '%h:%i %p %m-%d-%Y') AS FormattedOutTime 
        FROM 
            tblmanual_login 
        INNER JOIN 
            tblvehicle ON tblmanual_login.RegistrationNumber = tblvehicle.RegistrationNumber 
        LEFT JOIN 
            tblmanual_logout ON tblmanual_login.RegistrationNumber = tblmanual_logout.RegistrationNumber 
            AND tblmanual_login.ParkingSlot = tblmanual_logout.ParkingSlot
        WHERE 
            tblmanual_login.ID = '$cid'";
    }

    $result = mysqli_query($con, $query);

    if (!$result) {
        error_log("SQL Error in PRINT.PHP: " . mysqli_error($con), 3, "error_log.txt");
    }

    while ($row = mysqli_fetch_array($result)) {
        ?>
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
<title>PRINT | CTU DANAO Parking System</title>        

<!-- <div class="container mt-5">
   
    <form method="GET" class="form-inline">
        <label for="from_date" class="mr-2">From:</label>
        <input type="date" name="from_date" class="form-control mr-3" required>

        <label for="to_date" class="mr-2">To:</label>
        <input type="date" name="to_date" class="form-control mr-3" required>

        <button type="submit" class="btn btn-primary mr-3">Filter</button>
        <button type="button" class="btn btn-success" onclick="window.location.href='print_all.php'">Print All</button>
    </form>
</div> -->

        


<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 0;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-right: 50vh;
            padding-top: 20px;
        }
        .left-content {
            flex: 1;
            text-align: left;
            margin-left: 20px;
        }
        .left-image {
            margin-right: 5px;
            width: 100px;
            height: 100px;
        }
        .right-image {
            margin-left: 100px;
            width: 150px;
            height: 150px;
        }
        .receipt-table {
            margin: 10px;
        }
        .receipt-table td {
            width: 20%;
        }
        .receipt-table th {
            width: 20%;
        }
        #printbtn {
            padding: 5px;
            font-size: 35px;
            position: absolute;
            margin-top: 250px;
            justify-content: center;
            left: 610px;
            cursor: url('https://img.icons8.com/ios-glyphs/28/drag-left.png') 14 14, auto;
        }
        #printbtn:hover {
            opacity: 0.7;
            color: orange;
            font-weight: bolder;
        }
        @media print {
                body {
                    margin: 0;
                    padding: 0;
                    font-size: 12px; 
                }
                .container {
                    display: block;
                    width: 100%; 
                    margin: 0 auto;
                }
                .receipt-table {
                    width: 100%; 
                    border-collapse: collapse;
                }
                .receipt-table th, .receipt-table td {
                    padding: 8px; 
                    font-size: 12px; 
                }
                .left-content, .right-content {
                    display: inline-block; 
                    width: auto; 
                    margin: 0;
                }
                #printbtn {
                    display: none; 
                }
                img {
                    width: auto; 
                    height: auto;
                }
            }
    </style>
</head>
<body>
<div id="exampl" class="receipt-table">
            <div class="container">
                <div class="center-content">
                    <img src="images/header.png">
                </div>
            </div>
            <table border="1" class="table table-bordered mg-b-0">
                <tr>
                    <th colspan="4" style="text-align: center; font-size:22px;">Vehicle Parking Receipt</th>
                  
                </tr>
                <tr>
                    <th>Parking Number</th>
                    <td><?php echo $row['ParkingSlot']; ?></td>
                    <th>Vehicle Category</th>
                    <td><?php echo $row['VehicleCategory']; ?></td>
                </tr>
                <tr>
                    <th>Vehicle Company Name</th>
                    <td><?php echo $row['VehicleCompanyname']; ?></td>
                    <th>Registration Number</th>
                    <td><?php echo $row['RegistrationNumber']; ?></td>
                </tr>
                <tr>
                    <th>Owner Name</th>
                    <td><?php echo $row['OwnerName']; ?></td>
                    <th>Owner Contact Number</th>
                    <td><?php echo $row['OwnerContactNumber']; ?></td>
                </tr>
                <tr>
                    <th>In Time</th>
                    <td><?php echo $row['FormattedInTimeFromLogin']; ?></td>
                    <th>Out Time</th>
                        <td colspan="3"><?php echo $row['FormattedOutTime']; ?></td>
                </tr>
              
            </table>
            <div class="container">
                <div class="center-content">
                    <img src="images/footer.png" >
                </div>
            </div>
        </div>


        <script>
         function CallPrint() {
    const prtContent = document.getElementById('exampl').innerHTML;
    const printButton = document.getElementById('printbtn');

    // Temporarily hide the print button
    printButton.style.display = 'none';

    // Open a new window for printing
    const WinPrint = window.open('', '', 'left=0,top=0,width=900,height=900,toolbar=0,scrollbars=0,status=0');
    
    // Write the content and include necessary styles
    WinPrint.document.write(`
        <html>
        <head>
            <title>Print View</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
            <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
            <link rel="stylesheet" href="assets/css/style.css">
            <style>
                @media print {
                    #printbtn {
                        display: none; /* Ensure print button is hidden */
                    }
                    body {
                        margin: 0;
                    }
                }
            </style>
        </head>
        <body>
            ${prtContent}
        </body>
        </html>
    `);

    // Close the document and trigger print dialog
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();

    // Restore the original visibility of the print button after printing
    printButton.style.display = 'block';
}


        </script>
    </body>
    </html>

<?php
    }
}
?>
