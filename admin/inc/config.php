<?php
// include_once(__DIR__ . "/../../../wp-config.php");
// $servername = DB_HOST;
// $username = DB_USER;
// $password = DB_PASSWORD;
// $dbname = DB_NAME;

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'wp_restorat1stg';

//Create connection

$con = mysqli_connect($servername, $username, $password, $dbname);

//Check Connection
if(mysqli_connect_errno()) {
	echo "MySQL database connection failed : " . mysqli_connect_error();
}


$domainurl = "/store-locator/";
$adminurl = $domainurl."admin";
$adminhome = $domainurl."admin/locations.php?adminid=50";
$scripturl = $domainurl."script";


?>
