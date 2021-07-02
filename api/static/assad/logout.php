<?php

session_start(); 
//$currentDateTime = date('Y-m-d H:i:s');
   // echo $currentDateTime;

// $query="UPDATE login_history SET logout_time= $currentDateTime inner join users on login_history.user_id = users.id   where email=$_SESSION['login_user']  ";


session_destroy();

        echo "<script>window.location.href='index.php';</script>";




?>