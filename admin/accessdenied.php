<?php if($role == "subadmin") { ?>
<?php 
if($currentPage == "analyticsbylocation.php" && $analyticsbylocation =="on" && $pageavailability != 1) { ?>
	<div class="access_denied">
		<h1>Oops!</h1>
        <h2>You don't have access to this page or this page is not available.</h2>
		<h3>Please <a href="#" class="back" onclick="goBack()">Go Back</a> or GO to Our <a href="<?php echo $adminurl; ?>" class="admin-go">Admin Page</a></h3> 
	</div>
<?php } elseif($analytics !="on" || $analyticsbylocation !="on" || $locations !="on" || $addlocations !="on" || $defaultglobaloptions !="on" || $settings !="on" || $media !="on" || $adminpage !="on" || (!in_array($locationid, $edlocationresultsarray))) { ?>
<?php include 'sidebar.php'; ?>
<div class="col-md-9">
<div class="access_denied">
	<h1>Oops!</h1>
        <h2>You don't have access to this page or this page is not available.</h2>
    <h3>Please <a href="#" class="back" onclick="goBack()">Go Back</a> or GO to Our <a href="<?php echo $adminurl; ?>" class="admin-go">Admin Page</a></h3> 
</div>	
</div>
<?php } else {} ?>
<?php } else { ?>
<div class="access_denied">
	<h1>Oops!</h1>
        <h2>You don't have access to this page or this page is not available.</h2>
    <h3>Please <a href="#" class="back" onclick="goBack()">Go Back</a> or GO to Our <a href="<?php echo $adminurl; ?>" class="admin-go">Admin Page</a></h3> 
</div>
<?php } ?>
