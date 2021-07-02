<?php 
    include_once('includes/header_start.php'); 
    include_once('includes/session.php');
   
    if(!isset($_SESSION['login_user'])){ 
       
        echo "<script>window.location.href='index.php';</script>";
     
     // header("location: index.php"); // Redirecting To Home Page 
    }

   
    $doctor=mysqli_query($conn,"SELECT * From doctor"); 
    $doctor=mysqli_num_rows($doctor);
    
    $reception=mysqli_query($conn,"SELECT * From receptionist"); 
    $receptionist= mysqli_num_rows($reception);
    
    $patient=mysqli_query($conn,"SELECT * From patient");
     $patient=mysqli_num_rows($patient);


    // $active_tenant=mysqli_query($conn,"SELECT * From tenant where owner_id='$user_id' AND active_status= 1");
    //  $atenant=mysqli_num_rows($active_tenant);







?>

            <!--Morris Chart CSS -->
            <link rel="stylesheet" href="assets/plugins/morris/morris.css">

<?php include_once('includes/admin_header_end.php'); 









?>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">Admin Dashboard</h3>
                                </li>
                            </ul>

                            <div class="clearfix"></div>
                        </nav>

                    </div>
                    <!-- Top Bar End -->

                    <!-- ==================
                         PAGE CONTENT START
                         ================== -->

                    <div class="page-content-wrapper">
                        <h1 style="text-align: center;color: green;"> Welcome Back! </h1>
                        <br>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-info"><?php echo $doctor;?></h3>
                                            Total Doctors
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-purple"><?php echo $receptionist;?></h3>
                                            Total Receptionists
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-primary"><?php echo $patient;?></h3>
                                            Total Patients
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                            <h3 class="text-danger"><?php echo $atenant;?></h3>
                                            Active Tenants
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <!-- end row -->
            
                         </div>
            

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

<?php include_once('includes/footer_start.php'); ?>

        <!--Morris Chart-->
        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>

        <script src="assets/pages/dashboard.js"></script>

<?php include_once('includes/footer_end.php'); ?>