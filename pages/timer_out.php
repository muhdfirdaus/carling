<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');

$idlist = $_POST['idlist'];
$timestamp = time();


mysqli_query($con,"UPDATE temp_test set time_out = $timestamp where id in($idlist) ")or die(mysqli_error($con));
echo "<script>document.location='timer_result.php?id=$idlist'</script>"; 

























?>