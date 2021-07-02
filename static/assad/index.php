<?php 
    include_once('includes/header_account.php');
    include_once('includes/conn.php');
    session_start();
    $msg="0";
     if(isset($_POST['submit'])){

        $email = $_POST['email'];
        $pass = $_POST['password'];
        $role= $_POST['role'];
        echo $role;
        if($role==1){
            $login_query=mysqli_query($conn,"Select * from admin where email='$email' and password='$pass' and status=1");  
            $row_count=mysqli_num_rows ( $login_query );

            if($row_count!=0){
                $row=mysqli_fetch_assoc($login_query);  
                $role_id= $row['id'];
                $role = $row['role_id'];
                $_SESSION['login_user'] = $role_id;
        echo "<script>window.location.href='admin-dashboard.php';</script>";

                //header("Location: Admin-Dashboard.php");
            }
            else{
                $msg="1";
            }
        }

        else if ($role==2) {
             $login_query=mysqli_query($conn,"Select * from doctor where email='$email' and password='$pass' and status=1");  
            $row_count=mysqli_num_rows ( $login_query );
            if($row_count!=0){
                $row=mysqli_fetch_assoc($login_query);  
                $role_id= $row['id'];
                $role = $row['role_id'];
                $_SESSION['login_user'] = $role_id;
        echo "<script>window.location.href='doctor-Dashboard.php';</script>";

               // header("Location: doctor-Dashboard.php");
            }
            else{
                $msg="1";
            }
            
        }

        else if ($role==3) {
            $login_query=mysqli_query($conn,"Select * from receptionist where email='$email' and password='$pass' and status=1");  
            $row_count=mysqli_num_rows ( $login_query );
            if($row_count!=0){
                $row=mysqli_fetch_assoc($login_query);  
                $role_id= $row['id'];
                $role = $row['role_id'];
                $_SESSION['login_user'] = $role_id;
        echo "<script>window.location.href='reception-Dashboard.php';</script>";

                //header("Location: reception-Dashboard.php");
            }
            else{
                $msg="1";
            }

        }
        else {
            $msg="1";
        }
    }
 ?>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">

            <div class="card">
                <div class="card-body">

                    <h3 class="text-center m-0">
                        <a href="index.php" class="logo logo-admin"><img src="assets/images/logo_dark.png" height="60" alt="logo"></a>
                    </h3>

                    <div class="p-3">
                        <h4 class="text-muted font-18 m-b-5 text-center">Welcome Back !</h4><br>
                        <?php
                        if($msg==1){ echo '
                            <div class="alert alert-danger">
                                 <strong>Error!</strong> No user found .
                            </div>';
                        } ?>

                        <form class="form-horizontal m-t-30" action="index.php" method="POST">

                            <div class="form-group">
                                <label for="username">Email</label>
                                <input type="text" class="form-control" name="email" id="username" placeholder="Enter Email " required="required"  >
                            </div>

                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control" name="password" id="userpassword" required="required" placeholder="Enter password">
                            </div>
                             <div class="form-group">
                                <label for="userpassword" >Select Role</label>
                                <select name = "role" class="form-control">
                                    <option value="null">Select Here....</option>
                                    <option value= 1> Admin</option>
                                    <option value= 2> Doctor</option>
                                    <option value= 3> Receptionist</option>
                                </select>
                            </div>

                            <div class="form-group row m-t-20">
                                <div class="col-sm-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customControlInline">
                                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button name="submit" class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-12 m-t-20">
                                    <a href="pages-recoverpw.php" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                
                <p>© 2018 Assad Aesthetics. Crafted with <i class="mdi mdi-heart text-danger"></i> by i2c</p>
            </div>

        </div>

<?php include_once('includes/footer_account.php'); ?>