<?php
ini_set("error_reporting", E_ALL);
    include "../phpsqlsearch_dbinfo.php";
    include "../../Functions.php";
	
	$pageviews=''; $callclicks=''; $directionclicks=''; $consultation='';

	if(isset($_POST['consultation']))
		$consultation = $_POST['consultation'];

	if(isset($_POST['pageviews']))
		$pageviews = $_POST['pageviews'];
	
	if(isset($_POST['pageviews']))
		$callclicks = $_POST['callclicks'];
	
	if(isset($_POST['pageviews']))
		$directionclicks = $_POST['directionclicks'];
	if($consultation == "consultation") {
		
		$to = $_POST['to'];
		
		$labelname = $_POST['labelname'];
                for($i=0;$i < count($labelname);$i++)
                {
                    if(strtolower($labelname[$i])=='attachment')
                    {
                        unset($labelname[$i]);
                    }
                }
                $labelname=array_values($labelname);
		$inputval = $_POST['inputval'];
		$labelnamecount = count($labelname);           
		$message = '<div class="email-group"><table>';
		for ($i = 0; $i < $labelnamecount; $i++) {             
                 
			$message .= '<tr><td colspan=2>';
			$message .=  ucfirst($labelname[$i]).'</td><td colspan=2>'.$inputval[$i].'</td>';
			$message .= '</tr>';                
         
		 }
		$message .=	'</table></div>';
$messageBody='<html>            
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Store Locator EmailTemplate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
<style>
.wrapper{max-width:610px ; width:100%; margin:0px auto; }
  
@media only screen and (max-width: 610px){
	.wrapper{ max-width:100%; width:100% float:left;}
	.wrapper div{ width:100%; max-width:100%; }
}
</style>
</head>
<title>Payment failure!</title>
<body style="width:100%; height:100%; font-size:12px; font-family: "Open Sans", sans-serif !important; margin:0px; padding:0px;">
<div style="width:100%; float:left;">
     <div class="wrapper">    
		 <div style="width:100%;float:left; border-bottom: 1px solid rgb(221, 221, 221);background-color: rgba(181, 181, 181, 0.34);">
		     <div style="width:50%;margin:0 auto;padding-bottom: 18px; padding-top: 10px;">
			    <img src="https://restoration1.com/store-locator/admin/defaultimages/logo-restoration.png" style="width:100%;"/>
			</div>
		 </div>	 
		<div style="background-color: rgb(249, 249, 249);float: left;padding: 10px 6px;width: 98%;">
                <div style="width:100%;float:left;">
				<p style="font-size:18px; font-weight:normal;">Hi there!</p><br>
		</div>
                    <div style="width:100%;float:left;">			
                       <p style="font-size:16px;">You have received this email from a user for the "Free Consultation" by "Restoration 1".</p>
                       <p style="font-size:16px;">Below are the full message details : </p>
                     <p style="font-size:16px;">'.$message.'</p>
                   </div>	
                      <div style="width:100%;float:left;padding-top:10px;padding-bottom:10px;">				
                        <p style="font-size:18px;"><b>Thanks so much</b></p>
                        <p style="font-size:16px;"> Restoration1 </p>

	      </div>
		</div>
	<div style="width:100%;float:left;background: rgb(9, 83, 135) none repeat scroll 0 0;">
                 <p style="width:100%;float:left;color:#fff;text-align:center;">Copyright © Restoration1 2020 </p>
	        </div>
		 
     </div>
	
</div>

</body>
</html>';
                
	//$headers = "MIME-Version: 1.0" . "\r\n";
	//$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        
           $target_dir = "../../admin/c_uploads/";
           if(isset($_FILES["inputval"]["tmp_name"][0]) && !empty($_FILES["inputval"]["tmp_name"][0]))
           { 
			   
			$target_file = $target_dir . basename($_FILES["inputval"]["name"][0]);
          
                if(move_uploaded_file($_FILES["inputval"]["tmp_name"][0], $target_file))
                {

                     $name=!empty($_FILES["inputval"]["name"][0]) ? $_FILES["inputval"]["name"][0] : "";      
                     $e=new Functions;
                     $s= $e->sendMail('admin@kindlebit.com',$to, 'Contact Request',$messageBody, $name);
//ritika.sharma
                     if($name){
                     unlink('../../admin/c_uploads/'.$name);
                     }
                    

                }
           }else{
  
			   $e=new Functions;
			   $s= $e->sendMail('admin@kindlebit.com',$to, 'Contact Request',$messageBody,'');
              
		   }
		   echo "Mail sent";
		   die;
	
	} else if($pageviews == "pageviews") {
		echo "Page Views";
		$locationid = $_POST['locationid'];
		$adminid = $_POST['adminid'];
		$currentmonth = date('F', strtotime("-0 month"));
		$lastsixmonth = date('F', strtotime("-6 month"));
		$lastsevenmonth = date('F', strtotime("-7 month"));
		$lasteightmonth = date('F', strtotime("-8 month"));
		$lastninemonth = date('F', strtotime("-9 month"));
		$lasttenmonth = date('F', strtotime("-10 month"));
		$lastelevenmonth = date('F', strtotime("-11 month"));
		
		//$day = date('w');
		//$lasttwoweekstart = date('d-m-Y', strtotime('-'.(14-$day).' days'));
		//$lasttwoweekend = date('d-m-Y', strtotime('-'.(8-$day).' days'));
		//$lastweekstart = date('d-m-Y', strtotime('-'.(7-$day).' days'));
		//$lastweekend = date('d-m-Y', strtotime('-'.(1-$day).' days'));
		//$currentweekstart = date('d-m-Y', strtotime('-'.$day.' days'));
		//$currentweekend = date('d-m-Y', strtotime('+'.(6-$day).' days'));
	
		$pageviewquery = mysqli_query($conn, "SELECT * FROM pageviews WHERE adminid = '$adminid' AND locationid = '$locationid'");
		$pageviewrows = mysqli_num_rows($pageviewquery);
	
		if($pageviewrows == 0) {
			mysqli_query($conn, "INSERT INTO pageviews (adminid, locationid, $currentmonth, totalviews) VALUES ($adminid, $locationid, 1, 1)");
		} else {
			mysqli_query($conn, "UPDATE pageviews SET $currentmonth=$currentmonth + 1,  totalviews=totalviews + 1 WHERE adminid = '$adminid' AND locationid = '$locationid'");
		}
		
		mysqli_query($conn, "UPDATE pageviews SET $lastsixmonth='0', $lastsevenmonth='0', $lasteightmonth='0', $lastninemonth='0', $lasttenmonth='0', $lastelevenmonth='0' WHERE adminid = '$adminid'");
	} else if($callclicks == "callclicks") {
		echo "Call Clicks";
	
		$locationid = $_POST['locationid'];
		$adminid = $_POST['adminid'];
		$currentmonth = date('F', strtotime("-0 month"));
		$lastsixmonth = date('F', strtotime("-6 month"));
		$lastsevenmonth = date('F', strtotime("-7 month"));
		$lasteightmonth = date('F', strtotime("-8 month"));
		$lastninemonth = date('F', strtotime("-9 month"));
		$lasttenmonth = date('F', strtotime("-10 month"));
		$lastelevenmonth = date('F', strtotime("-11 month"));
		
	
		$pageviewquery = mysqli_query($conn, "SELECT * FROM callclicks WHERE adminid = '$adminid' AND locationid = '$locationid'");
		$pageviewrows = mysqli_num_rows($pageviewquery);
	
		if($pageviewrows == 0) {
			mysqli_query($conn, "INSERT INTO callclicks (adminid, locationid, $currentmonth, totalviews) VALUES ($adminid, $locationid, 1, 1)");
		} else {
			mysqli_query($conn, "UPDATE callclicks SET $currentmonth=$currentmonth + 1,  totalviews=totalviews + 1 WHERE adminid = '$adminid' AND locationid = '$locationid'");
		}
		
		mysqli_query($conn, "UPDATE callclicks SET $lastsixmonth='0', $lastsevenmonth='0', $lasteightmonth='0', $lastninemonth='0', $lasttenmonth='0', $lastelevenmonth='0' WHERE adminid = '$adminid'");
	} else if($directionclicks == "directionclicks") {
		echo "Direction Clicks";
			
		$locationid = $_POST['locationid'];
		$adminid = $_POST['adminid'];
		$currentmonth = date('F', strtotime("-0 month"));
		$lastsixmonth = date('F', strtotime("-6 month"));
		$lastsevenmonth = date('F', strtotime("-7 month"));
		$lasteightmonth = date('F', strtotime("-8 month"));
		$lastninemonth = date('F', strtotime("-9 month"));
		$lasttenmonth = date('F', strtotime("-10 month"));
		$lastelevenmonth = date('F', strtotime("-11 month"));
		
		$pageviewquery = mysqli_query($conn, "SELECT * FROM directionclicks WHERE adminid = '$adminid' AND locationid = '$locationid'");
		$pageviewrows = mysqli_num_rows($pageviewquery);
	
		if($pageviewrows == 0) {
			mysqli_query($conn, "INSERT INTO directionclicks (adminid, locationid, $currentmonth, totalviews) VALUES ($adminid, $locationid, 1, 1)");
		} else {
			mysqli_query($conn, "UPDATE directionclicks SET $currentmonth=$currentmonth + 1,  totalviews=totalviews + 1 WHERE adminid = '$adminid' AND locationid = '$locationid'");
		}
		
		mysqli_query($conn, "UPDATE directionclicks SET $lastsixmonth='0', $lastsevenmonth='0', $lasteightmonth='0', $lastninemonth='0', $lasttenmonth='0', $lastelevenmonth='0' WHERE adminid = '$adminid'");
	} else {
		
	}
	
?>
