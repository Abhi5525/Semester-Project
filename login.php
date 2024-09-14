<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movie_booking";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
$email=$_POST['email'];
$pw=$_POST['password'];
$sql="SELECT * FROM users WHERE email = '$email' AND password='$pw'";
$result=mysqli_query($conn,$sql);
  
if(mysqli_num_rows($result)==1){
  header("Location:dashboard.php");
  }else{
  
  echo "<script>alert('Incorrect username or password. Please try again.'); window.location.href='login.php';</script>";
  }
mysqli_close($conn);
?>