<?php
session_start();
include('../DBconnection/dbconnection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print All | CTU DANAO Parking System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .print-container, .print-container * {
                visibility: visible;
            }
            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
        .heading-container {
            display: flex;
            justify-content: center;
            margin-bottom: 1.5rem;
        }       
        .text-center {
            text-align: center;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-right: 50vh;
            padding-top: 20px;
        }
        .center-content{
            width: 100%;
        }
        .center2-content{
            width: 100%;
        }
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body onload="printPage()">
    <div class="container">
        <div class="center-content">
            <img src="images/header.png">
        </div>
    </div>

    <div class="heading-container">
        <div class="print-container">
            <h3 class="text-center">All Vehicle Records</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Parking Number</th>
                        <th>Vehicle Category</th>
                        <th>Company</th>
                        <th>Owner</th>
                        <th>Contact</th>
                        <th>In Time</th>
                        <th>Out Time</th>
                        <th>Status</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "
                    SELECT 
                        ParkingSlot,
                        VehicleCategory,
                        VehicleCompanyname,
                        OwnerName,
                        OwnerContactNumber,
                        FormattedInTimeFromLogin AS InTime,
                        FormattedOutTime AS OutTime,
                        IF(FormattedOutTime IS NULL, 'Incoming Vehicle', 'Outgoing Vehicle') AS Status,
                        IF(FormattedOutTime IS NOT NULL, 'Processed', 'Pending') AS Remark
                    FROM (
                        SELECT 
                            tblqr_login.ParkingSlot,
                            tblvehicle.VehicleCategory,
                            tblvehicle.VehicleCompanyname,
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
                        
                        UNION ALL
                        
                        SELECT 
                            tblmanual_login.ParkingSlot,
                            tblvehicle.VehicleCategory,
                            tblvehicle.VehicleCompanyname,
                            tblvehicle.OwnerName,
                            tblvehicle.OwnerContactNumber,
                            DATE_FORMAT(tblmanual_login.TIMEIN, '%h:%i %p %m-%d-%Y') AS FormattedInTimeFromLogin,
                            DATE_FORMAT(tblmanual_logout.TIMEOUT, '%h:%i %p %m-%d-%Y') AS FormattedOutTime
                        FROM 
                            tblmanual_login 
                        INNER JOIN 
                            tblvehicle ON tblmanual_login.RegistrationNumber = tblvehicle.RegistrationNumber 
                        LEFT JOIN 
                            tblmanual_logout ON tblmanual_login.RegistrationNumber = tblmanual_logout.RegistrationNumber
                    ) AS CombinedResults";

                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>
                            <td><?php echo $row['ParkingSlot']; ?></td>
                            <td><?php echo $row['VehicleCategory']; ?></td>
                            <td><?php echo $row['VehicleCompanyname']; ?></td>
                            <td><?php echo $row['OwnerName']; ?></td>
                            <td><?php echo $row['OwnerContactNumber']; ?></td>
                            <td><?php echo $row['InTime']; ?></td>
                            <td><?php echo $row['OutTime'] ?? "N/A"; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo $row['Remark']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="center2-content">
                <img src="images/footer.png">
            </div>
        </div>
    </div>
</body>
</html>
