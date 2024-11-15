<style>
 #header{
        background-image: linear-gradient(to top, #1e3c72 0%, #1e3c72 1%, #2a5298 100%);
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, 
            rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, 
            rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
    }
    .nav-link:hover{
        background-image: transparent;
        border-radius: 4px;
        box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
       
    }
    #hh{
        box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
        font: 20px;
        font-weight: bold;
           }
        .user-avatar{
            height: 35px;
            width: 27px;
        }
</style>
<div id="right-panel" class="right-panel">
<header id="header" class="header">
            <div class="top-left">
            <div class="navbar-header" style="background-image: linear-gradient(to top, #1e3c72 0%, #1e3c72 1%, #2a5298 100%);">
                    <a class="navbar-brand" href="dashboard.php"><img src="images/clientlogo.png" alt="Logo" style=" width: 120px; height: auto;"></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        
                        <div class="form-inline">
                           
                        </div>

                     
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="../admin/images/images.png" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu" id="hh">
                            <a class="nav-link" href="profile.php"><i class="fa fa-user" > My Profile
                            </i></a>

                            <a class="nav-link" href="change-password.php"><i class="fa fa-cog"> Change Password
                            </i></a>

                            <a class="nav-link" href="logout.php"><i class="fa fa-power-off"> Logout
                            </i></a>
                        </div>
                    </div>

                </div>
            </div>
        </header>