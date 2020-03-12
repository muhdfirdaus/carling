<?php
session_start();
include('../dist/includes/dbcon.php');

if(isset($_POST['check_id'])){
    $list_id = "";
    for($i=0; $i < count($_POST['check_id']); $i++)
    {
        if($i>0)
        {
            $list_id .= ", ";
        }
        $list_id .= $_POST['check_id'][$i];
    }
}
else{
    echo'<script type="text/javascript">
	alert("No item is selected");
	window.history.back();
	</script>';
}



// sql to delete a record
$sql = "DELETE FROM product WHERE equip_id in ($list_id)";

if ($con->query($sql) === TRUE) {
    echo'<script type="text/javascript">
	alert("Record deleted successfully");
	window.history.back();
	</script>';
} else {
    echo'<script type="text/javascript">
	alert("Error deleting record");
	window.history.back();
    </script>';
    // echo 'error is :'.$con->error;
}

$con->close();

?>