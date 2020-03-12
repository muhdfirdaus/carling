<?php 
session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
	$ip = $_POST['printer_ip'];
	$ip2 = $_POST['printer_ip2'];
	
	
	mysqli_query($con,"update printer_cfg set ip='$ip' where id=1")or die(mysqli_error($con));
	mysqli_query($con,"update printer_cfg set ip='$ip2' where id=2")or die(mysqli_error($con));
	
	echo "<script type='text/javascript'>alert('Printer IP updated!');</script>";
	echo "<script>window.history.back();</script>";  
?>
