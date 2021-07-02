<?php 
    include_once('includes/header_start.php');
     include_once('includes/session.php');
    if(!isset($_SESSION['login_user'])){ 
        echo "<script>window.location.href='index.php';</script>";
      
      //header("location: index.php");  
    }

    $month = date('m');
    $day = date('d');
    $year = date('Y');
    $today = $year. '-' . $month . '-' . $day;
     
   $data=mysqli_query($conn,"SELECT * from appointment where
            (appointment_date BETWEEN '$today'AND '$today') 
            "); 
   $dataa=mysqli_query($conn,"SELECT * from appointment where
            (appointment_date BETWEEN '$today'AND '$today') 
            "); 
    $t_income=0;
        while ( $row = mysqli_fetch_assoc($dataa) ) {

         $t_income=$t_income+$row['fee'];
        }

     if(isset($_POST['submit'])){
      
        $from = $_POST['from'];
        $to= $_POST['to'];
       
      
        $data=mysqli_query($conn,"SELECT * from appointment where
            (appointment_date BETWEEN '$from'AND '$to') 
            "); 

        $dataa=mysqli_query($conn,"SELECT * from appointment where
            (appointment_date BETWEEN '$from'AND '$to') 
            "); 

        $t_income=0;
        while ( $row = mysqli_fetch_assoc($dataa) ) {

         $t_income=$t_income+$row['fee'];
        }

        
       
    }


  










 ?>

        <!-- DataTables -->
        <link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<?php include_once('includes/admin_header_end.php'); ?>

                            <!-- Page title -->
                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="ion-navicon"></i>
                                    </button>
                                </li>
                                <li class="hide-phone list-inline-item app-search">
                                    <h3 class="page-title">Sales Tables</h3>
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
            
                                            <h4 class="mt-0 header-title">Enter Date</h4>
                                          
            
                                            <form class="" action="" method="post">
                                                
                                                 <div class="   ">
                                                    <label>From</label>
                                                    <div>
                                                        <input type="Date" id="pass2" name="from" class="form-control" required
                                                               Value="<?php echo $today; ?>" />
                                                    </div>

                                    
                                                </div>
                                                <div class="form-group">
                                                    <label>To</label>
                                                    <div>
                                                        <input type="Date" id="pass2" name="to" class="form-control" required
                                                               value="<?php echo $today; ?>" />
                                                    </div>

                                    
                                                </div>
                                                 <div class="form-group">
                                                    <label>Total Income</label>
                                                    <div>
                                                        <input type="number" id="pass2" name="income" class="form-control" 
                                                               disabled="disabled" value="<?php echo $t_income; ?>" />
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
                            </div>                   
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Sales Report</h4>
                                            
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                     <th style="text-align: center">#</th>
                                                    <th style="text-align: center">Pt Name</th>
                                                     <th style="text-align: center">Pt Contcat</th>
                                                     <th style="text-align: center">Date</th>
                                                     <th style="text-align: center">Doctor  </th>
                                                     <th style="text-align: center">Serivce</th>
                                                     <th style="text-align: center">Fee</th>
                                                    
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                <?php 
                                                    $index=1; 
                                                    
                                                    while ( $row = mysqli_fetch_assoc($data) ) {
                                                    $doc_id=$row['id'];
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
                                                             $pt_id=$row['pt_id'];
                                                             $patient=mysqli_query($conn,"SELECT * From patient where id='$pt_id' ");
                                                             $pt = mysqli_fetch_assoc($patient);
                                                             echo $pt['name'];

                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                       <?php
                                                             echo $pt['contact'];

                                                        ?>  
                                                    </td>
                                                    <td style="text-align: center;">
                                                       <?php
                                                             echo $row['appointment_date'];

                                                        ?>  
                                                    </td>
                                                    <td style="text-align: center;">
                                                         <?php
                                                            $d=$row['dr_id'];
                                                             $doc=mysqli_query($conn,"SELECT * From doctor where id='$d' ");
                                                             $dr = mysqli_fetch_assoc($doc);
                                                             echo $dr['name'];

                                                        ?>

                                                    </td>
                                                    <td style="text-align: center;"> 
                                                        <?php
                                                             $s=$row['service_id'];
                                                             $ser=mysqli_query($conn,"SELECT * From services where id='$s' ");
                                                             $dr = mysqli_fetch_assoc($ser);
                                                             echo $dr['name'];

                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                            
                                                             echo $row['fee'];
                                                            
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