<?php
// phpinfo();
$serverName = "10.38.7.114\\btssql"; //serverName\instanceName
$connectionInfo = array( "Database"=>"CRS_BME", "UID"=>"sa", "PWD"=>"");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>