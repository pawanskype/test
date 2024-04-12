<?php include "header.php"; ?>
  <body class="admin-panel">
         <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $defaultglobaloptions == "on")) { ?>
      <div class="row no-gutter">
	   <?php include 'sidebar.php'; ?>
        <div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">Default Global Options</h1>
			<section class="content-section">
            <p>Default Global Option will apply the sections to all locations which will be empty. However you can overide any section by checking the overide option.</p>
				<?php if($role == 'superadmin') { ?>
				<div class="select-business">
					<strong>Select Business</strong>
					<select class="locationchange">
						<?php $i = 0; while($selectdata = mysqli_fetch_assoc($selectadmin)) {
							$i++;
							echo '<option value='.$adminurl.'/defaultglobaloptions?adminid='.$selectdata['adminid'].''.(($selectdata['adminid']==$_GET['adminid'])?' selected':'').'>'.$selectdata['business'].'</option>';
							if($i == 1) {
								$adminid = $selectdata['adminid'];
							}
						}
						?>
					</select>	
				</div>
				<?php if($_GET['adminid'] =="") { ?>
				<script>
					var currentbusiness = "<?php echo $adminurl.'/defaultglobaloptions?adminid='.$adminid; ?>";
					window.location.href = currentbusiness;
				</script>
				<?php } ?>
				<?php } ?>
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
					<div class="clearfix"></div>
					<form id="global-options-default-title" method="POST" action="inc/submit.php" enctype="multipart/form-data">   
						<?php if($role == 'superadmin') { ?>
								<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
								<?php } ?>
								<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
						<section class="content-box">							
								<div class="box-title">Canconical Url</div>
									<div class="add-service-location-page">
										<div class="add-service-container">
											<div class="form-group">
													<label for="defaulttitle">Canonical</label>
														<input type="text" id="canonical" name="canonical_url" class="form-control" value="<?php echo !empty($canonical) ? $canonical : ""; ?>" placeholder="Enter url here" />
											</div>						
										</div>
									</div> 
								<div class="add-field-btn">
								<div class="add-location-btn"><input type="submit" name="canonical_url_btn" id="update_default_canonical" class="btn btn-primary" value="Update Canonical Url" /></div>
								</div>
							</section>
						</form>
					<?php if($get_id_global != "") { ?>
					<?php if($editavailablity == 1) { ?>
					<section class="content-box">
						<div class="box-title">Edit Holiday</div>
						<form id="global-options" method="POST" action="inc/submit.php">
						<?php if($role == 'superadmin') { ?>
							<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
						<?php } ?>
							<input type="hidden" name="holiday_id" value="<?php echo $get_id_global; ?>">
							<div class="form-group">
								<label for="holidayname">Holiday Name</label>
								<input type="text" id="holidayname" name="festname" class="form-control" value="<?php echo $holidayfetch_global['festname']; ?>" placeholder="Enter Holiday Name (ex. Happy New Year)" />
							</div>
							<div class="form-group">
								<label class="control-label" for="datepicker">You can close all locations on a specific holiday by selecting date below.</label>
								<input type="text" id="datepicker" name="date" data-date-format='dd-mm-yy' class="form-control datepicker" value="<?php echo date('d-m-Y', strtotime($holidayfetch_global['holiday_date'])); ?>" placeholder="Enter Date (Format: dd-mm-yyyy)" />
							</div>
							<input type="submit" class="btn btn-primary" name="update_date" Value="Update Holiday">
						</form>
						</section>
					<?php } else { ?>
					<div class="no-permission-holiday">
					<?php include "accessdenied.php"; ?>
					</div>
					<?php } ?>
					<?php } else { ?>
					<section class="content-box">
					<div class="box-title">Add Holiday</div>
					<form id="global-options" method="POST" action="inc/submit.php">
					<?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					<?php } ?>
						<input type="hidden" name="locationid" value="<?php echo $_GET['id']; ?>">
						<div class="form-group">
							<label for="holidayname">Holiday Name</label>
							<input type="text" id="holidayname" name="festname" class="form-control" placeholder="Enter Holiday Name (ex. Happy New Year)" />
						</div>
						<div class="form-group">
							<label class="control-label" for="datepicker">You can close all locations on a specific holiday by selecting date below.</label>
							<input type="text" id="datepicker" name="date" data-date-format='dd-mm-yy' class="form-control datepicker" placeholder="Enter Date (Format: dd-mm-yyyy)" />
						</div>
						<input type="submit" class="btn btn-primary" name="send_date" Value="Add Holiday" />
					</form>
					</section>
					<?php } ?>
					<section class="content-box">
					<div class="table-responsive">
						<form action="inc/submit.php" method="post">
						<?php if($role == 'superadmin') { ?>
							<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
						<?php } ?>
							<table id="holiday-table" class="table table-striped table-bordered user-entries" width="100%">
							<input type="checkbox" id="checkAll" class="custom-check">
								<thead>
								<tr>
									<th></th>
									<th class="sort-icons">Sr.No<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i></th>
									<th class="sort-icons">Holiday Name<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i></th>
									<th class="sort-icons">Holiday Date<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i></th>
									<th class="sort-icons">Edit Holiday<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i></th>
								</tr>
								</thead>
								<tbody class="list">
							  <?php 
								mysqli_data_seek($holiday, 0);
								$i = 1; while($holiday_data = mysqli_fetch_assoc($holiday)) {?>
								<tr>
								<td>
									<div class="checkbox">
									<label><input type="checkbox" class="checkbox" name="check[]" value="<?php echo $holiday_data['id']; ?>"></label>
									</div>
								</td>
								<td><?php echo $i++; ?></td>
								<td><?php echo $holiday_data['festname']; ?></td>
								<td><?php echo date('d-m-Y', strtotime($holiday_data['holiday_date'])); ?></td>
								<td><a href="defaultglobaloptions?<?php if($role == "superadmin") { echo "adminid=".$_GET['adminid']."&"; }?>edit=<?php echo $holiday_data['id']; ?>"><span class="icon-edit"><i class="fa fa-edit"></i></span></a></td>                      
								</tr>
								<?php } ?>
								</tbody>
							</table>
							<div class="remove-selected-users">
								<input type="submit" class="btn btn-danger delete" value="Delete Holiday(s)" name="sub_holiday" />
							</div>
						</form>
					</div>
					</section>
					<section class="content-box">
					<div class="box-title">Contact Form</div>
					<form id="contact-form" method="POST" action="inc/submit.php">
					<?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					<?php } ?>
						<div class="form-group">
							<label for="form_title">Form Title (Default: FREE CONSULTATION)</label>
							<input type="text" id="form_title" name="form_title" class="form-control" placeholder="Enter Form Title (ex. FREE CONSULTATION)" value="<?php echo $form_title; ?>" />
						</div>
						<div class="form-group">
							<label class="button_text" for="button_text">Button Text (Default: Submit)</label>
							<input type="text" id="button_text" name="button_text" class="form-control" placeholder="Enter Button Text (ex. Submit)" value="<?php echo $button_text; ?>" />
						</div>
						<div class="form-builder">
							<div class="form-builder-in">
								<div class="form-builder-top">
                                                                    <div class="alert alert-danger fade in alert-dismissable select_tag_error_div" style="display:none">
                                                                       <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                                                          <span id="select_tag_error"></span> 
                                                                    </div>
                                                                      
								<?php if(count(array_filter($forminput)) > 0) { ?>
								<div class="row">
									<div class="form-group">
										<div class="col-sm-4">
											<label>Select Form Tag</label>
										</div>
										<div class="col-sm-4">
											<label>Enter Placeholder/Label/Options</label>
										</div>
										<div class="col-sm-2">
											<div class="text-center">
												<label>Is required?</label>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="text-right"><label>Remove Field</label></div>
										</div>
									</div>
								</div>
								<?php } ?>
								</div>
								<div class="form-builder-bottom">
								<?php $contactform = array();
								$a=0;

								for($a=0;$a<count($forminput);$a++){ 
								    $contactform[$a]['forminput'] = $forminput[$a];
								    $contactform[$a]['formplaceholder'] = $formplaceholder[$a];
								    $contactform[$a]['formrequired'] = $formrequired[$a];
								?>
                                                                
								<?php if(count(array_filter($forminput)) > 0) { ?>
									    <div class="row">
										<div class="form-group">
											<div class="col-sm-4">
												<select class="form-control select_tag" name="forminput[]" id="select_tag">
													<option value="text"<?php if($contactform[$a]['forminput'] == "text") { echo " selected"; } ?>>Text</option>
													<option value="checkbox"<?php if($contactform[$a]['forminput'] == "checkbox") { echo " selected"; } ?>>Checkbox</option>
													<option value="date"<?php if($contactform[$a]['forminput'] == "date") { echo " selected"; } ?>>Date</option>
													<option value="email"<?php if($contactform[$a]['forminput'] == "email") { echo " selected"; } ?>>Email</option>
													<option value="file"<?php if($contactform[$a]['forminput'] == "file") { echo " selected"; } ?>>File</option>
													<option value="number"<?php if($contactform[$a]['forminput'] == "number") { echo " selected"; } ?>>Number</option>
													<option value="tel"<?php if($contactform[$a]['forminput'] == "tel") { echo " selected"; } ?>>Tel</option>
													<option value="url"<?php if($contactform[$a]['forminput'] == "url") { echo " selected"; } ?>>Url</option>
													<option value="select"<?php if($contactform[$a]['forminput'] == "select") { echo " selected"; } ?>>Select</option>
													<option value="textarea"<?php if($contactform[$a]['forminput'] == "textarea") { echo " selected"; } ?>>Textarea</option>
                                                                                                        <!--<option value="radio"<?php //if($contactform[$a]['forminput'] == "radio") { echo " selected"; } ?>>Radio</option>-->
												</select>
											</div>
											<div class="col-sm-4">
												<div class="enter_plo">
                                                                                                        <textarea class="form-control select_text" placeholder="<?php if($contactform[$a]['forminput']!='select'){ echo "Placeholder/Label/Options";}else{ echo "E.g option/option2";} ?>" name="formplaceholder[]"><?php echo $contactform[$a]['formplaceholder']; ?></textarea>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="is_required_checkbox">
													<select class="form-control" name="formrequired[]" ><option value="no"<?php if($contactform[$a]['formrequired'] == "no") { echo " selected"; } ?>>No</option><option value="yes"<?php if($contactform[$a]['formrequired'] == "yes") { echo " selected"; } ?>>Yes</option></select>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="remove-form-field">
													<i class="fa fa-window-close remove_input" aria-hidden="true"></i>
												</div>
											</div>
										</div>
									</div> 
									<?php } ?>
								<?php } ?>
								</div> 
							</div>
						</div>
						<div class="add_field_btn_wrap">
							<button class="btn btn-default btn-round" id="add_form_field">Add Field</button>
						</div>
						<div class="add-field-btn">
							<input type="submit" class="btn btn-primary" name="contact_form" Value="Update Form Options" />
						</div>		
					</form>
					</section>
					<section class="content-box">
				     <form id="global-options-business-hours" method="POST" action="inc/submit.php" enctype="multipart/form-data">
					<?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					<?php } ?>
					<section class="content-box">
					<label for="business_hours">Override default business hours. <input type="checkbox" id="business_hours" name="business_hours" <?php echo ($business_hours_global == 'on' ? 'checked' : '');?> /></label>
					<div class="box-title">Business Hours</div>
					<div class="form-horizontal">
					<div class="form-group">
						<input type="hidden" name="id" id="id_global" value="<?php  echo $admin_id;  ?>">
                                                <input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
						<label class="col-sm-2 control-label" for="sunot">Sunday</label>
						<div class="col-sm-4">
						<select class="form-control" name="sunot">
						<option value="3:00 AM" <?php if($sunot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($sunot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($sunot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($sunot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($sunot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($sunot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($sunot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($sunot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($sunot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($sunot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($sunot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($sunot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($$sunot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($$sunot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($sunot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($sunot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($$sunot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($$sunot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($sunot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($sunot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($sunot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($sunot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($sunot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($sunot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($sunot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($sunot_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($sunot_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($sunot_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($sunot_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($sunot_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($sunot_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($sunot_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($sunot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($sunot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($sunot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($sunot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($sunot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($sunot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($sunot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($sunot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($sunot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($sunot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($sunot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($sunot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($sunot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($sunot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($sunot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($sunot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="sunct">
						<option value="3:00 AM" <?php if($sunct_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($sunct_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($sunct_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($sunct_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($sunct_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($sunct_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($sunct_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($sunct_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($sunct_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($sunct_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($sunct_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($sunct_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($sunct_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($sunct_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($sunct_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($sunct_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($sunct_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($sunct_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($sunct_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($sunct_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($sunct_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($sunct_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($sunct_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($sunct_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($sunct_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($sunct_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($sunct_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($sunct_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($sunct_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($sunct_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($sunct_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($sunct_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($sunct_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($sunct_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($sunct_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($sunct_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($sunct_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($sunct_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($sunct_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($sunct_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($sunct_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($sunct_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($sunct_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($sunct_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($sunct_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($sunct_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($sunct_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($sunct_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
									<input type="hidden" name="sunos" value="closed" <?php echo ($sunos_global == 'closed' ? '' : '');?> />
									<input type="checkbox" name="sunos" value="open" <?php echo ($sunos_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
					</div><!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="monot">Monday</label>
						<div class="col-sm-4">
						<select class="form-control" name="monot">
						<option value="3:00 AM" <?php if($monot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($monot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($monot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($monot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($monot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($monot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($monot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($monot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($monot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($monot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($monot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($monot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($monot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($monot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($monot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($monot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($monot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($monot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($monot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($monot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($monot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($monot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($monot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($monot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($monot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($monot_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($monot_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($monot_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($monot_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($monot_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($monot_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($monot_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($monot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($monot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($monot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($monot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($monot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($monot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($monot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($monot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($monot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($monot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($monot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($monot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($monot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($monot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($monot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($monot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="monct">
						<option value="3:00 AM" <?php if($monct_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($monct_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($monct_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($monct_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($monct_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($monct_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($monct_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($monct_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($monct_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($monct_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($monct_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($monct_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($monct_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($monct_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($monct_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($monct_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($monct_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($monct_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($monct_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($monct_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($monct_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($monct_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($monct_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($monct_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($monct_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($monct_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($monct_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($monct_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($monct_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($monct_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($monct_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($monct_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($monct_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($monct_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($monct_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($monct_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($monct_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($monct_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($monct_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($monct_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($monct_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($monct_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($monct_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($monct_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($monct_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($monct_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($monct_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($monct_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
									<input type="hidden" name="monos" value="closed" <?php echo ($monos_global == 'closed' ? '' : '');?> />
									<input type="checkbox" name="monos" value="open" <?php echo ($monos_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
					</div><!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="tueot">Tuesday</label>
						<div class="col-sm-4">
						<select class="form-control" name="tueot">
						<option value="3:00 AM" <?php if($tueot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($tueot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($tueot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($tueot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($tueot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($tueot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($tueot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($tueot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($tueot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($tueot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($tueot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($tueot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($tueot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($tueot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($tueot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($tueot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($tueot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($tueot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($tueot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($tueot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($tueot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($tueot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($tueot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($tueot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($tueot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($tueot_global == '3:00 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($tueot_global == '4:30 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($tueot_global == '4:00 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($tueot_global == '5:30 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($tueot_global == '5:00 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($tueot_global == '6:30 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($tueot_global == '6:00 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($tueot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($tueot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($tueot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($tueot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($tueot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($tueot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($tueot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($tueot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($tueot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($tueot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($tueot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($tueot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($tueot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($tueot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($tueot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($tueot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="tuect">
						<option value="3:00 AM" <?php if($tuect_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($tuect_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($tuect_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($tuect_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($tuect_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($tuect_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($tuect_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($tuect_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($tuect_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($tuect_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($tuect_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($tuect_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($tuect_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($tuect_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($tuect_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($tuect_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($tuect_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($tuect_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($tuect_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($tuect_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($tuect_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($tuect_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($tuect_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($tuect_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($tuect_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($tuect_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($tuect_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($tuect_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($tuect_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($tuect_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($tuect_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($tuect_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($tuect_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($tuect_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($tuect_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($tuect_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($tuect_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($tuect_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($tuect_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($tuect_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($tuect_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($tuect_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($tuect_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($tuect_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($tuect_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($tuect_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($tuect_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($tuect_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
									<input type="hidden" name="tueos" value="closed" <?php echo ($tueos_global == 'closed' ? '' : '');?> />
									<input type="checkbox" name="tueos" value="open" <?php echo ($tueos_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
					</div><!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-2 control-label">Wednesday</label>
						<div class="col-sm-4">
						<select class="form-control" name="wedot">
						<option value="3:00 AM" <?php if($wedot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($wedot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($wedot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($wedot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($wedot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($wedot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($wedot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($wedot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($wedot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($wedot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($wedot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($wedot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($wedot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($wedot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($wedot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($wedot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($wedot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($wedot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($wedot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($wedot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($wedot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($wedot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($wedot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($wedot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($wedot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($wedot_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($wedot_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($wedot_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($wedot_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($wedot_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($wedot_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($wedot_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($wedot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($wedot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($wedot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($wedot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($wedot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($wedot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($wedot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($wedot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($wedot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($wedot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($wedot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($wedot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($wedot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($wedot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($wedot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($wedot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="wedct">
						<option value="3:00 AM" <?php if($wedct_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($wedct_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($wedct_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($wedct_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($wedct_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($wedct_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($wedct_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($wedct_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($wedct_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($wedct_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($wedct_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($wedct_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($wedct_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($wedct_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($wedct_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($wedct_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($wedct_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($wedct_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($wedct_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($wedct_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($wedct_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($wedct_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($wedct_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($wedct_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($wedct_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($wedct_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($wedct_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($wedct_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($wedct_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($wedct_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($wedct_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($wedct_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($wedct_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($wedct_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($wedct_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($wedct_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($wedct_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($wedct_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($wedct_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($wedct_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($wedct_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($wedct_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($wedct_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($wedct_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($wedct_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($wedct_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($wedct_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($wedct_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
									<input type="hidden" name="wedos" value="closed" <?php echo ($wedos_global == 'closed' ? '' : '');?> />
									<input type="checkbox" name="wedos" value="open" <?php echo ($wedos_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
					</div><!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="thuot">Thursday</label>
						<div class="col-sm-4">
						<select class="form-control" name="thuot">
						<option value="3:00 AM" <?php if($thuot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($thuot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($thuot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($thuot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($thuot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($thuot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($thuot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($thuot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($thuot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($thuot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($thuot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($thuot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($thuot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($thuot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($thuot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($thuot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($thuot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($thuot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($thuot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($thuot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($thuot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($thuot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($thuot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($thuot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($thuot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($thuot_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($thuot_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($thuot_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($thuot_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($thuot_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($thuot_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($thuot_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($thuot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($thuot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($thuot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($thuot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($thuot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($thuot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($thuot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($thuot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($thuot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($thuot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($thuot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($thuot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($thuot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($thuot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($thuot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($thuot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="thuct">
						<option value="3:00 AM" <?php if($thuct_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($thuct_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($thuct_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($thuct_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($thuct_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($thuct_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($thuct_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($thuct_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($thuct_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($thuct_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($thuct_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($thuct_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($thuct_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($thuct_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($thuct_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($thuct_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($thuct_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($thuct_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($thuct_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($thuct_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($thuct_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($thuct_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($thuct_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($thuct_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($thuct_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($thuct_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($thuct_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($thuct_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($thuct_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($thuct_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($thuct_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($thuct_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($thuct_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($thuct_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($thuct_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($thuct_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($thuct_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($thuct_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($thuct_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($thuct_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($thuct_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($thuct_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($thuct_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($thuct_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($thuct_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($thuct_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($thuct_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($thuct_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
								<input type="hidden" name="thuos" value="closed" <?php echo ($thuos_global == 'closed' ? '' : '');?> />
								<input type="checkbox" name="thuos" value="open" <?php echo ($thuos_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
					</div><!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="friot">Friday</label>
						<div class="col-sm-4">
						<select class="form-control" name="friot">
						<option value="3:00 AM" <?php if($friot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($friot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($friot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($friot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($friot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($friot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($friot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($friot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($friot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($friot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($friot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($friot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($friot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($friot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($friot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($friot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($friot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($friot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($friot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($friot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($friot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($friot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($friot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($friot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($friot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($friot_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($friot_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($friot_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($friot_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($friot_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($friot_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($friot_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($friot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($friot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($friot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($friot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($friot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($friot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($friot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($friot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($friot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($friot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($friot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($friot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($friot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($friot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($friot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($friot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="frict">
						<option value="3:00 AM" <?php if($frict_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($frict_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($frict_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($frict_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($frict_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($frict_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($frict_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($frict_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($frict_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($frict_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($frict_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($frict_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($frict_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($frict_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($frict_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($frict_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($frict_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($frict_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($frict_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($frict_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($frict_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($frict_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($frict_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($frict_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($frict_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($frict_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($frict_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($frict_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($frict_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($frict_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($frict_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($frict_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($frict_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($frict_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($frict_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($frict_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($frict_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($frict_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($frict_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($frict_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($frict_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($frict_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($frict_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($frict_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($frict_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($frict_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($frict_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($frict_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
								<input type="hidden" name="frios" value="closed" <?php echo ($frios_global == 'closed' ? '' : '');?> />
								<input type="checkbox" name="frios" value="open" <?php echo ($frios_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
					</div><!-- /.form-group -->
					<div class="form-group">
						<label class="col-sm-2 control-label" for="satot">Saturday</label>
						<div class="col-sm-4">
						<select class="form-control" name="satot">
						<option value="3:00 AM" <?php if($satot_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($satot_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($satot_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($satot_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($satot_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($satot_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($satot_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($satot_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($satot_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($satot_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($satot_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($satot_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($satot_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($satot_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($satot_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($satot_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($satot_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($satot_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($satot_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($satot_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($satot_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($satot_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($satot_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($satot_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($satot_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($satot_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($satot_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($satot_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($satot_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($satot_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($satot_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($satot_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($satot_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($satot_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($satot_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($satot_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($satot_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($satot_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($satot_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($satot_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($satot_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($satot_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($satot_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($satot_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($satot_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($satot_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($satot_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($satot_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-4">
						<select class="form-control" name="satct">
						<option value="3:00 AM" <?php if($satct_global == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
						<option value="3:30 AM" <?php if($satct_global == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
						<option value="4:00 AM" <?php if($satct_global == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
						<option value="4:30 AM" <?php if($satct_global == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
						<option value="5:00 AM" <?php if($satct_global == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
						<option value="5:30 AM" <?php if($satct_global == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
						<option value="6:00 AM" <?php if($satct_global == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
						<option value="6:30 AM" <?php if($satct_global == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
						<option value="7:00 AM" <?php if($satct_global == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
						<option value="7:30 AM" <?php if($satct_global == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
						<option value="8:00 AM" <?php if($satct_global == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
						<option value="8:30 AM" <?php if($satct_global == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
						<option value="9:00 AM" <?php if($satct_global == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
						<option value="9:30 AM" <?php if($satct_global == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
						<option value="10:00 AM" <?php if($satct_global == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
						<option value="10:30 AM" <?php if($satct_global == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
						<option value="11:00 AM" <?php if($satct_global == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
						<option value="11:30 AM" <?php if($satct_global == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
						<option value="12:00 PM" <?php if($satct_global == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
						<option value="12:30 PM" <?php if($satct_global == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
						<option value="1:00 PM" <?php if($satct_global == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
						<option value="1:30 PM" <?php if($satct_global == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
						<option value="2:00 PM" <?php if($satct_global == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
						<option value="2:30 PM" <?php if($satct_global == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
						<option value="3:00 PM" <?php if($satct_global == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
						<option value="3:30 PM" <?php if($satct_global == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
						<option value="4:00 PM" <?php if($satct_global == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
						<option value="4:30 PM" <?php if($satct_global == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
						<option value="5:00 PM" <?php if($satct_global == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
						<option value="5:30 PM" <?php if($satct_global == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
						<option value="6:00 PM" <?php if($satct_global == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
						<option value="6:30 PM" <?php if($satct_global == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
						<option value="7:00 PM" <?php if($satct_global == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
						<option value="7:30 PM" <?php if($satct_global == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
						<option value="8:00 PM" <?php if($satct_global == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
						<option value="8:30 PM" <?php if($satct_global == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
						<option value="9:00 PM" <?php if($satct_global == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
						<option value="9:30 PM" <?php if($satct_global == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
						<option value="10:00 PM" <?php if($satct_global == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
						<option value="10:30 PM" <?php if($satct_global == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
						<option value="11:00 PM" <?php if($satct_global == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
						<option value="11:30 PM" <?php if($satct_global == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
						<option value="12:00 AM" <?php if($satct_global == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
						<option value="12:30 AM" <?php if($satct_global == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
						<option value="1:00 AM" <?php if($satct_global == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
						<option value="1:30 AM" <?php if($satct_global == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
						<option value="2:00 AM" <?php if($satct_global == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
						<option value="2:30 AM" <?php if($satct_global == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
						</select>
						</div>
						<div class="col-sm-2">
							<div class="checkbox">
								<label>
									<input type="hidden" name="satos" value="closed" <?php echo ($satos_global == 'closed' ? '' : '');?> />
									<input type="checkbox" name="satos" value="open" <?php echo ($satos_global == 'open' ? 'checked' : '');?> />Open
								</label>
							</div>
						</div>
                            
					</div><!-- /.form-group -->
                                                <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="business_hours_submit" id="addGlobal" class="btn btn-primary" value="Update Business Hours" /></div>
                                                </div>
					</div>
					</div>
					</section>
                                      </form>
                                     <form id="global-options-profile-image" method="POST" action="inc/submit.php" enctype="multipart/form-data">
                                         <?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					<?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                         <section class="content-box">
						<label for="profile_image">Override default profile image. <input type="checkbox" id="profile_image" name="profile_image" <?php echo ($profileimage_overide_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Profile Image</div>
						<div class="form-group">
							<label for="profile-image">Add Image</label>
							<p class="recommend-size">Recommend Size: 480*270px</p>
							<input type="hidden" id="profileimage" name="profileimage" value="<?php echo $profileimage_global; ?>" />
							<button class="btn btn-default btn-round add-image-media">Select Image</button>
							<div class="image-holder"><?php if($profileimage_global != "") { ?><img src="uploads/<?php echo $profileimage_global; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="profile_image_submit" id="addGlobal" class="btn btn-primary" value="Update Profile Image" /></div>
                                                 </div>
					</section>
                                    </form>
                      <form id="global-options-page-content" method="POST" action="inc/submit.php" enctype="multipart/form-data">
                                        <?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					<?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                        <section class="content-box">
						<label for="page_content">Override default page content. <input type="checkbox" id="page_content" name="page_content" <?php echo ($page_content_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Page Content</div>
						<div class="form-group">
							<label for="pagetitle">Page Title</label>
							<input type="text" id="pagetitle" name="pagetitle" class="form-control" placeholder="Enter Title" value="<?php echo $pagetitle_global; ?>"/>
						</div>
						<div class="form-group">
							<textarea type="text" class="form-control tinymce" id="page-content" name="pagecontent" ><?php echo $pagecontent_global; ?>
							</textarea>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="page_content_submit" id="addGlobal" class="btn btn-primary" value="Update Page Content" /></div>
                                                 </div>
					</section>
                           </form>
                           
                          
                           <form id="global-options-page-content" method="POST" action="inc/submit.php" enctype="multipart/form-data">
                                        <?php if($role == 'superadmin') { ?>
						<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					<?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                        <section class="content-box">
						<label for="page_content">Override default analytic code. <input type="checkbox" id="page_content" name="analytic_default" <?php echo ($analytic_default == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Analytic Code</div>
						<div class="form-group">
							<textarea type="text" rows="8" class="form-control" id="analytic-content" name="analytic" ><?php echo $analytic; ?>
							</textarea>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="analytic_content_submit" id="addGlobal" class="btn btn-primary" value="Update Analytic Code" /></div>
                                                 </div>
					</section>
                           </form>
                           
                           
                                      
                                      
                                      <form id="global-options-trust-badges" method="POST" action="inc/submit.php" enctype="multipart/form-data"> 
                                                <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                          <section class="content-box">
						<label for="trust_badges">Override default trust badges. <input type="checkbox" id="trust_badges" name="trust_badges" <?php echo ($trust_badges_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Trust Badges</div>
						<div class="trust-bagdes">
						<div class="trust-bagde-group-container">
						<?php 
						$trust = array();
						$uploadImage_global = explode(" &&*&& ", $data_global['uploadimage']);
						$trustwebsitelink_global = (explode(" &&*&& ", $trustwebsitelink_global));
						$i=0;
						for($i=0;$i<count($uploadImage_global);$i++){ 
								$trust[$i]['uploadimage'] = $uploadImage_global[$i];
								$trust[$i]['trustwebsitelink'] = $trustwebsitelink_global[$i];
						?>
						<div class="trust-bagde-group">
							<div class="form-group">
							<label for="uploadimage<?php echo $i; ?>">Add Image</label>
							<p class="recommend-size">Recommend Size: 120*100px</p>
							<input type="hidden" id="uploadimage<?php echo $i; ?>" name="uploadimage[]" value="<?php echo $trust[$i]['uploadimage']; ?>" />
							<button class="btn btn-default btn-round add-image-media">Select Image</button>
							<div class="image-holder"><?php if($trust[$i]['uploadimage'] != "") { ?><img src="uploads/<?php echo $trust[$i]['uploadimage']; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group">
							<label for="trustwebsitelink<?php echo $i; ?>">Trust Website Link(optional)</label>
							<input type="url" class="form-control" id="trustwebsitelink<?php echo $i; ?>" name="trustwebsitelink[]" value="<?php echo $trust[$i]['trustwebsitelink']; ?>">
							</div>
							<div class="remove-badges"><button class="btn btn-default btn-round remove-badge">Remove badge</button></div>
						</div>
						<?php } ?>
						</div>
						<div class="add-badges">
							<button class="btn btn-default btn-round" id="add-badge">Add badge</button>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="trust_badge_submit" id="addGlobal" class="btn btn-primary" value="Update Trust Badges" /></div>
                                                 </div>
						</div>
					</section>
                                      </form>
                                      <form id="global-options-trust-text" method="POST" action="inc/submit.php" enctype="multipart/form-data">   
                                                <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					  <input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                          <section class="content-box">
						<label for="trust_text">Override trust text. <input type="checkbox" id="trust_text" name="trust_text" <?php echo ($trusttextoveride_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Trust Text</div>
						<div class="form-group">
							<label for="trusttext">Trust Text</label>
							<textarea type="text" class="form-control" rows="4" id="trusttext" name="trusttext" ><?php echo $trusttext_global; ?></textarea>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="trust_text_submit" id="addGlobal" class="btn btn-primary" value="Update Trust Text" /></div>
                                                 </div>
					</section>
                                      </form>
                    <form id="global-options-trust-text" method="POST" action="inc/submit.php" enctype="multipart/form-data"> 
						<?php if($role == 'superadmin'): ?>
							<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
						<?php endif; ?>
							<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                        <section class="content-box">
							<label for="overideemail">Override contact form email. 
								<input type="checkbox" id="overideemail" name="overideemail" <?php echo ($emailmessageidoveride_global == 'on' ? 'checked' : '');?> /></label>
							<div class="box-title">Contact Form</div>
								<div class="contact-form-email-override-box">
										<label for="emailmesageid">Email Messages Will Be Sent To <span class="required-star">*</span></label>
										<?php 
											$email_data='';
											try{
												$email_data=json_decode($emailmessageid_global);
											}
											catch(Exception $e){
												$email_data=$emailmessageid_global;
											}
										?>
										<?php if(is_array($email_data)): ?>
											<?php $key_index=0; ?>
											<?php foreach($email_data as $key=>$val): ?>
												<div class="form-group">
												<input type="text" class="form-control em-msg" id="emailmesageid" name="emailmesageid[]" placeholder="Enter the email you want your messages sent to" value="<?php echo $val; ?>" />
												<?php if($key_index>0): ?>
													<button type="button" class="btn btn-danger btn-minus" onclick="removeInputBox(this)"><span><i class="fa fa-minus"></i></span></button>
												<?php endif; ?>
												<?php $key_index++; ?>
												</div>
											<?php endforeach; ?>
										<?php else: ?>
											<input type="text" class="form-control em-msg" id="emailmesageid" name="emailmesageid[]" placeholder="Enter the email you want your messages sent to" value="<?php echo $emailmessageid_global; ?>" />
										<?php endif; ?>
								</div>
								<button type="button" onclick="add_more_email_option()" class="btn btn-primary"><span><i class="fa fa-plus"></i></span> Add</button>
													<div class="add-field-btn">
							<div class="add-location-btn"><input type="submit" name="contact_formemail_submit" id="addGlobal" class="btn btn-primary" value="Update Contact Email" /></div>
							</div>
						</section>
                    </form>
                                     <form id="global-options-review-us" method="POST" action="inc/submit.php" enctype="multipart/form-data"> 
                                               <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					   <input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                         <section class="content-box">
						<label for="review_us">Override default review us buttons. <input type="checkbox" id="review_us" name="review_us" <?php echo ($review_us_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Review Us Buttons</div>
						<div class="add-review">
						<div class="review-group-container">
							<?php 
							$buttontitle_global = (explode(' &&*&& ', $buttontitle_global));
							$buttonlink_global = (explode(' &&*&& ', $buttonlink_global));
							$i = 1;
								foreach ($buttontitle_global as $id => $key) {
								$i++;	
								$result[$key] = array(
									'buttontitle' => $buttontitle_global[$id],
									'buttonlink'  => $buttonlink_global[$id],
								);
								?>
								<div class="review-group">
									<div class="form-group">
										<label for="buttontitle<?php echo $i; ?>">Button Title</label>
										<input type="text" id="buttontitle<?php echo $i; ?>" name="buttontitle[]" class="form-control" placeholder="Enter button title (ex. Review Us On Yelp)" value="<?php echo $result[$key]['buttontitle']; ?>"/>
									</div>
									<div class="form-group">
										<label for="buttonlink<?php echo $i; ?>">Button Link</label>
										<input type="url" id="buttonlink<?php echo $i; ?>" name="buttonlink[]" class="form-control" placeholder="Enter button link (ex. http://www.example.com)" value="<?php echo $result[$key]['buttonlink']; ?>"/>
									</div>
									<div class="remove-review-btn"><button class="btn btn-default btn-round remove-btn">Remove Button</button></div>
								</div>
								<?php } ?>
						</div>
							<button class="btn btn-default btn-round" id="add-review-btn">Add Button</button>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="update_reviewbtn" id="addGlobal" class="btn btn-primary" value="Update Review Buttons" /></div>
                                                 </div>
					</section>
                                    </form>
                                     <form id="global-options-custom-reviews" method="POST" action="inc/submit.php" enctype="multipart/form-data"> 
                                                <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                         <section class="content-box">
						<label for="custom_reviews">Override default add custom reviews. <input type="checkbox" id="custom_reviews" name="custom_reviews" <?php echo ($custom_reviews_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Add Custom Reviews</div>
						<div class="add-review">
							<div class="add-custom-review-container">
							<?php 
							$all = array();
							$uploadprofileimage_global = (explode(' &&*&& ', $uploadprofileimage_global));
							$reviewername_global = (explode(' &&*&& ', $reviewername_global));
							$reviewsite_global = (explode(' &&*&& ', $reviewsite_global));
							$rating_global = (explode(' &&*&& ', $rating_global));
							$review_global = (explode(' &&*&& ', $review_global));
							//$result = array();
							$i=0;
							for($i=0;$i<count($uploadprofileimage_global);$i++){ 
							$all[$i]['uploadimage'] = $uploadprofileimage_global[$i];
							$all[$i]['reviewername'] = $reviewername_global[$i];
							$all[$i]['reviewsite'] = $reviewsite_global[$i];
							$all[$i]['rating'] = $rating_global[$i];
							$all[$i]['review'] = $review_global[$i];
							?>
							<div class="add-custom-review">
								<div class="form-group">
									<label for="uploadprofileimage<?php echo $i; ?>">Add Profile Image</label>
									<p class="recommend-size">Recommend Size: 70*70px</p>
									<input type="hidden" id="uploadprofileimage<?php echo $i; ?>" name="uploadprofileimage[]" value="<?php echo $all[$i]['uploadimage']; ?>" />
									<button class="btn btn-default btn-round add-image-media">Select Image</button>
									<div class="image-holder"><?php if($all[$i]['uploadimage'] != "") { ?><img src="uploads/<?php echo $all[$i]['uploadimage']; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
								</div>
								<div class="clearfix"></div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label for="reviewername1">Reviewer Name</label>
											<input type="text" id="reviewername1" name="reviewername[]" class="form-control" placeholder="Enter the reviewer's name" value="<?php echo $all[$i]['reviewername']; ?>"/>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
										<label for="reviewsite1">Review Site</label>
										<select id="reviewsite1" name="reviewsite[]" class="form-control">
										<option value="">Select</option>
										<option value="Yelp" <?php if($all[$i]['reviewsite'] == 'Yelp') { echo 'selected'; } ?>>Yelp</option>
										<option value="Google" <?php if($all[$i]['reviewsite'] == 'Google') { echo 'selected'; } ?>>Google</option>
										<option value="Superpages" <?php if($all[$i]['reviewsite'] == 'Superpages') { echo 'selected'; } ?>>Superpages</option>
										<option value="Foursquare" <?php if($all[$i]['reviewsite'] == 'Foursquare') { echo 'selected'; } ?>>Foursquare</option>
										</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label for="rating1">Rating</label>
											<select class="form-control" id="rating1" name="rating[]">
												<option value="">Select</option>
												<option value="1" <?php if($all[$i]['rating'] == '1') { echo 'selected'; } ?>>1</option>
												<option value="1.5" <?php if($all[$i]['rating'] == '1.5') { echo 'selected'; } ?>>1.5</option>
												<option value="2" <?php if($all[$i]['rating'] == '2') { echo 'selected'; } ?>>2</option>
												<option value="2.5" <?php if($all[$i]['rating'] == '2.5') { echo 'selected'; } ?>>2.5</option>
												<option value="3" <?php if($all[$i]['rating'] == '3') { echo 'selected'; } ?>>3</option>
												<option value="3.5" <?php if($all[$i]['rating'] == '3.5') { echo 'selected'; } ?>>3.5</option>
												<option value="4" <?php if($all[$i]['rating'] == '4') { echo 'selected'; } ?>>4</option>
												<option value="4.5" <?php if($all[$i]['rating'] == '4.5') { echo 'selected'; } ?>>4.5</option>
												<option value="5" <?php if($all[$i]['rating'] == '5') { echo 'selected'; } ?>>5</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="review1">Review</label>
									<textarea type="text" id="review1" name="review[]" class="form-control" rows="4" ><?php echo $all[$i]['review']; ?></textarea>
								</div>
								<div class="remove-reviews"><button class="btn btn-default btn-round remove-review">Remove review</button></div>
							</div>	
							<?php } ?>
							</div>
							<button class="btn btn-default btn-round" id="add-custom-review">Add Review</button>
						</div>	
                                                <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="update_customreviews" id="addGlobal" class="btn btn-primary" value="Update Custom Reviews" /></div>
                                                 </div>
			
					</section>
                                     </form>
                                     <form id="global-options-payments-accepted" method="POST" action="inc/submit.php" enctype="multipart/form-data"> 
                                                <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                         <section class="content-box">
						<label for="payments_accepted">Override default payments accepted. <input type="checkbox" id="payments_accepted" name="payments_accepted" <?php echo ($payments_accepted_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Payments Accepted</div>
						<div class="cc-wrapper">
							<img src="defaultimages/amex.png" class="cc active"><img src="defaultimages/credit.png" class="cc active"><img src="defaultimages/applepay.png" class="cc active"><img src="defaultimages/discover.png" class="cc active"><img src="defaultimages/google.png" class="cc active"><img src="defaultimages/mastercard.png" class="cc active"><img src="defaultimages/money.png" class="cc active"><img src="defaultimages/paypal.png" class="cc active"><img src="defaultimages/visa.png" class="cc active">
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="checkbox">
									<label><input type="checkbox" name="americanexpress"  <?php echo ($americanexpress_global == 'on' ? 'checked' : '');?> /> American Express</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="creditcard" <?php echo ($creditcard_global == 'on' ? 'checked' : '');?> /> Credit Card</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="applepay" <?php echo ($applepay_global == 'on' ? 'checked' : '');?> /> Apple Pay</label>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="checkbox">
									<label><input type="checkbox" name="discover"  <?php echo ($discover_global == 'on' ? 'checked' : '');?>> Discover</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="google"   <?php echo ($google_global == 'on' ? 'checked' : '');?>/> Google</label>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="checkbox">
									<label><input type="checkbox" name="mastercard"  <?php echo ($mastercard_global == 'on' ? 'checked' : '');?>> Mastercard</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="cash"  <?php echo ($cash_global == 'on' ? 'checked' : '');?>> Cash</label>
								</div>
							</div>
							<div class="col-sm-3">
								<div class="checkbox">
									<label><input type="checkbox" name="paypal"   <?php echo ($paypal_global == 'on' ? 'checked' : '');?>/> Paypal</label>
								</div>
								<div class="checkbox">
									<label><input type="checkbox" name="visa"  <?php echo ($visa_global == 'on' ? 'checked' : '');?>/> Visa</label>
								</div>
							</div>
						</div>
                                                 <div class="add-field-btn">
						   <div class="add-location-btn"><input type="submit" name="update_paymentsaccepted" id="addGlobal" class="btn btn-primary" value="Update" /></div>
                                                 </div>
					</section>
                                     </form>
                                     <form id="global-options-add-coupon" method="POST" action="inc/submit.php" enctype="multipart/form-data">     
                                                <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                         <section class="content-box">
						<label for="add_coupon">Override default add coupon. <input type="checkbox" id="add_coupon" name="add_coupon" <?php echo ($add_coupon_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Add Coupon</div>
						<p>Coupons can be images or text. if no image is added then you can add a text coupon by typing the Coupon Title field and Coupon Text field.</p>
						<div class="add-coupon-location-page">
							<div class="add-coupon-container">
							<?php 
								$allcoupon = array();
								$uploadcoupanimage_global = (explode(' &&*&& ', $uploadcoupanimage_global));
								$coupontitle_global = (explode(' &&*&& ', $coupontitle_global));
								$coupantext_global = (explode(' &&*&& ', $coupantext_global));
								$coupanlink_global = (explode(' &&*&& ', $coupanlink_global));
								$i=0;
								for($i=0;$i<count($uploadcoupanimage_global);$i++){ 
								   $allcoupon[$i]['uploadcoupanimage'] = $uploadcoupanimage_global[$i];
								   $allcoupon[$i]['coupontitle'] = $coupontitle_global[$i];
								   $allcoupon[$i]['coupantext'] = $coupantext_global[$i];
								   $allcoupon[$i]['coupanlink'] = $coupanlink_global[$i];
								 ?>
							<div class="add-coupon">
								<div class="form-group">
									<label for="uploadcoupanimage<?php echo $i; ?>">Add Coupon Image</label>
									<p class="recommend-size">Recommend Size: 260*140px</p>
									<input type="hidden" id="uploadcoupanimage<?php echo $i; ?>" name="uploadcoupanimage[]" value="<?php echo $allcoupon[$i]['uploadcoupanimage']; ?>" />
									<button class="btn btn-default btn-round add-image-media">Select Image</button>
									<div class="image-holder"><?php if($allcoupon[$i]['uploadcoupanimage'] != "") { ?><img src="uploads/<?php echo $allcoupon[$i]['uploadcoupanimage']; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label for="coupontitle<?php echo $i; ?>">Coupon Title</label>
									<input type="text" id="coupontitle<?php echo $i; ?>" name="coupontitle[]" class="form-control" placeholder="Enter coupon title (ex. Friday Sale)" value="<?php echo $allcoupon[$i]['coupontitle']; ?>"/>
								</div>
								<div class="form-group">
									<label for="coupantext<?php echo $i; ?>">Coupon Text (optional)</label>
									<textarea type="text" id="coupantext<?php echo $i; ?>" name="coupantext[]" class="form-control" rows="4"><?php echo $allcoupon[$i]['coupantext']; ?></textarea>
								</div>
								<div class="form-group">
									<label for="coupanlink<?php echo $i; ?>">Coupon Link (optional)</label>
									<input type="url" id="coupanlink<?php echo $i; ?>" name="coupanlink[]" class="form-control" placeholder="Enter coupon link (ex. html://www.couponlink.com)" value="<?php echo $allcoupon[$i]['coupanlink']; ?>"/>
								</div>
								<div class="remove-coupans"><button class="btn btn-default btn-round remove-coupan">Remove coupan</button></div>
							</div>
							<?php } ?>
							</div>
							<button class="btn btn-default btn-round" id="add-coupan">Add Coupon</button>	
						</div>
                                                               <div class="add-field-btn">
                                                  <div class="add-location-btn"><input type="submit" name="update_coupons" id="addGlobal" class="btn btn-primary" value="Update Coupons" /></div>
                                               </div>
					</section>
                                      </form>
                                      <form id="global-options-default-services" method="POST" action="inc/submit.php" enctype="multipart/form-data">   
                                                 <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                          <section class="content-box">
						<label for="defaultservices">Override default services. <input type="checkbox" id="defaultservices" name="defaultservices" <?php echo ($serviceoveride_global == 'on' ? 'checked' : ''); ?> /></label>
						<div class="box-title">Services</div>
						<div class="add-service-location-page">
							<div class="add-service-container">
								<?php $allservices = array();
								$servicesglobal_global = (explode(' &&*&& ', $servicesglobal_global));
								$a=0;
								for($a=0;$a<count($servicesglobal_global);$a++){ 
									$allservices[$i]['services'] = $servicesglobal_global[$a];
								?>
								<div class="add_services">
									<div class="form-group">   
										<label for="addservice<?php echo $a; ?>">Service</label>
										<textarea type="text" name="addservice[]" id="addservice<?php echo $a; ?>" class="form-control" rows="2"><?php echo $allservices[$i]['services']; ?></textarea>
									</div>
									<div class="remove-services">
										<button class="btn btn-default btn-round remove-service">Remove Service</button>
									</div>
								</div> 
								<?php } ?>
							</div>
							<button class="btn btn-default btn-round service-button" id="add-new-services">Add New Service</button>
						</div> 
                                                <div class="add-field-btn">
                                                  <div class="add-location-btn"><input type="submit" name="update_default_services" id="addGlobal" class="btn btn-primary" value="Update Services" /></div>
                                               </div>
					</section>
                                     </form>
                                        <form id="global-options-default-title" method="POST" action="inc/submit.php" enctype="multipart/form-data">   
                                                 <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                          <section class="content-box">
						<label for="defaulttitle">Override default title. <input type="checkbox" id="defaulttitle" name="title_tags_override" <?php echo ($title_tag_override == 'on' ? 'checked' : ''); ?> /></label>
						<div class="box-title">Title</div>
						<div class="add-service-location-page">
							<div class="add-service-container">
						             <div class="form-group">
								<label for="defaulttitle">Title</label>
								<input type="text" id="title_tags" name="title_tags" class="form-control" value="<?php echo !empty($title_tag) ? $title_tag : ""; ?>" placeholder="Enter title here" />
							     </div>						
							</div>
					
						</div> 
                                                <div class="add-field-btn">
                                                  <div class="add-location-btn"><input type="submit" name="update_default_title" id="update_default_title" class="btn btn-primary" value="Update Title" /></div>
                                               </div>
					</section>
                                     </form>
                                            
                                     <form id="global-options-default-module" method="POST" action="inc/submit.php" enctype="multipart/form-data">    
                                               <?php if($role == 'superadmin') { ?>
						   <input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
					       <?php } ?>
					<input type="hidden" name="addglobaloptions" id="addglobaloptions" value="addglobaloptions">
                                         <section class="content-box hidden">
						<label for="module_position">Override default module position. <input type="checkbox" id="module_position" name="module_position" <?php echo ($module_position_global == 'on' ? 'checked' : '');?> /></label>
						<div class="box-title">Module Position</div>
						<div class="dragdrop-wrapper">
							<div class="module module-breadcrumbs">
								<div class="module-label">
									<span>Breadcrumbs</span>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-9">
									<div class="row">
										<div class="col-xs-6" id="divmap">
											<div data-aspect-ratio="1:1" class="module module-map">
												<div class="module-label"><span>Map</span></div>
											</div>
										</div>
										<div class="col-xs-6" id="divnap">
											<div data-aspect-ratio="1:1" class="module module-nap">
												<div class="module-label"><span>Business NAP</span></div>
											</div>
										</div>
									</div>
									<div data-aspect-ratio="16:9" class="module module-business-info">
										<div class="module-label"><span>Business Info</span></div>
									</div>
									<div data-aspect-ratio="3:1" class="module module-trust">
										<div class="module-label"><span>Trust Icons</span></div>
									</div>
									<div data-aspect-ratio="16:9" class="module module-reviews">
										<div class="module-label"><span>Reviews</span></div>
									</div>
								</div>
								<div class="col-xs-3">
									<div data-aspect-ratio="1:1" class="module module-contact">
										<div class="module-label"><span>Contact</span></div>
									</div>
									<div data-aspect-ratio="3:1" class="module module-review-buttons">
										<div class="module-label"><span>Review Buttons</span></div>
									</div>
									<div data-aspect-ratio="16:9" class="module module-featured-review">
										<div class="module-label"><span>Featured Review</span></div>
									</div>
									<div data-aspect-ratio="16:9" class="module module-coupons">
										<div class="module-label"><span>Coupons</span></div>
									</div>
									<div data-aspect-ratio="3:1" class="module module-payment">
										<div class="module-label"><span>Payment</span></div>
									</div>
								</div>
							</div>
						</div>
					</section>
                                      </form>
					
				</section>
				</section>
			</div><!-- /.content-wrapper -->
        </div><!-- /.col -->
    </div><!-- /.row -->
    
	<?php include "mediapopup.php"; ?>
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	 <?php } ?>
</div><!-- /.container -->

<?php include 'footer.php'; ?>
