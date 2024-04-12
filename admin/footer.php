	
	<script>
		var adminurl = "<?php echo $adminurl; ?>";
		function goBack() {
			window.history.go(-1);
		}
	
		/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
		var dropdown = document.getElementsByClassName("dropdown-btn");
		var i;
		for (i = 0; i < dropdown.length; i++) {
		  dropdown[i].addEventListener("click", function() {
		  this.classList.toggle("active");
		  var dropdownContent = this.nextElementSibling;
		  if (dropdownContent.style.display === "block") {
		  dropdownContent.style.display = "none";
		  } else {
		  dropdownContent.style.display = "block";
		  }
		  });
		}

	</script>
	<?php if($currentPage == "billing.php") { ?>
	<script src="https://js.stripe.com/v2/"></script>
	<script>
	// Stripe Code
	Stripe.setPublishableKey('pk_live_4MpvEfv8Q34JvvTqs9DS4zSI');
	$(function() {		
	  var $form = $('#payment-form');
	  var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
	  $form.submit(function(event) {
		 if($("#name_credit_card").val() == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#name_credit_card').parent().offset().top}, 'slow');
			$("#name_credit_card").addClass("error");		 
		} else if($("#credit_card_number").val() == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#credit_card_number').parent().offset().top}, 'slow');
			$("#credit_card_number").addClass("error");
		} else if($("#expiry_month").val() == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('.expiry_cvv').offset().top}, 'slow');
			$("#expiry_month").addClass("error");
		} else if($("#expiry_year").val() == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('.expiry_cvv').offset().top}, 'slow');
			$("#expiry_year").addClass("error");
		} else if($("#cvv").val() == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('.expiry_cvv').offset().top}, 'slow');
			$("#cvv").addClass("error");
		} else {
			// Disable the submit button to prevent repeated clicks:
			$form.find('.submit').prop('disabled', true);
			// Request a token from Stripe:
			Stripe.card.createToken($form, stripeResponseHandler);
			// Prevent the form from being submitted:
			return false;
		}
	  });
	});
	</script>
	<?php } ?>
        <?php 

          
	?>
	<script>
			$(document).ready(function(){
				$('#siteUP').click(function() {
					var adminID = "<?php echo $_GET['adminid'] ?>";
					if($(this).prop("checked") == true){
						$('#bluesitemap').attr('href','script-url?adminid='+adminID+'&upload=true');
					}else{
						$('#bluesitemap').attr('href','script-url?adminid='+adminID+'&upload=false');
					}
				}); 
                                         $(".loader").removeClass('parentDisable'); 
                                         $(".loader").removeClass('loader_style');
                                         $(".loader").hide();
                       				var next = 1;
						$(".add-more").click(function(e){
							e.preventDefault();
							var addto = "#field" + next;
							var addRemove = "#field" + (next);
							next = next + 1;
							var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="field' + next + '" type="text">';
							var newInput = $(newIn);
							var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
							var removeButton = $(removeBtn);
							$(addto).after(newInput);
							$(addRemove).after(removeButton);
							$("#field" + next).attr('data-source',$(addto).attr('data-source'));
							$("#count").val(next);  
							
								$('.remove-me').click(function(e){
									e.preventDefault();
									var fieldNum = this.id.charAt(this.id.length-1);
									var fieldID = "#field" + fieldNum;
									$(this).remove();
									$(fieldID).remove();
								});
						});
			});
	</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.23/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.6.2/tinymce.min.js"></script>
    <script src="<?php echo $adminurl; ?>/js/form-validation.js"></script>
    <script src="<?php echo $adminurl; ?>/js/admin-scripts.js"></script>
    <script src="<?php echo $adminurl; ?>/js/list.min.js"></script>
    <script src="<?php echo $adminurl; ?>/js/bootstrap-datepicker.js"></script>
	
    <script>
     
    $('.datepicker2').datepicker({
      dateFormat: 'mm-dd-yyyy',
      setStartDate: new Date()
}); 
</script>
	<?php if($role == 'superadmin') { ?>
	<script>
		$(document).ready(function(){
			$(".locationchange").on('change', function (){
				var currentbusiness = $(this).val();
				window.location.href = currentbusiness;
			});
			//$(".locationchange").val(window.location.href);
		});
   </script>
	<?php } ?>
	
	<?php if($currentPage == "analyticsbylocation.php") { ?>
	<script src="js/Chart.bundle.min.js"></script>
	<script>
      // Line
      var lineCtx = document.getElementById("page-traffic");
      var myGlobalTraffic = new Chart(lineCtx, {
          type: 'line',
          data: {
    			labels: [<?php echo '"'.$lastfivemonth.'", "'.$lastfourmonth.'", "'.$lastthreemonth.'", "'.$lasttwomonth.'", "'.$lastonemonth.'", "'.$currentonemonth.'"'; ?>],
                datasets: [{
                  label: '# of Visitors',
                  data: [<?php echo $lastfivemonthpageviews.', '.$lastfourmonthpageviews.', '.$lastthreemonthpageviews.', '.$lasttwomonthpageviews.', '.$lastonemonthpageviews.', '.$currentmonthpageviews; ?>],
                  //data: [1253, 1935, 3235, 5235, 2235, 3858],
                  borderColor: "rgba(240,59,32,.9)",
                  backgroundColor: "rgba(240,59,32,.1)",
                  pointBorderWidth: "3",
                  pointBorderColor: "rgba(240,59,32,.9)",
                  pointBackgroundColor: "rgba(240,59,32,.9)",
                  pointHoverBorderWidth: "4",
                  pointHoverBorderColor: "rgba(240,59,32,.9)",
                  pointHoverBackgroundColor: "rgba(240,59,32,.9)"
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero:true
                      }
                  }]
              },
              legend: {
                  display: false
              }
          }
      });

      // Bar
      var barCtx = document.getElementById("page-clicks");
      var myGlobalClicks = new Chart(barCtx, {
          type: 'bar',
          data: {
				labels: [<?php echo '"'.$lastfivemonth.'", "'.$lastfourmonth.'", "'.$lastthreemonth.'", "'.$lasttwomonth.'", "'.$lastonemonth.'", "'.$currentonemonth.'"'; ?>],
				datasets: [
                {
                  label: 'Call Clicks',
                  data: [<?php echo $lastfivemonthnumberclicks.', '.$lastfourmonthnumberclicks.', '.$lastthreemonthnumberclicks.', '.$lasttwomonthnumberclicks.', '.$lastonemonthnumberclicks.', '.$currentmonthnumberclicks; ?>],
                  borderWidth: "0",
                  backgroundColor: "rgba(240,59,32,.9)"
                },
                {
                  label: 'Directions Clicks',
                   data: [<?php echo $lastfivemonthnumberdir.', '.$lastfourmonthnumberdir.', '.$lastthreemonthnumberdir.', '.$lasttwomonthnumberdir.', '.$lastonemonthnumberdir.', '.$currentmonthnumberdir; ?>],
                  borderWidth: "0",
                  backgroundColor: "rgba(254,178,76,.9)"
                },
              ]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero:true
                      }
                  }]
              }
          }
      });
    </script>
	<?php } ?>
	
	<?php if($currentPage == "analytics.php") { ?>
 <script src="js/Chart.bundle.min.js"></script>
 <script>
	  // Line
      var lineCtx = document.getElementById("global-traffic");
      var myGlobalTraffic = new Chart(lineCtx, {
          type: 'line',
          data: {
			  labels: [<?php echo '"'.$lastfivemonth.'", "'.$lastfourmonth.'", "'.$lastthreemonth.'", "'.$lasttwomonth.'", "'.$lastonemonth.'", "'.$currentonemonth.'"'; ?>],
              datasets: [{
                  label: 'Visitors',
                  data: [<?php echo $globallastfivemonthpageviews.', '.$globallastfourmonthpageviews.', '.$globallastthreemonthpageviews.', '.$globallasttwomonthpageviews.', '.$globallastonemonthpageviews.', '.$globalcurrentmonthpageviews; ?>],
                  borderColor: "rgba(43,140,190,.9)",
                  backgroundColor: "rgba(43,140,190,.1)",
                  pointBorderWidth: "3",
                  pointBorderColor: "rgba(43,140,190,.9)",
                  pointBackgroundColor: "rgba(43,140,190,.9)",
                  pointHoverBorderWidth: "4",
                  pointHoverBorderColor: "rgba(43,140,190,.9)",
                  pointHoverBackgroundColor: "rgba(43,140,190,.9)"
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero:true
                      }
                  }]
              },
              legend: {
                  display: false
              }
          }
      });

      // Bar
      var barCtx = document.getElementById("global-clicks");
      var myGlobalClicks = new Chart(barCtx, {
          type: 'bar',
          data: {
              labels: [<?php echo '"'.$lastfivemonth.'", "'.$lastfourmonth.'", "'.$lastthreemonth.'", "'.$lasttwomonth.'", "'.$lastonemonth.'", "'.$currentonemonth.'"'; ?>],
              datasets: [
                {
                  label: 'Call Clicks',
                  data: [<?php echo $globallastfivemonthclickcount.', '.$globallastfourmonthclickcount.', '.$globallastthreemonthclickcount.', '.$globallasttwomonthclickcount.', '.$globallastonemonthclickcount.', '.$globalcurrentmonthclickcount; ?>],
                  borderWidth: "0",
                  backgroundColor: "rgba(43,140,190,.9)"
                },
                {
                  label: 'Directions Clicks',
                  data: [<?php echo $globallastfivemonthclickdirection.', '.$globallastfourmonthclickdirection.', '.$globallastthreemonthclickdirection.', '.$globallasttwoclickdirection.', '.$globallastonemonthclickdirection.', '.$globalcurrentmonthclickdirection; ?>],
                  borderWidth: "0",
                  backgroundColor: "rgba(166,189,219,.9)"
                },
              ]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero:true
                      }
                  }]
              }
          }
      });
    </script>
<?php } ?>

	<?php if($currentPage == "billingreport.php") { ?>
 <script src="js/Chart.bundle.min.js"></script>
 <script>
	  // Line
      var lineCtx = document.getElementById("billing-report");
      var myGlobalTraffic = new Chart(lineCtx, {
          type: 'line',
          data: {
			  labels: [<?php echo '"'.$lastfivemonth.'", "'.$lastfourmonth.'", "'.$lastthreemonth.'", "'.$lasttwomonth.'", "'.$lastonemonth.'", "'.$currentonemonth.'"'; ?>],
              datasets: [{
                  label: 'Billing',
                  data: [<?php echo $globallastfivemonthPayment ?>,<?php echo $globallastfourmonthPayment ?>, <?php echo $globallastthreemonthPayment ?>, <?php echo $globallasttwomonthPayment ?>, <?php echo $globallastonemonthPayment ?>, <?php echo $globalcurrentmonthPayment ?>],
                  borderColor: "rgba(43,140,190,.9)",
                  backgroundColor: "rgba(43,140,190,.1)",
                  pointBorderWidth: "3",
                  pointBorderColor: "rgba(43,140,190,.9)",
                  pointBackgroundColor: "rgba(43,140,190,.9)",
                  pointHoverBorderWidth: "4",
                  pointHoverBorderColor: "rgba(43,140,190,.9)",
                  pointHoverBackgroundColor: "rgba(43,140,190,.9)"
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero:true
                      }
                  }]
              },
              legend: {
                  display: false
              }
          }
      });
    </script>
<?php } ?>
    
    	<?php if($currentPage == "totalbilling.php") { ?>
          <script src="js/Chart.bundle.min.js"></script>
          <script>
	  // Line
          var lineCtx = document.getElementById("billing-report");
          var myGlobalTraffic = new Chart(lineCtx, {
          type: 'line',
          data: {
			  labels: [<?php echo '"'.$lastfivemonth.'", "'.$lastfourmonth.'", "'.$lastthreemonth.'", "'.$lasttwomonth.'", "'.$lastonemonth.'", "'.$currentonemonth.'"'; ?>],
                  datasets: [{
                  label: 'Billing',
                  data: [<?php echo $last5monthsAmount ?>,<?php echo $last4monthsAmount ?>, <?php echo $last3monthsAmount ?>, <?php echo $last2monthsAmount ?>, <?php echo $last1monthsAmount ?>, <?php echo $currentMonthAmount ?>],
                  borderColor: "rgba(43,140,190,.9)",
                  backgroundColor: "rgba(43,140,190,.1)",
                  pointBorderWidth: "3",
                  pointBorderColor: "rgba(43,140,190,.9)",
                  pointBackgroundColor: "rgba(43,140,190,.9)",
                  pointHoverBorderWidth: "4",
                  pointHoverBorderColor: "rgba(43,140,190,.9)",
                  pointHoverBackgroundColor: "rgba(43,140,190,.9)"
              }]
          },
          options: {
              scales: {
                  yAxes: [{
                      ticks: {
                          beginAtZero:true
                      }
                  }]
              },
              legend: {
                  display: false
              }
          }
      });
    </script>
<?php } ?>
   
    <script>
      tinymce.init({
        selector: '.tinymce',
        height: 500,
        plugins: [
          'advlist autolink lists link image charmap print preview anchor',
          'searchreplace visualblocks code fullscreen',
          'insertdatetime media table contextmenu paste code'
        ],
        content_css: [
		  //'//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
          '//www.tinymce.com/css/codepen.min.css'
        ]
      });
    </script>
	<script>
		$(document).ready(function() {
        $(document).on('change', 'input[type="file"]:not(#file_excel)', function() {
          //Get count of selected files
          var countFiles = $(this)[0].files.length;
          var imgPath = $(this)[0].value;
          var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
		  var image_holder = $(this).parent().find(".image-holder");
          image_holder.empty();
          if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
              //loop for each file selected for uploaded.
              for (var i = 0; i < countFiles; i++) 
              {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                  }).appendTo(image_holder);
                }
                image_holder.show();
                reader.readAsDataURL($(this)[0].files[i]);
              }
            } else {
              alert("This browser does not support FileReader.");
            }
          } else {
            alert("Pls select only images");
          }
        });
        
        $(document).on('change','.log-section-changes',function(e){
            var option_selected=$(".log-section-changes option:selected").text().toLowerCase();
                option_selected=$.trim(option_selected);
                if(option_selected=='logout')
                {
                      window.location.href="http://store-locator.lssdev.com/admin/logout";
                }
        });
        
        $(document).on('click','#u_load',function(e){
			  e.preventDefault();
			  $('#media-form').submit();
			  $('#filename').val('');
        });
     });
</script>
<?php if($currentPage == "addlocationcustom.php" || $currentPage == "locationsedit.php") { ?>
	<script src="<?php echo $adminurl; ?>/js/admin-maps.js"></script>
<?php } ?>

<?php if($currentPage == "editzipcode.php" || $currentPage == "addcustomezipcode.php") { ?>
	<script src="<?php echo $adminurl; ?>/js/jquery-customselect.js"></script>
<?php } ?>
</body>
</html>
