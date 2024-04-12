<?php
   
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(E_ALL);	
	include "inc/config.php"; 	
	if($_GET['adminid']==50 && $_GET['mode']=='failure'){
		if(isset($_GET['adminid']) &&  $_GET['adminid']!="") {
			if(isset($_GET["mindate"]) or isset($_GET["maxdate"]))
			{
				if(isset($_GET["mindate"]) and isset($_GET["maxdate"]))
				{
				  $mindate = $_GET["mindate"];	
				  $maxdate = $_GET["maxdate"];
                  $query = 'SELECT * FROM r1_failure where date(created_at) >= "'.$mindate.'" and date(created_at) <= "'.$maxdate.'"';
				}
			}else
			{
			  $query = 'SELECT * FROM r1_failure';	
			}
			
			$mysqlquery = mysqli_query($con,$query);
			$csvdata = array();
			if(mysqli_num_rows($mysqlquery)>0){		
				while ($row = mysqli_fetch_array($mysqlquery)){
					$csvdata[] = array(
						'ID' => $row['id'],
						'business ID' => $row['buss_id'],
						'Location ID' => $row['loc_id'],
						'Child License' => $row['child_license'],
						'Parent License' => $row['parent_license'],
						'Parent Location Name' => $row['parent_location_name'],				
						'Child Location Name' => $row['child_location_name'],				
						'Zipcode' => $row['zipcode'],				
						'city' => $row['city'],				
						'state' => $row['state'],				
						'Status' => $row['status'],				
						'Remark' => $row['remark'],				
						'Created At' => $row['created_at']		
					);
				}
				
				
					$fileName = 'R1failure.csv';
					//Set the Content-Type and Content-Disposition headers.
					header('Content-Type: application/excel');
					header('Content-Type: application/force-download');
					header('Content-Disposition: attachment; filename="' . $fileName . '"');			 
					
					//Open up a PHP output stream using the function fopen.
					$fp = fopen('php://output', 'w');
					fputcsv($fp, array('ID', 'business ID','Location ID','Child License','Parent License','Parent Location Name','Child Location Name','Zipcode','city','state','Status','Remark','Created At'));
					//Loop through the array containing our CSV data.
					foreach ($csvdata as $row) {
						//fputcsv formats the array into a CSV format.
						//It then writes the result to our output stream.
						fputcsv($fp, $row);
					}					 
					//Close the file handle.
					fclose($fp);
					
			}else{
				$fileName = 'R1failure.csv'; 
				//Set the Content-Type and Content-Disposition headers.
				header('Content-Type: application/excel');
				header('Content-Type: application/force-download');
				header('Content-Disposition: attachment; filename="' . $fileName . '"');			 
				
				//Open up a PHP output stream using the function fopen.
				$fp = fopen('php://output', 'w');
				fputcsv($fp, array('ID', 'business ID','Location ID','Child License','Parent License','Child Location Name','Zipcode','city','state','Status','Remark','Created At'));	
				fputcsv($fp, array('','','','No Record Found'));
				//Close the file handle.
				fclose($fp);
				
			}
		}
	
	}else{
		if(isset($_GET['adminid']) &&  $_GET['adminid']!="") {
			$query = 'SELECT * FROM r1_logs';
			$mysqlquery = mysqli_query($con,$query);
			$csvdata = array();
			if(mysqli_num_rows($mysqlquery)>0){		
				while ($row = mysqli_fetch_array($mysqlquery)){
					$csvdata[] = array(
						'ID' => $row['id'],
						'Message' => $row['message'],
						'Created At' => $row['created_at']		
					);
				}
				
				
					$fileName = 'R1logs.csv'; 
					//Set the Content-Type and Content-Disposition headers.
					header('Content-Type: application/excel');
					header('Content-Type: application/force-download');
					header('Content-Disposition: attachment; filename="' . $fileName . '"');			 
					
					//Open up a PHP output stream using the function fopen.
					$fp = fopen('php://output', 'w');
					fputcsv($fp, array('ID', 'Message','Created At'));
					//Loop through the array containing our CSV data.
					foreach ($csvdata as $row) {
						//fputcsv formats the array into a CSV format.
						//It then writes the result to our output stream.
						fputcsv($fp, $row);
					}					 
					//Close the file handle.
					fclose($fp);
					
			}else{
				$fileName = 'R1logs.csv'; 
				//Set the Content-Type and Content-Disposition headers.
				header('Content-Type: application/excel');
				header('Content-Type: application/force-download');
				header('Content-Disposition: attachment; filename="' . $fileName . '"');			 
				
				//Open up a PHP output stream using the function fopen.
				$fp = fopen('php://output', 'w');
				fputcsv($fp, array('ID', 'Message','Created At'));
				fputcsv($fp, array('','No Record Found'));
				//Close the file handle.
				fclose($fp);
				
			}
		}
		
	}
	?>

