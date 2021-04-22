
<h1>Don't close this page!</h1>
<pre>
This page is set to update logfile for Carling(3/3) packing system automatically.
</pre>

<?php 

include('../dist/includes/dbcon.php');



$lupdICT=$_GET['lastupdate'];
// $lupdICT = 1600620271;


// ***********************************  Fetching ICT Log  **************************************************************


$mydir = "\\\\10.38.30.174\\Test";// Check if ICT sharefolder is accessible
if(file_exists($mydir)){

    $dir    = '\\\\10.38.30.174\\Test\\ICT\\942-10047';
    $files1 = scandir($dir);

    foreach($files1 as $file){
        if(date (filemtime("\\\\10.38.30.174\\Test\\ICT\\942-10047\\".$file))>$lupdICT){
        // if((filemtime("C:/carling/ict/".$file))){    
            if(strlen($file)>5){
                if(strpos($file, 'default') !== false){
                    //Do nothing
                }
                else{
                    $full = explode("-",$file);
                    $panel = preg_replace('/\s+/', '', $full[0]);
                    $res = $full[2][0];

                    $fdate = date (filemtime("\\\\10.38.30.174\\Test\\ICT\\942-10047\\".$file));
                    
                    set_time_limit(0);
                    
                    if(strlen($res)==1){
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
    }

    $dir    = '\\\\10.38.30.174\\Test\\ICT\\942-10046';
    $files1 = scandir($dir);

    foreach($files1 as $file){
        if(date (filemtime("\\\\10.38.30.174\\Test\\ICT\\942-10046\\".$file))>$lupdICT){
        // if((filemtime("C:/carling/ict/".$file))){    
            if(strlen($file)>5){
                if(strpos($file, 'default') !== false){
                    //Do nothing
                }
                else{
                    $full = explode("-",$file);
                    $panel = preg_replace('/\s+/', '', $full[0]);
                    $res = $full[2][0];

                    $fdate = date (filemtime("\\\\10.38.30.174\\Test\\ICT\\942-10046\\".$file));
                    
                    set_time_limit(0);
                    
                    if(strlen($res)==1){
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


echo "Last Updated on: ".date('d-m-Y H:i:s A', time());

header( "refresh:3600;url=icttestauto.php" );
?>