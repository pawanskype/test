<?php

//include_once(__DIR__ . "/../wp-config.php");
// $servername = DB_HOST;
// $username = DB_USER;
// $password = DB_PASSWORD;
// $dbname = DB_NAME;

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'wp_restorat1stg';

//Create connection

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$g_api_key = "AIzaSyC2IyuD0b-mrkm7MmQXoebVIdli6r3VZZA";