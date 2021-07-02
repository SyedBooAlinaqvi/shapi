<?php include_once('includes/header_start.php');

 include_once('includes/session.php');
    $success_msg="";
    $Error_msg="";
    //echo $_SESSION['login_user']."et";
    if(!isset($_SESSION['login_user'])){ 
        echo "<script>window.location.href='index.php';</script>";
    
    //  header("location: index.php"); // Redirecting To Home Page 
    }
    if(isset($_POST['submit'])){
       
        $name = $_POST['name'];
        $email= $_POST['email'];
        $password = $_POST['password'];
        $contact= $_POST['contact'];
        $age=$_POST['age'];
        $address= $_POST['address'];
        //echo $password;
        $login_query=mysqli_query($conn,"INSERT INTO receptionist (name, email,password,contact, age, address)
        VALUES ('$name', '$email', '$password','$contact','$age' ,'$address')"); 
        if($login_query){
            $success_msg="1";
        }
        else{
            $Error_msg="1";
        }  
    }






 ?>

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
                                    <h3 class="page-title">Add Receptionist</h3>
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
            
                                            <h4 class="mt-0 header-title">Reception Data Form</h4>
                                            <?php
                                                if($Error_msg==1){ echo '
                                                <div class="alert alert-danger">
                                                     <strong>Error!</strong> User Already exists .
                                                </div>';
                                                 } 
                                            ?>
                                            <?php
                                                if($success_msg==1){ echo '
                                                <div class="alert alert-success">
                                                     <strong>Success!</strong> User added successfully   .
                                                </div>';
                                                 } 
                                            ?>
            
                                            <form class="" action="" method="post">
                                                <div class="form-group">
                                                    <label>Name</label>
                                                    <input type="text" class="form-control" name="name" required  placeholder="Enter Name"/>
                                                </div>
            
                                               
                                                <div class="form-group">
                                                    <label>E-Mail</label>
                                                    <div>
                                                        <input type="email" class="form-control" required
                                                               parsley-type="email" name="email" placeholder="Enter a valid e-mail"/>
                                                    </div>
                                                </div>
                                                 <div class="form-group">
                                                    <label>passoword</label>
                                                    <div>
                                                        <input type="password" id="pass2" name="password" class="form-control" required
                                                               placeholder="Password"/>
                                                    </div>
                                                    <div class="m-t-10">
                                                        <input type="password" class="form-control" required
                                                               data-parsley-equalto="#pass2"
                                                               placeholder="Re-Type Password"/>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <label>Phone Number</label>
                                                    <div>
                                                        <input data-parsley-type="number"  name="contact" type="ph"
                                                               class="form-control" required
                                                               placeholder="Enter Phone number"/>
                                                    </div>
                                                </div>
                                                  <div class="form-group">
                                                    <label>Age </label>
                                                    <div>
                                                        <input data-parsley-type="number" name="age" type="number"
                                                               class="form-control" required
                                                               placeholder="Enter Age"/>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <div>
                                                        <textarea required class="form-control" name="address" rows="5"></textarea>
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