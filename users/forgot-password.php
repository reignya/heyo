<?php
session_start();
error_reporting(0);
include('../DBconnection/dbconnection.php');

if(isset($_POST['submit']))
  {
    $contactno=$_POST['contactno'];
    $email=$_POST['email'];

        $query=mysqli_query($con,"select ID from tblregusers where  Email='$email' and MobileNumber='$contactno' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
      $_SESSION['contactno']=$contactno;
      $_SESSION['email']=$email;
     header('location:reset-password.php');
    }
    else{
  
      echo "<script>alert('Invalid Details. Please try again.');</script>";
    }
  }
  ?>
<!doctype html>
 <html class="no-js" lang="">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="apple-touch-icon" href="images/ctu.png">
<link rel="shortcut icon" href="images/ctu.png">
    <link rel="apple-touch-icon" href="https://upload.wikimedia.org/wikipedia/commons/9/9a/CTU_new_logo.png">
    <link rel="shortcut icon" href="https://upload.wikimedia.org/wikipedia/commons/9/9a/CTU_new_logo.png">

    <title>CTU Danao Parking Management System-Forgot Page</title>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Poppins:400,500&display=swap');
  
    body{
      background: url('images/ctuser.png');
      height: 100vh;
      background-size: cover;
      background-position: center;
    }
    .bg-dark:after{
      z-index:-5;
      position: absolute;
      content: '';
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: rgba(0,0,0,0.7);
    }
    #content {
      background-color:#ff9933;
      border-radius: 20px;
      position: absolute;
      top: 45%;
      left: 50%;
      z-index: 999;
      text-align: center;
      padding: 60px 32px;
      width: 370px;
      transform: translate(-50%, -50%);
    }

    #content:hover {
      opacity: 1;      
      box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, 
      rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, 
      rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    }
    
    .btn{       
      background-color: rgb(53, 97, 255);        
      color: white;
      border: solid ;
        cursor:pointer;
        font-weight:bold;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        border-radius: 10px;
    }
    .btn:hover{
      background-color: darkblue;
      border: solid blue;
    }

    h2{
        color: black;
    }
    .pull-right{
        color:white;
        font-weight: bold;
        text-decoration: underline;
    }
    .pull-right:hover{
        color: blue;
        text-decoration: underline;
    }
    #x{
      margin-top:-2em;
      margin-left: 9em;
      color: white;
      font-weight: bold;
      text-shadow: 0px 6px 10px rgb(62, 57, 57);
      position: absolute;
    }
    #x:hover{
      color: red;
      text-decoration: none;
    }
    .field{
      position: relative;
      height: 45px;
      width: 100%;
      display: flex;
      background: rgba(255,255,255,0.94);
      border-radius: 10px;
    }
    .field span{
      color: black;
      width: 40px;
      line-height: 45px;
    }
    .field input{
      height: 100%;
      width: 100%;
      background: transparent;
      border: none;
      outline: none;
      color: #222;
      font-size: 16px;
      font-family: 'Poppins',sans-serif;
    }
    input[type="text"]:hover,
    input[type="password"]:hover {
        background-color: aliceblue;
        border: 2px solid orange;
    }
    .space{
      margin-top: 30px;
    }

        /* Responsive adjustments */
@media (max-width: 768px) {
    #content {
        width: 80%; /* Adjust width for smaller screens */
        padding: 40px 24px; /* Reduce padding */
        border-radius: 15px; /* Adjust border-radius */
    }
}

@media (max-width: 500px) {
    #content {
        width: 80%; /* Further reduce width for very small screens */
        padding: 30px 20px; /* Further reduce padding */
        border-radius: 10px; /* Adjust border-radius for a smaller look */
        height: 400px;
    }
    #x{
      margin-left: 7.5em;
      margin-top: -1.2em;
      position: absolute;
    }
    .space{
      margin-top: 35px;
    }
}
    
    </style>

  </head>
<body class="bg-dark">

            <div class="login-content" id="content">
            <div>
               <a href="login.php" id="x">
               <i class="fa-solid fa fa-xmark"></i></a>
                    <a class="space"style="text-decoration:none; font-family: 'Montserrat', sans-serif;">
                         <h2 style="color: white; " >F O R G O T PASSWORD</h2>
                    </a>
                </div>
                <div >
                    <form method="post">
                         
                  <div class="field space">
                      <span class="fa fa-user"></span>
                      <input type="text" class="form-control" name="email" placeholder="Email" autofocus required="true">
                  </div>
                  <div class="field space">
                      <span class="fa bi bi-telephone-fill"></span>
                            <input type="text" class="form-control" name="contactno" placeholder="Mobile Number" required="true">
                  </div>
                        <div class="checkbox">
                            
                            <label class="pull-right space">
                                <a href="login.php" style="color: white;">Signin</a>
                            </label><br>

                        </div>
                        <button type="submit" name="submit" class="pull-left space btn btn-success btn-flat m-b-30 m-t-30"><i class="fa fa-refresh"> Reset</i></button>
                       
                       
                    </form>
                </div>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../admin/assets/js/main.js"></script>

</body>
</html>