<?php
/*ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);*/

include '../phpsqlsearch_dbinfo.php';
include "../Functions.php";
require '../vendor/autoload.php';
$object = new Functions;
$query = "select * from jsondataAPI";
$data = mysqli_query($conn, $query);
$count_of_records =  mysqli_num_rows($data);
$flag = false;
$location_id='';
$location_name='';
$parent_license='';
 

//Set CST time 
date_default_timezone_set('America/Chicago'); 
$current_time = date('Y-m-d H:i:s');

    if($count_of_records > 0){
	




	$sqlTruncate="TRUNCATE TABLE r1_failure";
	mysqli_query($conn,$sqlTruncate);
	$sqlTruncate1="TRUNCATE TABLE r1_bridge";
	mysqli_query($conn,$sqlTruncate1);
	$one = array();
	$two = array();

	//loop through
	$i = 1;
	while($Results = mysqli_fetch_assoc($data))
	{
      
		//print("<pre>");print_R($Results);die;
		//if($Results->Status=="Owned" || $Results->Status=="Donut"){ //Process only Donut and Owned status TerritoryName
		$flag = TRUE;
		if($Results['Brand'] =="Restoration 1")
		{
			$brand =	isset($Results['Brand'])?$Results['Brand']:'n/a';
			if(is_numeric($Results['ParentLicenseNumber']) || is_numeric($Results['DonuntParentLicense'])){


             
               
				if(is_numeric($Results['ParentLicenseNumber'])){
					$pid = $Results['ParentLicenseNumber'];
				}elseif(is_numeric($Results['DonuntParentLicense'])){
					$pid = $Results['DonuntParentLicense'];
				}

				$sqlparent="SELECT location_id,location_name,parent_license FROM r1_parent_info_lookUp WHERE brand=1 AND parent_license=".$pid; //Get parent data using parent license.

				$sql_run_query=mysqli_query($conn,$sqlparent);
				if($sql_run_query){		
					$status_data=mysqli_fetch_assoc($sql_run_query);
					if(!empty($status_data))
					{
						$location_id = isset($status_data['location_id'])?$status_data['location_id']:0;
						$location_name = isset($status_data['location_name'])?$status_data['location_name']:'n/a';
						
						$parent_license = isset($status_data['parent_license'])?$status_data['parent_license']:0;
						
						if(!in_array($Results["ZipCode"],array("0",null)))
						{
						
							
						$Country = explode(',',$Results['County']);
						
						if(!empty($Country)){
						    $exploadCounty  = isset($Country[1])?$Country[1]:'';
						}else{
						     $exploadCounty  = '';
						}
				
					  $licensenumber = isset($Results['LicenseNumber'])?$Results['LicenseNumber']:0;
					  $zipcode = isset($Results['ZipCode'])?$Results['ZipCode']:0;
					  $zipcodename = isset($Results['ZipCodeName'])?$Results['ZipCodeName']:'n/a';
					  
					  $status =isset($Results['Status'])?$Results['Status']:0;
					  
						$child_location_name = "RESTORATION 1 SERVING ".trim($exploadCounty," ")." ".trim($exploadCounty," ");												
						mysqli_query($conn, "INSERT into r1_bridge(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,created_at) VALUES (50,".$location_id.",'". $brand."','".$licensenumber."','".$parent_license."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$current_time."')");	


						}else
						{
							$Remark = 'Warning : No Zipcodes found';
							$child_location_name='';
							$licensenumber = isset($Results['LicenseNumber'])?$Results['LicenseNumber']:0;
							$status =isset($Results['Status'])?$Results['Status']:0;
							$location_name=isset($location_name) ? $location_name : '';
							$parent_license=isset($parent_license) ? $parent_license : '';
						

							mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$parent_license."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");	
						}
						
																
					}else{
						//exception for parent;
						$sqlparentlookup="SELECT Parent_Licence,Child_License FROM r1_parent_license_lookUp WHERE brand=1 AND Child_License=".$pid; //Get parent data using parent license.
						$sql_run_query_lookup=mysqli_query($conn,$sqlparentlookup);
						if($sql_run_query_lookup){	
							$status_data_lookup=mysqli_fetch_assoc($sql_run_query_lookup);
							if(!empty($status_data_lookup))
							{												
								$pid1 = isset($status_data_lookup['Parent_Licence']) ? $status_data_lookup['Parent_Licence'] : '0';
								$pidnew = isset($status_data_lookup['Child_License']) ? $status_data_lookup['Child_License'] : '0';
								$sqlparent="SELECT location_id,location_name,parent_license FROM r1_parent_info_lookUp WHERE brand=1 AND parent_license=".$pid1; //Get parent data using parent license again.
								$sql_run_query=mysqli_query($conn,$sqlparent);
								if($sql_run_query){	
									$status_datanew=mysqli_fetch_assoc($sql_run_query);
									if(!empty($status_datanew))
									{
										$location_id_new = isset($status_datanew['location_id']) ? $status_datanew['location_id'] : '0';
										$location_name = 	isset($status_datanew['location_name']  ) ? $status_datanew['location_name'] : '0';				
										$parent_license = 	isset($status_datanew['parent_license'] ) ? $status_datanew['parent_license'] : '0';

																
										$Country = explode(',',$Results['County']);
										
										if(!empty($Country)){
											$exploadCounty  = isset($Country[1])?$Country[1]:'';
										}else{
											$exploadCounty  = '';
										}
										
									
										$child_location_name=isset($child_location_name) ? $child_location_name : '0';
										$zipcode=isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';
										$Status=isset($Results['Status']) ? $Results['Status'] : '0';
										$ZipCodeName=isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '0';
										if(!in_array($Results["ZipCode"],array("0",null)))
										{
																											
											 mysqli_query($conn, "INSERT into r1_bridge(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,created_at) VALUES (50,".$location_id_new.",'".$brand."','".$pidnew."','".$pid1."','".$location_name."','".$child_location_name."','".$zipcode."','".$ZipCodeName."','".$exploadCounty."','".$Status."','".$current_time."')");

											

										}else
										{
											$Remark = 'Warning : No Zipcodes found';
											$child_location_name='';

											$licensenumber = isset($Results['LicenseNumber'])?$Results['LicenseNumber']:0;
											$status =isset($Results['Status'])?$Results['Status']:0;
											$location_name=isset($location_name) ? $location_name : '';
											$parent_license=isset($parent_license) ? $parent_license : '';


										 mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$parent_license."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");
											array_push($two,$i);
										}
										
													
														
									}else{
										//exception for parent;	
										$Remark = $pid1." Restoration1 Parent license is not found in r1_parent_info_lookUp table";
										$location_name='';
										$plicense='';

										$licensenumber = isset($Results['LicenseNumber'])?$Results['LicenseNumber']:0;
										$pid1=isset($pid1) ? $pid1 : '0';
										$status =isset($Results['Status'])?$Results['Status']:0;
										$location_name=isset($location_name) ? $location_name : '';
										$parent_license=isset($parent_license) ? $parent_license : '';
										$zipcode=isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';

										if(!in_array($zipcode,array("0",null)))
										{
											$zipcodename=isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '';
																
											$Country = explode(',',$Results['County']);
											if(!empty($Country)){
												$exploadCounty  = isset($Country[1])?$Country[1]:'';
											}else{
												$exploadCounty  = '';
											}
											
											$child_location_name = "RESTORATION 1 SERVING ".trim($zipcodename," ")." ".trim($exploadCounty," ");



											mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$pid1."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$Remark."','api','".$current_time."')");
											array_push($two,$i);
										}else
										{
											$Remark = 'Restoration zipcode not found';
											$child_location_name='';


											mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$pid1."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");
											array_push($two,$i);
										}
										
										
									}
								}				
							}else{
								$Remark = $pid." Restoration1 Parent license is not found in r1_parent_license_lookUp table";
								$location_name='';
								$plicense='';

								$licensenumber = isset($Results['LicenseNumber'])?$Results['LicenseNumber']:0;
								$pid=isset($pid) ? $pid : '0';
								$status =isset($Results['Status'])?$Results['Status']:0;
								$location_name=isset($location_name) ? $location_name : '';
								$zipcode=isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';
								$zipcodename=isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '';
											
								if(!in_array($zipcode,array("0",null)))
								{
									$Country = explode(',',$Results['County']);
									if(!empty($Country)){
										$exploadCounty  = isset($Country[1])?$Country[1]:'';
									}else{
										$exploadCounty  = '';
									}
									
									
									$child_location_name = "RESTORATION 1 SERVING ".trim($zipcodename," ")." ".trim($exploadCounty," ");


									 mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$pid."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$Remark."','api','".$current_time."')");
									array_push($two,$i);
									
									
								}else
								{
									$Remark = 'Restoration zipcode not found';
									$child_location_name='';


									 mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$pid."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");	
									array_push($two,$i);
								}
								
								
							}
						}
					}
				}	
				
			}else{

				
				$Remark = "Restoration1 Parent License Missing";
				$location_name='';
				$plicense='';
				
				$licensenumber = isset($Results['LicenseNumber'])?$Results['LicenseNumber']:0;
				$pid=isset($pid) ? $pid : '0';
				$status =isset($Results['Status'])?$Results['Status']:0;
				$location_name=isset($location_name) ? $location_name : '';
				$zipcode=isset($Results['ZipCode']) ? $Results['ZipCode'] : '0';
				$zipcodename=isset($Results['ZipCodeName']) ? $Results['ZipCodeName'] : '';

				if(!in_array($zipcode,array("0",null)))
				{

					$Country = explode(',',$Results['County']);
					if(!empty($Country)){
						$exploadCounty  = isset($Country[1])?$Country[1]:'';
					}else{
						$exploadCounty  = '';
					}

					$child_location_name = "RESTORATION 1 SERVING ".trim($zipcodename," ")." ".trim($exploadCounty," ");
					 mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$plicense."','".$location_name."','".$child_location_name."','".$zipcode."','".$zipcodename."','".$exploadCounty."','".$status."','".$Remark."','api','".$current_time."')");

					array_push($two,$i);
				}else
				{
					$Remark = 'Restoraion1 zipcode not found and parent license missing';
					$child_location_name = '';
					 mysqli_query($conn, "INSERT into r1_failure(buss_id,loc_id,brand,child_license,parent_license,parent_location_name,child_location_name,zipcode,city,state,status,remark,origin,created_at) VALUES (50,0,'".$brand."','".$licensenumber."','".$plicense."','".$location_name."','".$child_location_name."',0,'Nozipcode name','no state','".$status."','".$Remark."','api','".$current_time."')");

					array_push($two,$i);
				}
						
			}
			
		}
		
	
		
		$i++;
	}
	
}else{
			
			
			echo json_encode(array("err" => 100,"msg"=>"Software Mapping Data is empty"));die;
		}

  
	if($flag==TRUE)
	{
		
		
		$data='';
		$sqldump="SELECT * FROM zipcodesnew";
		$result = mysqli_query($conn,$sqldump);
		$zipcodesnewprocess = false;
		$r1_messages = array();
		$bf_messages = array();
		if(!empty($result) && mysqli_num_rows($result)>0)
		{
			try
			{
			   $csvdata = array();		
				while ($row = mysqli_fetch_array($result)){
					$csvdata[] = array(
						'buss_id' => $row['buss_id'],
						'loc_id' => $row['loc_id'],
						'r1_number' => $row['r1_number'],				
						'r1_number_parent' => $row['r1_number_parent'],				
						'parent_loc_name' => $row['parent_loc_name'],				
						'zip_name' => $row['zip_name'],				
						'zipcode' => $row['zipcode'],				
						'city' => $row['city'],				
						'state' => $row['state'],				
						'country' => $row['country'],				
						'phone_no' => $row['phone_no'],				
						'lat' => $row['lat'],				
						'lng' => $row['lng'],				
						'page_content' => $row['page_content'],				
					);
				}
                 
                 $fileName = 'zipcodesnewR1backup';
                 $fileName = '../backup/r1_backup/'.$fileName."_".date("Y-m-d_H-i-s",time()).".csv";
                 if (file_put_contents($fileName,'') !== false)
				 {
					 
					chmod($fileName, 0777);
					$fp = fopen ($fileName, "w");					
					fputcsv($fp, array('buss_id', 'loc_id', 'r1_number','r1_number_parent','parent_loc_name','zip_name','zipcode','city','state','country','phone_no','lat','lng','page_content'));
					foreach ($csvdata as $row) {
						//fputcsv formats the array into a CSV format.
						//It then writes the result to our output stream.
						fputcsv($fp, $row);
					}				
					fclose($fp);
					mysqli_query($conn,"INSERT INTO r1_backup(file_name,brand,created_at) VALUES('".mysqli_real_escape_string($conn, $fileName)."','Restoration 1','".$current_time."')");
					$updtsql="update zipcodesnew set flagtodelete=1";
     				mysqli_query($conn,$updtsql);
					$sql= "INSERT INTO zipcodesnew(buss_id,loc_id,r1_number_parent,r1_number,parent_loc_name,zip_name,zipcode,city,state)SELECT buss_id,loc_id,parent_license,child_license,parent_location_name,child_location_name,zipcode,city,state from r1_bridge where brand = 'Restoration 1'";
					
					$sendR1_failuremail = false;
					if(mysqli_query($conn,$sql))
					{
						$sqlTruncate="delete from zipcodesnew where flagtodelete=1";
						mysqli_query($conn,$sqlTruncate);
					
						$sendR1_failuremail = true;
						$zipcodesnewprocess = true;
				
						//main file present at public_html folder
						$currentFilePath = '../../store-locator-R1.xml';

						//backup will take in following location
						$newFilePath = "../store-locator-sitemap/sitemap-backup/sitemap".date("Y-m-d_H-i-s",time()).".xml";

						$fileMoved = rename($currentFilePath, $newFilePath);		//move file to new backup location
						if($fileMoved)
						{
						  $fileName = '../../store-locator-R1.xml';
						  $mysqlquery = mysqli_query($conn, "select z.zipcode,z.city from zipcodesnew z UNION select m.zipcode,m.city from markers m where m.adminid=50");
						$base_url = "https://www.restoration1.com/find-my-location/";
						$xmlString = "";
						$xmlString = '<?xml version="1.0" encoding="utf-8"?><!--Generated by Screaming Frog SEO Spider 10.2-->
							<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
						$date = date('Y-m-d');
						while ($row = mysqli_fetch_array($mysqlquery)){
							$city = str_replace(' ','_',$row['city']);
							$xmlString.= '<url>' . PHP_EOL;
							$xmlString.= '<loc>'.$base_url.$city.'/'.$row['zipcode'].'</loc>' . PHP_EOL;
							$xmlString.= '<lastmod>'.$date.'</lastmod>' . PHP_EOL;
							$xmlString.= '<changefreq>daily</changefreq>' . PHP_EOL;
							$xmlString.= '<priority>1.0</priority>' . PHP_EOL;
							$xmlString.= '</url>' . PHP_EOL;
							
						}
						$xmlString.= '</urlset>' . PHP_EOL;
						 
						$dom = new DOMDocument;
						$dom->preserveWhiteSpace = TRUE;
						$dom->loadXML($xmlString);
                         $filesaved = $dom->save($fileName);
						 if(!$filesaved)
						 {
							  $r1_messages[] = "Sitemap could not be uploaded local FTP and so not uploaded to Live FTP";	
						 }  						 
						}else
						{
						   $r1_messages[] = "Sitemap backup could not be saved and new site map could not be uploaded";	
						}
						
						
						
					}else
					{
						$r1_messages[] = "New data could not be inserted into zipcodesnew table and so new sitemap was not uploaded.";
						mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('R1 sitemap could not be created as zipcodesnew table not updated','".$current_time."')");
					}
					
				 }else
				 {
					  $r1_messages[] = "Zipcodesnew backup could not be uploaded and all Zipcodesnew process was ommitted.";
				    mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('Zipcodesnew backup could not be uploaded','".$current_time."')");	 
				 } 				 
			}catch(Exception $e) 
			{
				//Insert data in log table and check exception					
				mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('".mysqli_real_escape_string($conn, $e->getMessage())."','".$current_time."')");
			}
		}else
		{
			$r1_messages[] = "Zipcodesnew table is empty"; 
		   mysqli_query($conn, "INSERT into r1_logs(message,created_at) VALUES ('Zipcodesnew is empty','".$current_time."')");	
		}
		
		

       	 if($zipcodesnewprocess == true )
		 {
			// making stats
			$json_r1_owned = mysqli_num_rows(mysqli_query($conn, 'select * from jsondataAPI where Brand = "Restoration 1" and Status = "Owned"'));
		      
			  $json_r1_donut = mysqli_num_rows(mysqli_query($conn, 'select * from jsondataAPI where Brand = "Restoration 1" and Status = "Donut"'));
			  
			 
			  
			   if($zipcodesnewprocess == true)
			  {
				$db_r1_owned = mysqli_num_rows(mysqli_query($conn, 'select * from r1_bridge where  brand = "Restoration 1" and status = "Owned"'));
			  
			    $db_r1_donut = mysqli_num_rows(mysqli_query($conn, 'select * from r1_bridge where brand = "Restoration 1" and status = "Donut"'));

                $db_r1_owned_failures = mysqli_num_rows(mysqli_query($conn, 'select * from r1_failure where brand = "Restoration 1" and status = "Owned"'));
			  
			    $db_r1_donut_failures = mysqli_num_rows(mysqli_query($conn, 'select * from r1_failure where brand = "Restoration 1" and status = "Donut"'));				
			  }else
			  {
				$db_r1_owned = 0;
			  
			    $db_r1_donut = 0;
                $db_r1_owned_failures = 0 ;
			  
			     $db_r1_donut_failures = 0;  
			  }
			  
			   
			  
			  
			  
			  
			  $insertsql = "INSERT INTO gbbis_stats(json_r1_owned,json_r1_donut,database_r1_owned,database_r1_donut,database_r1_owned_failures,database_r1_donut_failures,created) VALUES ('".$json_r1_owned."','".$json_r1_donut."','".$db_r1_owned."','".$db_r1_donut."','".$db_r1_owned_failures."','".$db_r1_donut_failures."','".date("Y-m-d H:i:s")."')";
			  mysqli_query($conn,$insertsql);
		 }	
        
		// fauilure mail send 
	   $result_sql_restoration1 = mysqli_query($conn,"SELECT parent_license,remark,GROUP_CONCAT(zipcode) as zipcodes FROM r1_failure where buss_id = '50' GROUP BY remark");		

       $result_sql_bluefrog = mysqli_query($conn,"SELECT parent_license,remark,GROUP_CONCAT(zipcode) as zipcodes FROM r1_failure where buss_id = '49' GROUP BY remark");
      

      		if(isset($result_sql_restoration1) && mysqli_num_rows($result_sql_restoration1)>0){
				$j=1;
                $messageEmail= '';
				while($rowFetch = mysqli_fetch_array($result_sql_restoration1)){
					if(isset($sendR1_failuremail) and $sendR1_failuremail == true)
					{
					  $messageEmail .= '
						<p style="width: 68%; font-size:18px;">
							<span style=" color: rgb(43, 40, 40); font-size: 14px; font-weight: bold; margin-right:10px;">'.$j.'.</span>'.$rowFetch["remark"].'
						</p>
						<p style="width: 68%; font-size:18px;">
							<span style=" color: rgb(43, 40, 40); font-size: 14px; font-weight: bold; margin-right:10px;">Zipcodes effected</span>'.$rowFetch["zipcodes"].'
						</p>';	
					}
					
					
					
					$j++;
				}
				
				if(!empty($r1_messages))
				{
					$messageEmail .= "<p style = 'color:red;font-size:20px;'>Additional Notes:</p>";
                    					
					foreach($r1_messages as $k => $v)
					{
						$messageEmail .= "<p>****$v</p>";
					}
				}
				
					$object->sendFailureEmailRestoration1($messageEmail);
				
				
			}


			
			

			
          $object->testmessage("Process2 Finished");
          echo json_encode(array("err" => 200,"msg"=>"Process Completed"));die;
	}
	die;
	?>