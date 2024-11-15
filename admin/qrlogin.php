<?php session_start(); ?>
<html class="no-js" lang="">
<head>
    <script type="text/javascript" src="js/adapter.min.js"></script>
    <script type="text/javascript" src="js/vue.min.js"></script>
    <script type="text/javascript" src="js/instascan.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="apple-touch-icon" href="images/ctu.png">
    <link rel="shortcut icon" href="images/ctu.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">



    <title>QR Code Login Scanner | CTU DANAO Parking System</title>
</head>
<body>

<!-- Left Panel -->

<?php include_once('includes/sidebar.php');?>

<!-- Left Panel -->

<!-- Right Panel -->

 <?php include_once('includes/header.php');?>

 <style>
                body{
                    color: black;
                    background-color: whitesmoke;
                    height: 100vh;
                    overflow: hidden;
                }
                .no-js{background-color:whitesmoke;
                }
                .table-bordered{
                    border-radius: 9px;
                    box-shadow: rgba(9, 30, 66, 0.25) 0px 1px 7px, rgba(9, 30, 66, 0.13) 0px 0px 1px 1px;
                }
            </style>

    <div class="container" style="background: transparent;">
        <div class="row" style="background: transparent;">
            <div class="col-md-6" style="top: 30px; background-color:transparent;">
                <video id="preview" width="100%"></video>
                <?php
                if(isset($_SESSION['error'])){
                    echo "
                    <div class='alert alert-danger'>
                        <h4>Error!</h4>
                        ".$_SESSION['error']."
                    </div>
                    ";
                }

                if(isset($_SESSION['success'])){
                    echo "
                    <div class='alert alert-primary'>
                        <h4>Success!</h4>
                        ".$_SESSION['success']."
                    </div>
                    ";
                }
                ?>
            </div>
    
            <div class="col-md-6" style="top: 30px; background-color: transparent;">
                <form action="insert1.php" method="post" class="form-horiz">
                <label style="font-weight: bold; color: orange; font-size: 20px">SCAN QR CODE <i class="fas fa-qrcode"></i></label>
                    <input type="text" name="text" id="text" readonly placeholder="scan qrcode" class="form-control" style="background: white;">
                </form>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>STUDENT ID</td>
                            <td>TIMEIN</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $server = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "parking";

                        $conn = new mysqli($server, $username, $password, $dbname);

                        if($conn->connect_error){
                            die("Connection failed" .$conn->connect_error);
                        }
                        $sql ="SELECT ID,STUDENTID,TIMEIN FROM table_attendance WHERE DATE(TIMEIN)=CURDATE()";
                        $query = $conn->query($sql);
                        while ($row = $query->fetch_assoc()){
                            ?>
                            <tr>
                                <td><?php echo $row['ID'];?></td>
                                <td><?php echo $row['STUDENTID'];?></td>
                                <td><?php echo $row['TIMEIN'];?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        Instascan.Camera.getCameras().then(function(cameras){
            if(cameras.length > 0 ){
                scanner.start(cameras[0]);
            } else {
                alert('No cameras found');
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c){
            document.getElementById('text').value = c;
            document.forms[0].submit();
        });
    </script>
</body>
</html>
