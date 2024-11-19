<?php
session_start();
if($_SESSION['isLoggedIn']==true){
    header("Location: dashboard.php");
    // echo "$_SESSION['isLoggedIn']";
}else{
    header("Location: ../LoginFiles/login.html");
    // echo "session value not set";
}
?>