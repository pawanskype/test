<?php 
include "header.php"; ?>

  <body class="admin-panel">
       <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $locations == "on" && in_array($locationsrow['id'], $elocationresultsarray))) { ?>
      <div class="row no-gutter">
       <?php include 'sidebar.php'; ?>
        <div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">Failure Records</h1>
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
				
				<?php if($role=='subadmin'){ ?>
					
					
					<a href="preview" target="_blank" class="preview_btn_sub"><input type="button" class="btn btn-success btn-sm" name="preview" value="Preview"></a>
					
					
				<?php } ?>
                         
            <section class="content-section map-content-section">
			<!--<div id="multiple-marker-map"></div>-->
              <div id="location-list">
				<form action="inc/submit.php" method="POST" id="add-new-user">
				<?php if($role == 'superadmin') { ?>
					<input type="hidden" name="adminid" value="<?php echo $_GET['adminid']; ?>" />
				<?php } ?>
				<!--<table border="0" cellspacing="5" cellpadding="5">
				<tbody>
					<tr>
						<td>Begin Date:</td>
						<td><input type="text" id="min" name="min" data-date-format='dd-mm-yy' class="form-control datepicker date-range-filter" value="" placeholder="Enter Begin Date" /></td>
						<td style="padding-left:10px;">End Date:</td>
						<td><input type="text" id="max" name="max" data-date-format='dd-mm-yy' class="form-control datepicker date-range-filter" value="" placeholder="Enter End Date " /></td>
						<td style="padding-left:10px;"><a href="" class = "clearfilter">Clear</a></td>
					</tr>
				</tbody>
				</table>
				<br>-->
					<div class="table-responsive">
						<table id="locations-table1" class="table table-striped table-bordered admin-location-table" width="100%" cellspacing="0">
						<!--<input type="checkbox" id="checkAll" class="custom-check">-->
							<thead>
								<tr>
									<!--<th></th>-->
									<th class="sort-icons">Child License
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Parent License
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">City
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Zip
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Status
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Remark
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Origin
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
									<th class="sort-icons">Created At
										<i class="material-icons sort-icon-default">sort</i>
										<i class="material-icons sort-icon-down">arrow_downward</i>
										<i class="material-icons sort-icon-up">arrow_upward</i>
									</th>
								</tr>
							</thead>
							<tbody class="list">								
							<?php 
								$query = mysqli_query($con,"SELECT * from r1_failure WHERE buss_id=".$_GET['adminid']); 
								if(!empty($query) && mysqli_num_rows($query)>0 ){	
									while($row = mysqli_fetch_assoc($query)){
										?>
										<tr>
											<!--<td><div class="checkbox"><label><input type="checkbox" class="checkbox" name="checkb[]" value="<?php echo $row['id']; ?>"></label></div></td>-->
											<td class="location-zipcode"><?php echo $row['child_license']; ?></td>
											<td class="location-zipcode"><?php echo $row['parent_license']; ?></td>
											<td class="location-city"><?php echo $row['city']; ?></td>
											<td class="location-zipcode"><?php echo $row['zipcode']; ?></td>
											<td class="location-state"><?php echo $row['status']; ?></td>
											<td class="location-state"><?php echo $row['remark']; ?></td>
											<td class="location-state"><?php echo $row['origin']; ?></td>
											<td class="location-state"><?php echo $row['created_at']; ?></td>
										</tr>
									<?php }
								}
							?>
							</tbody>
						</table>
					</div>
                </form>
              </div>
            </section>
          </div><!-- /.content-wrapper -->
        </div><!-- /.col -->
      </div><!-- /.row -->
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	<?php } ?>
    </div><!-- /.container -->
<?php  $_SESSION['session_adminid']=!empty($_GET['adminid']) ? $_GET['adminid'] : ""; 
	
?>
<?php include 'footer.php'; ?>
<script>
	$(document).ready(function(){
		//$("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true,format: "yyyy-mm-dd" });
        //$("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true,format: "yyyy-mm-dd" });
        
		var table = $('#locations-table1').DataTable({
			"aLengthMenu": [[10, 50, 100, -1], [10, 50, 100]],
			"iDisplayLength": 10
		});
			
		$("#max").datepicker({
			showWeek: true,
			firstDay: 1,
			format: "yyyy-mm-dd"
		});
		
		$("#min").datepicker({
			showWeek: true,
			firstDay: 1,
			format: "yyyy-mm-dd"
		});		

		// Event listener to the two range filtering inputs to redraw on input
		$('#min').on("changeDate", function(ev){
			
			var href = '<?php echo $adminurl.'/r1failureExport?adminid=50&mode=failure'; ?>' + "&mindate="+$(this).val()+"&maxdate="+$("#max").val();	
			$("#exportascsv").attr("href",href);
			$(this).datepicker('hide');			
			table.draw();
		}); 
		
		$('#max').on("changeDate", function(ev){
			
		  var href = '<?php echo $adminurl.'/r1failureExport?adminid=50&mode=failure'; ?>' + "&mindate="+$("#min").val()+"&maxdate="+$(this).val();	
		  $("#exportascsv").attr("href",href);
		  $(this).datepicker('hide');			
		  table.draw();
		}); 
		$('#min').on("change", function(ev){
			
			
			var href = '<?php echo $adminurl.'/r1failureExport?adminid=50&mode=failure'; ?>' + "&mindate="+$(this).val()+"&maxdate="+$("#max").val();
			$(this).datepicker('hide');	
			$("#exportascsv").attr("href",href);			
			table.draw();
		}); 
		
		$('#max').on("change", function(ev){
			
			var href = '<?php echo $adminurl.'/r1failureExport?adminid=50&mode=failure'; ?>' + "&mindate="+$("#min").val()+"&maxdate="+$(this).val();	
			$("#exportascsv").attr("href",href);
			$(this).datepicker('hide');			
			table.draw();
		});
		
		$("#clearfilter").click(function(e){
			e.preventDefault();
			$('#min').val("");
			$('#max').val("");
			table.draw();
			
		});
		
		$.fn.dataTable.ext.search.push(
		function (settings, data, dataIndex) {
			var FilterStart = $('#min').val();
			var FilterEnd = $('#max').val();
			var DataTableStart = data[6].trim();
			
			/*if (FilterStart == null || FilterEnd == null)
			{
				return true;
			}*/
			if (FilterStart == null && FilterEnd == null) { return true; }
			if (FilterStart == null && DataTableStart <= FilterEnd) {return true;}
			if(FilterEnd == null && DataTableStart >= FilterStart) {return true;}
			if (DataTableStart >= FilterStart && DataTableStart <= FilterEnd)
			{
				return true;
			}
			
				return false;
			
			
		});
    
				
        /*$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex,) {
				var min = $('#min').val();		
				var max = $('#max').val();
				var startDate = data[6];
				if (min == null && max == null) { console.log("both NULL");return true; }
				if (min == null && startDate <= max) { console.log("startDate <= max");return true;}
				if(max == null && startDate >= min) {console.log("startDate >= min");return true;}
				if (startDate <= max && startDate >= min) { console.log("in between");return true; }
				return false;
			}
        );*/
           
        });
</script>

