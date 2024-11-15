<?php
session_start();
include('../DBconnection/dbconnection.php');

// Check if the user has registered a fingerprint
$userId = $_SESSION['vpmsaid'] ?? null; // Assuming you can retrieve the user ID some other way

if (!$userId) {
    // Redirect to register page if user is not logged in
    header('Location: register-fingerprint.php');
    exit();
}

// Check if the user has a registered fingerprint
$result = mysqli_query($con, "SELECT * FROM user_fingerprints WHERE user_id = '$userId'");
if (mysqli_num_rows($result) == 0) {
    // If no fingerprint is found, redirect to register-fingerprint.php
    header('Location: register-fingerprint.php');
    exit();
}

// Here you would implement the logic to handle fingerprint login
// For example, verifying the fingerprint
// If the fingerprint verification is successful, log the user in:
$_SESSION['vpmsaid'] = $userId; // Log the user in
header('Location: dashboard.php'); // Redirect to dashboard
exit();
?>
