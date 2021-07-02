<?php
 include_once('includes/conn.php');


 $sql=mysqli_query($conn,"SELECT * from parts where id='".$_POST['id']."'");
        $ser_data= mysqli_fetch_assoc($sql);
 
 
 
 $output=(int)$ser_data['fee'];


 echo $output;

?>

