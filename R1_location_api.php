<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
include('restApi.php');
include 'phpsqlsearch_dbinfo.php';

$api = new restApi;
if($api->checkAuth()){
	$status = 0;
    $statusCode = 400;
	$data = json_decode(file_get_contents('php://input'), true);
	if(!empty($data['zipscodes'])){	
		$allZipcodes = $data['zipscodes'];
		$childCity = array();
		$previousId = '';
		
		foreach($allZipcodes as $allZipcode){
			$selectpageData = mysqli_query($conn, "SELECT DISTINCT z.city as zCity,m.id,m.name,m.address,m.city,m.state,m.zipcode,m.phone,m.addressshow,r.* from markers m RIGHT JOIN zipcodesnew z on z.loc_id=m.id LEFT JOIN r1_additional_address r on r.loc_id=m.id where m.zipcode =".$allZipcode);
		
			if(!empty($selectpageData) && mysqli_num_rows($selectpageData)>0){
				$city = array();
				while($row = mysqli_fetch_assoc($selectpageData)){
					
						if (substr($row["zipcode"], 0, 1) != '0' && strlen($row["zipcode"])==4) {
							$zipcode = '0'.$row["zipcode"];		      
						}else{
							$zipcode = $row["zipcode"];			 
						}
				
					$eaddressdata = array();	
					if($row['loc_id']!=''){	
						$eaddressdata[] = array(
							'Address'=>(($row['addressshow']==0) ? $row['address'].", " : NULL).$row["city"].", ".$row["state"]." ".$zipcode,
							'Phone'=>$row['phone'],
						);																					
						$eaddress = explode(" &&*&& ", $row['eaddress']);
						$eaddressshow = explode(" &&*&& ", $row['eaddressshow']);
						$ecity = explode(" &&*&& ", $row['ecity']);
						$estate = explode(" &&*&& ", $row['estate']);
						$ezipcode = explode(" &&*&& ", $row['ezipcode']);
						$ephone = (explode(" &&*&& ", $row['ephone']));
						$i=0;
						for($i=0;$i<count($eaddress);$i++){
							
							if (substr($ezipcode[$i], 0, 1) != '0' && strlen($ezipcode[$i])==4) {
							 $zip = '0'.$ezipcode[$i];		      
							}else{
							 $zip = $ezipcode[$i];			 
							}
								$eaddressdata[] = array(
									'Address'=>(($eaddressshow[$i] == 0) ? $eaddress[$i].", " : NULL).$ecity[$i].", ".$estate[$i]." ".$zip,
									'Phone'=>$ephone[$i],
								);		
						}
					}else{
						$eaddressdata[] = array(
								'Address'=>(($row['addressshow']==0) ? $row['address'].", " : NULL).$row["city"].", ".$row["state"]." ".$zipcode,
								'Phone'=>$row['phone'],
							);	
					}
					
					if($previousId !== '' && $previousId !== $row['id']){
						$previousId = $row['id'];																			
					}else{	
						$city[] = ucfirst(strtolower($row['zCity']));			
						$childCity[$zipcode] = array(
							'Name'=>preg_replace('/\t+/', '',$row['name']),
							'Cities'=>$city,
							'Addresses'=>$eaddressdata,
							'Status'=>200,
							'message'=>"success",
						);			
					}
				}
				
			}else{				
				$selectpageDataAgain = mysqli_query($conn, "SELECT m.id,m.name,m.address,m.city,m.state,m.zipcode,m.phone,m.addressshow,r.* from markers m RIGHT JOIN r1_additional_address r on r.loc_id=m.id where m.zipcode =".$allZipcode);
				if(!empty($selectpageDataAgain) && mysqli_num_rows($selectpageDataAgain)>0){
					while($row1 = mysqli_fetch_assoc($selectpageDataAgain)){
						
						if (substr($row1["zipcode"], 0, 1) != '0' && strlen($row1["zipcode"])==4) {
						$zipcode = '0'.$row1["zipcode"];		      
						}else{
							$zipcode = $row1["zipcode"];			 
							}
						$eaddressdata = array();	
						if($row1['loc_id']!=''){	
							
							$eaddressdata[] = array(
								'Address'=>(($row1['addressshow']==0) ? $row1['address'].", " : NULL).$row1["city"].", ".$row1["state"]." ".$zipcode,
								'Phone'=>$row1['phone'],
							);																					
							$eaddress = explode(" &&*&& ", $row1['eaddress']);
							$eaddressshow = explode(" &&*&& ", $row1['eaddressshow']);
							$ecity = explode(" &&*&& ", $row1['ecity']);
							$estate = explode(" &&*&& ", $row1['estate']);
							$ezipcode = explode(" &&*&& ", $row1['ezipcode']);
							$ephone = (explode(" &&*&& ", $row1['ephone']));
							$i=0;
							for($i=0;$i<count($eaddress);$i++){
								if (substr($ezipcode[$i], 0, 1) != '0' && strlen($ezipcode[$i])==4) {
								 $zip = '0'.$ezipcode[$i];		      
								}else{
								 $zip = $ezipcode[$i];			 
								}
									$eaddressdata[] = array(
										'Address'=>(($eaddressshow[$i] == 0) ? $eaddress[$i].", " : NULL).$ecity[$i].", ".$estate[$i]." ".$zip,
										'Phone'=>$ephone[$i],
									);		
							}
						}else{
							$eaddressdata[] = array(
									'Address'=>(($row1['addressshow']==0) ? $row1['address'].", " : NULL).$row1["city"].", ".$row1["state"]." ".$zipcode,
									'Phone'=>$row1['phone'],
								);	
						}
						
						$childCity[$zipcode] = array(
							'Name'=>preg_replace('/\t+/', '',$row1['name']),
							'Cities'=>$row1['city'],
							'Addresses'=>$eaddressdata,
							'Status'=>200,
							'message'=>"success",
						);			
						
					}
					
				}else{
					$childCity[$allZipcode] =array(
						'status'=>404,
						'record'=>'Record not found',
					);
				}
				
				
			}
			
		}		
		$result = $childCity;
		$status = 1;
		$statusCode = 200;
		$message = 'success';
		$api->response($api->json($result,$message,$statusCode,$status), $statusCode); 		
	}else{
        $message = 'Post parameters not found';         
	}	
	$api->response($api->json([],$message,$statusCode,$status), $statusCode);
	
	
	
	
	
	
}



?>
