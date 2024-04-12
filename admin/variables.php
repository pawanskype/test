<?php
error_reporting(0);
	include 'inc/config.php';

	$usersessionid = isset($_SESSION['data']['adminid'])?$_SESSION['data']['adminid']:0;
	$usersessionsubid = isset($_SESSION['data']['id'])?$_SESSION['data']['id']:0;
	$role = isset($_SESSION['data']['role'])?$_SESSION['data']['role']:0;;
	
	$analytics = isset($_SESSION['data']['analytics'])?$_SESSION['data']['role']:0;
	$analyticsbylocation = isset($_SESSION['data']['analyticsbylocation'])?$_SESSION['data']['analyticsbylocation']:0;
	$locations = isset($_SESSION['data']['locations'])?$_SESSION['data']['locations']:0;
	$addlocations = isset($_SESSION['data']['addlocations'])?$_SESSION['data']['addlocations']:0;
	$defaultglobaloptions = isset($_SESSION['data']['defaultglobaloptions'])?$_SESSION['data']['defaultglobaloptions']:0;
	$settings = isset($_SESSION['data']['settings'])?$_SESSION['data']['settings']:0;
	$media = isset($_SESSION['data']['media'])?$_SESSION['data']['media']:0;
	$adminpage = isset($_SESSION['data']['adminpage'])?$_SESSION['data']['adminpage']:0;
	
	$currentPage = basename($_SERVER['PHP_SELF']);
	$userid = 0;
	
	if($role == 'admin' || $role == 'subadmin'){
		$userid = $usersessionid;
	} elseif($role == 'superadmin'){
		if (isset($_GET['adminid'])) {
		$userid = $_GET['adminid'];
		}
	} 
	
if($role == 'subadmin'){ 
		if($currentPage == "locations.php") {
		$locationsaccess = mysqli_query($con, "SELECT locationsaccess FROM users WHERE id = '$usersessionsubid'");
		$locationsaccessfetch = mysqli_fetch_assoc($locationsaccess);
		$locationresults = $locationsaccessfetch['locationsaccess'];
			$query = mysqli_query($con, "SELECT * FROM markers WHERE id IN($locationresults)");
		} else {

			$query = mysqli_query($con, "SELECT * FROM markers WHERE adminid = '".$userid."'");
		}
	} else {
		
		if($currentPage == "estimates.php") {
					$query = mysqli_query($con, "SELECT id,date_created,source_url FROM `wp_gf_entry` where form_id=309 order by id desc");
			} 

		else{
			$query = mysqli_query($con, "SELECT * FROM markers WHERE adminid = '".$userid."'");
		}
    
		
	}
	
	if($userid==50){
		$queryzip = mysqli_query($con, "SELECT * FROM zipcodesnew WHERE buss_id = '".$userid."'");
		if (isset($_GET['zipcodeid'])) {
		$zipcodeid = $_GET['zipcodeid'];
		
		$zipcodesquery = mysqli_query($con, "SELECT * FROM zipcodesnew WHERE id='$zipcodeid'");
		$zipcodesdata = mysqli_fetch_assoc($zipcodesquery);
	}
	}
	$userdata = mysqli_query($con, "SELECT * FROM users WHERE adminid = '$userid' && role='admin'");
	$user = mysqli_fetch_assoc($userdata);		
	$superadmindata = mysqli_query($con, "SELECT * FROM users WHERE role='superadmin'");
	$superadmin = mysqli_fetch_assoc($superadmindata);	
	$subuserdata = mysqli_query($con, "SELECT * FROM users WHERE adminid = '$userid' && id = '$usersessionsubid' && role='subadmin'");
	$subuser = mysqli_fetch_assoc($subuserdata);
	$selectadmin = mysqli_query($con, "SELECT * FROM users WHERE role='admin'");
	$selectpackage = mysqli_query($con, "SELECT * FROM packages");
	$packageid = !empty($_GET['packageid'])?$_GET['packageid']:0;
	$packagequery = mysqli_query($con, "SELECT * FROM packages WHERE id='$packageid'");
	$fetchpackage = mysqli_fetch_assoc($packagequery);
	$brands = mysqli_query($con, "SELECT * FROM brandzinfo_brand");
	
	
	$parentname = mysqli_query($con, "SELECT id,name FROM markers WHERE adminid='$userid'");
	$parentnamedata = mysqli_fetch_all($parentname,MYSQLI_ASSOC);
	
	$clientid = !empty($_GET['clientid'])?$_GET['clientid']:0;
	$selectclient = mysqli_query($con, "SELECT * FROM users WHERE id = '$clientid' && role='admin'");
	$fetchclient = mysqli_fetch_assoc($selectclient);

	/*Variables - Page Clients - Start*/
	function locationscount($clientid) {
		global $con;
		$locationscountquery = mysqli_query($con, "SELECT * FROM markers WHERE adminid='$clientid'");
		$locationscount = mysqli_num_rows($locationscountquery);
		return $locationscount;
	}
	/*Variables - Page Clients - End*/
	
	/*Variables - Page Default Global Options - Start*/
	$holiday = mysqli_query($con, "SELECT * FROM businessholidays WHERE adminid='".$userid."'");
	$fetch_holiday = mysqli_fetch_assoc($holiday);
	$global_result = mysqli_query($con, "SELECT * FROM users WHERE adminid= '".$userid."'");
	$fetch_global = mysqli_fetch_assoc($global_result);
	$query_global = mysqli_query($con, "SELECT * FROM globaloptions WHERE adminid='".$userid."'");
	$data_global = mysqli_fetch_assoc($query_global);
   
	$querysubadmin = mysqli_query($con, "SELECT * FROM users WHERE adminid='$userid' && role='subadmin'");
	$edituser = !empty($_GET['edituser'])?$_GET['edituser']:0;
	$editsubadmin = mysqli_query($con, "SELECT * FROM users WHERE id='$edituser' && adminid='$userid' && role='subadmin'");
	$editdatasubadmin = mysqli_fetch_assoc($editsubadmin);
	$useravailablity = mysqli_num_rows($editsubadmin);
	if ($fetch_global !== null && isset($fetch_global['role'])) {
	$role_global = $fetch_global['role'];
	}
	if ($data_global !== null)
	{
	$form_title = $data_global['formtitle'];
	$button_text = $data_global['buttontext'];
	$business_hours_global = $data_global['business_hours'];
	$profileimage_overide_global = $data_global['profileimage_overide'];
    $canonical=$data_global['canonical_url'];
    $title_tag=$data_global['title_tags'];
    $title_tag_override=$data_global['title_tags_override'];
	$trust_badges_global = $data_global['trust_badges'];
	$review_us_global = $data_global['review_us'];
	$custom_reviews_global = $data_global['custom_reviews'];
	$payments_accepted_global = $data_global['payments_accepted'];
	$add_coupon_global = $data_global['add_coupon'];
	$page_layout_global = $data_global['page_layout'];
	$page_content_global = $data_global['page_content'];
	$module_position_global = $data_global['module_position'];
	$sunot_global = $data_global['sunot'];
	$sunct_global = $data_global['sunct'];
	$sunos_global = $data_global['sunos'];
	$monot_global = $data_global['monot'];
	$monct_global = $data_global['monct'];
	$monos_global = $data_global['monos'];
	$tueot_global = $data_global['tueot'];
	$tuect_global = $data_global['tuect'];
	$tueos_global = $data_global['tueos'];
	$wedot_global = $data_global['wedot'];
	$wedct_global = $data_global['wedct'];
	$wedos_global = $data_global['wedos'];
	$thuot_global = $data_global['thuot'];
	$thuct_global = $data_global['thuct'];
	$thuos_global = $data_global['thuos'];
	$friot_global = $data_global['friot'];
	$frict_global = $data_global['frict'];
	$frios_global = $data_global['frios'];
	$satot_global = $data_global['satot'];
	$satct_global = $data_global['satct'];
	$satos_global = $data_global['satos'];
	$pagetitle_global = $data_global['pagetitle'];
	$analytic = $data_global['analytic'];
	$analytic_default = $data_global['analytic_default'];
	$forminput = explode(" &&*&& ", $data_global['forminput']);
	$formplaceholder = explode(" &&*&& ", $data_global['formplaceholder']);
	$formrequired = explode(" &&*&& ", $data_global['formrequired']);
	$profileimage_global = $data_global['profileimage'];
	$pagecontent_global = $data_global['pagecontent'];
	$uploadImage_global = explode(" &&*&& ", $data_global['uploadimage']);
	$trusttext_global = $data_global['trusttext'];
	$trustwebsitelink_global = $data_global['trustwebsitelink'];
	$trusttextoveride_global = $data_global['trusttextoveride'];
	$emailmessageidoveride_global = $data_global['emailmessageidoveride'];
	$emailmessageid_global = $data_global['emailmessageid'];
	$buttontitle_global = $data_global['buttontitle'];
	$buttonlink_global = $data_global['buttonlink'];
	$uploadprofileimage_global = $data_global['uploadprofileimage'];
	$reviewername_global = $data_global['reviewername'];
	$reviewsite_global = $data_global['reviewsite'];
	$rating_global = $data_global['rating'];
	$review_global = $data_global['review'];
	$americanexpress_global = $data_global['americanexpress'];
	$discover_global = $data_global['discover'];
	$applepay_global = $data_global['applepay'];
	$paypal_global = $data_global['paypal'];
	$creditcard_global = $data_global['creditcard'];
	$google_global = $data_global['google'];
	$mastercard_global = $data_global['mastercard'];
	$cash_global = $data_global['cash'];
	$visa_global = $data_global['visa'];
	$uploadcoupanimage_global = $data_global['uploadcoupanimage'];
	$coupontitle_global = $data_global['coupontitle'];
	$coupantext_global = $data_global['coupantext'];
	$coupanlink_global = $data_global['coupanlink'];
	$get_id_global = !empty($_GET['edit'])?$_GET['edit']:0;
        $holidaydata_global = mysqli_query($con,"select *from businessholidays where id='".$get_id_global."'"); 
        $holidayfetch_global = mysqli_fetch_assoc($holidaydata_global);
	$holidayavailability = mysqli_num_rows($holiday);
	$editavailablity = mysqli_num_rows($holidaydata_global);
	$servicesglobal_global = $data_global['services'];	
	$serviceoveride_global = $data_global['serviceoveride'];
	}
	/*Variables - Page Default Global Options - End*/
	
	/*Variables - Page Admin Page Options - Start*/
	$elocationsaccess = mysqli_query($con, "SELECT locationsaccess FROM users WHERE id = '$edituser'");
	$elocationsaccessfetch = mysqli_fetch_assoc($elocationsaccess);
	if ($elocationsaccessfetch !== null && isset($elocationsaccessfetch['locationsaccess'])) {
		$elocationresults = $elocationsaccessfetch['locationsaccess'];
		$elocationresultsarray = explode(',', $elocationresults);
	}
	
	//$elocationresults = $elocationsaccessfetch['locationsaccess'];
	//$elocationresultsarray = explode(',', $elocationresults);
	/*Variables - Page Admin Page Options - End*/
	
	/*Variables - Page Location Edit - Start*/
	$locationid = !empty($_GET['locationid'])?$_GET['locationid']:0;
	
	$query_edit = mysqli_query($con, "select markers.*,locationsurl.url as loc_url from markers left join locationsurl on locationsurl.id=markers.locationurl
		where markers.id='".$locationid."' && markers.adminid='".$userid."'");
	$data = mysqli_fetch_assoc($query_edit);
	$pageavailability = mysqli_num_rows($query_edit);

	
	$edlocationsaccess = mysqli_query($con, "SELECT locationsaccess FROM users WHERE id = '$usersessionsubid'");
	$edlocationsaccessfetch = mysqli_fetch_assoc($edlocationsaccess);
	$edlocationresults = $edlocationsaccessfetch['locationsaccess'];
	$edlocationresultsarray = explode(',', $edlocationresults);
	if ($data !== null) {
		$id_loc = $data['id'];
	
	
	$name = $data['name'];
	$address = $data['address'];
	$addressshow = $data['addressshow'];
	$childcheck = $data['child_check'];
	$addresscheck = $data['address_check'];
	$suite = $data['suite'];	
	$loc_url=$data['loc_url'];
	$common_served_area=$data['common_served_area'];
	$locurlId=$data['locationurl'];
	$lookupID='';
    $brAnd = fetch_brand($userid);
	if($suite!= ''){
        $parentLookup = mysqli_query($con, "SELECT * FROM r1_parent_info_lookUp WHERE parent_license = $suite and brand = $brAnd ");
        if($parentLookup &&  mysqli_num_rows($parentLookup)>0 ){
		$parentLookupfetch = mysqli_fetch_assoc($parentLookup);
		$lookupID = $parentLookupfetch['id'];
        }
	}
	$city = $data['city'];
	$state = $data['state'];
	$zipcode = $data['zipcode'];
	$lat = $data['lat'];
	$lng = $data['lng'];
	$phone = $data['phone'];
	$sunot = $data['sunot'];
	$sunct = $data['sunct'];
	$sunos = $data['sunos'];
	$monot = $data['monot'];
	$monct = $data['monct'];
	$monos = $data['monos'];
	$tueot = $data['tueot'];
	$tuect = $data['tuect'];
	$tueos = $data['tueos'];
	$wedot = $data['wedot'];
	$wedct = $data['wedct'];
	$wedos = $data['wedos'];
	$thuot = $data['thuot'];
	$thuct = $data['thuct'];
	$thuos = $data['thuos'];
	$friot = $data['friot'];
	$frict = $data['frict'];
	$frios = $data['frios'];
	$satot = $data['satot'];
	$satct = $data['satct'];
	$satos = $data['satos'];
	$pagetitle = $data['pagetitle'];
	$profileimage = $data['profileimage'];
	$pagecontent = $data['pagecontent'];
	$trusttext = $data['trusttext'];
	$meta_desc = $data['meta_desc'];
	$review_script = $data['review_script'];
	$custom_reviewstar = $data['custom_reviewstar'];
	$custom_featurereview = $data['custom_featurereview'];
	$custom_reviewscript = $data['custom_reviewscript'];
	$trustwebsitelink = $data['trustwebsitelink'];
	$emailmesageid = $data['emailmesageid'];
	$buttontitle = $data['buttontitle'];
	$buttonlink = $data['buttonlink'];
	$uploadprofileimage = $data['uploadprofileimage'];
	$reviewername = $data['reviewername'];
	$reviewsite = $data['reviewsite'];
	$rating = $data['rating'];
	$review = $data['review'];
	$americanexpress = $data['americanexpress'];
	$discover = $data['discover'];
	$applepay = $data['applepay'];
	$paypal = $data['paypal'];
	$creditcard = $data['creditcard'];
	$google = $data['google'];
	$mastercard = $data['mastercard'];
	$cash = $data['cash'];
	$visa = $data['visa'];
	$uploadcoupanimage = $data['uploadcoupanimage'];
	$coupontitle = $data['coupontitle'];
	$coupantext = $data['coupantext'];
	$coupanlink = $data['coupanlink'];
	$services = $data['services'];	
	$serviceslinks = $data['serviceslink'];	
	$extraZipcode = $data['extra_zipcode'];	
	$extraZipcodelink = $data['extra_zipcode_link'];	
	$title = $data['title_tag'];	
	/*Variables - Page Location Edit - End*/
}
	/*Variables - Page Settings - Start*/
	
	$querythemecolor = mysqli_query($con, "SELECT * FROM settings WHERE adminid = '".$userid."'");
	$themedata = mysqli_fetch_assoc($querythemecolor);
	if ($themedata !== null){
	$backgroundcolor = $themedata['backgroundcolor'];
	$locationbackgroundcolor = $themedata['locationbackgroundcolor'];
	$themecolor = $themedata['themecolor'];
	$locationbackgroundcolor = $themedata['locationbackgroundcolor'];
	$themehovercolor = $themedata['themehovercolor'];
	$formcolor = $themedata['formcolor'];
	$buttonbackground = $themedata['buttonbackground'];
	$buttontextcolor = $themedata['buttontextcolor'];
	$buttonhovercolor = $themedata['buttonhovercolor'];
	}
	/*Variables - Page Settings - End*/
	
	/*Variables - Page Media - Start*/
	$mediaquery = mysqli_query($con, "SELECT media FROM media WHERE adminid='".$userid."'");
	$mediadata = mysqli_fetch_array($mediaquery);
	if ($mediadata !== null){
	$mediaimages = explode("&&*&&", $mediadata['media']);
	krsort($mediaimages);
	}
	/*Variables - Page Media - End*/
	
	/*Variables - Current Year - Start*/
	$currentyear = date('Y');
	
	/*Variables - Current Year - End*/
	
	/*Variables - Analytics - Start*/
	
	function pageviews($locationid) {
		global $con, $userid;
		
		$viewquery = mysqli_query($con, "SELECT totalviews FROM pageviews WHERE adminid='$userid' && locationid='$locationid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		$viewcount = $viewdata['totalviews'];
		return $viewcount;
	}	
	
	function directionclicks($locationid) {
		global $con, $userid;
		
		$viewquery = mysqli_query($con, "SELECT totalviews FROM directionclicks WHERE adminid='$userid' && locationid='$locationid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		$viewcount = $viewdata['totalviews'];
		return $viewcount;
	}	
	
	function callclicks($locationid) {
		global $con, $userid;
		
		$viewquery = mysqli_query($con, "SELECT totalviews FROM callclicks WHERE adminid='$userid' && locationid='$locationid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		$viewcount = $viewdata['totalviews'];
		return $viewcount;
	}

         $currentonemonth = date('F', strtotime("-0 month"));

	 $lastonemonth = date('F', strtotime("first day of -1 month"));
	 $lasttwomonth = date('F', strtotime("first day of -2 month"));
	 $lastthreemonth = date('F', strtotime("first day of -3 month"));
	 $lastfourmonth = date('F', strtotime("first day of -4 month"));
	 $lastfivemonth = date('F', strtotime("first day of -5 month"));
         
$last_week_percentagechange='';
$lastmonthschange='';
$lastyearchange='';
        // $last_week_percentagechange=BillPercentChange('weekly');
        // $lastmonthschange=BillPercentChange('lastmonth');
        // $lastyearchange=BillPercentChange('yearly');
    
      
        // $change_beforeequals_week=$last_week_billing_data/$count_rec*100;
   
         function BillPercentChange($duration)
         {
             global $con,$userid;
            $today_date=date('Y-m-d');
            if($duration=='weekly')
            {
              
            
            $last_sunday= date("Y-m-d",strtotime('last sunday -7 days')); 
            $date1 = new DateTime($today_date);
            $date2 = new DateTime($last_sunday);
            $interval_week = $date1->diff($date2);
            $interval_week_day= $interval_week->d; 
   
            // shows the total amount of days (not divided into years, months and days like above)
            
            $query_before_last_week=mysqli_query($con,"SELECT SUM(amount) FROM all_payments WHERE admin_id='$userid' and created_date <= DATE_SUB('$today_date' ,INTERVAL 7 DAY)");
            $totalbill_till_lastweek=mysqli_fetch_row($con,$query_before_last_week);
            $totalbill_till_lastweek=!empty($totalbill_till_lastweek[0]) ? $totalbill_till_lastweek[0] : 0;

            $query_beforeequals_today=mysqli_query($con,"SELECT SUM(amount) FROM all_payments WHERE  admin_id='$userid' and created_date <= '$today_date'");
            $totalbill_till_date=mysqli_fetch_row($con,$query_beforeequals_today);
            $totalbill_till_date=$totalbill_till_date[0] ? $totalbill_till_date[0] :0;

            $last_week_change=$totalbill_till_date-$totalbill_till_lastweek;

            $percent_change_last_week=($last_week_change/$totalbill_till_lastweek)*100;
            return $percent_change_last_week;
            }else if($duration=='lastmonth')
            {
                //Billing till last month
                global $lastonemonth,$currentonemonth;
              
                $last_monthquery=mysqli_query($con,"Select SUM(amount) from all_payments where  admin_id='$userid' and MONTHNAME(created_date)='$lastonemonth'");
                $last_monthdata=mysqli_fetch_row($last_monthquery);
                $amount_tillastmonth=$last_monthdata[0] ? $last_monthdata[0] :0 ;

               $billing_till_date_query=mysqli_query($con,"Select SUM(amount) from all_payments where  admin_id='$userid' and MONTHNAME(created_date)='$currentonemonth'");
               $billing_till_date=mysqli_fetch_row($billing_till_date_query);
               $billing_till_date1=$billing_till_date[0] ? $billing_till_date[0] : 0;
                $d=$billing_till_date1-$amount_tillastmonth;
               $percent_change_lastmonth=$d/$amount_tillastmonth*100;
              return $percent_change_lastmonth;
            }else if($duration=='yearly')
            {
                $last_year_query=mysqli_query($con,"Select SUM(amount) from all_payments where  admin_id='$userid' and created_date <= date_sub(now(),INTERVAL 1 YEAR)");
                $last_yeardata=mysqli_fetch_row($last_year_query);
                $amount_tillastyear=$last_yeardata[0] ? $last_yeardata[0] :0;
                
              $billing_till_date_query=mysqli_query($con,"Select SUM(amount) from all_payments where  admin_id='$userid' and created_date <= '$today_date'");
              $billing_till_date=mysqli_fetch_row($billing_till_date_query);
              $billing_till_date1=$billing_till_date[0] ? $billing_till_date[0] : 0;
                $d=$billing_till_date1-$amount_tillastyear;
              $percent_change_lastyear=($amount_tillastyear!=0) ? $d/$amount_tillastyear*100 : $billing_till_date1 ;
               return $percent_change_lastyear;
                
            }
             
         }
         
                 $currentMonthAmount=getAggregateAmountByMonth($currentonemonth);
                 $last1monthsAmount=getAggregateAmountByMonth($lastonemonth);
                 $last2monthsAmount=getAggregateAmountByMonth($lasttwomonth);
                 $last3monthsAmount=getAggregateAmountByMonth($lastthreemonth);
                 $last4monthsAmount=getAggregateAmountByMonth($lastfourmonth);
                 $last5monthsAmount=getAggregateAmountByMonth($lastfivemonth);
                 
                $lastyearaggregate=aggregatebillinginlastyear();
                $last7dayaggregate=aggregatebillinginlast7days();
                
                 function getAggregateAmountByMonth($month)
                {
                       global $con;
                       $q=mysqli_query($con,"SELECT sum(amount) as amount FROM all_payments WHERE MONTHNAME(created_date)='$month'");
                       $aggregate_result = mysqli_fetch_assoc($q);
                      return $aggregate_result['amount'];
                }
                
                function aggregatebillinginlastyear()
                {
                    global $con;

                    $q=mysqli_query($con,"SELECT sum(amount) as amount FROM all_payments WHERE created_date > date_sub(now(),INTERVAL 1 year) ");
                       $aggregate_result = mysqli_fetch_assoc($q);
                      return $aggregate_result['amount'];
                    
                }
                
                      function aggregatebillinginlast7days()
                {
                       global $con;

                       $q=mysqli_query($con,"SELECT sum(amount) as amount FROM all_payments WHERE created_date > date_sub(now(),INTERVAL 7 day)");
                       $aggregate_result = mysqli_fetch_assoc($q);
                      return $aggregate_result['amount'];            
                }
                
                
             
         
	
	function monthpageviews($month) {
		global $con, $userid, $locationid;
		
		$viewquery = mysqli_query($con, "SELECT $month FROM pageviews WHERE adminid='$userid' && locationid='$locationid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		if ($viewdata !== null && isset($viewdata[$month])) {
		$viewcount = $viewdata[$month];
		return $viewcount;
		}
		
	}
	
	$currentmonthpageviews = monthpageviews($currentonemonth);
	if($currentmonthpageviews == "") {
		$currentmonthpageviews = 0;
	}
	$lastonemonthpageviews = monthpageviews($lastonemonth);
	if($lastonemonthpageviews == "") {
		$lastonemonthpageviews = 0;
	}
	$lasttwomonthpageviews = monthpageviews($lasttwomonth);
	if($lasttwomonthpageviews == "") {
		$lasttwomonthpageviews = 0;
	}
	$lastthreemonthpageviews = monthpageviews($lastthreemonth);
	if($lastthreemonthpageviews == "") {
		$lastthreemonthpageviews = 0;
	}
	$lastfourmonthpageviews = monthpageviews($lastfourmonth);
	if($lastfourmonthpageviews == "") {
		$lastfourmonthpageviews = 0;
	}
	$lastfivemonthpageviews = monthpageviews($lastfivemonth);
	if($lastfivemonthpageviews == "") {
		$lastfivemonthpageviews = 0;
	}

	function monthcallclicks($month) {
		global $con, $userid, $locationid;
		
		$viewquery = mysqli_query($con, "SELECT $month FROM callclicks WHERE adminid='$userid' && locationid='$locationid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		if ($viewdata !== null && isset($viewdata[$month])) {
		$viewcount = $viewdata[$month];
		return $viewcount;
		}
	}
	
	$currentmonthnumberclicks = monthcallclicks($currentonemonth);
	if($currentmonthnumberclicks == "") {
		$currentmonthnumberclicks = 0;
	}
	$lastonemonthnumberclicks = monthcallclicks($lastonemonth);
	if($lastonemonthnumberclicks == "") {
		$lastonemonthnumberclicks = 0;
	}
	$lasttwomonthnumberclicks = monthcallclicks($lasttwomonth);
	if($lasttwomonthnumberclicks == "") {
		$lasttwomonthnumberclicks = 0;
	}
	$lastthreemonthnumberclicks = monthcallclicks($lastthreemonth);
	if($lastthreemonthnumberclicks == "") {
		$lastthreemonthnumberclicks = 0;
	}
	$lastfourmonthnumberclicks = monthcallclicks($lastfourmonth);
	if($lastfourmonthnumberclicks == "") {
		$lastfourmonthnumberclicks = 0;
	}
	$lastfivemonthnumberclicks = monthcallclicks($lastfivemonth);
	if($lastfivemonthnumberclicks == "") {
		$lastfivemonthnumberclicks = 0;
	}
	
	function monthdirectionclicks($month) {
		global $con, $userid, $locationid;
		
		$viewquery = mysqli_query($con, "SELECT $month FROM directionclicks WHERE adminid='$userid' && locationid='$locationid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		if ($viewdata !== null && isset($viewdata[$month])) {
		$viewcount = $viewdata[$month];
		return $viewcount;
		}
	}
	
	$currentmonthnumberdir = monthdirectionclicks($currentonemonth);
	if($currentmonthnumberdir == "") {
		$currentmonthnumberdir = 0;
	}
	$lastonemonthnumberdir = monthdirectionclicks($lastonemonth);
	if($lastonemonthnumberdir == "") {
		$lastonemonthnumberdir = 0;
	}
	$lasttwomonthnumberdir = monthdirectionclicks($lasttwomonth);
	if($lasttwomonthnumberdir == "") {
		$lasttwomonthnumberdir = 0;
	}
	$lastthreemonthnumberdir = monthdirectionclicks($lastthreemonth);
	if($lastthreemonthnumberdir == "") {
		$lastthreemonthnumberdir = 0;
	}
	$lastfourmonthnumberdir = monthdirectionclicks($lastfourmonth);
	if($lastfourmonthnumberdir == "") {
		$lastfourmonthnumberdir = 0;
	}
	$lastfivemonthnumberdir = monthdirectionclicks($lastfivemonth);
	if($lastfivemonthnumberdir == "") {
		$lastfivemonthnumberdir = 0;
	}
	
	function globalpageviews($month) {
		global $con, $userid;
		
		$viewquery = mysqli_query($con, "SELECT SUM($month) AS totalcount FROM pageviews WHERE adminid='$userid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		$viewcount = $viewdata['totalcount'];
		return $viewcount;
	}
	
	$globalcurrentmonthpageviews = globalpageviews($currentonemonth);
	if($globalcurrentmonthpageviews == "") {
		$globalcurrentmonthpageviews = 0;
	}
	$globallastonemonthpageviews = globalpageviews($lastonemonth);
	if($globallastonemonthpageviews == "") {
		$globallastonemonthpageviews = 0;
	}
	$globallasttwomonthpageviews = globalpageviews($lasttwomonth);
	if($globallasttwomonthpageviews == "") {
		$globallasttwomonthpageviews = 0;
	}
	$globallastthreemonthpageviews = globalpageviews($lastthreemonth);
	if($globallastthreemonthpageviews == "") {
		$globallastthreemonthpageviews = 0;
	}
	$globallastfourmonthpageviews = globalpageviews($lastfourmonth);
	if($globallastfourmonthpageviews == "") {
		$globallastfourmonthpageviews = 0;
	}
	$globallastfivemonthpageviews = globalpageviews($lastfivemonth);
	if($globallastfivemonthpageviews == "") {
		$globallastfivemonthpageviews = 0;
	}
		
	function globaldirectionclicks($month) {
		global $con, $userid;
		
		$viewquery = mysqli_query($con, "SELECT SUM($month) AS totalcount FROM directionclicks WHERE adminid='$userid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		$viewcount = $viewdata['totalcount'];
		return $viewcount;
	}
	
	$globalcurrentmonthclickdirection = globaldirectionclicks($currentonemonth);
	if($globalcurrentmonthclickdirection == "") {
		$globalcurrentmonthclickdirection = 0;
	}
	$globallastonemonthclickdirection = globaldirectionclicks($lastonemonth);
	if($globallastonemonthclickdirection == "") {
		$globallastonemonthclickdirection = 0;
	}
	$globallasttwoclickdirection = globaldirectionclicks($lasttwomonth);
	if($globallasttwoclickdirection == "") {
		$globallasttwoclickdirection = 0;
	}
	$globallastthreemonthclickdirection = globaldirectionclicks($lastthreemonth);
	if($globallastthreemonthclickdirection == "") {
		$globallastthreemonthclickdirection = 0;
	}
	$globallastfourmonthclickdirection = globaldirectionclicks($lastfourmonth);
	if($globallastfourmonthclickdirection == "") {
		$globallastfourmonthclickdirection = 0;
	}
	$globallastfivemonthclickdirection = globaldirectionclicks($lastfivemonth);
	if($globallastfivemonthclickdirection == "") {
		$globallastfivemonthclickdirection = 0;
	}
	
	function globalcallclicks($month) {
		global $con, $userid;
		
		$viewquery = mysqli_query($con, "SELECT SUM($month) AS totalcount FROM callclicks WHERE adminid='$userid'");
		$viewdata = mysqli_fetch_assoc($viewquery);
		$viewcount = $viewdata['totalcount'];
		return $viewcount;
	}
	
	$globalcurrentmonthclickcount = globalcallclicks($currentonemonth);
	if($globalcurrentmonthclickcount == "") {
		$globalcurrentmonthclickcount = 0;
	}
	$globallastonemonthclickcount = globalcallclicks($lastonemonth);
	if($globallastonemonthclickcount == "") {
		$globallastonemonthclickcount = 0;
	}
	$globallasttwomonthclickcount = globalcallclicks($lasttwomonth);
	if($globallasttwomonthclickcount == "") {
		$globallasttwomonthclickcount = 0;
	}
	$globallastthreemonthclickcount = globalcallclicks($lastthreemonth);
	if($globallastthreemonthclickcount == "") {
		$globallastthreemonthclickcount = 0;
	}
	$globallastfourmonthclickcount = globalcallclicks($lastfourmonth);
	if($globallastfourmonthclickcount == "") {
		$globallastfourmonthclickcount = 0;
	}
	$globallastfivemonthclickcount = globalcallclicks($lastfivemonth);
	if($globallastfivemonthclickcount == "") {
		$globallastfivemonthclickcount = 0;
	}
	
	$topviewquery = mysqli_query($con, "SELECT * FROM pageviews WHERE adminid='$userid' ORDER BY totalviews DESC");
	
    function getPaymentByMonth($month) {

		global $con, $userid;	
               
		$paymentquery = mysqli_query($con, "SELECT SUM(amount) AS monthamount FROM all_payments WHERE admin_id=$userid and MONTHNAME(created_date)='$month'");
		if (!$paymentquery) {
			error_log("Error: %s\n" . mysqli_error($con));
			return 0;
		}
		$paymentdata = mysqli_fetch_assoc($paymentquery);
		$totalamount = $paymentdata['monthamount'];
		return $totalamount;
	}
        
        $globalcurrentmonthPayment = getPaymentByMonth($currentonemonth);
	if($globalcurrentmonthPayment == "") {
		$globalcurrentmonthPayment = 0;
	} 
	$globallastonemonthPayment = getPaymentByMonth($lastonemonth);
	if($globallastonemonthPayment == "") {
		$globallastonemonthPayment = 0;
	}
	$globallasttwomonthPayment = getPaymentByMonth($lasttwomonth);
	if($globallasttwomonthPayment == "") {
		$globallasttwomonthPayment = 0;
	}
	$globallastthreemonthPayment = getPaymentByMonth($lastthreemonth);
	if($globallastthreemonthPayment == "") {
		$globallastthreemonthPayment = 0;
	}
	$globallastfourmonthPayment = getPaymentByMonth($lastfourmonth);
	if($globallastfourmonthPayment == "") {
		$globallastfourmonthPayment = 0;
	}
	$globallastfivemonthPayment = getPaymentByMonth($lastfivemonth);
	if($globallastfivemonthPayment == "") {
		$globallastfivemonthPayment = 0;
	}

	function toplocation($toplocationid) {
		global $con, $userid;
		
		$locationquery = mysqli_query($con, "SELECT * FROM markers WHERE adminid='$userid' && id='$toplocationid'");
		$locationdata = mysqli_fetch_assoc($locationquery);
		return array($locationdata['name'], $locationdata['address'], $locationdata['city'], $locationdata['state']);
	}
		/*Page views Changes*/
	$changelastMonthpageviews = ($currentmonthpageviews - $lastonemonthpageviews) * (0.01 * $lastonemonthpageviews);
	$countcurrenttwomonthviews = $currentmonthpageviews + $lastonemonthpageviews;
	$countlasttwomonthviews = $lasttwomonthpageviews + $lastthreemonthpageviews;
	$changetwoMonthviews = ($countcurrenttwomonthviews - $countlasttwomonthviews) * (0.01 * $countlasttwomonthviews);

	$countcurrentthreemonthviews = $currentmonthpageviews + $lastonemonthpageviews + $lasttwomonthpageviews;
	$countlastthreemonthviews = $lastthreemonthpageviews + $lastfourmonthpageviews + $lastfivemonthpageviews;
	$changethreeMonthviews = ($countcurrentthreemonthviews - $countlastthreemonthviews) * (0.01 * $countlastthreemonthviews);
		/*Page views Changes*/

		/*Call Clicks Changes*/
	$changelastMonthcallclicks = ($currentmonthnumberclicks - $lastonemonthnumberclicks) * (0.01 * $lastonemonthnumberclicks);
	$countcurrenttwomonthcallclicks = $currentmonthnumberclicks + $lastonemonthnumberclicks;
	$countlasttwomonthcallclicks = $lasttwomonthnumberclicks + $lastthreemonthnumberclicks;
	$changetwoMonthcallclicks = ($countcurrenttwomonthcallclicks - $countlasttwomonthcallclicks) * (0.01 * $countlasttwomonthcallclicks);

	$countcurrentthreemonthcallclicks = $currentmonthnumberclicks + $lastonemonthnumberclicks + $lasttwomonthnumberclicks;
	$countlastthreemonthcallclicks = $lastthreemonthnumberclicks + $lastfourmonthnumberclicks + $lastfivemonthnumberclicks;
	$changethreeMonthcallclicks = ($countcurrentthreemonthcallclicks - $countlastthreemonthcallclicks) * (0.01 * $countlastthreemonthcallclicks);
		/*Call Clicks Changes*/

		/*Direction Clicks Changes*/
	$changelastMonthdirection = ($currentmonthnumberdir - $lastonemonthnumberdir) * (0.01 * $lastonemonthnumberdir);
	
	$countcurrenttwomonthdirection = $currentmonthnumberdir + $lastonemonthnumberdir;
	$countlasttwomonthdirection = $lasttwomonthnumberdir + $lastthreemonthnumberdir;
	$changetwoMonthdirection = ($countcurrenttwomonthdirection - $countlasttwomonthdirection) * (0.01 * $countlasttwomonthdirection);

	$countcurrentthreemonthdirection = $currentmonthnumberdir + $lastonemonthnumberdir + $lasttwomonthnumberdir;
	$countlastthreemonthdirection = $lastthreemonthnumberdir + $lastfourmonthnumberdir + $lastfivemonthnumberdir;
	$changethreeMonthdirection = ($countcurrentthreemonthdirection - $countlastthreemonthdirection) * (0.01 * $countlastthreemonthdirection);
		/*Direction Clicks Changes*/
		
		/*Global Page views Changes*/
	$changelastMonthpage = ($globalcurrentmonthpageviews - $globallastonemonthpageviews) * (0.01 * $globallastonemonthpageviews);
	$countcurrenttwomonth = $globalcurrentmonthpageviews + $globallastonemonthpageviews;
	$countlasttwomonth = $globallasttwomonthpageviews + $globallastthreemonthpageviews;
	$changetwoMonth = ($countcurrenttwomonth - $countlasttwomonth) * (0.01 * $countlasttwomonth);

	$countcurrentthreemonth = $globalcurrentmonthpageviews + $globallastonemonthpageviews + $globallasttwomonthpageviews;
	$countlastthreemonth = $globallastthreemonthpageviews + $globallastfourmonthpageviews + $globallastfivemonthpageviews;
	$changethreeMonth = ($countcurrentthreemonth - $countlastthreemonth) * (0.01 * $countlastthreemonth);
		/*Global Page views Changes*/

		/*Global Call Clicks Changes*/
	$changelastMonthclicks = ($globalcurrentmonthclickcount - $globallastonemonthclickcount) * (0.01 * $globallastonemonthclickcount);
	$countcurrenttwomonthclicks = $globalcurrentmonthclickcount + $globallastonemonthclickcount;
	$countlasttwomonthclicks = $globallasttwomonthclickcount + $globallastthreemonthclickcount;
	$changetwoMonthclicks = ($countcurrenttwomonthclicks - $countlasttwomonthclicks) * (0.01 * $countlasttwomonthclicks);

	$countcurrentthreemonthclicks = $globalcurrentmonthclickcount + $globallastonemonthclickcount + $globallasttwomonthclickcount;
	$countlastthreemonthclicks = $globallastthreemonthclickcount + $globallastfourmonthclickcount + $globallastfivemonthclickcount;
	$changethreeMonthclicks = ($countcurrentthreemonthclicks - $countlastthreemonthclicks) * (0.01 * $countlastthreemonthclicks);
		/*Global Call Clicks Changes*/

		/*Global Direction Clicks Changes*/
	$changelastMonthdir = ($globalcurrentmonthclickdirection - $globallastonemonthclickdirection) * (0.01 * $globallastonemonthclickdirection);
	
	$countcurrenttwomonthdir = $globalcurrentmonthclickdirection + $globallastonemonthclickdirection;
	$countlasttwomonthdir = $globallasttwoclickdirection + $globallastthreemonthclickdirection;
	$changetwoMonthdir = ($countcurrenttwomonthdir - $countlasttwomonthdir) * (0.01 * $countlasttwomonthdir);

	$countcurrentthreemonthdir = $globalcurrentmonthclickdirection + $globallastonemonthclickdirection + $globallasttwoclickdirection;
	$countlastthreemonthdir = $globallastthreemonthclickdirection + $globallastfourmonthclickdirection + $globallastfivemonthclickdirection;
	$changethreeMonthdir = ($countcurrentthreemonthdir - $countlastthreemonthdir) * (0.01 * $countlastthreemonthdir);
		/*Global Direction Clicks Changes*/
	
	/*Variables - Analytics - End*/
	
	/*Variables - Page Default Global Options - Start*/
	$scriptquery = mysqli_query($con, "SELECT * FROM script WHERE adminid='".$userid."'");
	if(!$scriptquery){
		error_log("scriptquery" . mysqli_error($con));
	} else {
		$scriptdata = mysqli_fetch_assoc($scriptquery);
		$scripttitle = $scriptdata['title'];
		$scriptmeta = $scriptdata['meta'];
		$scriptbootstrapcss = $scriptdata['bootstrapcss'];
		$scriptfontawesomecss = $scriptdata['fontawesomecss'];
		$scriptsweetalertcss = $scriptdata['sweetalertcss'];
		$scriptstorelocatorcss = $scriptdata['storelocatorcss'];
		$scriptmaterialicons = $scriptdata['materialicons'];
		$scripttjquery = $scriptdata['jquery'];
		$scriptbootstrapjs = $scriptdata['bootstrapjs'];
		$scriptsweetalertjs = $scriptdata['sweetalertjs'];
		$scriptstorelocatorjs = $scriptdata['storelocatorjs'];
		$scriptgooglemapsjavascriptapi = $scriptdata['googlemapsjavascriptapi'];
		$scriptgoogleanalytics = $scriptdata['googleanalytics'];
		
	   if($scripttitle == "on") { $titletag = "titletag=on&"; } if($scriptmeta == "on") { $metadescription = "metadescription=on&"; } if($scriptbootstrapcss == "on") { $bootstrapcss = "bootstrapcss=on&"; } if($scriptfontawesomecss == "on") { $fontawesomecss = "fontawesomecss=on&"; } if($scriptsweetalertcss == "on") { $sweetalertcss = "sweetalertcss=on&"; } if($scriptstorelocatorcss == "on") { $storelocatorcss = "storelocatorcss=on&"; } if($scriptmaterialicons == "on") { $materialicons = "materialicons=on&"; } if($scripttjquery == "on") { $jquery = "jquery=on&"; } if($scriptbootstrapjs == "on") { $bootstrapjs = "bootstrapjs=on&"; } if($scriptsweetalertjs == "on") { $sweetalertjs = "sweetalertjs=on&"; } if($scriptstorelocatorjs == "on") { $storelocatorjs = "storelocatorjs=on&"; } if($scriptgooglemapsjavascriptapi == "on") { $googlemapsjavascriptapi = "googlemapsjavascriptapi=on&"; } if($scriptgoogleanalytics == "on") { $googleanalytics = "googleanalytics=on"; }
	   
	   $scriptstructure = $titletag.$metadescription.$bootstrapcss.$fontawesomecss.$sweetalertcss.$storelocatorcss.$materialicons.$jquery.$bootstrapjs.$sweetalertjs.$storelocatorjs.$googlemapsjavascriptapi.$googleanalytics;
	   if($scriptstructure != "") {
		   $scriptstructure = "&".$scriptstructure;
	   }
	}
   

   function fetch_brand($adminU_id){
    if($adminU_id==50){   //for restoration brand is 1
        $brAnd = 1;
    }elseif($adminU_id==51){ // for bluefrog brand is 2
        $brAnd = 2;
    }else{      //for tdc it's 3
        $brAnd = 3;
    }
    return $brAnd;
}
?>