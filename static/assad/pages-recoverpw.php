<?php 
    include_once('includes/header_account.php');
    include_once('includes/conn.php');
    $msg=0;
    
    if(isset($_POST['submit'])){
    
        $to= $_POST['email'];
        $subject="Assad Aesthetics Password Recovery";
        $query=mysqli_query($conn,"SELECT * from admin where email='$to' "); 
        $user_row_count=mysqli_num_rows ( $query );
        $a_null=mysqli_num_rows ( $query );
        if($user_row_count!=0){
            $row=mysqli_fetch_assoc($query);  
            $email_message="Your Password is : " .$row['password'];
            @mail($to, $subject, $email_message,"From: infot@assadaesthetics.com");    
            $msg=1;
            echo $email_message;
        }

        $query=mysqli_query($conn,"SELECT * from doctor where email='$to' "); 
        $user_row_count=mysqli_num_rows ( $query );
        $d_null=mysqli_num_rows ( $query );
        
        if($user_row_count!=0){

            $row=mysqli_fetch_assoc($query);  
            $email_message="Your Password is : " .$row['password'];
            echo $email_message;
            @mail($to, $subject, $email_message,"From: infot@assadaesthetics.com");    
            $msg=1;
        }

        $query=mysqli_query($conn,"SELECT * from receptionist where email='$to' "); 
        $user_row_count=mysqli_num_rows ( $query );
        $r_null=mysqli_num_rows ( $query );
        if($user_row_count!=0){
            $row=mysqli_fetch_assoc($query);  
            $email_message="Your Password is : " .$row['password'];
            @mail($to, $subject, $email_message,"From: infot@assadaesthetics.com");    
            $msg=1;
            echo $email_message;
        }

        if($a_null==0 && $d_null==0 && $r_null==0 ){
            $msg=2;
        }

 

    }






 ?>

        <!-- Begin page -->
        <div class="accountbg"></div>
        <div class="wrapper-page">

            <div class="card">
                <div class="card-body">

                   
                    <div class="p-3">
                        <h4 class="text-muted font-18 mb-3 text-center">Reset Password</h4>
                       
                       
                        <?php 
                        if($msg==0){
                        ?>
                         <div class="alert alert-info" role="alert">
                            Enter your Email and instructions will be sent to you!
                        </div>
                        <?php
                        }
                        ?>

                        <?php 
                        if($msg==1){
                        ?>
                         <div class="alert alert-success" role="alert">
                            Email Sent Successfully !
                        <?php
                        }
                        ?>


                        <?php 
                        if($msg==2){
                        ?>
                         <div class="alert alert-danger" role="alert">
                           Error! User not found...
                        <?php
                        }
                        ?>

                        <form class="form-horizontal m-t-30" action="" method="POST">

                            <div class="form-group">
                                <label for="useremail">Email</label>
                                <input type="email" class="form-control" id="useremail" name="email" required="required" placeholder="Enter email">
                            </div>

                            <div class="form-group row m-t-20">
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light"  name="submit" type="submit">Reset</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center">
                 <div class="m-t-40 text-center">
                
                <p>© 2018 Assad Aesthetics. Crafted with <i class="mdi mdi-heart text-danger"></i> by i2c</p>
            </div>

            </div>

        </div>

<?php include_once('includes/footer_account.php'); ?>