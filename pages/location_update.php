<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
	$id = $_POST['id'];
	$location =$_POST['location'];
	
	
	mysqli_query($con,"update location set location_name='$location' where location_id='$id'")or die(mysqli_error());
	
	echo "<script type='text/javascript'>alert('Successfully updated location!');</script>";
	echo "<script>document.location='location.php'</script>";  

	
?>
