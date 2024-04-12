<?php
	include "phpsqlsearch_dbinfo.php";
        //	include "variables.php";
        $adminId=15;
        //$pageId="minneapolis";  
  $pageId=!empty($_GET['locationid']) ? $_GET['locationid'] : "" ;
        $selectpageData = mysqli_query($conn, "SELECT * FROM markers WHERE slug = '".$pageId."' && adminid='".$adminId."'");
	$pageData = mysqli_fetch_assoc($selectpageData);

	$name = $pageData['name'];
	$address = $pageData['address'];
	$suite = $pageData['suite'];
	$city = $pageData['city'];
	$state = $pageData['state'];
	$phone = $pageData['phone'];
	$zipcode = $pageData['zipcode'];

                
        $globaloptions = mysqli_query($conn, "SELECT * FROM globaloptions WHERE adminid='".$adminId."'");
        $fetch = mysqli_fetch_assoc($globaloptions);
                 if(!empty($fetch['title_tags']) && $fetch['title_tags_override']=='on')
            {
                $title= $fetch['title_tags']; //custom title tags                
            }else{    
                      if (strpos($phone, '-') !== false) {
                            $title= $name.' '.$city.' '.$state.', '.$zipcode.' | '.''.$phone;
                       }else{
                           $title= $name.' '.$city.' '.$state.', '.$zipcode.' | '.''."(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);
                       }
                  }
                  echo json_encode(array(
                      'title'=>$title
                  ));
      
?>