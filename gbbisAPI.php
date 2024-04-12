<?php

ini_set('max_execution_time', '0');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'phpsqlsearch_dbinfo.php';
include "Functions.php";
require 'vendor/autoload.php';
$object = new Functions;

// before starting the api process , we are inserting the status 0  in the db table name json_api_status
date_default_timezone_set('America/Chicago');
$current_time = date('Y-m-d H:i:s');
$status_query = "Insert into json_api_status (start_time,status) VALUES ('$current_time',0)";
$status_query_result = mysqli_query($conn, $status_query);

if ($status_query_result) {
	$last_insert_id = mysqli_insert_id($conn);
}
try {

	$client = new \GuzzleHttp\Client();

	$Result = array();
	$page = 0;
	if ($page == 0) {
		$response = $client->request('GET', 'http://restorationone.mapwebserver10.com/api/restorationoneapi/GetTerritoryChanges?take=100&skip=0', array(
			'timeout' => 2400,
			// Response timeout
			'connect_timeout' => 480, // Connection timeout
		)
		);
		$res = $response->getBody()
			->getContents();
		$data = $res;
		$jsonData = json_decode($res);

		$Result = array_merge($Result, $jsonData->Territories);
	}

	$page = 100;
	$i = 1;



	while ($jsonData->AvailableOwned != 0) {
		sleep(2);
		$response = $client->request('GET', 'http://restorationone.mapwebserver10.com/api/restorationoneapi/GetTerritoryChanges?take=100&skip=' . $page, array(
			'timeout' => 2400,
			// Response timeout
			'connect_timeout' => 480, // Connection timeout
		)
		);
		$res = $response->getBody()
			->getContents();
		$data .= $res;
		$jsonData = json_decode($res);
		$Result = array_merge($Result, $jsonData->Territories);
		$i = $i + 1;
		$page = $page + 100;
	}



	$to = getenv('MAIL_TO');
	$subject = "store locator";

	//$headers = "From: store@example.com";
	if (!empty($Result)) {
		$aaa = 0;

		$sqlTruncate = "TRUNCATE TABLE jsondataAPI";
		mysqli_query($conn, $sqlTruncate);
		foreach ($Result as $row) {

			if ($row->Brand == "Restoration 1") {

				$territoryname = str_replace("'", "\'", $row->TerritoryName);
				$DonuntMarketingTerritory = str_replace("'", "\'", $row->DonuntMarketingTerritory);
				$OwnedTerritoryMarketing = str_replace("'", "\'", $row->OwnedTerritoryMarketing);
				if (!empty($row->ZipCodes)) {
					foreach ($row->ZipCodes as $allzips) {

						$message = "This is a Restoration 1 Result in zip code email sent";
						if ($aaa == 0) {
							// Send the email
							//if (mail($to, $subject, $message, $headers)) {
							if ($object->sendMail('', $to, $subject, $message, "")) {
								echo "Result started";
							} else {
								echo "Not Result started";
							}
						}
						$aaa++;
						//ParentLicenseNumber has changed to MarketingLicenseNumber and DonuntParentTerritory changed to DonuntMarketingTerritory
						$sql = "INSERT into jsondataAPI(TerritoryName,LicenseNumber,OwnedTerritoryParent,ParentLicenseNumber,DonuntParentTerritory,
							DonuntParentLicense,ZipCode,ZipCodeName,County,Status,Brand,created) VALUES ('" . $territoryname . "','" . $row->LicenseNumber . "','" . $OwnedTerritoryMarketing . "','" . $row->MarketingLicenseNumber . "','" . $DonuntMarketingTerritory . "','" . $row->DonuntMarketingLicense . "','" . $allzips->ZipCode . "','" . $allzips->ZipCodeName . "','" . $allzips->County . "','" . $row->Status . "','" . $row->Brand . "','" . $current_time . "')";

						if (!mysqli_query($conn, $sql)) {
							echo "Error in saving Zipcode" . $allzips->ZipCode;
						}
					}
				} else {
					$object->sendMail('', $to, $subject, "Entered part 2", "");
					//mail($to, $subject, "Entered part 2", $headers);
					$sql = "INSERT into jsondataAPI(TerritoryName,LicenseNumber,OwnedTerritoryParent,ParentLicenseNumber,DonuntParentTerritory,
							DonuntParentLicense,ZipCode,ZipCodeName,County,Status,Brand,created) VALUES ('" . $territoryname . "','" . $row->LicenseNumber . "','" . $OwnedTerritoryMarketing . "','" . $row->MarketingLicenseNumber . "','" . $DonuntMarketingTerritory . "','" . $row->DonuntMarketingLicense . "','0','0','0','" . $row->Status . "','" . $row->Brand . "','" . $current_time . "')";
					if (!mysqli_query($conn, $sql)) {
						echo "Error in saving Zipcode" . $row->TerritoryName;
					}
				}
			}
		}

		// dump json into a file on server
		$fileName = 'jsondump';
		$fileName = 'backup/jsondump/' . $fileName . "_" . date("m-d-Y_H-i-s", time()) . ".json";
		if (file_put_contents($fileName, '') !== false) {
			chmod($fileName, 0777);
			$fp = fopen($fileName, "w");
			fwrite($fp, json_encode($Result));
			fclose($fp);
			mysqli_query($conn, "INSERT INTO jsondump(filename,created) VALUES('" . mysqli_real_escape_string($conn, $fileName) . "','$current_time')");
		} else {
			mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('Zipcodesnew backup could not be uploaded','$current_time')");
		}
	}
} catch (Exception $e) {
	echo $e->getMessage();
	die;
	$message = $e->getMessage();
	mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('" . mysqli_real_escape_string($conn, $message) . "','$current_time')");
}

if (!empty($last_insert_id)) {
	$date = date("Y-m-d H:i:s");
	$status_query = "UPDATE json_api_status SET end_time='$date',status = 1 WHERE id = $last_insert_id";
	$status_query_result = mysqli_query($conn, $status_query);
}
die(" Cron run successfully");