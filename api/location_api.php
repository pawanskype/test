<?php
//To fetch location api (similar code is used in aig-location-listing plugin )

$childCity = array();
$childCity['searchedterm'] = "state";
$childCity['type'] = findZipCodeCountStatus($post_counteR);

$previousId = '';

$allZipcodes = $allZipdata['zipscodes'];
$loop = 0;

foreach ($allZipcodes as $allZipcode) {
	$pageurl = $allZipdata['url'][$loop];



	$selectpageData = mysqli_query($conn, "SELECT DISTINCT z.city as zCity,m.id,m.name,m.address,m.city,m.state,m.zipcode,m.common_served_area,m.phone,m.addressshow,r.* from markers m RIGHT JOIN " . $zipcode_tbl . " z on z.loc_id=m.id LEFT JOIN r1_additional_address r on r.loc_id=m.id where m.zipcode =" . $allZipcode . " AND   m.adminid=$adminid order by zCity asc");
	//echo "SELECT DISTINCT z.city as zCity,m.id,m.name,m.address,m.city,m.state,m.zipcode,m.common_served_area,m.phone,m.addressshow,r.* from markers m RIGHT JOIN " . $zipcode_tbl . " z on z.loc_id=m.id LEFT JOIN r1_additional_address r on r.loc_id=m.id where m.zipcode =" . $allZipcode . " AND   m.adminid=$adminid order by zCity asc"; echo '<br>';

	//    print_r($selectpageData);
	//    die();

	if (!empty($selectpageData) && mysqli_num_rows($selectpageData) > 0) {
		//$city1=array('East Cobb','Sandy Springs','Vinings','Dunwoody','Buckhead','Brookhaven','Midtown');
		$city = array();		
		$i = 0;
		while ($row = mysqli_fetch_assoc($selectpageData)) {
			 
			if ($i == 0) {
				$server_city_data = $row['common_served_area'];
				if (!empty($server_city_data))
					$city = explode(',', $server_city_data);
			}
			$i++;
			if (substr($row["zipcode"], 0, 1) != '0' && strlen($row["zipcode"]) == 4) {
				$zipcode = '0' . $row["zipcode"];
			} else {
				$zipcode = $row["zipcode"];
			}

			$eaddressdata = array();

			$phone_no = format_phone($row['phone']);

			if ($row['loc_id'] != '') {
				$eaddressdata[] = array(
					'Address' => (($row['addressshow'] == 0) ? $row['address'] . ", " : NULL) . $row["city"] . ", " . $row["state"] . " " . $zipcode,
					'Phone' => $phone_no,
				);
				$eaddress = explode(" &&*&& ", $row['eaddress']);
				$eaddressshow = explode(" &&*&& ", $row['eaddressshow']);
				$ecity = explode(" &&*&& ", $row['ecity']);
				$estate = explode(" &&*&& ", $row['estate']);
				$ezipcode = explode(" &&*&& ", $row['ezipcode']);
				$ephone = (explode(" &&*&& ", $row['ephone']));
				$i = 0;
				for ($i = 0; $i < count($eaddress); $i++) {

					if (substr($ezipcode[$i], 0, 1) != '0' && strlen($ezipcode[$i]) == 4) {
						$zip = '0' . $ezipcode[$i];
					} else {
						$zip = $ezipcode[$i];
					}
					$phone_no = format_phone($ephone[$i]);

					$eaddressdata[] = array(
						'Address' => (($eaddressshow[$i] == 0) ? $eaddress[$i] . ", " : NULL) . $ecity[$i] . ", " . $estate[$i] . " " . $zip,
						'Phone' => $phone_no,
					);
				}
			} else {
				$eaddressdata[] = array(
					'Address' => (($row['addressshow'] == 0) ? $row['address'] . ", " : NULL) . $row["city"] . ", " . $row["state"] . " " . $zipcode,
					'Phone' => $phone_no,
				);
			}

			if ($previousId !== '' && $previousId !== $row['id']) {
				$previousId = $row['id'];
			} else {

				if ($row['name'] == "bluefrog Plumbing + Drain of Denver") {
					$city = array("Aurora", " Arvada", " Denver", " Englewood", " Golden", " Lafayette", " Littleton", " Lone tree", " Louisville", "Thornton", " Westminster", " Wheat ridge");
				} else {
					$city[] = toTitleCase($row['zCity']);
				}
				$purl = get_State_PageUrl($row['state'], $row['name'], $conn, $zipcode_tbl);
			 
				$childCity[$zipcode] = array(
					'Name' => preg_replace('/\t+/', '', $row['name']),
					'Cities' => $city,
					'Addresses' => $eaddressdata,
					'url'  => $purl,
					'visit_websiteurl'  => $pageurl,
					'test'=>'true'
				);
				 
			}
		}
		
	} else {
	 
		$selectpageDataAgain = mysqli_query($conn, "SELECT m.id,m.name,m.address,m.city,m.common_served_area,m.state,m.zipcode,m.phone,m.addressshow,r.* from markers m LEFT JOIN r1_additional_address r on r.loc_id=m.id where m.zipcode =" . $allZipcode . " AND m.adminid=$adminid order by city asc ");
		$city = array();
		if (!empty($selectpageDataAgain) && mysqli_num_rows($selectpageDataAgain) > 0) {

			while ($row1 = mysqli_fetch_assoc($selectpageDataAgain)) {
				
				//	print_r($row1);
				//	die();
				if ($i == 0) {
					$server_city_data = $row1['common_served_area'];
					if (!empty($server_city_data))
						$city = explode(',', $server_city_data);
				}
				$i++;

				if (substr($row1["zipcode"], 0, 1) != '0' && strlen($row1["zipcode"]) == 4) {
					$zipcode = '0' . $row1["zipcode"];
				} else {
					$zipcode = $row1["zipcode"];
				}
				$eaddressdata = array();
				if ($row1['loc_id'] != '') {
					$phone = format_phone($row1['phone']);
					$eaddressdata[] = array(
						'Address' => (($row1['addressshow'] == 0) ? $row1['address'] . ", " : NULL) . $row1["city"] . ", " . $row1["state"] . " " . $zipcode,
						'Phone' => $phone,
					);
					$eaddress = explode(" &&*&& ", $row1['eaddress']);
					$eaddressshow = explode(" &&*&& ", $row1['eaddressshow']);
					$ecity = explode(" &&*&& ", $row1['ecity']);
					$estate = explode(" &&*&& ", $row1['estate']);
					$ezipcode = explode(" &&*&& ", $row1['ezipcode']);
					$ephone = (explode(" &&*&& ", $row1['ephone']));
					$i = 0;
					for ($i = 0; $i < count($eaddress); $i++) {
						if (substr($ezipcode[$i], 0, 1) != '0' && strlen($ezipcode[$i]) == 4) {
							$zip = '0' . $ezipcode[$i];
						} else {
							$zip = $ezipcode[$i];
						}
						$eaddressdata[] = array(
							'Address' => (($eaddressshow[$i] == 0) ? $eaddress[$i] . ", " : NULL) . $ecity[$i] . ", " . $estate[$i] . " " . $zip,
							'Phone' => format_phone($ephone[$i]),
						);
					}
				} else {
					$eaddressdata[] = array(
						'Address' => (($row1['addressshow'] == 0) ? $row1['address'] . ", " : NULL) . $row1["city"] . ", " . $row1["state"] . " " . $zipcode,
						'Phone' => format_phone($row1['phone']),
					);
				}
				
				$purl = get_State_PageUrl($row1['state'], $row1['name'], $conn, $zipcode_tbl);
				 
				$childCity[$zipcode] = array(
					'Name' => preg_replace('/\t+/', '', $row1['name']),
					'Cities' => $city,
					'Addresses' => $eaddressdata,
					'url'  => $purl,
					'visit_websiteurl'  => $pageurl,					
					
				);
				 
			}
		} else {
			$childCity[$allZipcode] = array(
				'status' => 404,
				'record' => 'Record not found',
			);
		}
	}
	$loop++;
}
