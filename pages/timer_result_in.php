<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
$user_id = $_SESSION['id'];

foreach($_POST['sn_id'] as $id){

    $res = $_POST['result'][$id];
    mysqli_query($con,"UPDATE temp_test_sn set result = '$res' where id = $id ")or die(mysqli_error($con));
        
}

foreach($_POST['id'] as $id){

    mysqli_query($con,"UPDATE temp_test set status = 1 where id = $id ")or die(mysqli_error($con));
        
}


echo "<script type='text/javascript'>alert('Data Saved!');</script>";
echo "<script>document.location='temperature_test.php'</script>"; 






















?>