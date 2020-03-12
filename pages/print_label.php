<?php 
    session_start();
    if(empty($_SESSION['id'])):
    header('Location:../index.php');
    endif;

    include('../dist/includes/dbcon.php');
    $box_id = $_GET['box_id'];
	$ip = $_GET['printer_ip'];
    
	$query=mysqli_query($con,"select * from box_master where box_id='{$box_id}' and status=1")or die(mysqli_error($con));
    $row=mysqli_fetch_array($query);
    if(count($row)>0){
        
        $model=$row['model'];
        $wo=$row['wo'];
        $qty=$row['qty'];
        $tmstmp=$row['timestamp'];
        $lot=$row['lot'];
        $rev=$row['rev'];

        
        //edit label file
        $lbldate = date('Y.m.d',$tmstmp);
        $lblbox = "^XA 

        ^FO10,20^GB1900,9,13^FS
        
        ^A0N,90,79^FO40,70^FDModel - Rev^FS 
        ^A0N,90,79^FO40,160^FD(M)^FS 
        
        ^CFP,110,110
        ^FO425,120^FD$model-$rev^FS 
        
        ^FO225,300^BY6^BCn,180,N^FDM$model-$rev^FS 
        
        ^FO10,510^GB1900,9,13^FS
        
        ^A0N,90,79^FO40,565^FDQuantity^FS 
        ^A0N,90,79^FO40,655^FD(Q)^FS 
        
        ^CFP,110,110
        ^FO425,575^FD$qty^FS 
        
        ^FO245,750^BY6^BCn,180,N^FDQ$qty^FS 
        
        ^FO950,510^GB9,475,5^FS 
        
        ^A0N,90,79^FO1040,565^FDWO^FS 
        ^A0N,90,79^FO1040,655^FD(O)^FS 
        
        ^CFP,110,110
        ^FO1290,575^FD$wo^FS 
        
        ^FO1040,750^BY5^BCn,180,N^FDO$wo^FS 
        
        ^FO10,985^GB1900,9,13^FS
        
        ^A0N,90,79^FO40,1020^FDSupplier^FS 
        ^A0N,90,79^FO40,1110^FD(S)^FS 
        
        ^CFP,110,110
        ^FO325,1030^FDBEYONICS^FS 
        
        ^FO160,1150^BY6^BCn,180,N^FDSBEYONICS^FS 
        
        ^FO1050,1000^GB9,375,5^FS 
        
        ^CFP,90,79
        ^FO1150,1020^FDModel Description^FS 
        ^FO1150,1130^FDNAVISTAR HAZARD^FS 
        ^FO1150,1210^FDSWITCH^FS 
        
        ^FO10,1375^GB1900,9,13^FS
        
        ^A0N,90,79^FO40,1460^FDCarton ID^FS 
        ^A0N,90,79^FO40,1550^FD(C)^FS 
        
        ^CFP,110,110
        ^FO345,1460^FD$box_id^FS 
        
        ^FO160,1660^BY4^BCn,180,N^FDC$box_id^FS 
        
        ^FO1100,1375^GB9,525,5^FS 
        
        ^CFP,90,79
        ^FO1200,1440^FDDate $lbldate^FS 
        ^FO1170,1560^FD(L) Lot #$lot^FS 
        
        ^FO1200,1530^GB690,9,13^FS
        
        ^FO1170,1700^BY4^BCn,140,N^FDLLOT#$lot^FS 
        
        ^FO10,1900^GB1900,9,13^FS
        ^XZ";
        echo $lblbox;
        // //function to ping ip address
        // function pingAddress($ip1) {
        //     $pingresult = exec("ping -n 2 $ip1", $outcome, $status);
        //     if (0 == $status) {//status-alive
        //         $toReturn = true;
        //     } else {//status-dead
        //         $toReturn = false;
        //     }
        //     return $toReturn;
        // }
        
        // $printable = pingAddress($ip);
        // if($printable){
        //     try//attempt to print label
        //     {
        //         // Number of seconds to wait for a response from remote host
        //         $timeout = 2;
        //         if($fp=@fsockopen($ip,9100, $errNo, $errStr, $timeout)){
        //             fputs($fp,$lblbox);
        //             fclose($fp);				
        //             echo '<script type="text/javascript">alert("Label printed successfully!");</script>';
        //             echo "<script type='text/javascript'>document.location='box.php'</script>"; 
        //         }
        //         else{
        //             echo '<script type="text/javascript">alert("Printer is not available!");</script>';
        //             echo "<script type='text/javascript'>document.location='box.php'</script>";  
        //         } 
        //     }
        //     catch (Exception $e) 
        //     {
        //         echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     }
        // }
        // else{
        //     echo '<script type="text/javascript">alert("Printer is not available!");</script>';
        //     echo "<script type='text/javascript'>document.location='box.php'</script>";  
        // }
    }
    else{
        echo "<script type='text/javascript'>alert('Box ID entered is NOT EXIST or NOT FINISHED yet!');</script>";
	    // echo "<script>window.history.back();</script>"; 
    }
?>
