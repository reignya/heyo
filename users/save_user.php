<?php
session_start();

// Include the database connection file
require_once '../DBconnection/dbconnection.php'; // Adjust the path if necessary

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the email was verified
    if (!isset($_SESSION['verification_code']) || !isset($_SESSION['verification_email'])) {
        echo json_encode(['success' => false, 'message' => 'Email verification required.']);
        exit();
    }

    // Get the verified email
    $email = $_SESSION['verification_email'];

    // Retrieve other form fields
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $contno = $_POST['mobilenumber'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the password
    $userType = $_POST['userType'];
    $place = $_POST['place'];
    $LicenseNumber = $_POST['LicenseNumber'];

    // Check if the email or mobile number already exists in the database
    $stmt = mysqli_prepare($conn, "SELECT Email FROM tblregusers WHERE Email=? OR MobileNumber=?");
    mysqli_stmt_bind_param($stmt, "ss", $email, $contno);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo json_encode(['success' => false, 'message' => 'This email or contact number is already registered.']);
        mysqli_stmt_close($stmt);
        exit();
    }

    // Close the select statement
    mysqli_stmt_close($stmt);

    // Prepare the SQL query to insert user data into the tblregusers table
    $stmt = $conn->prepare(
        "INSERT INTO tblregusers (FirstName, LastName, MobileNumber, Email, Password, user_type, place, LicenseNumber) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    // Bind the parameters
    $stmt->bind_param("ssssssss", $fname, $lname, $contno, $email, $password, $userType, $place, $LicenseNumber);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registration successful!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save user: ' . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
}
?>
