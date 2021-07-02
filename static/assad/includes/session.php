

<?php
include_once('conn.php');// mysqli_connect() function opens a new connection to the MySQL server. 
session_start();// Starting Session 
// Storing Session 
$user_check = $_SESSION['login_user']; 
//$user_role=$_SESSION['role_id']; 
// SQL Query To Fetch Complete Information Of User 
// $query = "SELECT * from user where id = '$user_check'"; 
// $ses_sql = mysqli_query($conn, $query); 
// $row = mysqli_fetch_assoc($ses_sql); 
// $login_session = $row['id'];
// //$login_role = $row['role_id'];
?>