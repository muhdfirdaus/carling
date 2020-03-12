<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');

$model = $_POST['model'];
$qty = $_POST['qty'];
$wo = $_POST['wo'];
$lot = date('md');
$rev = $_POST['rev'];
$rev_no = $_POST['rev_no'];
$userid = $_SESSION['id'];
$tmstmp = time();

//getting next box id
$query=mysqli_query($con,"select box_id from box_master order by id desc limit 1")or die(mysqli_error($con));
$row=mysqli_fetch_array($query);
$box_id=$row['box_id'];
$currdate = date('Ymd');
$lastdate =substr($box_id,0,8);

if($lastdate==$currdate){
    $lastrn = substr($box_id,10,4);      
    $next_box_id = $lastdate."04" . str_pad(($lastrn +1), 4, '0', STR_PAD_LEFT);
}
else{
    $next_box_id = $currdate."040001";
}


if($model!='null'){
    $sql = "INSERT INTO box_master (model, qty, user_id, timestamp, box_id, lot, wo,rev, rev_no)
        VALUES ('$model', '$qty', '$userid', '$tmstmp', '$next_box_id', '$lot', '$wo', '$rev', '$rev_no')";

    if (mysqli_query($con, $sql)) {
        
        $last_id = mysqli_insert_id($con);
        echo "<script type='text/javascript'>alert('Data Saved!');</script>";
        echo "<script>document.location='box_scan.php?id=$last_id'</script>"; 
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}
else{
    echo '<script type="text/javascript">alert("Please select model!");</script>';
    echo "<script>window.history.back();</script>"; 
}

?>