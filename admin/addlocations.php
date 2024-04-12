<?php include "header.php"; 
?>
  
  <body class="admin-panel">
       <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $addlocations == "on")) { ?>
      <div class="row no-gutter">
	   <?php include 'sidebar.php'; ?>
		<div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">Add Locations</h1>
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
				<section class="content-box">
					<div class="bulk-box">
						<div class="box-title">Add a custom Location</div>
						<p> Add a custom location by clicking the button below.</p>
						<a href="addlocationcustom" class="btn btn-default btn-round">Add A Custom Location</a>
					</div> 
					<div class="bulk-box">
						<div class="box-title">BULK UPLOAD</div>
						<p>Bulk upload your locations by uploading a populated Bulk Upload Template. The system supports only .xls file type.</p>
						<?php if($role == 'superadmin') { ?>
							<div class="select-business-add-location">
								Select Business
								<select class="locationchange">
								<?php $i = 0; while($selectdata = mysqli_fetch_assoc($selectadmin)) {
										$i++;
										echo '<option value='.$adminurl.'/addlocations?adminid='.$selectdata['adminid'].''.(($selectdata['adminid']==$_GET['adminid'])?' selected':'').'>'.$selectdata['business'].'</option>';
										if($i == 1) {
											$adminid = $selectdata['adminid'];
										}
									}
									?>
								</select>	
							</div>
						<?php if($_GET['adminid'] =="") { ?>
						<script>
							var currentbusiness = "<?php echo $adminurl.'/addlocations?adminid='.$adminid; ?>";
							window.location.href = currentbusiness;
						</script>
						<?php } ?>
					<?php } ?>
						<form enctype="multipart/form-data" action="inc/read.php" method="POST" id="file-add">
                                              
							<input type="file" name="xl" id="file_excel" accept=".xls" />
                                                        <input type="hidden" name="business_select" value="<?php echo !empty($_GET['adminid']) ? $_GET['adminid'] : ""; ?>">
							<input type="submit" name="sub" class="btn btn-primary" value="Upload" />
						</form>  
					</div>
					<div class="bulk-box-excel">
						<div class="box-title">BULK UPLOAD TEMPLATE</div>
						<p>To bulk upload locations please download the Bulk Upload Template, populate it, then upload it above.</p>
						<a href="excel/locations.xls" class="btn btn-success" download><span class="glyphicon glyphicon-save"></span> Download</a>
					</div>
				</section>
          </div><!-- /.content-wrapper -->
        </div><!-- /.col -->
      </div><!-- /.row -->
	<?php } else { ?>
	<?php include "accessdenied.php"; ?>
	<?php } ?>
    </div><!-- /.container -->

	<?php include 'footer.php'; ?>
