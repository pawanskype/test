<style>
.dropdown-btn, .sidenav a
{
	padding: 0 0 6px 29px !important;
}
</style>

<div class="col-md-2">
	<div class="admin-menu-wrapper">
		<div class="admin-brand-title">
			<a href="<?php echo $adminhome; ?>"><img src="<?php echo $adminurl; ?>/defaultimages/logo-restoration.png" alt="Store Locator" /></a>
		</div>
		<ul class="admin-menu" data-spy="affix" data-offset-top="78">
		
			
			
			
			
                       
                        
			<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $locations == "on")) { ?>
			<li <?php if($currentPage=="locations.php" || $currentPage=="locationsedit.php"){echo 'class="active"';} ?>><a href="locations.php?adminid=50"><i class="material-icons admin-icon">location_city</i>Locations</a>
			</li>
			
			<?php  } ?>			
			
			
			<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $addlocations == "on")) { ?>
			<li <?php if($currentPage=="addlocations.php" || $currentPage=="addlocationcustom.php"){echo 'class="active"';} ?>><a href="addlocationcustom.php?adminid=50"><i class="material-icons admin-icon">add_box</i>Add Locations</a></li>
			<?php } ?>
			
			<?php 
			/* if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $locations == "on")) { ?>
			<li <?php if($currentPage=="zipcodes.php" || $currentPage=="zipcodes.php"){echo 'class="active"';} ?>><a href="zipcodes.php?adminid=50"><i class="material-icons admin-icon">location_city</i>Child Zipcodes</a>
			</li>
			<?php } ?>
			
			<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $addlocations == "on")) { ?>
			<li <?php if($currentPage=="addzipcodes.php" || $currentPage=="addlocationcustom.php"){echo 'class="active"';} ?>><a href="addcustomezipcode.php?adminid=50"><i class="material-icons admin-icon">add_box</i>Add Child Zipcodes</a></li>
			<?php } */ ?>
			
			 <?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $defaultglobaloptions == "on")) { ?>
			<li <?php if($currentPage=="defaultglobaloptions.php"){echo 'class="active"';} ?>><a href="defaultglobaloptions.php?adminid=50"><i class="material-icons admin-icon">settings</i>Default Global Options</a></li>
			<?php } ?>

			<?php if($role == "admin" || $role == "superadmin" ) { ?>
			<li class="submenu <?php if($currentPage=="estimates.php"){echo 'active';} ?>">
				<i class="material-icons admin-icon">Rollups</i>
				<div class="sidenav">
				  <button class="dropdown-btn">Rollups
					<i class="fa fa-caret-down"></i>
				  </button>
				  <div class="dropdown-container">
				 	<a href="estimates.php?adminid=50"><i class="fa fa-caret-right"></i> Report</a>
						<a href="rollupsummary.php?adminid=50"><i class="fa fa-caret-right"></i> Summary</a>
				  	
				  </div>
				</div>
			</li> 
			<?php } ?>
			
			
			<?php if($role == "superadmin") { ?>
			<li class="submenu <?php if($currentPage=="restoration1Upload.php" || $currentPage=="r1failure.php" || $currentPage=="r1logs.php" || $currentPage=="restorebackup.php"){echo 'active';} ?>">
				<i class="material-icons admin-icon">settings</i>
				<div class="sidenav">
				  <button class="dropdown-btn">Maintenance
					<i class="fa fa-caret-down"></i>
				  </button>
				  <div class="dropdown-container">
				  	
			    <!--	<a href="r1failure?adminid=50"><i class="fa fa-caret-right"></i> Processing Failures</a> -->
						
						
						<a href="gbbis_stats.php"><i class="fa fa-caret-right"></i> GbBIS Statistics</a>
						<a href="gbbisjsondump.php"><i class="fa fa-caret-right"></i>Restoration GbBIS Json Dump</a>
						<a href="gbbisjsondump-bf.php"><i class="fa fa-caret-right"></i>Bluefrog GbBIS Json Dump</a>
				  		
						<a href="gbbisjsondump-tdc.php"><i class="fa fa-caret-right"></i>TDC GbBIS Json Dump</a>
				  	
					
					
					
				  </div>
				</div>
			</li> 
			<?php } ?>
			
			
			
			
			
				
			
			
			
			
			
                        	
			
			
			
			
			
			

		

			
			
			<!--li class="log-section">
                         <!--span>    
                        <?php  /*if(isset($_SESSION['data']['clientname'])) { echo "<span class='log'>Hi&nbsp;".$_SESSION['data']['clientname']."</span>";  } */  ?>
                            <a href="logout.php" class="logout">Logout</a>
                       </span-->
                             <!--select id="soflow" class="log-section-changes">
                                    <!-- This method is nice because it doesn't require extra div tags, but it also doesn't retain the style across all browsers. -->
                                    <!--option><?php if(isset($_SESSION['data']['clientname'])) { echo "<span class='log'>Hi&nbsp;".$_SESSION['data']['clientname']."</span>";  }  ?></option>
                                    <option><a href="logout.php" class="logout">Logout</a></option>
                              </select>

                        </li-->
                                    <li class="log-section">
                         <!--span>    
                                                    <a href="logout.php" class="logout">Logout</a>
                       </span-->
                             
 <button type="button" class="btn btn-info collapsed" data-toggle="collapse" data-target="#demo" aria-expanded="false"><?php if(isset($_SESSION['data']['clientname'])) { echo "Hi&nbsp;".$_SESSION['data']['clientname'];  }  ?> <span class="fa fa-chevron-down"></span></button>
  <div id="demo" class="collapse" aria-expanded="false" style="height: 0px;">
     <ul class="" style="padding: 0px;">
    <a href="logout.php"><li>Logout</li></a>    
    </ul>
</div>

                        </li>
        
                </ul>
                     

	</div>
</div><!-- /.col -->
