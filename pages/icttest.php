<?php 

include('../dist/includes/dbcon.php');

$query=mysqli_query($con,"select lastupdate from ict_test order by lastupdate desc limit 1")or die(mysqli_error($con));
$row=mysqli_fetch_array($query);
$lupdICT=$row['lastupdate'];
// $lupdICT = 1600620271;

$query=mysqli_query($con,"select lastupdate from sn_panel order by lastupdate desc limit 1")or die(mysqli_error($con));
$row=mysqli_fetch_array($query);
$lupdPanel=$row['lastupdate'];
// $lupdPanel = 1600361433;


// ***********************************  Fetching ICT Log  **************************************************************
$dir    = 'C:\carling\ict';
$files1 = scandir($dir);

foreach($files1 as $file){
    if(date (filemtime("C:/carling/ict/".$file))>$lupdICT){
    // if((filemtime("C:/carling/ict/".$file))){    
        if(strlen($file)>5){
            if(strpos($file, 'default') !== false){
                //Do nothing
            }
            else{
                $full = explode("-",$file);
                $panel = preg_replace('/\s+/', '', $full[0]);
                $res = $full[2][0];

                $fdate = date (filemtime("C:/carling/ict/".$file));
                
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
}

if(isset($data)){
    
    foreach($data as $newdata){

        $lupdate = time();
        $panel = $newdata['p'];
        $res = $newdata['r'];
        $fdate = $newdata['d'];

        $query=mysqli_query($con,"select fdate from ict_test where panel='$panel'")or die(mysqli_error($con));
        $row=mysqli_fetch_array($query);

        if(count($row)>0){
            if($row['fdate']<$fdate){
                mysqli_query($con, "UPDATE ict_test set fdate='$fdate', result='$res', lastupdate='$lupdate' where panel='$panel'")or die(mysqli_error($con));
            }
        }
        else{
            mysqli_query($con, "INSERT INTO ict_test (panel, result, fdate, lastupdate) values('$panel','$res','$fdate','$lupdate')")or die(mysqli_error($con));
        }
        
        
    }
}


// ***********************************  Fetching SN-Panel  **************************************************************
$dir    = 'C:\carling\panel_sn';
$files1 = scandir($dir);
foreach($files1 as $files){
    if(strlen($files)>5){
        if(date(filemtime("C:/carling/panel_sn/".$files))>$lupdPanel){
        // if((filemtime("C:/carling/panel_sn/".$files)){
            set_time_limit(0);
            $file = fopen("C:/carling/panel_sn/$files","r");
            if(fgetcsv($file) !== FALSE){
                while (($line = fgetcsv($file)) !== FALSE) {
                    $panel = preg_replace('/\s+/', '', $line[0]);
                    $sn = preg_replace('/\s+/', '', $line[1]); 
                    $updateon = time();
                    mysqli_query($con, "INSERT INTO sn_panel (panel_no,sn, lastupdate) values('$panel','$sn', '$updateon')")or die(mysqli_error($con));
                }
            }
            
            fclose($file);
        }
    }
}

echo '<script type="text/javascript">alert("Log data updated!");</script>';
echo "<script>window.history.back();</script>"; 

?>