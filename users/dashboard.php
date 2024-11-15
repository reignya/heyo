<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
include('../DBconnection/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['vpmsuid']==0)) {
  header('location:logout.php');
  } else{ 
    
    $uid = $_SESSION['vpmsuid'];

    // Fetch user information and validity status using email to join the uploads table
    $userQuery = mysqli_query($con, "SELECT u.*, up.validity AS upload_validity, up.expiration_date FROM tblregusers u LEFT JOIN uploads up ON u.email = up.email WHERE u.ID='$uid'");

    if (!$userQuery) {
        die("Error in query: " . mysqli_error($con)); // Add error handling for debugging
    }

    $userData = mysqli_fetch_array($userQuery);

    // Debug: Check if user data is fetched successfully
    if (!$userData) {
        die("Error fetching user data: " . mysqli_error($con));
    }

    // Get the expiration date
    $currentDate = date('Y-m-d');
    $expirationDate = $userData['expiration_date'];

    // Check if expiration date is valid
    $expirationTimestamp = $expirationDate ? strtotime($expirationDate) : null; // Check if expiration_date is not null
    $currentTimestamp = strtotime($currentDate);

    // Determine validity status
    $regValidityStatus = $userData['validity']; // Validity from tblregusers
    $uploadValidityStatus = $userData['upload_validity']; // Validity from uploads table
    $licenseStatusMessage = "";

    // Check if the license is expired and set the notification message
    if ($regValidityStatus == 0) {
        // Validity is 0 means the license is invalid
        $licenseStatusMessage = "Your driver's license is expired. Please renew it.";
    } elseif ($regValidityStatus == -2) {
        // User is unvalidated, do not show license messages
        $licenseStatusMessage = ""; // Explicitly set to empty for clarity
    } elseif ($uploadValidityStatus == 0) {
        // Check validity in uploads for invalidated clients
        $licenseStatusMessage = "Your driver's license is expired. Please renew it.";
    } elseif ($uploadValidityStatus == -2) {
        // Unvalidated users do not receive notifications
        $licenseStatusMessage = ""; // Explicitly set to empty for clarity
    } elseif ($expirationTimestamp && $expirationTimestamp < $currentTimestamp && $expirationTimestamp >= strtotime("-3 months", $currentTimestamp)) {
        // License expired but within 3 months grace period
        $licenseStatusMessage = "Your driver's license has expired. You have 3 months to renew it before your account is voided.";
    }

    // Sanitize user data for output
    $firstName = isset($userData['FirstName']) ? htmlspecialchars($userData['FirstName'], ENT_QUOTES, 'UTF-8') : 'User';
    $lastName = isset($userData['LastName']) ? htmlspecialchars($userData['LastName'], ENT_QUOTES, 'UTF-8') : '';

    ?>


<!doctype html>

 <html class="no-js" lang="">
<head>
    
    <title>Client Dashboard | CTU DANAO Parking System</title>
   
<link rel="apple-touch-icon" href="https://upload.wikimedia.org/wikipedia/commons/9/9a/CTU_new_logo.png">
<link rel="shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/9/9a/CTU_new_logo.png">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
<link rel="stylesheet" href="../admin/assets/css/cs-skin-elastic.css">
<link rel="stylesheet" href="../admin/assets/css/style.css">
<link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />
<link rel="stylesheet" href="path-to-your-pe-icon-styles.css">
<link rel="stylesheet" href="park.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet" type="text/css">

    <style>
        body{
            overflow-x: auto;
            font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif
        }
        /* Carousel container and styling */
        .carousel-container {
            width: 75%;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        }

        .carousel {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel img {
            width: 100%;
            height: 100%;
        }

        /* Progress bar styling */
        .progress-bar {
            width: 100%;
            height: 5px;
            background-color: orange;
            margin-top: 7px;
            position: relative;
        }

        /* Slide number indicator */
        .slide-number {
            position: absolute;
            top: -25px;
            right: 0;
            background-color: blue;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            opacity: 0.8;
        }

        .scrollable-images {
            margin-top: 20px;
            overflow-y: auto;
            align-items: center;
        }

        .scrollable-images img {
            border-radius: 20px;
            width: 99%;
            height: 500px;
            margin: 5px;
            border: 1px solid #ddd;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        }
        .section-divider {
            border-top: 10px groove; 
            margin: 20px 0; 
        }
        h4{
            text-align:center;
            font-weight: bold;
        }
        h2{
            text-align: center;
            text-shadow: #FC0 1px 0 10px;
            font-weight: bold;
        }
        p {
            font-size: 16px;         
            line-height: 1.6;        
            color: #333;              
            padding: 0;                
            text-align: justify;       
            font-family: Arial, sans-serif;  
            margin-left: 20px;
        }
            /* Card-specific styles */
        .notification {
            max-width: 300px;
            height: auto;
            padding: 4px;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            color: #333;
            z-index: 1005;
            position: absolute;
            border-radius: 9px;
            text-align: center;
            margin-top: -10px;
            color: green;
            font-weight: bold;
            position: absolute;
        }
            .content{
                background-color: transparent;
                margin-top: -30px;
            }
            #notificationCard {
                opacity: 1;
                transition: opacity 0.5s ease-in-out;
                padding: 5px;
                margin-left: 35em;
                max-width: 1000px;
                width: auto;
                height: auto;
                border: none;
                }
    </style>
</head>

<body>
    <?php include_once('includes/sidebar.php'); ?>
    <?php include_once('includes/header.php'); ?>
    <?php include_once('includes/userheader.php'); ?>
    <?php if ($licenseStatusMessage): ?>
                            <div class="notification"><?php echo $licenseStatusMessage; ?></div>
                        <?php endif; ?>
        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <div class="row">
                    <div class="col-lg-1">
                            <div class="card-body " id="notificationCard">
                                <h2>Welcome! <?php echo $firstName; $lastName;?> <?php echo $lastName; ?></h2>
                        </div>
                    </div>
                </div>
                <!-- /Widgets -->
            </div>
            <!-- .animated -->
        </div>

        <!-- Notification card with disappearing effect -->
        <?php if ($regValidityStatus == 0): ?>
            <div  class="notification" style="margin-left: 25em; position: absolute;">
                <?php echo $licenseStatusMessage; ?>
            </div>
        <?php endif; ?>

    <div class="carousel-container"style="margin-top: -70px;">
        <div class="carousel">
            <img src="images/tem.png" alt="Slide 1">
            <img src="images/temp.png" alt="Slide 2">
            <img src="images/tempo.png" alt="Slide 3">
            <img src="images/tempor.png" alt="Slide 4">
            <img src="images/tempora.png" alt="Slide 5">
        </div>
        <!-- Progress bar with slide number -->
        <div class="progress-bar">
            <div class="slide-number">1 / 5</div> 
        </div>
    </div>

    <div class="scrollable-images">
    <h2> PROPOSED PARKING AREAS</h2>
    <p> This is the proposed open parking space to be approved by Dr. Rosemary Almacen-CTU Danao Campus Director. The source of this parking areas is the </p>
    <img src="images/allArea.png" alt="Image 6">

    <hr class="section-divider"> 

    <h4> Area A</h4>
    <p> This is the proposed open parking space to be approved by Dr. Rosemary Almacen-CTU Danao Campus Director. The source of this parking areas is the </p>
    <img src="images/areaA.png" alt="Image 7">
    <hr class="section-divider"> 

    <h4> Area B</h4>
    <p> This is the proposed open parking space to be approved by Dr. Rosemary Almacen-CTU Danao Campus Director. The source of this parking areas is the </p>
    <img src="images/areaB.png" alt="Image 8">

    <hr class="section-divider"> 

    <h4> Area C</h4>
    <p> This is the proposed open parking space to be approved by Dr. Rosemary Almacen-CTU Danao Campus Director. The source of this parking areas is the </p>
    <img src="images/areaC.png" alt="Image 9">

    <hr class="section-divider"> 

    <h4> Area D</h4>
    <p> This is the proposed open parking space to be approved by Dr. Rosemary Almacen-CTU Danao Campus Director. The source of this parking areas is the </p>
    <img src="images/areaD.png" alt="Image 10">
</div>


    <div class="clearfix"></div>
<!-- Footer -->


<!-- /#right-panel -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../admin/assets/js/main.js"></script>
<script src="../admin/assets/js/main.js"></script>

<script>
const carousel = document.querySelector('.carousel');
const carouselContainer = document.querySelector('.carousel-container');
const images = document.querySelectorAll('.carousel img');
const progressBar = document.querySelector('.progress-bar');
const slideNumber = document.querySelector('.slide-number');
const intervalTime = 5000; 
let index = 0;
let intervalId; 

function startSlideshow() {
    intervalId = setInterval(() => {
        index++;
        if (index >= images.length) {
            index = 0; 
        }

        carousel.style.transform = `translateX(-${index * 100}%)`;

        const progress = ((index + 1) / images.length) * 100;
        progressBar.style.width = `${progress}%`;

        slideNumber.textContent = `${index + 1} / ${images.length}`;
    }, intervalTime);
}

function pauseSlideshow() {
    clearInterval(intervalId);
}

startSlideshow();

carouselContainer.addEventListener('mouseenter', pauseSlideshow);
carouselContainer.addEventListener('mouseleave', startSlideshow);

// Hide and remove the notification card after 10 seconds
setTimeout(function() {
    var notificationCard = document.getElementById('notificationCard');
    if (notificationCard) {
        notificationCard.style.transition = 'opacity 0.5s'; // Add transition effect
        notificationCard.style.opacity = '0'; // Fade out the card

        // After the fade-out effect, remove the element from the DOM
        setTimeout(function() {
            notificationCard.remove(); // Remove the card element
        }, 500); // Wait for the fade-out effect before removing
    }
}, 10000); // 10 seconds in milliseconds


</script>
<script>
    </script>
</body>
</html>
<?php } ?>