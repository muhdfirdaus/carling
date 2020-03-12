<?php 

include('../dist/includes/dbcon.php');
include('product_cfg.php');


$files = glob("C:\carling\ict\*");//open all file 


foreach($files as $file) {
    $line = file($file);//file in to an array
    $fn =  basename($file);
    $full = explode("-",$fn);
    $sn = preg_replace('/\s+/', '', $full[0]);
    $res = $full[2][0];
    $fdate = date (filemtime($file));
    echo "SN - $full[0] // $sn | Result - $res  Time - $fdate<br>";

    $query=mysqli_query($con,"select count(*)as cnt, fdate  from ict_test where sn='$sn'")or die(mysqli_error($con));
    $row=mysqli_fetch_array($query);

    if($row['cnt']==0){
        
        mysqli_query($con, "INSERT INTO ict_test (sn, result, fdate) values('$sn','$res','$fdate')")or die(mysqli_error($con));
    }
    elseif($row['cnt']!=0 && $row['fdate']<$fdate){
        
        mysqli_query($con, "UPDATE ict_test set fdate='$fdate', result='$res' where sn='$sn'")or die(mysqli_error($con));
    }
    
}

?>