<?php
		
// print_r($_COOKIE);die();
// session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');


function random_str($length = 32)
{
    return bin2hex(openssl_random_pseudo_bytes($length / 2));
}
 
$length = 32;
$rand_str = random_str($length);



if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "http")  {
	if($_server['HTTPS'] != "on") {
		$redirect = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		
		ob_start();
		header('Location:'.$redirect);
		ob_end_flush();
	}
}

?>
<?php include "variables.php"; 

include("database_class.php");	//Include MySQL database class
include("mysql_sessions.php");	//Include PHP MySQL sessions
// $session = new Session();
$session = new Session();
?>
<?php

    $currentPage = basename($_SERVER['PHP_SELF']);
	
	if($currentPage != "index.php" && $currentPage !='set_forget_password.php') {
		// echo $_COOKIE['storelocatorsessionid'].'cookie';
		// echo 'other pages are call'; die;

		if(empty($_COOKIE['storelocatorsessionid']) && !isset($_COOKIE['storelocatorsessionid'])){	
						
						 ob_start();
			          	header('Location:'.$adminurl);
			            ob_end_flush();
					
		}	

		if(isset($_COOKIE['storelocatorsessionid'])){
			// print_r($_COOKIE);die();
// print_r($_COOKIE['storelocatorsessionid']);die();
		  $user_logged_in_with_repsect_to_this_cookie_id =	$session->_read($_COOKIE['storelocatorsessionid']);

		  if($user_logged_in_with_repsect_to_this_cookie_id == ' '){
			
			ob_start();
			header('Location:'.$adminurl);
		    ob_end_flush();

		  }
           $cookie_data = unserialize($user_logged_in_with_repsect_to_this_cookie_id);
		   $cookie_creation_time = $cookie_data['creationTime'];
		   $extend_time = strtotime('+1 day', $cookie_creation_time);
        //    $extend_time = '1689329563';
		  if( $extend_time < time()){
			$session->_destroy($_COOKIE['storelocatorsessionid']);
			setcookie('storelocatorsessionid',$phpsessionID,time()+86400, "/");
			ob_start();
			header('Location:'.$adminurl);
		    ob_end_flush();
		  }

		  
		}
		
		
	}
	
	
?>
<!DOCTYPE html>
<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<title>Admin Panel</title>
		<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900,900italic' rel='stylesheet' type='text/css' />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet" />
		<link href="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
		<link href="<?php echo $adminurl; ?>/css/datepicker.css" rel="stylesheet" />
		<link href="<?php echo $adminurl; ?>/css/adminstyle.css" rel="stylesheet" />
		<?php if($currentPage == "editzipcode.php" || $currentPage == "addcustomezipcode.php") { ?>
		<link href="<?php echo $adminurl; ?>/css/jquery-customselect.css" rel="stylesheet" />
		<?php } ?>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
		<?php if($currentPage == "addlocationcustom.php" || $currentPage == "locationsedit.php" || $currentPage == "locations.php" || $currentPage == "locationsbrand.php") { ?>
		
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2IyuD0b-mrkm7MmQXoebVIdli6r3VZZA"></script>
		<?php } ?>

	         </head>