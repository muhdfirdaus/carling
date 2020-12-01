<?php 
include('../dist/includes/dbcon.php');
$id = $_GET['id'];
$query=mysqli_query($con,"select * from box_master where box_id='{$id}'")or die(mysqli_error($con));
$row=mysqli_fetch_array($query);

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
elseif(strpos($model, '10027-001')!== false){
    $desc = "^A0N,20,20^FO350,380^942-10027-001 rev.H Bom^FS ";
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
elseif(strpos($model, '10047-131')!== false){
    $desc = "^A0N,20,20^FO350,380^FD942-10047-131 Red LED ^FS 
    ^A0N,20,20^FO350,405^FDRev.J (Switch ^FS  
    ^A0N,20,20^FO350,430^FDBoard-DAF-KAMAZ)^FS ";
}
elseif(strpos($model, '10047-136')!== false){
    $desc = "^A0N,20,20^FO350,380^FD942-10047-136_J Bom ^FS 
    ^A0N,20,20^FO350,405^FDGreen \ Amber LED^FS  ";
}
elseif(strpos($model, '10046-005')!== false){
    $desc = "^A0N,20,20^FO350,380^FDLIN MASTER MODULE ^FS 
    ^A0N,20,20^FO350,405^FDBom Rev.P ^FS 
    ^A0N,20,20^FO350,430^FD(Note : set as Phantom)^FS ";
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
    $desc = "^A0N,20,20^FO350,380^FDRheostat BOM Rev.H^FS
    ^A0N,20,20^FO350,405^FD(SWITCH MODULE-LIN SLAVE)^FS ";
}
elseif(strpos($model, '10048-002')!== false){
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
elseif(strpos($model, '10053-001')!== false){
    $desc = "^A0N,20,20^FO350,380^FDFinish Goods with ^FS 
    ^A0N,20,20^FO350,405^FDCoating (Project 4033-001,^FS 
    ^A0N,20,20^FO350,430^FDHazard Switch)^FS ";
}
elseif(strpos($model, '10067-005')!== false){
    $desc = "^A0N,20,20^FO350,380^FDHALO SWITCH Blue^FS 
    ^A0N,20,20^FO350,405^FDHalo - Orange Indicators^FS 
    ^A0N,20,20^FO350,430^FD(Rev.G)^FS ";
}
elseif(strpos($model, '10067-011')!== false){
    $desc = "^A0N,20,20^FO350,380^FDHALO SWITCH Green^FS 
    ^A0N,20,20^FO350,405^FDHalo - Orange Indicators^FS 
    ^A0N,20,20^FO350,430^FD(Rev.G)^FS ";
}
elseif(strpos($model, '10067-012')!== false){
    $desc = "^A0N,20,20^FO350,380^FDHALO SWITCH Blue ^FS 
    ^A0N,20,20^FO350,405^FDHalo (Rev.G)^FS  ";
}
elseif(strpos($model, '10128-002')!== false){
    $desc = "^A0N,20,20^FO350,380^FDElectronics Package^FS 
    ^A0N,20,20^FO350,405^FD(942-10128-002)^FS  ";
}
elseif(strpos($model, '10128-003')!== false){
    $desc = "^A0N,20,20^FO350,380^FDElectronics Package^FS 
    ^A0N,20,20^FO350,405^FD(942-10128-003)^FS  ";
}
elseif(strpos($model, '10129-001')!== false){
    $desc = "^A0N,20,20^FO350,380^FD942-10129-001 Polaris^FS 
    ^A0N,20,20^FO350,405^FD(Carling)^FS  ";
}
elseif(strpos($model, '10047-102')!== false){
    $desc = "^A0N,20,20^FO350,380^FD942-10047-102_J Bom^FS 
    ^A0N,20,20^FO350,405^FD(Amber LED)^FS  ";
}
elseif(strpos($model, '10161-001')!== false){
    $desc = "^A0N,20,20^FO350,380^FD4045-001 Polaris^FS 
    ^A0N,20,20^FO350,405^FDLED Board^FS  ";
}
elseif(strpos($model, '10161-003')!== false){
    $desc = "^A0N,20,20^FO350,380^FD4045-001 Polaris^FS 
    ^A0N,20,20^FO350,405^FDLED Board^FS  ";
}
elseif(strpos($model, '10085-003')!== false){
    $desc = "^A0N,20,20^FO350,380^FDHALO SWITCH Blue ^FS 
    ^A0N,20,20^FO350,405^FDHalo - White Indicators (Rev.J)^FS  ";
}
elseif(strpos($model, '10169-001')!== false){
    $desc = "^A0N,20,20^FO350,380^FDPCBA, Polaris^FS 
    ^A0N,20,20^FO350,405^FDDriver Modes Switch^FS  ";
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
?>