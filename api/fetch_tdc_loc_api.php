<?php
//Api to fetch Locations data based upon State Name

include('../restApi.php');
include '../phpsqlsearch_dbinfo.php';
require("../script-rest/common_locurl.php");
$radius=999999999999999;
$adminid=52;  // id for tdc admin
$base_url = "https://thedrivewaycompany.com";
$status = 0;
$output=array();
$statusCode = 400;
$api = new restApi;
$zipdata['zipscodes']=array();
$zipcode_tbl = "zipcodesnew_tdc";
$output=array();
if(!empty($_REQUEST['search']) ){	
	$search_parameter=$_REQUEST['search'];
	//its state code
	if(preg_match("/[a-zA-Z]/i", $search_parameter)){
		if(strlen($search_parameter)> 2){
			//check for 2letter state code
			$message = 'State code should be 2 letters only';   
			$api->response($api->json([],$message,506,$status), 506);	
		}else{
            $state=$search_parameter;
            if(strlen($state) == 2){
                $state=findState_Name($state,$conn);
                if($state == ''){
                    $api->response($api->json([],"Invalid State Code",507,$status), 507);
                } 
            }
			$state_str=str_replace(" ","%20",$state);
			$tdc_apiurl = "https://thedrivewaycompany.com/thedrivewaycompany-store-locator-api/?state=" . $state . '&token=$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $tdc_apiurl);
            $output = curl_exec($ch);  
            $response = json_decode($output);
			
            if($response->status == "success"){
                $bf_datalist=$response->result->zipscodes;
                $bf_urllist=$response->result->url;
                for($i=0; $i < count($bf_datalist); $i++){
                    $zipdata['zipscodes'][] = $bf_datalist[$i];
                    $zipdata['url'][] = $bf_urllist[$i];//fetch visit website url(extrenal link)
                }
                if($state == "South Carolina"){     //Need to show this North Carolina (28173) in SC
                    $zipdata['zipscodes'][]=28173;
                    $zipdata['url'][] ='';
                }
                $post_counteR= count($bf_datalist);
                $allZipdata=$zipdata;
                require_once("location_api.php");
                $status = 1;
                $statusCode = 200;
                $message = 'success';
                $api->response($api->json($childCity,$message,$statusCode,$status), $statusCode);
            }else{
                $message = 'Coming to Your State Soon';   
                $api->response($api->json([],$message,500,$status), 500);
            }
    	}
	}elseif((strlen($search_parameter) < 4) || (strlen($search_parameter) > 5)){
		//check for 4 or 5digit zip code
		$message = 'Zip code should be 5 digits only';   
		$api->response($api->json([],$message,506,$status), 506);	
	}else{
		//For checking zip data
		$url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($search_parameter)."&sensor=false&key=".$g_api_key;
		$result_string = file_get_contents($url);
		$result = json_decode($result_string, true);
		if($result['status'] != 'REQUEST_DENIED'){	
			if(empty($result['results'])){
					$api->response($api->json([],"Invalid Zipcode",507,$status), 507);
			}else{
			$center_lat = $result['results'][0]['geometry']['location']['lat'];
			$center_lng = $result['results'][0]['geometry']['location']['lng'];
			$query = sprintf("SELECT z.id as ID,z.zip_name,z.zipcode as newzip,z.city,z.state,z.country,z.lat newlat,z.lng newlng,m.address,m.phone, m.id, m.adminid, m.slug, m.name,m.zipcode,m.addressshow FROM markers m INNER JOIN ".$zipcode_tbl." z on m.id=z.loc_id  WHERE m.adminid='$adminid' and FIND_IN_SET('$search_parameter',z.zipcode) > 0",
			mysqli_real_escape_string($conn,$center_lat),
			mysqli_real_escape_string($conn,$center_lng),
			mysqli_real_escape_string($conn,$center_lat),
			mysqli_real_escape_string($conn,$radius));
		   
		  $result = mysqli_query($conn,$query);	  
		  if(mysqli_num_rows($result)>0 ){
		  if (!$result) {
			  die("Invalid query: " . mysqli_error());
			}
				$output['searchedterm']="zip";
				$output['type']=findZipCodeCountStatus(mysqli_num_rows($result));
				
			// Iterate through the rows, adding XML nodes for each
			while ($row = @mysqli_fetch_assoc($result)){
					  
			  $lat = $row['newlat'];
			  $lng = $row['newlng'];
			  $phone=trim($row['phone']);
                   
			if(strpos($phone, '-') !== false)
			{
				$phone_no= ltrim($phone,"1");
			}else{
					$phone_no1=ltrim($phone,"1");
			   $phone_no= "(".substr($phone_no1, 0, 3).") ".substr($phone_no1, 3, 3)."-".substr($phone_no1,6);
		   
			}
			 if (substr($search_parameter, 0, 1) != '0' && strlen($search_parameter)==4) {	
					$search_parameter = '0'.$search_parameter;
				}else if (substr($search_parameter, 0, 1) != '0' && strlen($search_parameter)==3){
					$search_parameter = '00'.$search_parameter;
				}
				 $purl=get_State_PageUrl($row['state'],$row['name'], $conn ,$zipcode_tbl);
             if(mysqli_num_rows($result) > 1)
				 $zipnewId = $row['ID'];
			 else
				 $zipnewId = '';
				$area_zipcode=$row['zipcode'];
				$state_abbrv=trim($row['state']);
				if(strlen($state_abbrv) == 2){
					$state=findState_Name($state_abbrv,$conn);
				}else{
					$state=$row['state'];
				}
				
			/*	$term_id= findState_SlugTerm($state,$conn,"bf");		
				if($term_id != '' ){
						$ptitle=substr($row['name'], 17);
						$website_url=findZipWebsiteUrl($term_id,$ptitle,$conn);
				}else{
					$website_url='';
				}
				*/
				$serverdarea=get_commonserved_area($area_zipcode,$conn ,$zipcode_tbl);
				 $output[]=array("zipnewId" =>$zipnewId , "id" => $row['id'],
				 "adminid"=> $row['adminid'],
				 "slug"=> $row['slug'],
				 "name"=> $row['name'],
				// "address"=> $row['address'],
				 "address"=> ucwords(strtolower($row['city'])).", ".$row['state']." ".$row['zipcode'],
				 "city"=> toTitleCase($row['city']),
				 "Cities" => $serverdarea,
				 "state"=> $row['state'],
				 "phone"=>$phone_no,
				 "lat"=>$lat,
				 "lng"=> $lng,
				 "distance"=>0,			 
				 "zip"=> $search_parameter,
				 "addressshow"=> $row['addressshow'],
				 "url" => $purl,
				 "visit_websiteurl"	=>  ''
				 );
			}
			
			$api->response($api->json($output,'success',200,1), 200); 
		 }else{
			 $query = sprintf("SELECT address, city, state, phone, id, adminid, slug, name,zipcode,addressshow, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' AND zipcode='$search_parameter' HAVING distance < %s ORDER BY distance",
			 mysqli_real_escape_string($conn,$center_lat),
			 mysqli_real_escape_string($conn,$center_lng),
			 mysqli_real_escape_string($conn,$center_lat),
			 mysqli_real_escape_string($conn,$radius));
			 
			  $result =mysqli_query($conn,$query);
			 if(mysqli_num_rows($result)>0 ){
					 if (!$result) {
						  die("Invalid query: " .mysqli_error());
						}
					$output['searchedterm']="zip";		
				$output['type']=findZipCodeCountStatus(mysqli_num_rows($result));
				
				// Iterate through the rows, adding XML nodes for each
				while ($row = @mysqli_fetch_assoc($result)){
					$phone=trim($row['phone']);

					if(strpos($phone, '-') !== false)
					{
						$phone_no= ltrim($phone,"1");
					}else{
							$phone_no1=ltrim($phone,"1");
					   $phone_no= "(".substr($phone_no1, 0, 3).") ".substr($phone_no1, 3, 3)."-".substr($phone_no1,6);
				   
					}
						$state_abbrv=trim($row['state']);
						if(strlen($state_abbrv) == 2){
							$state=findState_Name($state_abbrv,$conn);
						}else{
							$state=$row['state'];
						}
						
				/*	$term_id= findState_SlugTerm($state,$conn,"bf");		
						if($term_id != '' ){
								$ptitle=substr($row['name'], 17);
								$website_url=findZipWebsiteUrl($term_id,$ptitle,$conn);
						}else{
							$website_url='';
						}*/
					$serverdarea=get_commonserved_area($row['zipcode'],$conn ,$zipcode_tbl);	
					$purl=get_State_PageUrl($row['state'],$row['name'], $conn,$zipcode_tbl);
            					 $output[]=array("id" => $row['id'],
						 "adminid"=> $row['adminid'],
						 "slug"=> $row['slug'],
						 "name"=> $row['name'],
						 "address"=>  ucwords(strtolower($row['city'])).", ".$row['state']." ".$row['zipcode'],
						 "city"=> toTitleCase($row['city']),
						"Cities" => $serverdarea,
						 "state"=> $row['state'],
						 "phone"=>$phone_no,
						 "lat"=>$row['lat'],
						 "lng"=> $row['lng'],
						 "distance"=>$row['distance'],			 
						 "zip"=> $row['zipcode'],
						 "addressshow"=> $row['addressshow'],
						 "url" => $purl,
				 "visit_websiteurl"	=>  ''
						 );
				}
				
		     }else{
				$query = sprintf("SELECT address, city, state, phone, id, adminid, slug, name,zipcode,addressshow, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' HAVING distance < %s ORDER BY distance LIMIT 0 , 10",
				 mysqli_real_escape_string($conn,$center_lat),
				 mysqli_real_escape_string($conn,$center_lng),
				 mysqli_real_escape_string($conn,$center_lat),
				 mysqli_real_escape_string($conn,$radius));
				 
				  $result =mysqli_query($conn,$query); 
				  if (!$result) {
						  die("Invalid query: " .mysqli_error());
						}
							$output['searchedterm']="zip";
				$output['type']=findZipCodeCountStatus(mysqli_num_rows($result));
				
				// Iterate through the rows, adding XML nodes for each
				while ($row = @mysqli_fetch_assoc($result)){
					$phone=trim($row['phone']);

					if(strpos($phone, '-') !== false)
					{
						$phone_no= ltrim($phone,"1");
					}else{
							$phone_no1=ltrim($phone,"1");
					   $phone_no= "(".substr($phone_no1, 0, 3).") ".substr($phone_no1, 3, 3)."-".substr($phone_no1,6);
				   
					}
					 $purl=get_State_PageUrl($row['state'],$row['name'], $conn,$zipcode_tbl);
						$state_abbrv=trim($row['state']);
						if(strlen($state_abbrv) == 2){
							$state=findState_Name($state_abbrv,$conn);
						}else{
							$state=$row['state'];
						}
						
					/*	$term_id= findState_SlugTerm($state,$conn,"bf");		
						if($term_id != '' ){
								$ptitle=substr($row['name'], 17);
								$website_url=findZipWebsiteUrl($term_id,$ptitle,$conn);
						}else{
							$website_url='';
						}
                        */
					$serverdarea=get_commonserved_area($row['zipcode'],$conn ,$zipcode_tbl);	
             		 $output[]=array("id" => $row['id'],
						 "adminid"=> $row['adminid'],
						 "slug"=> $row['slug'],
						 "name"=> $row['name'],
						 "address"=>  ucwords(strtolower($row['city'])).", ".$row['state']." ".$row['zipcode'],
						 "city"=> toTitleCase($row['city']),
						 "state"=> $row['state'],
						"Cities" => $serverdarea,
						 "phone"=>$phone_no,
						 "lat"=>$row['lat'],
						 "lng"=> $row['lng'],
						 "distance"=>$row['distance'],			 
						 "zip"=> $row['zipcode'],
						 "addressshow"=> $row['addressshow'],
						"url" => $purl,
				 "visit_websiteurl"	=>  ''
						 );
						 
				}
			 }
				
			$api->response($api->json($output,'success',200,1), 200);  
		
			}
		
		}
		}else{
			$message = $result['error_message'];   
			 $api->response($api->json([],$message,500,$status), 500);
		}
	}		
	
}else{
	 $message = 'Post parameter not found';   
	 $api->response($api->json([],$message,$statusCode,$status), $statusCode);
		
}

?>
