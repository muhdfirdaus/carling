<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
$limit = $_POST['limit'];
$id = $_SESSION['id'];


$incompleteData = 0;
for($i=1; $i<=$limit; $i++){
    
    $sn=trim($_POST['sn'.$i], " ");
    $result=trim($_POST['result'.$i], " ");

    if(strlen($sn)<=1)
    {    
        $incompleteData+=1;
    }
}

if($incompleteData == 0){
    for($i=1; $i<=$limit; $i++){
        $sn=trim($_POST['sn'.$i], " ");
        $result=trim($_POST['result'.$i], " ");
        $panel = $id."MP$sn";
        $tmstmp = time();

        mysqli_query($con,"INSERT INTO sn_panel(sn,panel_no,lastUpdate)VALUES('$sn','$panel','$tmstmp')")or die(mysqli_error($con));
        mysqli_query($con,"INSERT INTO ict_test(panel,result,lastUpdate)VALUES('$panel','$result','$tmstmp')")or die(mysqli_error($con));
    }
    echo "<script type='text/javascript'>alert('Data saved!');</script>";
    echo "<script type='text/javascript'>document.location='ictmanual.php'</script>";
}
else{
    echo "<script type='text/javascript'>alert('Please fill all column!');</script>";
    echo "<script>window.history.back();</script>"; 
}





