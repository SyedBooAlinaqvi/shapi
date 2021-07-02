
<?php
    
    include_once('includes/session.php');
    //get code
    if(isset($_GET['id'] )){
     $rec_id=$_GET['id'] ;
    } else {
        echo "<script>window.location.href='index.php';</script>";

     //header('Location: index.php');
    }

    //session code
    if(!isset($_SESSION['login_user'])){ 
        echo "<script>window.location.href='index.php';</script>";
       
     // header("location: index.php"); // Redirecting To Home Page 
    }

    

    $del= mysqli_query($conn,"DELETE  from receptionist  WHERE id ='$rec_id'");
    
    if ($del_query) {
       echo "<script>window.location.href='admin-view-reception.php';</script>";
        
      //header('Location: admin-view-reception.php');
    }
    else{
       echo "<script>window.location.href='admin-view-reception.php';</script>";
        
      // header('Location: admin-view-reception.php');  
    }

 ?>
