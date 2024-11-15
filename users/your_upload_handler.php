<?php
session_start();
include('../DBconnection/dbconnection.php');

// Check if user is logged in
if (empty($_SESSION['vpmsuid'])) {
    header('location:logout.php');
    exit;
}

// Initialize a flag for upload status
$upload_success = true;
$notification = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid = $_SESSION['vpmsuid'];
    $fname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lname = mysqli_real_escape_string($con, $_POST['lastname']);
    $registration_status = mysqli_real_escape_string($con, $_POST['registration_status']);

    // Initialize variables for file names
    $or_image = $cr_image = $nv_image = '';

    // Directory to store uploaded files
    $uploadDir = 'uploads/';

    // Create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) {
            die('Failed to create directory.');
        }
    }

    // Handle file uploads based on registration status
    if ($registration_status === 'registered') {
        if (isset($_FILES['OR_image']) && $_FILES['OR_image']['error'] === UPLOAD_ERR_OK) {
            $or_image = basename($_FILES['OR_image']['name']);
            $or_imagePath = $uploadDir . $or_image;

            // Validate file type and size (example validation)
            $fileType = pathinfo($or_imagePath, PATHINFO_EXTENSION);
            if (in_array($fileType, ['jpeg', 'jpg']) && $_FILES['OR_image']['size'] < 2 * 1024 * 1024) {
                if (!move_uploaded_file($_FILES['OR_image']['tmp_name'], $or_imagePath)) {
                    $upload_success = false;
                }
            } else {
                $upload_success = false;
            }
        }

        if (isset($_FILES['CR_image']) && $_FILES['CR_image']['error'] === UPLOAD_ERR_OK) {
            $cr_image = basename($_FILES['CR_image']['name']);
            $cr_imagePath = $uploadDir . $cr_image;

            // Validate file type and size (example validation)
            $fileType = pathinfo($cr_imagePath, PATHINFO_EXTENSION);
            if (in_array($fileType, ['jpeg', 'jpg']) && $_FILES['CR_image']['size'] < 2 * 1024 * 1024) {
                if (!move_uploaded_file($_FILES['CR_image']['tmp_name'], $cr_imagePath)) {
                    $upload_success = false;
                }
            } else {
                $upload_success = false;
            }
        }
    } elseif ($registration_status === 'for_registration') {
        if (isset($_FILES['NV_image']) && $_FILES['NV_image']['error'] === UPLOAD_ERR_OK) {
            $nv_image = basename($_FILES['NV_image']['name']);
            $nv_imagePath = $uploadDir . $nv_image;

            // Validate file type and size (example validation)
            $fileType = pathinfo($nv_imagePath, PATHINFO_EXTENSION);
            if (in_array($fileType, ['jpeg', 'jpg']) && $_FILES['NV_image']['size'] < 2 * 1024 * 1024) {
                if (!move_uploaded_file($_FILES['NV_image']['tmp_name'], $nv_imagePath)) {
                    $upload_success = false;
                }
            } else {
                $upload_success = false;
            }
        }
    }

    // Prepare SQL update query
    $updateQuery = "
        UPDATE tblregusers SET 
        FirstName = '$fname',
        LastName = '$lname',
        registration_status = '$registration_status',
        or_image = IF('$registration_status' = 'registered' AND '$or_image' != '', '$or_image', or_image),
        cr_image = IF('$registration_status' = 'registered' AND '$cr_image' != '', '$cr_image', cr_image),
        nv_image = IF('$registration_status' = 'for_registration' AND '$nv_image' != '', '$nv_image', nv_image)
        WHERE ID = '$uid'
    ";

    // Enable error reporting for debugging
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
    // Execute query and check for errors
    if (mysqli_query($con, $updateQuery)) {
        // Set notification message
        if ($upload_success) {
            $notification = 'Profile updated successfully.';
        } else {
            $notification = 'Profile updated, but some files were not uploaded successfully.';
        }
    } else {
        $notification = 'Error: ' . mysqli_error($con);
    }

    // Redirect to profile page with notification
    header('Location: profile.php?notification=' . urlencode($notification));
    exit;
}
?>
