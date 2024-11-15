<?php
$con = mysqli_connect("localhost", "root", "", "parkingz");

if (mysqli_connect_errno()) {
    echo "Connection Failed: " . mysqli_connect_error();
    exit(); // Stop execution if the connection fails
} else {
    // Optional: Uncomment for debugging
    // echo "Database connected successfully.";
}
?>
