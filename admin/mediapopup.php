<?php 
echo $media;
if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $media == "on")) { ?>
<div class="container media-pop-up">
	<div class="media-pop-up-in">
		<i class="material-icons material-close">close</i>
		<div class="col-md-9 images-block">
			<section class="content-box">
				<div class="box-title">Upload Image</div>
				<div class="form-group">
					<form id="media-pop-up" method="post" enctype="multipart/form-data" action="">
						<?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
						<?php } ?>
						<div id="image-preview"></div>
						<input type="file" name="filename" id="filename" accept="image/*">
						<input type="submit" class="btn btn-default btn-round" value="Upload Image" name="mediapopup" id="media" />
						<img id="loading" src="<?php echo $adminurl; ?>/defaultimages/progressbar.gif" alt="loading image" style="display:none;" />
					</form>
				</div>
			</section>
			<section class="content-box">
			<div class="box-title">Media Images</div>
				<div class="row">
					<div class="m-pop-up-images">
					<?php
					foreach($mediaimages as $images) { ?>
					<?php if($images !="") { ?>	
					<div class="col-sm-3">
						<div class="media">
							<img src="<?php echo $adminurl."/uploads/".$images; ?>" />
							<input type="checkbox" value="<?php echo $images; ?>" class="select-image-box <?php echo $images; ?>"/>
						</div>
					</div>
					<?php } ?>
					<?php } ?>
					</div>
				</div>
			</section>
		</div>
		<div class="col-md-3">
			<section class="content-box">
				<div class="select-image-container">
					<div class="select-image">
					<p>No image selected.</p>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<?php } ?>
