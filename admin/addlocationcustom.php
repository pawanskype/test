<?php 
   include "header.php"; 
   $emailmessageid ='';
   ?>
	<style>
	[type="checkbox"]
{
    vertical-align:text-bottom;
}

.content-box .form-group input[type=checkbox], .content-box .form-group input[type=radio] {
    float: left;
}

.content-box .form-group .childlicense
{
	margin-top:15px;
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
		    <h1 class="page-title">Add A Custom Location</h1>
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
				<input type="hidden" name="adminid" id="AdminID" value="<?php echo $_GET['adminid']; ?>" />
				<?php } ?>
				<section class="content-box">
				    <div class="form-group">
						<label for="name">Select Business<span class="required-star">*</span></label>
				    <select class="form-control" id="select_location_type" name="select_location_type">
				        <option value="50">Restoration</option>
				        <option value="51">BLueFrog</option>
				        <option value="52">TDC</option>
				        <option value="53">Softroc</option>
				    </select>
					</div>
					<div class="box-title">Basic Information</div>
					<div class="form-group">
						<label for="name">Location Name<span class="required-star">*</span></label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Custom Location Name" value=""/>
					</div>
					<div class="form-group">
						<label for="address">Address<span class="required-star">*</span></label>
						<input type="text" id="address" name="address" class="form-control" placeholder="Enter Address" value="" />
					</div>
					<div class="form-group">
						<label for="checkid"  style="word-wrap:break-word">
									<input type="checkbox" value="1" name="addressshow">&nbsp;&nbsp;Hide Address
					 </label>						
					</div>
					<div class="form-group ">					
							<label for="suite">License</label>
							<input type="text" id="suiteLicense" name="suite" class="form-control" placeholder="License #" value="" required />
							<span style="display:none; color:red;" id="MesgError">License number is already in use.</span>
							<div class="form-group childlicense">
								<label for="checkid"  style="word-wrap:break-word">
									<input type="checkbox" value="1" name="addchild" id="addchildcheck" >&nbsp;&nbsp;Child License
								 </label>
								
							</div>
							<section class="content-box" id="childBoxblock" style="display:none;">
									<div class="trust-bagdes">	
										<div class="child-group-container tbody">
											<span style="display:none; color:red;" id="MesgErrorchild">Child License number is already in use.</span>
											<div class="trust-bagde-group1">
												<div class="clearfix"></div>
												<div class="form-group">
													<label for="childL">Enter License Number</label>
													<input type="text" class="form-control childL" name="childL[]">
												</div>
											</div>
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
								<input type="text" id="city" name="city" class="form-control" placeholder="Enter City" />
							</div>
							<div class="form-group">
								<label for="state">State<span class="required-star">*</span></label>
								<input type="text" id="state" name="state" class="form-control" placeholder="Enter State (Ex. CA)" />
							</div>	
							<div class="form-group">
								<label for="zipcode">Zipcode</label>
								<input type="text" id="zipcode-edit" name="zipcode" class="form-control" placeholder="Enter Zipcode" />
							</div>
							<div class="form-group">
								<label for="lat">Latitude<span class="required-star">*</span><a href="#" data-toggle="tooltip" title="The Latitude & Longitude values will be filled automatically on the basis of address provided you above. It can be changed manually or by dragging the marker on the map to the correct location." class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></a></label>
								<input type="text" id="lat" name="lat" class="form-control" placeholder="Enter Latitude" />
							</div>
							<div class="form-group">
								<label for="lng">Longitude<span class="required-star">*</span><a href="#" data-toggle="tooltip" title="The Latitude & Longitude values will be filled automatically on the basis of address provided you above. It can be changed manually or by dragging the marker on the map to the correct location." class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></a></label>
								<input type="text" id="lng" name="lng" class="form-control" placeholder="Enter Longitude" />
							</div>
							<div class="form-group">
								<label for="phone">Phone<span class="required-star">*</span></label>
								<input type="text" id="phone" name="phone" class="form-control" placeholder="Enter Phone #" value="" />
							</div>
							
							<div class="form-group">
								<label for="phone">Location Url<span class="required-star">*</span></label>
								<input type="text" id="locUrl" name="locUrl" class="form-control" placeholder="Enter location Url"  />
							</div>
							
							<div class="form-group">
								<label for="phone">Common Served Area<span class="required-star"></span></label>
								<input type="text" id="common_served_area" name="common_served_area" class="form-control" placeholder="Enter Common Served Area"  />
							</div>
						</div>
						<div class="col-sm-6">
							<div id="adminmap" class="preview-map"></div>
							<button class="preview-btn" id="wpsl-lookup-location">Preview Location</button><a href="javascript:void(0)" data-toggle="tooltip" title="The Preview Location is based on the provided address, city & state." class="info-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
							<p class="marker-info">The marker can be dragged on the map to get the exact location.</p>
						</div>
					</div>
				</section>
				<?php if($_GET['adminid']==50){ ?>			
				<div class="clearfix"></div>				
				<section class="content-box">
					<label for="checkid"  style="word-wrap:break-word">
						<input type="checkbox" value="1" name="extraAddress" id="extraAddress">Additional Addresses
					</label>
					<section class="content-box" id="addressBoxblock" style="display:none;">
							<div class="trust-bagdes">	
								<div class="address-group-container tbody1">
									<div class="trust-bagde-address">
										<div class="clearfix"></div>
											<div class="form-group">
												<label for="Extraaddress">Address</label>
												<input type="text" class="form-control" id="Extraaddress" name="additionaladdress[]"  placeholder="Enter Address">
											</div>
											<div class="form-group">
												<label for="ExtraHide"  style="word-wrap:break-word">
													<input type="checkbox" id="ExtraHide1" value="1" name="additionaladdressshow[]">&nbsp;&nbsp;Hide Address
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
									</div>
								</div>
								<div class="add-badges">
									<button class="btn btn-default btn-round" id="add-additional-address">Add More</button>
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
								<select class="form-control" name="sunot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="sunct">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
									<input type="hidden" name="sunos" value="closed"/>
									<input type="checkbox" name="sunos" value="open" />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="monot">Monday</label>
							<div class="col-sm-4">
								<select class="form-control" name="monot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="monct">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="hidden" name="monos" value="closed"/>
										<input type="checkbox" name="monos" value="open" checked />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="tueot">Tuesday</label>
							<div class="col-sm-4">
								<select class="form-control" name="tueot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="tuect">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="hidden" name="tueos" value="closed"/>
										<input type="checkbox" name="tueos" value="open" checked />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Wednesday</label>
							<div class="col-sm-4">
								<select class="form-control" name="wedot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="wedct">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="hidden" name="wedos" value="closed" />
										<input type="checkbox" name="wedos" value="open" checked />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="thuot">Thursday</label>
							<div class="col-sm-4">
								<select class="form-control" name="thuot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="thuct">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="hidden" name="thuos" value="closed"/>
										<input type="checkbox" name="thuos" value="open" checked />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="friot">Friday</label>
							<div class="col-sm-4">
								<select class="form-control" name="friot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="frict">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="hidden" name="frios" value="closed" />
										<input type="checkbox" name="frios" value="open" checked />Open
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="satot">Saturday</label>
							<div class="col-sm-4">
								<select class="form-control" name="satot">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM" selected>8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM">6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-4">
								<select class="form-control" name="satct">
									<option value="3:00 AM">3:00 AM</option>
									<option value="3:30 AM">3:30 AM</option>
									<option value="4:00 AM">4:00 AM</option>
									<option value="4:30 AM">4:30 AM</option>
									<option value="5:00 AM">5:00 AM</option>
									<option value="5:30 AM">5:30 AM</option>
									<option value="6:00 AM">6:00 AM</option>
									<option value="6:30 AM">6:30 AM</option>
									<option value="7:00 AM">7:00 AM</option>
									<option value="7:30 AM">7:30 AM</option>
									<option value="8:00 AM">8:00 AM</option>
									<option value="8:30 AM">8:30 AM</option>
									<option value="9:00 AM">9:00 AM</option>
									<option value="9:30 AM">9:30 AM</option>
									<option value="10:00 AM">10:00 AM</option>
									<option value="10:30 AM">10:30 AM</option>
									<option value="11:00 AM">11:00 AM</option>
									<option value="11:30 AM">11:30 AM</option>
									<option value="12:00 PM">12:00 PM</option>
									<option value="12:30 PM">12:30 PM</option>
									<option value="1:00 PM">1:00 PM</option>
									<option value="1:30 PM">1:30 PM</option>
									<option value="2:00 PM">2:00 PM</option>
									<option value="2:30 PM">2:30 PM</option>
									<option value="3:00 PM">3:00 PM</option>
									<option value="3:30 PM">3:30 PM</option>
									<option value="4:00 PM">4:00 PM</option>
									<option value="4:30 PM">4:30 PM</option>
									<option value="5:00 PM">5:00 PM</option>
									<option value="5:30 PM">5:30 PM</option>
									<option value="6:00 PM" selected>6:00 PM</option>
									<option value="6:30 PM">6:30 PM</option>
									<option value="7:00 PM">7:00 PM</option>
									<option value="7:30 PM">7:30 PM</option>
									<option value="8:00 PM">8:00 PM</option>
									<option value="8:30 PM">8:30 PM</option>
									<option value="9:00 PM">9:00 PM</option>
									<option value="9:30 PM">9:30 PM</option>
									<option value="10:00 PM">10:00 PM</option>
									<option value="10:30 PM">10:30 PM</option>
									<option value="11:00 PM">11:00 PM</option>
									<option value="11:30 PM">11:30 PM</option>
									<option value="12:00 AM">12:00 AM</option>
									<option value="12:30 AM">12:30 AM</option>
									<option value="1:00 AM">1:00 AM</option>
									<option value="1:30 AM">1:30 AM</option>
									<option value="2:00 AM">2:00 AM</option>
									<option value="2:30 AM">2:30 AM</option>
								</select>
							</div>
							<div class="col-sm-2">
								<div class="checkbox">
									<label>
										<input type="hidden" name="satos" value="closed" />
										<input type="checkbox" name="satos" value="open" />Open
									</label>	  
								</div>
							</div>
						</div>
					</div>
				</section>
               
				<section class="content-box">
					<div class="box-title">Profile Image</div>
					<div class="form-group">
						<label for="profileimage">Add Image</label>
						<p class="recommend-size">Recommend Size: 480*270px</p>
						<input type="hidden" id="profileimage" name="profileimage" />
						<button class="btn btn-default btn-round add-image-media">Select Image</button>
						<div class="image-holder"></div>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Page Content</div>
					<div class="form-group">
						<label for="pagetitle">Page Title</label>
						<input type="text" id="pagetitle" name="pagetitle" class="form-control" placeholder="Enter Title" />
					</div>
					<div class="form-group">
						<textarea type="text" class="form-control tinymce" id="page-content" name="pagecontent">
						</textarea>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Trust Badges</div>
					<div class="trust-bagdes">	
						<div class="trust-bagde-group-container">
							<div class="trust-bagde-group">
								<div class="form-group">
									<label for="uploadimage1">Add Image</label>
									<p class="recommend-size">Recommend Size: 120*100px</p>
									<input type="hidden" id="uploadimage1" class="uploadimage" name="uploadimage[]" />
									<button class="btn btn-default btn-round add-image-media">Select Image</button>
									<div class="image-holder"></div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label for="trustwebsitelink">Trust Website Link(optional)</label>
									<input type="url" class="form-control" id="trustwebsitelink" name="trustwebsitelink[]">
								</div>
							</div>
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
						<textarea type="text" class="form-control" rows="4" id="trusttext" name="trusttext"></textarea>
					</div>
				</section> -->
				<section class="content-box">
					<div class="box-title">Contact Form</div>
						<div class="contact-form-email-override-box">
										<label for="emailmesageid">Email Messages Will Be Sent To <span class="required-star">*</span></label>
										
										<div class="form-group">
											<input type="text" class="form-control em-msg" id="emailmesageid" name="emailmesageid[]" placeholder="Enter the email you want your messages sent to" value="<?php echo $emailmessageid; ?>" />
										</div>
								</div>
								<button type="button" onclick="add_more_email_option()" class="btn btn-primary"><span><i class="fa fa-plus"></i></span> Add</button>
													<div class="add-field-btn">

			</section>
			<!--	<section class="content-box">
					<div class="box-title">Review Us Buttons</div>
					<div class="add-review">
						<div class="review-group-container">
							<div class="review-group">
								<div class="form-group">
									<label for="buttontitle1">Button Title</label>
									<input type="text" id="buttontitle1" name="buttontitle[]" class="form-control" placeholder="Enter button title (ex. Review Us On Yelp)" />
								</div>
								<div class="form-group">
									<label for="buttonlink1">Button Link</label>
									<input type="text" id="buttonlink1" name="buttonlink[]" class="form-control" placeholder="Enter button link (ex. http://www.example.com)" />
								</div>
							</div>
						</div>
						<button class="btn btn-default btn-round" id="add-review-btn">Add Button</button>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Add Custom Reviews</div>
					<div class="add-review">
						<div class="add-custom-review-container">
							<div class="add-custom-review">
								<div class="form-group">
									<label for="uploadprofileimage1">Add Profile Image</label>
									<p class="recommend-size">Recommend Size: 70*70px</p>
									<input type="hidden" id="uploadprofileimage1" name="uploadprofileimage[]" />
									<button class="btn btn-default btn-round add-image-media">Select Image</button>
									<div class="image-holder"></div>
								</div>
								<div class="clearfix"></div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
										<label for="reviewername1">Reviewer Name</label>
										<input type="text" id="reviewername1" name="reviewername[]" class="form-control" placeholder="Enter the reviewer's name" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
										<label for="reviewsite1">Review Site</label>
											<select id="reviewsite1" name="reviewsite[]" class="form-control">
												<option value="" selected>Select</option>
												<option value="Yelp">Yelp</option>
												<option value="Google">Google</option>
												<option value="Superpages">Superpages</option>
												<option value="Foursquare">Foursquare</option>
											</select>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
										<label for="rating1">Rating</label>
										<select class="form-control" id="rating1" name="rating[]">
											<option value="" selected>Select</option>
											<option value="1">1</option>
											<option value="1.5">1.5</option>
											<option value="2">2</option>
											<option value="2.5">2.5</option>
											<option value="3">3</option>
											<option value="3.5">3.5</option>
											<option value="4">4</option>
											<option value="4.5">4.5</option>
											<option value="5">5</option>
										</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="review1">Review</label>
									<textarea type="text" id="review1" name="review[]" class="form-control" rows="4"></textarea>
								</div>
							</div>
						</div>
						<button class="btn btn-default btn-round" id="add-custom-review">Add Review</button>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Payments Accepted</div>
					<div class="cc-wrapper">
						<img src="defaultimages/amex.png" class="cc active"><img src="defaultimages/credit.png" class="cc active"><img src="defaultimages/applepay.png" class="cc active"><img src="defaultimages/discover.png" class="cc active"><img src="defaultimages/google.png" class="cc active"><img src="defaultimages/mastercard.png" class="cc active"><img src="defaultimages/money.png" class="cc active"><img src="defaultimages/paypal.png" class="cc active"><img src="defaultimages/visa.png" class="cc active">
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="americanexpress" checked /> American Express</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="creditcard" /> Credit Card</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="applepay" /> Apple Pay</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="discover" checked> Discover</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="google" checked /> Google</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="mastercard" checked> Mastercard</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="cash" checked> Cash</label>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="checkbox">
								<label><input type="checkbox" name="paypal" checked /> Paypal</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" name="visa" checked /> Visa</label>
							</div>
						</div>
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Add Coupon</div>
					<p>Coupons can be images or text. if no image is added then you can add a text coupon by entering the Coupon Title field and Coupon Text field.</p>
					<div class="add-coupon-location-page">
						<div class="add-coupon-container">
							<div class="add-coupon">
								<div class="form-group">
									<label for="uploadcoupanimage1">Add Coupon Image</label>
									<p class="recommend-size">Recommend Size: 260*140px</p>
									<input type="hidden" id="uploadcoupanimage1" name="uploadcoupanimage[]" />
									<button class="btn btn-default btn-round add-image-media">Select Image</button>
									<div class="image-holder"></div>
								</div>
								<div class="clearfix"></div>
								<div class="form-group">
									<label for="coupontitle1">Coupon Title</label>
									<input type="text" id="coupontitle1" name="coupontitle[]" class="form-control" placeholder="Enter coupon title (ex. Friday Sale)" />
								</div>
								<div class="form-group">
									<label for="coupantext1">Coupon Text (optional)</label>
									<textarea type="text" id="coupantext1" name="coupantext[]" class="form-control" rows="4"></textarea>
								</div>
								<div class="form-group">
									<label for="coupanlink1">Coupon Link (optional)</label>
									<input type="url" id="coupanlink1" name="coupanlink[]" class="form-control" placeholder="Enter coupon link (ex. http://www.couponlink.com)" />
								</div>
							</div>
						</div>
						<button class="btn btn-default btn-round" id="add-coupan">Add Coupon</button>	
					</div>
				</section>
				<section class="content-box">
					<div class="box-title">Services</div>
					<div class="add-service-container">
						<div class="add_services">
							<div class="form-group">
								<label for="addservice1">Service</label>
								<textarea id="addservice1" name="addservice[]" id="addservice" class="form-control" rows="2"></textarea>
								<label for="addservice1">Service Link</label>
								<input id="addservice1" name="addservicelink[]" id="addservice" class="form-control">
							</div>
						</div>
					</div>
					<button class="btn btn-default btn-round service-button" id="add-new-services">Add New Service</button>
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
					<input type="text" id="title_tag" name="title_tag" class="form-control" placeholder="Enter Title " value="" />
				</div>
				<div class="form-group">
					<label for="meta_desc">Meta Description</label>
					<textarea type="text" class="form-control" rows="4" id="meta_desc" name="meta_desc"></textarea>
				</div>
				<div class="form-group">
					<label for="review_script">Review Script</label>
					<textarea type="text" class="form-control" rows="4" id="review_script" name="review_script"></textarea>
				</div>
                                    -->
				<!--- Custom fields for review star,featured review and listing review -->
			<!--	<div class="form-group">
					<label for="review_script">Custom Review star</label>
					<textarea type="text" class="form-control" rows="4" id="customreview_star" name="customreview_star"></textarea>
				</div>

				<div class="form-group">
					<label for="review_script">Custom Featured Review</label>
					<textarea type="text" class="form-control" rows="4" id="customfeaturereview" name="customfeaturereview"></textarea>
				</div>

				<div class="form-group">
					<label for="review_script">Custom Review Script</label>
					<textarea type="text" class="form-control" rows="4" id="customreview_script" name="customreview_script"></textarea>
				</div>
                                    -->
			
				<div class="submit-section">
					<div class="add-location-btn"><input type="submit" name="addLocation" id="addLocation" class="btn btn-primary" value="Add Location" /></div>
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
