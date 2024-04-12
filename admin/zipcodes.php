<?php 
include "header.php"; 

?>
  <body class="admin-panel">
       <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" )) { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
        <div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">Zipcodes</h1>
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
				                               
            <section class="content-section map-content-section">
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
									<th class="sort-icons">Parent location ID
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Parent location Name
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Location
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Zip
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">City
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">State
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
							<?php 
							while($row = mysqli_fetch_assoc($queryzip)){

							 $row1[] = $row['id']; $row2[] = $row['zip_name']; $row3[] = $row['zipcode']; $row4[] = $row['state']; $row5[] = $row['country']; $row6[] = $row['phone_no'];?>
								<tr>
									<td><div class="checkbox"><label><input type="checkbox" class="checkbox" name="checkzipb[]" value="<?php echo $row['id']; ?>"></label></div></td>
									<td class="location-locationid"><?php echo $row['loc_id']; ?></td>
									<td class="location-locationid"><?php
										if($row['parent_loc_name']==''){
											$zipcodesquery = mysqli_query($con, "SELECT name FROM markers WHERE id=".$row['loc_id']);
											$zipcodesdata = mysqli_fetch_assoc($zipcodesquery);
											if($zipcodesdata)
											 echo $zipcodesdata['name'];
											else
												echo '';
										}else{									
										echo $row['parent_loc_name'];
										} ?></td>
									<td class="location-zipcode"><?php echo $row['zip_name']; ?></td>
									<td class="location-city"><?php  $result = explode(',',$row['zipcode']); 
									   // print_r($result);
									    foreach($result as $value){
											echo  $value; echo "<br>";
										}
									?></td>
									<td class="location-zipcode"><?php echo $row['city']; ?></td>
									<td class="location-state"><?php echo $row['state']; ?></td>
									<td><a href="editzipcode?<?php if($role == "superadmin") { echo "adminid=".$_GET['adminid']."&"; }?>zipcodeid=<?php echo $row['id']; ?>"><span class="icon-edit"><i class="fa fa-edit"></i></span></a></td>
								</tr>
							<?php }
						/*	
							foreach($row1 as $key => $value){
								$result[$value] = array(
									'id' => $row1[$key],
									'zip_name' => $row2[$key],
									'zipcode' => $row3[$key],
									'state' => $row4[$key],
									'country' => $row5[$key],
									'phone_no' => $row6[$key]
							);
								 
							 $locationsmarkdata[] = '['."'".'<a href="'.$adminurl.'/zipcodedit?zipcodeid='.$result[$value]["id"].'">'.str_replace("'", "", $result[$value]["zip_name"]).''."</a>',".' '.$result[$value]["state"].' '.",".' '.$result[$value]["country"].']'.",";
							 }
							$locations_show = implode(" ", $locationsmarkdata);
						*/
							?>
							</tbody>
						</table>
					</div>
                                        
					<div class="remove-selected-users">
						<input type="submit" class="btn btn-danger delete" value="Delete Zipcode(s)" name="zipCodes" />
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
/*	var locations = [
		<?php echo $locations_show; ?>
	];*/
</script>
<?php include 'footer.php'; ?>
