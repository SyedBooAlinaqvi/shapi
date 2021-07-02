
<?php
    
    include_once('includes/session.php');
    //get code
    if(isset($_GET['id'] )){
     $doc_id=$_GET['id'] ;
    } else {
        echo "<script>window.location.href='index.php';</script>";
    
    // header('Location:index.php');
    }

    //session code
    if(!isset($_SESSION['login_user'])){ 
        echo "<script>window.location.href='index.php';</script>";
       
     // header("location: index.php"); // Redirecting To Home Page 
    }

    

    $del= mysqli_query($conn,"DELETE  from doctor  WHERE id ='$doc_id'");
    $del=  mysqli_query($conn,"DELETE  from services  WHERE dr_id ='$doc_id'");
    
    if ($del_query) {
        echo "<script>window.location.href='admin-view-doctor.php';</script>";

      //header('Location: admin-view-doctor.php');
    }
    else{
        echo "<script>window.location.href='admin-view-doctor.php';</script>";

      // header('Location:admin-view-doctor.php');  
    }

 ?>
