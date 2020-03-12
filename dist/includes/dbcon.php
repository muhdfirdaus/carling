<?php
$host = "localhost"; //server
$uname = "root"; //username
$pass = ""; //password
$dbname = "carling"; //db name
$con = mysqli_connect($host,$uname,$pass,$dbname);

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  date_default_timezone_set("Asia/Singapore"); 
?>

