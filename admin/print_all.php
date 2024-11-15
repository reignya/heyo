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
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body onload="printPage()">
    <div class="container mt-5 print-container">
        <h3 class="text-center mb-4">All Vehicle Records</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Vehicle Category</th>
                    <th>Plate Number</th>
                    <th>Make/Brand</th>
                    <th>Owner</th>
                    <th>Contact</th>
                    <th>Registration</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM tblvehicle";
                $result = mysqli_query($con, $query);

                while ($row = mysqli_fetch_array($result)) {
                    $status = ($row['Status'] == "Out") ? "Outgoing Vehicle" : "Incoming Vehicle";
                    $outTime = ($row['Status'] == "Out") ? $row['OutTime'] : "N/A";
                    $remark = ($row['Status'] == "Out") ? $row['Remark'] : "N/A";
                ?>
                    <tr>
                        <td><?php echo $row['VehicleCategory']; ?></td>
                        <td><?php echo $row['RegistrationNumber']; ?></td>
                        
                        <td><?php echo $row['VehicleCompanyname']; ?></td>
                        <td><?php echo $row['OwnerName']; ?></td>
                        <td><?php echo $row['OwnerContactNumber']; ?></td>
                        <td><?php echo $row['InTime']; ?></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
