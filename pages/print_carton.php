<?php 
    session_start();
    if(empty($_SESSION['id'])):
    header('Location:../index.php');
    endif;

    include('../dist/includes/dbcon.php');
    include('product_cfg.php');
    $carton_id = $_POST['carton_id'];
	$ip = $_POST['printer_ip'];
	
	$query=mysqli_query($con,"select ip from printer_cfg where id=2")or die(mysqli_error($con));
    $row=mysqli_fetch_array($query);
    $current_ip=$row['ip'];
    if($current_ip != $ip){
        mysqli_query($con,"update printer_cfg set ip='$ip' where id=2")or die(mysqli_error($con));
    }
    
	$query=mysqli_query($con,"select * from carton_info where carton_id='{$carton_id}'")or die(mysqli_error($con));
    $row=mysqli_fetch_array($query);
    if(count($row)>0){
        
        $modelname=$row['model_no'];
        $qty=$row['qty'];
        $tmstmp=$row['timestamp'];
        $current_ip=$row['id'];

        $allmodelName = get_modelNo2();
        $max = count($allmodelName);
        $no = 0;
        for($i=0;$i<$max;$i++){
            if($allmodelName[$i]==$modelname){
                $no = $i;
            }
        }

        //edit label file
                
        $allCustProd = get_custProd();
        $lblcode = $allCustProd[$no];

        $allShipPN = get_shipPN();
        $lblcode2 = $allShipPN[$no];
        
        $lbldate = date('d/m/y',$tmstmp);

        // $fp = fopen('C:/lblcarton.txt', 'w');
        // fwrite($fp, '

        if($lblcode =="IQ-M005551.10.1.SB" || $lblcode =="IQ-M005551.10.1.SB.SE")
        {
            $weight = '12.5KG';
        }
        elseif(strpos($lblcode, 'M007739')!== false)
        {
            $weight = '17KG';
        }
        else
        {
            $weight = '15KG';
        }

        $lblbox = '^XA
        ^FWR
        ^FX horizontal line
        ^FO1830,3^GB9,3635,3^FS
        ^FX vertical line
        ^FO1835,2150^GB710,9,3^FS
        
        ^CF0,153
        ^FO2000,170^FDFrom:^FS
        ^FO2000,2310^FDTo:^FS
        
        ^CF0,80
        ^FO2250,730^FDBeyonics Precision^FS
        ^FO2150,730^FDNo. 95, Jalan i-Park 1/10,^FS
        ^FO2050,730^FDKawasan Perindustrian i-Park,^FS
        ^FO1950,730^FDBandar Indahpura,^FS
        ^FO1850,730^FD8100 Kulai. Malaysia^FS
        
        ^FO2200,2690^FDILOQ^FS
        ^FO2100,2690^FDYrttipellontie^FS
        ^FO2000,2690^FD90230 Oulu^FS
        ^FO1900,2690^FDFinland^FS
        
        ^CF0,140
        ^FO1570,170^FD(P) Customer Product IDs:^FS
        ^FO1570,2310^FD(Q) Qty:^FS
        ^FO1360,170^FD'.$lblcode.'^FS
        ^FO1360,2430^FD'.$qty.'^FS
        
        ^BY5.5,3
        ^FO1150,170^BCR,180,N^FDP'.$lblcode.'^FS
        ^FO1150,2310^BCR,180,N^FDQ'.$qty.'^FS
        
        ^FX horizontal line
        ^FO1080,3^GB9,3635,3^FS
        
        ^CF0,150
        ^FO820,170^FD'.$lblcode2.'^FS
        ^FO610,170^FDDate: '.$lbldate.'^FS
        
        ^FO820,2310^FDWeight:  '.$weight.'^FS
        
        ^FX horizontal line
        ^FO550,3^GB9,3635,3^FS
        
        ^CF0,130
        ^FO295,170^FDPALLET ID:^FS
        ^CF0,140
        ^FO290,1000^FD'.$carton_id.'^FS
        
        ^BY5.5,3
        ^FO260,2310^BCR,180,N^FD'.$carton_id.'^FS
        
        ^FX horizontal line
        ^FO165,3^GB9,3635,3^FS
        
        ^XZ';

        //function to ping ip address
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
                    echo "<script type='text/javascript'>document.location='home.php'</script>"; 
                }
                else{
                    echo '<script type="text/javascript">alert("Printer is not available!");</script>';
                    echo "<script type='text/javascript'>document.location='home.php'</script>";  
                } 
            }
            catch (Exception $e) 
            {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        else{
            echo '<script type="text/javascript">alert("Printer is not available!");</script>';
            echo "<script type='text/javascript'>document.location='home.php'</script>";  
        }
    }
    else{
        echo "<script type='text/javascript'>alert('Box ID entered is not exist in system!');</script>";
	    echo "<script>window.history.back();</script>"; 
    }
?>
