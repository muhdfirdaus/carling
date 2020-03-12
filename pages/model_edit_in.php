<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');

$id = $_GET['id'];
$model = $_POST['model'];
$model_name = $_POST['model_name'];
$model_no = $_POST['model_no'];
$model_no2 = $_POST['model_no2'];
$model_cust = $_POST['model_cust'];
$model_ship = $_POST['model_ship'];

mysqli_query($con,"update model_list set model='$model',model_name='$model_name',model_no='$model_no',
model_no2='$model_no2',model_cust='$model_cust',model_ship='$model_ship' where id=$id")or die(mysqli_error($con));
	
echo "<script type='text/javascript'>alert('Successfully updated!');</script>";
echo "<script>document.location='model.php'</script>";  
?>