<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');

$user_id = $_SESSION['id'];
$temp = $_POST['temp'];
$tray = $_POST['tray'];
$sn[1] = $_POST['sn1'];
$sn[2] = $_POST['sn2'];
$sn[3] = $_POST['sn3'];
$sn[4] = $_POST['sn4'];
$sn[5] = $_POST['sn5'];
$sn[6] = $_POST['sn6'];
$sn[7] = $_POST['sn7'];
$sn[8] = $_POST['sn8'];
$sn[9] = $_POST['sn9'];
$sn[10] = $_POST['sn10'];
$time_in=time();

$start=0;
for($i=1;$i<=10;$i++){

    if(strlen($sn[$i])>1){
        $start = 1; 
    }
}

if($start==1){
    
    $dupmsg = 'Duplicate SN detected in: \n';
    $dupmsg_T = 0;
    for($i=1;$i<=10;$i++){
        $dup_detect = 0;
        for($c=1;$c<=10;$c++){
            if($c!=$i){
                if(strlen($sn[$i])>1&&strlen($sn[$c])>1){
                    $sn[$i]==$sn[$c]?$dup_detect=1:$dup_detect=$dup_detect;
                }
            }
        }
        $dup_detect==1?$dupmsg.='-line '.$i.'\n':$dupmsg = $dupmsg;
        $dup_detect==1?$dupmsg_T = 1: $dupmsg_T=$dupmsg_T;
    }
    if($dupmsg_T==1){
        $start=0;
        echo '<script type="text/javascript">alert("'.$dupmsg.'");</script>';
        echo "<script>window.history.back();</script>"; 
    }
    elseif($result = mysqli_query($con,"SELECT id FROM temp_test WHERE tray_no ='$tray' and status = '0'")){

        if(mysqli_num_rows($result)>0){
            
            echo "<script type='text/javascript'>alert('Tray exist in the system!');</script>";
            echo "<script>document.location=window.history.go(-1);</script>"; 

        }
        else{
            
            $sql = "INSERT INTO temp_test (tray_no, temperature)
            VALUES ('$tray', '$temp')";

            if (mysqli_query($con, $sql)) {
                
                $last_id = mysqli_insert_id($con);

                for($i=1;$i<=10;$i++){

                    if(strlen($sn[$i])>1){
                        mysqli_query($con, "INSERT INTO temp_test_sn (batch_id, sn) values('$last_id', '$sn[$i]')")or die(mysqli_error($con));
                    }

                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }


            mysqli_close($con);


            echo "<script type='text/javascript'>alert('Tray registered successfully!');</script>";
            echo "<script>document.location='temp_tray_sn.php'</script>"; 

        }
    }
}
else{    
    echo "<script type='text/javascript'>alert('Please insert atleast one serial number!');</script>";
    echo "<script>document.location=window.history.go(-1);</script>";
}
?>