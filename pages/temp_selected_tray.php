<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');

$prc = $_POST['prc'];

if(!empty($_POST['id'])){

    //process code(prc) 0=start, 1=stop, 2=finish
    if($prc == 0){

        $idlist="";
        $errorstatus = 0;

        foreach($_POST['id'] as $id){
            
            $query=mysqli_query($con,"SELECT * from temp_test where id = '$id'")or die(mysqli_error($con));
            $row=mysqli_fetch_array($query);
            
            if($row['time_in']!=null){
                $errorstatus = 1;
            }
            else{
                strlen($idlist)>0?$idlist .= ",$id":$idlist .= "$id";        
            }

        }

        if($errorstatus==0){

            $timestamp = time();
            mysqli_query($con,"UPDATE temp_test set time_in = $timestamp where id in($idlist) ")or die(mysqli_error($con));
            echo "<script type='text/javascript'>alert('Data Updated!');</script>";
            echo "<script>document.location=window.history.back();</script>"; 
        }
        else{
            echo "<script type='text/javascript'>alert('Some tray already started!');</script>";
            echo "<script>document.location=window.history.back();</script>"; 
        }

    }
    
    if($prc == 1){

        $idlist="";
        $errorstatus = 0;
        $errmsg1 = 0; //error message for existing data
        $errmsg2 = 0; //error message for less then minimum test time 

        foreach($_POST['id'] as $id){
            
            $query=mysqli_query($con,"SELECT * from temp_test where id = '$id'")or die(mysqli_error($con));
            $row=mysqli_fetch_array($query);
            
            $temperature = $row['temperature'];
            $time_in = $row['time_in'];
            $min_time = $time_in + ($temperature * 3600);
            $timestamp = time();

            if($row['time_out']!=null){
                $errorstatus = 1;
                $errmsg1 = 1;
            }
            elseif($timestamp<$min_time || $time_in==null){
                $errorstatus = 1;   
                $errmsg2 = 1;             
            }
            else{
                strlen($idlist)>0?$idlist .= ",$id":$idlist .= "$id";        
            }

        }

        if($errorstatus==0){

            $timestamp = time();
            mysqli_query($con,"UPDATE temp_test set time_out = $timestamp where id in($idlist) ")or die(mysqli_error($con));
            echo "<script type='text/javascript'>alert('Data Updated!');</script>";
            echo "<script>document.location=window.history.back();</script>"; 
        }
        else{
            $errmsg = "";
            if($errmsg1==1){
                $errmsg .= "Some tray already stopped!";
            }
            if($errmsg2==1){
                $errmsg .= " Some tray not pass minimum time test!";
            }
            echo "<script type='text/javascript'>alert('$errmsg');</script>";
            echo "<script>document.location=window.history.back();</script>"; 
        }

    }
    
    if($prc == 2){

        $idlist="";
        $errorstatus = 0;

        foreach($_POST['id'] as $id){
            
            $query=mysqli_query($con,"SELECT * from temp_test where id = '$id'")or die(mysqli_error($con));
            $row=mysqli_fetch_array($query);

            if($row['time_out']==null || $row['time_in']==null){
                $errorstatus = 1;
            }
            else{
                strlen($idlist)>0?$idlist .= ",$id":$idlist .= "$id";        
            }

        }

        if($errorstatus==0){

            $timestamp = time();
            echo "<script>document.location='timer_result.php?id=$idlist'</script>"; 
        }
        else{
            echo "<script type='text/javascript'>alert('Some tray dont have Time In/ Time Out');</script>";
            echo "<script>document.location=window.history.back();</script>"; 
        }

    }
}
else{

    echo "<script type='text/javascript'>alert('No Tray Selected!');</script>";
    echo "<script>document.location='temperature_test.php'</script>"; 
}





// if(!empty($_POST['id'])){
//     $i = 0;
//     $idlist = "";
//     foreach($_POST['id'] as $report_id){

//         if($i==0){
//             $temp = $_POST['temp'][$report_id];
//         }
        
//         if($temp != $_POST['temp'][$report_id]){
//             echo "<script type='text/javascript'>alert('Different Temperature Selected!');</script>";
//             echo "<script>document.location='temperature_test.php'</script>"; 
//         }
//         else{
//             strlen($idlist)>0?$idlist .= ",$report_id":$idlist .= "$report_id";
//         }
            
        
//         $i++;
//     }
//     if(($temp==1 && $i > 8) || ($temp==2 && $i > 16)){
//         echo "<script type='text/javascript'>alert('Exceeded number of tray allowed!');</script>";
//         echo "<script>document.location='temperature_test.php'</script>"; 
//     }
//     else{
//         $timestamp = time();
//         mysqli_query($con,"UPDATE temp_test set time_in = $timestamp where id in($idlist) ")or die(mysqli_error($con));
//         echo "<script>document.location='timer_test.php?id=$idlist&temp=$temp'</script>"; 
//     }
    
// }
// else{
//     echo "<script type='text/javascript'>alert('No Tray Selected!');</script>";
//     echo "<script>document.location='temperature_test.php'</script>"; 

// }



















?>