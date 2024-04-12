<?php
include('../restApi.php');
include '../phpsqlsearch_dbinfo.php';
$radius=999999999999999;
$adminid=53;
$api = new restApi;
//if($api->checkAuth()){
	$status = 0;
	$output=array();
    $statusCode = 400;
	//$data = json_decode(file_get_contents('php://input'), true);
	
	if(!empty($_REQUEST['zipcode'])){	
		$zipcode = $_REQUEST['zipcode'];
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($zipcode)."&sensor=false&key=".$g_api_key;
		$result_string = file_get_contents($url);
		$result = json_decode($result_string, true);
		
		if(empty($result['results'])){
				$api->response($api->json([],"Invalid Zipcode",$statusCode,$status), $statusCode);
		}else{
			$center_lat = $result['results'][0]['geometry']['location']['lat'];
			$center_lng = $result['results'][0]['geometry']['location']['lng'];
			$query = sprintf("SELECT m.emailmesageid as email,m.id as ID,z.r1_number,z.parent_loc_name,m.zipcode as zipcode, m.lat,  m.lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians(  m.lat ) ) * cos( radians(  m.lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( m.lat ) ) ) ) AS distance  FROM markers m INNER JOIN zipcodesnew_sr z on m.id=z.loc_id  WHERE m.adminid='$adminid' and FIND_IN_SET('$zipcode',z.zipcode) > 0 HAVING distance < %s ORDER BY distance",
			mysqli_real_escape_string($conn,$center_lat),
			mysqli_real_escape_string($conn,$center_lng),
			mysqli_real_escape_string($conn,$center_lat),
			mysqli_real_escape_string($conn,$radius));
			$result = mysqli_query($conn,$query);	  
			if(mysqli_num_rows($result)>0 ){
				$row = $result->fetch_row();		//fetch first record
				$output['Franchise_ID']=$row[2];
				$output['Franchise_Name']=$row[3];
				$email=$row[0];
				$output['email']=$email;
				if(mysqli_num_rows($result) == 2){
						//$output['email']="marketing@restoration1.com";
						$output['status']="shared";
				}else{
							
							if(mysqli_num_rows($result) > 2):
								$output['status']="unowned";
								$output['nearest_zip']=$row[4];
							else:
								$output['status']="single";
							endif;
				}
				
				$api->response($api->json($output,'success',200,1), 200); 	
			}else{
				 $query = sprintf("SELECT emailmesageid as email,id,name,zipcode, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' AND zipcode='$zipcode' HAVING distance < %s ORDER BY distance",
				 mysqli_real_escape_string($conn,$center_lat),
				 mysqli_real_escape_string($conn,$center_lng),
				 mysqli_real_escape_string($conn,$center_lat),
				 mysqli_real_escape_string($conn,$radius));
				 
				  $result =mysqli_query($conn,$query);
				 
				  if(mysqli_num_rows($result) > 0 ){
					  	$row = $result->fetch_row();		//fetch first record
						$marker_Id=$row[1];
						$franchiseArray=funcGetFranchise($marker_Id,$conn);
						$output['Franchise_ID']=$franchiseArray['r1_number'];
						$output['Franchise_Name']=$franchiseArray['parent_loc_name'];
						$email=$row[0];
						$output['email']=$email;
						if(mysqli_num_rows($result) == 2){
								//$output['email']="marketing@restoration1.com";
								$output['status']="shared";
							}else{
									if(mysqli_num_rows($result) > 2):
										$output['status']="unowned";
										$output['nearest_zip']=$row[3];
									else:
										$output['status']="single";
									endif;
						}
			}else{
				$query = sprintf("SELECT emailmesageid as email,id,name,zipcode, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' HAVING distance < %s ORDER BY distance LIMIT 0,10",
				 mysqli_real_escape_string($conn,$center_lat),
				 mysqli_real_escape_string($conn,$center_lng),
				 mysqli_real_escape_string($conn,$center_lat),
				 mysqli_real_escape_string($conn,$radius));
				 
				  $result =@mysqli_query($conn,$query); 
				
					if(@mysqli_num_rows($result)>0 ){
							$row = $result->fetch_row();		//fetch first record
							$marker_Id=$row[1];
						$franchiseArray=funcGetFranchise($marker_Id,$conn);
						$output['Franchise_ID']=$franchiseArray['r1_number'];
						$output['Franchise_Name']=$franchiseArray['parent_loc_name'];
						$email=$row[0];
						//$output['email']=$email;
						$output['email']="info@softroc.com";
						if(mysqli_num_rows($result) == 2){
								//$output['email']="marketing@restoration1.com";
									$output['status']="shared";
							}else{
									if(mysqli_num_rows($result) > 2):
										$output['status']="unowned";
										$output['nearest_zip']=$row[3];
									else:
										$output['status']="single";
									endif;
								}			
					}
			}	

		}
		

			$status = 1;
			$statusCode = 200;
			$message = 'success';	
		$api->response($api->json($output,$message,$statusCode,$status), $statusCode); 	
	}
}else{
        $message = 'Post parameters not found';   
				$api->response($api->json([],$message,$statusCode,$status), $statusCode);
	}

	
	

	
	
function funcGetFranchise($marker_Id,$conn)
{
	$franchiseData=array();
    $q2="select r1_number,parent_loc_name from zipcodesnew_sr where loc_id='".$marker_Id."' and r1_number!='' limit 1";
	$franchiseResult=mysqli_query($conn,$q2);
	  if(mysqli_num_rows($franchiseResult)>0 ){
		  while ($francRes = @mysqli_fetch_assoc($franchiseResult)){
			  $franchiseData['r1_number']=$francRes['r1_number'];
			  $franchiseData['parent_loc_name']=$francRes['parent_loc_name'];
		  }
	  }else{
        $franchiseData['r1_number']='';
        $franchiseData['parent_loc_name']='';
      }	 
	return $franchiseData;
}



?>