<?php  
session_start();
require("phpsqlsearch_dbinfo.php");
// Get parameters from URL
$adminid = $_GET['adminid'];
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];
$edata = $_GET["edata"];
// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
// Opens a connection to a mySQL server
$connection=mysql_connect ($hostname, $username, $password);
if (!$connection) {
  die("Not connected : " . mysql_error());
}
// Set the active mySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ("Can\'t use db : " . mysql_error());
}

	// Search the rows in the markers table
	if (is_numeric($edata) && $adminid=='50') {
		$query = sprintf("SELECT address, city, state, phone, id, adminid, slug, name,zipcode,addressshow, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' and zipcode='$edata'  HAVING distance < %s ORDER BY distance LIMIT 0 , 10",
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($center_lng),
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($radius));
	}else{
		$query = sprintf("SELECT address, city, state, phone, id, adminid, slug, name,zipcode,addressshow, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' HAVING distance < %s ORDER BY distance LIMIT 0 , 10",
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($center_lng),
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($radius));
	}

$result = mysql_query($query);

if(mysql_num_rows($result)<=0 && $adminid=='50'){	
	$query = sprintf("SELECT z.zip_name,z.zipcode as newzip,m.address, m.city, m.state, m.phone, m.id, m.adminid, m.slug, m.name,m.zipcode,m.addressshow, m.lat, m.lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( m.lat ) ) * cos( radians( m.lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( m.lat ) ) ) ) AS distance FROM markers m INNER JOIN zipcodes z on m.adminid=z.buss_id  WHERE m.adminid='$adminid' and z.zipcode='$edata' HAVING distance < %s  ORDER BY distance LIMIT 0 , 1",
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($center_lng),
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($radius));	  
	  $result = mysql_query($query);		
	  
	if(mysql_num_rows($result)<=0 ){	  
	 $query = sprintf("SELECT address, city, state, phone, id, adminid, slug, name,zipcode,addressshow, lat, lng, ( 6371 * acos( cos( radians('%s') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('%s') ) + sin( radians('%s') ) * sin( radians( lat ) ) ) ) AS distance FROM markers WHERE adminid='$adminid' HAVING distance < %s ORDER BY distance LIMIT 0 , 10",
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($center_lng),
	  mysql_real_escape_string($center_lat),
	  mysql_real_escape_string($radius));
	   $result = mysql_query($query);
			if (!$result) {
			  die("Invalid query: " . mysql_error());
			}
			header("Content-type: text/xml");
			// Iterate through the rows, adding XML nodes for each
			while ($row = @mysql_fetch_assoc($result)){
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
			  $newnode->setAttribute("name", $row['name']);
			  $newnode->setAttribute("address", $row['address']);
			  $newnode->setAttribute("city", $row['city']);
			  $newnode->setAttribute("state", $row['state']);
			  $newnode->setAttribute("phone",$phone_no);
			  $newnode->setAttribute("lat", $row['lat']);
			  $newnode->setAttribute("lng", $row['lng']);
			  $newnode->setAttribute("distance", $row['distance']);
			  $newnode->setAttribute("zip", $row['zipcode']);
			  $newnode->setAttribute("addressshow", $row['addressshow']);
			}
			 echo $dom->saveXML();
	}else{
		  if (!$result) {
			  die("Invalid query: " . mysql_error());
			}
			header("Content-type: text/xml");
			// Iterate through the rows, adding XML nodes for each
			while ($row = @mysql_fetch_assoc($result)){
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
			  $newnode->setAttribute("name", $row['zip_name']);
			  $newnode->setAttribute("address", $row['address']);
			  $newnode->setAttribute("city", $row['city']);
			  $newnode->setAttribute("state", $row['state']);
			  $newnode->setAttribute("phone",$phone_no);
			  $newnode->setAttribute("lat", $row['lat']);
			  $newnode->setAttribute("lng", $row['lng']);
			  $newnode->setAttribute("distance", $row['distance']);
			  $newnode->setAttribute("zip", $row['newzip']);
			  $newnode->setAttribute("addressshow", $row['addressshow']);
			}
			 echo $dom->saveXML();	  
	  }
}else{

		if (!$result) {
		  die("Invalid query: " . mysql_error());
		}
		header("Content-type: text/xml");
		// Iterate through the rows, adding XML nodes for each
		while ($row = @mysql_fetch_assoc($result)){
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
		  $newnode->setAttribute("name", $row['name']);
		  $newnode->setAttribute("address", $row['address']);
		  $newnode->setAttribute("city", $row['city']);
		  $newnode->setAttribute("state", $row['state']);
		  $newnode->setAttribute("phone",$phone_no);
		  $newnode->setAttribute("lat", $row['lat']);
		  $newnode->setAttribute("lng", $row['lng']);
		  $newnode->setAttribute("distance", $row['distance']);
		  $newnode->setAttribute("zip", $row['zipcode']);
		  $newnode->setAttribute("addressshow", $row['addressshow']);
		}
		echo $dom->saveXML();
}
?>
