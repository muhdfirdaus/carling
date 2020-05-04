<?php 
include('../dist/includes/dbcon.php');
$id = $_POST['box_id'];
$query=mysqli_query($con,"select * from box_master where box_id='{$id}'")or die(mysqli_error($con));
$row=mysqli_fetch_array($query);

if(count($row)==0){
    echo '<script type="text/javascript">alert("Box ID is not exist!");</script>';
    echo "<script>window.history.back();</script>"; 
}
else{
    $model = $row['model'];
    $rev = $row['rev'];
    $rev_no = $row['rev_no'];
    $box_id = $row['box_id'];
    $qty = $row['qty'];
    $wo = $row['wo'];
    $lot = $row['lot'];
    $tmstmp = date("Y.m.d",$row['timestamp']);
    $desc = "";
    if(strpos($model, '10047-001')!== false){
        $desc = "^A0N,20,20^FO350,380^FDLIN SWITCH RED FUNCTION^FS 
        ^A0N,20,20^FO350,405^FDLED REV.J (SWITCH ^FS 
        ^A0N,20,20^FO350,430^FDMODULE -LIN SLAVE)^FS ";
    }
    elseif(strpos($model, '10047-002')!== false){
        $desc = "^A0N,20,20^FO350,380^FDLIN SWITCH GREEN FUNCTION^FS 
        ^A0N,20,20^FO350,405^FDLED REV.J (SWITCH ^FS 
        ^A0N,20,20^FO350,430^FDMODULE -LIN SLAVE)^FS ";
    }
    elseif(strpos($model, '10047-003')!== false){
        $desc = "^A0N,20,20^FO350,380^FDLIN SWITCH NO FUNCTION^FS 
        ^A0N,20,20^FO350,405^FDLED REV.J (SWITCH ^FS 
        ^A0N,20,20^FO350,430^FDMODULE -LIN SLAVE)^FS ";
    }
    elseif(strpos($model, '10047-101')!== false){
        $desc = "^A0N,20,20^FO350,380^FD942-10047-101_H (Switch ^FS 
        ^A0N,20,20^FO350,405^FDBoard-DAF-KAMAZ)^FS ";
    }
    elseif(strpos($model, '10046')!== false){
        $desc = "^A0N,20,20^FO350,380^FDLIN MASTER MODULE ^FS 
        ^A0N,20,20^FO350,405^FDBom Rev.N ^FS 
        ^A0N,20,20^FO350,430^FD(Note : set as Phantom)^FS ";
    }
    elseif(strpos($model, '10049')!== false){
        $desc = "^A0N,20,20^FO350,380^FDSLAVE CARRIER  ^FS 
        ^A0N,20,20^FO350,405^FDBOARD (Rev E)^FS ";
    }
    elseif(strpos($model, '10048-001')!== false){
        $desc = "^A0N,20,20^FO350,380^FDSWITCH MODULE LIN SLAVE^FS ";
    }
    elseif(strpos($model, '10067-001')!== false){
        $desc = "^A0N,20,20^FO350,380^FDHALO SWITCH Blue ^FS 
        ^A0N,20,20^FO350,405^FDHalo - Red Indicators (Rev.G)^FS  ";
    }
    elseif(strpos($model, '10067-003')!== false){
        $desc = "^A0N,20,20^FO350,380^FDHALO SWITCH Blue ^FS 
        ^A0N,20,20^FO350,405^FDHalo - White Indicators (Rev.G)^FS  ";
    }

    $lbl = "^XA 

    ^FO5,5^GB630,2,3^FS

    ^A0N,28,25^FO20,20^FDModel - Rev^FS 
    ^A0N,28,25^FO20,55^FD(M)^FS 

    ^A0N,45,25^FO180,30^FD$model-$rev-$rev_no^FS 

    ^FO75,85^BY2^BCn,60,N^FDP$model-$rev-$rev_no^FS 

    ^FO5,160^GB630,2,3^FS

    ^A0N,28,25^FO20,180^FDQuantity^FS 
    ^A0N,28,25^FO20,215^FD(Q)^FS 

    ^A0N,45,25^FO160,185^FD$qty^FS 

    ^FO75,240^BY2^BCn,60,N^FDQ$qty^FS 

    ^FO300,160^GB2,160,3^FS 

    ^A0N,28,25^FO350,180^FDWO^FS 
    ^A0N,28,25^FO350,210^FD(O)^FS 

    ^A0N,45,25^FO420,185^FD$wo^FS 

    ^FO330,240^BY2^BCn,60,N^FDK$wo^FS 

    ^FO5,320^GB630,2,3^FS

    ^A0N,28,25^FO20,340^FDSupplier^FS 
    ^A0N,28,25^FO20,375^FD(S)^FS 

    ^A0N,45,25^FO140,350^FDBEYONICS^FS 

    ^FO40,405^BY2^BCn,60,N^FDVBEYONICS^FS 

    ^FO320,320^GB2,160,3^FS 

    ^A0N,20,20^FO350,350^FDModel Description^FS 
    $desc

    ^FO10,480^GB630,2,3^FS

    ^A0N,28,25^FO20,490^FDCarton ID^FS 
    ^A0N,28,25^FO20,525^FD(C)^FS 

    ^A0N,45,25^FO140,500^FD$box_id^FS 

    ^FO40,550^BY2^BCn,60,N^FDS$box_id^FS 

    ^FO445,480^GB2,150,3^FS 
    
    ^A0N,20,20^FO450,500^FDDate $tmstmp^FS 
    ^A0N,20,20^FO450,530^FD(L) Lot #$lot^FS 
    
    ^FO450,520^GB200,2,3^FS
    
    ^FO450,560^BY2^BCn,50,N^FDT$lot^FS 
    
    ^XZ";



    $filename = "lbl203.txt";
    $file = fopen($filename, "r+")or die("ERROR: Cannot open the file .")  ;
    if($file){
        fwrite($file, $lbl);      
        fclose($file);
    } 

    //print label
    copy($filename, "//PPS71001/z4mcarl");     
    echo "<script>document.location='box_start.php'</script>";   
}  
?>