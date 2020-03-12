<?php
session_start();
$branch = $_SESSION['branch'];
include('db_con.php');

$conn = new mysqli('localhost', 'root', '');
mysqli_select_db($conn, 'inventory');

$setSql = "SELECT `ur_Id`,`ur_username`,`ur_password` FROM `tbl_user`";
$setRec = mysqli_query($conn,$setSql);

$stmt=$db_con->prepare("select equip_id,equip_name,project,equip_no,model,accuracy,rangee,manufacturer,category,location,dept,status,cert_no,creation_date,due_date,remark from product where remark='Active' and branch_id='$branch'");
$stmt->execute();


$columnHeader ='';
$columnHeader = "Equipment ID"."\t"."Equipment Name"."\t"."Project"."\t"."Equipment No."."\t"."Model"."\t"."Accuracy"."\t". "Range"."\t". "Manufacturer"."\t". "Lab"."\t". "Location"."\t". "PIC"."\t". "Interval"."\t". "Cert. No."."\t". "Creation Date"."\t". "Due Date"."\t". "Remark"."\t";


$setData='';

while($rec =$stmt->FETCH(PDO::FETCH_ASSOC))
{
  $rowData = '';
  foreach($rec as $value)
  {
    $value = '"' . $value . '"' . "\t";
    $rowData .= $value;
  }
  $setData .= trim($rowData)."\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=listing_active.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";

?>
