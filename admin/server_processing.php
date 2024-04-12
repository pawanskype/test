<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
	
	include 'inc/config.php';
	
	if(isset($_POST['licVal']) && $_POST['licVal']!=''){
		$CheckSql = mysqli_query($con, "SELECT id FROM markers WHERE adminid=".$_POST['AID']." AND suite ='".$_POST['licVal']."'");
		if($CheckSql){
			if(mysqli_num_rows($CheckSql)>0){
				
				echo 1;
			}else{
				echo 0;
			}
		}else{
			
			echo 0;
		}
		exit();
	}else if(isset($_POST['licOldVal']) && $_POST['update']==1){
	   //   echo $_POST['AID'].'<br>';
	   //   echo $_POST['licOldVal'].'<br>';
	   //   echo $_POST['lid'].'<br>';
		$CheckSql = mysqli_query($con, "SELECT id FROM markers WHERE adminid=".$_POST['AID']." AND suite ='".$_POST['licOldVal']."' AND id!=".$_POST['lid']);
		if($CheckSql){
			if(mysqli_num_rows($CheckSql)>0){				
				echo 1;
			}else{
				echo 0;
			}
		}else{
			
			echo 0;
		}
		exit();
	}else if(isset($_POST['ClicVal']) && $_POST['ClicVal']!=''){
		if($_POST['AID']==49){
			$brAnd = 2;
		}else{
			$brAnd = 1;
		}
		$CheckSql = mysqli_query($con, "SELECT * FROM r1_parent_license_lookUp WHERE brand=".$brAnd." AND  Child_License =".$_POST['ClicVal']);
		if($CheckSql){
			$name = '';
			$status ='';
			if(mysqli_num_rows($CheckSql)>0){
				while($row = mysqli_fetch_assoc($CheckSql)){					
					$CheckSqlparent = mysqli_query($con, "SELECT * FROM r1_parent_info_lookUp WHERE brand=".$brAnd." AND parent_license =".$row['Parent_Licence']);
					if(mysqli_num_rows($CheckSqlparent)>0){
						while($row1 = mysqli_fetch_assoc($CheckSqlparent)){
							$data = array(
							'response'=>$row1['location_name'],
							'status'=>1
							);
						}
						
					}else{
						$data = array(
							'response'=>'',
							'status'=>1
							);
					}
				}
			}else{
				$data = array(
					'response'=>'',
					'status'=>0
					);
			}
		}else{
			
			$data = array(
								'response'=>'',
								'status'=>0
								);
		}
		echo json_encode($data);
		exit();
		
		
	}
	
	
	
	
	$role = $_SESSION['data']['role'];
	$userid = 51;
	$start = $_GET['start'];
	$end = $_GET['length'];
	$searchvalue = $_GET['search']['value'];
	$resultcount = mysqli_query($con, "SELECT id FROM markers3 WHERE adminid = $userid");
	$rowcount=mysqli_num_rows($resultcount);
	if($searchvalue==''){
		$response =array('draw'=>$_GET['draw'],'recordsTotal'=>$rowcount,'recordsFiltered'=>$rowcount);
		$query = mysqli_query($con, "SELECT * FROM markers3 WHERE adminid = $userid LIMIT $start, $end");	
	}else{
		$resultcountfilter = mysqli_query($con, "SELECT id FROM markers3 WHERE adminid = $userid AND (name LIKE '%".$searchvalue."%' OR city LIKE '%".$searchvalue."%' OR zipcode LIKE '%".$searchvalue."%')");
		$rowcountfilter=mysqli_num_rows($resultcountfilter);
		$response =array('draw'=>$_GET['draw'],'recordsTotal'=>$rowcount,'recordsFiltered'=>$rowcountfilter);
		$query = mysqli_query($con, "SELECT * FROM markers3 WHERE adminid = $userid AND (name LIKE '%".$searchvalue."%' OR city LIKE '%".$searchvalue."%' OR zipcode LIKE '%".$searchvalue."%') LIMIT $start, $end");	
		
	}	
	while($row = mysqli_fetch_assoc($query)){
		$check = '<div class="checkbox"><label><input type="checkbox" class="checkbox" name="checkb[]" value="'.$row['id'].'"></label></div>';
		if($role == "superadmin") {
			$edit = '<td><a href="locationsedit?adminid='.$userid.'&locationid='.$row['id'].'"><span class="icon-edit"><i class="fa fa-edit"></i></span></a></td>';	
		}else{
			$edit = '';
		}
		if (strpos($row['phone'], '-') !== false) {
			$phone = $row['phone'];
		}else{
		   $phone =  "(".substr($row['phone'], 0, 3).") ".substr($row['phone'], 3, 3)."-".substr($row['phone'],6); 
		}
		$response['data'][] = array($check,$row['id'],$row['name'],$row['suite'],$row['city'],$row['zipcode'],$row['state'],$phone,$edit);
		
	}
	echo json_encode($response);
	exit;
	
?>
