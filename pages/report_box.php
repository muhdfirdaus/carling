<?php
session_start();
include('../dist/includes/dbcon.php');
/*******EDIT LINES 3-8*******/


$DB_Server = $host; //MySQL Server    
$DB_Username = $uname; //MySQL Username     
$DB_Password = $pass; //MySQL Password     
$DB_DBName = $dbname; //MySQL Database Name  
$DB_TBLName = "box_info"; //MySQL Table Name  
isset($_POST['box_id'])?$box_id =trim($_POST['box_id'], " "):$box_id ="";
isset($_POST['pallet_id'])?$pallet_id =trim($_POST['pallet_id'], " "):$pallet_id ="";
if(strlen($box_id)>1 && strlen($pallet_id)>1){
    echo "<script type='text/javascript'>alert('Please insert ONE (1) field only!');</script>";
    echo "<script>window.history.back();</script>"; 
}
elseif(strlen($box_id)>1 && strlen($pallet_id)<=1){

    //create MySQL connection   
    if(strlen($box_id)>1){
        $query = mysqli_query($con,"select count(*) as cnt from box_info where box_id='$box_id'");
        $check_id=mysqli_fetch_array($query);
        if($check_id['cnt'] > 0){
            $filename = "Box_".$box_id; //File Name
            $sql ="SELECT cb.carton_id as Pallet_ID, bi.box_id AS BoxNo, bi.qty AS quantity, bi.model as model, bs.sn AS SN, FROM_UNIXTIME(ci.timestamp) AS TIME, u.username AS USER, sm.lockTest AS Functional, sm.durTest AS Durability, sm.rfsTest AS RFS  FROM  box_sn bs LEFT JOIN box_info bi ON bi.box_id = bs.box_id LEFT JOIN USER u ON bi.user_id = u.user_id left join carton_box cb on cb.box_id=bi.box_id LEFT JOIN sn_master sm ON sm.sn = bs.sn LEFT JOIN carton_info ci ON cb.carton_id=ci.carton_id where bs.box_id='$box_id' order by bs.sn asc"; 
        }
        else{
            echo "<script type='text/javascript'>alert('No such box exist!');</script>";
            echo "<script>window.history.back();</script>";  
        } 
    }
}
elseif(strlen($box_id)<=1 && strlen($pallet_id)>1){

    //create MySQL connection   
    if(strlen($pallet_id)>1){
        $query = mysqli_query($con,"select count(*) as cnt from carton_info where carton_id='$pallet_id'");
        $check_id=mysqli_fetch_array($query);
        if($check_id['cnt'] > 0){
            $filename = "Pallet_".$pallet_id; //File Name
            $sql ="SELECT cb.carton_id as Pallet_ID, bi.box_id AS BoxNo, bi.qty AS quantity,bi.model as model,  bs.sn AS SN, FROM_UNIXTIME(ci.timestamp) AS TIME, u.username AS USER, sm.lockTest AS Functional, sm.durTest AS Durability, sm.rfsTest AS RFS FROM  box_sn bs LEFT JOIN box_info bi ON bi.box_id = bs.box_id LEFT JOIN USER u ON bi.user_id = u.user_id left join carton_box cb on cb.box_id=bi.box_id LEFT JOIN sn_master sm ON sm.sn = bs.sn LEFT JOIN carton_info ci ON cb.carton_id=ci.carton_id where cb.carton_id='$pallet_id' order by bi.box_id, bs.sn asc"; 
        }
        else{
            echo "<script type='text/javascript'>alert('No such pallet exist!');</script>";
            echo "<script>window.history.back();</script>";  
        } 
    }
}
$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
//select database   
$Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());   
//execute query 
$result = @mysql_query($sql,$Connect) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno()); 
$file_ending = "xlsx";


//header info for browser
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields
for ($i = 0; $i < mysql_num_fields($result); $i++) {
echo mysql_field_name($result,$i) . "\t";
}
print("\n");    
//end of printing column names  
//start while loop to get data
while($row = mysql_fetch_row($result))
{
    $schema_insert = "";
    for($j=0; $j<mysql_num_fields($result);$j++)
    {
        if(!isset($row[$j]))
            $schema_insert .= "NULL".$sep;
        elseif ($row[$j] != "")
            $schema_insert .= "$row[$j]".$sep;
        else
            $schema_insert .= "".$sep;
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
} 
?>