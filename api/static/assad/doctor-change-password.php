<?php include_once('includes/header_start.php');

 include_once('includes/session.php');
    $success_msg="";
    $Error_msg="";
    $id=$_SESSION['login_user'];
    if(!isset($_SESSION['login_user'])){ 
        echo "<script>window.location.href='index.php';</script>";
    
    //  header("location: index.php"); // Redirecting To Home Page 
    }
    if(isset($_POST['submit'])){
       
       
        $password = $_POST['password'];
       
       $login_query=mysqli_query($conn,"UPDATE  doctor SET  password= '$password'  where id='$id' "); 
      
        if($login_query){
            $success_msg="1";
        }
        else{
            $Error_msg="1";
        }  
    }






 ?>

<?php include_once('includes/doctor_header_end.php');










 ?>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">Security</h3>
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

                        <div class="container-fluid">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card m-b-20">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Change password</h4>
                                            <?php
                                                if($Error_msg==1){ echo '
                                                <div class="alert alert-danger">
                                                     <strong>Error!</strong> .
                                                </div>';
                                                 } 
                                            ?>
                                            <?php
                                                if($success_msg==1){ echo '
                                                <div class="alert alert-success">
                                                     <strong>Success!</strong> Updated successfully   .
                                                </div>';
                                                 } 
                                            ?>
            
                                            <form class="" action="" method="post">
                                                
                                                 <div class="form-group">
                                                    <label>passoword</label>
                                                    <div>
                                                        <input type="password" id="pass2" name="password" class="form-control" required
                                                               placeholder="New Password"/>
                                                    </div>
                                                    <div class="m-t-10">
                                                        <input type="password" class="form-control" required
                                                               data-parsley-equalto="#pass2"
                                                               placeholder="Re-Type Password"/>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" name="submit" class="btn btn-primary">
                                                            Submit
                                                        </button>
                                                        <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
            
                               
                            </div> <!-- end row -->
            

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

<?php include_once('includes/footer_start.php'); ?>

        <!-- Parsley js -->
        <script type="text/javascript" src="assets/plugins/parsleyjs/parsley.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('form').parsley();
            });
        </script>

<?php include_once('includes/footer_end.php'); ?>