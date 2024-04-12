<?php include "header.php";


 ?>
 <style>
.sitemapexport
{
	border: 1px solid rgba(0,0,0,.1);
    padding: 10px;
}
</style>

  <body class="admin-panel">
      <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif" /></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $analyticsbylocation == "on")) { ?>
      <div class="row no-gutter">
	   <?php include 'sidebar.php'; ?>
        <div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title" style="float:left;width:35%;">BF JSON Dump Download</h1>
			
			<div class="btn-container sitemapexport">						
						<!--<a href="preview" target="_blank"><input type="button" class="btn btn-success btn-sm" style="float:right" name="preview" value="Preview"></a>-->
						
						<p>Upload Latest GbBIS data for Bluefrog</p>
						
						<span id = "uploadjson"><a href="#" alt="Restore" id = "process1" class="btn btn-primary" >JSON Download(Process 1)</a> &nbsp;&nbsp;<a href="#" alt="Restore" class="btn btn-primary" id = "process2">Process JSON (Process 2)</a></span><span id = "loader" ><img src = "loader.gif" width = "55" height = "55"/> <span id = "process"></span></span>
						
                    </div> 
             
<p id = "msg"></p>			 
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
				
			</div><!-- /.content-wrapper -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	 <?php } ?>
</div><!-- /.container -->

<?php include 'footer.php'; ?>

<script>
  $(document).ready(function(){
	  $("#loader").css("display","none");
	  $("#msg").html("");
	 $("#process1").click(function(e){
		e.preventDefault();
		$("#msg").html("");
		$("#uploadjson").css("display","none");
		$("#loader").css("display","block");
		$("#process").html("Downloading JSON ..");
        $.ajax({
					   type: "POST",
					   url: "process1bf.php",
					   dataType: 'json',
					   timeout: 1200000 ,	// sets timeout to 120 seconds=120000
					   success: function(data) {
						 
						$("#uploadjson").css("display","block");
						$("#loader").css("display","none");
						$("#msg").html(data.msg);
					   }
					}); 		
	 });
     $("#process2").click(function(e){
		 
		e.preventDefault();
		$("#msg").html("");
		$("#uploadjson").css("display","none");
		$("#loader").css("display","block");
		$("#process").html("Processing JSON ..");
        $.ajax({
					   type: "POST",
					   url: "https://store-locator.restoration1.com/admin/process2bf.php",
					   dataType: 'json',
					   success: function(data) {
						
						$("#uploadjson").css("display","block");
						$("#loader").css("display","none");
						$("#msg").html(data.msg);
						
					   }
					});		
	 }); 
	 
	 

	  	 
  });
</script>
