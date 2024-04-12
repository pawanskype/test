<!----------------------Store Locator Script Header Part Start HEADER--------------------------->
<?php
	include "phpsqlsearch_dbinfo.php";
	include "variables.php";
?>
<?php

$titletag = $_GET['titletag'];
$metadescription = $_GET['metadescription'];
$bootstrapcss = $_GET['bootstrapcss'];
$fontawesomecss = $_GET['fontawesomecss'];
$sweetalertcss = $_GET['sweetalertcss'];
$storelocatorcss = $_GET['storelocatorcss'];
$materialicons = $_GET['materialicons'];
$jquery = $_GET['jquery'];
$bootstrapjs = $_GET['bootstrapjs'];
$sweetalertjs = $_GET['sweetalertjs'];
$storelocatorjs = $_GET['storelocatorjs'];
$googlemapsjavascriptapi = $_GET['googlemapsjavascriptapi'];
$googleanalytics = $_GET['googleanalytics'];
?>
<?php if($titletag == "on") { ?>
<?php switch ($loadpage) { 
	case "index": ?>
	<title> <?php
            if(!empty($fetch['title_tags']) && $fetch['title_tags_override']=='on')
            {
				
                echo $fetch['title_tags']; //custom title tags                
            }else{    
                echo 'Location';
                  }
            ?></title> 
            <?php $canonical_url = "https://www.restoration1.com/find-my-location"; ?>
    <link rel="canonical" href="<?= $canonical_url ?>" />
	<?php break; 
	case "location":			
	case "locationdetails":	?>
	<title><?php
            if(isset($title) && $title!='')
            {
				
				//echo str_replace(trim($parentname),ucwords(strtolower($pageData['newcity'])),$title);  
				echo $title;
                        
            }else if(!empty($fetch['title_tags']) && $fetch['title_tags_override']=='on'){    
                    
                    echo str_replace(trim($parentname),ucwords(strtolower($pageData['newcity'])),$fetch['title_tags']);     
                    
             }else{
				 /*  if (strpos($phone, '-') !== false) {
						echo $name.' '.$city.' '.$state.', '.$zipcode.' | '.''.$phone;
				   }else{
						echo $name.' '.$city.' '.$state.', '.$zipcode.' | '.''."(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6);
				   }*/
				   echo '#1 Fire & water Damage Comany serving | '.$name;
				 
				}
            ?>
        </title>
			<?php 	if($slug2 == "detail"){
						$detailslug = "/detail";
					}
				$canonical_url = $scripturl.str_replace(" ","_",$city).'/'.$pageId.$detailslug; ?>
	<link rel="canonical" href="<?= $canonical_url ?>" />
	<?php break;
	case "notfound": ?>
	<title>Not Found</title>
	<?php 
        break;
	default:
           ?>
<?php } 
	}
?>

<?php if($metadescription == "on") { ?>
<?php switch ($loadpage) { 
	case "index": ?>
	<meta name="description" content="Find locations with Google Maps, contact number, address, reviews & many more.">

	<script src="<?php echo $scripturl; ?>/js/storelocator.js"></script>
	<?php break; 
	case "location":
	case "locationdetails":	?>
         <meta name="keywords" content="<?php 
         foreach($addservicesglobal as $value){
            echo $value;             
         }
         foreach($addservices as $value){ 
             echo $value;
         }         
         ?>">
         
         <?php if(isset($metadesc) && $metadesc!=''){ ?>
			 <meta name="description" content="<?php echo str_replace(trim($parentname),ucwords(strtolower($pageData['newcity'])),$metadesc); ?>">
		<?php } else { ?>
			<meta name="description" content="<?php switch($page_content_select) { case "Global Page Content": ?><?php if($pagetitle_global != "") { ?><?php echo strip_tags($pagetitle_global); ?><?php } else { ?><?php } ?><?php break; case "Page Content": ?>	<?php if($pagetitle != "") { ?><?php echo strip_tags($pagetitle); ?><?php } else { ?><?php } ?><?php break; default: ?><?php } ?> <?php switch($page_content_select) { case "Global Page Content": ?><?php if($pagecontent_global != "") { ?><?php echo strip_tags($pagecontent_global); ?><?php } ?><?php break; case "Page Content": ?><?php if($pagecontent != "") { ?><?php echo strip_tags(str_replace(trim($parentname),ucwords(strtolower($pageData['newcity'])),$pagecontent)); ?><?php } ?><?php break; default: ?><?php } ?>">
	<?php } ?>
	
	
        <meta name="robots" content="index, follow">
	<?php break;
	case "notfound": ?>
	<meta name="description" content="Page not found.">
	<?php break;
	default: ?>
<?php } ?>
<?php } ?>
<?php if($bootstrapcss == "on") { ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<?php } ?>
<?php if($fontawesomecss == "on") { ?>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
<?php } ?>
<?php if($sweetalertcss == "on") { ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet"/>
<?php } ?>
<?php if($storelocatorcss == "on") { ?>
<link href="<?php echo $scripturl; ?>/css/storelocator.css" rel="stylesheet"/>
<?php } ?>
<?php if($materialicons == "on") { ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
<?php } ?>
<style>
<?php if($backgroundcolor != "") { ?>
.store-page {
    background: <?php echo $backgroundcolor; ?>;
}
<?php } ?>
<?php if($themecolor != "") { ?>
.store-page .sp-nap-data .sp-nap-name, a, .store-page .sp-nap-data .sp-nap-list > li .icon, .multilistings-item a, .pane-buttons table td a {
    color: <?php echo $themecolor; ?>;
}
<?php } ?>
<?php if($locationbackgroundcolor != "") { ?>
.store-page-bg {
    background-color: <?php echo $locationbackgroundcolor; ?>;
}
<?php } ?>
<?php if($themehovercolor != "") { ?>
a:focus, a:hover, .multilistings-item a:hover, .pane-buttons table td a:hover {
    color: <?php echo $themehovercolor; ?>;
}
.multilistings-item a:hover .location-letter {
	background-color: <?php echo $themehovercolor; ?>;
}
<?php } ?>
<?php if($formcolor != "") { ?>
.store-page .sp-box.sp-box-brand {
    background: <?php echo $formcolor; ?>;
}
<?php } ?>
<?php if($buttonbackground != "") { ?>
.store-page .btn.btn-primary {
    background-color: <?php echo $buttonbackground; ?>;
}
.btn.btn-default {
    background-color: <?php echo $buttonbackground; ?> ;
    border-color: <?php echo $buttonbackground; ?> ;
}
<?php } ?>
<?php if($buttontextcolor != "") { ?>
.store-page .btn.btn-primary, .btn.btn-default {
    color: <?php echo $buttontextcolor; ?>;
}
<?php } ?>
<?php if($buttonhovercolor != "") { ?>
.store-page .btn.btn-primary:hover, .store-page .btn.btn-primary:active, .store-page .btn.btn-primary.active, .btn.btn-default:hover, .btn.btn-default:active, .btn.btn-default.active {
        background-color: <?php echo $buttonhovercolor; ?>;
	border-color: <?php echo $buttonhovercolor; ?> ;
}
<?php } ?>

</style>
<script>
	<?php if($adminId != ""){ ?>var adminid = <?php echo $adminId; ?>;<?php } ?>
	<?php if($lat != ""){ ?>var latitude = <?php echo $lat; ?>;<?php } ?>
	<?php if($lng != ""){ ?>var longitude = <?php echo $lng; ?>;<?php } ?>
	<?php if($name != ""){ ?>var locationname = "<?php echo $name; ?>";<?php } ?>
	<?php if($address != ""){ ?>var locationaddress = "<?php echo $address; ?>";<?php } ?>
	<?php if($addressshow != ""){ ?>var locationaddressshow = "<?php echo $addressshow; ?>";<?php } ?>
	<?php if($city != ""){ ?>var locationcity = "<?php echo $city; ?>";<?php } ?>
	<?php if($state != ""){ ?>var locationstate = "<?php echo $state; ?>";<?php } ?>
	<?php if($phone != ""){ ?>var locationphone = "<?php echo "(".substr($phone, 0, 3).") ".substr($phone, 3, 3)."-".substr($phone,6); ?>";<?php } ?>
	<?php if($locationId != "") { ?>var locationid = <?php echo $locationId; ?>; <?php } ?>
	<?php if($pageId != ""){ ?>var locationslug = "<?php echo $pageId; ?>";<?php } ?>
	<?php if($scripturl != ""){ ?>var scripturl = "<?php echo $scripturl; ?>";<?php } ?>
</script>

<?php if($jquery == "on") { ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<?php } ?>
<?php if($bootstrapjs == "on") { ?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php } ?>
<?php if($sweetalertjs == "on") { ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<?php } ?>
<?php if($storelocatorjs == "on") { ?>
<?php switch ($loadpage) { 
	case "index": ?>
	<script src="<?php echo $scripturl; ?>/js/storelocator.js"></script>
	<?php break; 
	default: ?>
<?php } ?>
<?php } ?>
<?php if($googlemapsjavascriptapi == "on" && isset($_GET["vivit"])) { ?>
   
   <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpeCvppyag5gwbv-_xAPToS9F_nxvjn-s"></script> -->
<?php }elseif($googlemapsjavascriptapi == "on" && !isset($_GET["vivit"])){ ?>
   <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijcw0f7yxzQew8_Rfd-VBrmPjA4d9ndU"></script> -->
<?php }?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcfvCwbcQmmGDFC98uCak_BuvJjOxvJw8&libraries=places"> </script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDijcw0f7yxzQew8_Rfd-VBrmPjA4d9ndU"></script>  -->
<?php if($googleanalytics == "on") { ?>


<?php switch ($loadpage) { 
	case "index": 
		if($canonical_url!=''){
	?>
	<link rel="canonical" href="<?php echo $canonical_url; ?>" />
	<?php } ?>
	<meta name="description" content="Find locations with Google Maps, contact number, address, reviews & many more.">
	<?php break; 
	case "location":
	case "locationdetails":	
		if($analytic_default=='on'){
				echo $analytic;
			}else{
	?>
			<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		  
		  ga('create', 'UA-90644043-1', 'auto');
		  ga('send', 'pageview');
			</script>
	<?php 
		}
	break;
	default: ?>
<?php } ?>
<?php } ?>
<!----------------------Store Locator Script Header Part End--------------------------->
