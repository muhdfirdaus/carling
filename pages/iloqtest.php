<?php 
$model_no2 = "M010172.10.1.SB.SE_P";
$box_id = "BEY7550";
$lbldate = "28/02/20";

    $lbl = "^XA
    ^CFP,200,139
    ^FO60,80^FD'.$model_no2.'^FS
    
    ^CFP,190,230
    ^FO40,320^FD'.$box_id.'^FS
    ^FO38,320^FD'.$box_id.'^FS
    ^FO40,322^FD'.$box_id.'^FS
    
    ^CFP,200,210
    ^FO40,560^FD'.$lbldate.'^FS
    
    ^XZ";



    $filename = "lbliloq.txt";
    $file = fopen($filename, "r+")or die("ERROR: Cannot open the file .")  ;
    if($file){
        fwrite($file, $lbl);      
        fclose($file);
    } 

    //print label
    copy($filename, "//BTS-iLOQ-1/iloqpizza");     
    // echo "<script>document.location='box_start.php'</script>";   

?>