<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
include('product_cfg.php');
	$box_id = $_POST['box_id'];
	$qty = $_POST['qty'];
	$no = $_POST['model'];
	$id = $_POST['id'];
    $tmstmp = time(); 
    $maxrow = $_POST['maxrow'];
    $user_id = $_SESSION['id'];

	//Check for duplicate SN
	$dupmsg = 'Duplicate SN detected in: \n';
    $dupmsg_T = 0;
    for($i=1;$i<=$maxrow;$i++){
        $_POST['sn'.$i]= preg_replace('/\s+/', '', $_POST['sn'.$i]);
    }
    for($i=1;$i<=$maxrow;$i++){
        $dup_detect = 0;
        for($c=1;$c<=$maxrow;$c++){
            if($c!=$i){
                if(strlen($_POST['sn'.$i])>=1&&strlen($_POST['sn'.$c])>=1){
                    $_POST['sn'.$i]==$_POST['sn'.$c]?$dup_detect=1:$dup_detect=$dup_detect;
                }
            }
        }
        $dup_detect==1?$dupmsg.='-line '.$i.'\n':$dupmsg = $dupmsg;
        $dup_detect==1?$dupmsg_T = 1: $dupmsg_T=$dupmsg_T;
    }
    if($dupmsg_T==1){
        echo '<script type="text/javascript">alert("'.$dupmsg.'");</script>';
        echo "<script>window.history.back();</script>"; 
	}
	else{
		//check for existing data
		$existmsg='';
		$testmsg='';
		$existed = 0;
		$testfailed=0;
		for($i=1;$i<=$maxrow;$i++){
			$sn= $_POST['sn'.$i];
			$query=mysqli_query($con,"select count(*) as cnt from box_sn where sn='$sn'")or die(mysqli_error($con));
			$row=mysqli_fetch_array($query);
			if($row['cnt']!=0){
				$existed = 1;
				$existmsg.=$sn.' on line '.$i.' already exist in the system!\n';
			}
		}
		if($existed){
			echo '<script type="text/javascript">alert("'.$existmsg.'");</script>';
        	echo "<script>window.history.back();</script>"; 
        }
        else{
            for($i=1;$i<=$maxrow;$i++){
                if(strpos($no,"10047")!== false || strpos($no,"10046")!== false || strpos($no,"10045")!== false){
                    if(strlen($_POST['sn'.$i])>=1){
                        $sn = $_POST['sn'.$i];
                        if(strpos($no,"10046")!== false ){
                            $query=mysqli_query($con,"SELECT result FROM ict_test WHERE panel='$sn'LIMIT 1")or die(mysqli_error($con));
                        }
                        else{
                            $query=mysqli_query($con,"SELECT i.result FROM ict_test i JOIN sn_panel p ON i.panel = p.panel_no WHERE p.sn='$sn' ORDER BY i.id DESC LIMIT 1")or die(mysqli_error($con));
                        }
                        $row=mysqli_fetch_array($query);
                        if($row['result']!="P"){
                            if(strpos($no,"10046")!== false ){
                                $query=mysqli_query($con,"SELECT i.result FROM ict_test i JOIN sn_panel p ON i.panel = p.panel_no WHERE p.sn='$sn' ORDER BY i.id DESC LIMIT 1")or die(mysqli_error($con));
                                $row=mysqli_fetch_array($query);
                                if($row['result']!="P"){
                                    $testfailed = 1;
                                    $testmsg.=$sn.' on line '.$i.' not pass ICT Test yet!\n';
                                }
                            }
                            else{
                                $testfailed = 1;
                                $testmsg.=$sn.' on line '.$i.' not pass ICT Test yet!\n';
                            }
                        }
                    }
                }
            }
            if($testfailed==0){
                for($i=1;$i<=$maxrow;$i++){

                    if(strlen($_POST['sn'.$i])>=1){
                        $sn = $_POST['sn'.$i];
                        mysqli_query($con, "INSERT INTO box_sn (box_id, sn, user_id, timestamp) values('$box_id', '$sn', '$user_id', '$tmstmp')")or die(mysqli_error($con));
                    }

                }
                echo '<script type="text/javascript">alert("Data saved!");</script>';

                $query=mysqli_query($con,"select count(*) as tot from box_sn where box_id=$box_id")or die(mysqli_error($con));
                $row=mysqli_fetch_array($query);
                $scanned = $row['tot'];

                if($scanned<$qty){
                    echo "<script>document.location='box_scan.php?id=$id'</script>"; 
                }
                else{
                    mysqli_query($con, "UPDATE box_master set status=1 where box_id ='$box_id' ")or die(mysqli_error($con));
                    echo "<script>document.location='lblprint.php?id=$box_id'</script>"; 
                }
            }
            else{
                echo '<script type="text/javascript">alert("'.$testmsg.'");</script>';
				echo "<script>window.history.back();</script>"; 
            }
        }
    }
?>
