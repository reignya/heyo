<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .left-panelbg {
            font-size:12px;
    }
</style>

<div class="left-panelbg">
    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="dashboard.php"><i class="menu-icon fa fa-dashboard"></i>Dashboard</a>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-list-alt"></i>Vehicle Category
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-road"></i><a href="add-category.php">Add Vehicle Category</a></li>
                            <li><i class="menu-icon fa bi bi-p-square-fill"></i><a href="manage-category.php">Manage Vehicle Category</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="add-vehicle.php"><i class="menu-icon fa fa-user-circle-o"></i>Add Vehicle</a>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-th"></i>Manage Vehicle
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                             <li><i class="menu-icon fa fa-user-circle-o"> <a href="manage-reg.php"></i>Manage Registered Client Vehicles </a></li>
                            <li><i class="menu-icon bi bi-car-front-fill"></i><a href="manage-incomingvehicle.php">Manage In Vehicle</a></li>
                            <li><i class="menu-icon bi bi-car-front"></i><a href="manage-outgoingvehicle.php">Manage Out Vehicle</a></li>
                        </ul>
                    </li>

                 

                    <li>
                        <a href="search-vehicle.php"><i class="menu-icon fa fa-search"></i>Search Vehicle</a>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa fa-newspaper-o"></i>Reports
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-calendar"></i><a href="bwdates-report-ds.php">Between Dates Reports</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="menu-icon fa bi bi-card-checklist"></i>Validation
                        </a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa bi bi-journal-text"></i><a href="validation.php">Validate</a></li>
                            <li><i class="menu-icon fa bi bi-journal-check"></i><a href="validated.php">Validated</a></li>
                            <li><i class="menu-icon fa bi bi-journal-x"></i><a href="unvalidated.php">Unvalidated</a></li>
                            <li><i class="menu-icon fa bi bi-journal-minus"></i><a href="invalidated.php">InValidated</a>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-address-book"></i>Client Management</a>
                        
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="menu-icon fa fa-user-circle-o"></i><a href="register.php">Register Client</a></li>
                                <li><i class="menu-icon fa fa-address-book"></i><a href="reg-users.php">User Information</a></li>
                                <li><i class="menu-icon  fa bi bi-chat-dots-fill"></i><a href="admin_comments.php">Comment</a></li>
                                <li><i class="menu-icon fa  bi bi-envelope-paper-heart"></i><a href="admin_feedbacks.php">Feedback</a></li>
                                <li><i class="menu-icon fa  bi bi-headset"></i><a href="admin_service.php">Customer Service</a></li>
                            </ul>
                    </li>

                    <li>
                        <a href="manage-slot.php"><i class="menu-icon fa  bi bi-geo-fill"></i> Add Area and Slot</a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>
</div>
