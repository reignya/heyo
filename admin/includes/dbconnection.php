<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Ensure this is correct; it looks like you're using no password
$dbname = "parkingz";

// Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally set the character set for the connection
mysqli_set_charset($con, "utf8"); // Adjust if necessary

?>
