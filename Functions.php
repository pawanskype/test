<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Load src from phpmailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



class Functions
{
	private $storelocatormail;

	public function __construct()
	{

		$this->storelocatormail = new PHPMailer;
		$this->storelocatormail->SMTPDebug = 4;
		$this->storelocatormail->isSMTP(); // Set mailer to use SMTP
		$this->storelocatormail->SMTPAuth = true; // Enable SMTP authentication
		$this->storelocatormail->Username = getenv('MAIL_USERNAME');
		$this->storelocatormail->Password = getenv('MAIL_PASSWORD');
		$this->storelocatormail->Host = getenv('MAIL_HOST');
		$this->storelocatormail->SMTPSecure = getenv('MAIL_ENCRYPTION'); // Enable TLS encryption, `ssl` also accepted
		$this->storelocatormail->Port = getenv('MAIL_PORT');
		$this->storelocatormail->SMTPKeepAlive = true;
		$this->storelocatormail->AuthType = 'PLAIN';
		$this->storelocatormail->setFrom(getenv('MAIL_FROM'), 'StoreLocator');
	}

	public function sendRegistrationEmail($username, $password, $to_address, $clientname)
	{


		$this->storelocatormail->addAddress($to_address, $username); // Add a recipient
		$this->storelocatormail->isHTML(true); // Set email format to HTML
		$this->storelocatormail->Subject = 'Storelocator Registration';
		$this->storelocatormail->Body = '<html>
		<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<title>Store Locator Registration</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<style>
		.wrapper{max-width:610px ; width:100%; margin:0px auto; }
		  
		@media only screen and (max-width: 610px){
			.wrapper{ max-width:100%; width:100% float:left;}
			.wrapper div{ width:100%; max-width:100%; }
		}
		</style>
		</head>

		<body style="width:100%; height:100%; font-size:12px; font-family: "Open Sans", sans-serif !important; margin:0px; padding:0px;">
		<div style="width:100%; float:left;">
			 <div class="wrapper">
				 
				 <div style="width:100%;float:left; border-bottom: 1px solid rgb(221, 221, 221);">
					 <div style="width:50%;margin:0 auto;padding-bottom: 18px; padding-top: 10px;">
						<img src="https://store-locator.lssdev.com/admin/defaultimages/storelocatorlogo.png" style="width:100%;"/>
					</div>
				 </div>
				 
				<div style="background-color: rgb(249, 249, 249);float: left;padding: 10px 6px;width: 98%;">
			
					<div style="width:100%;float:left;">
						<p style="font-size:18px; font-weight:normal; margin:0px">Dear ' . ucfirst($clientname) . ',</p><br>
						<p style="font-size:18px; margin:0px">Thank you for Choosing store Locator for your brand. Included in this email is important information to get started. <p>
										<p style="font-size:18px;">Please make note of your username and password</p>
					</div>
					 
					<div style="width:100%;float:left;">
						<div class="form-wrap" style="width:52%;margin:0 auto;">
							<form>
							   <div class="user-detail" style="margin-bottom: 15px;margin-top: 15px;">
									<p style="width: 68%; font-size:18px;"><span style=" color: rgb(43, 40, 40); font-size: 14px; font-weight: bold; margin-right:10px;">Username</span>' . $username . '</p>
									<p style="width: 68%; font-size:18px;"><span style=" color: rgb(43, 40, 40); font-size: 14px; font-weight: bold; margin-right:10px;">Password</span>' . $password . '</p>
									
								</div>
							   <a href="https://store-locator.lssdev.com/admin/" target="_blank" style="color: rgb(233, 125, 39); font-size: 19px;text-decoration: none;">Login to your admin section here.</a>
							</form>
						</div>
					</div>
					 
					<div style="width:100%;float:left; padding-top: 20px;">
					<p style="width:100%;float:left;color:#000;text-align:center; font-size:14px;">If you havent added your location already you can add the Address, Phone number and hours of each location to the spreadsheet attached. You can upload the spreadsheet to the add location section within your admin dashboard or send this back to us and we will upload for you."</p>
						
					</div>
					 
				</div>
					 
					<div style="width:100%;float:left;background: rgb(9, 83, 135) none repeat scroll 0 0;">
						<p style="width:100%;float:left;color:#fff;text-align:center;">Copyright © Store Locator 2017 </p>
					</div>
				 
			 </div>
			
		</div>

		</body>
		</html>';



		$this->storelocatormail->AddAttachment('bulk_uploads/locations.xls', "location_report.xls");
		$this->storelocatormail->AltBody = 'Unable to fetch proper content';
		//sdie("fff");
		if (!$this->storelocatormail->send()) {
			echo 'Mailer Error: ' . $this->storelocatormail->ErrorInfo;
			return "fail";
		} else {
			return "sent";
		}
	}




	public function sendMail($from, $to_address, $subject, $body, $attachment)
	{

		try {

			$emails = '';
			try {
				$emails = json_decode($to_address);
			} catch (Exception $e) {
				$emails = $to_address;
			}

			if (is_array($emails)) {
				foreach ($emails as $key => $value) {
					$this->storelocatormail->addAddress($value); // Add a recipient				
				}
			} else {
				$this->storelocatormail->addAddress($to_address); // Add a recipient
			}


			$this->storelocatormail->isHTML(true); // Set ethis->storelocatormail format to HTML

			$this->storelocatormail->Subject = $subject;
			$this->storelocatormail->Body = $body;
			if ($attachment != "") {
				$this->storelocatormail->AddAttachment('../../admin/c_uploads/' . $attachment, $attachment);
			}
			$this->storelocatormail->AltBody = 'Unable to fetch proper content';
			$this->storelocatormail->send();
			return 'Message Sent successfully';
		} catch (Exception $e) {
			return "Message could not be sent. Mail Error: {$this->storelocatormail->ErrorInfo}";
		}
	}



	public function sendFailureEmailRestoration1($data)
	{

		$subject = 'Store Locator GbBIS Failures (LIVE) - R1 ' . date("m/d/y H-i-s", time());

		$this->storelocatormail->SMTPDebug = 1;
		$this->storelocatormail->AddAddress('kbg.upwork.php@gmail.com', 'Dev Team'); // Add a 
		$this->storelocatormail->addAddress('Judyorr1979@gmail.com', 'Dev Team');
		$this->storelocatormail->addAddress('judy.orr@restoration1.com', 'Dev Team'); // Add a recipient
		$this->storelocatormail->addAddress(getenv('MAIL_TO'), 'Dev Team'); // Add a recipient



		$this->storelocatormail->isHTML(true); // Set ethis->storelocatormail format to HTML
		$this->storelocatormail->Subject = $subject;
		$this->storelocatormail->Body = '<html>
		<head>
		
		<title>Store Locator Processing Failures</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<style>
		.wrapper{max-width:610px ; width:100%; margin:0px auto; }
		  
		@media only screen and (max-width: 610px){
			.wrapper{ max-width:100%; width:100% float:left;}
			.wrapper div{ width:100%; max-width:100%; }
		}
		</style>
		</head>

		<body style="width:100%; height:100%; font-size:12px; font-family: "Open Sans", sans-serif !important; margin:0px; padding:0px;">
		<div style="width:100%; float:left;">
			 <div class="wrapper">
				 
				 <div style="width:100%;float:left; border-bottom: 1px solid rgb(221, 221, 221);">
					 <div style="width:50%;margin:0 auto;padding-bottom: 18px; padding-top: 10px;">
						<img src="https://restoration1.com/store-locator/admin/defaultimages/logo-restoration.png" style="width:100%;"/>
					</div>
				 </div>
				 
				<div style="background-color: rgb(249, 249, 249);float: left;padding: 10px 6px;width: 98%;">
			
					<div style="width:100%;float:left;">
						<p style="font-size:18px; font-weight:normal; margin:0px">Hello Admin,</p><br>
						<p style="font-size:18px; margin:0px">Please find below a list of errors encountered while uploading the latest JSON from GbBIS API ENDPOINT: <p>										
					</div>
					 
					<div style="width:100%;float:left;">
						<div class="form-wrap" style="width:80%;margin:0 auto;">
							<form>
							   <div class="user-detail" style="margin-bottom: 15px;margin-top: 15px;">
									' . $data . '
								</div>
							</form>
						</div>
					</div>
					 
				</div>
					 
					<div style="width:100%;float:left;background: rgb(9, 83, 135) none repeat scroll 0 0;">
						<p style="width:100%;float:left;color:#fff;text-align:center;">Copyright © Restoration1 2020 </p>
					</div>
				 
			 </div>
			
		</div>

		</body>
		</html>';
		echo "<br> come to step 2";
		if (!$this->storelocatormail->send()) {
			echo 'Mailer Error: ' . $this->storelocatormail->ErrorInfo;
			return "fail";
		} else {
			return "sent";
		}
	}
	public function testmessage($msg)
	{

		$subject = 'Testing Cron';

		$this->storelocatormail->addAddress(getenv('MAIL_TO'), 'Dev Team');
		// Add a recipient
		$recipients = array(
			'kbg.upwork.php@gmail.com' => 'Sahil',
		);
		$this->storelocatormail->Subject = $subject;
		foreach ($recipients as $email => $name) {
			$this->storelocatormail->AddCC($email, $name);
		}
		$this->storelocatormail->isHTML(true); // Set ethis->storelocatormail format to HTML
		$this->storelocatormail->Subject = $msg;
		$this->storelocatormail->Body = $msg;
		$this->storelocatormail->send();
	}


	public function sendRestoreEmail($data)
	{

		$this->storelocatormail->addAddress(getenv('MAIL_TO'), 'Dev Team'); // Add a recipient

		$this->storelocatormail->isHTML(true); // Set this->storelocatormail format to HTML
		$this->storelocatormail->Subject = 'Storelocator Restore Backup';
		$this->storelocatormail->Body = '<html>
		<head>
		
		<title>Storelocator Restore Backup</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<style>
		.wrapper{max-width:610px ; width:100%; margin:0px auto; }
		  
		@media only screen and (max-width: 610px){
			.wrapper{ max-width:100%; width:100% float:left;}
			.wrapper div{ width:100%; max-width:100%; }
		}
		</style>
		</head>

		<body style="width:100%; height:100%; font-size:12px; font-family: "Open Sans", sans-serif !important; margin:0px; padding:0px;">
		<div style="width:100%; float:left;">
			 <div class="wrapper">
				 
				 <div style="width:100%;float:left; border-bottom: 1px solid rgb(221, 221, 221);">
					 <div style="width:50%;margin:0 auto;padding-bottom: 18px; padding-top: 10px;">
						<img src="https://store-locator.lssdev.com/admin/defaultimages/storelocatorlogo.png" style="width:100%;"/>
					</div>
				 </div>
				 
				<div style="background-color: rgb(249, 249, 249);float: left;padding: 10px 6px;width: 98%;">
			
					<div style="width:100%;float:left;">
						<p style="font-size:18px; font-weight:normal; margin:0px">Hello Admin,</p><br>									
					</div>
					 
					<div style="width:100%;float:left;">
						<div class="form-wrap" style="width:80%;margin:0 auto;">
							<form>
							   <div class="user-detail" style="margin-bottom: 15px;margin-top: 15px;">
									' . $data . '
								</div>
							</form>
						</div>
					</div>
					 
				</div>
					 
					<div style="width:100%;float:left;background: rgb(9, 83, 135) none repeat scroll 0 0;">
						<p style="width:100%;float:left;color:#fff;text-align:center;">Copyright © Store Locator 2017 </p>
					</div>
				 
			 </div>
			
		</div>

		</body>
		</html>';

		if (!$this->storelocatormail->send()) {
			echo 'Mailer Error: ' . $this->storelocatormail->ErrorInfo;
			return "fail";
		} else {
			return "sent";
		}
	}


	public function sendFailureEmailRestoration1UsingMail($data)
	{

		$subject = 'Store Locator GbBIS Failures (LIVE) - R1 ' . date("m/d/y H-i-s", time());

		$this->storelocatormail->addAddress(getenv('MAIL_TO'), 'Dev Team'); // Add a recipient
		//$this->storelocatormail->addAddress('kbg.upwork.php@gmail.com', 'Dev Team'); 
		$this->storelocatormail->isHTML(true); // Set ethis->storelocatormail format to HTML
		$this->storelocatormail->Subject = $subject;



		$this->storelocatormail->Body = '<html>
		<head>
		
		<title>Store Locator Processing Failures</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<style>
		.wrapper{max-width:610px ; width:100%; margin:0px auto; }
		  
		@media only screen and (max-width: 610px){
			.wrapper{ max-width:100%; width:100% float:left;}
			.wrapper div{ width:100%; max-width:100%; }
		}
		</style>
		</head>

		<body style="width:100%; height:100%; font-size:12px; font-family: "Open Sans", sans-serif !important; margin:0px; padding:0px;">
		<div style="width:100%; float:left;">
			 <div class="wrapper">
				 
				 <div style="width:100%;float:left; border-bottom: 1px solid rgb(221, 221, 221);">
					 <div style="width:50%;margin:0 auto;padding-bottom: 18px; padding-top: 10px;">
						<img src="https://restoration1.com/store-locator/admin/defaultimages/logo-restoration.png" style="width:100%;"/>
					</div>
				 </div>
				 
				<div style="background-color: rgb(249, 249, 249);float: left;padding: 10px 6px;width: 98%;">
			
					<div style="width:100%;float:left;">
						<p style="font-size:18px; font-weight:normal; margin:0px">Hello Admin,</p><br>
						<p style="font-size:18px; margin:0px">Please find below a list of errors encountered while uploading the latest JSON from GbBIS API ENDPOINT: <p>										
					</div>
					 
					<div style="width:100%;float:left;">
						<div class="form-wrap" style="width:80%;margin:0 auto;">
							<form>
							   <div class="user-detail" style="margin-bottom: 15px;margin-top: 15px;">
									' . $data . '
								</div>
							</form>
						</div>
					</div>
					 
				</div>
					 
					<div style="width:100%;float:left;background: rgb(9, 83, 135) none repeat scroll 0 0;">
						<p style="width:100%;float:left;color:#fff;text-align:center;">Copyright © Restoration1 2020 </p>
					</div>
				 
			 </div>
			
		</div>

		</body>
		</html>';

		if (!$this->storelocatormail->send()) {
			echo 'Mailer Error: ' . $this->storelocatormail->ErrorInfo;

			return "fail";
		} else {

			return "sent";
		}
	}


	public function testmessageUsingMail($msg)
	{
		$subject = 'Testing Cron';
		$this->storelocatormail->Subject = $subject;
		$this->storelocatormail->addAddress(getenv('MAIL_TO'), 'Dev Team');
		$this->storelocatormail->Body = $msg;
		if (!$this->storelocatormail->send()) {
			echo 'Mailer Error: ' . $this->storelocatormail->ErrorInfo;

			return "fail";
		} else {

			return "sent";
		}
	}

	public function send_failure_api_msgUsingMail()
	{


		$subject = 'Store Locator API Reading Failure ' . date("m/d/y H-i-s", time());
		$this->storelocatormail->addAddress(getenv('MAIL_TO'), 'Dev Team');
		$this->storelocatormail->Subject = $subject;
		$this->storelocatormail->isHTML(true);
		$this->storelocatormail->Body = '<head>
		
		<title>Store Locator Processing Failures</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<style>
		.wrapper{max-width:610px ; width:100%; margin:0px auto; }
		  
		@media only screen and (max-width: 610px){
			.wrapper{ max-width:100%; width:100% float:left;}
			.wrapper div{ width:100%; max-width:100%; }
		}
		</style>
		</head>

		<body style="width:100%; height:100%; font-size:12px; font-family: "Open Sans", sans-serif !important; margin:0px; padding:0px;">
		<div style="width:100%; float:left;">
			 <div class="wrapper">
				 
				 <div style="width:100%;float:left; border-bottom: 1px solid rgb(221, 221, 221);">
					 <div style="width:50%;margin:0 auto;padding-bottom: 18px; padding-top: 10px;">
						<img src="https://store-locator.lssdev.com/admin/defaultimages/storelocatorlogo.png" style="width:100%;"/>
					</div>
				 </div>
				 
				<div style="background-color: rgb(249, 249, 249);float: left;padding: 10px 6px;width: 98%;">
			
					<div style="width:100%;float:left;">
						<p style="font-size:18px; font-weight:normal; margin:0px">Hello Admin,</p><br>
						<p style="font-size:18px; margin:0px">There is some issue  with API reading and data   <p>										
					</div>
					 

					 
				</div>
					 
					<div style="width:100%;float:left;background: rgb(9, 83, 135) none repeat scroll 0 0;">
						<p style="width:100%;float:left;color:#fff;text-align:center;">Copyright © Store Locator 2017 </p>
					</div>
				 
			 </div>
			
		</div>

		</body>
		</html>';

		if (!$this->storelocatormail->send()) {
			echo 'Mailer Error: ' . $this->storelocatormail->ErrorInfo;

			return "fail";
		} else {

			return "sent";
		}
	}

	public function fetchTerritoriesData($take, $skip = 0)
	{
		$url = sprintf('http://restorationone.mapwebserver10.com/api/restorationoneapi/GetTerritoryChanges?take=%u&skip=%u', $take, $skip);

		echo $url . '<br><br>';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);

		if ($response === false) {
			echo 'cURL Error: ' . curl_error($ch);
		}

		$results = json_decode($response);

		$territories = (!empty($results->Territories) ? $results->Territories : []);

		if (count($territories) > 0) {
			$territories = array_merge($territories, self::fetchTerritoriesData($take, $skip + $take));
		}

		curl_close($ch);

		return $territories;

	}
}