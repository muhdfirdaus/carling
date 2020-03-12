<?php

include('../dist/includes/dbcon.php');


$files = glob("C:\carling\panel_sn\*");//open all file 


foreach($files as $file) {
    $line = file($file);//file in to an array
    $fn =  basename($file);
    
    // The nested array to hold all the arrays
    $the_big_array = []; 
    $c = 0;
    // Open the file for reading
    $filename = "C:\\carling\\panel_sn\\$fn";
    if (($h = fopen("{$filename}", "r")) !== FALSE) 
    {
        // Each line in the file is converted into an individual array that we call $data
        // The items of the array are comma separated
        while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
        {
            $c++;
            $the_big_array[] = $data;
        }

        // Close the file
        fclose($h);
    }

    
    
}

for($i=0;$i<$c;$i++){
    $sn = preg_replace('/\s+/', '', $the_big_array[$i][1]);
    $panel = preg_replace('/\s+/', '', $the_big_array[$i][0]);
    $query=mysqli_query($con,"select count(*) as cnt from sn_panel where sn='$sn' and panel_no='$panel'")or die(mysqli_error($con));
    $row=mysqli_fetch_array($query);
    if($row['cnt']==0){
        mysqli_query($con, "INSERT INTO sn_panel (sn, panel_no) values('$sn','$panel')")or die(mysqli_error($con));
    }
}



?>