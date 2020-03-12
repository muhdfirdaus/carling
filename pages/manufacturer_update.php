<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
	$id = $_POST['id'];
	$manufacturer =$_POST['manufacturer'];
	
	
	mysqli_query($con,"update manufacturer set manufacturer_name='$manufacturer' where manufacturer_id='$id'")or die(mysqli_error());
	
	echo "<script type='text/javascript'>alert('Successfully updated manufacturer!');</script>";
	echo "<script>document.location='manufacturer.php'</script>";  

	
?>
