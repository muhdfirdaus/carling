<?php 

include('../dist/includes/dbcon.php');



$files = glob("C:\iLOQ\Durability\Fix1_19OCT18\*.txt");//open all file 

foreach($files as $file) {

    $line = file($file);//file in to an array
    // echo basename($file)."\n";
    $fdate = date ("YmdHis", filemtime($file));
    $line1 = $line[0];//fetch serial number
    $arr1 = explode(":",$line1);
    $sn = preg_replace('/\s+/', '', $arr1[1]);
    
    $line3 = $line[2];//fetch test result
    $arr2 = explode(":",$line3);
    $status = preg_replace('/\s+/', '', $arr2[1]);
    
    if(isset($data[$sn])){
        if($data[$sn]['d'] < $fdate){
            $data[$sn] = array(0=>$sn, 1=>$status[0], 'd'=>$fdate);
        }
    }
    else{
        $data[$sn] = array(0=>$sn, 1=>$status[0], 'd'=>$fdate);
    }
    // rename($file, 'C:/iLOQ/Durability/logged/'.basename($file));
}

$files = glob("C:\iLOQ\pcba\Oval_Assy_M0041*.txt");//open all lock file

foreach($files as $file) {
    if (trim(file_get_contents($file)) == true) {
        $line = file($file);//file in to an array
        $fdate = date ("YmdHis", filemtime($file));
        $line1 = $line[3];//fetch serial number
        $arr1 = explode(":",$line1);
        $sn = preg_replace('/\s+/', '', $arr1[1]);
        
        $line3 = $line[9];//fetch test result
        $arr2 = explode(":",$line3);
        $status = preg_replace('/\s+/', '', $arr2[1]);
    
        if(isset($data[$sn]['l'])){
            if($data[$sn]['l'] < $fdate){
                $data[$sn][2] =  $status[0];
                $data[$sn]['l'] =  $fdate;
            }
        }
        else{
            $data[$sn][2] =  $status[0];
            $data[$sn]['l'] =  $fdate;
        }
    }
    // rename($file, 'C:/iLOQ/pcba/logged/'.basename($file));
}


foreach($data as $newdata){
    isset($newdata[0])?$sn = $newdata[0]:$sn="NULL";
    isset($newdata[1])?$durability = $newdata[1]:$durability="NULL";
    isset($newdata[2])?$lock = $newdata[2]:$lock="NULL";
    isset($newdata['d'])?$dDate = $newdata['d']:$dDate="NULL";
    isset($newdata['l'])?$lDate = $newdata['l']:$lDate="NULL";
    $lupdt = time();

    if($sn != "NULL" && ($durability != "NULL" || $lock != "NULL")){
        //check for existing data
        $query=mysqli_query($con,"select lDate, dDate, count(*) as cnt from sn_master where sn='$sn'")or die(mysqli_error($con));
        $row=mysqli_fetch_array($query);
        if($row['cnt']==0){
            //insert new data
            mysqli_query($con,"INSERT INTO sn_master(sn,lockTest,durTest,lDate,dDate,lastUpdate)VALUES('$sn','$lock', '$durability', '$lDate', '$dDate', '$lupdt')")or die(mysqli_error($con));
        }
        else{
            //update existing data
            if($dDate!="NULL"){
                if($dDate>$row['dDate']){
                    mysqli_query($con,"update sn_master set dDate='$dDate',durTest='$durability',lastUpdate='$lupdt' where sn='$sn'")or die(mysqli_error($con));
                }
            }
            if($lDate!="NULL"){
                if($dDate>$row['lDate']){
                    mysqli_query($con,"update sn_master set lDate='$lDate',lockTest='$lock',lastUpdate='$lupdt' where sn='$sn'")or die(mysqli_error($con));
                }
            }

        }
    }

}
echo '<script type="text/javascript">alert("Log data updated!");</script>';
echo "<script>window.history.back();</script>"; 

?>