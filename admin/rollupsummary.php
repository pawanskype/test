<?php //

include "header.php"; 

$franchise_id ='';
$form_selcted ='';
$day_count ='';
$startdate  ='';
$enddate   ='';
$msg_count_where  ='';
$open_count_where   ='';
$click_count_where    ='';
?>
<style>
	.custom-location_auto {
		position: relative;
		display: inline-block;
	}
	.custom-location_auto-toggle {
		position: absolute;
		top: 0;
		bottom: 0;
		margin-left: -1px;
		padding: 0;
	}
	.custom-location_auto-input {
		margin: 0;
		padding: 5px 10px;
	}
	</style>
<?php if(in_array($_GET["adminid"],array("50"))){
	
	?>
<?php } ?>
  <body class="admin-panel">
  <script>

	var dataPoints = [];
	var formPoints = [];

</script>
    <div class="container admin-body">
<?php
$admin_val = $_GET['adminid'];
if($admin_val == 50)
    $brand = 1;
else if($admin_val == 51)
    $brand = 2;
else if($admin_val == 52)
    $brand = 3;

	$form_ddl='';	$loc_seletced='';
	$headtext=''; $headBarchart='';
	$sql_where=' WHERE 1=1 ';
$defaultFlag=true;  //need to set it false if any filter is applied

if(isset($_POST['sort_day']) && ($_POST['sort_day'] != '')){
	$defaultFlag=false;
	$day_count=	$_POST['sort_day'];
	$sql_where .=" && ( mail_date <= curdate() and mail_date >= DATE_SUB(curdate(),INTERVAL ".$day_count." day) )";
	
}elseif((isset($_POST['startdate']) && isset($_POST['enddate'])) && (!empty($_POST['startdate']) && !(empty($_POST['startdate'])))){
	$defaultFlag=false;
	$sql_where.="&& (mail_date <= '".$_POST['enddate']."' and mail_date >= '".$_POST['startdate']."')";
}	
if((isset($_POST['location_auto'])) && ($_POST['location_auto'] !='')){
	$defaultFlag=false;
	$loc_seletced=$_POST['location_auto'];
	$sql_loc="SELECT * FROM `r1_parent_license_lookUp` WHERE Parent_Licence=$loc_seletced and brand=$brand";
	$data_locquery = mysqli_query($con,$sql_loc);
	if(count($data_locquery) > 0){
		$franchise_id=$loc_seletced;
		while($locid_result = mysqli_fetch_assoc($data_locquery)){
			$franchise_id.=",".$locid_result['Child_License'];
		}
		 $sql_where.=" && ( franchise_id in(".$franchise_id."))";
	}
}
if(isset($_POST['formid'])  && ($_POST['formid'] != '')){
	$defaultFlag=false;
	 $form_selcted=$_POST['formid'];
	 $sql_where.="&& ( form_id=".$_POST['formid'].")";	
}
//Fetch Location name from markers table
$loc_sql="SELECT suite,name FROM `markers` where adminid= $admin_val order by name asc";
$loc_data = mysqli_query($con,$loc_sql);
$loc_ddl='';
while($loc_result=mysqli_fetch_assoc($loc_data)){
    $loc_nm= trim($loc_result['name']);
    $loc=str_replace("Restoration 1 of ","",$loc_nm);
    $loc_id= $loc_result['suite'];
    if($loc_seletced == $loc_id)
        $loc_ddl.="<option selected value='$loc_id'>$loc</option>";
    else
            $loc_ddl.="<option value='$loc_id'>$loc</option>";
}
if($admin_val == '52'){
    /**************************For TDC Location****************************/
 if(isset($_POST['startdate'])){
	$tdc_rollup_url="https://thedrivewaycompany.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted;
}else{
	$tdc_rollup_url="https://thedrivewaycompany.com/api/rollupdata.php";
}
 $output = file_get_contents($tdc_rollup_url);
 $response = json_decode($output);
	if ($response !== null)
	{
		if($response->status == "success"){
			$rollup_result =$response->result;
			$forms_data =$response->forms_data;
            if(isset($response->graphresult)){
			$graphresult =$response->graphresult;
			$formBarResult =$response->formBarResult;
			$cur_count = $response->cur_count;
			$open_count = $response->open_count;
			$click_count = $response->click_count;
			}
			foreach($forms_data as $val){
				$formid =  $val->id;
				$form_name =  $val->f_name;
				$formArray[$formid]=$form_name;
				if($form_selcted == $formid)
					$form_ddl.="<option selected value='$formid'>$form_name</option>";
				else
					$form_ddl.="<option value='$formid'>$form_name</option>";
			}
		}
	}
}elseif($admin_val == '51'){
    /**************************For TDC Location****************************/
 //$bf_rollup_url="https://bluefrogplumbing.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted."&rollup_summary=true&defaultFlag=".$defaultFlag;

 if(isset($_POST['startdate'])){
	$bf_rollup_url="https://bluefrogplumbing.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted;
}else{
	$bf_rollup_url="https://bluefrogplumbing.com/api/rollupdata.php";
}
 $output = file_get_contents($bf_rollup_url);
 $response = json_decode($output);

	if($response !== null)
	{
			if($response->status === "success"){
				$rollup_result =$response->result;
				$forms_data =$response->forms_data;
				if(isset($response->graphresult)){
					$graphresult =$response->graphresult;
					$formBarResult =$response->formBarResult;
					$cur_count = $response->cur_count;
					$open_count = $response->open_count;
					$click_count = $response->click_count;
				}
				foreach($forms_data as $val){
					$formid =  $val->id;
					$form_name =  $val->f_name;
					$formArray[$formid]=$form_name;
					if($form_selcted == $formid)
						$form_ddl.="<option selected value='$formid'>$form_name</option>";
					else
						$form_ddl.="<option value='$formid'>$form_name</option>";
				}
			}
	}
}
elseif($admin_val == '53'){
    /**************************For TDC Location****************************/
 //$softroc_rollup_url="https://softroc.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted."&rollup_summary=true&defaultFlag=".$defaultFlag;

 if (isset($_POST['startdate'])) {
    $softroc_rollup_url="https://softroc.com/api/rollupdata.php?day_count=".$day_count."&startdate=".$_POST['startdate']."&enddate=".$_POST['enddate']."&franchise_id=".$franchise_id."&form_id=".$form_selcted;
   }else{
       $softroc_rollup_url="https://softroc.com/api/rollupdata.php";
   }
 $output = file_get_contents($softroc_rollup_url);
 $response = json_decode($output);
 if($response->status == "success"){
     $rollup_result =$response->result;
     $forms_data =$response->forms_data;
	 if(isset($response->graphresult)){
		$graphresult =$response->graphresult;
		$formBarResult =$response->formBarResult;
		$cur_count = $response->cur_count;
		$open_count = $response->open_count;
		$click_count = $response->click_count;
	 }
     foreach($forms_data as $val){
         $formid =  $val->id;
         $form_name =  $val->f_name;
         $formArray[$formid]=$form_name;
          if($form_selcted == $formid)
             $form_ddl.="<option selected value='$formid'>$form_name</option>";
         else
             $form_ddl.="<option value='$formid'>$form_name</option>";
     }
 }
}
else{
    $form_sql="SELECT form_id FROM `form_rollups` group by form_id";
	$form_data = mysqli_query($con,$form_sql);

	$formArray=array();			//For getting all forms value and name to show in table below
	while($form_result=mysqli_fetch_assoc($form_data)){
		$formid=$form_result['form_id'];
		$formdbsql="select title from wp_w7smtofx3h_gf_form where id=".$formid;
		$form_namedata = mysqli_query($con,$formdbsql);
		if ($form_namedata) {
		$form_name=mysqli_fetch_row($form_namedata);
		$formArray[$formid]=$form_name[0];
		$form_selcted = '';
			if($formid == 154){
				$form_name="Contact Us";
			}else
				$form_name=$form_name[0];
			
			if($form_selcted == $formid)
				$form_ddl.="<option selected value='$formid'>$form_name</option>";
			else
				$form_ddl.="<option value='$formid'>$form_name</option>";
		}
	}        
    if($defaultFlag == true){		
        $headtext="2 Weeks Data"; $headBarchart="2 Weeks Forms Data";
		$msg_count_where = '';
		$open_count_where ='';
		$click_count_where ='';
    //For last 14 days record by default
        $sql_where.=" && mail_date <= curdate() and mail_date >= DATE_SUB(curdate(),INTERVAL 14 day)";
        $msg_count_where.=" && CAST(mail_date As DATE)=curDATE()-1";
        $open_count_where.=" && CAST(mail_date As DATE)=curDATE()-1";
        $click_count_where.=" && CAST(mail_date As DATE)=curDATE()-1";
    }
        $open_count_where.=" && opens_count > 0";
        $click_count_where.=" && clicks_count > 0";
}
if(isset($graphresult) && !empty($graphresult))
    {
        foreach($graphresult as $graphres){                
            $date_entry=$graphres->count_date;
            $datearr=explode('-', $date_entry);
            ?>
            <script>
            dataPoints.push({
            x: new Date(<?php echo $datearr[0].",". ($datearr[1]-1).",".$datearr[2];?>),//new Date(2012, 01, 1) need this format for date months count start from 0
            y: <?php echo $graphres->totalcount; ?>
        });
        </script>
<?php
        }
        
        foreach($formBarResult as $bar_result){ ?>
            <script>
            formPoints.push({
                y: <?php echo $bar_result->icount; ?>, label: "<?php echo $bar_result->f_name;?>" 
        });
        </script>
     <?php   }
    }
    else
    {       /*******************************For Restoration site********************** */
        //Sql for graph
        $graphSql="SELECT  CAST(mail_date As DATE) as count_date,count(CAST(mail_date As DATE)) as totalcount FROM form_rollups ".$sql_where." group by CAST(mail_date As DATE) order by count_date";
        $graph_resdata = mysqli_query($con,$graphSql);
        while($graph_result = mysqli_fetch_assoc($graph_resdata)){                
                $date_entry=$graph_result['count_date'];
                $datearr=explode('-', $date_entry);
                ?>
                <script>
                dataPoints.push({
                x: new Date(<?php echo $datearr[0].",". ($datearr[1]-1).",".$datearr[2];?>),//new Date(2012, 01, 1) need this format for date months count start from 0
                y: <?php echo $graph_result['totalcount']; ?>
            });
            </script>
    <?php
        }
        
        //Query for Bar chart
        $sql="SELECT count(id)as icount,form_id FROM `form_rollups` ".$sql_where."  group by form_id";
            $form_resdata = mysqli_query($con,$sql);
            while($formgraph_result = mysqli_fetch_assoc($form_resdata)){
                
                $formid=$formgraph_result['form_id'];
                $formdbsql="select title from wp_w7smtofx3h_gf_form where id=".$formid;
                $form_namedata = mysqli_query($con,$formdbsql);
				if ($form_namedata) {
                $form_name=mysqli_fetch_row($form_namedata);
                if($formid == 154){
                    $form_name="Contact Us";
                }else
                    $form_name=$form_name[0];
			}
                ?>
                <script>
                formPoints.push({
                    y: <?php echo $formgraph_result['icount']; ?>, label: "<?php echo $form_name;?>" 
            });
            </script>
<?php
        }
        //fetch no. of records on current date
        $countSql="SELECT count(id) as count from form_rollups ".$sql_where.$msg_count_where;
        $resultSet = mysqli_query($con,$countSql);
        while($result = mysqli_fetch_assoc($resultSet)){
                
                $cur_count=$result['count'];
        }
            
        $opencountsql="SELECT count(id) as count from form_rollups ".$sql_where.$open_count_where;
        $resultSet2 = mysqli_query($con,$opencountsql);
        while($result2 = mysqli_fetch_assoc($resultSet2)){
            
            $open_count=$result2['count'];
        }
            
        $clickcountsql="SELECT count(id) as count from form_rollups ".$sql_where.$click_count_where;
        $resultSet3 = mysqli_query($con,$clickcountsql);
        while($result3 = mysqli_fetch_assoc($resultSet3)){
            
            $click_count=$result3['count'];
        }
    }
        ?>
	<?php if($role == "admin" || $role == "superadmin") { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
	
<div class="content-wrapper">
	<div class="col-md-10">
	 <h1 class="page-title">Rollup Summary</h1>
	<div class="col-sm-12" style="margin:15px 0px;">
           <div class="form-group">
						<label for="name">Select Business<span class="required-star">*</span></label>
				    <select style=" width: 179px;" class="form-control" id="select_loc_business" name="select_location_type">
                     <option s <?php echo ($admin_val == 50) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/rollupsummary.php?adminid=50">Restoration</option>
				        <option  <?php echo ($admin_val == 51) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/rollupsummary.php?adminid=51">BLueFrog</option>
				        <option  <?php echo ($admin_val == 52) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/rollupsummary.php?adminid=52">TDC</option>
				        <option  <?php echo ($admin_val == 53) ? "selected" : ''; ?> value="<?php echo $adminurl;?>/rollupsummary.php?adminid=53">Softroc</option>
				    </select>
					</div>
          </div>
	<form method="post">
		<div class="col-sm-12" style="margin:15px 0px;">
			<div class="col-sm-6">
				<input type="text" id="min_date" name="startdate" data-date-format='dd-mm-yy' class="datepicker" value="<?php if(isset($_POST['startdate'])) echo $_POST['startdate'];?>" placeholder="Start Date" />
					<input type_POST="text" id="max_date" name="enddate" data-date-format='dd-mm-yy' class="datepicker" value="<?php if(isset($_POST['enddate'])) echo $_POST['enddate'];?>"placeholder="End Date">
			</div>
			<div class="col-sm-3">
				<select class="form-control" name='formid'><option value=''>Select Form</option>
						<?php echo $form_ddl; ?>
				</select>		
			</div>
			<div class="col-sm-3">
				
						<select class="form-control" name='sort_day'>
						<option value=''>Select Days Range</option>
						<option <?php if($day_count == 7) echo "selected";?> value='7'>Last 7 Days</option>
						<option <?php if($day_count == 15) echo "selected";?> value='15'>Last 15 Days</option>
						<option <?php if($day_count == 30) echo "selected";?> value='30'>Last 30 Days</option>
						</select>	
			</div>		
		</div>		
		<div class="col-sm-12">
			<div class="col-sm-6">
				<strong>Select Location</strong>
				<select class="form-control" name="location_auto" id="location_auto">
				<option value=''>select location</option>
				<?php echo $loc_ddl; ?>
			</select>		
			</div>
			
			<div class="col-sm-3">
			<input style="width: 100%;" class="btn btn-primary" type="submit" name="ShowData" id="ShowData" value="Search" />	
			</div>
			
			<div class="col-sm-3">
				<a style="float: right;width:100%;" class="btn btn-primary" href="<?php echo $adminurl; ?>/rollupsummary.php?adminid=<?php echo $admin_val; ?>">Clear Filters</a>
			</div>
		</div> 		
	</form>	
	 <?php if(isset($_SESSION['msg_error'])) { ?>
		<div class = "alert alert-danger alert-dismissable">
			<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
			&times;
			</button>
			<?php echo $_SESSION['msg_error']; unset($_SESSION['msg_error']); ?>
		</div>
		<?php } elseif(isset($_SESSION['msg_succ'])) { ?>
		<div class = "alert alert-success alert-dismissable">
		<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
		&times;
		</button>
		<?php echo $_SESSION['msg_succ']; unset($_SESSION['msg_succ']); ?>
		</div>
		<?php } ?>	
		<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:25px;">		
		<div class="col-md-4 col-sm-4 col-xs-12">
			   <div class="rollupbox borderblue">
				  <div class="icon_wrap bgblue">
					 <i class="fa fa-envelope" aria-hidden="true"> </i>
					 <h3 style='color:#fff;'>Messages Received</h3>
				  </div>
				 
				  <h6>	
					<?php echo $cur_count; ?></h6>
			   </div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
			   <div class="rollupbox bordergreen">
				  <div class="icon_wrap bggreen">
					 <i class="fa fa-clock-o" aria-hidden="true"></i>					 
				  <h3 style='color:#fff;'>Open count</h3>
				  </div>
				  <h6>
					<?php echo $open_count; ?></h6>
			   </div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12">
			   <div class="rollupbox">
				  <div class="icon_wrap">
					 <i class="fa fa-mouse-pointer" aria-hidden="true"></i>
				  <h3 style='color:#fff;'>Click count</h3>
				  </div>
				  <h6>
					<?php echo $click_count; ?></h6>
			   </div>
			</div>
		</div>		
		</div>
<hr/>
  <div class="col-md-9 canvas_rollup_chart">
	<div id="chartContainer" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
	</div>
	 <div  class="col-md-9 canvas_rollup_chart">
	<div id="barchartContainer" style="height: 300px; max-width: 920px; margin: 0px auto;"></div>
		<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
		<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>      
    </div><!-- /.content-wrapper -->
  </div><!-- /.col -->
      </div><!-- /.row -->
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	<?php } ?>
    </div><!-- /.container -->
<?php  $_SESSION['session_adminid']=!empty($_GET['adminid']) ? $_GET['adminid'] : ""; 

?>
<script>
window.onload = function() {
var options =  {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "<?php echo $headtext;?>"
	},
	axisX: {
		valueFormatString: "DD MMM YYYY",
	},
	axisY: {
		title: "Submissions",
		titleFontSize: 24
	},
	data: [{
		type: "spline", 
		yValueFormatString: "###",
		dataPoints: dataPoints
	}]
};


	$("#chartContainer").CanvasJSChart(options);

	
	
	//For Bar chart based on form id
	var options =  {
	animationEnabled: true,
	theme: "light2",
	title: {
		text: "<? echo $headBarchart;?>"
	},	
	axisY:{
		interlacedColor: "rgba(1,77,101,.2)",
		gridColor: "rgba(1,77,101,.1)",
		title: "Form Id"
	},
	data: [{
		type: "column",
		axisYType: "secondary",
		color: "#014D65", 
		dataPoints: formPoints
	}]
};


	$("#barchartContainer").CanvasJSChart(options);
}

/* for autocomplete Location */
$( function() {
		$.widget( "custom.location_auto", {
			_create: function() {
				this.wrapper = $( "<span>" )
					.addClass( "custom-location_auto" )
					.insertAfter( this.element );

				this.element.hide();
				this._createAutocomplete();
				this._createShowAllButton();
			},

			_createAutocomplete: function() {
				var selected = this.element.children( ":selected" ),
					value = selected.val() ? selected.text() : "";

				this.input = $( "<input>" )
					.appendTo( this.wrapper )
					.val( value )
					.attr( "title", "" )
					.addClass( "custom-location_auto-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: $.proxy( this, "_source" )
					})
					.tooltip({
						classes: {
							"ui-tooltip": "ui-state-highlight"
						}
					});

				this._on( this.input, {
					autocompleteselect: function( event, ui ) {
						ui.item.option.selected = true;
						this._trigger( "select", event, {
							item: ui.item.option
						});
					},

					autocompletechange: "_removeIfInvalid"
				});
			},

			_createShowAllButton: function() {
				var input = this.input,
					wasOpen = false;

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Locations" )
					.tooltip()
					.appendTo( this.wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "custom-location_auto-toggle ui-corner-right" )
					.on( "mousedown", function() {
						wasOpen = input.autocomplete( "widget" ).is( ":visible" );
					})
					.on( "click", function() {
						input.trigger( "focus" );

						// Close if already visible
						if ( wasOpen ) {
							return;
						}

						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
			},

			_source: function( request, response ) {
				var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
				response( this.element.children( "option" ).map(function() {
					var text = $( this ).text();
					if ( this.value && ( !request.term || matcher.test(text) ) )
						return {
							label: text,
							value: text,
							option: this
						};
				}) );
			},

			_removeIfInvalid: function( event, ui ) {

				// Selected an item, nothing to do
				if ( ui.item ) {
					return;
				}

				// Search for a match (case-insensitive)
				var value = this.input.val(),
					valueLowerCase = value.toLowerCase(),
					valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});

				// Found a match, nothing to do
				if ( valid ) {
					return;
				}

				// Remove invalid value
				this.input
					.val( "" )
					.attr( "title", value + " didn't match any item" )
					.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});

		$( "#location_auto" ).location_auto();
		$( "#toggle" ).on( "click", function() {
			$( "#location_auto" ).toggle();
		});
	} );
  
</script>
<?php include 'footer.php'; ?>
