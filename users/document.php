<?php
include('../DBconnection/dbconnection.php');

$query = "SELECT * FROM parkingz.registration_data"; // Modify this query as needed
$result = mysqli_query($con, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>Registration Status: " . $row['registration_status'] . "</p>";
        if (!empty($row['or_file_path']) && file_exists($row['or_file_path']) && (pathinfo($row['or_file_path'], PATHINFO_EXTENSION) === 'jpg' || pathinfo($row['or_file_path'], PATHINFO_EXTENSION) === 'jpeg' || pathinfo($row['or_file_path'], PATHINFO_EXTENSION) === 'png' || pathinfo($row['or_file_path'], PATHINFO_EXTENSION) === 'gif')) {
            echo "<p>OR Image: <img src='" . $row['or_file_path'] . "' alt='OR Image' style='width: 350px; height: auto;' ></p>";
        }
        if (!empty($row['cr_file_path']) && file_exists($row['cr_file_path']) && (pathinfo($row['cr_file_path'], PATHINFO_EXTENSION) === 'jpg' || pathinfo($row['cr_file_path'], PATHINFO_EXTENSION) === 'jpeg' || pathinfo($row['cr_file_path'], PATHINFO_EXTENSION) === 'png' || pathinfo($row['cr_file_path'], PATHINFO_EXTENSION) === 'gif')) {
            echo "<p>CR Image: <img src='" . $row['cr_file_path'] . "' alt='CR Image' style='width: 350px; height: auto;' ></p>";
        }
        if (!empty($row['nv_file_path']) && file_exists($row['nv_file_path']) && (pathinfo($row['nv_file_path'], PATHINFO_EXTENSION) === 'jpg' || pathinfo($row['nv_file_path'], PATHINFO_EXTENSION) === 'jpeg' || pathinfo($row['nv_file_path'], PATHINFO_EXTENSION) === 'png' || pathinfo($row['nv_file_path'], PATHINFO_EXTENSION) === 'gif')) {
            echo "<p>NV Image: <img src='" . $row['nv_file_path'] . "' alt='NV Image' style='width: 350px; height: auto;' ></p>";
        }
        echo "<hr>";
    }
} else {
    echo "No files uploaded yet.";
}
?>
