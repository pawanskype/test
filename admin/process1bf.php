<?php
 header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");


//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include '../phpsqlsearch_dbinfo.php';
include "../Functions.php";
require '../vendor/autoload.php';
$object = new Functions;



 	try{
		 $client = new \GuzzleHttp\Client();
//$object->testmessage("Process1 Started");
			
		$Result = array();
		    $page= 0;
			if($page==0)
			{
			   $response = $client->request('GET', 'http://restorationone.mapwebserver05.com/api/restorationoneapi/GetTerritoryChanges?take=100&skip=0', array(
				'timeout' => 600, // Response timeout
				'connect_timeout' => 120, // Connection timeout
				));	
				$res = $response->getBody()
                ->getContents();
				$data = $res;
				$jsonData = json_decode($res);
				$Result = array_merge($Result, $jsonData->Territories);
			}
			
			$page=100;
		    $i=1;
			while($jsonData->AvailableOwned!=0)
			{
				$response = $client->request('GET', 'http://restorationone.mapwebserver05.com/api/restorationoneapi/GetTerritoryChanges?take=100&skip='.$page, array(
				'timeout' => 600, // Response timeout
				'connect_timeout' => 120, // Connection timeout
				));	
				$res = $response->getBody()
                ->getContents();
				$data .= $res;
				$jsonData = json_decode($res);
				$Result = array_merge($Result, $jsonData->Territories);
				$i = $i+1;
			    $page=$page+100;
			}
		
	
		
		date_default_timezone_set('America/Chicago'); 
		$current_time = date('Y-m-d H:i:s');
		
		if(!empty($Result))
		{
			$sqlTruncate="TRUNCATE TABLE jsondataAPI_bf";
			mysqli_query($conn,$sqlTruncate);
			foreach($Result as $row)
			{
				if($row->Brand == "Bluefrog Plumbing and Drain")
				{
				   $territoryname=str_replace("'","\'",$row->TerritoryName);
				$DonuntMarketingTerritory=str_replace("'","\'",$row->DonuntMarketingTerritory);
				$OwnedTerritoryMarketing=str_replace("'","\'",$row->OwnedTerritoryMarketing);
				if(!empty($row->ZipCodes))
				{
					foreach($row->ZipCodes as $allzips)
					{
					
						$sql = "INSERT into jsondataAPI_bf(TerritoryName,LicenseNumber,OwnedTerritoryParent,ParentLicenseNumber,DonuntParentTerritory,
						DonuntParentLicense,ZipCode,ZipCodeName,County,Status,Brand,created) VALUES ('".$territoryname."','".$row->LicenseNumber."','".$OwnedTerritoryMarketing."','".$row->MarketingLicenseNumber."','".$DonuntMarketingTerritory."','".$row->DonuntMarketingLicense."','".$allzips->ZipCode."','".$allzips->ZipCodeName."','".$allzips->County."','".$row->Status."','".$row->Brand."','".$current_time."')";
						if (!mysqli_query($conn, $sql))
							{
								echo "Error in saving Zipcode".$allzips->ZipCode;
							}
					}
				}else
				{
					$sql = "INSERT into jsondataAPI_bf(TerritoryName,LicenseNumber,OwnedTerritoryParent,ParentLicenseNumber,DonuntParentTerritory,
						DonuntParentLicense,ZipCode,ZipCodeName,County,Status,Brand,created) VALUES ('".$territoryname."','".$row->LicenseNumber."','".$OwnedTerritoryMarketing."','".$row->MarketingLicenseNumber."','".$DonuntMarketingTerritory."','".$row->DonuntMarketingLicense."','0','0','0','".$row->Status."','".$row->Brand."','".$current_time."')";
					if (!mysqli_query($conn, $sql))
							{
								echo "Error in saving Zipcode".$row->TerritoryName;
							}
				}	
				}
				
			}

	// dump json into a file on server 
			 $fileName = 'jsondump_bf';
                 $fileName = '../backup/jsondump/'.$fileName."_".date("m-d-Y_H-i-s",time()).".json";
				 $path = 'backup/jsondump/jsondump_'.date("m-d-Y_H-i-s",time()).".json";
				 if (file_put_contents($fileName,'') !== false)
				 {
					
					chmod($fileName, 0777);
					$fp = fopen ($fileName, "w");
					fwrite($fp,  json_encode($Result));
					fclose($fp);
					
					mysqli_query($conn,"INSERT INTO jsondump_bf(filename,created) VALUES('".mysqli_real_escape_string($conn, $path)."','$current_time')");
					
				 }else
				 {
					  
					mysqli_query($conn, "INSERT into r1_logs_bf(message,created_at) VALUES ('process1BF Zipcodesnew backup could not be uploaded','$current_time')"); 
				 }
			echo json_encode(array("err" => 200,"msg"=>"Latest JSON uploaded succesfully . Please proceed to Process2."));die;
       }else
	   {
		   echo json_encode(array("err" => 300,"msg"=>"No Data was returned by API"));die;
		   
	   }

      }catch (Exception $e) {
         echo json_encode(array("err" => 100,"msg"=>"something went wrong"));die;
    }
die;	
?>	      