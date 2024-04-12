<?php include "header.php";


 ?>
 <style>
   .gbbistable{padding:10px;}
   .rowdarkblue{background-color:#ccccff;}
   .lightblue{background-color:#e6e6ff;}
   .yellow1{background-color:#ffffb3}
   .yellow2{background-color:#ffffcc}
 </style>
  <body class="admin-panel">
      <div class="parentDisable loader loader_style"><img src="defaultimages/loader.gif"></div> 
    <div class="container admin-body">
	<?php if($role == "admin" || $role == "superadmin" || ($role == "subadmin" && $analyticsbylocation == "on")) { ?>
      <div class="row no-gutter">
	   <?php include 'sidebar.php'; ?>
        <div class="col-md-9">
          <div class="content-wrapper">
            <h1 class="page-title">GbBIS Processing Statistics</h1>	
               <?php 
			     $sqldump="SELECT * FROM gbbis_stats ORDER BY id DESC LIMIT 10";
				$result = mysqli_query($con,$sqldump);
				if(!empty($result) && mysqli_num_rows($result)>0){
				  while($row=mysqli_fetch_assoc($result)){
					 
			   ?>
			   <div>
			     <b>Processing Time : </b><?php echo $row["created"];?>
			   </div>
               <table >
                      
					  <th class = "gbbistable rowdarkblue" colspan = "3" style = "text-align:center;">
					     <b>From Json</b>
					  </th>
					  
					  <th class = "gbbistable yellow1" colspan = "4" style = "text-align:center;">
					    <b>In Database</b>
					  </th>
					  
					  
					  <tr>
					     <td class = "gbbistable lightblue" >
						 </td>
						 <td class = "gbbistable lightblue">
						    <b>Owned</b>
						 </td>
						 <td class = "gbbistable lightblue">
						    <b>Donut</b>
						 </td>
						  <td class = "gbbistable yellow2">
						    <b>Owned </b>
						 </td>
						 <td class = "gbbistable yellow2">
						    <b>Donut</b>
						 </td>
						 <td class = "gbbistable yellow2">
						 <b>Failures Owned</b>
						 </td>
						 <td class = "gbbistable yellow2">
						 <b>Failures Donut</b>
						 </td>
					  </tr>
				
					  <tr>
					      <td class = "gbbistable rowdarkblue">
						    <b>Individual Total</b>
						 </td>
						 <td class = "gbbistable rowdarkblue">
						    <?php echo $totaljsonowned =  $row["json_bf_owned"] + $row["json_r1_owned"];?>
						 </td>
						 <td class = "gbbistable rowdarkblue">
						    <?php echo $totaljsondonut = $row["json_bf_donut"] + $row["json_r1_donut"];?>
						 </td>
						 <td class = "gbbistable yellow1">
						    <?php echo $totaldbowned = $row["database_bf_owned"] + $row["database_r1_owned"];?>
						 </td>
						 <td class = "gbbistable yellow1">
						    <?php echo $totaldbdonut = $row["database_bf_donut"] + $row["database_r1_donut"];?>
						 </td>
						 <td class = "gbbistable yellow1">
						  <?php echo $totaldbownedfailures = $row["database_r1_owned_failures"] + $row["database_bf_owned_failures"];?>
						 </td>
						 <td class = "gbbistable yellow1">
						    <?php echo $totaldbdonutfailures = $row["database_r1_donut_failures"] + $row["database_bf_donut_failures"];?>
						 </td>
					  </tr>
					  <tr>
					      <td class = "gbbistable lightblue">
						    <b>Grand Total</b>
						 </td>
						 <td class = "gbbistable lightblue" colspan = "2" style = "text-align:center;">
						    <?php echo $totaljson =  $row["json_bf_owned"] + $row["json_r1_owned"] + $row["json_bf_donut"] + $row["json_r1_donut"];?> (API Json)
						 </td>
						 
						 <td class = "gbbistable yellow2" colspan = "4" style = "text-align:center;">
						    <?php echo $totaldbdonut = $row["database_bf_donut"] + $row["database_r1_donut"]+ $row["database_bf_owned"] + $row["database_r1_owned"] + $row["database_r1_owned_failures"] + $row["database_bf_owned_failures"] + $row["database_r1_donut_failures"] + $row["database_bf_donut_failures"];?> (Database)
						 </td>
						
						 
					  </tr>
               </table> 	
                   <hr/>
				  <?php }} ?>			   
                <!-- <table>
				   <tr>
				     <td>Total Records</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Records Restoration1</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Records Bluefrog</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Records Restoration1 Owned</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Records Restoration1 Donut</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Records Bluefrog Owned</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Records Bluefrog Donut</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success Restoration1</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success Restoration1 Owned</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success Restoration1 Donut</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success Bluefrog</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success Bluefrog Owned</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Success Bluefrog Donut</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Failures</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Failures Restoration1</td>
					 <td></td>
				   </tr>
				    <tr>
				     <td>Total Failures Restoration1 Owned</td>
					 <td></td>
				   </tr>
				    <tr>
				     <td>Total Failures Restoration1 Donut</td>
					 <td></td>
				   </tr>
				   <tr>
				     <td>Total Failures Bluefrog</td>
					 <td></td>
				   </tr>
				    <tr>
				     <td>Total Failures Bluefrog Owned</td>
					 <td></td>
				   </tr>
				    <tr>
				     <td>Total Failures Bluefrog Donut</td>
					 <td></td>
				   </tr>
				</table> -->
			</div><!-- /.content-wrapper -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	<?php } else { ?>
		<?php include "accessdenied.php"; ?>
	 <?php } ?>
</div><!-- /.container -->
<?php include 'footer.php'; ?>

