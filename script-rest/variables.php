<?php
//print_r($_GET);
/*echo "<pre>";
print_r($_GET);
echo "</pre>pre>";
die;*/

	$adminurl = "/store-locator/admin";
	$scripturl = "/store-locator/script-rest";
	
	$fileurl = $_GET['slug'];
	$slugurl = explode("?", $fileurl);

         $slug = isset($slugurl[1]) ? $slugurl[1]  : "";
		 $slug2 = isset($slugurl[2]) ? $slugurl[2] : "";
		 /******Exploding with URI******/
		  			
		if(empty($slug)){
			$fileurlNEW = trim($_GET['slug'],"/");
			$fileURLasArray = explode("/", $fileurlNEW);
		
			if(end($fileURLasArray) == "detail"){
				$slug2 = array_pop($fileURLasArray);
			}
			$zipcode_newId='';
				//this is case for zipcodenew id where multiple records come for zipcode
			if((count($fileURLasArray) == 4) && ($fileURLasArray[3] != "thank-you")){
				 	$zipcode_newId=$fileURLasArray[3];
					$slug=$fileURLasArray[2];
			}else{		
					$slug = array_pop($fileURLasArray);
			}		
			if(strpos("_".$slug,"index.php")>0 || strpos("_".$slug,"location")>0 ){
				$slug = "";
			}
		}
		
		 /************/
	 	 $pageId = $slug;
	   
	// $pageId = str_replace("address=", "", $slug);
	
	 $adminId = $_GET['adminid'];
	 
	//For New script for reviews
	$customreview_star='';
	$custom_featurereview='';
	$custom_reviewscript='';


	$currentPage = basename($_SERVER['PHP_SELF']);
        
        $fetch_alllocations = mysqli_query($conn, "SELECT slug FROM markers WHERE adminid='".$adminId."'");
      	while($servicelocation = mysqli_fetch_assoc($fetch_alllocations)) {
            //print_r($servicelocation);
		$servicelocations_array[] = $servicelocation['slug'];
	}
  
	$fetch_color = mysqli_query($conn, "SELECT * FROM settings WHERE adminid='".$adminId."'");
	$color_result = mysqli_fetch_assoc($fetch_color);
	
	$backgroundcolor = $color_result['backgroundcolor'];
	$locationbackgroundcolor = $color_result['locationbackgroundcolor'];
	$themecolor = $color_result['themecolor'];
	$themehovercolor = $color_result['themehovercolor'];
	$formcolor = $color_result['formcolor'];
	$buttonbackground = $color_result['buttonbackground'];
	$buttontextcolor = $color_result['buttontextcolor'];
	$buttonhovercolor = $color_result['buttonhovercolor'];
	
	$holiday = mysqli_query($conn, "SELECT * FROM businessholidays WHERE adminid='$adminId'");
	$holidate=[];
	while($holiday_arry = mysqli_fetch_assoc($holiday)) { 
		$holidate[] = $holiday_arry['holiday_date'];
	}
	for($i=0; $i < 7; $i++) {
		$currentweekarray[] = date('Y-m-d', strtotime('last sunday + '.$i.' day'));
	}
	$weekholidays = array_intersect($holidate, $currentweekarray);
	$weekholidaysarray=[];
	foreach($weekholidays as $holidayvalue) {
		$weekholidaysarray[] = date("l", strtotime($holidayvalue));
	}
	
		// if (substr($pageId, 0, 1) === '0') {	
		// 	$pageId = ltrim($pageId, '0');
		// }		
				
		 $checkowned = mysqli_query($conn, "SELECT id FROM zipcodesnew WHERE FIND_IN_SET('$pageId',zipcode) > 0 and buss_id='".$adminId."'");
		 $count = mysqli_num_rows($checkowned);	
		
		 if($count!=0){
			  if($zipcode_newId != ''):
					$sqlQuery="SELECT z.id as ID,z.zip_name as newname,z.zipcode as newzip,z.city as newcity,z.state as newstate,z.country as newcountry,z.lat newlat,z.lng newlng,z.page_content as pageContent,m.* FROM markers m INNER JOIN zipcodesnew z on m.id=z.loc_id  WHERE m.adminid='$adminId' and z.id='$zipcode_newId' and FIND_IN_SET('$pageId',z.zipcode) > 0";
			  else:
		
					$sqlQuery="SELECT z.id as ID,z.zip_name as newname,z.zipcode as newzip,z.city as newcity,z.state as newstate,z.country as newcountry,z.lat newlat,z.lng newlng,z.page_content as pageContent,m.* FROM markers m INNER JOIN zipcodesnew z on m.id=z.loc_id  WHERE m.adminid='$adminId' and FIND_IN_SET('$pageId',z.zipcode) > 0";
			  endif;
			
			  $selectpageData = mysqli_query($conn, $sqlQuery);
			  $pageData = mysqli_fetch_assoc($selectpageData);
			 
				$locationId = $pageData['id'];
				//$name = 'Restoration 1 Serving '.ucwords(strtolower($pageData['newcity'])).' '.$pageData['newstate'];
				$name=$pageData['name'];
				$city = $pageData['newcity'];
				$state = $pageData['newstate'];
				$parentname = $pageData['name'];
			//	$title = 'Fire & Water Damage Restoration Service '.ucwords(strtolower($pageData['newcity'])).' '.$pageData['newstate'].' | '.$pageData['name'];
				$title = 'Fire & Water Damage Restoration Service'.' | '.$pageData['name'];
				
			  
			  if($pageData['newlat']=='' && $pageData['newlng']==''){
				 $fulladdress = $pageData['newcity'].','.$pageData['newstate'].','.$pageData['newcountry'];
				$coordinates = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($fulladdress) . '&sensor=true&key=AIzaSyBF4FGtqxS5RUDRYickC3b9sQ5fyj-JFbc');
				 $coordinates = json_decode($coordinates); 
				  $lat = $coordinates->results[0]->geometry->location->lat;
				  $lng = $coordinates->results[0]->geometry->location->lng;
				  mysqli_query($conn,"UPDATE zipcodesnew SET lat='".$lat."',lng='".$lng."' WHERE id='".$pageData['ID']."'");
			  }else{				  
				  $lat = $pageData['newlat'];
				  $lng = $pageData['newlng'];
			   }
			   
			  if (substr($pageId, 0, 1) != '0' && strlen($pageId)==4) {	
					$zipcode = '0'.$pageId;
		      }else if (substr($pageId, 0, 1) != '0' && strlen($pageId)== 3){
				$zipcode = '00'.$pageId;
			  }else{
					$zipcode = $pageId;
			  }
			  
				
				
	     }else{
			  $selectpageData = mysqli_query($conn, "SELECT * FROM markers WHERE zipcode = '".$pageId."' && adminid='".$adminId."'");
			  
				$pageData = mysqli_fetch_assoc($selectpageData);
				      
				$locationId = $pageData['id'];
				$name = $pageData['name'];				
				$city = $pageData['city'];
				$state = $pageData['state'];				
				$zipcode = $pageData['zipcode'];
				$lat = $pageData['lat'];
				$lng = $pageData['lng'];
				//$parentcity = str_replace('Restoration 1 of','',$pageData['name']);
				$parentcity = $pageData['name'];
				$title = $pageData['name'];
				
			 
			}
			
       if(isset($pageData['pageContent']) && $pageData['pageContent']!=''){
		   $pagecontent =  $pageData['pageContent'];
		   
	   }else{
		   $pagecontent = $pageData['pagecontent'];
		}
      
    $metadesc = $pageData['meta_desc'];   
    $address = $pageData['address'];
	$addressshow = $pageData['addressshow'];
	$suite = $pageData['suite'];    
	$phone = $pageData['phone'];
	$dyanmicReviewscript = $pageData['review_script'];	
	
	
	$review_review = explode(" &&*&& ", $pageData['review']);
	$created = date("m/d/y" , strtotime($pageData['modified']));
	$reviewername = explode(" &&*&& ", $pageData['reviewername']);
	
	//Defaultglobaloptions query
	$globaloptions = mysqli_query($conn, "SELECT * FROM globaloptions WHERE adminid='".$adminId."'");
	$fetch = mysqli_fetch_assoc($globaloptions);    
	$page_layout= $fetch['page_layout'];
	$module_position= $fetch['module_position'];
	$analytic = $fetch['analytic'];
	$analytic_default = $fetch['analytic_default'];
	$canonical_url = $fetch['canonical_url'];
?>
<?php
//Business Hours//
	$weekDays = date('l');
	$class = 'business-open';
	//Normal
	$sunot = $pageData['sunot'];
	$sunct = $pageData['sunct'];
	$sunos = $pageData['sunos'];
	$monot = $pageData['monot'];
	$monct = $pageData['monct'];
	$monos = $pageData['monos'];
	$tueot = $pageData['tueot'];
	$tuect = $pageData['tuect'];
	$tueos = $pageData['tueos'];
	$wedot = $pageData['wedot'];
	$wedct = $pageData['wedct'];
	$wedos = $pageData['wedos'];
	$thuot = $pageData['thuot'];
	$thuct = $pageData['thuct'];
	$thuos = $pageData['thuos'];
	$friot = $pageData['friot'];
	$frict = $pageData['frict'];
	$frios = $pageData['frios'];
	$satot = $pageData['satot'];
	$satct = $pageData['satct'];
	$satos = $pageData['satos'];
	//Global
	$business_hours= $fetch['business_hours'];
	$sunot_1 = $fetch['sunot'];
	$sunct_1 = $fetch['sunct'];
	$sunos_1 = $fetch['sunos'];
	$monot_1 = $fetch['monot'];
	$monct_1 = $fetch['monct'];
	$monos_1 = $fetch['monos'];
	$tueot_1 = $fetch['tueot'];
	$tuect_1 = $fetch['tuect'];
	$tueos_1 = $fetch['tueos'];
	$wedot_1 = $fetch['wedot'];
	$wedct_1 = $fetch['wedct'];
	$wedos_1 = $fetch['wedos'];
	$thuot_1 = $fetch['thuot'];
	$thuct_1 = $fetch['thuct'];
	$thuos_1 = $fetch['thuos'];
	$friot_1 = $fetch['friot'];
	$frict_1 = $fetch['frict'];
	$frios_1 = $fetch['frios'];
	$satot_1 = $fetch['satot'];
	$satct_1 = $fetch['satct'];
	$satos_1 = $fetch['satos'];
if($business_hours == "on") {
	$business_hours_select = "Global Business Hours"; 
} else if($sunot && $sunct && $sunos && $monot && $monct && $monos && $tueot && $tuect && $tueos && $wedot && $wedct && $wedos && $thuot && $thuct && $thuos && $friot &&	$frict && $frios && $satot && $satct && $satos != "") {
	$business_hours_select = "Business Hours";
} else if($sunot_1 && $sunct_1 && $sunos_1 && $monot_1 && $monct_1 && $monos_1 && $tueot_1 && $tuect_1 && $tueos_1 && $wedot_1 && $wedct_1 && $wedos_1 && $thuot_1 && $thuct_1 && $thuos_1 && $friot_1 && $frict_1 && $frios_1 && $satot_1 && $satct_1 && $satos_1 != "") {
	$business_hours_select = "Global Business Hours";	
} else { }

//Profile Images
	//Normal
	$profileimage = $pageData['profileimage'];
	//Global
	$profileimage_overide = $fetch['profileimage_overide'];
	$profileimage_global = $fetch['profileimage'];
        if($profileimage_overide == "on") {
                $profile_image_select = "Global Profile Image";
        } else if($profileimage != "") {
                $profile_image_select = "Profile Image";
        } else if($profileimage_global != ""){
                $profile_image_select = "Global Profile Image";
        } else {
                $profile_image_select = "Street View";
        }

        //Page Content
	//Normal
	$pagetitle = $pageData['pagetitle'];	
	$pagedescription = $pageData['pagecontent'];

	//Global
	$page_content = $fetch['page_content'];
	$pagetitle_global = $fetch['pagetitle'];
	$pagecontent_global = $fetch['pagecontent'];
      if($page_content == "on") {
	$page_content_select = "Global Page Content";
      } else if($pagetitle || $pagecontent != "") {
	$page_content_select = "Page Content";	
      } else if($pagetitle_global || $pagecontent_global != ""){
	$page_content_select = "Global Page Content";	
      } else { }

//Trust Badges
	//Normal
	$uploadimage = explode(" &&*&& ", $pageData['uploadimage']);
	$uploadimagearray = array_filter($uploadimage);
	$uploadimagecount = count($uploadimagearray);
	$trustwebsitelink = explode(" &&*&& ", $pageData['trustwebsitelink']);
  
	//Global
	$trust_badges = $fetch['trust_badges'];
	$uploadimage_global = explode(" &&*&& ",$fetch['uploadimage']);
	$uploadimage_globalarray = array_filter($uploadimage_global);
	$uploadimage_globalcount = count($uploadimage_globalarray);
	$trustwebsitelink_global = explode(" &&*&& ", $fetch['trustwebsitelink']);

	if($trust_badges == "on") {
		$trust_badges_select = "Global Trust Badges";
	} else if(!empty($uploadimagearray)) {
		$trust_badges_select = "Trust Badges";
	} else if(!empty($uploadimage_globalarray)) {
		$trust_badges_select = "Global Trust Badges";
	} else {}
	
//Trust text 	
	//Normal
	$trusttext = $pageData['trusttext'];
	//Global
	$trusttextoveride = $fetch['trusttextoveride'];
	$trusttext_global = $fetch['trusttext'];
	if($trusttextoveride == "on") {
		$trust_text_select = "Global Trust Text";
	} elseif($trusttext != "") {
		$trust_text_select = "Trust Text";
	} elseif($trusttext_global != "") {
		$trust_text_select = "Global Trust Text";
	} else {}
// Custom Reviews
	$customreview_star=$pageData['custom_reviewstar'];
	$custom_featurereview=$pageData['custom_featurereview'];
	$custom_reviewscript=$pageData['custom_reviewscript'];

	// Normal	
	$uploadprofileimage = explode(" &&*&& ", $pageData['uploadprofileimage']);
	$reviewername_review = explode(" &&*&& ", $pageData['reviewername']);
	$review = explode(" &&*&& ", $pageData['review']);
	$reviewsite = explode(" &&*&& ", $pageData['reviewsite']);
	$rating = explode(" &&*&& ", $pageData['rating']);
	$ratingarray = array_filter($rating);
	$ratingcount = count($ratingarray);
	//Count Stars Average
	$ratingcountsum = array_sum($rating);
	$averagestars = ($ratingcountsum) / ($ratingcount);

	// Global
	$custom_reviews = $fetch['custom_reviews'];
	$uploadprofileimage_global = explode(" &&*&& ", $fetch['uploadprofileimage']);
	$reviewername_global = explode(" &&*&& ", $fetch['reviewername']);
	$review_global = explode(" &&*&& ", $fetch['review']);
	$reviewsite_global = explode(" &&*&& ", $fetch['reviewsite']);
 	$rating_global = explode(" &&*&& ", $fetch['rating']);
 	$rating_globalarray = array_filter($rating_global);
	$rating_globalcount = count($rating_globalarray);
	
	//Count Stars Average
	$ratingcountsum_global = array_sum($rating_global);
	$averagestars_global = ($ratingcountsum_global) / ($rating_globalcount);
	
	if($custom_reviews == "on") {
		$custom_reviews_status = "Global Custom Reviews";
	} elseif ($ratingcount > 0) {
		$custom_reviews_status = "Custom Reviews";
	} elseif ($rating_globalcount > 0) {
		$custom_reviews_status = "Global Custom Reviews";
	} else {}
	
        //Contact Form
	$formtitle = $fetch['formtitle'];
	$buttontext = $fetch['buttontext'];
	$forminput = explode(" &&*&& ", $fetch['forminput']);
	$formplaceholder = explode(" &&*&& ", $fetch['formplaceholder']);
	$formrequired = explode(" &&*&& ", $fetch['formrequired']);
	$forminputcount = count(array_filter($forminput));
	
	//Normal
	$emailmesageid = $pageData['emailmesageid'];
	//Global
	$emailmesageidoveride = $fetch['emailmessageidoveride'];
	$emailmesageid_global = $fetch['emailmessageid'];
	
	if($emailmesageidoveride == "on") {
		$contactformemail = $emailmesageid_global;
	} elseif($emailmesageid != "") {
		$contactformemail = $emailmesageid;
	} elseif($trusttext_global != "") {
		$contactformemail = $emailmesageid_global;
	} else {}

	
// Review Us Button
	// Normal	
	$buttontitle = explode(" &&*&& ", $pageData['buttontitle']);
	$buttontitlearray = array_filter($buttontitle);
	$buttontitlecount = count($buttontitlearray);
	$buttonlink = explode(" &&*&& ", $pageData['buttonlink']);
	
	// Global
	$reviewoveride = $fetch['review_us'];
	$buttontitleglobal = explode(" &&*&& ", $fetch['buttontitle']);
	$buttontitleglobalarray = array_filter($buttontitleglobal);
	$buttontitleglobalcount = count($buttontitleglobalarray);
	$buttonlinkglobal = explode(" &&*&& ", $fetch['buttonlink']);
	
	if($reviewoveride == "on") {
		$reviewbuttonselect = "Global Review Buttons";
	} elseif($buttontitlecount > 0){
		$reviewbuttonselect = "Review Buttons";
	} elseif($buttontitleglobalcount > 0) {
		$reviewbuttonselect = "Global Review Buttons";
	} else {}
	
                 //Coupans
		//Normal
		$uploadcoupanimage = explode(" &&*&& ", $pageData['uploadcoupanimage']);
		$coupantitle = explode(" &&*&& ", $pageData['coupontitle']);
		$coupantitlearray  = array_filter($coupantitle);
		$coupantitlecount = count($coupantitlearray);
		$coupantext = explode(" &&*&& ", $pageData['coupantext']);
		$coupanlink = explode(" &&*&& ", $pageData['coupanlink']);
		//Global
		$add_coupon = $fetch['add_coupon'];
		$uploadcoupanimage_global = explode(" &&*&& ", $fetch['uploadcoupanimage']);
		$coupantitle_global = explode(" &&*&& ", $fetch['coupontitle']); 
		$coupantitle_globalarray = array_filter($coupantitle_global); 
		$coupantitle_globalcount = count($coupantitle_globalarray);
		$coupantext_global = explode(" &&*&& ", $fetch['coupantext']);
		$coupanlink_global = explode(" &&*&& ", $fetch['coupanlink']);
	if($add_coupon == "on") {
		$couponselect = "Global Coupons";
	} elseif ($coupantitlecount > 0) {
		$couponselect = "Coupons";
	} elseif($coupantitle_globalcount > 0) {
		$couponselect = "Global Coupons";
	} else {}
         //Payments
	//Normal
	$americanexpress = $pageData['americanexpress'];
	$discover = $pageData['discover'];
	$applepay = $pageData['applepay'];
	$paypal = $pageData['paypal'];
	$creditcard = $pageData['creditcard'];
	$google = $pageData['google'];
	$mastercard = $pageData['mastercard'];
	$cash = $pageData['cash'];
	$visa = $pageData['visa'];
	
	//Global
	$payments_accepted = $fetch['payments_accepted'];
	$americanexpress_global = $fetch['americanexpress'];
	$discover_global = $fetch['discover'];
	$applepay_global = $fetch['applepay'];
	$paypal_global = $fetch['paypal'];
	$creditcard_global = $fetch['creditcard'];
	$google_global = $fetch['google'];
	$mastercard_global = $fetch['mastercard'];
	$cash_global = $fetch['cash'];
	$visa_global = $fetch['visa'];
	
	if($payments_accepted == "on") {
		$paymentselect = "Global Payments";
	} elseif($americanexpress || $discover || $applepay || $paypal || $creditcard || $google || $mastercard || $cash || $visa != "") {
		$paymentselect = "Payments";
	} elseif($americanexpress_global || $discover_global || $applepay_global || $paypal_global || $creditcard_global || $google_global || $mastercard_global || $cash_global || $visa_global != "") {
		$paymentselect = "Global Payments";	
	} else {}
//Services
	//Normal
		$addservices = explode(" &&*&& ", $pageData['services']);
		$addservicesarray = array_filter($addservices);
		$addservicescount = count($addservicesarray);
		/*service link*/
		$addserviceslink = explode(" &&*&& ", $pageData['serviceslink']);
		$addservicesarraylink = array_filter($addserviceslink);
		$addservicescountlink = count($addservicesarraylink);
	// Global
		$serviceoveride = $fetch['serviceoveride'];
		$addservicesglobal = explode("&&*&&", $fetch['services']);
		$addservicesarrayglobal = array_filter($addservicesglobal);
		$addservicescountglobal = count($addservicesarrayglobal);

                
	if($serviceoveride == "on") {
		$serviceselect = "Global Services";
	} elseif($addservicescount > 0) {
		$serviceselect = "Services";
	} elseif($addservicescountglobal > 0) {
		$serviceselect = "Global Services";
	} else {
		
	}
?>

<?php
//Open Status 
  $today = date('l');
  //Normal
	if(!in_array("Sunday", $weekholidaysarray) && $today == "Sunday" && $sunos == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$sunot.' - '.$sunct.'</span>';
	} else if(!in_array("Monday", $weekholidaysarray) && $today == "Monday" && $monos == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$monot.' - '.$monct.'</span>';
	} else if(!in_array("Tuesday", $weekholidaysarray) && $today == "Tuesday" && $tueos == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$tueot.' - '.$tuect.'</span>';
	} else if(!in_array("Wednesday", $weekholidaysarray) && $today == "Wednesday" && $wedos == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$wedot.' - '.$wedct.'</span>';
	} else if(!in_array("Thursday", $weekholidaysarray) && $today == "Thursday" && $thuos == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$thuot.' - '.$thuct.'</span>';
	} else if(!in_array("Friday", $weekholidaysarray) && $today == "Friday" && $frios == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$friot.' - '.$frict.'</span>';
	} else if(!in_array("Saturday", $weekholidaysarray) && $today == "Saturday" && $satos == "open") {
		$todayStatus = '<span class="bopen">Open today</span> : <span>'.$satot.' - '.$satct.'</span>';
	} else {
		$todayStatus = '<span class="bclosed">Closed today</span>';
	}
	
	//Global
	if(!in_array("Sunday", $weekholidaysarray) && $today == "Sunday" && $sunos_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$sunot_1.' - '.$sunct_1.'</span>';
	} else if(!in_array("Monday", $weekholidaysarray) && $today == "Monday" && $monos_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$monot_1.' - '.$monct_1.'</span>';
	} else if(!in_array("Tuesday", $weekholidaysarray) && $today == "Tuesday" && $tueos_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$tueot_1.' - '.$tuect_1.'</span>';
	} else if(!in_array("Wednesday", $weekholidaysarray) && $today == "Wednesday" && $wedos_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$wedot_1.' - '.$wedct_1.'</span>';
	} else if(!in_array("Thursday", $weekholidaysarray) && $today == "Thursday" && $thuos_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$thuot_1.' - '.$thuct_1.'</span>';
	} else if(!in_array("Friday", $weekholidaysarray) && $today == "Friday" && $frios_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$friot_1.' - '.$frict_1.'</span>';
	} else if(!in_array("Saturday", $weekholidaysarray) && $today == "Saturday" && $satos_1 == "open") {
		$todayglobalStatus = '<span class="bopen">Open today</span> : <span>'.$satot_1.' - '.$satct_1.'</span>';
	} else {
		$todayglobalStatus = '<span class="bclosed">Closed today</span>';
	}
?>

<?php

if($slug == "" && $slug2 == "") {
	$loadpage = "index";
} else if($slug != "" && $slug2 == ""&& mysqli_num_rows($selectpageData) > 0){
	$loadpage = "location";
} else if($slug != "" && $slug2 =="detail"&& mysqli_num_rows($selectpageData) > 0) {
	$loadpage = "locationdetails";
} elseif($slug == "servicelocations" && $slug2 == ""){
         $loadpage="servicelocations";    
}else if($slug == "thank-you"){
	$loadpage = "thankcontent";
}else {
	$loadpage = "notfound";
}

?>
