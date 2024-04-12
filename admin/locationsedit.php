<?php include "header.php"; ?>
  <body class="admin-panel" onLoad="initialize()">
    <div class="container admin-body">
	  <?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $locations == "on" && in_array($locationid, $edlocationresultsarray))) {
	      $admin_id=$_GET['adminid'];
      	if($admin_id==50){
   				$brAnd = 1;
   			}elseif($admin_id==51){
   				$brAnd = 2;
   			}elseif($admin_id==52){
   				$brAnd = 3;
   			}elseif($admin_id==53){
				$brAnd = 4;
			}
	  ?>
	  <div class="row no-gutter">
	  <?php include 'sidebar.php'; ?>
		<div class="col-md-9">
          <div class="content-wrapper">
		   <?php if($pageavailability == 1) { ?>
            <h1 class="page-title">Edit Location</h1>
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
				<form id="location-add" enctype="multipart/form-data" method="post" action="inc/submit.php">
				<?php if($role == "superadmin") { ?>
					<input type="hidden" name="adminid" id="AdminID" value="<?php echo $_GET['adminid']; ?>" />
				<?php } ?>
				<section class="content-box">
					<div class="box-title">Basic Information</div>
					<div class="form-group">
						<input type="hidden" class="form-control" id="id" name="id_loc" placeholder="Enter Custom Location Name" value="<?php echo $id_loc; ?>"/>
					</div>
					<div class="form-group">
						<label for="name">Location Name<span class="required-star">*</span></label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Custom Location Name" value="<?php echo $name; ?>"/>
					</div>
					<div class="form-group">
						<label for="address">Address<span class="required-star">*</span></label>
						<input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" value="<?php echo $address; ?>" />
					</div>
					<div class="form-group">
						<label for="address">Hide Address</label>
						<input type="checkbox" value="1" name="addressshow" <?= ($addressshow==1) ? 'checked' : ''?>>
					</div>
					<div class="form-group">
							<label for="suite">License</label>
							<input type="text" id="suiteLicenseUpdate" name="suite" class="form-control" placeholder="License #" value="<?php echo $suite; ?>" required />
							<input type="hidden" name="lookupID" value="<?php echo $lookupID; ?>" />
							<input type="hidden" name="delaypurpose" value="<?php echo $suite; ?>" />
							<span style="display:none; color:red;" id="MesgError">License number is already in use.</span>
							<div class="form-group">
								<label for="address">Child License</label>
								<input type="checkbox" value="1" name="addchild" id="addchildcheck" <?= ($childcheck==1) ? 'checked' : ''?>>
							</div>
							<section class="content-box" id="childBoxblock" style="<?= ($childcheck==0) ? 'display:none' : '' ?>">
									<div class="trust-bagdes">	
										<div class="child-group-container tbody">
										 <span style="display:none; color:red;" id="MesgErrorchild">Child License number is already in use.</span>
											<?php
												$children_result = mysqli_query($con, "SELECT * FROM r1_parent_license_lookUp where Parent_Licence = '".$suite."' and brand='".$brAnd."'");
												if($children_result->num_rows > 0)
												{
													while ($row=mysqli_fetch_assoc($children_result)){ ?>
														<div class="trust-bagde-group1">
															<div class="clearfix"></div>
															<div class="form-group">
																<label for="childL">Enter License Number</label>
																<input type="text" class="form-control" id="childL" name="childL[]" value="<?= $row['Child_License'] ?>">
															</div>
															<div class="remove-badges"><button class="btn btn-default btn-round remove-childs">Remove Child</button></div>
														</div>
													 
													<?php }
												 
												}else{ ?>
													<div class="trust-bagde-group1">
														<div class="clearfix"></div>
														<div class="form-group">
															<label for="childL">Enter License Number</label>
															<input type="text" class="form-control" id="childL" name="childL[]">
														</div>
													</div>												
													
												<?php }
												
											?>
											
										</div>
										<div class="add-badges">
											<button class="btn btn-default btn-round" id="add-child-license">Add Child</button>
										</div>
									</div>
							</section>  	
					   </div>
					<div class="row">
						<div class="col-sm-6">	
							<div class="form-group">
								<label for="city">City<span class="required-star">*</span></label>
								<input type="text" id="city" name="city" class="form-control" placeholder="Enter City" value="<?php echo $city; ?>" />
							</div>
							<div class="form-group">
								<label for="state">State<span class="required-star">*</span></label>
								<input type="text" id="state" name="state" class="form-control" placeholder="Enter State (Ex. CA)" value="<?php echo $state; ?>" />
							</div>	
							<div class="form-group">
								<label for="zipcode">Zipcode</label>
								<input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="Enter Zipcode" value="<?php echo $zipcode; ?>"/>
							</div>
							<div class="form-group">
								<label for="lat">Latitude<span class="required-star">*</span><a href="#" data-toggle="tooltip" title="The Latitude & Longitude values will be filled automatically on the basis of address provided you above. It can be changed manually or by dragging the marker on the map to the correct location." class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></a></label>
								<input type="text" id="lat" name="lat" class="form-control" placeholder="Enter Latitude" value="<?php echo $lat; ?>" />
							</div>
							<div class="form-group">
								<label for="lng">Longitude<span class="required-star">*</span><a href="#" data-toggle="tooltip" title="The Latitude & Longitude values will be filled automatically on the basis of address provided you above. It can be changed manually or by dragging the marker on the map to the correct location." class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></a></label>
								<input type="text" id="lng" name="lng" class="form-control" placeholder="Enter Longitude" value="<?php echo $lng; ?>"/>
							</div>
							<div class="form-group">
								<label for="phone">Phone<span class="required-star">*</span></label>
								<input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone #" value="<?php echo substr($phone, 0, 3).substr($phone, 3, 3)."-".substr($phone,6); ?>" />
							</div>
								
								<div class="form-group">
									<label for="phone">Location Url</label>
									<input type="text" id="locUrl" name="locUrl" class="form-control" placeholder="Enter location Url" value="<?php echo $loc_url; ?>" />
								</div>
								
							
							<div class="form-group">
								<label for="phone">Common Served Area<span class="required-star"></span></label>
								<input type="text" id="common_served_area" name="common_served_area" class="form-control" placeholder="Enter Common Served Area" value='<?php echo $common_served_area; ?>' />
							</div>
							<input type="hidden" name="locationUrl_tblId" id="locationUrl_tblId" value="<?php echo $locurlId;?>"/>
						</div>
						<div class="col-sm-6">
							<div id="adminmap" class="preview-map"></div>
							<button class="preview-btn" id="wpsl-lookup-location">Preview Location</button><a href="javascript:void(0)" data-toggle="tooltip" title="The Preview Location is based on the provided address, city & state." class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							<p class="marker-info">The marker can be dragged on the map to get the exact location.</p>
						</div>
					</div>
				</section>
				
				<?php if($_GET['adminid']==50 || $_GET['adminid']==49){ ?>			
				<div class="clearfix"></div>				
				<section class="content-box">
					<label for="checkid"  style="word-wrap:break-word">
						<input type="checkbox" value="1" name="extraAddress" id="extraAddress" <?= ($addresscheck==1) ? 'checked' : ''?>>Additional Addresses
					</label>
					<section class="content-box" id="addressBoxblock" style="<?= ($addresscheck==0) ? 'display:none' : '' ?>">
							<div class="trust-bagdes">	
								<div class="address-group-container tbody1">
									<?php
										$address_result_sql = mysqli_query($con, "SELECT * FROM r1_additional_address where loc_id =".$id_loc);
										
										if($address_result_sql->num_rows > 0)
										{
											$address_result = mysqli_fetch_assoc($address_result_sql);
											$eaddressdata = array();
											$eaddress = explode(" &&*&& ", $address_result['eaddress']);
											$ephone = (explode(" &&*&& ", $address_result['ephone']));
											$eaddressshow = (explode(" &&*&& ", $address_result['eaddressshow']));
											$ecity = (explode(" &&*&& ", $address_result['ecity']));
											$estate = (explode(" &&*&& ", $address_result['estate']));
											$ezipcode = (explode(" &&*&& ", $address_result['ezipcode']));
											$i=0;
											$j=1;
											for($i=0;$i<count($eaddress);$i++){ 
													$eaddressdata[$i]['eaddress'] = $eaddress[$i];
													$eaddressdata[$i]['ephone'] = $ephone[$i]; 
													$eaddressdata[$i]['eaddressshow'] = $eaddressshow[$i]; 
													$eaddressdata[$i]['ecity'] = $ecity[$i]; 
													$eaddressdata[$i]['estate'] = $estate[$i]; 
													$eaddressdata[$i]['ezipcode'] = $ezipcode[$i]; 
													
													?>
										<div class="trust-bagde-address">
											<div class="clearfix"></div>										
											<div class="form-group">
												<label for="Extraaddress">Address</label>
												<input type="text" class="form-control" id="Extraaddress" name="additionaladdress[]"  placeholder="Enter Address" value="<?= $eaddressdata[$i]['eaddress'] ?>">
											</div>
											<div class="form-group">
												<label for="ExtraHide"  style="word-wrap:break-word">
													<input type="checkbox" id="ExtraHide<?= $j ?>" value="1" name="additionaladdressshow[]" <?= ($eaddressdata[$i]['eaddressshow']==1) ? 'checked' : ''?>>Hide Address
												</label>
												<input type='hidden' id="ExtraHide<?= $j ?>1" value='0' name='additionaladdressshow[]' <?= ($eaddressdata[$i]['eaddressshow']==1) ? 'disabled="disabled"' : ''?>>
											</div>											
											<div class="form-group">
												<label for="Extracity">City</label>
												<input type="text" id="Extracity" name="additionalcity[]" class="form-control" placeholder="Enter City" value="<?= $eaddressdata[$i]['ecity'] ?>" />
											</div>
											<div class="form-group">
												<label for="Extrastate">State</label>
												<input type="text" id="Extrastate" name="additionalstate[]" class="form-control" placeholder="Enter State (Ex. CA)" value="<?= $eaddressdata[$i]['estate'] ?>" />
											</div>	
											<div class="form-group">
												<label for="Extrazipcode">Zipcode</label>
												<input type="text" id="Extrazipcode" name="additionalzipcode[]" class="form-control" placeholder="Enter Zipcode" value="<?= $eaddressdata[$i]['ezipcode'] ?>" />
											</div>
											
											<div class="form-group">
												<label for="Extraphone">Phone</label>
												<input type="text" class="form-control" id="Extraphone" name="additionalphone[]" placeholder="Enter Phone" value="<?= $eaddressdata[$i]['ephone'] ?>">
											</div>
											<div class="remove-badges"><button class="btn btn-default btn-round remove-childs">Remove Child</button></div>
										</div>
										<?php 
										$j++;
										}	
										}else{ ?>
										<div class="trust-bagde-address">
										<div class="clearfix"></div>
											<div class="form-group">
												<label for="Extraaddress">Address</label>
												<input type="text" class="form-control" id="Extraaddress" name="additionaladdress[]"  placeholder="Enter Address">
											</div>
											<div class="form-group">
												<label for="ExtraHide"  style="word-wrap:break-word">
													<input type="checkbox" id="ExtraHide1" value="1" name="additionaladdressshow[]">Hide Address
												</label>
												<input type='hidden' id="ExtraHide11" value='0' name='additionaladdressshow[]'>
											</div>											
											<div class="form-group">
												<label for="Extracity">City</label>
												<input type="text" id="Extracity" name="additionalcity[]" class="form-control" placeholder="Enter City" />
											</div>
											<div class="form-group">
												<label for="Extrastate">State</label>
												<input type="text" id="Extrastate" name="additionalstate[]" class="form-control" placeholder="Enter State (Ex. CA)" />
											</div>	
											<div class="form-group">
												<label for="Extrazipcode">Zipcode</label>
												<input type="text" id="Extrazipcode" name="additionalzipcode[]" class="form-control" placeholder="Enter Zipcode" />
											</div>
											
											<div class="form-group">
												<label for="Extraphone">Phone</label>
												<input type="text" class="form-control" id="Extraphone" name="additionalphone[]" placeholder="Enter Phone">
											</div>
										</div>
										<?php } ?>
								</div>
								<div class="add-badges">
									<button class="btn btn-default btn-round" id="add-additional-address">Add More</button>
								</div>
							</div>
					</section>
				</section>	
				<?php } ?>
				<div class="clearfix"></div>
			<!--	<section class="content-box">
					<div class="box-title">Business Hours</div>
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" for="sunot">Sunday</label>
							<div class="col-sm-4">
								<?php
								if($_GET['adminid']== 53){
									$sunot="12:00 PM";
									$sunct="5:00 PM";
									$monot="7:00 AM";
									$monct="7:00 PM";
									$tueot ='7:00 AM';
									$tuect ='7:00 PM';
									$wedot ='7:00 AM';
									$wedct ='7:00 PM';
									$thuot ='7:00 AM';
									$thuct ='7:00 PM';									
									$friot ='7:00 AM';
									$frict ='7:00 PM';
									$satot ='7:00 AM';
									$satct ='7:00 PM';
								}
								
								?>
							<select class="form-control" name="sunot">
							<option value="3:00 AM" <?php if($sunot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($sunot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($sunot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($sunot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($sunot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($sunot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($sunot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($sunot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($sunot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($sunot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($sunot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($sunot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($sunot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($sunot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($sunot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($sunot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($sunot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($sunot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($sunot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($sunot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($sunot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($sunot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($sunot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($sunot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($sunot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($sunot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($sunot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($sunot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($sunot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($sunot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($sunot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($sunot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($sunot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($sunot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($sunot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($sunot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($sunot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($sunot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($sunot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($sunot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($sunot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($sunot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($sunot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($sunot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($sunot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($sunot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($sunot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($sunot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="sunct">
							<option value="3:00 AM" <?php if($sunct == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($sunct == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($sunct == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($sunct == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($sunct == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($sunct == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($sunct == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($sunct == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($sunct == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($sunct == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($sunct == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($sunct == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($sunct == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($sunct == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($sunct == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($sunct == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($sunct == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($sunct == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($sunct == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($sunct == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($sunct == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($sunct == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($sunct == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($sunct == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($sunct == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($sunct == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($sunct == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($sunct == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($sunct == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($sunct == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($sunct == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($sunct == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($sunct == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($sunct == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($sunct == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($sunct == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($sunct == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($sunct == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($sunct == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($sunct == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($sunct == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($sunct == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($sunct == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($sunct == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($sunct == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($sunct == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($sunct == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($sunct == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="sunos" value="closed" <?php echo ($sunos == 'closed' ? '' : '');?> />
									<input type="checkbox" name="sunos" value="open" <?php echo ($sunos == 'open' ? 'checked' : '');?> />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="monot">Monday</label>
							<div class="col-sm-4">
							<select class="form-control" name="monot">
							<option value="3:00 AM" <?php if($monot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($monot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($monot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($monot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($monot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($monot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($monot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($monot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($monot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($monot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($monot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($monot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($monot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($monot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($monot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($monot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($monot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($monot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($monot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($monot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($monot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($monot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($monot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($monot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($monot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($monot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($monot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($monot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($monot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($monot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($monot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($monot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($monot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($monot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($monot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($monot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($monot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($monot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($monot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($monot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($monot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($monot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($monot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($monot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($monot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($monot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($monot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($monot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="monct">
							<option value="3:00 AM" <?php if($monct == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($monct == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($monct == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($monct == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($monct == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($monct == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($monct == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($monct == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($monct == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($monct == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($monct == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($monct == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($monct == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($monct == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($monct == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($monct == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($monct == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($monct == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($monct == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($monct == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($monct == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($monct == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($monct == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($monct == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($monct == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($monct == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($monct == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($monct == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($monct == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($monct == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($monct == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($monct == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($monct == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($monct == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($monct == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($monct == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($monct == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($monct == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($monct == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($monct == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($monct == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($monct == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($monct == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($monct == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($monct == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($monct == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($monct == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($monct == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
								<label>
								<input type="hidden" name="monos" value="closed" <?php echo ($monos == 'closed' ? '' : '');?> />
								<input type="checkbox" name="monos" value="open" <?php echo ($monos == 'open' ? 'checked' : '');?> />Open
								</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="tueot">Tuesday</label>
							<div class="col-sm-4">
							<select class="form-control" name="tueot">
							<option value="3:00 AM" <?php if($tueot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($tueot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($tueot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($tueot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($tueot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($tueot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($tueot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($tueot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($tueot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($tueot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($tueot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($tueot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($tueot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($tueot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($tueot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($tueot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($tueot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($tueot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($tueot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($tueot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($tueot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($tueot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($tueot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($tueot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($tueot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($tueot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($tueot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($tueot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($tueot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($tueot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($tueot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($tueot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($tueot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($tueot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($tueot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($tueot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($tueot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($tueot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($tueot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($tueot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($tueot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($tueot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($tueot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($tueot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($tueot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($tueot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($tueot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($tueot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="tuect">
							<option value="3:00 AM" <?php if($tuect == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($tuect == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($tuect == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($tuect == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($tuect == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($tuect == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($tuect == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($tuect == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($tuect == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($tuect == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($tuect == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($tuect == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($tuect == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($tuect == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($tuect == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($tuect == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($tuect == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($tuect == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($tuect == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($tuect == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($tuect == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($tuect == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($tuect == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($tuect == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($tuect == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($tuect == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($tuect == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($tuect == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($tuect == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($tuect == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($tuect == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($tuect == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($tuect == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($tuect == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($tuect == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($tuect == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($tuect == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($tuect == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($tuect == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($tuect == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($tuect == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($tuect == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($tuect == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($tuect == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($tuect == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($tuect == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($tuect == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($tuect == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="tueos" value="closed" <?php echo ($tueos == 'closed' ? '' : '');?> />
									<input type="checkbox" name="tueos" value="open" <?php echo ($tueos == 'open' ? 'checked' : '');?> />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Wednesday</label>
							<div class="col-sm-4">
							<select class="form-control" name="wedot">
							<option value="3:00 AM" <?php if($wedot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($wedot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($wedot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($wedot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($wedot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($wedot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($wedot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($wedot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($wedot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($wedot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($wedot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($wedot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($wedot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($wedot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($wedot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($wedot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($wedot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($wedot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($wedot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($wedot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($wedot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($wedot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($wedot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($wedot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($wedot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($wedot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($wedot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($wedot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($wedot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($wedot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($wedot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($wedot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($wedot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($wedot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($wedot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($wedot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($wedot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($wedot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($wedot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($wedot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($wedot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($wedot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($wedot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($wedot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($wedot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($wedot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($wedot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($wedot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="wedct">
							<option value="3:00 AM" <?php if($wedct == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($wedct == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($wedct == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($wedct == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($wedct == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($wedct == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($wedct == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($wedct == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($wedct == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($wedct == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($wedct == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($wedct == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($wedct == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($wedct == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($wedct == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($wedct == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($wedct == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($wedct == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($wedct == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($wedct == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($wedct == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($wedct == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($wedct == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($wedct == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($wedct == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($wedct == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($wedct == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($wedct == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($wedct == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($wedct == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($wedct == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($wedct == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($wedct == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($wedct == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($wedct == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($wedct == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($wedct == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($wedct == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($wedct == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($wedct == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($wedct == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($wedct == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($wedct == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($wedct == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($wedct == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($wedct == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($wedct == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($wedct == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="wedos" value="closed" <?php echo ($wedos == 'closed' ? '' : '');?> />
									<input type="checkbox" name="wedos" value="open" <?php echo ($wedos == 'open' ? 'checked' : '');?> />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="thuot">Thursday</label>
							<div class="col-sm-4">
							<select class="form-control" name="thuot">
							<option value="3:00 AM" <?php if($thuot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($thuot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($thuot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($thuot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($thuot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($thuot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($thuot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($thuot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($thuot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($thuot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($thuot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($thuot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($thuot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($thuot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($thuot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($thuot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($thuot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($thuot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($thuot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($thuot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($thuot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($thuot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($thuot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($thuot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($thuot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($thuot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($thuot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($thuot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($thuot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($thuot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($thuot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($thuot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($thuot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($thuot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($thuot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($thuot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($thuot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($thuot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($thuot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($thuot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($thuot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($thuot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($thuot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($thuot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($thuot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($thuot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($thuot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($thuot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="thuct">
							<option value="3:00 AM" <?php if($thuct == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($thuct == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($thuct == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($thuct == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($thuct == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($thuct == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($thuct == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($thuct == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($thuct == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($thuct == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($thuct == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($thuct == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($thuct == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($thuct == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($thuct == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($thuct == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($thuct == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($thuct == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($thuct == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($thuct == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($thuct == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($thuct == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($thuct == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($thuct == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($thuct == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($thuct == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($thuct == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($thuct == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($thuct == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($thuct == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($thuct == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($thuct == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($thuct == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($thuct == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($thuct == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($thuct == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($thuct == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($thuct == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($thuct == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($thuct == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($thuct == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($thuct == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($thuct == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($thuct == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($thuct == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($thuct == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($thuct == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($thuct == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="thuos" value="closed" <?php echo ($thuos == 'closed' ? '' : '');?> />
									<input type="checkbox" name="thuos" value="open" <?php echo ($thuos == 'open' ? 'checked' : '');?> />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="friot">Friday</label>
							<div class="col-sm-4">
							<select class="form-control" name="friot">
							<option value="3:00 AM" <?php if($friot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($friot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($friot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($friot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($friot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($friot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($friot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($friot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($friot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($friot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($friot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($friot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($friot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($friot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($friot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($friot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($friot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($friot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($friot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($friot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($friot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($friot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($friot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($friot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($friot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($friot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($friot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($friot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($friot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($friot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($friot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($friot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($friot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($friot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($friot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($friot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($friot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($friot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($friot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($friot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($friot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($friot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($friot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($friot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($friot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($friot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($friot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($friot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="frict">
							<option value="3:00 AM" <?php if($frict == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($frict == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($frict == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($frict == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($frict == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($frict == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($frict == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($frict == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($frict == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($frict == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($frict == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($frict == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($frict == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($frict == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($frict == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($frict == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($frict == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($frict == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($frict == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($frict == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($frict == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($frict == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($frict == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($frict == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($frict == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($frict == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($frict == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($frict == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($frict == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($frict == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($frict == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($frict == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($frict == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($frict == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($frict == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($frict == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($frict == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($frict == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($frict == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($frict == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($frict == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($frict == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($frict == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($frict == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($frict == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($frict == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($frict == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($frict == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="frios" value="closed" <?php echo ($frios == 'closed' ? '' : '');?> />
									<input type="checkbox" name="frios" value="open" <?php echo ($frios == 'open' ? 'checked' : '');?> />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="satot">Saturday</label>
							<div class="col-sm-4">
							<select class="form-control" name="satot">
							<option value="3:00 AM" <?php if($satot == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($satot == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($satot == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($satot == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($satot == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($satot == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($satot == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($satot == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($satot == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($satot == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($satot == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($satot == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($satot == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($satot == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($satot == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($satot == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($satot == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($satot == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($satot == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($satot == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($satot == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($satot == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($satot == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($satot == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($satot == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($satot == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($satot == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($satot == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($satot == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($satot == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($satot == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($satot == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($satot == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($satot == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($satot == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($satot == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($satot == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($satot == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($satot == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($satot == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($satot == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($satot == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($satot == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($satot == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($satot == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($satot == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($satot == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($satot == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-4">
							<select class="form-control" name="satct">
							<option value="3:00 AM" <?php if($satct == '3:00 AM'){ echo 'selected'; } ?>>3:00 AM</option>
							<option value="3:30 AM" <?php if($satct == '3:30 AM'){ echo 'selected'; } ?>>3:30 AM</option>
							<option value="4:00 AM" <?php if($satct == '4:00 AM'){ echo 'selected'; } ?>>4:00 AM</option>
							<option value="4:30 AM" <?php if($satct == '4:30 AM'){ echo 'selected'; } ?>>4:30 AM</option>
							<option value="5:00 AM" <?php if($satct == '5:00 AM'){ echo 'selected'; } ?>>5:00 AM</option>
							<option value="5:30 AM" <?php if($satct == '5:30 AM'){ echo 'selected'; } ?>>5:30 AM</option>
							<option value="6:00 AM" <?php if($satct == '6:00 AM'){ echo 'selected'; } ?>>6:00 AM</option>
							<option value="6:30 AM" <?php if($satct == '6:30 AM'){ echo 'selected'; } ?>>6:30 AM</option>
							<option value="7:00 AM" <?php if($satct == '7:00 AM'){ echo 'selected'; } ?>>7:00 AM</option>
							<option value="7:30 AM" <?php if($satct == '7:30 AM'){ echo 'selected'; } ?>>7:30 AM</option>
							<option value="8:00 AM" <?php if($satct == '8:00 AM'){ echo 'selected'; } ?>>8:00 AM</option>
							<option value="8:30 AM" <?php if($satct == '8:30 AM'){ echo 'selected'; } ?>>8:30 AM</option>
							<option value="9:00 AM" <?php if($satct == '9:00 AM'){ echo 'selected'; } ?>>9:00 AM</option>
							<option value="9:30 AM" <?php if($satct == '9:30 AM'){ echo 'selected'; } ?>>9:30 AM</option>
							<option value="10:00 AM" <?php if($satct == '10:00 AM'){ echo 'selected'; } ?>>10:00 AM</option>
							<option value="10:30 AM" <?php if($satct == '10:30 AM'){ echo 'selected'; } ?>>10:30 AM</option>
							<option value="11:00 AM" <?php if($satct == '11:00 AM'){ echo 'selected'; } ?>>11:00 AM</option>
							<option value="11:30 AM" <?php if($satct == '11:30 AM'){ echo 'selected'; } ?>>11:30 AM</option>
							<option value="12:00 PM" <?php if($satct == '12:00 PM'){ echo 'selected'; } ?>>12:00 PM</option>
							<option value="12:30 PM" <?php if($satct == '12:30 PM'){ echo 'selected'; } ?>>12:30 PM</option>
							<option value="1:00 PM" <?php if($satct == '1:00 PM'){ echo 'selected'; } ?>>1:00 PM</option>
							<option value="1:30 PM" <?php if($satct == '1:30 PM'){ echo 'selected'; } ?>>1:30 PM</option>
							<option value="2:00 PM" <?php if($satct == '2:00 PM'){ echo 'selected'; } ?>>2:00 PM</option>
							<option value="2:30 PM" <?php if($satct == '2:30 PM'){ echo 'selected'; } ?>>2:30 PM</option>
							<option value="3:00 PM" <?php if($satct == '3:00 PM'){ echo 'selected'; } ?>>3:00 PM</option>
							<option value="3:30 PM" <?php if($satct == '3:30 PM'){ echo 'selected'; } ?>>3:30 PM</option>
							<option value="4:00 PM" <?php if($satct == '4:00 PM'){ echo 'selected'; } ?>>4:00 PM</option>
							<option value="4:30 PM" <?php if($satct == '4:30 PM'){ echo 'selected'; } ?>>4:30 PM</option>
							<option value="5:00 PM" <?php if($satct == '5:00 PM'){ echo 'selected'; } ?>>5:00 PM</option>
							<option value="5:30 PM" <?php if($satct == '5:30 PM'){ echo 'selected'; } ?>>5:30 PM</option>
							<option value="6:00 PM" <?php if($satct == '6:00 PM'){ echo 'selected'; } ?>>6:00 PM</option>
							<option value="6:30 PM" <?php if($satct == '6:30 PM'){ echo 'selected'; } ?>>6:30 PM</option>
							<option value="7:00 PM" <?php if($satct == '7:00 PM'){ echo 'selected'; } ?>>7:00 PM</option>
							<option value="7:30 PM" <?php if($satct == '7:30 PM'){ echo 'selected'; } ?>>7:30 PM</option>
							<option value="8:00 PM" <?php if($satct == '8:00 PM'){ echo 'selected'; } ?>>8:00 PM</option>
							<option value="8:30 PM" <?php if($satct == '8:30 PM'){ echo 'selected'; } ?>>8:30 PM</option>
							<option value="9:00 PM" <?php if($satct == '9:00 PM'){ echo 'selected'; } ?>>9:00 PM</option>
							<option value="9:30 PM" <?php if($satct == '9:30 PM'){ echo 'selected'; } ?>>9:30 PM</option>
							<option value="10:00 PM" <?php if($satct == '10:00 PM'){ echo 'selected'; } ?>>10:00 PM</option>
							<option value="10:30 PM" <?php if($satct == '10:30 PM'){ echo 'selected'; } ?>>10:30 PM</option>
							<option value="11:00 PM" <?php if($satct == '11:00 PM'){ echo 'selected'; } ?>>11:00 PM</option>
							<option value="11:30 PM" <?php if($satct == '11:30 PM'){ echo 'selected'; } ?>>11:30 PM</option>
							<option value="12:00 AM" <?php if($satct == '12:00 AM'){ echo 'selected'; } ?>>12:00 AM</option>
							<option value="12:30 AM" <?php if($satct == '12:30 AM'){ echo 'selected'; } ?>>12:30 AM</option>
							<option value="1:00 AM" <?php if($satct == '1:00 AM'){ echo 'selected'; } ?>>1:00 AM</option>
							<option value="1:30 AM" <?php if($satct == '1:30 AM'){ echo 'selected'; } ?>>1:30 AM</option>
							<option value="2:00 AM" <?php if($satct == '2:00 AM'){ echo 'selected'; } ?>>2:00 AM</option>
							<option value="2:30 AM" <?php if($satct == '2:30 AM'){ echo 'selected'; } ?>>2:30 AM</option>
							</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="satos" value="closed" <?php echo ($satos == 'closed' ? '' : '');?> />
									<input type="checkbox" name="satos" value="open" <?php echo ($satos == 'open' ? 'checked' : '');?> />Open
									</label>
								</div>
							</div>
						</div>
					</div>
				</section> 
				<section class="content-box">
					<div class="box-title">Profile Image</div>
					<div class="form-group">
						<label for="profile-image">Add Image</label>
						<p class="recommend-size">Recommend Size: 480*270px</p>
						<input type="hidden" id="profileimage" name="profileimage" value="<?php echo $profileimage; ?>" />
						<button class="btn btn-default btn-round add-image-media">Select Image</button>
						<div class="image-holder"><?php if($profileimage != "") { ?><img src="uploads/<?php echo $profileimage; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Page Content</div>
					<div class="form-group">
						<label for="pagetitle">Page Title</label>
						<input type="text" id="pagetitle" name="pagetitle" class="form-control" placeholder="Enter Title" value="<?php echo $pagetitle; ?>"/>
					</div>
					<div class="form-group">
						<textarea type="text" class="form-control tinymce" id="page-content" name="pagecontent" ><?php echo $pagecontent; ?>
						</textarea>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Trust Badges</div>
					<div class="trust-bagdes">	
						<div class="trust-bagde-group-container">
						<?php 
						$trust = array();
						$uploadimage = explode(" &&*&& ", $data['uploadimage']);
						$trustwebsitelink = (explode(" &&*&& ", $trustwebsitelink));
						$i=0;
						for($i=0;$i<count($uploadimage);$i++){ 
								$trust[$i]['uploadimage'] = $uploadimage[$i];
								$trust[$i]['trustwebsitelink'] = $trustwebsitelink[$i];
						?>
						<div class="trust-bagde-group">
							<div class="form-group">
								<label for="uploadimage1">Add Image</label>
								<p class="recommend-size">Recommend Size: 120*100px</p>
							<input type="hidden" id="uploadimage1" name="uploadimage[]" value="<?php echo $trust[$i]['uploadimage']; ?>"/>
								<button class="btn btn-default btn-round add-image-media">Select Image</button>
								<div class="image-holder"><?php if($trust[$i]['uploadimage'] != "") { ?><img src="uploads/<?php echo $trust[$i]['uploadimage']; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
							</div>
							<div class="clearfix"></div>
							<div class="form-group">
								<label for="trustwebsitelink">Trust Website Link(optional)</label>
								<input type="url" class="form-control" id="trustwebsitelink" name="trustwebsitelink[]" value="<?php echo $trust[$i]['trustwebsitelink']; ?>">
							</div>
							<div class="remove-badges"><button class="btn btn-default btn-round remove-badge">Remove Badge</button></div>
						</div>
						<?php } ?>
						</div>
						<div class="add-badges">
							<button class="btn btn-default btn-round" id="add-badge">Add Badge</button>
						</div>
					</div>
				</section>        
				<section class="content-box">
					<div class="box-title">Trust Text</div>
					<div class="form-group">
						<label for="trusttext">Trust Text</label>
						<textarea type="text" class="form-control" rows="4" id="trusttext" name="trusttext" ><?php echo $trusttext; ?></textarea>
					</div>
				</section>-->
				<section class="content-box">
					<div class="box-title">Contact Form</div>
					<div class="contact-form-email-override-box">
										<label for="emailmesageid">Email Messages Will Be Sent To <span class="required-star">*</span></label>
										<?php 
											$email_data='';
											try{
												if(strpos($emailmesageid,"[") == 0)
													$email_data=json_decode($emailmesageid);
												else
													$email_data=$emailmesageid;
											}
											catch(Exception $e){
												$email_data=$emailmesageid;
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
										<?php else:									
											?>
										<div class="form-group">
											<input type="text" class="form-control em-msg" id="emailmesageid" name="emailmesageid[]" placeholder="Enter the email you want your messages sent to" value="<?php echo $emailmesageid; ?>" />
										</div>
										<?php endif; ?>
								</div>
								<button type="button" onclick="add_more_email_option()" class="btn btn-primary"><span><i class="fa fa-plus"></i></span> Add</button>
													<div class="add-field-btn">


				</section>
			<!--	<section class="content-box">
					<div class="box-title">Review Us Buttons</div>
					<div class="add-review">
						<div class="review-group-container">
						<?php
						$buttontitle = explode(' &&*&& ', $buttontitle);
						$buttonlink = explode(' &&*&& ', $buttonlink);
						$c = array_combine($buttontitle, $buttonlink);
						$i = 0;
						foreach($c as $key => $bt){
							$i++;
						?>
						<div class="review-group">
							<div class="form-group">
								<label for="buttontitle<?php echo $i; ?>">Button Title</label>
								<input type="text" id="buttontitle<?php echo $i; ?>" name="buttontitle[]" class="form-control" placeholder="Enter button title (ex. Review Us On Yelp)" value="<?php echo $key; ?>"/>
							</div>
							<div class="form-group">
								<label for="buttonlink<?php echo $i; ?>">Button Link</label>
								<input type="url" id="buttonlink<?php echo $i; ?>" name="buttonlink[]" class="form-control" placeholder="Enter button link (ex. http://www.example.com)" value="<?php echo $bt; ?>"/>
							</div>
							<div class="remove-review-btn"><button class="btn btn-default btn-round remove-btn">Remove Button</button></div>
						</div>
						<?php } ?>
						</div>
						<button class="btn btn-default btn-round" id="add-review-btn">Add Button</button>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Add Custom Reviews</div>
					<div class="add-review">
						<div class="add-custom-review-container">
						<?php 
						$all = array();
						$uploadprofileimage = (explode(' &&*&& ', $uploadprofileimage));
						$reviewername = (explode(' &&*&& ', $reviewername));
						$reviewsite = (explode(' &&*&& ', $reviewsite));
						$rating = (explode(' &&*&& ', $rating));
						$review = (explode(' &&*&& ', $review));
						//$result = array();
						$i=0;
						for($i=0;$i<count($uploadprofileimage);$i++){ 
						$all[$i]['uploadprofileimage'] = $uploadprofileimage[$i];
						$all[$i]['reviewername'] = $reviewername[$i];
						$all[$i]['reviewsite'] = $reviewsite[$i];
						$all[$i]['rating'] = $rating[$i];
						$all[$i]['review'] = $review[$i];
						?>
						<div class="add-custom-review">
							<div class="form-group">
								<label for="uploadprofileimage1">Add Profile Image</label>
								<p class="recommend-size">Recommend Size: 70*70px</p>
								<input type="hidden" id="uploadprofileimage1" name="uploadprofileimage[]" value="<?php echo $all[$i]['uploadprofileimage']; ?>"/>
								<button class="btn btn-default btn-round add-image-media">Select Image</button>
								<div class="image-holder"><?php if($all[$i]['uploadprofileimage'] != "") { ?><img src="uploads/<?php echo $all[$i]['uploadprofileimage']; ?>" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"><i class="fa fa-times select-delete-image" aria-hidden="true"></i><?php } ?></div>
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
							<div class="remove-reviews"><button class="btn btn-default btn-round remove-review">Remove Review</button></div>
						</div>
						<?php } ?>
						</div>
						<button class="btn btn-default btn-round" id="add-custom-review">Add Review</button>
					</div>	
				</section>
				<section class="content-box">
					<div class="box-title">Payments Accepted</div>
					<div class="cc-wrapper">
						<img src="defaultimages/amex.png" class="cc active"><img src="defaultimages/credit.png" class="cc active"><img class="cc active" src="defaultimages/applepay.png"><img src="defaultimages/discover.png" class="cc active"><img src="defaultimages/google.png" class="cc active"><img src="defaultimages/mastercard.png" class="cc active"><img src="defaultimages/money.png" class="cc active"><img src="defaultimages/paypal.png" class="cc active"><img src="defaultimages/visa.png" class="cc active">
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="checkbox">
							<label><input type="checkbox" name="americanexpress"  <?php echo ($americanexpress == 'on' ? 'checked' : '');?> /> American Express</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="creditcard" <?php echo ($creditcard == 'on' ? 'checked' : '');?> /> Credit Card</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="applepay" <?php echo ($applepay == 'on' ? 'checked' : '');?> /> Apple Pay</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="discover"  <?php echo ($discover == 'on' ? 'checked' : '');?>> Discover</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="google"   <?php echo ($google == 'on' ? 'checked' : '');?>/> Google</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="mastercard"  <?php echo ($mastercard == 'on' ? 'checked' : '');?>> Mastercard</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="cash"  <?php echo ($cash == 'on' ? 'checked' : '');?>> Cash</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="paypal"   <?php echo ($paypal == 'on' ? 'checked' : '');?>/> Paypal</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="visa"  <?php echo ($visa == 'on' ? 'checked' : '');?>/> Visa</label>
							</div>
						</div>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Add Coupon</div>
					<p>Coupons can be images or text. if no image is added then you can add a text coupon by typing the Coupon Title field and Coupon Text field.</p>
					<div class="add-coupon-location-page">
						<div class="add-coupon-container">
						<?php 
						$allcoupon = array();
						$uploadcoupanimage = (explode(' &&*&& ', $uploadcoupanimage));
						$coupontitle = (explode(' &&*&& ', $coupontitle));
						$coupantext = (explode(' &&*&& ', $coupantext));
						$coupanlink = (explode(' &&*&& ', $coupanlink));
					 	$i=0;
						for($i=0;$i<count($uploadcoupanimage);$i++){ 
						   $allcoupon[$i]['uploadcoupanimage'] = $uploadcoupanimage[$i];
						   $allcoupon[$i]['coupontitle'] = $coupontitle[$i];
						   $allcoupon[$i]['coupantext'] = $coupantext[$i];
						   $allcoupon[$i]['coupanlink'] = $coupanlink[$i];
						 ?>
						<div class="add-coupon">
							<div class="form-group">
								<label for="uploadcoupanimage<?php echo $i; ?>">Add Coupon Image</label>
								<p class="recommend-size">Recommend Size: 260*140px</p>
								<input type="hidden" id="uploadcoupanimage<?php echo $i; ?>" name="uploadcoupanimage[]" value="<?php echo $allcoupon[$i]['uploadcoupanimage']; ?>"/>
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
							<div class="remove-coupans"><button class="btn btn-default btn-round remove-coupan">Remove Coupan</button></div>
						</div>
						<?php } ?>
						</div>
						<button class="btn btn-default btn-round" id="add-coupan">Add Coupon</button>	
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Services</div>
					<div class="add-service-location-page">
						<div class="add-service-container">
						<?php 
						$allservices = array();
						$allserviceslink = array();
						$services = (explode(' &&*&& ', $services));
						$serviceslink = (explode(' &&*&& ', $serviceslinks));
						$a=0;
						for($a=0;$a<count($services);$a++){ 
						 $allservices[$i]['services'] = $services[$a];
						 $allserviceslink[$i]['serviceslink'] = $serviceslink[$a];
						?>
						<div class="add_services">
							<div class="form-group">   
								<label for="addservice<?php echo $a; ?>">Service</label>
								<textarea type="text" name="addservice[]" id="addservice<?php echo $a; ?>" class="form-control" rows="2"><?php echo $allservices[$i]['services']; ?></textarea>
								<label for="addservice1">Service Link</label>
								<input id="addservice1" name="addservicelink[]" id="addservice" value="<?php echo $allserviceslink[$i]['serviceslink']; ?>" class="form-control">
							</div>
							<div class="remove-services"><button class="btn btn-default btn-round remove-service">Remove Service</button></div>
						</div> 
						<?php } ?>
						</div>
						<button class="btn btn-default btn-round service-button" id="add-new-services">Add New Service</button>
					</div> 
				</section>
				<section class="content-box hidden">
					<div class="box-title">Module Position</div>
					<p>Drag and drop the boxes to change the page layout</p>
					<div class="dragdrop-wrapper">
						<div class="module module-breadcrumbs">
							<div class="module-label">
								<span>Breadcrumbs</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-9">
								<div class="row">
									<div class="col-xs-6">
										<div data-aspect-ratio="1:1" class="module module-map">
											<div class="module-label"><span>Map</span></div>
										</div>
									</div>
									<div class="col-xs-6">
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
				<div class="form-group">
					<label for="suite">Title</label>
					<input type="text" id="title_tag" name="title_tag" class="form-control" placeholder="Enter Title " value="<?php echo $title; ?>" />
				</div>
				<div class="form-group">
					<label for="meta_desc">Meta Description</label>
					<textarea type="text" class="form-control" rows="4" id="meta_desc" name="meta_desc"><?php echo $meta_desc; ?></textarea>
				</div>
				<div class="form-group">
					<label for="review_script">Review Script</label>
					<textarea type="text" class="form-control" rows="4" id="review_script" name="review_script"><?php echo $review_script; ?></textarea>
				</div>
                        -->
				<!--- Custom fields for review star,featured review and listing review -->
			<!--	<div class="form-group">
					<label for="review_script">Custom Review star</label>
					<textarea type="text" class="form-control" rows="4" id="customreview_star" name="customreview_star"><?php echo $custom_reviewstar; ?></textarea>
				</div>

				<div class="form-group">
					<label for="review_script">Custom Featured Review</label>
					<textarea type="text" class="form-control" rows="4" id="customfeaturereview" name="customfeaturereview"><?php echo $custom_featurereview; ?></textarea>
				</div>

				<div class="form-group">
					<label for="review_script">Custom Review Script</label>
					<textarea type="text" class="form-control" rows="4" id="customreview_script" name="customreview_script"><?php echo $custom_reviewscript; ?></textarea>
				</div>
				<!--<section class="content-box">
					<div class="box-title">Sidebar Zipcodes</div>
					<div class="add-zip-container">
						<?php 
						$allzips = array();
						$allzipslink = array();
						$extraZipcode = (explode(' &&*&& ', $extraZipcode));
						$extraZipcodelink = (explode(' &&*&& ', $extraZipcodelink));
						$a=0;
						for($a=0;$a<count($extraZipcode);$a++){ 
						 $allzips[$i]['extra_zipcode'] = $extraZipcode[$a];
						 $allzipslink[$i]['extra_zipcode_link'] = $extraZipcodelink[$a];
						?>
						<div class="add_zip">
							<div class="form-group">
								<label for="addservice1">Zipcode</label>
								<input id="addservice1" name="extra_zipcode[]" id="addzip" class="form-control" value="<?php echo $allzips[$i]['extra_zipcode']; ?>">
								<label for="addservice1">Zipcode page link</label>
								<input id="addservice1" name="extra_zipcode_link[]" id="addzip" class="form-control" value="<?php echo $allzipslink[$i]['extra_zipcode_link']; ?>">
							</div>
							<div class="remove-services"><button class="btn btn-default btn-round remove-zip">Remove Service</button></div>
						</div>
						<?php } ?>
					</div>
					<button class="btn btn-default btn-round service-button" id="add-new-zipcode">Add More zipcode</button>
				</section>-->
				<div class="submit-section">
					<div class="add-location-btn"><input type="submit" name="updateLocation" id="addLocation" class="btn btn-primary" value="Update Location" /></div>
				</div>
				</form>
				<?php } else { ?>
					<?php include "accessdenied.php"; ?>
				<?php } ?>
			</div><!-- /.content-wrapper -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	<?php include "mediapopup.php"; ?>
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	 <?php } ?>
</div><!-- /.container -->
<?php include "footer.php"; ?>
