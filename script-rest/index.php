<!------------------------------------Store Locator Script Body Part Start----------------------------------->
<style>
.store-page .btn.btn-sm {
	font-size: 20px;
	line-height: 12px;
	padding: 8px 18px;
}
</style>
    <?php
    
	include "phpsqlsearch_dbinfo.php";
	
	include "variables.php";

function getAddress() {
    $protocol = $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

?>

<?php switch ($loadpage) { 
case "thankcontent": 
	echo '<div class="col-sm-12"><h3>Thanks for Contacting Us. We will get back you shortly.</h3></div>';
	break;

	case "index": ?>
<!----------------------------------------------Page Index Start---------------------------------------------->
<div class="store-page">
  <div class="container-fluid">
         		<div class="map-section">
			<div class="row no-gutter">                                                
				<div class="col-sm-4">
					<div class="locate">
						<div class="locate-inner">
							<?php 
							 if($adminId == 50){ ?>
								 <div class="locate-pre-title">Find Your Local</div>
								 <div class="locate-title">Restoration1</div>
							<?php } else{
							?>
								<div class="locate-pre-title">Location</div>
								<div class="locate-title">Find a store</div>
							<?php } ?>
							<div class="form-group has-feedback">
								<p style="display:none; color:#F15822;" id="CursorShow">Zip Code or State Code</p>
							<input type="text" id="addressInput" class="search-query form-control" size="10" placeholder="Zip Code or State Code" />
                                   
						                                         
							</div>
							<div class="submit-box">
							<!--<span id="searchid" style="display:none; color:green;">Click on search</span>-->
							<button id="searchBtn" class="btn btn-default btn-round" type="submit" onclick="searchLocations(), disableBtn()" aria-label="Search">Search</button>	
                            	<img class="loading_state" style="display:none;" src="https://www.restoration1.com/wp-content/themes/restone-2019/images/Spinner-1.gif">						
							</div>
						</div>
						<ul id="locationSelect" style="visibility:hidden"></ul>
					</div>
				</div>
				
				<div class="col-sm-8">
					<div id="map" style="width: 100%;"></div>
				</div>
			</div>
		</div>
    </div>
            <!-- <a href="?servicelocations" class="btn btn-xs btn-success service_store_locations">Service Locations</a>-->
</div>
<script>
    $(document).ready(function(){
        var protocol=document.location.protocol;

            if($.trim(protocol)==$.trim('https:'))
            {

                $("#myaddressInput").show();
            }else{

                $("#myaddressInput").hide();
            }
        
    });

</script>
<!----------------------------------------------Page Index End------------------------------------------------>
	<?php break; 
	case "location": ?>
<!----------------------------------------------Page Location Start-------------------------------------------->
<div class="store-page">
    <div class="container-fluid">
		<div class="map-section">
			<div class="row no-gutter">
				<div class="col-sm-4">
					<div class="locate-select-box">
					<!------------Profile Image Start------------------>
					<?php switch ($profile_image_select) {
						case "Global Profile Image": ?>
							<?php if($profileimage_global != "") { ?>
							<div class="profile-pic">
								<div class="back-btn-container">
									<button class="btn btn-round btn-locate-back" onclick="goBack()"><i class="fa fa-arrow-left back-arrow-icon" aria-hidden="true" aria-label="Back"></i>Back</button>
									
								</div>
                                                          <div class="main_img_div">

                                                             <div class="img_div">
                                                                 <a class="img_div_a">
							           <img src="<?php echo $adminurl; ?>/uploads/<?php echo $profileimage_global; ?>" class="sp-image" alt="<?php echo pathinfo($profileimage_global, PATHINFO_FILENAME); ?>"/>
                                                                 </a>
                                                            </div>
                                                          </div>
                                                         </div>
							<?php } ?>
					<?php break;
						case "Profile Image": ?>
							<?php if($profileimage != "") { ?>
							<div class="profile-pic">
								<div class="back-btn-container">
									<!--<a href="/locations" class="btn btn-round btn-locate-back"><i class="fa fa-arrow-left back-arrow-icon" aria-hidden="true"></i>Back</a>-->
                                    <a href="/find-my-location/" class="btn btn-round btn-locate-back"><i class="fa fa-arrow-left back-arrow-icon" aria-hidden="true"></i>Back</a>
								</div>
                                                          <div class="main_img_div"> 
                                                            <div class="img_div">
                                                                <a class="img_div_a">
								    <img src="<?php echo $adminurl; ?>/uploads/<?php echo $profileimage; ?>" class="sp-image" alt="<?php echo pathinfo($profileimage, PATHINFO_FILENAME); ?>"/>
                                                                </a>
                                                            </div>
                                                          </div>
                                                         </div>
							<?php } ?>
					<?php break;
						case "Street View": ?>
							<div class="profile-pic">
								<div class="back-btn-container">
									<button class="btn btn-round btn-locate-back" onclick="goBack()"><i class="fa fa-arrow-left back-arrow-icon" aria-hidden="true" aria-label="Back"></i>Back</button>
								</div>
								<div id="pano"></div>
							</div>
					<?php break;
						default: ?>
					<?php } ?>
					<!------------Profile Image End------------------>
								
					<div class="pane">
						<?php if($name != "") { ?><h2 class="store-name"><?php echo $name; ?></h2><?php } ?>

				<?php 
				
					if($customreview_star != ''){			//new script added in db
							?>
										<div class="ratings"> 
												<?php echo $customreview_star ; ?>
										</div>
				<?php
					}
					else
					 {
						switch($custom_reviews_status) 
						{
							case "Global Custom Reviews" : ?>
							<?php if($rating_globalcount > 0) { ?>
							
								<div class="rating">
									<div class="rating-score"><?php //echo round($averagestars_global, 2); ?></div>
										<div class="ratings">
											<div class="empty-stars"></div>
											<div class="full-stars" style="width:<?php echo round($averagestars_global, 2) * 20; ?>%"></div>
										</div>
									<span class="reviews-count"><?php echo $rating_globalcount; ?> Reviews</span>
								 </div>
						     <?php } ?>
								<?php break; 
									case "Custom Reviews": ?>
									<?php if($ratingcount > 0) { ?>
									
									<div class="rating">
										<div class="rating-score"><?php //echo round($averagestars, 2); ?></div>
										<div class="ratings">
											<div class="empty-stars"></div>
											<div class="full-stars" style="width:<?php echo round($averagestars, 2)*20; ?>%"></div>										
										</div>
										<span class="reviews-count"><?php echo $ratingcount; ?> Reviews</span>
										
									</div>
									<?php } ?>
								<?php break;	
								default: ?>	
						<?php }
					}	
					?>	
							<ul class="nap-list">
								<?php if($address || $city || $state || $zipcode != "") { ?>
								<li>
									<div class="nap-icon">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
									</div>
									<div class="l-store-address" id="address">
										<?php 
										if($addressshow != 1){
											//echo $address.", ";
										}
											
										echo $city.", ".$state.' '.$zipcode; ?> 
										
									</div>
								</li>
								<?php } ?>
								<?php if($phone != "") { ?>
								<li>
									<div class="nap-icon">
										<i class="fa fa-phone" aria-hidden="true"></i>
									</div>
									<div class="l-store-phone">
										<?php 
                                                                                if (strpos($phone, '-') !== false) {
                                                                                            echo $phone;
                                                                                       }else{
                                                                                           echo "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6); 
                                                                                       }
                                                                
                                                                
                                                                                  ?>
									</div>
								</li>
								<?php } ?>
								
								
							  <?php switch ($business_hours_select) { 
								case "Global Business Hours": ?>
								<?php if($todayglobalStatus != "") { ?>
								<li>
									<div class="nap-icon">
										<i class="fa fa-clock-o" aria-hidden="true"></i>
									</div>
									<div class="l-store-open">
										<span class="storestatus"><?php echo $todayglobalStatus; ?></span>
									</div>
								</li>
								<?php } ?>
								<?php break;
								case "Business Hours":  ?>
								<?php if($todayStatus != "") { ?>
								   <li>
									<div class="nap-icon">
										<i class="fa fa-clock-o" aria-hidden="true"></i>
									</div>
									<div class="l-store-open">
										<span class="storestatus"><?php echo $todayStatus; ?></span>
									</div>
								  </li>
								<?php } ?>
								<?php break;
								default: ?>
								<?php }	?>	
							</ul>
						</div>
						<div class="pane-buttons">
							<table>
								<tbody>
									<tr>
										<td>
											<a href="tel:<?php echo $phone; ?>" onclick="callClicks()">
												<i class="fa fa-phone" aria-hidden="true"></i>
												<div class="pbtext-wrapper">Click to Call</div>
											</a>
										</td>
										<?php
										 if($adminId != 50){ ?>
										<td>
											<a href="https://www.google.com/maps/dir/Current+Location/<?php echo $lat; ?>,<?php echo $lng; ?>" target="_blank" onclick="directionClicks()">
												<i class="fa fa-hand-o-right" aria-hidden="true"></i>
												<div class="pbtext-wrapper">Get Directions</div>
											</a>
										</td>
										<?php
										 } ?>
										<td>
										
											<a href="/find-my-location/<?php echo str_replace(' ', '_',$city).'/'.$pageId; ?>/detail">
												<i class="fa fa-info-circle" aria-hidden="true"></i>
												<div class="pbtext-wrapper">Location Details</div>
											</a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-sm-8">
					<div id="locationmap" class="location-height"></div>
				</div>
			</div>
		</div>
	</div>	
<script>
console.log("latitude "+latitude);
console.log("longitude "+longitude);

	var myCenter = new google.maps.LatLng(latitude,longitude);
	function initialize() {
		var mapProp = {
			center: myCenter,
			zoom : 15,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById('locationmap'), mapProp);
		var marker = new google.maps.Marker({
			position : myCenter,
			animation:google.maps.Animation.BOUNCE
		});
		marker.setMap(map);
		var ADDRESSshow='';
			if(locationaddressshow != 1){
				//ADDRESSshow = locationaddress+', ';
				ADDRESSshow = '';
			}
			var CITY = locationcity.replace(" ", "_");
		var infowindow = new google.maps.InfoWindow({			
			content : '<div class="marker-store-name"><a href="/find-my-location/'+CITY+'/'+locationslug+'/detail">'+locationname+'</a></div><div class="marker-store-address">'+ADDRESSshow +' '+locationcity+' , '+locationstate+' </div><div class="marker-phone-number">'+locationphone+'</div>'
		});
		google.maps.event.addListener(marker, 'click', function(){
			marker.setAnimation(null);
			infowindow.open(map, marker);
		});
  }
 google.maps.event.addDomListener(window, 'load', initialize);
 locationPhone = '<?php echo "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6) ?>';
localStorage.setItem('r1-location-phone', locationPhone);
</script>
</div>
<!----------------------------------------------Page Location End---------------------------------------------->
	<?php break;
	case "locationdetails":	?>
<!----------------------------------------------Page Location Details Start------------------------------------>
<?php
		//redirect to main location url 21.10.2020
	//get parent id
	$sqlloc='SELECT r1_number_parent FROM `zipcodesnew` WHERE `parent_loc_name` LIKE "%'.$name.'%" limit 1 ';
	$result_loc = mysqli_query($conn,$sqlloc);
	if(mysqli_num_rows($result_loc)>0 ){
		$row_loc = $result_loc->fetch_row();	
		$locparent_id=$row_loc['0'];		
	
		if($locparent_id != 'INACTIVE'){
			//fetch url based upon parent id
			$postquery="SELECT url FROM `locationsurl` WHERE `parent_id` = ".$locparent_id;
			$post1_result = mysqli_query($conn,$postquery);
			  if(mysqli_num_rows($post1_result) > 0)
			  {
				 if(mysqli_num_rows($post1_result)>0 ){
						 $rowloc2 = $post1_result->fetch_row();
						$redirectURLloc=$rowloc2[0];
						?>
						<script>
								window.location.href="<?php echo $redirectURLloc;?>";
						</script>
						<?php
					
				 }
			  }
		}
	}

    session_start();

    if (!isset($_SESSION["visits"]))
        $_SESSION["visits"] = 0;
		$_SESSION["visits"] = $_SESSION["visits"] + 1;
		//echo $_SESSION["visits"];
    
	if ($_SESSION["visits"] == 1) { ?>
	<script>
		$.ajax({
			url:"https://www.restoration1.com/store-locator/script-rest/inc/consultation.php",
			type: "POST",
			data: {locationid: locationid, adminid: adminid, pageviews: "pageviews"},
			success: function(result){
				//alert(result);
			}
		});
	</script>
	<?php } ?>	
<div class="store-page">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12">
			<div class="store-page-bg">
				<div class="breadcrumb sp-breadcrumb">
					<?php echo "<a href='".dirname($pageId)."'>Location</a> >>".$city.">> Detail"; ?>
				</div>
			</div>
        </div>
      </div>
    </div><!-- /.container -->

   <div class="container-fluid sp-body" itemscope itemtype="http://schema.org/LocalBusiness" itemprop="image">
    <div class="store-page-bg">
      <div class="row">
        <div class="col-md-9">
          <div class="row sp-header-wrapper">
            <div class="col-sm-6">
				<div class="iframe-wrapper">
					<div id="landingmap" style="height:400px;"></div>
				</div>
            </div>
            <div class="col-sm-6">
              <div class="sp-nap-data">
                <?php if($name != "") { ?><div itemprop="name"><h2 class="sp-nap-name"><?php echo $name; ?></h2></div><?php } ?>
				<input type="hidden" name="pageview" value="<?php echo $locationId; ?>" />


				<!------------Star Reviews Start------------------>
			<?php
				 if($customreview_star != ''){
				?>
					<div class="rating">
							<div class="rating-score" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><span><?php //echo round($averagestars, 2); ?></span></div>
							<div class="ratings">
								<?php echo $customreview_star; ?>
							</div>
					</div>		
				<?php
				 }
				else{
					switch($custom_reviews_status) {
						case "Global Custom Reviews" : ?>
							<?php if($rating_globalcount > 0) { ?>
							
							<div class="rating">
								<div class="rating-score" itemscope="" itemtype="http://schema.org/Rating"><span><?php //echo round($averagestars_global, 2); ?></span></div>
								<div class="ratings">
									<div class="empty-stars"></div>
									<div class="full-stars" style="width:<?php echo round($averagestars_global, 2) * 20; ?>%"></div>
								</div>
								<span class="reviews-count"><?php echo $rating_globalcount; ?> Reviews</span>
							</div>
							<?php } ?>
						<?php break; 
							case "Custom Reviews": ?>
							<?php if($ratingcount > 0) { ?>
							
							<div class="rating">
								<div class="rating-score" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><span><?php //echo round($averagestars, 2); ?></span></div>
								<div class="ratings">
									<div class="empty-stars"></div>
									<div class="full-stars" style="width:<?php echo round($averagestars, 2) * 20; ?>%"></div>
							
								</div>
								<span class="reviews-count"><?php echo $ratingcount; ?> Reviews</span>							
							</div>
							<?php } ?>
						<?php break;	
						default: ?>	
			<?php	 } 
				
				}
				?>	
				<!------------Star Reviews End------------------>
			
				<ul class="sp-nap-list">
					<li>
						<div class="icon"><i class="material-icons">place</i></div>
						<?php if($address && $city && $state != "") { ?>
						<div itemtype="http://schema.org/PostalAddress" itemscope="" itemprop="address">
						<div class="address"><a href="#"><?php if($addressshow !=1) { ?><span itemprop="streetAddress"><?php //echo $address; ?></span><br/><?php }?><span itemprop="addressLocality"><?php echo $city; ?></span>, <span itemprop="addressRegion"><?php echo $state; ?></span> <span itemprop="postalCode"><?php echo $zipcode; ?></span></a></div>
						</div>
						<?php } ?>
					</li>
					<li>
						<!--<div class="icon"><i class="material-icons">phone</i></div>-->
					<div class="phone">
						<span itemprop="telephone">
							<a href="tel:<?php echo $phone; ?>" class="btn btn-primary btn-sm get-direction-btn" onclick="callClicks()">
								<?php 
								if (strpos($phone, '-') !== false) {
											echo $phone;
									   }else{
										   echo "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6); 
									   } ?>
                                                        </a>
						</span>	
						<?php
						if($adminId != 50){ ?>
							<a href="https://www.google.com/maps/dir/Current+Location/<?php echo $lat; ?>,<?php echo $lng; ?>" target="_blank" class="btn btn-primary btn-sm get-direction-btn" style="margin-left: 12px;" onclick="directionClicks()">Get Directions</a>
						<?php } ?>
					</div>
					</li>
				<!------------Business Hours Start------------------>
                <?php switch ($business_hours_select) { 
				case "Global Business Hours": ?>
					<li>
						<div class="icon"><i class="material-icons">schedule</i></div>
					<ul class="sp-sub-list">
						<?php if(!in_array("Sunday", $weekholidaysarray) && $sunos_1 =="open"){$metasun = "Su,";} if(!in_array("Monday", $weekholidaysarray) && $monos_1 =="open"){$metamon = "Mo,";} if(!in_array("Tuesday", $weekholidaysarray) && $tueos_1 =="open"){$metatus = "Tu,";} if(!in_array("Wednesday", $weekholidaysarray) && $wedos_1 =="open"){$metawed = "We,";} if(!in_array("Thursday", $weekholidaysarray) && $thuos_1 =="open"){$metathu = "Th,";} if(!in_array("Friday", $weekholidaysarray) && $frios_1 =="open"){$metafri = "Fr,";} if(!in_array("Saturday", $weekholidaysarray) && $satos_1 =="open"){$metasat = "Sa,";} 
						$metadays = rtrim($metasun.$metamon.$metatus.$metawed.$metathu.$metafri.$metasat, ",");
						?>
							<meta itemprop="openingHours"  style='display: none'  datetime="<?php echo $metadays; ?>" />
							<li class='<?php if($weekDays == 'Sunday') { echo $class; }  ?>'>
								<div class="day">Sunday</div>
								<div class="hours"><?php if(in_array("Sunday", $weekholidaysarray)) { echo "Closed"; } elseif($sunos_1 =="open"){echo $sunot_1, '-', $sunct_1;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Monday') { echo $class; } ?>'>
								<div class="day">Monday</div>
								<div class="hours"><?php if(in_array("Monday", $weekholidaysarray)) { echo "Closed"; } elseif($monos_1 =="open"){echo $monot_1, '-', $monct_1;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Tuesday') { echo $class; } ?>'>
								<div class="day">Tuesday</div>
								<div class="hours"><?php if(in_array("Tuesday", $weekholidaysarray)) { echo "Closed"; } elseif($tueos_1 =="open"){echo $tueot_1, '-', $tuect_1;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Wednesday') { echo $class; } ?>'>
								<div class="day">Wednesday</div>
								<div class="hours"><?php if(in_array("Wednesday", $weekholidaysarray)) { echo "Closed"; } elseif($wedos_1 =="open"){echo $wedot_1, '-', $wedct_1;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Thursday') { echo $class; } ?>'>
								<div class="day">Thursday</div>
								<div class="hours"><?php if(in_array("Thursday", $weekholidaysarray)) { echo "Closed"; } elseif($thuos_1 =="open"){echo $thuot_1, '-', $thuct_1;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Friday') { echo $class; } ?>'>
								<div class="day">Friday</div>
								<div class="hours"><?php if(in_array("Friday", $weekholidaysarray)) { echo "Closed"; } elseif($frios_1 =="open"){echo $friot_1, '-', $frict_1;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Saturday') { echo $class; } ?>'>
								<div class="day">Saturday</div>
								<div class="hours"><?php if(in_array("Saturday", $weekholidaysarray)) { echo "Closed"; } elseif($satos_1 =="open"){echo $satot_1, '-', $satct_1;} else { echo "Closed"; } ?></div>
							</li>
						</ul>
					</li>
				<?php break;
				case "Business Hours":  ?>
					<li>
						<div class="icon"><i class="material-icons">schedule</i></div>
				         	<ul class="sp-sub-list">
						<?php if(!in_array("Sunday", $weekholidaysarray) && $sunos =="open"){$metasun = "Su,";} if(!in_array("Monday", $weekholidaysarray) && $monos =="open"){$metamon = "Mo,";} if(!in_array("Tuesday", $weekholidaysarray) && $tueos =="open"){$metatus = "Tu,";} if(!in_array("Wednesday", $weekholidaysarray) && $wedos =="open"){$metawed = "We,";} if(!in_array("Thursday", $weekholidaysarray) && $thuos =="open"){$metathu = "Th,";} if(!in_array("Friday", $weekholidaysarray) && $frios =="open"){$metafri = "Fr,";} if(!in_array("Saturday", $weekholidaysarray) && $satos =="open"){$metasat = "Sa,";} 
						$metadays = rtrim($metasun.$metamon.$metatus.$metawed.$metathu.$metafri.$metasat, ",");
						?>
							<meta itemprop="openingHours"  style='display: none'  datetime="<?php echo $metadays; ?>" />
							<li class='<?php if($weekDays == 'Sunday') { echo $class; }  ?>'>
								<div class="day">Sunday</div>
								<div class="hours"><?php if(in_array("Sunday", $weekholidaysarray)) { echo "Closed"; } elseif($sunos=="open"){echo $sunot, '-', $sunct;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Monday') { echo $class; } ?>'>
								<div class="day">Monday</div>
								<div class="hours"><?php if(in_array("Monday", $weekholidaysarray)) { echo "Closed"; } elseif($monos=="open"){echo $monot, '-', $monct;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Tuesday') { echo $class; } ?>'>
								<div class="day">Tuesday</div>
								<div class="hours"><?php if(in_array("Tuesday", $weekholidaysarray)) { echo "Closed"; } elseif($tueos=="open"){echo $tueot, '-', $tuect;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Wednesday') { echo $class; } ?>'>
								<div class="day">Wednesday</div>
								<div class="hours"><?php if(in_array("Wednesday", $weekholidaysarray)) { echo "Closed"; } elseif($wedos=="open"){echo $wedot, '-', $wedct;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Thursday') { echo $class; } ?>'>
								<div class="day">Thursday</div>
								<div class="hours"><?php if(in_array("Thursday", $weekholidaysarray)) { echo "Closed"; } elseif($thuos=="open"){echo $thuot, '-', $thuct;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Friday') { echo $class; } ?>'>
								<div class="day">Friday</div>
								<div class="hours"><?php if(in_array("Friday", $weekholidaysarray)) { echo "Closed"; } elseif($frios=="open"){echo $friot, '-', $frict;} else { echo "Closed"; } ?></div>
							</li>
							<li class='<?php if($weekDays == 'Saturday') { echo $class; } ?>'>
								<div class="day">Saturday</div>
								<div class="hours"><?php if(in_array("Saturday", $weekholidaysarray)) { echo "Closed"; } elseif($satos=="open"){echo $satot, '-', $satct;} else { echo "Closed"; } ?></div>
							</li>
						</ul>
					</li>
				<?php break;
				default: ?>
				<?php }	?>
				<!------------Business Hours End------------------>
				</ul>
			 </div>
            
			 </div>
          </div><!-- /nested row -->
		
		<div class="sp-business-info">
			<!------------Page Title Start------------------>
			<?php switch($page_content_select) {
				case "Global Page Content": ?>
					<?php if($pagetitle_global != "") { ?>
					<h2><?php echo $pagetitle_global; ?></h2>
					<?php } else { ?>
					<div class="title_spacer"></div>
					<?php } ?>
				<?php break;
				case "Page Content": ?>
					<?php if($pagetitle != "") { ?>
					<h2><?php echo $pagetitle; ?></h2>
					<?php } else { ?>
					<div class="title_spacer"></div>
					<?php } ?>
				<?php break;
				default: ?>
			<?php } ?>
			<!------------Business Title End------------------>
			
			<!------------Profile Image Start------------------>
			<?php switch ($profile_image_select) { 
				case "Global Profile Image":
                  
                                    ?>
					<?php if($profileimage_global != "") { ?>
                                         <figure itemscope itemtype="https://schema.org/ImageObject" itemprop="image"> 
                                             <div class="pimage-holder image"><img src="<?php echo $adminurl; ?>/uploads/<?php echo $profileimage_global; ?>" class="sp-image" alt="<?php echo pathinfo($profileimage_global, PATHINFO_FILENAME); ?>"/></div>
                                             <meta itemprop="url" content="<?php echo $adminurl; ?>/uploads/<?php echo $profileimage_global; ?>">
                                         </figure>
					<?php } ?>
			<?php break;
                                case "Profile Image":
                    
                                    ?>
					<?php if($profileimage != "") { ?>
                                   <figure itemscope itemtype="https://schema.org/ImageObject"> 
					<div class="pimage-holder"><img src="<?php echo $adminurl; ?>/uploads/<?php echo $profileimage; ?>" class="sp-image" alt="<?php echo pathinfo($profileimage, PATHINFO_FILENAME); ?>"/></div>
                                        <meta itemprop="url" content="<?php echo $adminurl; ?>/uploads/<?php echo $profileimage; ?>">
                                   </figure>
					<?php } ?>
			<?php break;
				case "Street View": 
                                   
                                    ?>
                              					
                            <div class="col-sm-6 custom-pano">
                                <div id="pano">  
                                   <?php  if($profileimage=="" &&  $profileimage_global==""){ ?>
                                    <figure itemscope itemtype="https://schema.org/ImageObject" itemprop="image" style="display:none"> 
                                     
					<div class="pimage-holder"><img src="<?php echo $adminurl; ?>/uploads/no_image.jpeg" class="sp-image" alt="<?php echo $adminurl; ?>/uploads/no_image.jpeg"/></div>
                                        <meta itemprop="url" content="<?php echo $adminurl; ?>/uploads/no_image.jpeg">
                                   </figure>
                                   <?php } ?>
                                </div>
                            </div>
			<?php break;
				default: ?>
                                     <figure itemscope itemtype="https://schema.org/ImageObject" itemprop="image" style="display:none"> 
					    <div class="pimage-holder image"><img src="<?php echo $adminurl; ?>/uploads/no_image.jpeg" class="sp-image" alt="<?php echo pathinfo($profileimage_global, PATHINFO_FILENAME); ?>"/></div>
                                            <meta itemprop="url" content="<?php echo $adminurl; ?>/uploads/no_image.jpeg">
                                     </figure>
                                    
			<?php } ?>
			<!------------Profile Image End------------------>
			
			<!------------Page Content Start------------------>
			<?php switch($page_content_select) {
				case "Global Page Content": ?>
					<?php if($pagecontent_global != "") { ?>
					<?php echo $pagecontent_global; ?>
					<?php } ?>
				<?php break;
				case "Page Content": ?>
					<?php if($pagecontent != "") { ?>
					<?php 
					//echo str_replace(trim($parentname),' '.Ucfirst(strtolower($pageData['newcity'])),$pagecontent); 
					echo $pagecontent;
					?>
					<?php } ?>
				<?php break;
				default: ?>
			<?php } ?>
			<!------------Business Content End------------------>
			
		 </div><!-- /.sp-business-info -->
		 
		<div class="clearfix"></div>
			<!------------Trust Badges Start------------------>
			<?php switch($trust_badges_select) {
                          
				case "Global Trust Badges": 
                                
                                    ?>
					<div class="sp-trust">
					<?php for ($i = 0; $i < $uploadimage_globalcount; $i++) {
                                        
						$p = $i+1; ?>
                                                <a href="<?php if($trustwebsitelink_global[$i] !="") { echo $trustwebsitelink_global[$i]; } else { echo "javascript:void(0)"; } ?>" <?php  if($trustwebsitelink_global[$i] !=""){ ?> target="__blank" <?php } ?>><img src="<?php echo $adminurl; ?>/uploads/<?php echo $uploadimage_global[$i]; ?>" class="trust-logo" alt="<?php echo pathinfo($uploadimage_global[$i], PATHINFO_FILENAME); ?>"/></a>
					   <?php } ?>
					</div>
					<?php break;	
					case "Trust Badges": ?>
					<div class="sp-trust">
					<?php for ($i = 0; $i < $uploadimagecount; $i++) {
                                              
						$p = $i+1; ?>
						<a href="<?php if($trustwebsitelink[$i] !="") { echo $trustwebsitelink[$i]; } else { echo "javascript:void(0)"; } ?>" target="__blank"><img src="<?php echo $adminurl; ?>/uploads/<?php echo $uploadimage[$i]; ?>" class="trust-logo" alt="<?php echo pathinfo($uploadimage[$i], PATHINFO_FILENAME); ?>"/></a>
						<?php } ?>
					</div>
					
				<?php break;
					default: ?>
				<?php } ?>
				<!------------Trust Badges End------------------>			
				
				<!------------Trust Text Start------------------>
			<?php switch($trust_text_select) {
				case "Global Trust Text": ?>
					<?php if($trusttext_global != "") { ?>
						<div class="sp-trust">
						<div class="sp-trust-text">
						<p><?php echo $trusttext_global; ?></p>
						</div>
						</div>
					<?php } ?>
				<?php break;	
				case "Trust Text": ?>
					<?php if($trusttext != "") { ?>
						<div class="sp-trust">
						<div class="sp-trust-text">
							<p><?php echo $trusttext; ?></p>
						</div>	
						</div>	
					<?php } ?>
					
				<?php break;
					default: ?>
				<?php } ?>
				<!------------Trust Text End------------------>
				
				<!------------Custom Reviews Start------------------>
				<?php 
				if($dyanmicReviewscript != ''){
					echo '<div class="sp-reviews">';
					echo '<h2>Reviews</h2>';
					echo $dyanmicReviewscript;
					echo '</div>';
				}
			//	else if($custom_reviewscript!=''){ 
				/* dyanmicReviewscript present from markers */
				/*		echo '<div class="sp-reviews">';
						echo '<h2>Reviews</h2>';
						echo $custom_reviewscript;
						echo '</div>';
					}*/else{
						/* custom review present */
						switch($custom_reviews_status) {
						case "Global Custom Reviews" : ?>
						
						<?php 
						/* Global Custom Reviews present from globaloptions */
						if($rating_globalcount > 0) { ?>
						<div class="sp-reviews">
							<h2>Reviews</h2>
                                                <?php  //echo $rating_globalcount; ?>
						<?php for ($i = 0; $i < $rating_globalcount; $i++) {
                                               
							$p = $i+1;
							if($reviewsite_global[$i] == "Yelp") { $reviewsiteimage = "yelplogo.png"; }
							if($reviewsite_global[$i] == "Google") { $reviewsiteimage = "googlelogo.png"; }
							if($reviewsite_global[$i] == "Superpages") { $reviewsiteimage = "superpage.jpeg"; }
							if($reviewsite_global[$i] == "Foursquare") { $reviewsiteimage = "foursquare.png"; } ?>
								<div class="sp-review" itemscope itemtype="http://schema.org/Review">
									<div class="review-header">
                                                                   
                                                                          <meta itemprop="itemreviewed" content="<?php echo $name; ?>"/>
                                                                          <meta itemprop="author" content="<?php echo !empty($reviewername_global[$i]) ? $reviewername_global[$i] : "Anonymous"; ?>"/>
										<div class="reviewer-picture">
											<img src="<?php if($uploadprofileimage_global[$i] != "") { echo $adminurl."/uploads/".$uploadprofileimage_global[$i]; } else { echo $adminurl."/defaultimages/user-icon.jpg"; } ?>" alt="<?php if($uploadprofileimage_global[$i] != "") { echo pathinfo($uploadprofileimage_global[$i], PATHINFO_FILENAME); } else { echo "user-icon"; } ?>" />
										</div>
										<?php if($reviewername_global[$i] != "") { ?><div class="reviewer" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span itemprop="name"><?php echo !empty($reviewername_global[$i]) ? $reviewername_global[$i] : "Anonymous"; ?></span></div><?php } ?>
										<?php if($rating_global[$i] != "") { ?>
										<div class="review-rating">
											<div class="rating-score" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><span itemprop="ratingValue"><?php echo $rating_global[$i]; ?></span></div>
											<div class="ratings">	
												<div class="empty-stars"></div>
												<div class="full-stars" style="width:<?php echo $rating_global[$i]*20; ?>%"></div>
											</div>
										</div>
										<?php } ?>
										<?php if($reviewsiteimage != "") { ?>
										<div class="review-site"><a href="javascript:void(0)"><img src="<?php echo $adminurl; ?>/defaultimages/<?php echo $reviewsiteimage; ?>" alt="<?php echo pathinfo($reviewsiteimage, PATHINFO_FILENAME); ?>"></a></div>
										<?php } ?>
                                                                             
									</div>
									<?php if($review_global[$i] != "") { ?>
									<div class="review-text"><span itemprop="description"><?php echo $review_global[$i]; ?></span></div>
									<?php } ?>
								</div>
                                                     
							<?php } ?>
                                                        <?php  //echo $i; ?>
						</div>
						<?php } ?>
					<?php break;
					
						/* Custom Reviews present from markers */
						case "Custom Reviews": ?>
						<?php if($ratingcount > 0) { ?>
						<div class="sp-reviews">
							<h2>Reviews</h2>
                                                        <?php //echo $ratingcount; ?>
						<?php for ($i = 0; $i < $ratingcount; $i++) {
							 $p = $i+1;
							if($reviewsite[$i] == "Yelp") { $reviewsite_image = "yelplogo.png"; }
							if($reviewsite[$i] == "Google") { $reviewsite_image = "googlelogo.png"; }
							if($reviewsite[$i] == "Superpages") { $reviewsite_image = "superpage.jpeg"; }
							if($reviewsite[$i] == "Foursquare") { $reviewsite_image = "foursquare.png"; } ?>
								<div class="sp-review" itemscope itemtype="http://schema.org/Review">
									<div class="review-header">
                                                                          <meta itemprop="itemreviewed" content="<?php echo $name; ?>"/>
                                                                          <meta itemprop="author" content="<?php echo !empty($reviewername_global[$i]) ? $reviewername_global[$i] : "Anonymous"; ?>"/>
										<div class="reviewer-picture">
											<img src="<?php if($uploadprofileimage[$i] != "") { echo $adminurl."/uploads/".$uploadprofileimage[$i]; } else { echo $adminurl."/defaultimages/user-icon.jpg"; } ?>" alt="<?php if($uploadprofileimage[$i] != "") { echo pathinfo($uploadprofileimage[$i], PATHINFO_FILENAME); } else { echo "user-icon"; } ?>" />
										</div>
										<?php if($reviewername_review[$i] != "") { ?><div class="reviewer" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span itemprop="name"><?php echo $reviewername_review[$i]; ?></span></div><?php } ?>
										<?php if($rating[$i] != "") { ?>
										<div class="review-rating">
											<div class="rating-score" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><span itemprop="ratingValue"><?php echo $rating[$i]; ?></span></div>
											<div class="ratings">	
												<div class="empty-stars"></div>
												<div class="full-stars" style="width:<?php echo $rating[$i]*20; ?>%"></div>
											</div>
										</div>
										<?php } ?>
										<?php if($reviewsite_image != "") { ?>
										<div class="review-site"><a href="javascript:void(0)"><img src="<?php echo $adminurl; ?>/defaultimages/<?php echo $reviewsite_image; ?>" alt="<?php echo pathinfo($reviewsite_image, PATHINFO_FILENAME); ?>"></a></div>
										<?php } ?>
									</div>
									<?php if($review[$i] != "") { ?>
									<div class="review-text"><span itemprop="description"><?php echo $review[$i]; ?></span></div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
						<?php } ?>
					<?php break;	
					default: ?>	
				<?php } } ?>	
				<!------------Custom Reviews End------------------>
	    </div><!-- /.col-md-9 -->
	
        <div class="col-md-3">


		<!------------Free Consultation Box Start------------------>
		<!-- test box  -->
		<?php if($forminputcount > 0) { ?>
          <div class="sp-box sp-box-brand">

          	<?php /*  
			<iframe src="https://www.restoration1.com/order-service" width="100%" frameBorder="0" id="gformiframe" style="background: #e97d27;"></iframe>

            <script>
        	// This code auto adjusts the iframe size on load
        	
 			// Selecting the iframe element
			var iframe = document.getElementById("gformiframe");
				//console.log(iframe);
			// Adjusting the iframe height onload event
			iframe.onload = function(){
				iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
				//console.log("SIZE" + iframe.style.height);
			}
			</script>
 			*/  ?>

          	
            <div class="box-title"><?php if($formtitle != "") { echo $formtitle; } else { echo "Free Consultation"; } ?></div>
            <form id="consultation-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
				<input type="hidden" name="to" id="to" value='<?php echo $contactformemail; ?>'/>
                                 <!--<input type="hidden" name="to" id="to" value="keshav.bindra@kindlebit.com"/>-->
				
				 <?php for ($i = 0; $i < $forminputcount; $i++) {
					$p = $i+1; ?>
					<div class="form-group">
					<?php if($forminput[$i] == "textarea") { ?>
						
						<textarea class="form-control select_text" rows="6" placeholder="<?php echo $formplaceholder[$i] ?>" name="inputval[]"></textarea>
						<input type="hidden" name="labelname[]" value="<?php echo ucfirst($formplaceholder[$i]) ?>" />
					<?php } else if($forminput[$i] == "select") { ?>
						<select class="form-control" rows="6" name="inputval[]">
						<?php foreach(explode('/', $formplaceholder[$i]) as $value) {
							echo "<option>".$value."</option>";
						} ?>	
						</select>
                                                <?php $exp_option=explode("/",$formplaceholder[$i]);
                                                 $select_label=!empty($exp_option[0]) ? $exp_option[0] : "";
                                                ?>
						<input type="hidden" name="labelname[]" value="<?php echo $select_label ?>" />
					<?php } else { ?>
						<?php if($forminput[$i] == "checkbox" || $forminput[$i] == "radio" || $forminput[$i] == "file") { echo '<label>'.$formplaceholder[$i].'</label>'; } ?>
						
                         <?php $file_id=(strtolower($forminput[$i]) == "file") ? "file" : ""; ?>
						<input tabindex="<?php echo $i+1; ?>" type="<?php echo $forminput[$i] ?>" <?php if($forminput[$i] != "checkbox" && $forminput[$i] != "radio") { ?> class="form-control <?php echo (strtolower($forminput[$i])=='number') ? "number": ""; ?> <?php echo (strtolower($forminput[$i]) == "tel") ? "tel" : "";  ?> <?php echo (strtolower($forminput[$i]) == "date") ? "datepicker" : "";  ?>" style="padding:0px;" <?php } ?> id="<?php echo $file_id; ?>" name="inputval[]" <?php if($forminput[$i] != "checkbox" && $forminput[$i] != "radio" && $forminput[$i] != "file") { ?>placeholder="<?php echo ucfirst($formplaceholder[$i]); ?>"<?php } ?> autocomplete="off" <?php if(trim($formrequired[$i]) == trim("yes")) { echo "required"; } ?> aria-label="<?php echo ucfirst($formplaceholder[$i]); ?>"/>
						<input type="hidden" name="labelname[]" value="<?php echo ucfirst($formplaceholder[$i]) ?>" />
					<?php } ?>
					</div>
				<?php } ?>
				<div class="response-message">
				</div>
				<input type="submit" tabindex="5" class="btn btn-primary contact_submit" aria-label="<?php if($buttontext != "") { echo $buttontext; } else { echo "Submit"; } ?>" value="<?php if($buttontext != "") { echo $buttontext; } else { echo "Submit"; } ?>" />
			</form> 
			
          
         
          </div>

		  <?php } ?>
		  <!------------Free Consultation Box End------------------>
		  
		  <!------------Review Button Start---------------->
		  <?php switch($reviewbuttonselect) {
				case "Global Review Buttons" : ?>
					<?php if($buttontitleglobalcount > 0) { ?>
							<div class="btn-group-wrapper">
							<?php for ($i = 0; $i < $buttontitleglobalcount; $i++) {
								$p = $i+1; ?>
								<?php if($buttonlinkglobal[$i] != "") { ?><a href="<?php if($buttonlinkglobal[$i] != "") { echo $buttonlinkglobal[$i]; } else { echo "javascript:void(0)"; } ?>" target="__blank" class="btn btn-primary btn-block" aria-label="<?php echo $buttontitleglobal[$i]; ?>"><?php echo $buttontitleglobal[$i]; ?></a><?php } ?>
							<?php } ?>
							</div>
					<?php } ?>
					<?php break;
				          case "Review Buttons": ?>
					<?php if($buttontitlecount > 0) { ?>
							<div class="btn-group-wrapper">
							<?php for ($i = 0; $i < $buttontitlecount; $i++) {
								$p = $i+1; ?>
								<?php if($buttonlink[$i] != "") { ?><a href="<?php if($buttonlink[$i] != "") { echo $buttonlink[$i]; } else { echo "javascript:void(0)"; } ?>" target="__blank" class="btn btn-primary btn-block" aria-label="<?php echo $buttontitle[$i]; ?>"><?php echo $buttontitle[$i]; ?></a><?php } ?>
							<?php } ?>
							</div>
					         <?php } ?>
				<?php break; 
				default: ?>	
		  <?php } ?>
		  
		  <!------------Review Button End------------------>
		  
		  <!------------Featured Reviews Start------------------>
				<?php 
				
					if($custom_featurereview != '')
					{
                        ?>
								<div class="sp-review review-featured" itemscope itemtype="http://schema.org/Review">
								<div class="review-featured-title">Featured Review</div>
 			<?php
						echo $custom_featurereview; ?>
                        </div>
			<?php	}else{
							switch($custom_reviews_status) {
					case "Global Custom Reviews" : ?>

						<?php if($rating_globalcount > 0) { ?>
						<div class="sp-review review-featured" itemscope itemtype="http://schema.org/Review">
							<div class="review-featured-title" itemprop="itemReviewed">Featured Review</div>
						<?php for ($i = 0; $i < 1; $i++) {
							$p = $i+1;
							if($reviewsite_global[$i] == "Yelp") { $reviewsiteimage = "yelplogo.png"; $reviewsiteimagealt = "Yelp"; }
							if($reviewsite_global[$i] == "Google") { $reviewsiteimage = "googlelogo.png"; $reviewsiteimagealt = "Google"; }
							if($reviewsite_global[$i] == "Superpages") { $reviewsiteimage = "superpage.jpeg"; $reviewsiteimagealt = "Superpages"; }
							if($reviewsite_global[$i] == "Foursquare") { $reviewsiteimage = "foursquare.png"; $reviewsiteimagealt = "Foursquare"; } ?>
								<div class="review-header">
                                                                    <meta itemprop="itemreviewed" content="<?php echo $name; ?>"/>
                                                                          <meta itemprop="author" content="<?php echo !empty($reviewername_global[$i]) ? $reviewername_global[$i] : "Anonymous"; ?>"/>
									<div class="reviewer-picture">
										<img src="<?php if($uploadprofileimage_global[$i] != "") { echo $adminurl."/uploads/".$uploadprofileimage_global[$i]; } else { echo $adminurl."/defaultimages/user-icon.jpg"; } ?>" alt="<?php if($uploadprofileimage_global[$i] != "") { echo pathinfo($uploadprofileimage_global[$i], PATHINFO_FILENAME); } else { echo "user-icon"; } ?>" />
									</div>
									<?php if($reviewername_global[$i] != "") { ?><div class="reviewer" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span itemprop="name"><?php echo $reviewername_global[$i]; ?></span></div><?php } ?>
									<?php if($reviewsiteimage != "") { ?>
									<div class="review-site"><a href="javascript:void(0)"><img src="<?php echo $adminurl; ?>/defaultimages/<?php echo $reviewsiteimage; ?>" alt="<?php echo pathinfo($reviewsiteimage, PATHINFO_FILENAME); ?>"></a></div>
									<?php } ?>
								</div>
								<?php if($rating_global[$i] != "") { ?>
									<div class="review-rating">
										<div class="rating-score" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><span itemprop="ratingValue"><?php echo $rating_global[$i]; ?></span></div>
										<div class="ratings">	
											<div class="empty-stars"></div>
											<div class="full-stars" style="width:<?php echo $rating_global[$i]*20; ?>%"></div>
										</div>
									</div>
									<?php } ?>
								<?php if($review_global[$i] != "") { ?>
								<div class="review-text"><span itemprop="description"><?php echo $review_global[$i]; ?></span></div>
								<?php } ?>
							<?php } ?>
						</div>
						<?php } ?>
					<?php break; 
						case "Custom Reviews": ?>
						<?php if($ratingcount > 0) { ?>
						<div class="sp-review review-featured" itemscope itemtype="http://schema.org/Review">
							<div class="review-featured-title">Featured Review</div>
						
						<?php
					
						for ($i = 0; $i < 1; $i++) {
							  $p = $i+1;
							if($reviewsite[$i] == "Yelp") { $reviewsite_image = "yelplogo.png"; $reviewsite_imagealt = "Yelp"; }
							if($reviewsite[$i] == "Google") { $reviewsite_image = "googlelogo.png"; $reviewsite_imagealt = "Google"; }
							if($reviewsite[$i] == "Superpages") { $reviewsite_image = "superpage.jpeg"; $reviewsite_imagealt = "Superpages"; }
							if($reviewsite[$i] == "Foursquare") { $reviewsite_image = "foursquare.png"; $reviewsite_imagealt = "Foursquare"; } ?>
								<div class="review-header">
									<div class="reviewer-picture">
										<img src="<?php if($uploadprofileimage[$i] != "") { echo $adminurl."/uploads/".$uploadprofileimage[$i]; } else { echo $adminurl."/defaultimages/user-icon.jpg"; } ?>" alt="<?php if($uploadprofileimage[$i] != "") { echo pathinfo($uploadprofileimage[$i], PATHINFO_FILENAME); } else { echo "user-icon"; } ?>" />
									</div>
									<?php if($reviewername_review[$i] != "") { ?><div class="reviewer" itemprop="author" itemscope="" itemtype="http://schema.org/Person"><span itemprop="name"><?php echo $reviewername_review[$i]; ?></span></div><?php } ?>
									<?php if($reviewsite_image != "") { ?>
									<div class="review-site"><a href="javascript:void(0)"><img src="<?php echo $adminurl; ?>/defaultimages/<?php echo $reviewsite_image; ?>" alt="<?php echo pathinfo($reviewsite_image, PATHINFO_FILENAME); ?>"></a></div>
									<?php } ?>
								</div>
								<?php if($rating[$i] != "") { ?>
									<div class="review-rating">
										<div class="rating-score" itemprop="reviewRating" itemscope="" itemtype="http://schema.org/Rating"><span itemprop="ratingValue"><?php echo $rating[$i]; ?></span></div>
										<div class="ratings">
											<div class="empty-stars"></div>
											<div class="full-stars" style="width:<?php echo $rating[$i]*20; ?>%"></div>
										</div>
									</div>
								<?php } ?>
								<?php if($review[$i] != "") { ?>
								<div class="review-text"><span itemprop="description"><?php echo $review[$i]; ?></span></div>
								<?php } ?>
							<?php }
							?>
						</div>
						<?php } ?>
					<?php break;	
					default: ?>	
					   <?php } 
					}
				 ?>	
				<!------------Featured Reviews End------------------>
				
				<!------------Coupons Start------------------>
				<?php switch($couponselect) {
					case "Global Coupons": ?>
						<?php if($coupantitle_globalcount > 0) { ?>
					<div class="sp-box" itemscope itemtype="http://schema.org/Offer">
						<div class="box-title" itemprop="name">Coupon</div>
						<?php for ($i = 0; $i < $coupantitle_globalcount; $i++) {
									$p = $i+1; ?>
							<?php if($coupanlink_global[$i] != "") { ?><a href="<?php echo $coupanlink_global[$i]; ?>"><?php } ?>
							<?php if($coupantitle_global[$i] != "") { ?><h2><span itemprop="name"><?php echo $coupantitle_global[$i]; ?></span></h2><?php } ?>
							<?php if($uploadcoupanimage_global[$i] != "") { ?><img src="<?php echo $adminurl."/uploads/".$uploadcoupanimage_global[$i]; ?>" itemprop="image" alt="<?php echo pathinfo($uploadcoupanimage_global[$i], PATHINFO_FILENAME); ?>" itemprop="image" /><?php } ?>	
							<?php if($coupantext_global[$i] != "") { ?><p itemprop="description"><?php echo $coupantext_global[$i]; ?></p><?php } ?>
							<?php if($coupanlink_global[$i] != "") { ?></a><?php } ?>
                                                            
						
						<?php } ?>
                                       </div>
                                                
                                          <?php } ?>
                              
					<?php break; ?>
                                          
					<?php case "Coupons": ?>
						<?php if($coupantitlecount > 0) { ?>
					<div class="sp-box" itemscope itemtype="http://schema.org/Offer">
						<div class="box-title" itemprop="name">Coupon</div>
						<?php for ($i = 0; $i < $coupantitlecount; $i++) {
									$p = $i+1; ?>
							
							<?php if($coupanlink[$i] != "") { ?><a href="<?php echo $coupanlink[$i]; ?>"><?php } ?>
							<?php if($coupantitle[$i] != "") { ?><h2><span itemprop="name"><?php echo $coupantitle[$i]; ?></span></h2><?php } ?>
							<?php if($uploadcoupanimage[$i] != "") { ?><img src="<?php echo $adminurl."/uploads/".$uploadcoupanimage[$i]; ?>" itemprop="image" alt="<?php echo pathinfo($uploadcoupanimage[$i], PATHINFO_FILENAME); ?>" itemprop="image" /><?php } ?>	
							<?php if($coupantext[$i] != "") { ?><p itemprop="description"><?php echo $coupantext[$i]; ?></p><?php } ?>
							<?php if($coupanlink[$i] != "") { ?></a><?php } ?>
							
						<?php } ?>
				        </div>
						<?php } ?>
					<?php break;
					default: ?>
				<?php } ?>	
				<!------------Coupons End------------------>
				<span itemprop="priceRange" content="USD" style="display:none;">USD</span>
			<!------------Payments Accepted Start------------------>
			<?php switch($paymentselect) {
			case "Global Payments": ?>
			<?php if($americanexpress_global || $discover_global || $applepay_global || $paypal_global || $creditcard_global || $google_global || $mastercard_global || $cash_global || $visa_global != "") { ?>
			<div class="sp-box">
            <div class="box-title">Payments Accepted</div>
            <div class="cc-wrapper">
			<?php 
			if($americanexpress_global == 'on'){ $americanexpressmeta ="americanexpress,"; }
			if($creditcard_global == 'on'){ $creditcardmeta ="creditcard,"; }
			if($applepay_global == 'on'){ $applepaymeta ="applepay,"; }
			if($discover_global == 'on'){ $discovermeta ="discover,"; }
			if($google_global == 'on'){ $googlemeta ="google,"; }
			if($mastercard_global == 'on'){ $mastercardmeta ="mastercard,"; }
			if($cash_global == 'on'){ $cashmeta ="cash,"; }
			if($paypal_global == 'on'){ $paypalmeta ="paypal,"; }
			if($visa_global == 'on'){ $visameta ="visa,"; }
			$metapayments = rtrim($americanexpressmeta.$creditcardmeta.$applepaymeta.$discovermeta.$googlemeta.$mastercardmeta.$cashmeta.$paypalmeta.$visameta,',');
			?>
			<div itemprop="paymentAccepted"  style='display: none' ><?php echo $metapayments; ?></div>
			<?php 
			if($americanexpress_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/amex.png" class="cc" alt="americanexpress"/>'; }
			if($creditcard_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/credit.png" class="cc" alt="creditcard"/>'; }
			if($applepay_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/applepay.png" class="cc" alt="applepay"/>'; }
			if($discover_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/discover.png" class="cc" alt="discover"/>'; }
			if($google_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/google.png" class="cc" alt="google"/>'; }
			if($mastercard_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/mastercard.png" class="cc" alt="mastercard"/>'; }
			if($cash_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/money.png" class="cc" alt="cash"/>'; }
			if($paypal_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/paypal.png" class="cc" alt="paypal"/>'; }
			if($visa_global == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/visa.png" class="cc" alt="visa"/>'; }
			?>
	        </div>
			</div>
			<?php } ?>
			<?php break;
			case "Payments": ?>
			<?php if($americanexpress || $discover || $applepay || $paypal || $creditcard || $google || $mastercard || $cash || $visa != ""){ ?>
			<div class="sp-box">
                          <div class="box-title">Payments Accepted</div>
                            <div class="cc-wrapper">
			<?php 
			if($americanexpress == 'on'){ $americanexpressmeta ="americanexpress,"; }
			if($creditcard == 'on'){ $creditcardmeta ="creditcard,"; }
			if($applepay == 'on'){ $applepaymeta ="applepay,"; }
			if($discover == 'on'){ $discovermeta ="discover,"; }
			if($google == 'on'){ $googlemeta ="google,"; }
			if($mastercard == 'on'){ $mastercardmeta ="mastercard,"; }
			if($cash == 'on'){ $cashmeta ="cash,"; }
			if($paypal == 'on'){ $paypalmeta ="paypal,"; }
			if($visa == 'on'){ $visameta ="visa,"; }
			$metapayments = rtrim($americanexpressmeta.$creditcardmeta.$applepaymeta.$discovermeta.$googlemeta.$mastercardmeta.$cashmeta.$paypalmeta.$visameta,',');
			?>
	                <div itemprop="paymentAccepted"  style='display: none' ><?php echo $metapayments; ?></div>
			<?php 
				if($americanexpress == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/amex.png" class="cc" alt="americanexpress"/>'; }
				if($creditcard == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/credit.png" class="cc" alt="creditcard"/>'; }
				if($applepay == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/applepay.png" class="cc" alt="applepay"/>'; }
				if($discover == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/discover.png" class="cc" alt="discover"/>'; }
				if($google == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/google.png" class="cc" alt="google"/>'; }
				if($mastercard == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/mastercard.png" class="cc" alt="mastercard"/>'; }
				if($cash == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/money.png" class="cc" alt="cash"/>'; }
				if($paypal == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/paypal.png" class="cc" alt="paypal"/>'; }
				if($visa == 'on'){ echo '<img src="'.$adminurl.'/defaultimages/visa.png" class="cc" alt="visa"/>'; }
			?>
	        </div>
			</div>
			<?php } ?>
			<?php break;
			default: ?>
			<?php } ?>
			<!------------Payments Accepted End------------------>
			<!-------------------Services Start------------------>
			<?php switch($serviceselect) {
			case "Global Services": ?>
				<?php if($addservicescountglobal > 0) { 
                                        $ser='';
                                    ?>
                          
				<div class="sp-box"  itemscope itemtype="http://schema.org/Services">
				<h2 class="box-title">Our Services</h2>
					<?php
						foreach($addservicesglobal as $value){
                                                    $ser.=$value." ";
                                                    ?>
							<?php if($value != "") { ?>
                    
							<div class="sp-custom-list-item" itemprop="service">
                                                           
								<h2><?php echo $value; ?></h2>
							</div>
							<?php } ?>
					<?php } ?>
               
				</div>
				<?php } ?>
                     
			<?php break;
			case "Services": 
                             $ser='';
                            ?>
                   
                 	<?php if($addservicescount > 0) {
							
						 ?>
				<div class="sp-box"  itemscope itemtype="http://schema.org/Services">
                                        
				<div class="box-title">Our Services</div>
					<?php
						for($i=0;$i < $addservicescount;$i++){ ?>
						           
							<div class="sp-custom-list-item" itemprop="service">
								<a href="<?= ($addservicesarraylink[$i]!='') ? $addservicesarraylink[$i] : '' ?>" title="<?= ($addservices[$i]!='') ? $addservices[$i] : '' ?>"><?= ($addservices[$i]!='') ? $addservices[$i] : '' ?></a>
							</div>
					<?php } ?>
				</div>
                        
				<?php } ?>
			<?php break; 
			default: ?>
			<?php } ?>
			<!-------------------Services End------------------>
			<?php if(isset($pageData['newzip']) && strlen($pageData['newzip']) >5) { 
                                        $ser='';
                                    ?>
                          
				<div class="sp-box"  itemscope itemtype="http://schema.org/Services">
                                       
				<div class="box-title">Zip codes Served</div>
					<?php
					
						if(strlen($pageData['newzip']) >5){
							$allzips = explode(',',$pageData['newzip']);						
						}else{
							$allzips = $pageData['newzip'];
						}
						for($i=0;$i < count($allzips);$i++){ 
							 if (substr($allzips[$i], 0, 1) != '0' && strlen($allzips[$i])==4) {	
								$newZIP = '0'.$allzips[$i];
							}else{
								$newZIP = $allzips[$i];
								}
							$zipurl = 'https://www.restoration1.com/find-my-location/'.str_replace(' ','_',$pageData['newcity']).'/'.$allzips[$i];
							?>
						           
							<div class="sp-custom-list-item" itemprop="service">
								<a href="<?= ($allzips[$i]!='') ? $zipurl : '' ?>" title="<?= ($allzips[$i]!='') ? $newZIP : '' ?>"><?= ($allzips[$i]!='') ? $newZIP : '' ?></a>
							</div>
					<?php }	 ?>
				</div>
				<?php }  ?>
		
                </div>
             </div>
          </div>
      </div>
</div>
<script>
	 var myCenter = new google.maps.LatLng(latitude,longitude);
	 function initialize() {
	  var mapProp = {
		  center:myCenter,
		  zoom:15,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  var map = new google.maps.Map(document.getElementById("landingmap"), mapProp);
	  var marker = new google.maps.Marker({
		position:myCenter,
	  });
	  $("#landingmap").append('<div class="save-widget">' + locationname + '</div>');
	  marker.setMap(map);
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	locationPhone = '<?php echo "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6) ?>';
	localStorage.setItem('r1-location-phone', locationPhone);
</script>
<!----------------------------------------------Page Location Details End-------------------------------------->
	<?php break;
	case "servicelocations":
            ?>

<div class='store-page'>
	<div class='container-fluid'>	    
		<div class='store-locator_locations'>
			<h3>SERVICE LOCATIONS</h3>
			<hr class="service_divider">
		<div class="service_final_list">        
			<ul >
			<?php foreach($servicelocations_array as $location_slug){

			$url="".$location_slug."/detail"; 
			?>

			<li><a href="<?php echo $url ?>" target='_blank' title="<?php  echo ucfirst($location_slug); ?>"><?php  echo ucfirst($location_slug); ?></a></li>


			<?php } ?>
			</ul>
		</div>


		</div>
	</div>
</div>
<style>
.store-page .store-locator_locations .service_final_list ul {
  float: left;
  width: 100%;
}

.store-page .store-locator_locations .service_final_list ul li {
  float: left;
  list-style: outside none none;
  margin: 0;
  padding: 0;
  width: 25%;
}

.store-page .store-locator_locations .service_final_list ul li a {
  color: black;
}
 .store-locator_locations h3 {
  font-size: 30px;
  margin-bottom: 0;
  padding: 30px 0 0;
  text-align: center;
}
.service_divider {
  background-color: #000 !important;
  border-bottom: 1px solid #bbbb;
  color: #000 !important;
  margin: 11px auto;
  max-width: 256px;
  padding: 0;
}
.service_final_list {
    float: left;
    width: 100%;
    margin: 2% 0%;
}


    
</style>
	<?php break;
           case "notfound": ?>
<!----------------------------------------------Page Not Found Start------------------------------------>
<div class="container-fluid">
	<div class="not-found">
		<h1>404: Not Found</h1>
		<h2>The Requested Page Was Not Found</h2>
		<h3>Please <a href="#" class="back" onclick="goBack()">Go Back</a> or GO to Our <a href="/locations" class="admin-go">Locations Page</a></h3> 
	</div>
</div>
<!----------------------------------------------Page Not Found End-------------------------------------->
	<?php break;
	default: ?>
<?php } ?>

<link href="<?php echo $adminurl; ?>/css/datepicker.css" rel="stylesheet" />
<script src="<?php echo $adminurl; ?>/js/bootstrap-datepicker.js"></script>
<script>
    $(document).on('keypress', '.number', function (event) {
        //alert(event.which);
        return (((event.which > 47) && (event.which < 58)) || (event.which == 13) || (event.which == 8) || (event.which == 43));
    });
    $(document).on('keypress', '.tel', function (event) {
        //alert(event.which);
        return (((event.which > 47) && (event.which < 58)) || (event.which == 13) || (event.which == 8) || (event.which == 43));
    });
    jQuery(".datepicker").datepicker({ dateFormat: 'dd-mm-yy' });

    </script>
<?php include "footer.php"; ?>
<!------------------------------------Store Locator Script Body Part End----------------------------------->
