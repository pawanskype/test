<?php //

include "header.php";
if(isset($_GET['rid']) && ($_GET['rid'] != '')){
$rid=	$_GET['rid'];
}
$softroc_rollup_url="https://softroc.com/api/rollupdetail.php?rid=".$rid;
$output = file_get_contents($softroc_rollup_url);
$response = json_decode($output);
if($response->status == "success"){
    $rollup_result =$response->result;
}
?>
<body class="admin-panel">
    <div class="container admin-body">
<?php
if($role == "admin" || $role == "superadmin") { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
        <div class="col-md-10">
          <div class="content-wrapper">
         <div class="col-sm-12 col-sm-12 col-xs-12 titlewrap"> <h1 class="page-title">Rollup Detail</h1>
		</div>
		</div>
         <section class="content-section map-content-section">
			<div  style="overflow: scroll;"  id="location-list">
					<table class="table table-bordred table-striped" id="mytable">
					<?php
				  if(isset($rollup_result) && !empty($rollup_result)){
                            foreach($rollup_result as $res){
                            $Location_ID=''; $email_routing=''; $message=''; $phone=''; $zip=''; $email=''; $service='';						$name='';	$clicks_count=''; $opens_count=''; $to_email=''; $from_email; $mail_status=''; 						$deliveredDate=''; $page_url='';  $address=''; $state=''; $exist_client=''; $emergency=''; $Iam_the='';
							$entry_id= $res->gf_entry_id;
                            $page_url= $res->page_url;
							$form_id= $res->form_id;
							$loc_title= $res->loc_title;
							$loc_postal_code= $res->loc_postal_code;
							$deliveredDate= $res->mail_date;
							$openedDate= $res->mail_opened_date;
							$subject= $res->mail_subject;
							$to_email= $res->to_email;
							$from_email= $res->from_email;
							$mail_status= $res->mail_status;
							$opens_count= $res->opens_count;
							$clicks_count= $res->clicks_count;
							$form_data_json= $res->form_data;
							$form_data=json_decode($form_data_json);
							foreach($form_data as $data){
								if(($data->label == "First Name") || ($data->label == "First Name*"))
									$name=$data->value;	
									elseif(($data->label == "Last Name") || ($data->label == "Last Name*"))	
									$name.=" ".$data->value;
									
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
                    }
                ?>
			  <tbody>
					<tr>

						<td>Location11</td><td><?php echo $loc_title; ?></td>
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
