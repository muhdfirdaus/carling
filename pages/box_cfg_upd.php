<?php 
session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
include('product_cfg.php');
	$model = $_POST['model'];
	$qty =$_POST['qty'];
	
	
	mysqli_query($con,"update box_config set model='$model',qty='$qty' where id=1")or die(mysqli_error($con));
	
	echo "<script type='text/javascript'>alert('Successfully update box configurations!');</script>";
	echo "<script>document.location='box_cfg.php'</script>";  
?>
