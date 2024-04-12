<?php //

include "header.php";
$dataquery ='';
$franchise_id ='';
$name= '';
?>
<style>
	.custom-location_auto {
		position: relative;
		display: inline-block;
	}
	.custom-location_auto-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
	}
	.custom-location_auto-input {
		margin: 0;
		padding: 5px 10px;
	}
	.messagedetail{
		display:none !important;
	}
	</style>
<body class="admin-panel">
    <div class="container admin-body">
<?php
$admin_val = $_GET['adminid'];
//find record in last seven days
$orderby=" order by CAST(mail_date As DATE) desc";
$day_count='';
$form_selcted='';$loc_seletced='';
$sql_where='WHERE 1=1 ';
if(isset($_POST['sort_day']) && ($_POST['sort_day'] != '')){
	$day_count=	$_POST['sort_day'];
	$sql_where .=" && ( mail_date <= curdate() and mail_date >= DATE_SUB(curdate(),INTERVAL ".$day_count." day) )";

}elseif((isset($_POST['startdate']) && isset($_POST['enddate'])) && (!empty($_POST['startdate']) && !(empty($_POST['startdate'])))){
	$sql_where.="&& (date(mail_date) <= '".$_POST['enddate']."' and date(mail_date) >= '".$_POST['startdate']."')";

}
if((isset($_POST['location_auto'])) && ($_POST['location_auto'] !='')){
	$loc_seletced=$_POST['location_auto'];
	$sql_loc="SELECT * FROM `r1_parent_license_lookUp` WHERE Parent_Licence=$loc_seletced";
	$data_locquery = mysqli_query($con,$sql_loc);
	if(count($data_locquery) > 0){
		$franchise_id=$loc_seletced;
		while($locid_result = mysqli_fetch_assoc($data_locquery)){
			$franchise_id.=",".$locid_result['Child_License'];
		}
		 $sql_where.="&& ( franchise_id in(".$franchise_id."))";
	}
}
if(isset($_POST['formid'])  && ($_POST['formid'] != '')){
	 $form_selcted=$_POST['formid'];
	 $sql_where.="&& ( form_id=".$_POST['formid'].")";

}
$form_ddl='';
$formArray=array();
if($admin_val == '52'){
       /**************************For TDC Location****************************/
    if(isset($_POST['startdate'])){
		$tdc_rollup_url="https://thedrivewaycompany.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted;
	}else{
		$tdc_rollup_url="https://thedrivewaycompany.com/api/rollupdata.php";
	}
	$output = file_get_contents($tdc_rollup_url);
    $response = json_decode($output);
	
    if($response->status == "success"){
        $rollup_result =$response->result;
        $forms_data =$response->forms_data;
		foreach($forms_data as $val){
			$formid =  $val->id;
			$form_name =  $val->f_name;
			$formArray[$formid]=$form_name;
			 if($form_selcted == $formid)
				$form_ddl.="<option selected value='$formid'>$form_name</option>";
			else
				$form_ddl.="<option value='$formid'>$form_name</option>";
		}
    }
	$roll_updetail_page = "tdc_report_detail.php";
}else if($admin_val == '51'){
   /**************************For BF Location****************************/
  
   
	if(isset($_POST['startdate'])){
		$bf_rollup_url="https://bluefrogplumbing.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted;
	}else{
		$bf_rollup_url="https://bluefrogplumbing.com/api/rollupdata.php";
	}
    
    $output = file_get_contents($bf_rollup_url);
    $response = json_decode($output);
    if($response->status == "success"){
        $rollup_result =$response->result;
        $forms_data =$response->forms_data;
      	foreach($forms_data as $val){
			$formid =  $val->id;
			$form_name =  $val->f_name;
			$formArray[$formid]=$form_name;
			 if($form_selcted == $formid)
				$form_ddl.="<option selected value='$formid'>$form_name</option>";
			else
				$form_ddl.="<option value='$formid'>$form_name</option>";
		}
    }
	$roll_updetail_page = "bf_report_detail.php";
}else if($admin_val == '53'){
   /**************************For BF Location****************************/
   if (isset($_POST['startdate'])) {
    $softroc_rollup_url="https://softroc.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted;
   }else{
       $softroc_rollup_url="https://softroc.com/api/rollupdata.php";
   }
    $output = file_get_contents($softroc_rollup_url);
    $response = json_decode($output);
    if($response->status == "success"){
        $rollup_result =$response->result;
        $forms_data =$response->forms_data;
      	foreach($forms_data as $val){
			$formid =  $val->id;
			$form_name =  $val->f_name;
			$formArray[$formid]=$form_name;
			 if($form_selcted == $formid)
				$form_ddl.="<option selected value='$formid'>$form_name</option>";
			else
				$form_ddl.="<option value='$formid'>$form_name</option>";
		}
    }
	$roll_updetail_page = "sr_report_detail.php";
}else{
   
        /**************************For Restoration Location****************************/
    $sql="SELECT * FROM form_rollups ".$sql_where.$orderby." limit 200";
	$dataquery = mysqli_query($con,$sql);

	$form_sql="SELECT form_id FROM `form_rollups` group by form_id ";
	$form_data = mysqli_query($con,$form_sql);
		//For getting all forms value and name to show in table below
	while($form_result=mysqli_fetch_assoc($form_data)){
		$formid=$form_result['form_id'];
		$formdbsql="select title from wp_w7smtofx3h_gf_form where id=".$formid;
		$form_namedata = mysqli_query($con,$formdbsql);
		if($form_namedata){
		$form_name=mysqli_fetch_row($form_namedata);
		$formArray[$formid]=$form_name[0];
			if($formid == 154){
				$form_name="Contact Us";
			}else
				$form_name=$form_name[0];

			if($form_selcted == $formid)
				$form_ddl.="<option selected value='$formid'>$form_name</option>";
			else
				$form_ddl.="<option value='$formid'>$form_name</option>";
		}
	}

}
//Fetch Location name from markers table
	$loc_sql="SELECT suite,name FROM `markers` where adminid= $admin_val order by name asc";
	$loc_data = mysqli_query($con,$loc_sql);
	$loc_ddl='';
	while($loc_result=mysqli_fetch_assoc($loc_data)){
		$loc_nm= trim($loc_result['name']);
		$loc=str_replace("Restoration 1 of ","",$loc_nm);
		$loc_id= $loc_result['suite'];
		if($loc_seletced == $loc_id)
			$loc_ddl.="<option selected value='$loc_id'>$loc</option>";
		else
				$loc_ddl.="<option value='$loc_id'>$loc</option>";
		}

	if($role == "admin" || $role == "superadmin") { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
        <div class="col-md-10">
          <div class="content-wrapper">
           <div class="col-sm-12"> <div class="col-sm-9"><h1 class="page-title">Rollups</h1></div>
			<div class="col-sm-3"><input style="width: 100%;" class="btn btn-primary" type="button" name="exportData" id="exportData" value="Export">
				</div></div>
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
	<section id="filter_section">
    <div class="col-sm-12" style="margin:15px 0px;">
           <div class="form-group">
						<label for="name">Select Business<span class="required-star">*</span></label>
				    <select style=" width: 179px;" class="form-control" id="select_loc_business" name="select_location_type">
                     <option <?php echo ($admin_val == 50) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/estimates.php?adminid=50">Restoration</option>
				        <option <?php echo ($admin_val == 51) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/estimates.php?adminid=51">BLueFrog</option>
				        <option <?php echo ($admin_val == 52) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/estimates.php?adminid=52">TDC</option>
				        <option <?php echo ($admin_val == 53) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/estimates.php?adminid=53">Softroc</option>
				    </select>
					</div>
          </div>
		<div class="col-sm-12" style="margin:15px 0px;">
			<div class="col-sm-6">
		 <form method="post">
				<input type="text" id="min_date" name="startdate" data-date-format='dd-mm-yy' class="datepicker" value="<?php if(isset($_POST['startdate'])) echo $_POST['startdate'];?>" placeholder="Start Date" />
					<input type_POST="text" id="max_date" name="enddate" data-date-format='dd-mm-yy' class="datepicker" value="<?php if(isset($_POST['enddate'])) echo $_POST['enddate'];?>"placeholder="End Date">
			</div>
			<div class="col-sm-3">
				<select class="form-control" name='formid'><option value=''>Select Form</option>
						<?php echo $form_ddl; ?>
				</select>
			</div>
			<div class="col-sm-3">

						<select class="form-control" name='sort_day'>
						<option value=''>Select Days Range</option>
						<option <?php if($day_count == 7) echo "selected";?> value='7'>Last 7 Days</option>
						<option <?php if($day_count == 15) echo "selected";?> value='15'>Last 15 Days</option>
						<option <?php if($day_count == 30) echo "selected";?> value='30'>Last 30 Days</option>
						</select>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="col-sm-6">
				<strong>Select Location</strong>
				<select class="form-control" name="location_auto" id="location_auto">
				<option value=''>select location</option>
				<?php echo $loc_ddl; ?>
			</select>

			</div>

			<div class="col-sm-3">
			<input style="width: 100%;" class="btn btn-primary" type="submit" name="ShowData" id="ShowData" value="Search" />

			</div>

		</form>

			<div class="col-sm-3">
				<a style="float: right;width:100%;" class="btn btn-primary" href="<?php echo $adminurl; ?>/estimates.php?adminid=<?php echo $admin_val ; ?>">Clear Filters</a>
			</div>
		</div>

	</section>
            <section class="content-section map-content-section">
			   <div id="location-list">
				<form action="inc/submit.php" method="POST" id="add-new-user">
				<?php if($role == 'superadmin') { ?>
					<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
				<?php } ?>
					<div class="col-sm-12 tablescroll table-responsive">
						<table id="locationestimate-table" class="table table-striped table-bordered table-responsive admin-location-table" width="100%" cellspacing="0">

							<thead>
								<tr><th>View</th>
									<th class="sort-icons">Location Name
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Form
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Loc. Zip
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Loc. ID
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>

									<th class="sort-icons">Date Delievered
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>

									<th class="sort-icons">Date Opened
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">To Email
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">From Email
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Subject
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
										<th class="sort-icons">Emergency
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Name
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Address
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

									<th class="sort-icons">Zipcode
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>

									<th class="sort-icons">Service Needed
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>

									<th class="sort-icons">Email Routing
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>

									<th class="sort-icons">Page Url
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th  class="messagedetail">Message</th>
									<th class="sort-icons">Message
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
								</tr>
							</thead>
							<tbody class="list">
                    <?php
                    if(isset($rollup_result) && !empty($rollup_result)){
                            foreach($rollup_result as $res){
                                $r_id = $res->id;
                                $entry_id=$res->gf_entry_id;
                                $franchise_id=$res->franchise_id;
                                $page_url=$res->page_url;
                                $form_id=$res->form_id;
                                $formName=isset($formArray[$form_id] ) ? $formArray[$form_id] : '';
                                $loc_title_l=$res->loc_title;
                                $loc_title=str_replace("Restoration 1 of ","",$loc_title_l);
                                $loc_postal_code=$res->loc_postal_code;
                                $deliveredDate=$res->mail_date;
                                $openedDate=$res->mail_opened_date;
                                $subject=$res->mail_subject;
                                $to_email=$res->to_email;
                                $from_email=$res->from_email;
                                $mail_status=$res->mail_status;
                                $opens_count=$res->opens_count;
                                $clicks_count=$res->clicks_count;
                                $form_data_json=$res->form_data;
                                $form_data=json_decode($form_data_json);
                                foreach($form_data as $data){
                                if(($data->label == "Name") || ($data->label == "First Name*"))
                                    $name=$data->value;
                                elseif(($data->label == "Last Name") || ($data->label == "Last Name*"))

                                    $name.=" ".$data->value;
                                elseif(($data->label == "Email") || ($data->label == "Email Address*"))
                                    $email=$data->value;
                                elseif(($data->label == "Phone Number")|| ($data->label == "Phone Number *") || ($data->label == "Phone Number*") || ($data->label == "Phone"))
                                    $phone=$data->value;
                                elseif(($data->label == "Zip Code")|| ($data->label == "Zip Code*")|| ($data->label == "Zipcode"))
                                    $zip=$data->value;
                                elseif($data->label == "Service Required" || $data->label == "Services Required")
                                    $service=$data->value;
                                elseif($data->label == "How can we help?")
                                    $message=$data->value;
                                elseif($data->label == "Email Routing")
                                    $email_routing=$data->value;
                                elseif($data->label == "Street Address...")
                                    $address=$data->value;
                                elseif($data->label == "Address Line 2")
                                    $address.=" ".$data->value;
                                elseif($data->label == "State")
                                    $state=$data->value;
                                //elseif($data->label == "Location ID")
                                    //$Location_ID=$data->value;
                                elseif($data->label == "Is this an emergency?" || $data->label == "This is an Emergency")
                                    $emergency=$data->value;
                            }
                            ?>
                            <tr>
                                <td class="location-title">
                                    <a target="_blank"  href='<?php echo $roll_updetail_page; ?>?rid=<?php echo $r_id; ?>'><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </td>
                                <td class="location-title"><?php echo $loc_title; ?></td>
                                <td class="location-formName"><?php echo $formName; ?></td>
                                <td class="location-zip"><?php echo $loc_postal_code; ?></td>
                                <td class="location-locId"><?php echo $franchise_id; ?></td>
                                <td><?php echo $deliveredDate; ?></td>
                                <td><?php echo $openedDate; ?></td>
                                <td class="location-to_mail"><?php echo $to_email; ?></td>
                                <td class="location-email"><?php echo $email; ?></td>
                                <td class="location-subject"><?php echo $subject; ?></td>
                                <td class="location-emergency"><?php echo $emergency; ?></td>
                                    <td class="location-name"><?php echo $name; ?></td>
                            <td class="location-address"><?php echo $address; ?></td>
                                <td class="location-state"><?php echo $state; ?></td>
                                <td class="location-phone"><?php echo $phone; ?></td>
                                <td class="location-zip"><?php echo $zip; ?></td>
                                <td class="location-zip"><?php echo $service; ?></td>
                                <td class="location-email_routing"><?php echo $email_routing; ?></td>
                                <td class="location-page_url"><?php echo $page_url; ?></td>
                            <td class="location-message1 messagedetail" ><?php echo $message; ?></td>
                            <td class="location-message"><?php echo substr($message,0,80); ?><?php if(!empty($message)){?>...<a target="_blank" href="<?php echo $roll_updetail_page; ?>?rid=<?php echo $r_id; ?>">View More</a><?php } ?></td>

                            </tr>
                        <?php }
                    }else{
						if($dataquery){
						while($entry_result = mysqli_fetch_assoc($dataquery)){
						$Location_ID=''; $email_routing=''; $message=''; $phone=''; $zip=''; $email=''; $service='';
						$name='';	$clicks_count=''; $opens_count=''; $to_email=''; $from_email; $mail_status='';
						$deliveredDate=''; $page_url='';  $address=''; $state=''; $emergency='';
							$r_id=$entry_result['id'];
							$entry_id=$entry_result['gf_entry_id'];
							$franchise_id=$entry_result['franchise_id'];
							$page_url=$entry_result['page_url'];
							$form_id=$entry_result['form_id'];
							$formName=isset($formArray[$form_id] ) ? $formArray[$form_id] : '';
							$loc_title_l=$entry_result['loc_title'];
							$loc_title=str_replace("Restoration 1 of ","",$loc_title_l);
							$loc_postal_code=$entry_result['loc_postal_code'];
							$deliveredDate=$entry_result['mail_date'];
							$openedDate=$entry_result['mail_opened_date'];
							$subject=$entry_result['mail_subject'];
							$to_email=$entry_result['to_email'];
							$from_email=$entry_result['from_email'];
							$mail_status=$entry_result['mail_status'];
							$opens_count=$entry_result['opens_count'];
							$clicks_count=$entry_result['clicks_count'];
							$form_data_json=$entry_result['form_data'];
							$form_data=json_decode($form_data_json);
							foreach($form_data as $data){
                                    if(($data->label == "Name") || ($data->label == "First Name*"))
                                        $name=$data->value;
                                    elseif(($data->label == "Last Name") || ($data->label == "Last Name*"))

                                        $name.=" ".$data->value;
                                    elseif(($data->label == "Email") || ($data->label == "Email Address*"))
                                        $email=$data->value;
                                    elseif(($data->label == "Phone Number")|| ($data->label == "Phone Number *") || ($data->label == "Phone Number*") || ($data->label == "Phone"))
                                        $phone=$data->value;
                                    elseif(($data->label == "Zip Code")|| ($data->label == "Zip Code*")|| ($data->label == "Zipcode"))
                                        $zip=$data->value;
                                    elseif($data->label == "Service Required" || $data->label == "Services Required")
                                        $service=$data->value;
                                    elseif($data->label == "How can we help?")
                                        $message=$data->value;
                                    elseif($data->label == "Email Routing")
                                        $email_routing=$data->value;
                                    elseif($data->label == "Street Address...")
                                        $address=$data->value;
                                    elseif($data->label == "Address Line 2")
                                        $address.=" ".$data->value;
                                    elseif($data->label == "State")
                                        $state=$data->value;
                                    //elseif($data->label == "Location ID")
                                        //$Location_ID=$data->value;
                                    elseif($data->label == "Is this an emergency?" || $data->label == "This is an Emergency")
                                        $emergency=$data->value;
                            }
                            ?>
								<tr>
									<td class="location-title">
										<a target="_blank"  href='report_detail.php?rid=<?php echo $r_id; ?>'><i class="fa fa-eye" aria-hidden="true"></i></a>
									</td>
									<td class="location-title"><?php echo $loc_title; ?></td>
									<td class="location-formName"><?php echo $formName; ?></td>
									<td class="location-zip"><?php echo $loc_postal_code; ?></td>
									<td class="location-locId"><?php echo $franchise_id; ?></td>
									<td><?php echo $deliveredDate; ?></td>
									<td><?php echo $openedDate; ?></td>
									<td class="location-to_mail"><?php echo $to_email; ?></td>
									<td class="location-email"><?php echo $email; ?></td>
									<td class="location-subject"><?php echo $subject; ?></td>
									<td class="location-emergency"><?php echo $emergency; ?></td>
										<td class="location-name"><?php echo $name; ?></td>
								<td class="location-address"><?php echo $address; ?></td>
									<td class="location-state"><?php echo $state; ?></td>
									<td class="location-phone"><?php echo $phone; ?></td>
									<td class="location-zip"><?php echo $zip; ?></td>
									<td class="location-zip"><?php echo $service; ?></td>
									<td class="location-email_routing"><?php echo $email_routing; ?></td>
									<td class="location-page_url"><?php echo $page_url; ?></td>
								<td class="location-message1 messagedetail" ><?php echo $message; ?></td>
								<td class="location-message"><?php echo substr($message,0,80); ?><?php if(!empty($message)){?>...<a target="_blank" href="report_detail.php?rid=<?php echo $r_id; ?>">View More</a><?php } ?></td>

								</tr>
							<?php } }
                            }
                        ?>
                        </tbody>
                    </table>
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


    <script src="<?php echo $adminurl; ?>/js/jquery.base64.js"></script>

    <script src="<?php echo $adminurl; ?>/js/tableExport.js"></script>

<script>

$(document).ready(function(){
  oTable=$('#locationestimate-table').DataTable( {
      "aLengthMenu": [[5, 10, 20, 50, -1], [5, 10, 20, 50, "All"]],
        "iDisplayLength": 10,
    });
    oSettings = oTable.settings(); //store its settings in oSettings

	//To export data to excel
$("#exportData").click(function() {
	oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
	   //set display length of dataTables settings to the total records available
	   oTable.draw();  //draw the table
		$('#locationestimate-table').tableExport({
			type : 'excel',
			escape : 'false',
			exportHiddenCells:true,
			ignoreColumn: [0,20]
		});
	});


	$("#ShowData").on('click',function(){
	var StartDate= document.getElementById('min_date').value;
  var EndDate= document.getElementById('max_date').value;
  var eDate = new Date(EndDate);
  var sDate = new Date(StartDate);
  if(StartDate!= '' && StartDate!= '' && sDate> eDate)
    {
    alert("Please ensure that the End Date is greater than Start Date.");
    return false;
    }
	});

});



/* for autocomplete Location */
$( function() {
		$.widget( "custom.location_auto", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-location_auto" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-location_auto-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						classes: {
							"ui-tooltip": "ui-state-highlight"
						}
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Locations" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-location_auto-toggle ui-corner-right" )
					.on( "mousedown", function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.on( "click", function() {
						input.trigger( "focus" );

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " didn't match any item" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});

		$( "#location_auto" ).location_auto();
		$( "#toggle" ).on( "click", function() {
			$( "#location_auto" ).toggle();
		});
	} );
  </script>
<?php include 'footer.php'; ?>
