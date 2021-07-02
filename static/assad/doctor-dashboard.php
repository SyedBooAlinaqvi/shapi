<?php include_once('includes/header_start.php'); 
include_once('includes/session.php');
   
    if(!isset($_SESSION['login_user'])){ 
        
        echo "<script>window.location.href='index.php';</script>";
       
     // header("location: index.php"); // Redirecting To Home Page 
    }

   $id=$_SESSION['login_user'];

    $services=mysqli_query($conn,"SELECT * From services where dr_id='$id' "); 
    $services=mysqli_num_rows($services);
    
    // $reception=mysqli_query($conn,"SELECT * From receptionist"); 
    // $receptionist= mysqli_num_rows($reception);
    
    // $patient=mysqli_query($conn,"SELECT * From patient");
    //  $patient=mysqli_num_rows($patient);
?>
            <!--Morris Chart CSS -->
            <link rel="stylesheet" href="assets/plugins/morris/morris.css">

<?php include_once('includes/doctor_header_end.php'); ?>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">Doctor Dashboard</h3>
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

                        <div class="header-bg"> 
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 mb-4 pt-5">
                                        
                
                                       
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">
                                           <h3 class="text-info"><?php echo $services;?></h3>
                                            Services
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">

                                           <h3 class="text-info" id="datetime"></h3>
										   Date
                                            <script>
                                            var dt = new Date();
                                            document.getElementById("datetime").innerHTML = dt.toLocaleDateString();
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-3">
                                    <div class="card text-center m-b-30">
                                        <div class="mb-2 card-body text-muted">

                                            <h3 class="text-info" id="time"></h3>
											
											Time
                                                <script>										
                                                var dt = new Date();
                                                document.getElementById("time").innerHTML = dt.toLocaleTimeString();
                                                </script>                        
                                      </div>
                                    </div>
                                </div>
                                 
                                
                            </div>
                            <!-- end row -->
            
                            
                          
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