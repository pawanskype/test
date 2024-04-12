<?php

include('../restApi.php');
include '../phpsqlsearch_dbinfo.php';
function fetch_StateData($state){
	
		$state_slug= str_replace(" ","-", strtolower($state));
	$sql='SELECT term_id FROM `wp_terms` WHERE `name` = "'.$state.'" and slug="'.$state_slug.'"';
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0 ){
	  $row = $result->fetch_row();	
	  $term_id=$row['0'];		//fetch termid based upon state name
	  $postquery="SELECT wp_posts.* FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) WHERE 1=1 AND ( wp_term_relationships.term_taxonomy_id IN (".$term_id.") ) AND wp_posts.post_type = 'location' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled') GROUP BY wp_posts.ID ORDER BY wp_posts.post_title ASC";
	  $post_result = mysqli_query($conn,$postquery);
	  if(mysqli_num_rows($post_result) > 0)
	  {
		  $i=0;
		  //Find All cities data present for this State
		  while($row = mysqli_fetch_assoc($post_result)){
				$post_id=$row['ID'];
				$meta_query="select(select meta_value from wp_postmeta where post_id=".$post_id." and  meta_key='aig_parent_postal_code') as postalcode,(select meta_value from wp_postmeta where post_id=(select meta_value from wp_postmeta where post_id=".$post_id." and  meta_key='aig_parent_landing_page') and meta_key='cmb_home_location_website') as url";
				$meta_result=mysqli_query($conn,$meta_query);
				if(mysqli_num_rows($meta_result) > 0)
				{
					$data=$meta_result->fetch_row();
					$zipdata['zipscodes'][]=$data[0];
					$zipdata['url'][]=$data[1];
					$i++;
					
				}
				
		  }
		$allZipdata=$zipdata;
		require_once("location_api.php");
		//['aig_parent_landing_page']  2927
			$status = 1;
		$statusCode = 200;
		$message = 'success';
		$api->response($api->json($childCity,$message,$statusCode,$status), $statusCode);
	  }else{
		   $message = 'Not any post found';   
		 $api->response($api->json([],$message,$statusCode,$status), $statusCode);
	  }
	}else{
		 $message = 'Result not found';   
		 $api->response($api->json([],$message,$statusCode,$status), $statusCode);
		
	}
}