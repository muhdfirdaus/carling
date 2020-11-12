<?php 

include('../dist/includes/dbcon.php');

$lupdPanel = 1603818561;

// ***********************************  Fetching SN-Panel  **************************************************************
$dir    = 'C:\carling\panel_sn';
$files1 = scandir($dir);
foreach($files1 as $files){
    if(strlen($files)>5){
        if(date(filemtime("C:/carling/panel_sn/".$files))>$lupdPanel){
        // if(date(filemtime("C:/carling/panel_sn/".$files))>1603130367 && date(filemtime("C:/carling/panel_sn/".$files))<1603173567){    
        // if((filemtime("C:/carling/panel_sn/".$files)){
            set_time_limit(0);
            $file = fopen("C:/carling/panel_sn/$files","r");
            if(fgetcsv($file) !== FALSE){
                while (($line = fgetcsv($file)) !== FALSE) {
                    $panel = preg_replace('/\s+/', '', $line[0]);
                    $sn = preg_replace('/\s+/', '', $line[1]); 
                    $fdate = date(filemtime("C:/carling/panel_sn/".$files));
                    $updateon = time();
                    mysqli_query($con, "INSERT INTO sn_panel (panel_no,sn, fdate,lastupdate) values('$panel','$sn', '$fdate', '$updateon')")or die(mysqli_error($con));
                }
            }
            
            fclose($file);
        }
    }
}

echo '<script type="text/javascript">alert("Log data updated!");</script>';
// echo "<script>window.history.back();</script>"; 

?>