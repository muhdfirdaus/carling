<?php 

include('../dist/includes/dbcon.php');

$lupdPanel = 1601925474;

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