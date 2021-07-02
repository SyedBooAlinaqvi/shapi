<?php include_once('includes/header_start.php');


 include_once('includes/session.php');
    $success_msg="";
    $Error_msg="";
   
    if(!isset($_SESSION['login_user'])){ 
        echo "<script>window.location.href='index.php';</script>";
    
    //  header("location: index.php"); // Redirecting To Home Page 
    }

    //get code
    if(isset($_GET['id'] )){
     $patient_id=$_GET['id'] ;
    } else {
        echo "<script>window.location.href='index.php';</script>";
        
     //header('Location:index.php');
    }

      $user=$_SESSION['login_user'];
      

      $doctors=mysqli_query($conn,"SELECT * From appointment where pt_id='$patient_id' AND dr_id='$user' ");

      $patient= mysqli_query($conn,"SELECT * From patient where id= '$patient_id' ");
      $p_data = mysqli_fetch_assoc($patient);
      



















 ?>

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<?php include_once('includes/doctor_header_end.php'); ?>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">Patient Tables</h3>
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
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Patient Record</h4>
                                            
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                     <th style="text-align: center">#</th>
                                                     <th style="text-align: center">Pt Name</th>    
                                                     <th style="text-align: center">Date</th>
                                                     <th style="text-align: center">Doctor  </th>
                                                     <th style="text-align: center">Serivce</th>
                                                     <th style="text-align: center">Before Image</th>
                                                     <th style="text-align: center">After Image</th>
                                                     <th style="text-align: center">Fee</th>
                                                    

                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                 <?php 
                                                    $index=1; while ( $app_fetch = mysqli_fetch_assoc($doctors) ) {
                                                    $pt_id=$app_fetch['id'];
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                        echo $index;
                                                        $index=$index + 1;
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                        echo $p_data['name'];
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                        echo $app_fetch['appointment_date'];
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                            $doc_id=$app_fetch['dr_id'];
                                                            $doc_query= mysqli_query($conn,"SELECT * From doctor where id= '$doc_id' ");
                                                            $row_data = mysqli_fetch_assoc($doc_query);
                                                            echo $row_data['name'];
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php 
                                                            $ser_id=$app_fetch['service_id'];
                                                            $ser_query= mysqli_query($conn,"SELECT * From services where id= '$ser_id' ");
                                                            $ser_data = mysqli_fetch_assoc($ser_query);
                                                            echo $ser_data['name'];
                                                    
                                                        ?>
                                                    </td>
                                                     <td style="text-align: center;">
                                                         <?php 
                                                            if($app_fetch['before_pic']==null){ 
                                                            ?>
                                                                <a  class="fa fa-edit" href="doctor-add-before-pic.php?id= <?php echo $pt_id;?>">  Enter Image</a>
                                                            <?php }                                                               
                                                            
                                                        ?>

                                                         <a href="http://localhost/a/assad/upload/<?php echo $app_fetch['before_pic'] ?>" target="_blank">
                                                            <img  class=".rounded-circle" src="upload/<?php echo $app_fetch['before_pic'] ?>" alt="" border=3 height=100 width=100></img> 
                                                        </a>
                                                        
                                                            
                                                    </td>
                                                    
                                                     <td style="text-align: center;">
                                                         <?php 
                                                            if($app_fetch['after_pic']==null){ 
                                                            ?>
                                                                <a  class="fa fa-edit" href="doctor-add-after-pic.php?id= <?php echo $pt_id;?>">  Enter Image</a>
                                                            <?php }                                                               
                                                            
                                                        ?>
                                                            <a href="http://localhost/a/assad/upload/<?php echo $app_fetch['after_pic'] ?>" target="_blank">
                                                             <img  class=".rounded-circle" src="upload/<?php echo $app_fetch['after_pic'] ?>" alt="" border=3 height=100 width=100></img> 
                                                         </a>
                                                        
                                                            
                                                    </td>
                                                    <td style="text-align: center;">
                                                         <?php 
                                                            
                                                            echo $app_fetch['fee'];
                                                        ?>
                                                    </td>
                                                    

                                                </tr>
                                                <?php
                                                    }
                                                ?>                                                
                                                </tbody>
                                            </table>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
            

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

<?php include_once('includes/footer_start.php'); ?>

        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>

<?php include_once('includes/footer_end.php'); ?>