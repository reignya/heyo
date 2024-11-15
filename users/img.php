<?php
session_start();
include('includes/dbconnection.php');

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrationStatus = isset($_POST['registrationStatus']) ? $_POST['registrationStatus'] : '';
    $targetDirectory = "uploads/";

    // Get the user ID from the session (replace 'user_id' with your actual session variable)
    $userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

    function handleFileUpload($fileInputName) {
        global $targetDirectory;
        $fileFullName = $_FILES[$fileInputName]['name'];
        $fileTempName = $_FILES[$fileInputName]['tmp_name'];
        $fileFinalPath = $targetDirectory . $fileFullName;

        if (move_uploaded_file($fileTempName, $fileFinalPath)) {
            return $fileFullName;
        }
        return null;
    }

    $orFileName = '';
    $crFileName = '';
    $nvFileName = '';

    if ($registrationStatus === 'registered') {
        $orFileName = handleFileUpload('orFile');
        $crFileName = handleFileUpload('crFile');
    } elseif ($registrationStatus === 'forRegistration') {
        $nvFileName = handleFileUpload('nvFile');
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "parkingz";

    $con = mysqli_connect($servername, $username, $password, $dbname);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if ($con) {
        if (($orFileName !== null && $crFileName !== null) || $nvFileName !== null) {
            $insertQuery = "INSERT INTO parkingz.registration_data (registration_status, or_file_name, or_file_path, cr_file_name, cr_file_path, nv_file_name, nv_file_path, user_id) VALUES ('$registrationStatus', '$orFileName', '$targetDirectory$orFileName', '$crFileName', '$targetDirectory$crFileName', '$nvFileName', '$targetDirectory$nvFileName', '$userID')";

            if (mysqli_query($con, $insertQuery)) {
                mysqli_close($con);
                header("Location: http://localhost/parkingz/profile.php");
                exit();
            } else {
                $message = "Error inserting data into database: " . mysqli_error($con);
            }
        } else {
            $message = "Error uploading files.";
        }
    } else {
        $message = "Error connecting to the database.";
    }
}
?>



    <div id="page2">
        <form id="uploadForm" form action="profile.php"method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Registration Status</label>
                <select id="registrationStatus" name="registrationStatus">
                    <option value="" selected disabled>Select Registration Status</option>
                    <option value="registered">Registered</option>
                    <option value="forRegistration">For Registration</option>
                </select>
            </div>

            <div class="form-group file-upload" id="orGroup" style="display: none;">
                <label>OR (Official Receipt)</label>
                <input type="file" name="orFile" required>
            </div>

            <div class="form-group file-upload" id="crGroup" style="display: none;">
                <label>CR (Certificate of Registration)</label>
                <input type="file" name="crFile" required>
            </div>

            <div class="form-group file-upload" id="nvGroup" style="display: none;">
                <label>NV (Other Required Document)</label>
                <input type="file" name="nvFile" required>
            </div>

            <button type="button" id="submitButton">Submit</button>
        </form>
    </div>

    <script>
        document.getElementById('registrationStatus').addEventListener('change', function() {
            var orGroup = document.getElementById('orGroup');
            var crGroup = document.getElementById('crGroup');
            var nvGroup = document.getElementById('nvGroup');

            orGroup.style.display = 'none';
            crGroup.style.display = 'none';
            nvGroup.style.display = 'none';

            var selectedValue = this.value;
            if (selectedValue === 'registered') {
                orGroup.style.display = 'block';
                crGroup.style.display = 'block';
            } else if (selectedValue === 'forRegistration') {
                nvGroup.style.display = 'block';
            }
        });

        document.getElementById('submitButton').addEventListener('click', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>
</body>
</html>
