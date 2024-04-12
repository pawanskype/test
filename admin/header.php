<?php
session_start();
ob_start();
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

?>
<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
	
	if($currentPage != "index.php" && $currentPage!='set_forget_password.php') {
		
		if($_SESSION['login'] != true) {
                ob_start();
              
          	header('Location:'.$adminurl);

             ob_end_flush();
		
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