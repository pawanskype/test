<?php
//API used to fetch ZIpcode by Name in TDC and bluefrog site page form rollup page to fetch sendgrid data to their respective db(Name is Not setup for BF)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('../restApi.php');
include '../phpsqlsearch_dbinfo.php';

$api = new restApi;
	$status = 0;
    $statusCode = 400;
if(!empty($_REQUEST['name']) ){
	$childCity = array();
		$name_parameter = $_REQUEST['name'];
		$adminid = $_REQUEST['adminid'];
		$pageData = mysqli_query($conn, "select zipcode from markers where name like '%".$name_parameter."%' and adminid=".$adminid);
		if(!empty($pageData) && mysqli_num_rows($pageData)>0){
		while($row_data = mysqli_fetch_row($pageData) ){
			 $zipcode =  $row_data[0];
		}
			$result =  array(
				"zipcode" => $zipcode
			);
			$status = 1;
			$message = 'success';
			$statusCode = 200;
		}
		else{
			$message="failure";
			$statusCode = 404;
			$result = array(
				'record'=>'Record not found',
			);
		}
		$api->response($api->json($result,$message,$statusCode,$status), $statusCode);
	}else{
        $message = 'Post parameters not found';
	}
	$api->response($api->json([],$message,$statusCode,$status), $statusCode);





?>
