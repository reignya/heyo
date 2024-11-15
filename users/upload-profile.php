<?php
session_start();
include('../DBconnection/dbconnection.php');

if (isset($_POST['login'])) {
    $emailOrMobile = $_POST['emailcont'];
    $password = $_POST['password'];

    $condition = filter_var($emailOrMobile, FILTER_VALIDATE_EMAIL) 
                 ? "Email='$emailOrMobile'" 
                 : "MobileNumber='$emailOrMobile'";

    $query = mysqli_query($con, "SELECT ID, FirstName, LastName, MobileNumber, Password, QRCode FROM tblregusers WHERE $condition");
    $row = mysqli_fetch_assoc($query);

    if ($row && password_verify($password, $row['Password'])) {
        $_SESSION['vpmsuid'] = $row['ID'];
        $_SESSION['vpmsumn'] = $row['MobileNumber'];
        header('location:dashboard.php');
        exit();
    } else {
        echo "<script>alert('Invalid Details.');</script>";
    }
}

if (isset($_POST['upload'])) {
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] == 0) {
        $uploadsDir = '../uploads/profile_uploads/';
        $fileName = basename($_FILES['profilePic']['name']);
        $targetFilePath = $uploadsDir . $fileName;

        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $targetFilePath)) {
            $userId = $_SESSION['vpmsuid'];
            $query = mysqli_query($con, "UPDATE tblregusers SET profile_pictures='$fileName' WHERE ID='$userId'");

            if ($query) {
                echo "<script>alert('Profile picture uploaded successfully.');</script>";
            } else {
                echo "<script>alert('Database update failed.');</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }
    } else {
        echo "<script>alert('File upload failed.');</script>";
    }
}
?>

<!-- Link to external JavaScript -->
<script src="js/upload-profile.js"></script>

<style>
    /* Your existing CSS styles */
    #header {
        background-image: linear-gradient(to top, #1e3c72 0%, #1e3c72 1%, #2a5298 100%);
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, 
                    rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, 
                    rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    }
    .nav-link:hover {
        border-radius: 4px;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    }
    #hh {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        font: 20px;
        font-weight: bold;
    }
    .user-avatar {
        height: 35px;
        width: 27px;
    }
</style>

<div id="right-panel" class="right-panel">
    <header id="header" class="header">
        <div class="top-left">
            <div class="navbar-header" style="background-image: linear-gradient(to top, #1e3c72 0%, #1e3c72 1%, #2a5298 100%);">
                <a class="navbar-brand" href="dashboard.php"><img src="images/clienthc.png" alt="Logo" style="width: 120px; height: auto;"></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">
                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="user-avatar rounded-circle" src="../admin/images/images.png" alt="User Avatar">
                    </a>
                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="profile.php"><i class="fa fa-user"></i> My Profile</a>
                        <a class="nav-link" href="change-password.php"><i class="fa fa-cog"></i> Change Password</a>
                        <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>

                        <!-- Profile picture upload form -->
                        <form action="upload-profile.php" method="POST" enctype="multipart/form-data" style="padding: 10px;">
                            <label for="profilePic">Upload Profile Picture:</label>
                            <input type="file" name="profilePic" id="profilePic" accept="image/*" class="form-control">
                            <button type="submit" name="upload" class="btn btn-primary mt-2">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>
