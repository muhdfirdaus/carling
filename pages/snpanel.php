<?php 

include('../dist/includes/dbcon.php');


$query=mysqli_query($con,"select lastupdate from sn_panel order by lastupdate desc limit 1")or die(mysqli_error($con));
$row=mysqli_fetch_array($query);
$lupdPanel=$row['lastupdate'];


// fetching panel-sn data
$dir    = 'C:\carling\panel_sn';
$files1 = scandir($dir);
foreach($files1 as $files){
    if(strlen($files)>5){
        if(date(filemtime("C:/carling/panel_sn/".$files))>$lupdPanel){
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













?>