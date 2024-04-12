<?php  

session_start();
require("phpsqlsearch_dbinfo.php");
require("common_locurl.php");
// Get parameters from URL
	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);
//Check for State code

	$adminid = $_GET['adminid'];
	$center_lat = $_GET["lat"];
	$center_lng = $_GET["lng"];
	$radius = $_GET["radius"];
	$edata = $_GET["edata"];
	// Start XML file, create parent node

	// Search the rows in the markers table
	if (is_numeric($edata)) {		
		// if (substr($edata, 0, 1) === '0') {	
		// 	$edata = ltrim($edata, '0');
		// }
		
		$query = sprintf("SELECT z.id as ID,z.zip_name,z.zipcode as newzip,z.city,z.state,z.country,z.lat newlat,z.lng newlng,m.address,m.phone, m.id, m.adminid, m.slug, m.name,m.zipcode,m.addressshow FROM markers m INNER JOIN zipcodesnew z on m.id=z.loc_id  WHERE m.adminid='$adminid' and FIND_IN_SET('$edata',z.zipcode) > 0",
		mysqli_real_escape_string($conn,$center_lat),
		mysqli_real_escape_string($conn,$center_lng),
		mysqli_real_escape_string($conn,$center_lat),
		mysqli_real_escape_string($conn,$radius));
	   
	  $result = mysqli_query($conn,$query);	  
	  if(mysqli_num_rows($result)>0 ){
		  if (!$result) {
			  die("Invalid query: " . mysqli_error());
			}
			header("Content-type: text/xml");
			// Iterate through the rows, adding XML nodes for each
			while ($row = @mysqli_fetch_assoc($result)){
				
			 if($row['newlat']=='' && $row['newlng']==''){
					 $fulladdress = $row['city'].','.$row['state'].','.$row['country'];
					$coordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($fulladdress) . '&sensor=true&key=AIzaSyBF4FGtqxS5RUDRYickC3b9sQ5fyj-JFbc');
					 $coordinates = json_decode($coordinates); 
					$lat = $coordinates->results[0]->geometry->location->lat;
					$lng = $coordinates->results[0]->geometry->location->lng;
				  mysqli_query($conn,"UPDATE zipcodesnew SET lat='".$lat."',lng='".$lng."' WHERE id='".$row['ID']."'");
			  }else{				  
				  $lat = $row['newlat'];
				  $lng = $row['newlng'];
			   }
			
				$phone=trim($row['phone']);
                   
				if(strpos($phone, '-') !== false)
				{
					$phone_no= ltrim($phone,"1");
				}else{
						$phone_no1=ltrim($phone,"1");
				   $phone_no= "(".substr($phone_no1, 0, 3).") ".substr($phone_no1, 3, 3)."-".substr($phone_no1,6);
			   
				}
               
			  $node = $dom->createElement("marker");
			  $newnode = $parnode->appendChild($node);
			  if(mysqli_num_rows($result) > 1)
			  	$newnode->setAttribute("zipnewId", $row['ID']);
			  $newnode->setAttribute("id", $row['id']);
			  $newnode->setAttribute("adminid", $row['adminid']);
			  $newnode->setAttribute("slug", $row['slug']);
			//  $newnode->setAttribute("name", 'Restoration 1 Serving '.ucwords(strtolower($row['city'])).' '.$row['state']);
			  $row_name=$row['name'];			 
			  $newnode->setAttribute("name", $row_name);
			  $newnode->setAttribute("address", $row['address']);
			  $newnode->setAttribute("city", $row['city']);
			  $newnode->setAttribute("state", $row['state']);
			  $newnode->setAttribute("phone",$phone_no);
			  $newnode->setAttribute("lat",$lat);
			  $newnode->setAttribute("lng", $lng);
			  $newnode->setAttribute("distance",0);
			  if (substr($edata, 0, 1) != '0' && strlen($edata)==4) {	
					$edata = '0'.$edata;
				}else if (substr($edata, 0, 1) != '0' && strlen($edata)==3){
					$edata = '00'.$edata;
				}
			  $newnode->setAttribute("zip", $edata);
			  $newnode->setAttribute("addressshow", $row['addressshow']);
			    //find page url
			  $purl=get_State_PageUrl($row['state'],$row_name, $conn);
			  $newnode->setAttribute("pageurl", $purl);
			}
			 echo $dom->saveXML();
		 }else{
			 $query = sprintf("SELECT address, city, state, phone, id, adminid, slug, name,zipcode,addressshow, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' AND zipcode='$edata' HAVING distance < %s ORDER BY distance",
			 mysqli_real_escape_string($conn,$center_lat),
			 mysqli_real_escape_string($conn,$center_lng),
			 mysqli_real_escape_string($conn,$center_lat),
			 mysqli_real_escape_string($conn,$radius));
			 
			  $result =mysqli_query($conn,$query);
			 if(mysqli_num_rows($result)>0 ){
					 if (!$result) {
						  die("Invalid query: " .mysqli_error());
						}
				header("Content-type: text/xml");
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

				  $node = $dom->createElement("marker");
				  $newnode = $parnode->appendChild($node);
				  $newnode->setAttribute("id", $row['id']);
				  $newnode->setAttribute("adminid", $row['adminid']);
				  $newnode->setAttribute("slug", $row['slug']); 
				  $row_name=$row['name'];			 
				  $newnode->setAttribute("name", $row_name);
				  $newnode->setAttribute("address", $row['address']);
				  $newnode->setAttribute("city", $row['city']);
				  $newnode->setAttribute("state", $row['state']);
				  $newnode->setAttribute("phone",$phone_no);
				  $newnode->setAttribute("lat", $row['lat']);
				  $newnode->setAttribute("lng", $row['lng']);
				  $newnode->setAttribute("distance", $row['distance']);
				  $newnode->setAttribute("zip", $row['zipcode']);
				  $newnode->setAttribute("addressshow", $row['addressshow']);
				    //find page url
			  $purl=get_State_PageUrl($row['state'],$row_name, $conn);
			  $newnode->setAttribute("pageurl", $purl);
				}
				 echo $dom->saveXML();  
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
				header("Content-type: text/xml");
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

				  $node = $dom->createElement("marker");
				  $newnode = $parnode->appendChild($node);
				  $newnode->setAttribute("id", $row['id']);
				  $newnode->setAttribute("adminid", $row['adminid']);
				  $newnode->setAttribute("slug", $row['slug']);
				    $row_name=$row['name'];			 
				  $newnode->setAttribute("name", $row_name);
				  $newnode->setAttribute("address", $row['address']);
				  $newnode->setAttribute("city", $row['city']);
				  $newnode->setAttribute("state", $row['state']);
				  $newnode->setAttribute("phone",$phone_no);
				  $newnode->setAttribute("lat", $row['lat']);
				  $newnode->setAttribute("lng", $row['lng']);
				  $newnode->setAttribute("distance", $row['distance']);
				  $newnode->setAttribute("zip", $row['zipcode']);
				  $newnode->setAttribute("addressshow", $row['addressshow']);
				    //find page url
			  $purl=get_State_PageUrl($row['state'],$row_name, $conn);
			  $newnode->setAttribute("pageurl", $purl);
				}
				 echo $dom->saveXML();  
			 }
				  
			 
			 
			}
		  
	}else{		  
		 $aKeyword = explode(",", $edata);
		 $query = "SELECT z.id as ID,z.zip_name,z.zipcode as newzip,z.city,z.state,z.country,z.lat newlat,z.lng newlng,m.address,m.phone, m.id, m.adminid, m.slug, m.name,m.zipcode,m.addressshow FROM markers m INNER JOIN zipcodesnew z on m.id=z.loc_id  WHERE m.adminid='$adminid' and z.city LIKE '%".$aKeyword[0]."%'";
			if($aKeyword[1]!=''){
				$query .= " OR z.state like '%" . $aKeyword[1] . "%'";
			}		  
		$query .=   " ORDER BY CASE WHEN z.city LIKE '%".$aKeyword[0]."%' THEN 1 ELSE 2 END LIMIT 0 , 10";
			$result =mysqli_query($conn,$query);
		if(mysqli_num_rows($result)>0 ){
			if (!$result) {
			  die("Invalid query: " .mysqli_error());
			}
			header("Content-type: text/xml");
			// Iterate through the rows, adding XML nodes for each
			while ($row = @mysqli_fetch_assoc($result)){
				
			 if($row['newlat']=='' && $row['newlng']==''){
					 $fulladdress = $row['city'].','.$row['state'].','.$row['country'];
					$coordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($fulladdress) . '&sensor=true&key=AIzaSyBF4FGtqxS5RUDRYickC3b9sQ5fyj-JFbc');
					 $coordinates = json_decode($coordinates); 
					$lat = $coordinates->results[0]->geometry->location->lat;
					$lng = $coordinates->results[0]->geometry->location->lng;
				  mysqli_query($conn,"UPDATE zipcodesnew SET lat='".$lat."',lng='".$lng."' WHERE id='".$row['ID']."'");
			  }else{				  
				  $lat = $row['newlat'];
				  $lng = $row['newlng'];
			   }
			
				$phone=trim($row['phone']);

				if(strpos($phone, '-') !== false)
				{
					$phone_no= ltrim($phone,"1");
				}else{
						$phone_no1=ltrim($phone,"1");
				   $phone_no= "(".substr($phone_no1, 0, 3).") ".substr($phone_no1, 3, 3)."-".substr($phone_no1,6);
			   
				}

			  $node = $dom->createElement("marker");
			  $newnode = $parnode->appendChild($node);
			  $newnode->setAttribute("id", $row['id']);
			  $newnode->setAttribute("adminid", $row['adminid']);
			  $newnode->setAttribute("slug", $row['slug']);
			  $row_name=$row['name'];			 
			  $newnode->setAttribute("name", $row_name);
			  $newnode->setAttribute("address", $row['address']);
			  $newnode->setAttribute("city", $row['city']);
			  $newnode->setAttribute("state", $row['state']);
			  $newnode->setAttribute("phone",$phone_no);
			  $newnode->setAttribute("lat",$lat);
			  $newnode->setAttribute("lng", $lng);
			  $newnode->setAttribute("distance",0);
			  if (substr($row['newzip'], 0, 1) != '0' && strlen($row['newzip'])==4) {	
					$edata = '0'.$row['newzip'];
				}else if (substr($edata, 0, 1) != '0' && strlen($row['newzip'])==3){
					$edata = '00'.$row['newzip'];
				}
			  $newnode->setAttribute("zip", $row['newzip']);
			  $newnode->setAttribute("addressshow", $row['addressshow']);
			    //find page url
			  $purl=get_State_PageUrl($row['state'],$row_name, $conn);
			  $newnode->setAttribute("pageurl", $purl);
			}
			 echo $dom->saveXML();
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
			header("Content-type: text/xml");
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

			  $node = $dom->createElement("marker");
			  $newnode = $parnode->appendChild($node);
			  $newnode->setAttribute("id", $row['id']);
			  $newnode->setAttribute("adminid", $row['adminid']);
			  $newnode->setAttribute("slug", $row['slug']);
			  $row_name=$row['name'];			 
			  $newnode->setAttribute("name", $row_name);
			  $newnode->setAttribute("address", $row['address']);
			  $newnode->setAttribute("city", $row['city']);
			  $newnode->setAttribute("state", $row['state']);
			  $newnode->setAttribute("phone",$phone_no);
			  $newnode->setAttribute("lat", $row['lat']);
			  $newnode->setAttribute("lng", $row['lng']);
			  $newnode->setAttribute("distance", $row['distance']);
			  $newnode->setAttribute("zip", $row['zipcode']);
			  $newnode->setAttribute("addressshow", $row['addressshow']);
			    //find page url
			  $purl=get_State_PageUrl($row['state'],$row_name, $conn);
			  $newnode->setAttribute("pageurl", $purl);
			}
			 echo $dom->saveXML();
			
		}
	}	  


	
?>
