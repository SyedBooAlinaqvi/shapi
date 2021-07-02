<?php 
    include_once('includes/header_start.php');

    include_once('includes/session.php');
    $success_msg="";
    $Error_msg="";
    $id=$_SESSION['login_user'];

    if(isset($_GET['id'] )){
     $rec_id=$_GET['id'] ;
    } else {
        //echo "<script>window.location.href='index.php';</script>";
     
     //header('Location:index.php');
    }


    if(!isset($_SESSION['login_user'])){ 
        //echo "<script>window.location.href='index.php';</script>";

      //header("location: index.php"); // Redirecting To Home Page 
    }







    if(isset($_POST['submit'])){
        $name       = $_FILES['file']['name'];  
        $temp_name  = $_FILES['file']['tmp_name'];  
        if(isset($name)){
            if(!empty($name)){      
                $location = 'upload/';      
                if(move_uploaded_file($temp_name, $location.$name)){
                    $login_query=mysqli_query($conn,"UPDATE  appointment SET after_pic = '$name' where id = '$rec_id' "); 
                    if($login_query){
                        $success_msg=1;
                    }
                    

                }
            }       
        } 
     else {
      $Error_msg=1;
    }
       
      
       }

   
 

    
    



 ?>

<?php include_once('includes/doctor_header_end.php'); ?>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">After Treatment Picture</h3>
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
            
                                            <h4 class="mt-0 header-title"> After Treatment Picture </h4>
                                            <?php
                                                if($Error_msg==1){ echo '
                                                <div class="alert alert-danger">
                                                     <strong>Error!</strong> Service Already exists .
                                                </div>';
                                                 } 
                                            ?>
                                            <?php
                                                if($success_msg==1){ echo '
                                                <div class="alert alert-success">
                                                     <strong>Success!</strong>  added successfully   .
                                                </div>';
                                                 } 
                                            ?>
                                              
                                            
            
                                            <form class="" action="" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label></label>
                                                     <input type='file' name='file' />
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