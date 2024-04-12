<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);

      include "config.php";
    //  include('../PaymentFunctions.php');
      include('../../Functions.php');
      $custom_functions=new Functions;
   ?>
<?php
   if (session_status() == PHP_SESSION_NONE) {
   	session_start();
   }
   	$usersessionid = $_SESSION['data']['adminid'];
   	$usersessionsubid = $_SESSION['data']['id'];
   	$role = $_SESSION['data']['role'];
   	if($role == 'admin' || $role == 'subadmin'){
   		$admin_id = $usersessionid;
   	} elseif($role == 'superadmin'){
   		$admin_id = $_POST['adminid'];
   	} else {

           }


   	$checkadminid = mysqli_query($con, "SELECT id,package,invoice FROM users WHERE role='admin' && adminid='$admin_id'");
   	$checkadminiddata = mysqli_fetch_array($checkadminid);
   	$checkexactadminid = $checkadminiddata['id'];

           /*$duplicate = mysqli_query($con, "SELECT id, slug FROM markers WHERE slug IN (SELECT slug FROM markers GROUP BY slug HAVING COUNT(id) > 1)");
           $query=mysqli_query($con, "SELECT slug FROM markers having count(*) >= 2");
               while($data = mysqli_fetch_array($duplicate)){
                   echo $data["slug"]."<br>";
               }
           die;*/

                   $countlocationquery = mysqli_query($con, "SELECT * FROM markers WHERE adminid=".$admin_id);
   	        $locationfetch = mysqli_fetch_all($countlocationquery);
                   $total_locations=count($locationfetch);

                //   $payment_query="SELECT * FROM payments WHERE adminid=".$admin_id;
                //   $ex_payment_query=mysqli_query($con,$payment_query);
                //   $payment_data=mysqli_fetch_assoc($ex_payment_query);
                //   $existing_stripeplan=$payment_data['stripeplan'];
                //   $current_subscription_id=$payment_data['subscription_id'];

                //   $pack_query="SELECT * FROM packages WHERE planname='".$checkadminiddata['package']."'";
                //   $ex_pack_query=mysqli_query($con,$pack_query);
                //   $package_data=mysqli_fetch_assoc($ex_pack_query);


   ?>
<?php
   /*save zip code*/
   if(isset($_POST["addZip"])) {
   	if($_POST['adminid']==50){
   		$flag = 0;
   		//foreach($_POST['zip_name'] as $key=>$value){
			if(mysqli_query($con, "INSERT INTO zipcodesnew (buss_id, zip_name, zipcode,city,state, country, loc_id,page_content) VALUES ('".mysqli_real_escape_string($con, $_POST['adminid'])."', '".mysqli_real_escape_string($con, $_POST['zip_name'])."', '".mysqli_real_escape_string($con, $_POST['zipcode'])."', '".mysqli_real_escape_string($con, $_POST['city'])."', '".mysqli_real_escape_string($con, $_POST['state'])."', '".mysqli_real_escape_string($con, $_POST['country'])."', '".mysqli_real_escape_string($con, $_POST['loc_id'])."','".mysqli_real_escape_string($con, $_POST['page_content'])."')")) {
   				 $flag =1;
   			} else {
   				$flag = 0;
   			}
   		//}

   		if($flag==1){
   			$_SESSION['msg_succ'] = "zipcode data added successfully";

   				if(trim($role) == trim('superadmin') || trim($role) == trim('subadmin')){

   					header('location:../addcustomezipcode.php?adminid='.$admin_id);
   				} else {
   						header('location:../addcustomezipcode.php');
   				}
   		}else{
			$_SESSION['msg_error'] = mysqli_error($con);
   		//	$_SESSION['msg_error'] = "Location could not be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
   			if(trim($role) == trim('superadmin')){

   				header('location:../addcustomezipcode.php?adminid='.$admin_id);
   			} else {
   				header('location:../addcustomezipcode.php');
   			}

   		}
   	}
   }else if(isset($_POST["addLocation"])) {
   	/*Add locations*/
   $emailmesageid = json_encode($_POST['emailmesageid']);
   //$_POST = array_map("trim", $_POST);
   $name = $_POST['name'];
   $address = $_POST['address'];
   if(isset($_POST['addressshow'])) {
   	$addressshow = 1;
   }else{
   	$addressshow = 0;
   }
   $suite = $_POST['suite'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $locUrl = $_POST['locUrl'];
   $common_served_area = $_POST['common_served_area'];
          $user_enroll_query=mysqli_query($con,"SELECT enrolled,package FROM users WHERE adminid='".$admin_id."' ");
          $user_enroll_data=mysqli_fetch_assoc($user_enroll_query);


   $slug = trim(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', str_replace(' ', '-', $city))), "-");

   $slugquery = mysqli_query($con, "SELECT COUNT(*) AS slugcount FROM markers WHERE adminid='".$admin_id."' AND slug LIKE '$slug%'");
   $slugrow = $slugquery->fetch_assoc();
   $slugcount = $slugrow['slugcount'];

   if($slugcount > 0) {
   	$slugnewquery=mysqli_query($con, "SELECT slug FROM markers WHERE adminid='".$admin_id."' AND slug LIKE '$slug%'");
   	while($slugdata = mysqli_fetch_array($slugnewquery)){
   	  $slugdatanum = $slugdata["slug"];
	  
   	}
  /*$slugnum = explode("-", $slugdatanum);
   	$slugnumval = end($slugnum);
   	$slug = $slug.'-'.($slugnumval + 1);
   */
	   $slugnum = explode("-", $slugdatanum);
	   $slugnumval = end($slugnum);   
	   
	   // Ensure $slugnumval is treated as an integer
	    $slugnumval = intval($slugnumval);
	 
	   $slug = $slug . '-' . ($slugnumval + 1);
	   
	  
   }

   $zipcode = $_POST['zipcode'];
   $lat = $_POST['lat'];
   $lng = $_POST['lng'];
   $phone = $_POST['phone'];
   $phone1 = preg_replace('/\D+/', '', $phone);



   /*
   $sunot = $_POST['sunot'];
   $sunct = $_POST['sunct'];
   $sunos = $_POST['sunos'];
   $monot = $_POST['monot'];
   $monct = $_POST['monct'];
   $monos = $_POST['monos'];
   $tueot = $_POST['tueot'];
   $tuect = $_POST['tuect'];
   $tueos = $_POST['tueos'];
   $wedot = $_POST['wedot'];
   $wedct = $_POST['wedct'];
   $wedos = $_POST['wedos'];
   $thuot = $_POST['thuot'];
   $thuct = $_POST['thuct'];
   $thuos = $_POST['thuos'];
   $friot = $_POST['friot'];
   $frict = $_POST['frict'];
   $frios = $_POST['frios'];
   $satot = $_POST['satot'];
   $satct = $_POST['satct'];
   $satos = $_POST['satos'];
   $profileimage = $_POST['profileimage'];
   $pagetitle = $_POST['pagetitle'];
   $pagecontent = $_POST['pagecontent'];

   $uploadimage = $_POST['uploadimage'];
   foreach($uploadimage as $value){
   	$badgeuploadimage[] = $value;
   	}
   $badgeimage = implode(' &&*&& ', $badgeuploadimage);

   $trustwebsitelink = $_POST['trustwebsitelink'];
   foreach($trustwebsitelink as $value){
   	$trustwebsitelinkval[] = $value;
   	}
   $trustwebsitelinkval = implode(' &&*&& ', $trustwebsitelinkval);

   $trusttext = $_POST['trusttext'];

   $buttontitle = $_POST['buttontitle'];
   foreach($buttontitle as $value){
   	$buttontitlevalue[] = $value;
   }

   $buttontitlevalue = implode(' &&*&& ', $buttontitlevalue);

   $buttonlink = $_POST['buttonlink'];
   foreach($buttonlink as $value) {
   	$buttonlinkvalue[] = $value;
   }
   $buttonlinkvalue = implode(' &&*&& ', $buttonlinkvalue);

   $uploadpimage = $_POST['uploadprofileimage'];
   foreach($uploadpimage as $value) {
   	$uploadprofileimage[] = $value;
   }
   $uploadprofileimage = implode(' &&*&& ', $uploadprofileimage);

   $reviewername = $_POST['reviewername'];
   foreach($reviewername as $value) {
   	$reviewernamevalue[] = $value;
   }
   $reviewernamevalue = implode(' &&*&& ', $reviewernamevalue);

   $reviewsite = $_POST['reviewsite'];
   foreach($reviewsite as $value) {
   	$reviewsitevalue[] = $value;
   }
   $reviewsitevalue = implode(' &&*&& ', $reviewsitevalue);

   $rating = $_POST['rating'];
   foreach($rating as $value) {
   	$ratingvalue[] = $value;
   }
   $ratingvalue = implode(' &&*&& ', $ratingvalue);

   $review = $_POST['review'];
   foreach($review as $value) {
   	$reviewvalue[] = $value;
   }
   $reviewvalue = implode(' &&*&& ', $reviewvalue);

   $americanexpress = (isset($_POST['americanexpress'])) ? $_POST['americanexpress'] : '' ;
   $discover = (isset($_POST['discover'])) ? $_POST['discover'] : '';
   $applepay = (isset($_POST['applepay'])) ? $_POST['applepay'] : '';
   $paypal = 	(isset($_POST['paypal'])) ? $_POST['paypal'] : '';
   $creditcard = (isset($_POST['creditcard'])) ? $_POST['creditcard'] : '';
   $google = (isset($_POST['google'])) ? $_POST['google'] : '';
   $mastercard = (isset( $_POST['mastercard'])) ? $_POST['mastercard'] : '';
   $cash = (isset($_POST['cash'])) ? $_POST['cash'] : '';
   $visa = (isset($_POST['visa'])) ? $_POST['visa'] : '';

   $uploadcimage = $_POST['uploadcoupanimage'];
   foreach($uploadcimage as $value) {
   	$uploadcoupanimage[] = $value;
   }
   $uploadcoupanimage = implode(' &&*&& ', $uploadcoupanimage);

   $coupontitle = $_POST['coupontitle'];
   foreach($coupontitle as $value) {
   	$coupontitlevalue[] = $value;
   }
   $coupontitlevalue = implode(' &&*&& ', $coupontitlevalue);

   $coupantext = $_POST['coupantext'];
   foreach($coupantext as $value) {
   	$coupantextvalue[] = $value;
   }
   $coupantextvalue = implode(' &&*&& ', $coupantextvalue);

   $coupanlink = $_POST['coupanlink'];
   foreach($coupanlink as $value) {
   	$coupanlinkvalue[] = $value;
   }
   $coupanlinkvalue = implode(' &&*&& ', $coupanlinkvalue);

   $addservice = $_POST['addservice'];
   foreach($addservice as $value){
   	 $addservicevalue[] = $value;
   	}
   $addservicevalue = implode(' &&*&& ', $addservicevalue);

   $addservicelink = $_POST['addservicelink'];
   foreach($addservicelink as $value){
   	 $addservicelinkvalue[] = $value;
   	}
   $addservicelinkvalue = implode(' &&*&& ', $addservicelinkvalue);


   $extra_zipcodevalue='';
   */
   /*for extra zipcode*/
   /*if(isset($_POST['extra_zipcode'])):
   	$extra_zipcode = $_POST['extra_zipcode'];
   	foreach($extra_zipcode as $value){
   		$extra_zipcodevalue[] = $value;
   		}
   	$extra_zipcodevalue = implode(' &&*&& ', $extra_zipcodevalue);
   endif;

   $extra_zipcode_linkvalue='';

   if(isset( $_POST['extra_zipcode_link'])):
   	$extra_zipcode_link = $_POST['extra_zipcode_link'];
   	foreach($extra_zipcode_link as $value){
   		$extra_zipcode_linkvalue[] = $value;
   		}
   	$extra_zipcode_linkvalue = implode(' &&*&& ', $extra_zipcode_linkvalue);
   endif;
   */
   if( (isset($_POST['addchild']) && $_POST['addchild']==1) && $suite!=''){
   	$childL = $_POST['childL'];
   	foreach($childL as $value){
   		 $childLvalue[] = $value;
   		}
   	$childLvalue = implode(' &&*&& ', $childLvalue);
   	if($childLvalue==''){
   		$checkChild = 0;
   	}else{
   		$checkChild = $_POST['addchild'];
   	}

   }else{
   	$childLvalue='';
   	$checkChild=0;
   }

   /*********************************code for additional address Start************************************/


   $additionalAddressHide = array();
   if(isset($_POST['extraAddress']) && ($_POST['extraAddress']==1)){
   	$additionalAddressHide = $_POST['additionaladdressshow'];
   	foreach($additionalAddressHide as $value){
   		 $additionalAddressHidevalue[] = $value;
   		}
   	$additionalAddressHidevalue = implode(' &&*&& ', $additionalAddressHidevalue);



   	$additionaladdress = $_POST['additionaladdress'];
   	foreach($additionaladdress as $value){
   		 $additionaladdressvalue[] = $value;
   		}
   	$additionaladdressvalue = implode(' &&*&& ', $additionaladdressvalue);



   	$additionalcity = $_POST['additionalcity'];
   	foreach($additionalcity as $value){
   		 $additionalcityvalue[] = $value;
   		}
   	$additionalcityvalue = implode(' &&*&& ', $additionalcityvalue);

   	$additionalstate = $_POST['additionalstate'];
   	foreach($additionalstate as $value){
   		 $additionalstatevalue[] = $value;
   		}
   	$additionalstatevalue = implode(' &&*&& ', $additionalstatevalue);

   	$additionalzipcode = $_POST['additionalzipcode'];
   	foreach($additionalzipcode as $value){
   		 $additionalzipcodevalue[] = $value;
   		}
   	$additionalzipcodevalue = implode(' &&*&& ', $additionalzipcodevalue);

   	$additionalphone = $_POST['additionalphone'];
   	foreach($additionalphone as $value){
   		 $additionalphonevalue[] = $value;
   		}
   	$additionalphonevalue = implode(' &&*&& ', $additionalphonevalue);

   	if($additionaladdressvalue==''){
   		$checkaddress = 0;
   	}else{
   		$checkaddress = $_POST['extraAddress'];
   	}

   }else{
   	$additionaladdressvalue='';
   	$checkaddress=0;
   }

   /*********************************Code for additional address END************************************/



   $currentlocationsquery = mysqli_query($con, "SELECT locationsaccess FROM users WHERE id = '$usersessionsubid'");
   $currentlocationsfetch = mysqli_fetch_assoc($currentlocationsquery);
   $currentlocationsaccess = $currentlocationsfetch['locationsaccess'];
 /*
   $title_tag = $_POST['title_tag'];
   $meta_desc = $_POST['meta_desc'];
   $review_script = $_POST['review_script'];
   $customreview_star = $_POST['customreview_star'];
   $customfeaturereview = $_POST['customfeaturereview'];
   $customreview_script = $_POST['customreview_script'];
   */
    $locationUrl_tblId='0';
   //Insert location's url in table locationsurl then saved it's id to markers table
	//locationsurl table url and parent_id
	$lname=trim($name,"");
	if($admin_id == 50) //for restoration
		$locName=substr($lname,17);
	elseif($admin_id == 51) //for bluefrog
		$locName=substr($lname,28);
	elseif($admin_id == 52) //for tdc drivaway
		$locName=substr($lname,23);
	elseif($admin_id == 53) //for soft roc
		$locName=$lname;
    $locName = trim($locName);

	$insertlocsql="insert into locationsurl (location,url,parent_id) values('".$locName."', '".$locUrl."','".$suite."')";
	mysqli_query($con,$insertlocsql);
		$locationUrl_tblId = mysqli_insert_id($con);
 /*  if(mysqli_query($con, "INSERT INTO markers (is_publish,adminid,common_served_area,locationurl, name, address,addressshow, suite,child_check,address_check, city, state, zipcode, lat, lng, phone, sunot, sunct, sunos, monot, monct, monos, tueot, tuect, tueos, wedot, wedct, wedos, thuot, thuct, thuos, friot, frict, frios, satot, satct, satos, profileimage, pagetitle, pagecontent, uploadimage, trusttext, trustwebsitelink, emailmesageid, buttontitle, buttonlink, uploadprofileimage, reviewername, reviewsite, rating, review, americanexpress, discover, applepay, paypal, creditcard, google, mastercard, cash, visa, uploadcoupanimage, coupontitle, coupantext, coupanlink, services,serviceslink, slug,extra_zipcode,extra_zipcode_link,title_tag,meta_desc,review_script,custom_reviewstar,custom_featurereview,custom_reviewscript,created,direction,clickcall) VALUES ('0','".mysqli_real_escape_string($con, $admin_id)."','".mysqli_real_escape_string($con,$common_served_area)."','".$locationUrl_tblId."',  '".mysqli_real_escape_string($con, $name)."', '".mysqli_real_escape_string($con, $address)."', '".mysqli_real_escape_string($con, $addressshow)."', '".mysqli_real_escape_string($con, $suite)."', '".mysqli_real_escape_string($con, $checkChild)."', '".mysqli_real_escape_string($con, $checkaddress)."','".mysqli_real_escape_string($con, $city)."', '".mysqli_real_escape_string($con, $state)."', '".mysqli_real_escape_string($con, $zipcode)."', '".mysqli_real_escape_string($con, $lat)."', '".mysqli_real_escape_string($con, $lng)."', '".mysqli_real_escape_string($con, $phone1)."', '".mysqli_real_escape_string($con, $sunot)."', '".mysqli_real_escape_string($con, $sunct)."', '".mysqli_real_escape_string($con, $sunos)."', '".mysqli_real_escape_string($con, $monot)."', '".mysqli_real_escape_string($con, $monct)."', '".mysqli_real_escape_string($con, $monos)."', '".mysqli_real_escape_string($con, $tueot)."', '".mysqli_real_escape_string($con, $tuect)."', '".mysqli_real_escape_string($con, $tueos)."', '".mysqli_real_escape_string($con, $wedot)."', '".mysqli_real_escape_string($con, $wedct)."', '".mysqli_real_escape_string($con, $wedos)."', '".mysqli_real_escape_string($con, $thuot)."', '".mysqli_real_escape_string($con, $thuct)."', '".mysqli_real_escape_string($con, $thuos)."', '".mysqli_real_escape_string($con, $friot)."', '".mysqli_real_escape_string($con, $frict)."', '".mysqli_real_escape_string($con, $frios)."', '".mysqli_real_escape_string($con, $satot)."', '".mysqli_real_escape_string($con, $satct)."', '".mysqli_real_escape_string($con, $satos)."', '".mysqli_real_escape_string($con, $profileimage)."', '".mysqli_real_escape_string($con, $pagetitle)."', '".mysqli_real_escape_string($con, $pagecontent)."', '".mysqli_real_escape_string($con, $badgeimage)."', '".mysqli_real_escape_string($con, $trusttext)."', '".mysqli_real_escape_string($con, $trustwebsitelinkval)."', '".mysqli_real_escape_string($con, $emailmesageid)."', '".mysqli_real_escape_string($con, $buttontitlevalue)."', '".mysqli_real_escape_string($con, $buttonlinkvalue)."', '".mysqli_real_escape_string($con, $uploadprofileimage)."', '".mysqli_real_escape_string($con, $reviewernamevalue)."', '".mysqli_real_escape_string($con, $reviewsitevalue)."', '".mysqli_real_escape_string($con, $ratingvalue)."', '".mysqli_real_escape_string($con, $reviewvalue)."', '".mysqli_real_escape_string($con, $americanexpress)."', '".mysqli_real_escape_string($con, $discover)."', '".mysqli_real_escape_string($con, $applepay)."', '".mysqli_real_escape_string($con, $paypal)."', '".mysqli_real_escape_string($con, $creditcard)."', '".mysqli_real_escape_string($con, $google)."', '".mysqli_real_escape_string($con, $mastercard)."', '".mysqli_real_escape_string($con, $cash)."', '".mysqli_real_escape_string($con, $visa)."', '".mysqli_real_escape_string($con, $uploadcoupanimage)."', '".mysqli_real_escape_string($con, $coupontitlevalue)."', '".mysqli_real_escape_string($con, $coupantextvalue)."', '".mysqli_real_escape_string($con, $coupanlinkvalue)."', '".mysqli_real_escape_string($con, $addservicevalue)."', '".mysqli_real_escape_string($con, $addservicelinkvalue)."','".mysqli_real_escape_string($con, $slug)."', '".mysqli_real_escape_string($con, $extra_zipcodevalue)."','".mysqli_real_escape_string($con, $extra_zipcode_linkvalue)."','".mysqli_real_escape_string($con, $title_tag)."','".mysqli_real_escape_string($con, $meta_desc)."','".mysqli_real_escape_string($con, $review_script)."','".mysqli_real_escape_string($con, $customreview_star)."','".mysqli_real_escape_string($con, $customfeaturereview)."','".mysqli_real_escape_string($con, $customreview_script)."', NOW(),'0','0')"))
 */

if(mysqli_query($con, "INSERT INTO markers (is_publish,adminid,common_served_area,locationurl, name, address,addressshow, suite,child_check,address_check, city, state, zipcode, lat, lng, phone, sunot, sunct, sunos, monot, monct, monos, tueot, tuect, tueos, wedot, wedct, wedos, thuot, thuct, thuos, friot, frict, frios, satot, satct, satos, profileimage, pagetitle, pagecontent, uploadimage, trusttext, trustwebsitelink, emailmesageid, buttontitle, buttonlink, uploadprofileimage, reviewername, reviewsite, rating, review, americanexpress, discover, applepay, paypal, creditcard, google, mastercard, cash, visa, uploadcoupanimage, coupontitle, coupantext, coupanlink, services,serviceslink, slug,extra_zipcode,extra_zipcode_link,title_tag,meta_desc,review_script,custom_reviewstar,custom_featurereview,custom_reviewscript,created,direction,clickcall) VALUES ('0','".mysqli_real_escape_string($con, $admin_id)."','".mysqli_real_escape_string($con,$common_served_area)."','".$locationUrl_tblId."',  '".mysqli_real_escape_string($con, $name)."', '".mysqli_real_escape_string($con, $address)."', '".mysqli_real_escape_string($con, $addressshow)."', '".mysqli_real_escape_string($con, $suite)."', '".mysqli_real_escape_string($con, $checkChild)."', '".mysqli_real_escape_string($con, $checkaddress)."','".mysqli_real_escape_string($con, $city)."', '".mysqli_real_escape_string($con, $state)."', '".mysqli_real_escape_string($con, $zipcode)."', '".mysqli_real_escape_string($con, $lat)."', '".mysqli_real_escape_string($con, $lng)."', '".mysqli_real_escape_string($con, $phone1)."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, $pagecontent)."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, $emailmesageid)."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con,'')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."', '".mysqli_real_escape_string($con, '')."','".mysqli_real_escape_string($con, $slug)."', '".mysqli_real_escape_string($con, '')."','".mysqli_real_escape_string($con, '')."','".mysqli_real_escape_string($con,'')."','".mysqli_real_escape_string($con,'')."','".mysqli_real_escape_string($con,'')."','".mysqli_real_escape_string($con, '')."','".mysqli_real_escape_string($con,'')."','".mysqli_real_escape_string($con, '')."', NOW(),'0','0')"))
   {
		$last_id = mysqli_insert_id($con);    
		$brAnd = fetch_brand($admin_id,$con);
      	mysqli_query($con, "INSERT INTO r1_parent_info_lookUp (location_name, parent_license, location_id,brand) VALUES ('".mysqli_real_escape_string($con, $name)."',".$suite.",".$last_id.",".$brAnd.")");
		 
			if($checkChild==1 && $childLvalue!=''){
				foreach($_POST['childL'] as $value){
					mysqli_query($con, "INSERT INTO r1_parent_license_lookUp (Parent_Licence, Child_License,brand) VALUES (".$suite.",".mysqli_real_escape_string($con, $value).",".$brAnd.")");
				}
			}

			if($checkaddress!=0){
				mysqli_query($con, "INSERT INTO r1_additional_address (loc_id, eaddress,eaddressshow,ecity,estate,ezipcode,ephone,ecreated_at,brand) VALUES (".$last_id.",'".mysqli_real_escape_string($con, $additionaladdressvalue)."','".mysqli_real_escape_string($con, $additionalAddressHidevalue)."','".mysqli_real_escape_string($con, $additionalcityvalue)."','".mysqli_real_escape_string($con, $additionalstatevalue)."','".mysqli_real_escape_string($con, $additionalzipcodevalue)."','".mysqli_real_escape_string($con, $additionalphonevalue)."',NOW(),".$brAnd.")");
			}

		if($role = "subadmin") {
			$lastlocationquery = mysqli_query($con, "SELECT id FROM markers ORDER BY id DESC LIMIT 1");
			$lastlocationfetch = mysqli_fetch_assoc($lastlocationquery);
			$lastlocationid = $lastlocationfetch['id'];
			if($currentlocationsaccess != "") {
				$newlocationsaccess = $currentlocationsaccess.",".$lastlocationid;
			} else {
				$newlocationsaccess = $lastlocationid;
			}
			mysqli_query($con, "UPDATE users SET locationsaccess='".mysqli_real_escape_string($con, $newlocationsaccess)."' WHERE id= '".$usersessionsubid."'");
		}
			/*
		$chk_account = mysqli_query($con, "SELECT * FROM accounts WHERE admin_id='$admin_id'");
		$account_data = mysqli_fetch_assoc($chk_account);
		$amount_due=calculatePrice($con,$admin_id);
		if(!empty($account_data))
		{
			/*update amount_due in accounts
			$update_account_query = mysqli_query($con, "UPDATE accounts SET amount_due='".mysqli_real_escape_string($con, $amount_due)."' WHERE admin_id=$admin_id");

		}else{
			/* Insert new row */
			/* $insert_account_query = mysqli_query($con, "INSERT INTO accounts(admin_id,amount_due) VALUES('".mysqli_real_escape_string($con, $admin_id)."','".mysqli_real_escape_string($con, $amount_due)."')");
		} */


		$_SESSION['msg_succ'] = "Location added successfully.";

		if(trim($role) == trim('superadmin') || trim($role) == trim('subadmin')){
			header('location:../addlocationcustom.php?adminid='.$admin_id);
		} else {
			header('location:../addlocationcustom.php');
		}
   }else {
			$_SESSION['msg_error'] = mysqli_error($con);
   	 //	$_SESSION['msg_error'] = "Location could not be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
		if(trim($role) == trim('superadmin')){

			header('location:../addlocationcustom.php?adminid='.$admin_id);
		} else {

			header('location:../addlocationcustom.php');
		}
   }

   } elseif(isset($_POST["contact_form"])) {

   $form_title = $_POST['form_title'];
   $button_text = $_POST['button_text'];
   //echo "<pre>"; print_r($forminput); die;
   $forminput = implode(' &&*&& ', $_POST['forminput']);
   $formplaceholder = implode(' &&*&& ', $_POST['formplaceholder']);
   $formrequired = implode(' &&*&& ', $_POST['formrequired']);

   if(mysqli_query($con, "Update globaloptions SET formtitle='".mysqli_real_escape_string($con, $form_title)."', buttontext='".mysqli_real_escape_string($con, $button_text)."', forminput='".mysqli_real_escape_string($con, $forminput)."', formplaceholder='".mysqli_real_escape_string($con, $formplaceholder)."', formrequired='".mysqli_real_escape_string($con, $formrequired)."' WHERE adminid= '".$admin_id."'")) {
   	$_SESSION['msg_succ'] = "Contact form options updated successfully.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions.php');
   	}
   } else {
   	//$_SESSION['msg_error'] = mysqli_error($con);
   	$_SESSION['msg_error'] = "Contact form options could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions.php');
   	}
   }
   } elseif(isset($_POST["addglobaloptions"])) {


      if(isset($_POST['business_hours_submit']))
      {
          $business_hours = $_POST['business_hours'];
   $sunot = $_POST['sunot'];
   $sunct = $_POST['sunct'];
   $sunos = $_POST['sunos'];
   $monot = $_POST['monot'];
   $monct = $_POST['monct'];
   $monos = $_POST['monos'];
   $tueot = $_POST['tueot'];
   $tuect = $_POST['tuect'];
   $tueos = $_POST['tueos'];
   $wedot = $_POST['wedot'];
   $wedct = $_POST['wedct'];
   $wedos = $_POST['wedos'];
   $thuot = $_POST['thuot'];
   $thuct = $_POST['thuct'];
   $thuos = $_POST['thuos'];
   $friot = $_POST['friot'];
   $frict = $_POST['frict'];
   $frios = $_POST['frios'];
   $satot = $_POST['satot'];
   $satct = $_POST['satct'];
   $satos = $_POST['satos'];
          if(mysqli_query($con, "Update globaloptions SET business_hours='".mysqli_real_escape_string($con, $business_hours)."', sunot='".mysqli_real_escape_string($con, $sunot)."', sunct='".mysqli_real_escape_string($con, $sunct)."', sunos='".mysqli_real_escape_string($con, $sunos)."', monot='".mysqli_real_escape_string($con, $monot)."', monct='".mysqli_real_escape_string($con, $monct)."', monos='".mysqli_real_escape_string($con, $monos)."', tueot='".mysqli_real_escape_string($con, $tueot)."', tuect='".mysqli_real_escape_string($con, $tuect)."', tueos='".mysqli_real_escape_string($con, $tueos)."', wedot='".mysqli_real_escape_string($con, $wedot)."', wedct='".mysqli_real_escape_string($con, $wedct)."', wedos='".mysqli_real_escape_string($con, $wedos)."', thuot='".mysqli_real_escape_string($con, $thuot)."', thuct='".mysqli_real_escape_string($con, $thuct)."', thuos='".mysqli_real_escape_string($con, $thuos)."', friot='".mysqli_real_escape_string($con, $friot)."', frict='".mysqli_real_escape_string($con, $frict)."', frios='".mysqli_real_escape_string($con, $frios)."', satot='".mysqli_real_escape_string($con, $satot)."', satct='".mysqli_real_escape_string($con, $satct)."', satos='".mysqli_real_escape_string($con, $satos)."' WHERE adminid= '".$admin_id."'")){
          $_SESSION['msg_succ'] = "Business hours updated successfully.";
          }else{
              $_SESSION['msg_error'] = "Business hours could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
          }
      }

   if(isset($_POST['profileimage']))
   {

   $profile_image = $_POST['profile_image'];
   $profileimagevalue = $_POST['profileimage'];

          if(mysqli_query($con, "Update globaloptions SET  profileimage_overide='".mysqli_real_escape_string($con, $profile_image)."', profileimage='".mysqli_real_escape_string($con, $profileimagevalue)."' WHERE adminid= '".$admin_id."'"))
          {
                  $_SESSION['msg_succ'] = "Profile Image updated successfully.";
          }else{

              $_SESSION['msg_error'] = "Profile Image could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
          }
   }

      if(isset($_POST['page_content_submit']))
      {

     	$pagetitle = $_POST['pagetitle'];
   $pagecontent = $_POST['pagecontent'];
   $page_content = $_POST['page_content'];
          if(mysqli_query($con, "Update globaloptions SET  page_content='".mysqli_real_escape_string($con, trim($page_content))."', pagetitle='".trim(mysqli_real_escape_string($con, $pagetitle))."', pagecontent='".trim(mysqli_real_escape_string($con, $pagecontent))."' WHERE adminid= '".$admin_id."'"))
          {
               $_SESSION['msg_succ'] = "Page content updated successfully.";
          }else{
              $_SESSION['msg_error'] = "Page content could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
          }
      }

      if(isset($_POST['analytic_content_submit']))
      {

   $analytic = $_POST['analytic'];
   $analytic_default = $_POST['analytic_default'];
          if(mysqli_query($con, "Update globaloptions SET  analytic='".mysqli_real_escape_string($con, $analytic)."', analytic_default='".mysqli_real_escape_string($con, $analytic_default)."' WHERE adminid= '".$admin_id."'"))
          {
               $_SESSION['msg_succ'] = "Analytic content updated successfully.";
          }else{
              $_SESSION['msg_error'] = "Analytic content could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
          }
      }


      if(isset($_POST['trust_badge_submit']))
      {
          $uploadimage = $_POST['uploadimage'];
   foreach($uploadimage as $value){
   	$badgeuploadimage[] = $value;
   }
   $badgeimage = implode(' &&*&& ', $badgeuploadimage);

   $trustwebsitelink = $_POST['trustwebsitelink'];
   foreach($trustwebsitelink as $value){
   	$trustwebsitelinkval[] = $value;
   }
   $trustwebsitelinkval = implode(' &&*&& ', $trustwebsitelinkval);
   $trust_badges = $_POST['trust_badges'];
          if(mysqli_query($con, "Update globaloptions SET trust_badges='".mysqli_real_escape_string($con, $trust_badges)."', uploadimage='".mysqli_real_escape_string($con, $badgeimage)."',trustwebsitelink='".mysqli_real_escape_string($con, $trustwebsitelinkval)."' WHERE adminid= '".$admin_id."'"))
          {
                 $_SESSION['msg_succ'] = "Trust Badges updated successfully.";
          }else{
                    $_SESSION['msg_error'] = "Trust Badges could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
               }
      }

   if(isset($_POST['trust_text_submit']))
          {
                $trusttext = $_POST['trusttext'];
         $trusttextoveride = $_POST['trust_text'];
                if(mysqli_query($con, "Update globaloptions SET  trusttextoveride='".mysqli_real_escape_string($con, $trusttextoveride)."',trusttext='".mysqli_real_escape_string($con, $trusttext)."' WHERE adminid= '".$admin_id."'"))
                {
                      $_SESSION['msg_succ'] = "Trust text updated successfully.";
                }else{
                    $_SESSION['msg_error'] = "Trust text could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
                }
          }
          if(isset($_POST['contact_formemail_submit']))
          {
				$emailmessageid = json_encode($_POST['emailmesageid']);
				$emailmessageidoveride = $_POST['overideemail'];
				if(mysqli_query($con, "Update globaloptions SET emailmessageidoveride='".mysqli_real_escape_string($con, $emailmessageidoveride)."', emailmessageid='".mysqli_real_escape_string($con, $emailmessageid)."' WHERE adminid= '".$admin_id."'")){
					$_SESSION['msg_succ'] = "Contact form email updated successfully.";
				}
				else{
					$_SESSION['msg_error'] = "Review options could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
         		}
          }

        if(isset($_POST['update_reviewbtn']))
        {
   $buttontitle = $_POST['buttontitle'];
   foreach($buttontitle as $value){
   	$buttontitlevalue[] = $value;
   }
   $buttontitlevalue = implode(' &&*&& ', $buttontitlevalue);

   $buttonlink = $_POST['buttonlink'];
   foreach($buttonlink as $value) {
   	$buttonlinkvalue[] = $value;
   }
   $buttonlinkvalue = implode(' &&*&& ', $buttonlinkvalue);

   $review_us = $_POST['review_us'];

          if(mysqli_query($con, "Update globaloptions SET review_us='".mysqli_real_escape_string($con, $review_us)."', buttontitle='".mysqli_real_escape_string($con, $buttontitlevalue)."', buttonlink='".mysqli_real_escape_string($con, $buttonlinkvalue)."' WHERE adminid= '".$admin_id."'"))
          {
                $_SESSION['msg_succ'] = "Review options updated successfully.";
          }else{
              $_SESSION['msg_error'] = "Review options could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";

          }
        }
            if(isset($_POST['update_customreviews']))
        {

   $uploadprofileimage = $_POST['uploadprofileimage'];
   foreach($uploadprofileimage as $value) {
   	$uploadprofileimagevalue[] = $value;
   }
   $uploadprofileimagevalue = implode(' &&*&& ', $uploadprofileimagevalue);

   $reviewername = $_POST['reviewername'];
   foreach($reviewername as $value) {
   	$reviewernamevalue[] = $value;
   }
   $reviewernamevalue = implode(' &&*&& ', $reviewernamevalue);

   $reviewsite = $_POST['reviewsite'];
   foreach($reviewsite as $value) {
   	$reviewsitevalue[] = $value;
   }
   $reviewsitevalue = implode(' &&*&& ', $reviewsitevalue);

   $rating = $_POST['rating'];
   foreach($rating as $value) {
   	$ratingvalue[] = $value;
   }
   $ratingvalue = implode(' &&*&& ', $ratingvalue);

   $review = $_POST['review'];
   foreach($review as $value) {
   	$reviewvalue[] = $value;
   }
   $reviewvalue = implode(' &&*&& ', $reviewvalue);
   $custom_reviews = $_POST['custom_reviews'];

          if(mysqli_query($con, "Update globaloptions SET  uploadprofileimage='".mysqli_real_escape_string($con, $uploadprofileimagevalue)."', reviewername='".mysqli_real_escape_string($con, $reviewernamevalue)."', reviewsite='".mysqli_real_escape_string($con, $reviewsitevalue)."', rating='".mysqli_real_escape_string($con, $ratingvalue)."', review='".mysqli_real_escape_string($con, $reviewvalue)."', custom_reviews='".mysqli_real_escape_string($con, $custom_reviews)."' WHERE adminid= '".$admin_id."'"))
          {
                $_SESSION['msg_succ'] = "Custom reviews services updated successfully.";
          }else{
              $_SESSION['msg_error'] = "Custom reviews could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";

          }
        }
//         if(isset($_POST['update_paymentsaccepted']))
//         {

//   $americanexpress = (isset($_POST['americanexpress'])) ? $_POST['americanexpress'] : '' ;
//   $discover = (isset($_POST['discover'])) ? $_POST['discover'] : '';
//   $applepay = (isset($_POST['applepay'])) ? $_POST['applepay'] : '';
//   $paypal = 	(isset($_POST['paypal'])) ? $_POST['paypal'] : '';
//   $creditcard = (isset($_POST['creditcard'])) ? $_POST['creditcard'] : '';
//   $google = (isset($_POST['google'])) ? $_POST['google'] : '';
//   $mastercard = (isset( $_POST['mastercard'])) ? $_POST['mastercard'] : '';
//   $cash = (isset($_POST['cash'])) ? $_POST['cash'] : '';
//   $visa = (isset($_POST['visa'])) ? $_POST['visa'] : '';
//   $payments_accepted = (isset($_POST['payments_accepted'])) ? $_POST['payments_accepted'] : '';

//           if(mysqli_query($con, "Update globaloptions SET americanexpress='".mysqli_real_escape_string($con, $americanexpress)."', discover='".mysqli_real_escape_string($con, $discover)."', applepay='".mysqli_real_escape_string($con, $applepay)."', paypal='".mysqli_real_escape_string($con, $paypal)."', creditcard='".mysqli_real_escape_string($con, $creditcard)."', google='".mysqli_real_escape_string($con, $google)."', mastercard='".mysqli_real_escape_string($con, $mastercard)."', cash='".mysqli_real_escape_string($con, $cash)."', visa='".mysqli_real_escape_string($con, $visa)."' WHERE adminid= '".$admin_id."'"))
//           {
//               $_SESSION['msg_succ'] = "Payment options updated successfully.";

//           }else{
//                   $_SESSION['msg_error'] = "Payment options not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";

//           }
//         }

        if(isset($_POST['update_coupons']))
        {
   $uploadcimage = $_POST['uploadcoupanimage'];
   foreach($uploadcimage as $value) {
   	$uploadcoupanimage[] = $value;
   }
   $uploadcoupanimage = implode(' &&*&& ', $uploadcoupanimage);

   $coupontitle = $_POST['coupontitle'];
   foreach($coupontitle as $value) {
   	$coupontitlevalue[] = $value;
   }
   $coupontitlevalue = implode(' &&*&& ', $coupontitlevalue);

   $coupantext = $_POST['coupantext'];
   foreach($coupantext as $value) {
   	$coupantextvalue[] = $value;
   }
   $coupantextvalue = implode(' &&*&& ', $coupantextvalue);

   $coupanlink = $_POST['coupanlink'];
   foreach($coupanlink as $value) {
   	$coupanlinkvalue[] = $value;
   }
   $coupanlinkvalue = implode(' &&*&& ', $coupanlinkvalue);
   $add_coupon = $_POST['add_coupon'];
          if(mysqli_query($con, "Update globaloptions SET uploadcoupanimage='".mysqli_real_escape_string($con, $uploadcoupanimage)."',add_coupon='".mysqli_real_escape_string($con, $add_coupon)."', coupontitle='".mysqli_real_escape_string($con, $coupontitlevalue)."', coupantext='".mysqli_real_escape_string($con, $coupantextvalue)."', coupanlink='".mysqli_real_escape_string($con, $coupanlinkvalue)."' WHERE adminid= '".$admin_id."'"))
          {
              $_SESSION['msg_succ'] = "Coupon updated successfully.";

          }else{
                  $_SESSION['msg_error'] = "Coupon could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";

          }

        }
        if(isset($_POST['update_default_services']))
        {
   $addserviceglobal = $_POST['addservice'];
   foreach($addserviceglobal as $value){
   	 $addservicevalueglobal[] = $value;
   	}
   $addservicevalueglobal = implode(' &&*&& ', $addservicevalueglobal);
   $servicesoveride = $_POST['defaultservices'];
          if(mysqli_query($con, "Update globaloptions SET services='".mysqli_real_escape_string($con, $addservicevalueglobal)."', serviceoveride='".mysqli_real_escape_string($con, $servicesoveride)."' WHERE adminid= '".$admin_id."'"))
          {
               $_SESSION['msg_succ'] = "Default services updated successfully.";

          }else{
              $_SESSION['msg_error'] = "Defaultoptions could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";

          }

        }

        if(isset($_POST['title_tags'])) {

           $title_tags=$_POST['title_tags'];
           $title_tags_override=$_POST['title_tags_override'];
           if(mysqli_query($con, "Update globaloptions SET title_tags='".mysqli_real_escape_string($con, $title_tags)."', title_tags_override='".mysqli_real_escape_string($con, $title_tags_override)."' WHERE adminid= '".$admin_id."'"))
           {
                $_SESSION['msg_succ'] = "Title for the selected business has been updated successfully.";
           }else{
               $_SESSION['msg_error'] = "Title could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
           }

   }

   if(isset($_POST['canonical_url'])) {

           $canonical_url=$_POST['canonical_url'];
           if(mysqli_query($con, "Update globaloptions SET canonical_url='".mysqli_real_escape_string($con, $canonical_url)."' WHERE adminid= '".$admin_id."'"))
           {
                $_SESSION['msg_succ'] = "Canonical url for the selected business has been updated successfully.";
           }else{
               $_SESSION['msg_error'] = "Canonical url could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
           }

   }

           $page_layout = $_POST['page_layout'];
    $module_position = $_POST['module_position'];
           mysqli_query($con, "Update globaloptions SET page_layout='".mysqli_real_escape_string($con, $page_layout)."', module_position='".mysqli_real_escape_string($con, $module_position)."'  WHERE adminid= '".$admin_id."'");
            if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions.php');
   	}
          /*	if(mysqli_query($con, "Update globaloptions SET business_hours='".mysqli_real_escape_string($con, $business_hours)."', profileimage_overide='".mysqli_real_escape_string($con, $profile_image)."', trust_badges='".mysqli_real_escape_string($con, $trust_badges)."', review_us='".mysqli_real_escape_string($con, $review_us)."', custom_reviews='".mysqli_real_escape_string($con, $custom_reviews)."', payments_accepted='".mysqli_real_escape_string($con, $payments_accepted)."', add_coupon='".mysqli_real_escape_string($con, $add_coupon)."', page_layout='".mysqli_real_escape_string($con, $page_layout)."', page_content='".mysqli_real_escape_string($con, $page_content)."', module_position='".mysqli_real_escape_string($con, $module_position)."', sunot='".mysqli_real_escape_string($con, $sunot)."', sunct='".mysqli_real_escape_string($con, $sunct)."', sunos='".mysqli_real_escape_string($con, $sunos)."', monot='".mysqli_real_escape_string($con, $monot)."', monct='".mysqli_real_escape_string($con, $monct)."', monos='".mysqli_real_escape_string($con, $monos)."', tueot='".mysqli_real_escape_string($con, $tueot)."', tuect='".mysqli_real_escape_string($con, $tuect)."', tueos='".mysqli_real_escape_string($con, $tueos)."', wedot='".mysqli_real_escape_string($con, $wedot)."', wedct='".mysqli_real_escape_string($con, $wedct)."', wedos='".mysqli_real_escape_string($con, $wedos)."', thuot='".mysqli_real_escape_string($con, $thuot)."', thuct='".mysqli_real_escape_string($con, $thuct)."', thuos='".mysqli_real_escape_string($con, $thuos)."', friot='".mysqli_real_escape_string($con, $friot)."', frict='".mysqli_real_escape_string($con, $frict)."', frios='".mysqli_real_escape_string($con, $frios)."', satot='".mysqli_real_escape_string($con, $satot)."', satct='".mysqli_real_escape_string($con, $satct)."', satos='".mysqli_real_escape_string($con, $satos)."', profileimage='".mysqli_real_escape_string($con, $profileimagevalue)."', pagetitle='".mysqli_real_escape_string($con, $pagetitle)."', pagecontent='".mysqli_real_escape_string($con, $pagecontent)."', uploadimage='".mysqli_real_escape_string($con, $badgeimage)."', trusttextoveride='".mysqli_real_escape_string($con, $trusttextoveride)."', emailmessageidoveride='".mysqli_real_escape_string($con, $emailmessageidoveride)."', emailmessageid='".mysqli_real_escape_string($con, $emailmessageid)."', trusttext='".mysqli_real_escape_string($con, $trusttext)."', trustwebsitelink='".mysqli_real_escape_string($con, $trustwebsitelinkval)."', buttontitle='".mysqli_real_escape_string($con, $buttontitlevalue)."', buttonlink='".mysqli_real_escape_string($con, $buttonlinkvalue)."', uploadprofileimage='".mysqli_real_escape_string($con, $uploadprofileimagevalue)."', reviewername='".mysqli_real_escape_string($con, $reviewernamevalue)."', reviewsite='".mysqli_real_escape_string($con, $reviewsitevalue)."', rating='".mysqli_real_escape_string($con, $ratingvalue)."', review='".mysqli_real_escape_string($con, $reviewvalue)."', americanexpress='".mysqli_real_escape_string($con, $americanexpress)."', discover='".mysqli_real_escape_string($con, $discover)."', applepay='".mysqli_real_escape_string($con, $applepay)."', paypal='".mysqli_real_escape_string($con, $paypal)."', creditcard='".mysqli_real_escape_string($con, $creditcard)."', google='".mysqli_real_escape_string($con, $google)."', mastercard='".mysqli_real_escape_string($con, $mastercard)."', cash='".mysqli_real_escape_string($con, $cash)."', visa='".mysqli_real_escape_string($con, $visa)."', uploadcoupanimage='".mysqli_real_escape_string($con, $uploadcoupanimage)."', coupontitle='".mysqli_real_escape_string($con, $coupontitlevalue)."', coupantext='".mysqli_real_escape_string($con, $coupantextvalue)."', coupanlink='".mysqli_real_escape_string($con, $coupanlinkvalue)."', services='".mysqli_real_escape_string($con, $addservicevalueglobal)."', serviceoveride='".mysqli_real_escape_string($con, $servicesoveride)."' WHERE adminid= '".$admin_id."'")) {
   	$_SESSION['msg_succ'] = "Globaloptions updated successfully.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions');
   	}
   } else {
   	//$_SESSION['msg_error'] = mysqli_error($con);
   	$_SESSION['msg_error'] = "Globaloptions could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions');
   	}
   } */
   } elseif(isset($_POST["updateLocation"])) 
   {
        // print_r($_POST['locUrl']);
        // die('here');
        $emailmesageid = json_encode($_POST['emailmesageid']);
       //$_POST = array_map("trim", $_POST);
   		$id_location = $_POST['id_loc'];
   		$admin_id = $_POST['adminid'];
   		$name = $_POST['name'];
   		$address = $_POST['address'];
   		if(isset($_POST['addressshow'])) {
   			$addressshow = 1;
   		}else{
   			$addressshow = 0;
   		}
   		$suite = $_POST['suite'];
		$locUrl = $_POST['locUrl'];
		$common_served_area = $_POST['common_served_area'];
		//locationurl table id from which url is fetched
		$locationUrl_tblId=$_POST['locationUrl_tblId'];
   		$city = $_POST['city'];
   		$state = $_POST['state'];

   		$slug = trim(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', str_replace(' ', '-', $city))), "-");

   		$slugquery = mysqli_query($con, "SELECT COUNT(*) AS slugcount FROM markers WHERE adminid='".$admin_id."' AND id < '".$id_location."' AND slug LIKE '$slug%'");
   		$slugrow = $slugquery->fetch_assoc();
   		$slugcount = $slugrow['slugcount'];

   		if($slugcount > 0) {
   			$slugnewquery=mysqli_query($con, "SELECT slug FROM markers WHERE adminid='".$admin_id."' AND id < '".$id_location."' AND slug LIKE '$slug%'");
   			while($slugdata = mysqli_fetch_array($slugnewquery)){
   				$slugdatanum = $slugdata["slug"];
   			}
			/*
   			$slugnum = explode("-", $slugdatanum);
   			$slugnumval = end($slugnum);
   			$slug = $slug.'-'.($slugnumval + 1);

			*/

			$slugnum = explode("-", $slugdatanum);
			$slugnumval = end($slugnum);   
			
			// Ensure $slugnumval is treated as an integer
			$slugnumval = intval($slugnumval);
			
			$slug = $slug . '-' . ($slugnumval + 1);


   		}

   		$zipcode = $_POST['zipcode'];
   		$lat = $_POST['lat'];
   		$lng = $_POST['lng'];
   		$phone = $_POST['phone'];
   		$phone = preg_replace('/\D+/', '', $phone);
	   //$emailmesageid = json_encode($_POST['emailmesageid']);

   		/*$sunot = $_POST['sunot'];
   		$sunct = $_POST['sunct'];
   		$sunos = isset($_POST['sunos']) ? $_POST['sunos'] : false;
   		$monot = $_POST['monot'];
   		$monct = $_POST['monct'];
   		$monos = isset($_POST['monos']) ? $_POST['monos'] : false;
   		$tueot = $_POST['tueot'];
   		$tuect = $_POST['tuect'];
   		$tueos = isset($_POST['tueos']) ? $_POST['tueos'] : false;
   		$wedot = $_POST['wedot'];
   		$wedct = $_POST['wedct'];
   		$wedos = isset($_POST['wedos']) ? $_POST['wedos'] : false;
   		$thuot = $_POST['thuot'];
   		$thuct = $_POST['thuct'];
   		$thuos = isset($_POST['thuos']) ? $_POST['thuos'] : false;
   		$friot = $_POST['friot'];
   		$frict = $_POST['frict'];
   		$frios = isset($_POST['frios']) ? $_POST['frios'] : false;
   		$satot = $_POST['satot'];
   		$satct = $_POST['satct'];
   		$satos = isset($_POST['satos']) ? $_POST['satos'] : false;
   		$profileimage = $_POST['profileimage'];
   		$pagetitle = $_POST['pagetitle'];
   		$pagecontent = $_POST['pagecontent'];

   		$uploadimage = $_POST['uploadimage'];
   		foreach($uploadimage as $value){
   			$badgeuploadimage[] = $value;
   			}
   		$badgeimage = implode(' &&*&& ', $badgeuploadimage);

   		$trustwebsitelink = $_POST['trustwebsitelink'];
   		foreach($trustwebsitelink as $value){
   			$trustwebsitelinkval[] = $value;
   			}
   		$trustwebsitelinkval = implode(' &&*&& ', $trustwebsitelinkval);

   		$trusttext = $_POST['trusttext'];

   		$buttontitle = $_POST['buttontitle'];
   		foreach($buttontitle as $value){
   			$buttontitlevalue[] = $value;
   		}

   		$buttontitlevalue = implode(' &&*&& ', $buttontitlevalue);

   		$buttonlink = $_POST['buttonlink'];
   		foreach($buttonlink as $value) {
   			$buttonlinkvalue[] = $value;
   		}
   		$buttonlinkvalue = implode(' &&*&& ', $buttonlinkvalue);

   		$uploadpimage = $_POST['uploadprofileimage'];
   		foreach($uploadpimage as $value) {
   			$uploadprofileimagevalue[] = $value;
   		}
   		$uploadprofileimagevalue = implode(' &&*&& ', $uploadprofileimagevalue);

   		$reviewername = $_POST['reviewername'];
   		foreach($reviewername as $value) {
   			$reviewernamevalue[] = $value;
   		}
   		$reviewernamevalue = implode(' &&*&& ', $reviewernamevalue);

   		$reviewsite = $_POST['reviewsite'];
   		foreach($reviewsite as $value) {
   			$reviewsitevalue[] = $value;
   		}
   		$reviewsitevalue = implode(' &&*&& ', $reviewsitevalue);

   		$rating = $_POST['rating'];
   		foreach($rating as $value) {
   			$ratingvalue[] = $value;
   		}
   		$ratingvalue = implode(' &&*&& ', $ratingvalue);

   		$review = $_POST['review'];
   		foreach($review as $value) {
   			$reviewvalue[] = $value;
   		}
   		$reviewvalue = implode(' &&*&& ', $reviewvalue);
   		$reviewvalue_review = $reviewvalue;


   $americanexpress = (isset($_POST['americanexpress'])) ? $_POST['americanexpress'] : '' ;
   $discover = (isset($_POST['discover'])) ? $_POST['discover'] : '';
   $applepay = (isset($_POST['applepay'])) ? $_POST['applepay'] : '';
   $paypal = 	(isset($_POST['paypal'])) ? $_POST['paypal'] : '';
   $creditcard = (isset($_POST['creditcard'])) ? $_POST['creditcard'] : '';
   $google = (isset($_POST['google'])) ? $_POST['google'] : '';
   $mastercard = (isset( $_POST['mastercard'])) ? $_POST['mastercard'] : '';
   $cash = (isset($_POST['cash'])) ? $_POST['cash'] : '';
   $visa = (isset($_POST['visa'])) ? $_POST['visa'] : '';
   $payments_accepted = (isset($_POST['payments_accepted'])) ? $_POST['payments_accepted'] : '';
   		$uploadcimage = $_POST['uploadcoupanimage'];
   		foreach($uploadcimage as $value) {
   			$uploadcoupanimage[] = $value;
   		}
   		$uploadcoupanimage = implode(' &&*&& ', $uploadcoupanimage);

   		$coupontitle = $_POST['coupontitle'];

   		foreach($coupontitle as $value) {
   			$coupontitlevalue[] = $value;
   		}

   		$coupontitlevalue = implode(' &&*&& ', $coupontitlevalue);

   		$coupantext = $_POST['coupantext'];
   		foreach($coupantext as $value) {
   			$coupantextvalue[] = $value;
   		}
   		$coupantextvalue = implode(' &&*&& ', $coupantextvalue);
   		$coupantextvalue_text = $coupantextvalue;

   		$coupanlink = $_POST['coupanlink'];
   		foreach($coupanlink as $value) {
   			$coupanlinkvalue[] = $value;
   		}
   		$coupanlinkvalue = implode(' &&*&& ', $coupanlinkvalue);

   		$addservice = $_POST['addservice'];
   		foreach($addservice as $value){
   			$addservicevalue[] = $value;

   			}
   		$addservicevalue = implode(' &&*&& ', $addservicevalue);

   		$addservicelink = $_POST['addservicelink'];
   		foreach($addservicelink as $value){
   			$addservicelinkvalue[] = $value;

   			}
   		$addservicelinkvalue = implode(' &&*&& ', $addservicelinkvalue);

   		$extra_zipcodevalue='';
		   */
   		/*for extra zipcode*/
   	/*	if(isset($_POST['extra_zipcode'])):
   			$extra_zipcode = $_POST['extra_zipcode'];
   			foreach($extra_zipcode as $value){
   				$extra_zipcodevalue[] = $value;
   				}
   			$extra_zipcodevalue = implode(' &&*&& ', $extra_zipcodevalue);
   		endif;

   		$extra_zipcode_linkvalue='';

   		if(isset($_POST['extra_zipcode_link'])):
   			$extra_zipcode_link = $_POST['extra_zipcode_link'];
   			foreach($extra_zipcode_link as $value){
   				$extra_zipcode_linkvalue[] = $value;
   				}
   			$extra_zipcode_linkvalue = implode(' &&*&& ', $extra_zipcode_linkvalue);
   		endif;



   		$title_tag = $_POST['title_tag'];
   		$meta_desc = $_POST['meta_desc'];
   		$review_script = $_POST['review_script'];
   		$customreview_star = $_POST['customreview_star'];
   		$customfeaturereview = $_POST['customfeaturereview'];
   		$customreview_script = $_POST['customreview_script'];
   	 */
   		if( (isset($_POST['addchild']) && $_POST['addchild']==1) && $suite!=''){
   			$childL = $_POST['childL'];
   				foreach($childL as $value){
   					$childLvalue[] = $value;
   				}
   			$childLvalue = implode(' &&*&& ', $childLvalue);
   			if($childLvalue==''){
   				$checkChild = 0;
   			}else{
   				$checkChild = $_POST['addchild'];
   			}

   		}else{
   			$childLvalue='';
   			$checkChild=0;
   		}


   	$additionalAddressHide = array();
   	if(isset($_POST['extraAddress']) && ($_POST['extraAddress']==1)){

   		$additionalAddressHide = $_POST['additionaladdressshow'];
   		foreach($additionalAddressHide as $value){
   			 $additionalAddressHidevalue[] = $value;
   			}
   		$additionalAddressHidevalue = implode(' &&*&& ', $additionalAddressHidevalue);



   		$additionaladdress = $_POST['additionaladdress'];
   		foreach($additionaladdress as $value){
   			 $additionaladdressvalue[] = $value;
   			}
   		$additionaladdressvalue = implode(' &&*&& ', $additionaladdressvalue);



   		$additionalcity = $_POST['additionalcity'];
   		foreach($additionalcity as $value){
   			 $additionalcityvalue[] = $value;
   			}
   		$additionalcityvalue = implode(' &&*&& ', $additionalcityvalue);

   		$additionalstate = $_POST['additionalstate'];
   		foreach($additionalstate as $value){
   			 $additionalstatevalue[] = $value;
   			}
   		$additionalstatevalue = implode(' &&*&& ', $additionalstatevalue);

   		$additionalzipcode = $_POST['additionalzipcode'];
   		foreach($additionalzipcode as $value){
   			 $additionalzipcodevalue[] = $value;
   			}
   		$additionalzipcodevalue = implode(' &&*&& ', $additionalzipcodevalue);

   		$additionalphone = $_POST['additionalphone'];
   		foreach($additionalphone as $value){
   			 $additionalphonevalue[] = $value;
   			}
   		$additionalphonevalue = implode(' &&*&& ', $additionalphonevalue);




   		if($additionaladdressvalue==''){
   			$checkaddress = 0;
   		}else{
   			$checkaddress = $_POST['extraAddress'];
   		}

   	}else{
   		$additionaladdressvalue='';
   		$checkaddress=0;
   	}

   /*********************************Code for additional address END************************************/

   		/*if(mysqli_query($con, "Update markers set name='".mysqli_real_escape_string($con, $name)."',common_served_area='".mysqli_real_escape_string($con, $common_served_area)."', address='".mysqli_real_escape_string($con, $address)."', child_check='".mysqli_real_escape_string($con, $checkChild)."', suite='".mysqli_real_escape_string($con, $suite)."', city='".mysqli_real_escape_string($con, $city)."', state='".mysqli_real_escape_string($con, $state)."', zipcode='".mysqli_real_escape_string($con, $zipcode)."', lat='".mysqli_real_escape_string($con, $lat)."', lng='".mysqli_real_escape_string($con, $lng)."', phone='".mysqli_real_escape_string($con, $phone)."', sunot='".mysqli_real_escape_string($con, $sunot)."', sunct='".mysqli_real_escape_string($con, $sunct)."', sunos='".mysqli_real_escape_string($con, $sunos)."', monot='".mysqli_real_escape_string($con, $monot)."', monct='".mysqli_real_escape_string($con, $monct)."', monos='".mysqli_real_escape_string($con, $monos)."', tueot='".mysqli_real_escape_string($con, $tueot)."', tuect='".mysqli_real_escape_string($con, $tuect)."', tueos='".mysqli_real_escape_string($con, $tueos)."', wedot='".mysqli_real_escape_string($con, $wedot)."', wedct='".mysqli_real_escape_string($con, $wedct)."', wedos='".mysqli_real_escape_string($con, $wedos)."', thuot='".mysqli_real_escape_string($con, $thuot)."', thuct='".mysqli_real_escape_string($con, $thuct)."', thuos='".mysqli_real_escape_string($con, $thuos)."', friot='".mysqli_real_escape_string($con, $friot)."', frict='".mysqli_real_escape_string($con, $frict)."', frios='".mysqli_real_escape_string($con, $frios)."', satot='".mysqli_real_escape_string($con, $satot)."', satct='".mysqli_real_escape_string($con, $satct)."', satos='".mysqli_real_escape_string($con, $satos)."', profileimage='".mysqli_real_escape_string($con, $profileimage)."', pagetitle='".mysqli_real_escape_string($con, $pagetitle)."', pagecontent='".mysqli_real_escape_string($con, $pagecontent)."', uploadimage='".mysqli_real_escape_string($con, $badgeimage)."', trusttext='".mysqli_real_escape_string($con, $trusttext)."', trustwebsitelink='".mysqli_real_escape_string($con, $trustwebsitelinkval)."', emailmesageid='".mysqli_real_escape_string($con, $emailmesageid)."', buttontitle='".mysqli_real_escape_string($con, $buttontitlevalue)."', buttonlink='".mysqli_real_escape_string($con, $buttonlinkvalue)."', uploadprofileimage='".mysqli_real_escape_string($con, $uploadprofileimagevalue)."', reviewername='".mysqli_real_escape_string($con, $reviewernamevalue)."', reviewsite='".mysqli_real_escape_string($con, $reviewsitevalue)."', rating='".mysqli_real_escape_string($con, $ratingvalue)."', review='".mysqli_real_escape_string($con, $reviewvalue_review)."', americanexpress='".mysqli_real_escape_string($con, $americanexpress)."', discover='".mysqli_real_escape_string($con, $discover)."', applepay='".mysqli_real_escape_string($con, $applepay)."', paypal='".mysqli_real_escape_string($con, $paypal)."', creditcard='".mysqli_real_escape_string($con, $creditcard)."', google='".mysqli_real_escape_string($con, $google)."', mastercard='".mysqli_real_escape_string($con, $mastercard)."', cash='".mysqli_real_escape_string($con, $cash)."', visa='".mysqli_real_escape_string($con, $visa)."', uploadcoupanimage='".mysqli_real_escape_string($con, $uploadcoupanimage)."', coupontitle='".mysqli_real_escape_string($con, $coupontitlevalue)."', coupantext='".mysqli_real_escape_string($con, $coupantextvalue_text)."', coupanlink='".mysqli_real_escape_string($con, $coupanlinkvalue)."', services='".mysqli_real_escape_string($con, $addservicevalue)."', slug='".mysqli_real_escape_string($con, $slug)."', serviceslink='".mysqli_real_escape_string($con, $addservicelinkvalue)."', title_tag='".mysqli_real_escape_string($con, $title_tag)."', addressshow='".mysqli_real_escape_string($con, $addressshow)."', extra_zipcode='".mysqli_real_escape_string($con, $extra_zipcodevalue)."', extra_zipcode_link='".mysqli_real_escape_string($con, $extra_zipcode_linkvalue)."', meta_desc='".mysqli_real_escape_string($con, $meta_desc)."', review_script='".mysqli_real_escape_string($con, $review_script)."',
   		custom_reviewstar='".mysqli_real_escape_string($con, $customreview_star)."', custom_featurereview='".mysqli_real_escape_string($con, $customfeaturereview)."', custom_reviewscript='".mysqli_real_escape_string($con, $customreview_script)."',
   		address_check='".mysqli_real_escape_string($con, $checkaddress)."' WHERE id= '$id_location'")) */
		if(mysqli_query($con, "Update markers set name='".mysqli_real_escape_string($con, $name)."',common_served_area='".mysqli_real_escape_string($con, $common_served_area)."', address='".mysqli_real_escape_string($con, $address)."', child_check='".mysqli_real_escape_string($con, $checkChild)."', suite='".mysqli_real_escape_string($con, $suite)."', city='".mysqli_real_escape_string($con, $city)."', state='".mysqli_real_escape_string($con, $state)."', zipcode='".mysqli_real_escape_string($con, $zipcode)."', lat='".mysqli_real_escape_string($con, $lat)."', lng='".mysqli_real_escape_string($con, $lng)."', phone='".mysqli_real_escape_string($con, $phone)."', sunot='".mysqli_real_escape_string($con, '')."', sunct='".mysqli_real_escape_string($con, '')."', sunos='".mysqli_real_escape_string($con, '')."', monot='".mysqli_real_escape_string($con,  '')."', monct='".mysqli_real_escape_string($con,  '')."', monos='".mysqli_real_escape_string($con, '')."', tueot='".mysqli_real_escape_string($con,  '')."', tuect='".mysqli_real_escape_string($con,'')."', tueos='".mysqli_real_escape_string($con, $tueos)."', wedot='".mysqli_real_escape_string($con, $wedot)."', wedct='".mysqli_real_escape_string($con, '')."', wedos='".mysqli_real_escape_string($con,  '')."', thuot='".mysqli_real_escape_string($con, '')."', thuct='".mysqli_real_escape_string($con, '')."', thuos='".mysqli_real_escape_string($con, '')."', friot='".mysqli_real_escape_string($con, '')."', frict='".mysqli_real_escape_string($con, '')."', frios='".mysqli_real_escape_string($con, '')."', satot='".mysqli_real_escape_string($con, '')."', satct='".mysqli_real_escape_string($con, '')."', satos='".mysqli_real_escape_string($con, '')."', profileimage='".mysqli_real_escape_string($con, '')."', pagetitle='".mysqli_real_escape_string($con, '')."', pagecontent='".mysqli_real_escape_string($con, '')."', uploadimage='".mysqli_real_escape_string($con, '')."', trusttext='".mysqli_real_escape_string($con, '')."', trustwebsitelink='".mysqli_real_escape_string($con, '')."', emailmesageid='".mysqli_real_escape_string($con, $emailmesageid)."', buttontitle='".mysqli_real_escape_string($con,'')."', buttonlink='".mysqli_real_escape_string($con,'')."', uploadprofileimage='".mysqli_real_escape_string($con,'')."', reviewername='".mysqli_real_escape_string($con, '')."', reviewsite='".mysqli_real_escape_string($con, '')."', rating='".mysqli_real_escape_string($con,'')."', review='".mysqli_real_escape_string($con,'')."', americanexpress='".mysqli_real_escape_string($con, '')."', discover='".mysqli_real_escape_string($con,'')."', applepay='".mysqli_real_escape_string($con,'')."', paypal='".mysqli_real_escape_string($con,'')."', creditcard='".mysqli_real_escape_string($con,'')."', google='".mysqli_real_escape_string($con, '')."', mastercard='".mysqli_real_escape_string($con,'')."', cash='".mysqli_real_escape_string($con,'')."', visa='".mysqli_real_escape_string($con,'')."', uploadcoupanimage='".mysqli_real_escape_string($con, '')."', coupontitle='".mysqli_real_escape_string($con,'')."', coupantext='".mysqli_real_escape_string($con,'')."', coupanlink='".mysqli_real_escape_string($con, '')."', services='".mysqli_real_escape_string($con,'')."', slug='".mysqli_real_escape_string($con, $slug)."', serviceslink='".mysqli_real_escape_string($con, '')."', title_tag='".mysqli_real_escape_string($con, '')."', addressshow='".mysqli_real_escape_string($con,  $addressshow)."', extra_zipcode='".mysqli_real_escape_string($con,'')."', extra_zipcode_link='".mysqli_real_escape_string($con,'')."', meta_desc='".mysqli_real_escape_string($con,'')."', review_script='".mysqli_real_escape_string($con, '')."',
	custom_reviewstar='".mysqli_real_escape_string($con, '')."', custom_featurereview='".mysqli_real_escape_string($con, '')."', custom_reviewscript='".mysqli_real_escape_string($con,'')."',
	address_check='".mysqli_real_escape_string($con, $checkaddress)."' WHERE id= '$id_location'")) {
// 			if($locUrl != Null){
            $lname=trim($name,"");
            if($admin_id == 50) //for restoration
                $locName=substr($lname,17);
            elseif($admin_id == 51) //for bluefrog
                $locName=substr($lname,28);
            elseif($admin_id == 52) //for tdc drivaway
                $locName=substr($lname,23);
                 elseif($admin_id == 53) //for tsoft roc
                $locName=$lname;
              $locName = trim($locName);
			    //locationsurl table url and parent_id
		        $updtsql="update locationsurl set location='".$locName."',url='".$locUrl."',parent_id=".$suite." where id=".$locationUrl_tblId;
			    mysqli_query($con,$updtsql);
// 			}
			$brAnd = fetch_brand($admin_id,$con);
   			//$lookupId = $_POST['lookupID'];

        //    echo"<pre>";
		//    print_r($_POST['id_loc']);
		//    echo"</pre>";

		   $locationidForSuit = $_POST['id_loc'];  
			if ($locationidForSuit != '') {
			
					// Sanitize user inputs
					$suite = mysqli_real_escape_string($con, $suite);
					$brAnd = intval($brAnd);

					// Create and execute the query
					$lookupQuery = "SELECT * FROM r1_parent_info_lookUp WHERE location_id = '$locationidForSuit' AND brand = $brAnd";
					$result = mysqli_query($con, $lookupQuery);
					
					
					if ($result) {
						// Fetch and print the data
						while ($row = mysqli_fetch_assoc($result)) {
							 $lookupId =  $row['location_id'];
													
						}  

						// Free the result set
						mysqli_free_result($result);
					} else {
						// Handle the error
						echo "Error: " . mysqli_error($con);
					}
					
				//die();
				/*
				$lookupQurey = "SELECT * FROM r1_parent_info_lookUp WHERE parent_license = $suite and brand = $brAnd";
				mysqli_query($con,$updtsql);
				//$parentLookup = mysqli_query($con, "SELECT * FROM r1_parent_info_lookUp WHERE parent_license = $suite and brand = $brAnd ");
				echo"<pre>";
				print_r(mysqli_query($con,$updtsql));
				echo"</pre>";
				die();
				if ($parentLookup &&  mysqli_num_rows($parentLookup) > 0) {
					$parentLookupfetch = mysqli_fetch_assoc($parentLookup);
					$lookupID = $parentLookupfetch['id'];
				}

				*/
				
			}  
			
		
			if($lookupId==''){
				
				//mysqli_query($con, "INSERT INTO r1_parent_info_lookUp (location_name, parent_license, location_id,brand) VALUES ('".mysqli_real_escape_string($con, $name)."',".$suite.",".$id_location.",".$brAnd.")");

				$query = "INSERT INTO r1_parent_info_lookUp (location_name, parent_license, location_id, brand) VALUES ('" . mysqli_real_escape_string($con, $name) . "', " . intval($suite) . ", " . intval($id_location) . ", " . intval($brAnd) . ")";
                mysqli_query($con, $query);

			}else{
				
				$checkzipSql = mysqli_query($con,"SELECT id from r1_parent_info_lookUp WHERE location_id= $lookupId and brand=$brAnd");
				if($checkzipSql &&  mysqli_num_rows($checkzipSql)>0 ){

                    if ($checkzipSql) {
						// Fetch the result as an associative array
						$row = mysqli_fetch_assoc($checkzipSql);
					
						// Check if a row was found
						if ($row) {
							// Access the 'id' value
							$idValue = $row['id'];
					
							// Print or use the ID as needed
							//echo "ID: " . $idValue;
						} else {
							echo "No rows found.";
						}
					
						// Free the result set
						mysqli_free_result($checkzipSql);
					} else {
						// Handle the error
						echo "Error: " . mysqli_error($con);
					}
					mysqli_query($con, "Update r1_parent_info_lookUp set location_name='".mysqli_real_escape_string($con, $name)."', parent_license='".mysqli_real_escape_string($con, $suite)."',location_id=".$id_location." WHERE id= $idValue and brand=$brAnd");
				}else{
					 
					mysqli_query($con, "INSERT INTO r1_parent_info_lookUp (location_name, parent_license, location_id,brand) VALUES ('".mysqli_real_escape_string($con, $name)."',".$suite.",".$id_location.",".$brAnd.")");
					
				}
			}
			$checkAddressSql = mysqli_query($con,"SELECT id from r1_additional_address WHERE loc_id= $id_location");
   				if(!empty($checkAddressSql) && mysqli_num_rows($checkAddressSql)>0 && $checkaddress==1)
   				{
   					mysqli_query($con, "Update r1_additional_address set eaddress='".mysqli_real_escape_string($con, $additionaladdressvalue)."', ephone='".mysqli_real_escape_string($con, $additionalphonevalue)."', eaddressshow='".mysqli_real_escape_string($con, $additionalAddressHidevalue)."', ecity='".mysqli_real_escape_string($con, $additionalcityvalue)."', estate='".mysqli_real_escape_string($con, $additionalstatevalue)."', ezipcode='".mysqli_real_escape_string($con, $additionalzipcodevalue)."' WHERE loc_id= $id_location");
   				}else if($checkaddress==1){
   					mysqli_query($con, "INSERT INTO r1_additional_address (loc_id, eaddress,eaddressshow,ecity,estate,ezipcode,ephone,ecreated_at,brand) VALUES (".$id_location.",'".mysqli_real_escape_string($con, $additionaladdressvalue)."','".mysqli_real_escape_string($con, $additionalAddressHidevalue)."','".mysqli_real_escape_string($con, $additionalcityvalue)."','".mysqli_real_escape_string($con, $additionalstatevalue)."','".mysqli_real_escape_string($con, $additionalzipcodevalue)."','".mysqli_real_escape_string($con, $additionalphonevalue)."',NOW(),".$brAnd.")");
   				}

   				if($checkaddress==0 && (!empty($checkAddressSql) && mysqli_num_rows($checkAddressSql)>0)){
   					$sq=mysqli_query($con,"DELETE from r1_additional_address WHERE loc_id=".$id_location);
   				}


   				if($checkChild==1 && $childLvalue!=''){
   					$sq=mysqli_query($con,"DELETE from r1_parent_license_lookUp WHERE brand=".$brAnd." AND Parent_Licence=".$_POST['delaypurpose']);
   					foreach($_POST['childL'] as $value){
   						mysqli_query($con, "INSERT INTO r1_parent_license_lookUp (Parent_Licence, Child_License,brand) VALUES (".$suite.",".mysqli_real_escape_string($con, $value).",".$brAnd.")");
   					}
   				}else{
   					$sq=mysqli_query($con,"DELETE from r1_parent_license_lookUp WHERE brand=".$brAnd." AND Parent_Licence=".$_POST['delaypurpose']);
   				}

   			$_SESSION['msg_succ'] = "Location updated successfully.";
   			if($role == 'superadmin' ){
   				header('location:../locationsedit.php?adminid='.$admin_id.'&locationid='.$id_location);
   			} else {
   				header('location:../locationsedit.php?locationid='.$id_location);
   			}
   		} else {
   			//$_SESSION['msg_error'] = mysqli_error($con);
   			$_SESSION['msg_error'] = "Location could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   			header('location:../locationsedit.php?locationid='.$id_location);
   		}
   } elseif(isset($_POST['send_date'])){
   $festname1 = $_POST['festname'];
          $date =  $_POST['date'];
          $new_date = date('Y-m-d', strtotime($date));

   $fetch = mysqli_query($con, "SELECT festname FROM businessholidays WHERE festname='".$festname1."' && adminid='".$admin_id."'");
   $fetch_arry = mysqli_num_rows($fetch);
   $fetch_date = mysqli_query($con, "SELECT holiday_date FROM businessholidays WHERE holiday_date='".$new_date."' && adminid='".$admin_id."'");
   $fetch_arry1 = mysqli_num_rows($fetch_date);
   if($fetch_arry > 0){
   	$_SESSION['msg_succ'] = "Holiday Name already exist.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions.php');
   	}
   } else if($fetch_arry1 > 0){
   $_SESSION['msg_error'] = "This date of holiday is already added. If you want to add another holiday on the same day you can edit the holiday and can mention the second holiday in the 'Holiday Name' section by seperating commas i.e Holiday 1, Holiday 2.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions');
   	}
   } else {
   $inset = mysqli_query($con, "INSERT INTO businessholidays(festname,adminid,holiday_date)VALUES('".mysqli_real_escape_string($con, $festname1)."','".mysqli_real_escape_string($con, $admin_id)."','".mysqli_real_escape_string($con, $new_date)."')");
   if($inset){
   $_SESSION['msg_succ'] = "Holiday added successfully.";
   if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions');
   	}
   } else{
   //$_SESSION['msg_error'] = mysqli_error($con);
   $_SESSION['msg_error'] = "Holiday could not be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
   if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions.php');
   }
   }
     }
    } elseif(isset($_POST['update_date'])){
   $holi_id = $_POST['holiday_id'];
   $festname = $_POST['festname'];
   $date = str_replace('/', '-', $_POST['date']);
   $new_date = date('Y-m-d', strtotime($date));

   $fetch = mysqli_query($con, "SELECT festname FROM businessholidays WHERE festname='".$festname."' && adminid='".$admin_id."' && id != '".$holi_id."'");
   $fetch_arry = mysqli_num_rows($fetch);
   $fetch_date = mysqli_query($con, "SELECT holiday_date FROM businessholidays WHERE holiday_date='".$new_date."' && adminid='".$admin_id."' && id!='".$holi_id."'");
   $fetch_arry1 = mysqli_num_rows($fetch_date);
   if($fetch_arry > 0){
   	$_SESSION['msg_succ'] = "Holiday Name already exist.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id.'&edit='.$holi_id);

   	} else {
   		header('location:../defaultglobaloptions.php?edit='.$holi_id);
   	}
   } else if($fetch_arry1 > 0){
   $_SESSION['msg_error'] = "This date of holiday is already added. If you want to add another holiday on the same day you can edit the holiday and can mention the second holiday in the 'Holiday Name' section by seperating commas i.e Holiday 1, Holiday 2.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id.'&edit='.$holi_id);

   	} else {
   		header('location:../defaultglobaloptions.php?edit='.$holi_id);
   	}
   } else {
   $holiday_update = mysqli_query($con, "update businessholidays set festname='".mysqli_real_escape_string($con, $festname)."', holiday_date='".mysqli_real_escape_string($con, $new_date)."' where id='".mysqli_real_escape_string($con, $holi_id)."'");
   $fetching = mysqli_fetch_assoc($holiday_update);

   if($holiday_update){
   	$_SESSION['msg_succ'] = "Holiday updated successfully.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id.'&edit='.$holi_id);

   	} else {
   		header('location:../defaultglobaloptions.php?edit='.$holi_id);
   	}
   } else {
   	//$_SESSION['msg_error'] = mysqli_error($con);
   	$_SESSION['msg_error'] = "Holiday could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id.'&edit='.$holi_id);

   	} else {
   		header('location:../defaultglobaloptions.php?edit='.$holi_id);
   	}
   }
   }
   } elseif(isset($_POST['sub_holiday'])) {
   $check = $_POST['check'];
   $check1 = implode(',', $check);
   $sq=mysqli_query($con,"DELETE from businessholidays WHERE id IN ($check1) && adminid= '$admin_id'");
   if($sq){
    $_SESSION['msg_succ'] = "Holiday(s) deleted successfully.";
   	if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	} else {
   		header('location:../defaultglobaloptions.php');
   	}
   } else {
   	 $_SESSION['msg_error'] = "No records found";
   	 if($role == 'superadmin' ){
   		header('location:../defaultglobaloptions.php?adminid='.$admin_id);
   	 } else {
   		header('location:../defaultglobaloptions.php');
   	 }
   }
   } elseif(isset($_POST['upload_hidden'])) {
   $media = $_FILES['filename']['name'];
   $actual_name = pathinfo($media,PATHINFO_FILENAME);
   $original_name = $actual_name;
   $extension = pathinfo($media, PATHINFO_EXTENSION);
   $target = "../uploads/";

   $i = 1;
   while(file_exists($target.$actual_name.".".$extension)){
   	$actual_name = $original_name.$i;

   	$media = $actual_name.".".$extension;
   	$i++;
   }

   $target = $target.basename( $media ) ;
   move_uploaded_file($_FILES['filename']['tmp_name'], $target);

   $existmedia = mysqli_query($con, "SELECT media FROM media WHERE adminid='".$admin_id."'");
   $datamedia = mysqli_fetch_array($existmedia);
   $availablemedia = $datamedia['media'];
   if($availablemedia != "") {
   	$newmedia = $availablemedia. "&&*&&" .$media;
   } else {
   	$newmedia = $media;
   }
   if(mysqli_query($con, "UPDATE media SET media='".mysqli_real_escape_string($con, $newmedia)."' WHERE adminid= '".$admin_id."'")) {
   	$_SESSION['msg_succ'] = "Image added successfully.";
   	if($role == 'superadmin' ){
   		header('location:../media.php?adminid='.$admin_id);
   	} else {
   		header('location:../media.php');
   	}
   } else {
   	$_SESSION['msg_error'] = "Image could not be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
   	if($role == 'superadmin' ){
   		header('location:../media.php?adminid='.$admin_id);
   	} else {
   		header('location:../media.php');
   	}
   }
   } elseif(isset($_FILES['filename'])) {

   $media = $_FILES['filename']['name'];
   $actual_name = pathinfo($media,PATHINFO_FILENAME);
   $original_name = $actual_name;
   $extension = pathinfo($media, PATHINFO_EXTENSION);
   $target = "../uploads/";

   $i = 1;
   while(file_exists($target.$actual_name.".".$extension)){
   	$actual_name = $original_name.$i;

   	$media = $actual_name.".".$extension;
   	$i++;
   }

   $target = $target.basename( $media ) ;
   move_uploaded_file($_FILES['filename']['tmp_name'], $target);

   $existmedia = mysqli_query($con, "SELECT media FROM media WHERE adminid='".$admin_id."'");
   $datamedia = mysqli_fetch_array($existmedia);
   $availablemedia = $datamedia['media'];
   if($availablemedia != "") {
   	$newmedia = $availablemedia. "&&*&&" .$media;
   } else {
   	$newmedia = $media;
   }
   if(mysqli_query($con, "UPDATE media SET media='".mysqli_real_escape_string($con, $newmedia)."' WHERE adminid= '".$admin_id."'")) {
   	echo $media;
   } else {}
           } elseif(isset($_POST['mediadelete'])) {

   $media = $_FILES['filename']['name'];
   $checkmedia = $_POST['delete-checkbox'];
   $target = "../uploads/";
   $existmedia = mysqli_query($con, "SELECT media FROM media WHERE adminid='".$admin_id."'");
   $datamedia = mysqli_fetch_array($existmedia);
   $availablemedia = $datamedia['media'];
   $availablemedia = explode("&&*&&", $availablemedia);
   $deletemedia = array_intersect($checkmedia, $availablemedia);
   if(count($deletemedia) > 0){
   	foreach($deletemedia as $deleteimage) {
   		unlink($target.$deleteimage);
   	}
   	$updatenewmedia = array_diff($availablemedia, $deletemedia);
   	$updatenewmedia = implode("&&*&&", $updatenewmedia);
   	if(mysqli_query($con, "UPDATE media SET media='".mysqli_real_escape_string($con, $updatenewmedia)."' WHERE adminid= '".$admin_id."'")) {
   		$_SESSION['msg_succ'] = "Image(s) deleted successfully.";
   		if($role == 'superadmin' ){
   			header('location:../media.php?adminid='.$admin_id);
   		} else {
   			header('location:../media.php');
   		}
   	} else {
   		$_SESSION['msg_error'] = "Image could not be delete. Please check the details & try again. If you are getting error continuously please contact administrator.";
   		if($role == 'superadmin' ){
   			header('location:../media.php?adminid='.$admin_id);
   		} else {
   			header('location:../media.php');
   		}
   	}
    } else {
   	$_SESSION['msg_error'] = "Image could not be delete. Please check the details & try again. If you are getting error continuously please contact administrator.";
   		if($role == 'superadmin' ){
   			header('location:../media.php?adminid='.$admin_id);
   		} else {
   			header('location:../media.php');
   		}
    }
   } elseif(isset($_POST['create-script'])) {
   $title = $_POST['title'];
   if($title == "") {$title = "off";}
   $meta = $_POST['meta'];
   if($meta == "") {$meta = "off";}
   $bootstrapcss = $_POST['bootstrapcss'];
   if($bootstrapcss == "") {$bootstrapcss = "off";}
   $fontawesomecss = $_POST['fontawesomecss'];
   if($fontawesomecss == "") {$fontawesomecss = "off";}
   $sweetalertcss = $_POST['sweetalertcss'];
   if($sweetalertcss == "") {$sweetalertcss = "off";}
   $storelocatorcss = $_POST['storelocatorcss'];
   if($storelocatorcss == "") {$storelocatorcss = "off";}
   $materialicons = $_POST['materialicons'];
   if($materialicons == "") {$materialicons = "off";}
   $jquery = $_POST['jquery'];
   if($jquery == "") {$jquery = "off";}
   $bootstrapjs = $_POST['bootstrapjs'];
   if($bootstrapjs == "") {$bootstrapjs = "off";}
   $sweetalertjs = $_POST['sweetalertjs'];
   if($sweetalertjs == "") {$sweetalertjs = "off";}
   $storelocatorjs = $_POST['storelocatorjs'];
   if($storelocatorjs == "") {$storelocatorjs = "off";}
   $googlemapsjavascriptapi = $_POST['googlemapsjavascriptapi'];
   if($googlemapsjavascriptapi == "") {$googlemapsjavascriptapi = "off";}
   $googleanalytics = $_POST['googleanalytics'];
   if($googleanalytics == "") {$googleanalytics = "off";}

   if(mysqli_query($con, "Update script SET title='".mysqli_real_escape_string($con, $title)."', meta='".mysqli_real_escape_string($con, $meta)."', bootstrapcss='".mysqli_real_escape_string($con, $bootstrapcss)."', fontawesomecss='".mysqli_real_escape_string($con, $fontawesomecss)."', sweetalertcss='".mysqli_real_escape_string($con, $sweetalertcss)."', storelocatorcss='".mysqli_real_escape_string($con, $storelocatorcss)."', materialicons='".mysqli_real_escape_string($con, $materialicons)."', jquery='".mysqli_real_escape_string($con, $jquery)."', bootstrapjs='".mysqli_real_escape_string($con, $bootstrapjs)."', sweetalertjs='".mysqli_real_escape_string($con, $sweetalertjs)."', storelocatorjs='".mysqli_real_escape_string($con, $storelocatorjs)."', googlemapsjavascriptapi='".mysqli_real_escape_string($con, $googlemapsjavascriptapi)."', googleanalytics='".mysqli_real_escape_string($con, $googleanalytics)."' WHERE adminid= '".$admin_id."'")) {
   	$_SESSION['msg_succ'] = "Script created successfully.";
   	if($role == 'superadmin' ){
   		header('location:../adminpage.php?adminid='.$admin_id);
   	} else {
   		header('location:../adminpage.php');
   	}
   } else {
   	//$_SESSION['msg_error'] = mysqli_error($con);
   	$_SESSION['msg_error'] = "Script could not be create. Please check the details & try again. If you are getting error continuously please contact administrator.";
   	if($role == 'superadmin' ){
   		header('location:../adminpage.php?adminid='.$admin_id);
   	} else {
   		header('location:../adminpage.php');
   	}
   }
   } elseif(isset($_POST['themecolors'])) {
   $backgroundcolor = $_POST['backgroundcolor'];
   $locationbackgroundcolor = $_POST['locationbackgroundcolor'];
   $themecolor = $_POST['themecolor'];
   $themehovercolor = $_POST['themehovercolor'];
   $formcolor = $_POST['formcolor'];
   $buttonbackground = $_POST['buttonbackground'];
   $buttontextcolor = $_POST['buttontextcolor'];
   $buttonhovercolor = $_POST['buttonhovercolor'];

   if(mysqli_query($con, "Update settings SET backgroundcolor='".mysqli_real_escape_string($con, $backgroundcolor)."', locationbackgroundcolor='".mysqli_real_escape_string($con, $locationbackgroundcolor)."', themecolor='".mysqli_real_escape_string($con, $themecolor)."', themehovercolor='".mysqli_real_escape_string($con, $themehovercolor)."', formcolor='".mysqli_real_escape_string($con, $formcolor)."', buttonbackground='".mysqli_real_escape_string($con, $buttonbackground)."', buttontextcolor='".mysqli_real_escape_string($con, $buttontextcolor)."', buttonhovercolor='".mysqli_real_escape_string($con, $buttonhovercolor)."' WHERE adminid= '".$admin_id."'")) {
   	$_SESSION['msg_succ'] = "Theme colors updated successfully.";
   	if($role == 'superadmin' ){
   		header('location:../settings.php?adminid='.$admin_id);
   	} else {
   		header('location:../settings.php');
   	}
   } else {
   	//$_SESSION['msg_error'] = mysqli_error($con);
   	$_SESSION['msg_error'] = "Theme colors could not be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   	if($role == 'superadmin' ){
   		header('location:../settings.php?adminid='.$admin_id);
   	} else {
   		header('location:../settings.php');
   	}
   }
   } elseif(isset($_POST['update_setting'])) {
   $clientname = $_POST['clientname'];
   $username = $_POST['username'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $phone = preg_replace('/\D+/', '', $phone);
   $repeat_password = md5($_POST['repeat-password']);

   $checkusername = mysqli_query($con, "SELECT username FROM users where username='$username' && id!='$checkexactadminid'");
   $checkusernamerows = mysqli_num_rows($checkusername);

   $checkemail = mysqli_query($con, "SELECT email FROM users where email='$email' && id!='$checkexactadminid'");
   $checkemailrows = mysqli_num_rows($checkemail);

   if($checkusernamerows > 0) {
   	$_SESSION['msg_error'] = "Username already exists.";
   		if($role == 'superadmin' ){
   			header('location:../settings.php?adminid='.$admin_id);
   		} else {
   			header('location:../settings.php');
   		}
   } else if($checkemailrows > 0) {
   	$_SESSION['msg_error'] = "Email already exists.";
   		if($role == 'superadmin' ){
   			header('location:../settings.php?adminid='.$admin_id);
   		} else {
   			header('location:../settings.php');
   		}
   } else {
   	if(mysqli_query($con, "Update users SET clientname='".mysqli_real_escape_string($con, $clientname)."', username='".mysqli_real_escape_string($con, $username)."', email='".mysqli_real_escape_string($con, $email)."', phone='".mysqli_real_escape_string($con, $phone)."', password='".mysqli_real_escape_string($con, $repeat_password)."' WHERE adminid= '".$admin_id."' && role= 'admin'")) {
   		$_SESSION['msg_succ'] = "Settings updated successfully.";
   		if($role == 'superadmin' ){
   			header('location:../settings.php?adminid='.$admin_id);
   		} else {
   			header('location:../settings.php');
   		}
   	} else {
   		//$_SESSION['msg_error'] = mysqli_error($con);
   		$_SESSION['msg_error'] = "Settings couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   		if($role == 'superadmin' ){
   			header('location:../settings.php?adminid='.$admin_id);
   		} else {
   			header('location:../settings.php');
   		}
   	}
   }
   } elseif(isset($_POST['superadmin'])) {
   $clientname = $_POST['clientname'];
   $username = $_POST['username'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $phone = preg_replace('/\D+/', '', $phone);
   $repeat_password = md5($_POST['repeat-password']);

   $checkusername = mysqli_query($con, "SELECT username FROM users where username='$username' && role!='superadmin'");
   $checkusernamerows = mysqli_num_rows($checkusername);

   $checkemail = mysqli_query($con, "SELECT email FROM users where email='$email' && role!='superadmin'");
   $checkemailrows = mysqli_num_rows($checkemail);

   if($checkusernamerows > 0) {
   	$_SESSION['msg_error'] = "Username already exists.";
   		header('location:../superadminpage.php');
   } else if($checkemailrows > 0) {
   	$_SESSION['msg_error'] = "Email already exists.";
   		header('location:../superadminpage.php');
   } else {
   	if(mysqli_query($con, "Update users SET clientname='".mysqli_real_escape_string($con, $clientname)."', username='".mysqli_real_escape_string($con, $username)."', email='".mysqli_real_escape_string($con, $email)."', phone='".mysqli_real_escape_string($con, $phone)."', password='".mysqli_real_escape_string($con, $repeat_password)."' WHERE role= 'superadmin'")) {
   		$_SESSION['msg_succ'] = "Profile updated successfully.";
   		header('location:../superadminpage.php');
   	} else {
   		//$_SESSION['msg_error'] = mysqli_error($con);
   		$_SESSION['msg_error'] = "Profile couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   		header('location:../superadminpage.php');
   	}
   }
   } elseif(isset($_POST['update_subsetting'])) {
   $clientname = $_POST['clientname'];
   $username = $_POST['username'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $repeat_password = $_POST['repeat-password'];

   $checkusername = mysqli_query($con, "SELECT username FROM users where username='$username' && id!='$usersessionsubid'");
   $checkusernamerows = mysqli_num_rows($checkusername);

   $checkemail = mysqli_query($con, "SELECT email FROM users where email='$email' && id!='$usersessionsubid'");
   $checkemailrows = mysqli_num_rows($checkemail);

   if($checkusernamerows > 0) {
   	$_SESSION['msg_error'] = "Username already exists.";
   	header('location:../settings.php');
   } else if($checkemailrows > 0) {
   	$_SESSION['msg_error'] = "Email already exists.";
   	header('location:../settings.php');
   } else {
   	if(mysqli_query($con, "Update users SET clientname='".mysqli_real_escape_string($con, $clientname)."', username='".mysqli_real_escape_string($con, $username)."', email='".mysqli_real_escape_string($con, $email)."', phone='".mysqli_real_escape_string($con, $phone)."', password='".mysqli_real_escape_string($con, $repeat_password)."' WHERE adminid='".$admin_id."' && id='".$usersessionsubid."' && role='subadmin'")) {
   		$_SESSION['msg_succ'] = "Settings updated successfully.";
   		header('location:../settings.php');
   	} else {
   		//$_SESSION['msg_error'] = mysqli_error($con);
   		$_SESSION['msg_error'] = "Settings couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   		header('location:../settings.php');
   	}
   }
   } elseif(isset($_POST['adduserform']))
   {
		$clientname = $_POST['clientname'];
		$username = $_POST['username'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$phone = preg_replace('/\D+/', '', $phone);
		$repeat_password = md5($_POST['repeat-password']);
		$userrole = "subadmin";
		$analytics = $_POST['analytics'];
		$analyticsbylocation = $_POST['analyticsbylocation'];
		$locations = $_POST['locations'];
		$addlocations = $_POST['addlocations'];
		$defaultglobaloptions = $_POST['defaultglobaloptions'];
		$settings = $_POST['settings'];
		$media = $_POST['mediapage'];
		$adminpage = $_POST['adminpage'];
		$selectlocations = implode(",", $_POST['selectlocations']);

		$checkusername = mysqli_query($con, "SELECT username FROM users where username='$username'");
		$checkusernamerows = mysqli_num_rows($checkusername);

		$checkemail = mysqli_query($con, "SELECT email FROM users where email='$email'");
		$checkemailrows = mysqli_num_rows($checkemail);

		if($checkusernamerows > 0) {
			$_SESSION['msg_error'] = "Username already exists.";
				if($role == 'superadmin' ){
					header('location:../adminpage.php?adminid='.$admin_id);
				} else {
					header('location:../adminpage.php');
				}
		} else if($checkemailrows > 0) {
					$_SESSION['msg_error'] = "Email already exists.";
						if($role == 'superadmin' ){
							header('location:../adminpage.php?adminid='.$admin_id);
						} else {
							header('location:../adminpage.php');
						}
				} else {
					if(mysqli_query($con, "INSERT INTO users (adminid, clientname, username, email, phone, password, role, analytics, analyticsbylocation, locations, addlocations, defaultglobaloptions, settings, media, adminpage, locationsaccess, created) VALUES ('".mysqli_real_escape_string($con, $admin_id)."', '".mysqli_real_escape_string($con, $clientname)."', '".mysqli_real_escape_string($con, $username)."', '".mysqli_real_escape_string($con, $email)."', '".mysqli_real_escape_string($con, $phone)."', '".mysqli_real_escape_string($con, $repeat_password)."', '".mysqli_real_escape_string($con, $userrole)."', '".mysqli_real_escape_string($con, $analytics)."', '".mysqli_real_escape_string($con, $analyticsbylocation)."', '".mysqli_real_escape_string($con, $locations)."', '".mysqli_real_escape_string($con, $addlocations)."', '".mysqli_real_escape_string($con, $defaultglobaloptions)."', '".mysqli_real_escape_string($con, $settings)."', '".mysqli_real_escape_string($con, $media)."', '".mysqli_real_escape_string($con, $adminpage)."', '".mysqli_real_escape_string($con, $selectlocations)."', NOW())")) {
						$_SESSION['msg_succ'] = "User added successfully.";
						if($role == 'superadmin' ){
							header('location:../adminpage.php?adminid='.$admin_id);
						} else {
							header('location:../adminpage.php');
						}
					} else {
					//	$_SESSION['msg_error'] = mysqli_error($con);
						$_SESSION['msg_error'] = "User couldn't be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
						if($role == 'superadmin' ){
							header('location:../adminpage.php?adminid='.$admin_id);
						} else {
							header('location:../adminpage.php');
							}
						}
			}
		} elseif(isset($_POST['updateuserform'])) {
			$edituserid = $_POST['edituserid'];
			$clientname = $_POST['clientname'];
			$username = $_POST['username'];
			$email = $_POST['email'];
			$phone = $_POST['phone'];
			$phone = preg_replace('/\D+/', '', $phone);
			$repeat_password = md5($_POST['repeat-password']);
			$userrole = "subadmin";
			$analytics = $_POST['analytics'];
			$analyticsbylocation = $_POST['analyticsbylocation'];
			$locations = $_POST['locations'];
			$addlocations = $_POST['addlocations'];
			$defaultglobaloptions = $_POST['defaultglobaloptions'];
			$settings = $_POST['settings'];
			$media = $_POST['mediapage'];
			$adminpage = $_POST['adminpage'];
			$selectlocations = implode(",", $_POST['selectlocations']);

			$checkusername = mysqli_query($con, "SELECT username FROM users where username='$username' && id!='$edituserid'");
			$checkusernamerows = mysqli_num_rows($checkusername);

			$checkemail = mysqli_query($con, "SELECT email FROM users where email='$email' && id!='$edituserid'");
			$checkemailrows = mysqli_num_rows($checkemail);

			if($checkusernamerows > 0) {
				$_SESSION['msg_error'] = "Username already exists.";
					if($role == 'superadmin' ){
						header('location:../adminpage.php?adminid='.$admin_id);
					} else {
						header('location:../adminpage.php?edituser='.$edituserid);
					}
			} else if($checkemailrows > 0) {
				$_SESSION['msg_error'] = "Email already exists.";
					if($role == 'superadmin' ){
						header('location:../adminpage.php?adminid='.$admin_id);
					} else {
						header('location:../adminpage.php');
					}
			} else {

				if(mysqli_query($con, "Update users SET clientname='".mysqli_real_escape_string($con, $clientname)."', username='".mysqli_real_escape_string($con, $username)."', email='".mysqli_real_escape_string($con, $email)."', phone='".mysqli_real_escape_string($con, $phone)."', password='".mysqli_real_escape_string($con, $repeat_password)."', analytics='".mysqli_real_escape_string($con, $analytics)."', analyticsbylocation='".mysqli_real_escape_string($con, $analyticsbylocation)."', locations='".mysqli_real_escape_string($con, $locations)."', addlocations='".mysqli_real_escape_string($con, $addlocations)."', defaultglobaloptions='".mysqli_real_escape_string($con, $defaultglobaloptions)."', settings='".mysqli_real_escape_string($con, $settings)."', media='".mysqli_real_escape_string($con, $media)."', adminpage='".mysqli_real_escape_string($con, $adminpage)."', locationsaccess='".mysqli_real_escape_string($con, $selectlocations)."' WHERE id='$edituserid' && adminid= '$admin_id' && role='subadmin'")) {
				$_SESSION['msg_succ'] = "User updated successfully.";
					if($role == 'superadmin' ){
						header('location:../adminpage.php?adminid='.$admin_id);
					} else {
						header('location:../adminpage.php?edituser='.$edituserid);
					}
				} else {
				//	$_SESSION['msg_error'] = mysqli_error($con);
							$_SESSION['msg_error'] = "User couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
							if($role == 'superadmin' ){
								header('location:../adminpage.php?adminid='.$admin_id);
							} else {
								header('location:../adminpage.php?edituser='.$edituserid);
							}
						}
					}
	} elseif(isset($_POST['deleteuser'])) {
		$deleteuserid = $_POST['deleteuserid'];
		$deleteuserid = implode(',', $deleteuserid);

		if(mysqli_query($con,"DELETE from users WHERE id IN ($deleteuserid) && adminid= '$admin_id' && role='subadmin'")) {
			$_SESSION['msg_succ'] = "User(s) deleted successfully.";
			if($role == 'superadmin' ){
				header('location:../adminpage.php?adminid='.$admin_id);
			} else {
				header('location:../adminpage.php');
			}
		} else {
		//	$_SESSION['msg_error'] = mysqli_error($con);
			$_SESSION['msg_error'] = "User couldn't be delete. Please check the details & try again. If you are getting error continuously please contact administrator.";
			if($role == 'superadmin' ){
				header('location:../adminpage.php?adminid='.$admin_id);
			} else {
				header('location:../adminpage.php');
			}
		}
	} elseif(isset($_POST['addclient'])) {

		$clientname = $_POST['clientname'];
		$clientaddress = $_POST['clientaddress'];
		$clientusername = $_POST['clientusername'];
		$clientemail = $_POST['clientemail'];
		$clientphone = $_POST['clientphone'];
		$clientphone = preg_replace('/\D+/', '', $clientphone);
		$clientbusiness = $_POST['clientbusiness'];
		$reclientpassword = md5($_POST['reclientpassword']);
				$clientpricingpackage = $_POST['clientpricingpackage'];
		$invoicesystem = $_POST['invoicesystem'];
		if($invoicesystem=='invoice')
		{ $invoicesystem ='invoice'; } else {$invoicesystem ='recurring'; }
		$userrole = "admin";
		$userstatus = "0";

		$selectlastadminid = mysqli_query($con, "SELECT MAX(adminid) FROM users WHERE role='admin'");
		$lastadmindata = mysqli_fetch_row($selectlastadminid);
		$lastadminid = $lastadmindata[0]+1;
		$defaultonvalue = "on";

		$checkusername = mysqli_query($con, "SELECT username FROM users where username='$clientusername'");
		$checkusernamerows = mysqli_num_rows($checkusername);

		$checkclientbusiness = mysqli_query($con, "SELECT business FROM users where business='$clientbusiness'");
		$checkclientbusinessrows = mysqli_num_rows($checkclientbusiness);

		$checkemail = mysqli_query($con, "SELECT email FROM users where email='$clientemail'");
		$checkemailrows = mysqli_num_rows($checkemail);

		if($checkusernamerows > 0) {
			$_SESSION['msg_error'] = "Username already exists.";
			header('location:../addclient.php');
		} else if($checkemailrows > 0) {
			$_SESSION['msg_error'] = "Email already exists.";
			header('location:../addclient.php');
		}  else if($checkclientbusinessrows > 0) {
			$_SESSION['msg_error'] = "Business Name already exists.";
			header('location:../addclient.php');
		} else {
			mysqli_query($con, "INSERT INTO globaloptions (adminid, created) VALUES ('".mysqli_real_escape_string($con, $lastadminid)."', NOW())");
			mysqli_query($con, "INSERT INTO media (adminid) VALUES ('".mysqli_real_escape_string($con, $lastadminid)."')");
			mysqli_query($con, "INSERT INTO script (adminid, title, meta, bootstrapcss, fontawesomecss, sweetalertcss, storelocatorcss, materialicons, jquery, bootstrapjs, sweetalertjs, storelocatorjs, googlemapsjavascriptapi, googleanalytics) VALUES ('".mysqli_real_escape_string($con, $lastadminid)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."', '".mysqli_real_escape_string($con, $defaultonvalue)."')");
			mysqli_query($con, "INSERT INTO settings (adminid) VALUES ('".mysqli_real_escape_string($con, $lastadminid)."')");
		//	mysqli_query($con, "INSERT INTO payments (adminid,paymentmethod) VALUES ('".mysqli_real_escape_string($con, $lastadminid)."','$invoicesystem')");


			if(mysqli_query($con, "INSERT INTO users (adminid, clientname,client_address, username, email, phone, business, password, package, invoice, role, status, created) VALUES ('".mysqli_real_escape_string($con, $lastadminid)."', '".mysqli_real_escape_string($con, $clientname)."','".mysqli_real_escape_string($con, $clientaddress)."', '".mysqli_real_escape_string($con, $clientusername)."', '".mysqli_real_escape_string($con, $clientemail)."', '".mysqli_real_escape_string($con, $clientphone)."', '".mysqli_real_escape_string($con, $clientbusiness)."', '".mysqli_real_escape_string($con, $reclientpassword)."', '".mysqli_real_escape_string($con, $clientpricingpackage)."', '".mysqli_real_escape_string($con, $invoicesystem)."', '".mysqli_real_escape_string($con, $userrole)."', '".mysqli_real_escape_string($con, $userstatus)."', NOW())")) {
							$send_reg_mail=$custom_functions->sendRegistrationEmail($clientusername,$_POST['clientpassword'],"agnihotriramandeep@gmail.com",$clientname);
							$_SESSION['msg_succ'] = "Client added successfully.";
							header('location:../addclient.php');
			} else {
							//$_SESSION['msg_error'] = mysqli_error($con);
							$_SESSION['msg_error'] = "Client couldn't be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
							header('location:../addclient.php');
			}
		}
   } elseif(isset($_POST['addplan'])) {

		$packagename = $_POST['packagename'];
		$startupfee = $_POST['startupfee'];
		$standardprice = $_POST['standardprice'];
		$bulkprice = $_POST['bulkprice'];
		$locationsquantity = $_POST['locationsquantity'];

		$checkplan = mysqli_query($con, "SELECT planname FROM packages where planname='$packagename'");
		$checkplanrows = mysqli_num_rows($checkplan);

		if($checkplanrows > 0) {
			$_SESSION['msg_error'] = "Package Name already exists.";
			header('location:../addpackage.php');
		} else {
			if(mysqli_query($con, "INSERT INTO packages (planname, startupfee, standardprice, bulkprice, locationsquantity) VALUES ('".mysqli_real_escape_string($con, $packagename)."', '".mysqli_real_escape_string($con, $startupfee)."', '".mysqli_real_escape_string($con, $standardprice)."', '".mysqli_real_escape_string($con, $bulkprice)."', '".mysqli_real_escape_string($con, $locationsquantity)."')")) {
			$_SESSION['msg_succ'] = "Package added successfully.";
				header('location:../packages.php');
			} else {
			//	$_SESSION['msg_error'] = mysqli_error($con);
				$_SESSION['msg_error'] = "Package couldn't be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
				header('location:../addpackage.php');
			}
		}
	}
// 	elseif(isset($_POST['payment'])) {

// 			if(mysqli_query($con,"Update payments SET paymentmethod='".mysqli_real_escape_string($con, 'on')."' WHERE adminid ='$admin_id'")){
// 				$_SESSION['msg_succ'] = "Payment method added successfully.";
// 				header('location:../clients');
// 			} else {
// 				$_SESSION['msg_error'] = "Payment method couldn't be add. Please check the details & try again. If you are getting error continuously please contact administrator.";
// 				header('location:../clients');
// 			}

//   }
else if(isset($_POST['locations']))
   {
        	$check1 = $_POST['checkb'];
			$check2 = implode(',', $check1);

			$adminlocationsaccess = mysqli_query($con, "SELECT id, locationsaccess FROM users WHERE adminid ='$admin_id' && role='subadmin'");
			while($adminlocationsaccessfetch = mysqli_fetch_assoc($adminlocationsaccess)) {
				$locationsubadminid = $adminlocationsaccessfetch['id'];
				$availablelocationaccess = explode(',', $adminlocationsaccessfetch['locationsaccess']);
				$availablelocationaccessdiff = array_diff($availablelocationaccess, $check1);
				$impavailablelocationaccessdiff = implode(',', $availablelocationaccessdiff);

				mysqli_query($con, "Update users SET locationsaccess='".mysqli_real_escape_string($con, $impavailablelocationaccessdiff)."' WHERE id='$locationsubadminid' && role='subadmin'");
			}

			mysqli_query($con,"DELETE FROM callclicks WHERE locationid IN ($check2)");

			mysqli_query($con,"DELETE FROM directionclicks WHERE locationid IN ($check2)");

			mysqli_query($con,"DELETE FROM pageviews WHERE locationid IN ($check2)");
			mysqli_query($con,"DELETE FROM r1_parent_info_lookUp WHERE location_id IN ($check2)");

			if(mysqli_query($con,"DELETE from markers WHERE id IN ($check2)")){

				///  $calculateamount=calculatePrice($con,$admin_id);
		//		  mysqli_query($con,"UPDATE accounts SET amount_due=$calculateamount WHERE admin_id=$admin_id");

				$_SESSION['msg_succ'] = "Location(s) deleted successfully.";
				if($role == 'superadmin' ){
					header('location:../locations.php?adminid='.$admin_id);
				} else {
					header('location:../locations.php');
				}

			} else {

				$_SESSION['msg_error'] = "Location(s) couldn't be delete. Please check the details & try again. If you are getting error continuously please contact administrator.";
				if($role == 'superadmin' ){
					header('location:../locations.php?adminid='.$admin_id);
				} else {
					header('location:../locations.php');
				}
			}
   } else if(isset($_POST['packages'])) {
		$checkbox_packages = $_POST['checkbox_packages'];
		$checkbox_packages = implode(',', $checkbox_packages);
		if(mysqli_query($con,"DELETE from packages WHERE id IN ($checkbox_packages)")){
			$_SESSION['msg_succ'] = "Package(s) deleted successfully.";
			header('location:../packages.php');
		}
		else {
			$_SESSION['msg_error'] = "Package(s) couldn't be delete. Please check the details & try again. If you are getting error continuously please contact administrator.";
			header('location:../packages.php');
		}
   } else if(isset($_POST['dectclients'])) {
		$checkbox_clients = $_POST['checkbox_clients'];
		$checkbox_clients = implode(',', $checkbox_clients);

		if(mysqli_query($con,"Update users SET status = CASE WHEN status = 0 THEN 1 ELSE 0 END WHERE adminid IN ($checkbox_clients)")){
			$_SESSION['msg_succ'] = "Client(s) activated/dectivated successfully.";
			header('location:../clients.php');
		} else {
			$_SESSION['msg_error'] = "Client(s) couldn't be activate/dectivate. Please check the details & try again. If you are getting error continuously please contact administrator.";
			header('location:../clients.php');
		}
   } else if(isset($_POST['clients'])) {
   $checkbox_clients1 = $_POST['checkbox_clients'];
          $checkbox_clients = implode(',', $checkbox_clients1);
          //Delete media images
          if(!empty($checkbox_clients1))
          {
              foreach($checkbox_clients1 as $chk)
              {

                  $r=mysqli_query($con,"SELECT media FROM media WHERE adminid=$chk");
                  $fetch_row=mysqli_fetch_assoc($r);
                  $media=$fetch_row['media'];
                  $exp_media=explode("&&*&&",$media);
                  // echo "<pre>"; print_r($exp_media); die;
                  if(!empty($exp_media))
                  {
                      foreach($exp_media as $image)
                      {

                         unlink(getcwd().'/../uploads/'.$image);
                      }
                  }
              }
          }
				//Delete media images done
		mysqli_query($con,"DELETE FROM businessholidays WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM callclicks WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM directionclicks WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM globaloptions WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM markers WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM media WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM pageviews WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM script WHERE adminid IN ($checkbox_clients)");
		mysqli_query($con,"DELETE FROM settings WHERE adminid IN ($checkbox_clients)");

		if(mysqli_query($con,"DELETE from users WHERE adminid IN ($checkbox_clients)")){
			$_SESSION['msg_succ'] = "Client(s) deleted successfully.";
			header('location:../clients.php');
		} else {
			$_SESSION['msg_error'] = "Client(s) couldn't be delete. Please check the details & try again. If you are getting error continuously please contact administrator.";
			header('location:../clients.php');
		}
   } elseif(isset($_POST['updateclient'])) {

			$clientid = $_POST['clientid'];
			$clientname = $_POST['clientname'];
					$clientaddress = $_POST['clientaddress'];
			$clientusername = $_POST['clientusername'];
			$clientemail = $_POST['clientemail'];
			$clientphone = $_POST['clientphone'];
			$clientphone = preg_replace('/\D+/', '', $clientphone);
			$clientbusiness = $_POST['clientbusiness'];
			$reclientpassword = md5($_POST['reclientpassword']);

			$checkusername = mysqli_query($con, "SELECT username FROM users where username='$clientusername' && id!='$clientid'");
			$checkusernamerows = mysqli_num_rows($checkusername);

			$checkemail = mysqli_query($con, "SELECT email FROM users where email='$clientemail' && id!='$clientid'");
			$checkemailrows = mysqli_num_rows($checkemail);

			$checkclientbusiness = mysqli_query($con, "SELECT business FROM users where business='$clientbusiness' && id!='$clientid'");
			$checkclientbusinessrows = mysqli_num_rows($checkclientbusiness);

			if($checkusernamerows > 0) {
				$_SESSION['msg_error'] = "Username already exists.";
				header('location:../editclient.php?clientid='.$clientid);
			} elseif($checkemailrows > 0) {
				$_SESSION['msg_error'] = "Email already exists.";
				header('location:../editclient.php?clientid='.$clientid);
			} elseif($checkclientbusinessrows > 0) {
				$_SESSION['msg_error'] = "Business Name already exists.";
				header('location:../editclient.php?clientid='.$clientid);
			} else {

				if(mysqli_query($con, "Update users SET clientname='".mysqli_real_escape_string($con, $clientname)."', client_address='".mysqli_real_escape_string($con, $clientaddress)."', username='".mysqli_real_escape_string($con, $clientusername)."', email='".mysqli_real_escape_string($con, $clientemail)."', phone='".mysqli_real_escape_string($con, $clientphone)."', business='".mysqli_real_escape_string($con, $clientbusiness)."', password='".mysqli_real_escape_string($con, $reclientpassword)."' WHERE id='".$clientid."' && role='admin'")) {
					$_SESSION['msg_succ'] = "Client updated successfully.";
					header('location:../editclient.php?clientid='.$clientid);
				} else {
					//$_SESSION['msg_error'] = mysqli_error($con);
					$_SESSION['msg_error'] = "Client couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
					header('location:../editclient.php?clientid='.$clientid);
				}
			}
		} elseif(isset($_POST['updatepackage'])) {
			$packageid = $_POST['packageid'];
			$packagename = $_POST['packagename'];
			$startupfee = $_POST['startupfee'];
			$standardprice = $_POST['standardprice'];
			$bulkprice = $_POST['bulkprice'];
			$locationsquantity = $_POST['locationsquantity'];

			$checkplan = mysqli_query($con, "SELECT planname FROM packages where planname='$packagename' && id!='$packageid'");
			$checkplanrows = mysqli_num_rows($checkplan);

			if($checkplanrows > 0) {
				$_SESSION['msg_error'] = "Package Name already exists.";
				header('location:../editpackage.php?packageid='.$packageid);
			} else {
				if(mysqli_query($con, "Update packages SET planname='".mysqli_real_escape_string($con, $packagename)."', startupfee='".mysqli_real_escape_string($con, $startupfee)."', standardprice='".mysqli_real_escape_string($con, $standardprice)."', bulkprice='".mysqli_real_escape_string($con, $bulkprice)."', locationsquantity='".mysqli_real_escape_string($con, $locationsquantity)."' WHERE id='".$packageid."'")) {
				$_SESSION['msg_succ'] = "Package updated successfully.";
				header('location:../editpackage.php?packageid='.$packageid);
				} else {
				//$_SESSION['msg_error'] = mysqli_error($con);
				$_SESSION['msg_error'] = "Package couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
				header('location:../editpackage.php?packageid='.$packageid);
				}
			}
	}
	else if(isset($_POST['updatezipcode'])) {

		$adminid = $_POST['adminid'];
		$zipcodeid = $_POST['zipcodeid'];
		$locid = $_POST['locid'];
		$zipname = $_POST['zipname'];
		$zipcode = $_POST['zipcode'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$pagecontentzip = $_POST['page_content'];
   		if($adminid==50){
   		if(mysqli_query($con, "Update zipcodesnew SET zip_name='".mysqli_real_escape_string($con, $zipname)."', zipcode='".mysqli_real_escape_string($con,$zipcode)."', city='".mysqli_real_escape_string($con, $city)."', state='".mysqli_real_escape_string($con, $state)."', country='".mysqli_real_escape_string($con, $country)."', page_content='".mysqli_real_escape_string($con, $pagecontentzip)."', loc_id='".$locid."' WHERE id='".$zipcodeid."'")) {

		   $_SESSION['msg_succ'] = "Zipcode updated successfully.";
			header('location:../editzipcode?adminid='.$adminid.'&zipcodeid='.$zipcodeid);
   		} else {
   			$_SESSION['msg_error'] = mysqli_error($con);
   			$_SESSION['msg_error'] = "Zipcode couldn't be update. Please check the details & try again. If you are getting error continuously please contact administrator.";
   			header('location:../editzipcode.php?adminid='.$adminid.'&zipcodeid='.$zipcodeid);
   		}
   	}
   }else if(isset($_POST['operation']) && $_POST['operation']=='delete_pop_image'){

     $img_name=$_POST['img_name'];
     $adminid=$_POST['adminid'];
    // $locationid=$_POST['locationid'];
     if(!empty($img_name))
     {
         unlink(getcwd().'/../uploads/'.$img_name);
     }
     $find=mysqli_query($con,"SELECT media from media WHERE adminid=$adminid");
     $getdata=mysqli_fetch_assoc($find);
     $media_array=explode('&&*&&',$getdata['media']);
     $search_deleted_image=array_search($img_name,$media_array);
     unset($media_array[$search_deleted_image]);

     $new_img_str=implode('&&*&&',$media_array);
     // update database
     $find=mysqli_query($con,"UPDATE media SET media='$new_img_str' WHERE adminid=$adminid");


   } else if(isset($_POST['zipCodes'])) {
   $check1 = $_POST['checkzipb'];
   $check2 = implode(',', $check1);
   if($_POST['adminid']==50){
   	if(mysqli_query($con,"DELETE from zipcodesnew WHERE id IN ($check2)")){
   		$_SESSION['msg_succ'] = "Zipcodes(s) deleted successfully.";
   		if($role == 'superadmin' ){
   			header('location:../zipcodes.php?adminid='.$admin_id);
   		} else {
   			header('location:../zipcodes.php');
   		}
   	}
   }else if($_POST['adminid']==49){
   	if(mysqli_query($con,"DELETE from zipcodesnew_blu WHERE id IN ($check2)")){
   		$_SESSION['msg_succ'] = "Zipcodes(s) deleted successfully.";
   		if($role == 'superadmin' ){
   			header('location:../zipcodes.php?adminid='.$admin_id);
   		} else {
   			header('location:../zipcodes.php');
   		}
   	}
   }

   }else {

   header('location:'.$adminurl);
   }
   /*delete zipcodes*/

   function calculatePrice($con,$admin_id)
          {

              $user_query="SELECT * FROM users WHERE adminid=$admin_id";
              $user_run_query=mysqli_query($con,$user_query);
              $user_data=mysqli_fetch_assoc($user_run_query);
              $user_package=$user_data['package'];

              $q="SELECT * FROM packages WHERE planname='$user_package'";
              $package_run_query=mysqli_query($con,$q);
              $package_data=mysqli_fetch_assoc($package_run_query);

                  $standard_price=$package_data['standardprice'];
                  $bulkprice=$package_data['bulkprice'];
                  $locationsquantity=$package_data['locationsquantity'];


                      $marker="SELECT * FROM markers WHERE adminid=$admin_id";
                      $marker_query=mysqli_query($con,$marker);
                      $marker_data=mysqli_fetch_all($marker_query);
                       $total_amount=0;
                       $net_current_locations=count($marker_data);

                       if($net_current_locations > $locationsquantity)
                      {

                        $total_amount= ($locationsquantity*$standard_price) + (($net_current_locations-$locationsquantity) * $bulkprice);

                      }else{

                          $total_amount=$standard_price * $net_current_locations;

                      }

                      return $total_amount."00";

          }

function fetch_brand($admin_id,$con){

                          $admin_id;
                          $getBrand_Id = mysqli_query($con, "SELECT brand_id FROM busniess_brands WHERE admin_id = '$admin_id'");
                          $getAdminBrand = mysqli_fetch_assoc($getBrand_Id);
                          $getAdminBrand_Id = $getAdminBrand['brand_id'];
                          return $getAdminBrand_Id;

                      }
   ?>