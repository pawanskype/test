<?php 
   include "header.php"; ?>
 <style>
.custom-select > div ul li {
    color: #000;
}
</style> 
  <body class="admin-panel" onLoad="initialize()">
         <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $addlocations == "on")) { ?>
      <div class="row no-gutter">
	   <?php include 'sidebar.php'; ?>
		<div class="col-md-9">
          <div class="content-wrapper">
		    <h1 class="page-title">Add A Custom Zipcode</h1>
             <?php if(isset($_SESSION['msg_error'])) { ?>
				<div class = "alert alert-danger alert-dismissable">
					<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
					&times;
					</button>
					<?php echo $_SESSION['msg_error']; unset($_SESSION['msg_error']); ?>
				</div>
				<?php } elseif(isset($_SESSION['msg_succ'])) { ?>
				<div class = "alert alert-success alert-dismissable">
				<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
				&times;
				</button>
				<?php echo $_SESSION['msg_succ']; unset($_SESSION['msg_succ']); ?>
				</div>
				<?php } ?>	
				<form id="location-add" enctype="multipart/form-data" method="post" action="inc/submit.php">
				<?php if($role == 'superadmin') { ?>
				<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
				<?php } ?>
				<section class="content-box">
				
					<div class="box-title">Zipcode Information</div>
					<section class="content-box">					
					<div class="add-review">
						<!--<div class="review-group-container11">
							<div class="review-group">-->
							<div class="form-group">
							<label for="packagename">Parent location<span class="required-star">*</span></label>
							 <select id='standard' name='loc_id' class='custom-select'>
								<option value=''>Please Select</option>
								<?php foreach($parentnamedata as $parentnamedatas){ ?>
								<option value="<?php echo $parentnamedatas['id']; ?>" ><?php echo $parentnamedatas['name']; ?></option>
								<?php } ?>
							  </select>
							</div>
								<div class="form-group">
									<label for="buttontitle1">Location Name</label>
									<input type="text" id="buttontitle1" name="zip_name" class="form-control" placeholder="Enter location name" required />
								</div>
								<div class="form-group">
									<label for="buttonlink1">Zip Code</label>
									<input type="text" id="buttonlink1" name="zipcode" class="form-control" placeholder="Enter zipcode (ex. 45623,45652)" required />
									<span>More zipcode enter by comma. e.g 45623,45652 and no space </span></br>
									<span>*IN 4 digit zipcode not added 0 LPAD</span>
								</div>
								<div class="form-group">
									<label for="buttonlink1">City</label>
									<input type="text" id="buttonlink1" name="city" class="form-control" placeholder="Enter City" />
								</div>
								<div class="form-group">
									<label for="buttonlink1">State</label>
									<input type="text" id="buttonlink1" name="state" class="form-control" placeholder="Enter State" />
								</div>
								<div class="form-group">
									<label for="buttonlink1">county</label>
									<input type="text" id="buttonlink1" name="country" class="form-control" placeholder="Enter county" />
								</div>
								
								<div class="form-group">
									<label for="pagecontent">Page Content</label>
									<textarea type="text" class="form-control tinymce" id="page-content" name="page_content">
									</textarea>
								</div>
							<!--</div>
						</div>
						<button class="btn btn-default btn-round" id="add-review-btn-zip">Add More</button>-->
					</div>
				</section>
				<div class="submit-section">
					<div class="add-location-btn"><input type="submit" name="addZip" id="addLocation" class="btn btn-primary" value="Add Zipcode" /></div>
				</div>
				</form>
			</div>
			<!-- /.content-wrapper -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	<?php include "mediapopup.php"; ?>
	<?php } else { ?>
	<?php include "accessdenied.php"; ?>
	<?php } ?>
	</div>
    </div><!-- /.container -->

  	<?php include 'footer.php'; ?>
<script>
	 $(function() {
        $("#standard").customselect();
      });
	</script>
