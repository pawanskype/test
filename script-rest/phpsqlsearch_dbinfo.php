<?php
$hostname = "localhost:3306";
$username = "r1cpanel_wp_tih1q";
$password = "0~rXi_PG70?zQ9B&";
$database = "r1cpanel_wp_kj2e9";
$conn = mysqli_connect($hostname, $username, $password, $database);

if(mysqli_connect_errno($conn)) {
	echo "Mysql database connection failed" . mysqli_connect_error();	
}

?>
