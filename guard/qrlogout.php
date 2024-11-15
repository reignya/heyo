<?php
session_start();
date_default_timezone_set('Asia/Manila');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "parking";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $sqlDelete = "DELETE FROM tblqr_logout WHERE ID = '$id'";
    if ($conn->query($sqlDelete) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['qrData'])) {
    $qrData = $_POST['qrData'];
    $dataLines = explode("\n", $qrData);
    $vehicleType = str_replace('Vehicle Type: ', '', $dataLines[0]);
    $vehiclePlateNumber = str_replace('Plate Number: ', '', $dataLines[1]);
    $name = str_replace('Name: ', '', $dataLines[2]);
    $mobilenum = str_replace('Contact Number: ', '', $dataLines[3]);

    // Check if the vehicle has a recent login entry
    $sqlFindLogin = "SELECT ParkingSlot FROM tblqr_login WHERE VehiclePlateNumber = '$vehiclePlateNumber' AND Name = '$name' ORDER BY TIMEIN DESC LIMIT 1";
    $resultLogin = $conn->query($sqlFindLogin);

    if ($resultLogin->num_rows > 0) {
        $rowLogin = $resultLogin->fetch_assoc();
        $occupiedSlots = explode(', ', $rowLogin['ParkingSlot']);

        // Proceed with logout regardless of existing logout entries
        $timeOut = date("Y-m-d h:i:s A");
        $sqlInsert = "INSERT INTO tblqr_logout (Name, ContactNumber, VehicleType, VehiclePlateNumber, ParkingSlot, TIMEOUT)
                      VALUES ('$name', '$mobilenum', '$vehicleType', '$vehiclePlateNumber', '{$rowLogin['ParkingSlot']}', '$timeOut')";

if ($conn->query($sqlInsert) === TRUE) {
    foreach ($occupiedSlots as $slot) {
        $updateSlot = "UPDATE tblparkingslots SET Status = 'Vacant' WHERE SlotNumber = '$slot'";
        $conn->query($updateSlot);
    }
    $_SESSION['success'] = 'Vehicle logged out successfully.';
} else {
    $_SESSION['error'] = 'Error: ' . $conn->error;
}
} else {
$_SESSION['error'] = 'No login record found for this vehicle. Please log in first before logging out.';
}

    header('Location: qrlogout.php');
    exit();
}

// Query the current day logout records
$sql = "SELECT ID, Name, ContactNumber, VehicleType, VehiclePlateNumber, ParkingSlot, TIMEOUT FROM tblqr_logout WHERE DATE(TIMEOUT) = CURDATE() ORDER BY TIMEOUT DESC";
$result = $conn->query($sql);
$conn->close();
?>

<html class="no-js" lang="">
<head>
    <script type="text/javascript" src="js/adapter.min.js"></script>
    <script type="text/javascript" src="js/vue.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="apple-touch-icon" href="images/ctu.png">
    <link rel="shortcut icon" href="images/ctu.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="guard.css">

    <title>QR Code Logout Scanner | CTU DANAO Parking System</title>

    <style>
        body {
            color: black;
            background-color: #f9fcff;
            background-image: linear-gradient(147deg, #f9fcff 0%, #dee4ea 74%);
        }
        .no-js {
            background-color: #f9fcff;
            background-image: linear-gradient(147deg, #f9fcff 0%, #dee4ea 74%);
        }
        .container {
            padding: 20px;
        }
        .scanner-container, .table-container {
            margin-top: 20px;
        }
        video {
            width: 500px; /* Reduced size */
            height: 300px; /* Square scanner */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: block;
            margin: 0 auto; /* Centered */
        }
        table {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            border-radius: 5px;
        }
        .scanner-label {
            font-weight: bold; 
            color: orange; 
            font-size: 20px; 
            text-align: center; 
            margin-top: 10px;
        }
        .alert {
            transition: opacity 0.5s ease;
        }
    </style>
</head>
<body>

<!-- Responsive Navigation Bar -->
<?php include_once('includes/headerout.php');?>

<div class="container" style="background: transparent;">
    <div class="row">
        <!-- Scanner Section -->
        <div class="col-md-12 scanner-container">
            <video id="preview"></video>
            <div class="scanner-label">SCAN QR CODE <i class="fas fa-qrcode"></i></div>

            <?php
                if (isset($_SESSION['error'])) {
                    echo "
                    <div class='alert alert-danger mt-2'>
                        <h4>Error!</h4>
                        " . $_SESSION['error'] . "
                    </div>
                    ";
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo "
                    <div class='alert alert-primary mt-2 alert-dismissible fade show' role='alert' id='successAlert'>
                        <h4>Success!</h4>
                        " . $_SESSION['success'] . "
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    ";
                    unset($_SESSION['success']);
                }
                ?>
        </div>

        <!-- Table Section -->
        <div class="col-md-12 table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td>No.</td>
                        <td>Name</td>
                        <td>Contact Number</td>
                        <td>Vehicle Type</td>
                        <td>Vehicle Plate Number</td>
                        <td>Parking Slot</td>
                        <td>TIMEOUT</td>
                        <td>Action</td> <!-- New column for delete action -->
                    </tr>
                </thead>
                <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $formattedTimeout = date("h:i:s A m-d-y", strtotime($row['TIMEOUT']));
                        echo "
                        <tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['Name']}</td>
                            <td>{$row['ContactNumber']}</td>
                            <td>{$row['VehicleType']}</td>
                            <td>{$row['VehiclePlateNumber']}</td>
                            <td>{$row['ParkingSlot']}</td>
                            <td>{$formattedTimeout}</td>
                            <td>
                            <button onclick=\"deleteEntry(" . $row['ID'] . ")\" class=\"btn btn-danger btn-sm\">Delete</button>
                            </td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='7'>No records found for today.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- QR Scanner Script -->
<script>
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

// Attempt to get available cameras
Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
        let selectedCamera = cameras[0];  // Default to the first camera

        // Prioritize back camera if available
        cameras.forEach(function (camera) {
            if (camera.name.toLowerCase().includes('back')) {
                selectedCamera = camera;
            }
        });

        scanner.start(selectedCamera).catch(function (e) {
            console.error("Error starting scanner:", e);
            document.getElementById('scanner-status').textContent = "Error: Unable to start the scanner.";
        });
    } else {
        // No camera found
        document.getElementById('scanner-status').textContent = "Scanner is not available. Please check with the admin.";
    }
}).catch(function (e) {
    console.error("Error accessing cameras:", e);
    document.getElementById('scanner-status').textContent = "Error: Unable to access cameras.";
});

    scanner.addListener('scan', function (content) {
        // Post the scanned content to the same page for logout processing
        fetch('qrlogout.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `qrData=${encodeURIComponent(content)}`,
        })
        .then(response => {
            if (response.ok) {
                window.location.reload(); // Reload the page after successful logout
            } else {
                console.error('Logout failed.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });


    function toggleMenu() {
        document.getElementById("navbarMenu").classList.toggle("show");
    }
    window.onload = function() {
            setTimeout(function() {
                var successAlert = document.getElementById('successAlert');
                if (successAlert) {
                    successAlert.style.opacity = '0';
                    setTimeout(function() {
                        successAlert.remove();
                    }, 500); // Remove alert after fade-out
                }
            }, 3000); // Fade-out after 3 seconds
        };

        function deleteEntry(id) {
    if (confirm("Are you sure you want to delete this entry?")) {
        fetch("qrlogout.php", { // Use the correct PHP script URL
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id=" + id
        })
        .then(response => response.text())
        .then(result => {
            if (result === "success") {
                alert("Entry deleted successfully.");
                location.reload(); // Reload the page to refresh the table
            } else {
                alert("Failed to delete entry.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }
}

</script>

</body>
</html>
