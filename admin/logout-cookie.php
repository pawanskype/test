<?php 
include("database_class.php");	//Include MySQL database class
include("mysql_sessions.php");	
include "variables.php";

$session = new Session();

if(!empty($_COOKIE) && !empty($_COOKIE['storelocatorsessionid']) && isset($_COOKIE['storelocatorsessionid'])){
    
   $loggedinData=  $session->_read($_COOKIE['storelocatorsessionid']);

   if($loggedinData != " "){
    $session->_destroy($_COOKIE['storelocatorsessionid']);
   }

   setcookie('storelocatorsessionid',"",time()-86400, "/");

   ob_start();
   header('Location:'.$adminurl);
   ob_end_flush();

}

?>