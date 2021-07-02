<?php 
    include_once('includes/header_start.php');
    include_once('includes/session.php');
    require('pdf/fpdf.php');
    $success_msg="";
    $Error_msg="";
    //echo $_SESSION['login_user']."et";
    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $todayDate = $year . '-' . $month . '-' .$day ;
    if(!isset($_SESSION['login_user'])){     
        echo "<script>window.location.href='index.php';</script>";
      
      //header("location: index.php"); // Redirecting To Home Page 
    }
    $user_id=$_SESSION['login_user'];
    $doc=0;
    if(isset($_POST['submit'])){
        $doc=$_POST['doc'];
    }

    if(isset($_POST['submitt'])){
        $doc=$_POST['doc'];
        $pt_id=$_POST['mri'];
        $ser_id=$_POST['ser'];
        $date=$_POST['appdate'];
        $fee=$_POST['fee'];
        //Queries
        $patient_data=mysqli_query($conn,"SELECT * From patient where id= '$pt_id' ");
        $doctor_data=mysqli_query($conn,"SELECT * From doctor where id= '$doc' ");
        $service_data=mysqli_query($conn,"SELECT * From services where id= '$ser_id' ");
        //Row count
        $row_count=mysqli_num_rows($patient_data);
        if($row_count>0){
        //book appointment query
        $login_query=mysqli_query($conn,"INSERT INTO appointment (dr_id, service_id,pt_id, r_id, appointment_date,fee)
         VALUES ('$doc', '$ser_id', '$pt_id', '$user_id' ,'$date','$fee')"); 
        // // data Queries
        $pt_data= mysqli_fetch_assoc($patient_data);
        $doc_data= mysqli_fetch_assoc($doctor_data);
        $ser_data= mysqli_fetch_assoc($service_data);
        //patient Info
        $pt_name=$pt_data['name'];
        $pt_age=$pt_data['age'];
        $pt_gender=$pt_data['gender'];
        $pt_contact=$pt_data['contact'];
        $pt_visits=$pt_data['visits'];
        $pt_visits=$pt_visits+1;
        $login_query=mysqli_query($conn,"UPDATE  patient SET visits = '$pt_visits' where id= '$pt_id' "); 
        //doctor info
        $doc_name=$doc_data['name'];
        //sevice Info
        $ser_name=$ser_data['name'];
        //url wth parameters
        $success_msg=1;
       // header("Location: http://localhost/a/assad/t.php?MRI=".$pt_id."&name=".$pt_name."&age= ".$pt_age ."&gender= ".$pt_gender."&contact=".$pt_contact."&visits=".$pt_visits." &doctor=".$doc_name." &service=".$ser_name." ");
        
        echo "<script>window.location.href='t.php?MRI=".$pt_id."&name=".$pt_name."&age= ".$pt_age ."&gender= ".$pt_gender."&contact=".$pt_contact."&visits=".$pt_visits." &doctor=".$doc_name." &service=".$ser_name."';</script>";

        }
        else {
            $Error_msg=1;
        }
    }
 ?>    
<?php include_once('includes/header_end.php');?>




                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title"> Patient Appointment</h3>
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
            
                                            <h4 class="mt-0 header-title"></h4>
                                           
            
                                            <form class="" action="" method="post">
                                               
                                                <div class="form-group">
                                                            <label for="Doctor">
                                                               Select  Doctor 
                                                            </label>
                                                            <select name="doc" class="form-control"  required="required">
                                                                <option value="">Select Doctor</option>
                                                                    <?php 
                                                                        $doctors=mysqli_query($conn,"SELECT * From doctor ");
                                                                        while($d_name=mysqli_fetch_array($doctors))
                                                                        {
                                                                    ?>
                                                                <option value="<?php echo $d_name['id'] ;?>">
                                                                    <?php echo $d_name['name'];?>
                                                                </option>
                                                                <?php } ?>
                                                                
                                                            </select>
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
                                  <div class="col-lg-6">
                                    <div class="card m-b-20">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title"></h4>
                                            <?php
                                                if($Error_msg==1){ echo '
                                                <div class="alert alert-danger">
                                                     <strong>Error!</strong> Patient Not Found .
                                                </div>';
                                                 } 
                                            ?>
                                            <?php
                                                if($success_msg==1){ echo '
                                                <div class="alert alert-success">
                                                     <strong>Success!</strong> patient added successfully   .
                                                </div>';
                                                 } 
                                            ?>
            
                                            <form class="" action="" method="post">
                                               <div class="form-group">
                                                    <label>Patient MRI</label>
                                                    <div>
                                                        <input type="number" class="form-control" required
                                                               parsley-type="number" name="mri" placeholder="Enter a patient MRI"/>
                                                    </div>
                                                </div>
                                               
                                                  <div class="form-group">
                                                            <label for="Doctor">
                                                               Select  Doctor 
                                                            </label>
                                                            <select name="doc" class="form-control"   required="required">
                                                               
                                                                    <?php 
                                                                        $doctors=mysqli_query($conn,"SELECT * From doctor  where id='$doc' ");
                                                                        while($d_name=mysqli_fetch_array($doctors))
                                                                        {
                                                                    ?>
                                                                <option value="<?php echo $d_name['id'] ;?>">
                                                                    <?php echo $d_name['name'];?>
                                                                </option>
                                                                <?php } ?>
                                                                
                                                            </select>
                                                </div>       
                                                <div class="form-group">
                                                            <label for="Doctor">
                                                               Select  Service 
                                                            </label>
                                                            <select name="ser" class="form-control"  id="ser" required="required">
                                                                <option value="">Select Service</option>
                                                                    <?php 
                                                                        $doctors=mysqli_query($conn,"SELECT * From services where dr_id='$doc' ");
                                                                        while($d_name=mysqli_fetch_array($doctors))
                                                                        {
                                                                    ?>
                                                                <option value="<?php echo $d_name['id'] ;?>">
                                                                    <?php echo $d_name['name'];?>
                                                                </option>
                                                                <?php } ?>
                                                                
                                                            </select>
                                                </div>

            
                                               
                                                <div class="form-group">
                                                    <label>Date</label>
                                                    <div>
                                                        <input type="date" class="form-control" required
                                                               parsley-type="number" name="appdate" value="<?php echo $todayDate; ?>" placeholder="Enter a patient age"/>
                                                    </div>
                                                </div>
                                                
            
                                                <div class="form-group">
                                                    <label>Fee</label>
                                                    <div>
                                                        <input data-parsley-type="number"  name="fee" id="fee" type="text"
                                                               class="form-control" required value="" 
                                                               placeholder=""/>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" name="submitt" class="btn btn-primary">
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

<script > 
     

        $("#ser").change(function(){
            // alert();

        
            var service_id=$(this).val();
            $.ajax({
                url:"get_doctor.php",
                method:"POST",
                data:{serviceId:service_id},
                dataType:"text",
                success:function(data)
                {  console.log(data);
                    $('#fee').val(data);
                }

            });
        });
  
 </script>





<?php include_once('includes/footer_end.php'); ?>