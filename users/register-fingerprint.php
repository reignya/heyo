<?php
session_start();
include('../DBconnection/dbconnection.php');

// Check if the user is logged in
if (!isset($_SESSION['vpmsaid'])) {
    header('Location: login.php');
    exit();
}

// Handle the fingerprint registration process here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assume the fingerprint data is sent via POST
    $fingerprintData = $_POST['fingerprint_data']; // Replace with actual data handling

    // Store the fingerprint in the database (you need to implement this)
    $userId = $_SESSION['vpmsaid'];
    $query = "INSERT INTO user_fingerprints (user_id, fingerprint_data) VALUES ('$userId', '$fingerprintData')";
    if (mysqli_query($con, $query)) {
        echo "Fingerprint registered successfully.";
        header('Location: dashboard.php'); // Automatically redirect to dashboard after registration
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Fingerprint</title>
</head>
<body>
    <h2>Register Fingerprint</h2>
    <form method="POST" action="">
        <input type="hidden" name="fingerprint_data" value="..."> <!-- Replace with actual fingerprint data -->
        <button type="submit">Register Fingerprint</button>
    </form>
</body>
</html>
