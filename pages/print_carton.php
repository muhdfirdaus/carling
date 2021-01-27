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

        $allmodelName = get_modelNo2($con);
        foreach($allmodelName as $key=>$value){
            if($value==$modelname){
                $no = $key;
            }
        }

        //edit label file
                
        $allCustProd = get_custProd($con);
        $lblcode = $allCustProd[$no];

        $allShipPN = get_shipPN($con);
        $lblcode2 = $allShipPN[$no];
        
        $lbldate = date('d/m/y',$tmstmp);

        // $fp = fopen('C:/lblcarton.txt', 'w');
        // fwrite($fp, '

        if($carton_id =="IQ001294")
        {
            $weight = '4.455KG';
        }
        elseif(strpos($lblcode, 'M10795')!== false)
        {
            $weight = '7.5KG';
        }
        elseif(strpos($lblcode, 'M10794')!== false)
        {
            $weight = '7.5KG';
        }
        elseif(strpos($lblcode, 'M10475')!== false)
        {
            $weight = '7.5KG';
        }
        elseif(strpos($lblcode, 'M009373')!== false)
        {
            $weight = '7.5KG';
        }
        elseif(strpos($lblcode, 'M009370')!== false)
        {
            $weight = '7.5KG';
        }
        elseif($carton_id =="IQ003047")
        {
            $weight = '13KG';
        }
        elseif($carton_id =="IQ001951")
        {
            $weight = '6.13KG';
        }
        elseif($carton_id =="IQ002934")
        {
            $weight = '4.5KG';
        }
        elseif($carton_id =="IQ001880")
        {
            $weight = '1.745KG';
        }
        elseif($carton_id =="IQ001777")
        {
            $weight = '7.40KG';
        }
        elseif($carton_id =="IQ001823")
        {
            $weight = '5.145KG';
        }
        elseif($carton_id =="IQ001794")
        {
            $weight = '7.40KG';
        }
        elseif($carton_id =="IQ001790")
        {
            $weight = '3.565KG';
        }
        elseif($carton_id =="IQ001767")
        {
            $weight = '5.10KG';
        }
        elseif($carton_id =="IQ002929")
        {
            $weight = '11KG';
        }
        elseif($carton_id =="IQ001766")
        {
            $weight = '1.43KG';
        }
        elseif($carton_id =="IQ001731")
        {
            $weight = '7.43KG';
        }
        elseif($carton_id =="IQ001722")
        {
            $weight = '5.94KG';
        }
        elseif($carton_id =="IQ001329")
        {
            $weight = '4.44KG';
        }
        elseif($lblcode =="IQ-M005551.10.1.SB" || $lblcode =="IQ-M005551.10.1.SB.SE")
        {
            $weight = '12.5KG';
        }
        elseif($lblcode =="IQ-M011795.1-B1" )
        {
            $weight = '8KG';
        }
        elseif(strpos($lblcode, 'M007739')!== false)
        {
            $weight = '17KG';
        }
        elseif(strpos($lblcode, 'M011442')!== false)
        {
            $weight = '22.96KG';
        }
        elseif(strpos($lblcode, 'M009801')!== false)
        {
            $weight = '21.15KG';
        }
        elseif(strpos($lblcode, 'M010293')!== false)
        {
            $weight = '22.76KG';
        }
        elseif($carton_id =="IQ001254")
        {
            $weight = '1.59KG';
        }
        elseif($carton_id =="IQ001251")
        {
            $weight = '4.385KG';
        }
        elseif($carton_id =="IQ001247")
        {
            $weight = '6.01KG';
        }
        elseif($carton_id =="IQ001226")
        {
            $weight = '2.24KG';
        }
        elseif($carton_id =="IQ001227")
        {
            $weight = '0.5KG';
        }
        elseif( $carton_id =="IQ001228")
        {
            $weight = '1.02KG';
        }
        elseif( $carton_id =="IQ001551")
        {
            $weight = '10.315KG';
        }
        elseif( $carton_id =="IQ001557")
        {
            $weight = '7.365KG';
        }
        elseif( $carton_id =="IQ001619")
        {
            $weight = '1.46KG';
        }
        elseif(strpos($lblcode, 'M010267')!== false && $carton_id !="IQ001157")
        {
            $weight = '17KG';
        }
        elseif(strpos($lblcode, 'M010267')!== false && $carton_id =="IQ001157")
        {
            $weight = '11.5KG';
        }
        elseif(strpos($lblcode, 'M010172')!== false)
        {
            $weight = '12.5KG';
        }
        elseif(strpos($lblcode, 'M005551')!== false)
        {
            $weight = '12.5KG';
        }
        elseif(strpos($lblcode, 'M012309')!== false)
        {
            $weight = '15.75KG';
        }
        elseif(strpos($lblcode, 'M012217')!== false)
        {
            $weight = '15.75KG';
        }
        elseif($carton_id=="IQ001162")
        {
            $weight = "4.1KG";
        }
        elseif($carton_id=="IQ001165")
        {
            $weight = "4.1KG";
        }
        elseif($carton_id=="IQ001195")
        {
            $weight = "4.5KG";
        }
        elseif($carton_id=="IQ001196")
        {
            $weight = "2.8KG";
        }
        elseif($carton_id=="IQ001656")
        {
            $weight = "7.025KG";
        }
        elseif($carton_id=="IQ001657")
        {
            $weight = "7.595KG";
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
        ^FO1850,730^FD81000 Kulai. Malaysia^FS
        
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
        
        ^FO610,2310^FDWeight:  '.$weight.'^FS
        
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
                    echo "<script type='text/javascript'>document.location='box.php'</script>"; 
                }
                else{
                    echo '<script type="text/javascript">alert("Printer is not available!");</script>';
                    echo "<script type='text/javascript'>document.location='box.php'</script>";  
                } 
            }
            catch (Exception $e) 
            {
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        else{
            echo '<script type="text/javascript">alert("Printer is not available!");</script>';
            echo "<script type='text/javascript'>document.location='box.php'</script>";  
        }
    }
    else{
        echo "<script type='text/javascript'>alert('Box ID entered is not exist in system!');</script>";
	    echo "<script>window.history.back();</script>"; 
    }
?>
