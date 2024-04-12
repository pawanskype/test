<?php //

include "header.php"; 

?>
<body class="admin-panel">
    <div class="container admin-body">
<?php
if(isset($_GET['rid']) && ($_GET['rid'] != '')){
	$rid=	$_GET['rid'];
	$sql_where =" id=".$rid;
	
}
 $sql="SELECT * FROM form_rollups where ".$sql_where;
	$dataquery = mysqli_query($con,$sql);

	
	$form_sql="SELECT form_id FROM `form_rollups` group by form_id";
	$form_data = mysqli_query($con,$form_sql);
	$form_ddl='';
	
	while($form_result=mysqli_fetch_assoc($form_data)){
		$formid=$form_result['form_id'];
		$formdbsql="select title from wp_w7smtofx3h_gf_form where id=".$formid;
		$form_namedata = mysqli_query($con,$formdbsql);
		$form_name=mysqli_fetch_row($form_namedata);
		if($formid == 154){
			$form_name="Contact Us";
		}else
			$form_name=$form_name[0];
	}	
		
	if($role == "admin" || $role == "superadmin") { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
        <div class="col-md-10">
          <div class="content-wrapper">
         <div class="col-sm-12 col-sm-12 col-xs-12 titlewrap"> <h1 class="page-title">Rollup Detail</h1>
		</div>
		</div>
         <section class="content-section map-content-section">
			<div id="location-list">
					<table class="table table-bordred table-striped" id="mytable">
					<?php 
						while($entry_result = mysqli_fetch_assoc($dataquery)){														$Location_ID=''; $email_routing=''; $message=''; $phone=''; $zip=''; $email=''; $service='';						$name='';	$clicks_count=''; $opens_count=''; $to_email=''; $from_email; $mail_status=''; 						$deliveredDate=''; $page_url='';  $address=''; $state=''; $exist_client=''; $emergency=''; $Iam_the='';
							$entry_id=$entry_result['gf_entry_id'];									$page_url=$entry_result['page_url'];	
							$form_id=$entry_result['form_id'];	
							$loc_title=$entry_result['loc_title'];	
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
									$name=$data->value;								elseif(($data->label == "Last Name") || ($data->label == "Last Name*"))									$name.=" ".$data->value;
								elseif(($data->label == "Email") || ($data->label == "Email Address*") || ($data->label == "Email Address"))
									$email=$data->value;
								elseif(($data->label == "Phone Number")|| ($data->label == "Phone Number *") || ($data->label == "Phone Number*") || ($data->label == "Phone"))
									$phone=$data->value;
								elseif(($data->label == "Zip Code")|| ($data->label == "Zip Code*")|| ($data->label == "Zipcode"))
									$zip=$data->value;
								elseif($data->label == "Service Required" || $data->label == "Services Required")
									$service=$data->value;
								elseif($data->label == "How can we help?")
									$message=$data->value;								elseif($data->label == "Existing Client?")									$exist_client=$data->value;																	elseif($data->label == "Email Routing")									$email_routing=$data->value;								elseif($data->label == "Location ID")									$Location_ID=$data->value;								elseif($data->label == "Street Address...")									$address=$data->value;								elseif($data->label == "Address Line 2")									$address.=" ".$data->value;								elseif($data->label == "State")									$state=$data->value;								elseif($data->label == "I am the")									$Iam_the=$data->value;								elseif($data->label == "Is this an emergency?" || $data->label == "This is an Emergency")									$emergency=$data->value;
						}
					
						?>
			  <tbody>
					<tr>
						
						<td>Location</td><td><?php echo $loc_title; ?></td>
						</tr>												<tr><td>Page Url</td><td><?php echo $page_url; ?></tr>						<tr><td>Location ID</td><td><?php echo $Location_ID; ?></tr>						<tr><td>Email Routing</td><td><?php echo $email_routing; ?></tr>						<tr>
						<td>Location Zipcode</td><td><?php echo $loc_postal_code; ?></td>
						</tr><tr>
						<td>Delivery Date</td><td><?php echo $deliveredDate; ?></td>
						</tr><tr>
						<td>Opened Date</td><td><?php echo $openedDate; ?></td>
						</tr><tr>
						<td>To Email</td><td><?php echo $to_email; ?></td>
						</tr><tr>
						</tr>						<tr><td>Subject</td><td><?php echo $subject; ?></tr>						<tr><td>Name</td><td><?php echo $name; ?></td></tr>												<td>From Email</td><td><?php echo $email; ?></td>											<tr><td>Phone</td><td><?php echo $phone; ?></td></tr>						<tr><td>Zipcode</td><td><?php echo $zip; ?></td></tr>												<?php if($address != '' && !empty($address)){?>						<tr><td>Address</td><td><?php echo $address; ?></td></tr>						<?php } ?>								<?php if($state != '' && !empty($state)){?>						<tr><td>State</td><td><?php echo $state; ?></td></tr>						<?php } if($exist_client != '' && !empty($exist_client)){?>						<tr><td>Existing Client</td><td><?php echo $exist_client; ?></td></tr>						<?php } if($Iam_the != '' && !empty($Iam_the)){?>						<tr><td>I am the</td><td><?php echo $Iam_the; ?></td></tr>						<?php  }  if($emergency != '' && !empty($emergency)) { ?>						<tr><td>EMERGENCY</td><td><?php echo $emergency; ?></td></tr>						<?php } if($service != '' && !empty($service)){?>						<tr><td>Services Required</td><td><?php echo $service; ?></td></tr>						<?php  } if($message != '' && !empty($message)){?>						<tr><td>How Can We Help (Message)</td><td><?php echo $message; ?></td></tr>													<?php } ?>
							<?php }
							
							?>
							</tbody>
							
							</table>
					</div>
              </div>
            </section>
          </div><!-- /.content-wrapper -->
        </div><!-- /.col -->
      </div><!-- /.row -->
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	<?php } 
	?>
    </div><!-- /.container -->
<?php  $_SESSION['session_adminid']=!empty($_GET['adminid']) ? $_GET['adminid'] : ""; 

?>

<?php include 'footer.php'; ?>
