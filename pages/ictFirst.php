<?php

include('../dist/includes/dbcon.php');

$lupdate = "1576730220";

//fetching ICT log
$dir    = 'C:\carling\temp\942-10048';
$files1 = scandir($dir);

foreach($files1 as $file){
    if(strlen($file)>5){
        if(strpos($file, 'default') !== false){
            //Do nothing
        }
        else{
            $full = explode("-",$file);
            $panel = preg_replace('/\s+/', '', $full[0]);
            $res = $full[2][0];

            $fdate = date (filemtime("C:/carling/temp/942-10048/".$file));
            // $lupdate = time();
            set_time_limit(0);
            
            if(isset($data[$panel])){
                if($data[$panel]['d']<$fdate){
                    $data[$panel]['r'] = $res;
                    $data[$panel]['d'] = $fdate;
                }
            }
            else{
                $data[$panel]['p'] = $panel;
                $data[$panel]['r'] = $res;
                $data[$panel]['d'] = $fdate;
            }
            
            
            
        }
    }
}
foreach($data as $newdata){
    $panel = $newdata['p'];
    $res = $newdata['r'];
    $fdate = $newdata['d'];
    mysqli_query($con, "INSERT INTO ict_test (panel, result, fdate, lastupdate) values('$panel','$res','$fdate','$lupdate')")or die(mysqli_error($con));
}

// if($check!=false && $check['fdate']<$fdate){
//     $id = $check['id'];
//     mysqli_query($con, "UPDATE ict_test set fdate='$fdate', result='$res', lastupdate='$lupdate' where id='$id'")or die(mysqli_error($con));
// }
// if($check==false){
//     mysqli_query($con, "INSERT INTO ict_test (panel, result, fdate, lastupdate) values('$panel','$res','$fdate','$lupdate')")or die(mysqli_error($con));
// }
?>