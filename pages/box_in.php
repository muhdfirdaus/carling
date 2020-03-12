<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../dist/includes/dbcon.php');
include('product_cfg.php');
	$box_id = $_POST['box_id'];
	$qty = $_POST['qty'];
	$no = $_POST['model'];
	$id = $_SESSION['id'];
	$tmstmp = time(); 

	$allmodel = get_model();
	$allmodelNo = get_modelNo();
	$allmodelNo2 = get_modelNo2();
	$allmodel_name = get_model_name();
	$model = $allmodel[$no];
	$model_no = $allmodelNo[$no];
	$model_name = $allmodel_name[$no];
	$model_no2 = $allmodelNo2[$no];
	//Check for duplicate SN
	$dupmsg = 'Duplicate SN detected in: \n';
    $dupmsg_T = 0;
    for($i=1;$i<=$qty;$i++){
        $dup_detect = 0;
        for($c=1;$c<=$qty;$c++){
            if($c!=$i){
                $_POST['sn'.$i]==$_POST['sn'.$c]?$dup_detect=1:$dup_detect=$dup_detect;
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
		for($i=1;$i<=$qty;$i++){
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

			for($i=1;$i<=$qty;$i++){
				$rfsissue = 0;
				$sn= $_POST['sn'.$i];
				$query=mysqli_query($con,"select lockTest, durTest, rfsTest,lDate,rDate,dDate, count(*) as cnt from sn_master where sn='$sn'")or die(mysqli_error($con));
				$row=mysqli_fetch_array($query);
				if($row['cnt']==0 || ($row['lockTest']!="P"&&$row['durTest']!="P"&&$row['rfsTest']!="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass ANY test yet!.\n';
				}
				elseif(($row['lockTest']=="P"&&$row['durTest']!="P"&&$row['rfsTest']=="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass Durability test yet!\n';
				}
				elseif(($row['lockTest']!="P"&&$row['durTest']=="P"&&$row['rfsTest']=="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass Lock test yet!\n';
				}
				elseif(($row['lockTest']=="P"&&$row['durTest']=="P"&&$row['rfsTest']!="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass RFS test yet!\n';
				}
				elseif(($row['lockTest']!="P"&&$row['durTest']!="P"&&$row['rfsTest']=="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass Lock & Durability test yet!\n';
				}
				elseif(($row['lockTest']!="P"&&$row['durTest']=="P"&&$row['rfsTest']!="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass Lock & RFS test yet!\n';
				}
				elseif(($row['lockTest']=="P"&&$row['durTest']!="P"&&$row['rfsTest']!="P")){
					$testfailed = 1;
					$testmsg.=$sn.' on line '.$i.' not pass RFS & Durability test yet!\n';
				}
				elseif(($row['rDate']<=$row['dDate']||$row['rDate']<=$row['dDate'])){
					$testfailed = 1;
					$rfsissue = 1;
					$testmsg.=$sn.' on line '.$i.' RFS Test is not valid! Please start over test process.\n';
				}

				if(strpos($model_name,"OUTDOOR")){

					if($tempres = checkTempTest($sn,$con)){
						$rdate = strtotime($row['rDate']);
						if($tempres['result']!="P"){
							$testfailed = 1;
							$testmsg.=$sn.' on line '.$i.' not pass Temperature test yet.\n';
						}
						elseif($tempres['time_out']<$rdate && $rfsissue==0){
							$testfailed = 1;
							$testmsg.=$sn.' on line '.$i.' RFS Test is not valid! Please start over test process.\n';
						}
					}
					else{
						$testfailed = 1;
						$testmsg.=$sn.' on line '.$i.' not pass Temperature test yet.\n';
					}

				}
				
			}
			if($testfailed){
				echo '<script type="text/javascript">alert("'.$testmsg.'");</script>';
				echo "<script>window.history.back();</script>"; 
			}
			else{
			
			
				$i = 1;
				
				while($i <= $qty){
					
					$sn= $_POST['sn'.$i];
					mysqli_query($con,"INSERT INTO box_sn(box_id,sn)VALUES('$box_id','$sn')")or die(mysqli_error($con));

					$i++;
				}
				
				mysqli_query($con,"INSERT INTO box_info(box_id,user_id,qty,timestamp,model_no,model)
				VALUES('$box_id','$id', '$qty', '$tmstmp', '$model_no2', '$model_name')")or die(mysqli_error($con));
				echo "<script type='text/javascript'>alert('Data saved!');</script>";
				
				$query=mysqli_query($con,"select ip from printer_cfg where id=1")or die(mysqli_error($con));
				$row=mysqli_fetch_array($query);
				$ip=$row['ip'];

				//edit label file
				$lbldate = date('d/m/y',$tmstmp);
				$lblbox = '^XA
				
				^FO30,10^GFA,12412,12412,58,,::::::::::::::::::::::::::::::::::::::O07FE,N01IF8,N03IFE,N0KF,M01KF8,:M03KFC,M07KFE,::M0MF,M0MFgW07FF8gN01IF8,M0MFgU01KFEgL03KFE,M0MFgT01MFEgJ03MFE,M0MFL07KFCgG0OFEgH03OFC,M0MFL07KFCg07PFCgG0QF8,M0MFL07KFCY01RFg07QFE,M07LFL07KFCY0SFCX01SF,M07KFEL07KFCX03TFX07RFE,M07KFEL07KFCX07TF8W0SFC,M03KFCL07KFCW01UFEV03SFC,M03KFCL07KFCW07VF8U07SF8,M01KF8L07KFCW0WFCT01TF8,N0KFM07KFCV01XFT03TF,N07IFEM07KFCV03XF8S0TFE,N01IFCM07KFCV0YFCR01TFEI018,O0IFN07KFCU01YFER03TFCI03C,O01F8N07KFCU03gFR07TF8I03E,g07KFCU07gF8Q0UF8I07F,g07KFCU0gGFCP01UFJ07F8,g07KFCT01gGFEP03TFEJ0FFC,g07KFCT03gHFP07TFEI01FFE,g07KFCT07gHF8O0UFCI01IF,g07KFCT07gHFCN01UFCI03IF8,g07KFCT0gIFCN01UF8I07IF8,g07KFCS01PFI03OFEN03OFEI03FJ07IFC,g07KFCS03OFK03OFN07NFEK07J0JFE,g07KFCS03NFCL07NF8M07NFQ0KF,g07KFCS07MFEM01NF8M0NFCP01KF,g07KFCS0NF8N07MFCL01NFQ03KF8,g07KFCS0NFO01MFEL01MFCQ03KFC,M03KFCL07KFCR01MFCP0MFEL03MF8Q07KFC,M03KFCL07KFCR01MF8P07MFL03MFR0LFE,M03KFCL07KFCR03MFQ01MFL07LFER0LFE,M03KFCL07KFCR03LFER0MF8K07LF8Q01MF,M03KFCL07KFCR07LFCR07LF8K0MFS0MF,M03KFCL07KFCR07LF8R03LFCK0MFS07LF8,M03KFCL07KFCR0MFS01LFCJ01LFES03LF8,M03KFCL07KFCR0LFES01LFEJ01LFCS03LFC,M03KFCL07KFCQ01LFCT0LFEJ03LF8S01LFC,M03KFCL07KFCQ01LFCT07KFEJ03LFU0LFC,M03KFCL07KFCQ01LF8T03LFJ03LFU07KFE,M03KFCL07KFCQ03LFU03LFJ07KFEU07KFE,M03KFCL07KFCQ03LFU01LFJ07KFEU03KFE,M03KFCL07KFCQ03KFEU01LF8I07KFCU03LF,M03KFCL07KFCQ07KFEV0LF8I0LFCU01LF,M03KFCL07KFCQ07KFCV0LF8I0LF8U01LF,M03KFCL07KFCQ07KFCV07KF8I0LF8V0LF,M03KFCL07KFCQ07KF8V07KFCI0LFW0LF8,:M03KFCL07KFCQ0LF8V03KFC001LFW07KF8,M03KFCL07KFCQ0LFW03KFC001KFEW07KF8,::M03KFCL07KFCQ0LFW01KFC001KFEW03KFC,M03KFCL07KFCQ0LFW01KFE001KFEW03KFC,:M03KFCL07KFCQ0KFEW01KFE001KFCW03KFC,::::::M03KFCL07KFCQ0LFW01KFE001KFEW03KFC,:M03KFCL07KFCQ0LFW01KFC001KFEW03KFC,M03KFCL07KFCQ0LFW03KFC001KFEW07KF8,:M03KFCL07KFCQ0LFW03KFC001LFW07KF8,M03KFCL07KFCQ0LF8V03KFC001LFW07KF8,M03KFCL07KFCQ07KF8V07KFCI0LFW0LF8,:M03KFCL07KFCQ07KFCV07KF8I0LF8V0LF,M03KFCL07KFCQ07KFCV0LF8I0LF8U01LF,M03KFCL07KFCQ03KFEV0LF8I07KFCU01LF,M03KFCL07KFCQ03KFEU01LF8I07KFCU03LF,M03KFCL07KFCQ03LFU01LFJ07KFEU03KFE,M03KFCL07KFCQ03LFU03LFJ07KFEU07KFE,M03KFCL07KFCQ01LF8T03LFJ03LFU07KFE,M03KFCL07KFCQ01LFCT07KFEJ03LF8T0LFC,M03KFCL07KFCQ01LFCT0LFEJ01LF8S01LFC,M03KFCL07KFCR0LFES01LFEJ01LFCS03LFC,M03KFCL07KFCR0MFS01LFCJ01LFES03LF8,M03KFCL07KFCR07LF8R03LFCK0MFS07LF8,M03KFCL07KFCR07LFCR07LF8K0MF8R0MF,M03KFCL07KFCR03LFER0MF8K07LFCQ01MF,M03KFCL07KFCR03MFQ03MFL07LF8Q03LFE,M03KFCL07KFCR01MF8P07MFL03LF8Q0MFE,M03KFCL07KFCR01MFEP0MFEL03LFQ01MFC,M03KFCL07KFCS0NFO03MFEL01KFEQ07MFC,M03KFCL07KFCS0NFCN07MFCM0KFEQ0NF8,M03KFCL07KFCS07MFEM01NF8M0KFCP03NF,M03KFCL07KFCS03NFCL07NF8M07JFCP0OF,M03KFCL07VFI03OF8J03OFN07JF8I07K07NFE,M03KFCL07UFEI01PF8003OFEN03JFJ07FI07OFC,M03KFCL07UFCJ0gIFCN01JFJ0gIFD,M03KFCL07UFCJ07gHFCO0IFEI01gJF,M03KFCL07UF8J07gHF8O07FFEI01gIFE,M03KFCL07UF8J03gHFP03FFCI03gIFC,M03KFCL07UFK01gGFEP03FF8I03gIFC,M03KFCL07UFL0gGFCP01FFJ07gIF8,M03KFCL07TFEL07gF8Q0FFJ0gJF8,M03KFCL07TFCL03gFR07EJ0gJF,M03KFCL07TFCL01YFER01EI01gIFE,M03KFCL07TF8M07XFCS0CI03gIFC,M03KFCL07TF8M03XF8W03gIFC,M03KFCL07TFN01WFEX07gIF8,M03KFCL07TFO0WFCX0gJF8,M03KFCL07SFEO03VF8X0gJF,M03KFCL07SFCO01UFEX01gIFE,M03KFCL07SFCP07TF8X01gIFE,M03KFCL07SF8P01SFEY03gIFC,M03KFCL07SF8Q07RFCY07gIFC,M03KFCL07SFR01RFg03gIF8,M03KFCL07SFS07PF8gG0gIF,M03KFCL07RFET0OFCgH01gHF,hN01MFEgJ01gFE,hO01KFEgL01YFC,hR0FCgP01WFC,,::::::::::::::::::::::::::::::::::::::::::::^FS

				^CFP,120,99
				^FO840,70^FDwww.iloq.com^FS
				
				^CFP,130,99
				^FO45,220^FD'.$model_name.'^FS
				
				^CFP,120,85
				^FO45,330^FDPN: '.$model_no.'^FS
				^FO1160,330^FDQTY: '.$qty.'^FS
				
				^BY5,2
				^FO45,430^BCn,80,N^FD'.$model_no.'^FS
				^FO1150,430^BCn,80,N^FD'.$qty.'^FS
				
				^FO45,555^FDBOX NO: '.$box_id.'^FS
				^FO1000,555^FDDATE: '.$lbldate.'^FS
				
				^BY5,2
				^FO45,655^BCn,80,N^FD'.$box_id.'^FS
				^FO1000,655^BCn,80,N^FD'.$lbldate.'^FS
				
				^XZ';

				$lblbox2 ='^XA
				^CFP,200,139
				^FO60,80^FD'.$model_no2.'^FS
				
				^CFP,190,230
				^FO40,320^FD'.$box_id.'^FS
				^FO38,320^FD'.$box_id.'^FS
				^FO40,322^FD'.$box_id.'^FS
				
				^CFP,200,210
				^FO40,560^FD'.$lbldate.'^FS
				
				^XZ';

				// end of label editting


				// function to ping ip address
				function pingAddress($ip1) {
					$pingresult = exec("ping -n 2 $ip1", $outcome, $status);
					if (0 == $status) {//status-alive
						$toReturn = true;
					} else {//status-dead
						$toReturn = false;
					}
					return $toReturn;
				}
				
				$printable = pingAddress($ip);
				if($printable){
					try//attempt to print label
					{
						// Number of seconds to wait for a response from remote host
						$timeout = 2;
						if($fp=@fsockopen($ip,9100, $errNo, $errStr, $timeout)){
							fputs($fp,$lblbox);
							fclose($fp);				
							echo '<script type="text/javascript">alert("Label printed successfully!");</script>';
							echo "<script>window.history.back();</script>"; 
						}
						else{
							echo '<script type="text/javascript">alert("Printer is not available!");</script>';
							echo "<script>window.history.back();</script>";  
						} 
					}
					catch (Exception $e) 
					{
						echo 'Caught exception: ',  $e->getMessage(), "\n";
					}
				}
				else{
					echo '<script type="text/javascript">alert("Printer is not available!");</script>';
					echo "<script>window.history.back();</script>";  
				}
				
			}
		}

		
	}

	function checkTempTest($sn,$con){
		
        $query=mysqli_query($con,"SELECT tt.id, tt.temperature, ts.sn, tt.time_out, ts.result
        FROM temp_test tt
        JOIN temp_test_sn ts ON tt.id = ts.batch_id
        WHERE ts.sn = $sn AND ts.result IS NOT NULL
        ORDER BY tt.id DESC")or die(mysqli_error($con));

        $rowcount=mysqli_num_rows($query);

        if($rowcount>=1){

            while($row = mysqli_fetch_assoc($query)) {

                if($row['temperature']==1){
					$timeout = date("YmdHis", $retval['time_out']);
                    isset($retval['result'])?$retval['result']=$retval['result']:$retval['result']=$row['result'];
                    isset($retval['time_out'])?$retval['time_out']=$retval['time_out']:$retval['time_out']=$timeout;
                }

                // if($row['temperature']==2){
					// $timeout = date("YmdHis", $retval['time_out']);
                //     isset($retval['result2'])?$retval['result2']=$retval['result2']:$retval['result2']=$row['result'];
                //     isset($retval['time_out2'])?$retval['time_out2']=$retval['time_out2']:$retval['time_out2']=$timeout;
                // }
            }
        }
        else{            
            $retval['result'] = '';
            $retval['time_out'] ='';
            // $retval['result2'] = '';
            // $retval['time_out2'] ='';
        }

		return $retval;
    }
?>
