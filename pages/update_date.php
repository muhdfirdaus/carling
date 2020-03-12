<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT equip_id, creation_date, due_date FROM product_mod WHERE LENGTH(creation_date)<10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        // echo "id: " . $row["equip_id"]. " - Created: " . $row["creation_date"]. " - Expired: " . $row["due_date"]."new>> ". date("Y-m-d", strtotime($row["creation_date"])) ."<br>";
        $new_due = date("Y-m-d", strtotime($row["due_date"]));
        $new_cre = date("Y-m-d", strtotime($row["creation_date"]));
        $sql = 'UPDATE product SET creation_date = "'. $new_cre.'", due_date = "'.$new_due.'" where equip_id ='. $row["equip_id"];
        $conn->query($sql);
    }
} else {
    // echo "0 results";
}
$conn->close();
?>