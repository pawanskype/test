<?php

//find state name based upon slug

function findState_Name($state,$conn){

			$query = "SELECT name FROM `locationstatescode` where code like '%".$state."%' limit 1";
			$stateresult = mysqli_query($conn,$query);
			if(mysqli_num_rows($stateresult)>0){
				 $row = $stateresult->fetch_row();
				return $state=$row['0'];
			}else{
					return '';
			}
}

//for zipcode api find website url
function findZipWebsiteUrl($term_id,$ptitle,$conn){
	$ptitle=trim($ptitle);
	$websiteurl='';
	$postquery="SELECT wp_w7smtofx3h_posts.ID FROM wp_w7smtofx3h_posts LEFT JOIN custom_term_relationships ON (wp_w7smtofx3h_posts.ID = custom_term_relationships.object_id) WHERE 1=1 AND  wp_w7smtofx3h_posts.post_title='".$ptitle."' AND ( custom_term_relationships.term_taxonomy_id IN (".$term_id.") ) AND wp_w7smtofx3h_posts.post_type = 'location' AND (wp_w7smtofx3h_posts.post_status = 'publish' OR wp_w7smtofx3h_posts.post_status = 'acf-disabled') GROUP BY wp_w7smtofx3h_posts.ID,wp_w7smtofx3h_posts.post_title ORDER BY wp_w7smtofx3h_posts.post_title ASC";
	  $post_result = mysqli_query($conn,$postquery);
		  if(mysqli_num_rows($post_result) > 0)
		  {
			  $i=0;
			  //Find All cities data present for this State
			  while($row = mysqli_fetch_assoc($post_result)){
					$post_id=$row['ID'];
				$meta_query="select meta_value  as websiteurl from wp_w7smtofx3h_postmeta where post_id=(select meta_value from wp_w7smtofx3h_postmeta where post_id=".$post_id." and  meta_key='aig_parent_landing_page') and meta_key='cmb_home_location_website'";
					$meta_result=mysqli_query($conn,$meta_query);
					if(mysqli_num_rows($meta_result) > 0)
					{
						$data=$meta_result->fetch_row();
						$websiteurl=$data[0];//fetch visit website url(extrenal link)
					}
			  }
		  }
		  return $websiteurl;
}
//find termId based upon state

function findState_SlugTerm($state,$conn){
		$state_slug= str_replace(" ","-", strtolower($state));
		$sql='SELECT term_id FROM `wp_w7smtofx3h_terms` WHERE `name` = "'.$state.'" and slug="'.$state_slug.'"';
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0 ){
			  $row = $result->fetch_row();
			 return $term_id=$row['0'];		//fetch termid based upon state name
			}else{
					return '';
			}
}
//find page url based upon location name
function get_State_PageUrl($state,$loc_name,$conn,$tbl=''){
	$loc_name=ltrim($loc_name,'');

	if($tbl == '')
	    $tbl = "zipcodesnew";
    // LIKE $loc_name == bluefrog Plumbing + Drain of Columbus
	//get parent id
	$sql='SELECT r1_number_parent FROM '.$tbl.' WHERE `parent_loc_name` LIKE "'.$loc_name.'" and state like "'.$state.'" limit 1 ';
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0 ){
		$row = $result->fetch_row();
		$parent_id=$row['0'];

		if($parent_id != 'INACTIVE'){
			//fetch url based upon parent id
			if($loc_name == "Restoration 1 of Western Wayne County"){
				$postquery="SELECT url FROM `locationsurl` WHERE `parent_id` = ".$parent_id." and location like '%Western Wayne County%'";
			}else{
				if($tbl == "zipcodesnew_bf"){
					if(strpos($loc_name,"bluefrog Plumbing + Drain of ") >= 0){
						$loc_name = str_replace("bluefrog Plumbing + Drain of ","",$loc_name);
					}else{
						$loc_name = str_replace("bf - ","",$loc_name);
					}

					$postquery="SELECT url FROM `locationsurl` WHERE `parent_id` = '".$parent_id."' and location like '".$loc_name."'";


				}elseif($tbl == "zipcodesnew_tdc"){
				     $loc_name = str_replace("The Driveway Company of ","",$loc_name);
				     $postquery= "SELECT url FROM `locationsurl` WHERE `parent_id` = '".$parent_id."' and location like '".$loc_name."'";
				}
				elseif($tbl == "zipcodesnew_sr"){
				        $loc_name = str_replace("The Softroc  of ","",$loc_name);
				    	$postquery="SELECT url FROM `locationsurl` WHERE `parent_id` = '".$parent_id."' and location like '".$loc_name."'";
				}else{  //for restoration
				$postquery="SELECT url FROM `locationsurl` WHERE `parent_id` = ".$parent_id;
				}
			}
			$post_result = mysqli_query($conn,$postquery);
			  if(mysqli_num_rows($post_result) > 0)
			  {
				 if(mysqli_num_rows($post_result)>0 ){

						$row2 = $post_result->fetch_row();
						return $row2[0];

				 }
			  }
		}
	}else{
		//just check in locationurl table
	    if($tbl == "zipcodesnew"){
	    	$loc_name=str_replace("Restoration 1 of ","",$loc_name);
			$url_str="restorat";
		}
	   else if($tbl == "zipcodesnew_bf"){
			if(strpos($loc_name,"bluefrog Plumbing + Drain of ") >= 0){
				$loc_name = str_replace("bluefrog Plumbing + Drain of ","",$loc_name);
			}else{
				$loc_name = str_replace("bf - ","",$loc_name);
			}
			$url_str="bluefrog";
		}elseif($tbl == "zipcodesnew_tdc"){
			$loc_name = str_replace("The Driveway Company of ","",$loc_name);
			$url_str="thedriveway";
		}
		elseif($tbl == "zipcodesnew_sr"){
			$loc_name = str_replace("The Softroc of ","",$loc_name);
			$url_str="Softroc";
		}
		$postquery="SELECT url FROM `locationsurl` WHERE  location like '".$loc_name."' and url like'%".$url_str."%'";
		$post_result = mysqli_query($conn,$postquery);

		  if(mysqli_num_rows($post_result) > 0)
		  {
			 if(mysqli_num_rows($post_result)>0 ){

					$row2 = $post_result->fetch_row();
					return $row2[0];
			 }
		  }

	}
	return "";
}


//find common served area based upon zipcode
function get_commonserved_area($zipcode,$conn , $tbl=""){
	if($tbl == '')
	    $tbl = "zipcodesnew";
    $city = '';
	$selectpageData = mysqli_query($conn, "SELECT DISTINCT z.city as zCity,m.id,m.name,m.address,m.city,m.state,m.zipcode,m.common_served_area,m.phone,m.addressshow,r.* from markers m RIGHT JOIN ".$tbl." z on z.loc_id=m.id LEFT JOIN r1_additional_address r on r.loc_id=m.id where m.zipcode =".$zipcode);

		if(!empty($selectpageData) && mysqli_num_rows($selectpageData)>0){
			$i=0;

				while($row = mysqli_fetch_assoc($selectpageData)){
					if($i == 0){
						$server_city_data=$row['common_served_area'];
						if(!empty($server_city_data))
							$city=explode(',',$server_city_data);
						else
							$city = array();
					}
					$i++;
						$city[] = ucfirst(strtolower($row['zCity']));
				}
		}
		return $city;
}

function findZipCodeCountStatus($resultCount){
			if($resultCount == 2){
						$status="shared";
				}elseif($resultCount > 2){
						$status="unowned";

				}else{
					$status="single";
				}
	return $status;
}

function format_phone($phone)
{
    if(strpos($phone,"(") === false){
	$phone_no1=ltrim($phone,"1");
	$phone_no= "(".substr($phone_no1, 0, 3).") ".substr($phone_no1, 3, 3)."-".substr($phone_no1,6);
		return $phone_no;
    }else
        return $phone;
}


function toTitleCase($str) {
	if(strpos($str,"-")){
    $capstr = explode('-',$str);
    return ucwords($capstr[0]).'-'. ucwords($capstr[1]);
	}else
		 return ucwords(strtolower($str));
}