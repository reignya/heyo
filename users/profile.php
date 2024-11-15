<?php
session_start();
include('../DBconnection/dbconnection.php');

// Check if user is logged in
if (empty($_SESSION['vpmsuid'])) {
    header('location:logout.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_SESSION['vpmsuid'];
    $fname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lname = mysqli_real_escape_string($con, $_POST['lastname']);
    $registration_status = mysqli_real_escape_string($con, $_POST['registration_status']);

    $or_image = $cr_image = $nv_image = '';
    $uploadDir = 'uploads/';

    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die('Failed to create directory.');
        }
    }

    // Handle file uploads
    if ($registration_status === 'registered') {
        if (isset($_FILES['OR_image']) && $_FILES['OR_image']['error'] === UPLOAD_ERR_OK) {
            $or_image = basename($_FILES['OR_image']['name']);
            move_uploaded_file($_FILES['OR_image']['tmp_name'], $uploadDir . $or_image);
        }
        if (isset($_FILES['CR_image']) && $_FILES['CR_image']['error'] === UPLOAD_ERR_OK) {
            $cr_image = basename($_FILES['CR_image']['name']);
            move_uploaded_file($_FILES['CR_image']['tmp_name'], $uploadDir . $cr_image);
        }
    } elseif ($registration_status === 'for_registration') {
        if (isset($_FILES['NV_image']) && $_FILES['NV_image']['error'] === UPLOAD_ERR_OK) {
            $nv_image = basename($_FILES['NV_image']['name']);
            move_uploaded_file($_FILES['NV_image']['tmp_name'], $uploadDir . $nv_image);
        }
    }

    $updateQuery = "
        UPDATE tblregusers SET 
        FirstName = '$fname',
        LastName = '$lname',
        registration_status = '$registration_status',
        or_image = IF('$or_image' != '', '$or_image', or_image),
        cr_image = IF('$cr_image' != '', '$cr_image', cr_image),
        nv_image = IF('$nv_image' != '', '$nv_image', nv_image)
        WHERE ID = '$uid'
    ";

    if (mysqli_query($con, $updateQuery)) {
        echo '<script>alert("Profile updated successfully.")</script>';
        echo '<script>window.location.href="profile.php"</script>';
        exit;
    } else {
        echo '<script>alert("Error: ' . mysqli_error($con) . '")</script>';
    }
}

$uid = $_SESSION['vpmsuid'];
$ret = mysqli_query($con, "SELECT * FROM tblregusers WHERE ID='$uid'");
$row = mysqli_fetch_array($ret);
$orImage = !empty($row['or_image']) ? 'uploads/' . htmlspecialchars($row['or_image']) : '';
$crImage = !empty($row['cr_image']) ? 'uploads/' . htmlspecialchars($row['cr_image']) : '';
$nvImage = !empty($row['nv_image']) ? 'uploads/' . htmlspecialchars($row['nv_image']) : '';
$registrationStatus = htmlspecialchars($row['registration_status']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   <style>

#notification {
    position: fixed;
    top: 10px;
    right: 10px;
    background-color: #f8d7da; /* Light red background */
    color: #721c24; /* Dark red text for contrast */
    border: 1px solid #f5c6cb; /* Border color similar to background */
    border-radius: 5px;
    padding: 15px; /* Increased padding for better readability */
    display: none;
    z-index: 9999;
    width: 300px;
    max-width: 90%;
    font-size: 16px; /* Increased font size for better visibility */
}

#notification span {
    display: inline-block;
    vertical-align: middle;
}

#notification button {
    float: right;
    border: none;
    background: none;
    color: #721c24; /* Dark red color for the close button */
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

</style>
</head>
<body>
    <!-- Include sidebar -->
    <?php include_once('includes/sidebar.php'); ?>

    <!-- Notification system -->
   <!-- Notification system -->
<div id="notification">
    <span id="notification-message"><?php if (isset($_GET['notification'])) echo htmlspecialchars($_GET['notification']); ?></span>
    <button id="notification-close">&times;</button>
</div>

</body>
</html>


   <?php include_once('userheader.php');?>

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>My Profile</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="dashboard.php">Dashboard</a></li>
                                    <li><a href="profile.php">Profile</a></li>
                                    <li class="active">User Profile</li>
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
                    <div class="col-lg-6">
                        <div class="card">
                            
                           
                        </div> <!-- .card -->

                    </div><!--/.col-->

              

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>User </strong> Profile
                            </div>
                            <div class="card-body card-block">
                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                   
                                   <?php
$uid=$_SESSION['vpmsuid'];
$ret=mysqli_query($con,"select * from tblregusers where ID='$uid'");
$cnt=1;
while ($row = mysqli_fetch_array($ret)) {
    //echo "User Type from Database: " . $row['user_type']; // Add this line for debugging
    ?>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">First Name</label></div>
                                        <div class="col-12 col-md-9"> <input type="text" name="firstname" required="true" class="form-control" value="<?php  echo $row['FirstName'];?>">
                                            <br></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="email-input" class=" form-control-label">Last Name</label></div>
                                        <div class="col-12 col-md-9"><input type="text" name="lastname" required="true" class="form-control" value="<?php  echo $row['LastName'];?>"></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="password-input" class=" form-control-label">Contact Number</label></div>
                                        <div class="col-12 col-md-9"> <input type="text" name="mobilenumber" maxlength="10" pattern="[0-9]{10}" readonly="true" class="form-control" value="<?php  echo $row['MobileNumber'];?>"></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Email address</label></div>
                                        <div class="col-12 col-md-9"><input type="email" name="email" required="true" class="form-control" value="<?php  echo $row['Email'];?>"  readonly="true"></div>
                                    </div>
                                  
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Registration</label></div>
                                        <div class="col-12 col-md-9"><input type="text" name="regdate" value="<?php  echo $row['RegDate'];?>"  readonly="true" class="form-control"></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">UserType</label></div>
                                        <div class="col-12 col-md-9"><input type="text" name="userType" value="<?php  echo $row['user_type'];?>"  readonly="true" class="form-control"></div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Place</label></div>
                                        <div class="col-12 col-md-9"><input type="text" name="place" value="<?php  echo $row['place'];?>"  readonly="true" class="form-control"></div>
                                    </div>



                                    <div class="row form-group">
    <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">License Number</label></div>
    <div class="col-12 col-md-9"><input type="text" name="LicenseNumber" value="<?php echo $row['LicenseNumber']; ?>" readonly="true" class="form-control"></div>
</form>










<!-- Include Bootstrap CSS (required for styling) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- CSS for Fixed Image Size -->
<style>
    .clickable-image {
        width: 100%;               /* Responsive width */
        height: 300px;              /* Fixed height (similar to Instagram posts) */
        object-fit: cover;          /* Ensures the image scales properly without distortion */
        border-radius: 8px;         /* Optional: Add rounded corners */
        cursor: pointer;            /* Pointer cursor to indicate the image is clickable */
        transition: transform 0.2s; /* Smooth scaling effect on hover */
    }

    .clickable-image:hover {
        transform: scale(1.05);     /* Slight zoom effect on hover */
    }
</style>

<!-- HTML Form -->
<div class="container mt-5">
    <div class="row">
        <?php if ($orImage): ?>
            <div class="col-md-4 mb-4">
                <h4>OR File</h4>
                <img src="<?php echo $orImage; ?>" alt="OR File" 
                     class="img-fluid clickable-image" 
                     data-toggle="modal" data-target="#imageModal" 
                     data-title="OR File">
            </div>
        <?php endif; ?>

        <?php if ($crImage): ?>
            <div class="col-md-4 mb-4">
                <h4>CR File</h4>
                <img src="<?php echo $crImage; ?>" alt="CR File" 
                     class="img-fluid clickable-image" 
                     data-toggle="modal" data-target="#imageModal" 
                     data-title="CR File">
            </div>
        <?php endif; ?>

        <?php if ($nvImage): ?>
            <div class="col-md-4 mb-4">
                <h4>MV File</h4>
                <img src="<?php echo $nvImage; ?>" alt="NV File" 
                     class="img-fluid clickable-image" 
                     data-toggle="modal" data-target="#imageModal" 
                     data-title="NV File">
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript for Modal Image Handling -->
<script>
    $(document).on('click', '.clickable-image', function () {
        var src = $(this).attr('src');
        var title = $(this).data('title');
        $('#modalImage').attr('src', src);
        $('#imageModalTitle').text(title);
    });
</script>
















    <p>Registration Status: <?php echo $registrationStatus; ?></p>













    <!-- Persistent Notification system -->
    <div id="notification" style="display: none;">
        <span id="notification-message">Please upload your files.</span>
        <button id="notification-close">&times;</button>
    </div>

    <form id="upload-form" action="your_upload_handler.php" method="POST" enctype="multipart/form-data">
        <div class="row form-group">
            <div class="col-md-3">
                <label for="registration-status" class="form-control-label">Registration Status</label>
            </div>
            <div class="col-md-9">
                <select id="registration-status" name="registration_status" class="form-control" required>
                    <option value="" disabled selected>Select Registration Status</option>
                    <option value="for_registration" <?php echo $registrationStatus === 'for_registration' ? 'selected' : ''; ?>>For Registration</option>
                    <option value="registered" <?php echo $registrationStatus === 'registered' ? 'selected' : ''; ?>>Registered</option>
                </select>
            </div>
        </div>

        <div class="row form-group" id="for-registration-files" style="display: none;">
            <div class="col-md-3">
                <label for="nv-file" class="form-control-label">Upload MV File</label>
            </div>
            <div class="col-md-9">
                <input type="file" id="nv-file" name="NV_image" accept=".jpeg, .jpg" class="form-control">
            </div>
        </div>

        <div class="row form-group" id="registered-files" style="display: none;">
            <div class="col-md-3">
                <label for="or-file" class="form-control-label">Upload OR File</label>
            </div>
            <div class="col-md-9">
                <input type="file" id="or-file" name="OR_image" accept=".jpeg, .jpg" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="cr-file" class="form-control-label">Upload CR File</label>
            </div>
            <div class="col-md-9">
                <input type="file" id="cr-file" name="CR_image" accept=".jpeg, .jpg" class="form-control">
            </div>
        </div>

        <div class="row form-group">
            <div class="col text-center">
                <button type="submit" id="submit-button" class="btn btn-primary btn-sm">Submit</button>
            </div>
        </div>
    </form>
</div>
<script>
        // Show/hide upload fields based on selected registration status
        document.getElementById('registration-status').addEventListener('change', function() {
            const registeredFiles = document.getElementById('registered-files');
            const forRegistrationFiles = document.getElementById('for-registration-files');

            if (this.value === 'registered') {
                registeredFiles.style.display = 'block';
                forRegistrationFiles.style.display = 'none';
            } else if (this.value === 'for_registration') {
                registeredFiles.style.display = 'none';
                forRegistrationFiles.style.display = 'block';
            } else {
                registeredFiles.style.display = 'none';
                forRegistrationFiles.style.display = 'none';
            }
        });

        // Close notification on click
        document.getElementById('notification-close').addEventListener('click', function() {
            document.getElementById('notification').style.display = 'none';
        });
    </script>

<script>
    function startReminderNotification() {
        var notification = document.getElementById('notification');
        var notificationMessage = document.getElementById('notification-message');
        notification.style.display = 'block';

        // Customize the message or keep it from PHP
        notificationMessage.textContent = notificationMessage.textContent || "Please upload your files.";

        // Toggle visibility every second
        setInterval(function () {
            notification.style.display = notification.style.display === 'none' ? 'block' : 'none';
        }, 1000); // Toggle visibility every second
    }

    function hideNotification() {
        var notification = document.getElementById('notification');
        notification.style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        var orImageUploaded = <?php echo json_encode(!empty($orImage)); ?>;
        var crImageUploaded = <?php echo json_encode(!empty($crImage)); ?>;
        var nvImageUploaded = <?php echo json_encode(!empty($nvImage)); ?>;

        // Show notification only if no files are uploaded
        if (!orImageUploaded && !crImageUploaded && !nvImageUploaded) {
            startReminderNotification();
        }

        // File input elements
        var nvFileInput = document.getElementById('nv-file');
        var orFileInput = document.getElementById('or-file');
        var crFileInput = document.getElementById('cr-file');
        var form = document.getElementById('upload-form');
        var registrationStatus = document.getElementById('registration-status');

        function anyFileUploaded() {
            // Check if any file has been uploaded, including PHP pre-upload checks
            return (
                nvFileInput.files.length > 0 ||
                orFileInput.files.length > 0 &&
                crFileInput.files.length > 0 &&
                orImageUploaded &&
                crImageUploaded ||
                nvImageUploaded
            );
        }

        function checkNotification() {
            if (anyFileUploaded()) {
                hideNotification(); // Hide notification if any file is uploaded
                return true;
            } else {
                startReminderNotification(); // Show notification if no files are uploaded
                return false;
            }
        }

        // Add event listeners to file inputs to check for uploads
        nvFileInput.addEventListener('change', checkNotification);
        orFileInput.addEventListener('change', checkNotification);
        crFileInput.addEventListener('change', checkNotification);

        // Handle registration status change
        registrationStatus.addEventListener('change', function () {
            checkNotification();
        });

        // Prevent form submission if files are missing
        form.addEventListener('submit', function (event) {
            if (!checkNotification()) {
                event.preventDefault();
            }
        });

        // Close button event listener for the notification
        document.getElementById('notification-close').addEventListener('click', function () {
            hideNotification();
        });

        // Initial check and setup on page load
        checkNotification();
    });
</script>




                                    
                                    <?php } ?>
                                   <p style="text-align: center;"> <button type="submit" class="btn btn-primary btn-sm" name="submit" >⏏ Update</button></p>
                                </form>
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="col-lg-6">
                        
                  
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
<script src="../admin/assets/js/main.js"></script>


</body>
</html>
<?php  ?>