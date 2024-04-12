<?php include "header.php"; ?>
 <style>
.custom-select > div ul li {
    color: #000;
}
</style> 
  <body class="admin-panel">
    <div class="container admin-body">
	<?php if($role == "superadmin") { ?>
      <div class="row no-gutter">
	   <?php include 'sidebar.php'; ?>
		<div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">Edit Zipcode</h1>
             <?php if(isset($_SESSION['msg_error'])) { ?>
				<div class = "alert alert-danger alert-dismissable">
					<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">&times;</button>
					<?php echo $_SESSION['msg_error']; unset($_SESSION['msg_error']); ?>
				</div>
				<?php } elseif(isset($_SESSION['msg_succ'])) { ?>
				<div class = "alert alert-success alert-dismissable">
				<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">&times;</button>
				<?php echo $_SESSION['msg_succ']; unset($_SESSION['msg_succ']); ?>
				</div>
				<?php } ?>	
				<section class="content-box">
					<div class="box-title">Edit A Zipcode</div>
					<form action="inc/submit.php" id="addazipcode" method="post">
						<input type="hidden" name="zipcodeid" value="<?php echo $_GET['zipcodeid']; ?>" />
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
						<div class="form-group">
							<label for="packagename">Parent location<span class="required-star">*</span></label>
							 <select id='standard' name='locid' class='custom-select'>
								<option value=''>Please Select</option>
								<?php 
								
								foreach($parentnamedata as $parentnamedatas){ ?>
								<option value="<?php echo $parentnamedatas['id']; ?>" <?php if($zipcodesdata['loc_id'] == $parentnamedatas['id']){ echo 'selected'; } ?> ><?php echo $parentnamedatas['name']; ?></option>
								<?php } ?>
							  </select>
						</div>
						<div class="form-group">
							<label for="packagename">Location Name<span class="required-star">*</span></label>
							<input type="text" class="form-control" name="zipname" id="zipname" placeholder="Enter Location Name" value="<?php echo $zipcodesdata['zip_name']; ?>" required />
						</div>
						<div class="form-group">
							<label for="packagename">Zipcode<span class="required-star">*</span></label>
							<input type="text" class="form-control" name="zipcode" id="zipcode" placeholder="Enter zipcode Name" value="<?php echo $zipcodesdata['zipcode']; ?>" required />
							<span>More zipcode enter by comma. e.g 45623,45652 and no space </span></br>
							<span>*IN 4 digit zipcode not added 0 LPAD</span>
						</div>
						<div class="form-group">
							<label for="packagename">City Name<span class="required-star">*</span></label>
							<input type="text" class="form-control" name="city" id="city" placeholder="Enter City Name" value="<?php echo $zipcodesdata['city']; ?>" required />
						</div>
						<div class="form-group">
							<label for="packagename">State Name<span class="required-star">*</span></label>
							<input type="text" class="form-control" name="state" id="state" placeholder="Enter Country Name" value="<?php echo $zipcodesdata['state']; ?>" required />
						</div>
						<div class="form-group">
							<label for="packagename">County Name</label>
							<input type="text" class="form-control" name="country" id="country" placeholder="Enter Country Name" value="<?php echo $zipcodesdata['country']; ?>" />
						</div>
						<div class="form-group">
							<label for="pagecontent">Page Content</label>
							<textarea type="text" class="form-control tinymce" id="page-content" name="page_content">
							<?php echo $zipcodesdata['page_content']; ?></textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="updatezipcode" id="updatezipcode" class="btn btn-primary btn-md" value="Update Zipcode" />
						</div>
					</form>
				</section>
          </div><!-- /.content-wrapper -->
        </div><!-- /.col -->
      </div><!-- /.row -->
	<?php } else { ?>
	<?php include "accessdenied.php"; ?>
	<?php } ?>
    </div><!-- /.container -->
	<?php include 'footer.php'; ?>
	<script>
	 $(function() {
        $("#standard").customselect();
      });
	</script>
