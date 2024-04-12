<?php //

include "header.php";
?>
<?php if(in_array($_GET["adminid"],array("49","50"))){
	
	
	?>
<style>
.sitemapexport
{
	border: 1px solid rgba(0,0,0,.1);
    padding: 10px;
}
</style>
<?php } ?>
  <body class="admin-panel">
       <!-- <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div>  -->
    <div class="container admin-body">
    

	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $locations == "on" && in_array($locationsrow['id'], $elocationresultsarray))) { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
        <div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">Locations</h1>
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
				
				<?php if($role=='subadmin'){ ?>
					<a href="preview" target="_blank" class="preview_btn_sub"><input type="button" class="btn btn-success btn-sm" name="preview" value="Preview"></a>
					<?php } ?>
                         
            <section class="content-section map-content-section">
                <div class="form-group">
						<label for="name">Select Business<span class="required-star">*</span></label>
				    <select style=" width: 179px;" class="form-control" id="select_loc_business" name="select_location_type">
				        <option <?php echo ($_GET['adminid'] == 50) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/locations.php?adminid=50">Restoration</option>
				        <option <?php echo ($_GET['adminid']  == 51) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/locations.php?adminid=51">BLueFrog</option>
				        <option <?php echo ($_GET['adminid'] == 52) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/locations.php?adminid=52">TDC</option>
				         <option <?php echo ($_GET['adminid'] == 53) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/locations.php?adminid=53">Softroc</option>
				    </select>
					</div>
			<div id="multiple-marker-map"></div>
              <div id="location-list">
				<form action="inc/submit.php" method="POST" id="add-new-user">
				<?php if($role == 'superadmin') { ?>
					<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
				<?php } ?>
					<div class="table-responsive">
						<table id="locations-table" class="table table-striped table-bordered admin-location-table" width="100%" cellspacing="0">
						<input type="checkbox" id="checkAll" class="custom-check">
							<thead>
								<tr>
									<th></th>
									<th class="sort-icons">Location ID
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Location
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">City
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Zip
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">State
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Phone
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Edit Page
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
								</tr>
							</thead>
							<tbody class="list">
							<?php while($row = mysqli_fetch_assoc($query)){ 
							
							$row1[] = $row['id']; $row2[] = $row['name']; $row3[] = $row['lat']; $row4[] = $row['lng']; ?>
								<tr>
									<td><div class="checkbox"><label><input type="checkbox" class="checkbox" name="checkb[]" value="<?php echo $row['id']; ?>"></label></div></td>
									<td class="location-zipcode"><?php echo $row['id']; ?></td>
									<td class="location-zipcode"><?php echo $row['name']; ?></td>
									<td class="location-city"><?php echo $row['city']; ?></td>
									<td class="location-zipcode"><?php echo $row['zipcode']; ?></td>
									<td class="location-state"><?php echo $row['state']; ?></td>
									<td class="location-phone"><?php echo substr($row['phone'], 0, 3).substr($row['phone'], 3, 3)."-".substr($row['phone'],6); ?></td>
									<td><a href="locationsedit.php?<?php if($role == "superadmin") { echo "adminid=".$_GET['adminid']."&"; }?>locationid=<?php echo $row['id']; ?>"><span class="icon-edit"><i class="fa fa-edit"></i></span></a></td>
								</tr>
							<?php }
							foreach($row1 as $key => $value){
								$result[$value] = array(
									'id' => $row1[$key],
									'name' => $row2[$key],
									'lat' => $row3[$key],
									'lng' => $row4[$key]
							);
							 $locationsmarkdata[] = '['."'".'<a href="'.$adminurl.'/locationsedit.php?adminid='.$_GET['adminid'].'&locationid='.$result[$value]["id"].'">'.str_replace("'", "", $result[$value]["name"]).''."</a>',".' '.$result[$value]["lat"].' '.",".' '.$result[$value]["lng"].']'.",";
							 }
							$locations_show = implode(" ", $locationsmarkdata);
							?>
							</tbody>
						</table>
					</div>
                                        
					<div class="remove-selected-users">
						<input type="submit" class="btn btn-danger delete" value="Delete Location(s)" name="locations" />
                                                <!--<input type="button" class="btn btn-success publish_locations" value="Publish Locations" onclick="javascript:publishLocations();" name="public_locations" />-->
					</div>
                                        
                                </form>
              </div>
            </section>
          </div><!-- /.content-wrapper -->
        </div><!-- /.col -->
      </div><!-- /.row -->
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	<?php } ?>
    </div><!-- /.container -->
<?php  $_SESSION['session_adminid']=!empty($_GET['adminid']) ? $_GET['adminid'] : ""; 

?>
<script>
	var locations = [
		<?php echo $locations_show; ?>
	];
</script>
<script>
/*Script - Multiple Markers Map - Locations Page - Start*/	
      var map = new google.maps.Map(document.getElementById('multiple-marker-map'), {
		zoom: 10,
		center: new google.maps.LatLng(-37.92, 151.25),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		mapTypeControl: false,
		streetViewControl: false,
		panControl: false,
		zoomControlOptions: {
                   position: google.maps.ControlPosition.LEFT_BOTTOM
                  }
    });
    var infowindow = new google.maps.InfoWindow({
		maxWidth: 160
    });
    var markers = new Array();
    var iconCounter = 0;
    // Add the markers and infowindows to the map
    for (var i = 0; i < locations.length; i++) {  
		var marker = new google.maps.Marker({
			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			map: map,
		});
		markers.push(marker);
		google.maps.event.addListener(marker, 'click', (function(marker, i) {
			return function() {
				infowindow.setContent(locations[i][0]);
				infowindow.open(map, marker);
			}
		})(marker, i));
     	       iconCounter++;
    }

 function autoCenter() {
      var bounds = new google.maps.LatLngBounds();
		for (var i = 0; i < markers.length; i++) {  
			bounds.extend(markers[i].position);
		}
      //  Fit these bounds to the map
		map.fitBounds(bounds);
    }
    autoCenter();
/*Script - Multiple Markers Map - Locations Page - End*/	
function publishLocations()
{
    var redirect_url ="https://store-locator.lssdev.com/admin/updatelocationstatus.php?admin_id=<?php echo $_GET['adminid'] ?>";

    window.location.href=redirect_url;
    
} 
      

</script>
<style>
.location-phone {
    width: 16%;
}
</style>
<?php include 'footer.php'; ?>
