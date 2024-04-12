$(document).ready(function(){
		var locationForm = $("#location-add");
		$(locationForm).on('submit', function(event){
		var name = $("#name").val();
		var address = $("#address").val();
		var city = $("#city").val();
		var state = $("#state").val();
		var zipcode = $("#zipcode").val();
		var lat = $("#lat").val();
		var lng = $("#lng").val();
		var phone = $("#phone").val();
		var emailmesageid = $("#emailmesageid").val();
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		var profileimage = $("#profileimage").val().split('.').pop().toLowerCase();
		var buttontitle1 = $("#buttontitle1").val();
		var buttonlink1 = $("#buttonlink1").val();
		var url = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
		var reviewername11 = $("#reviewername1").val();
		var reviewsite1 = $("#reviewsite1").val();
		var rating1 = $("#rating1").val();
		var review1 = $("#review1").val();
		var uploadcoupanimage1 = $("#uploadcoupanimage1").val();
		var coupontitle1 = $("#coupontitle1").val();
		var coupantext1 = $("#coupantext1").val();
		var coupanlink1 = $("#coupanlink1").val();
		var contact_number = $("#contact_number").val();
		var business_one = $("#business_one").val();
	    if(business_one == ""){
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#business_one').parent().offset().top}, 'slow');
			$("#business_one").addClass("error");
		} else if (name=="") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#name').parent().offset().top}, 'slow');
			$("#name").addClass("error");
		} else if (address=="") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#address').parent().offset().top}, 'slow');
			$("#address").addClass("error");
		} else if (city=="") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#city').parent().offset().top}, 'slow');
			$("#city").addClass("error");
		} else if (state=="") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#state').parent().offset().top}, 'slow');
			$("#state").addClass("error");
		}  else if (zipcode="" ) {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#zipcode').parent().offset().top}, 'slow');
			$("#zipcode").addClass("error");
		} else if (lat=="" || isNaN(lat) || lat < -90 || lat > 90) {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#lat').parent().offset().top}, 'slow');
			$("#lat").addClass("error");
		} else if (lng=="" || isNaN(lng) || lng < -180 || lng > 180) {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#lng').parent().offset().top}, 'slow');
			$("#lng").addClass("error");
		} else if (phone=="") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#phone').parent().offset().top}, 'slow');
			$("#phone").addClass("error");
		} else if (emailmesageid=="") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#emailmesageid').parent().offset().top}, 'slow');
			$("#emailmesageid").addClass("error");
		} else if (!emailpattern.test(emailmesageid)) {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#emailmesageid').parent().offset().top}, 'slow');
			$("#emailmesageid").addClass("error");
		} else if(buttontitle1 !="" && buttonlink1 == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#buttonlink1').parent().offset().top}, 'slow');
			$("#buttonlink1").addClass("error");
		} else if(buttonlink1 != "" & buttontitle1 == "") {
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#buttontitle1').parent().offset().top}, 'slow');
			$("#buttontitle1").addClass("error");
		}
		
		 /*else if(buttonlink1 != "" && !url.test(buttonlink1)){
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#buttonlink1').parent().offset().top}, 'slow');
			$("#buttonlink1").addClass("error");
		}*/ else if(reviewername11 != "" && reviewsite1 =="" || reviewername11 != "" && rating1 =="" || reviewername11 != "" && review1 =="" || reviewsite1 != "" && reviewername11 =="" || reviewsite1 != "" && rating1 =="" || reviewsite1 != "" && review1 =="" || rating1 != "" && reviewername11 =="" || rating1 != "" && reviewsite1 =="" || rating1 != "" && review1 =="" || review1 != "" && reviewername11 =="" || review1 != "" && reviewsite1 =="" || review1 != "" && rating1 ==""){
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#reviewername1').parent().offset().top}, 'slow');
			if(reviewername11 == "") {
				$("#reviewername1").addClass("error");	
			}
			if(reviewsite1 == "") {
				$("#reviewsite1").addClass("error");	
			}
			if(rating1 == "") {
				$("#rating1").addClass("error");	
			}
			if(review1 == "") {
				$("#review1").addClass("error");	
			}
		} /*else if(uploadcoupanimage1 != "" && coupontitle1 =="" || uploadcoupanimage1 != "" && coupantext1 =="" || uploadcoupanimage1 != "" && coupanlink1 =="" || coupontitle1 != "" && uploadcoupanimage1 =="" || coupontitle1 != "" && coupantext1 =="" || coupontitle1 != "" && coupanlink1 =="" || coupantext1 != "" && uploadcoupanimage1 =="" || coupantext1 != "" && coupontitle1 =="" || coupantext1 != "" && coupanlink1 =="" || coupanlink1 != "" && uploadcoupanimage1 =="" || coupanlink1 != "" && coupontitle1 =="" || coupanlink1 != "" && coupantext1 =="" || coupanlink1 != "" && !url.test(coupanlink1)){
			event.preventDefault();
			$('html, body').animate({scrollTop:$('#uploadcoupanimage1').parent().offset().top}, 'slow');
			if(uploadcoupanimage1 == "") {
				$("#uploadcoupanimage1").addClass("errorimage");	
			}
			if(coupontitle1 == "") {
				$("#coupontitle1").addClass("error");	
			}
			if(coupantext1 == "") {
				$("#coupantext1").addClass("error");	
			}
			if(coupanlink1 == "" || !url.test(coupanlink1)) {
				$("#coupanlink1").addClass("error");	
			}
		}  else {
			$(".buttonlinktest").each(function(){
			if($(this).val()=="" || !url.test(this)) {
				event.preventDefault();
				$(this).addClass("error");
				$('html, body').animate({scrollTop:$(this).parent().offset().top}, 'slow');
				return false;
			}*/
			});
			$(".buttontitletest").each(function(){
			if($(this).val()=="") {
				event.preventDefault();
				$(this).addClass("error");
				$('html, body').animate({scrollTop:$(this).parent().offset().top}, 'slow');
				return false;
			}
			});
		});
		
		$(document).on("keyup", "input.error", function(){
			$(this).removeClass("error");
		});	
		$(document).on("change", "input.error", function(){
			$(this).removeClass("error");
		});
		$(document).on("click", "input.errorimage", function(){
			$(this).removeClass("errorimage");
		});
		$(document).on("click", "textarea.error", function(){
			$(this).removeClass("error");
		});
		$("select").change(function(){
			$(this).removeClass("error");
		});
		
		
		//~ var coupanForm = $("#coupon-form");
		//~ $(coupanForm).on("submit", function(event){
			//~ var url = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/;
			//~ var couponimage = $("#couponimage").val();
			//~ var coupontitle = $("#coupontitle").val();
			//~ var couponlink = $("#couponlink").val();
			
			//~ if(couponimage == "") {
				//~ event.preventDefault();
				//~ $('html, body').animate({scrollTop:$("#couponimage").parent().offset().top}, 'slow');
				//~ $("#couponimage").addClass("errorimage");
			//~ } else if(coupontitle == "") {
				//~ event.preventDefault();
				//~ $('html, body').animate({scrollTop:$("#coupontitle").parent().offset().top}, 'slow');
				//~ $("#coupontitle").addClass("error");
			//~ } else if(couponlink != "" && !url.test(couponlink)) {
				//~ event.preventDefault();
				//~ $('html, body').animate({scrollTop:$("#couponlink").parent().offset().top}, 'slow');
				//~ $("#couponlink").addClass("error");
			//~ } else {
				
			//~ }
		//~ });

	
	
		var editprofileForm = $("#edit-profile-form");
		$(editprofileForm).on("submit", function(event){
			var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
			var mobile_pattern= /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
			var clientname = $("#clientname").val();
                       
			var username = $("#username").val();
			var email = $("#email").val();
			var phone = $("#phone").val();
			var upassword = $("#password").val();
			var repeatpassword = $("#repeat-password").val();
			
			if(clientname == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientname").parent().offset().top}, 'slow');
				$("#clientname").addClass("error");  
		    }	else if(username == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#username").parent().offset().top}, 'slow');
				$("#username").addClass("errorimage");
			} else if(email == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#email").parent().offset().top}, 'slow');
				$("#email").addClass("error");
			} else if(!emailpattern.test(email)) {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#email").parent().offset().top}, 'slow');
				$("#email").addClass("error");
			} else if(phone == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#phone").parent().offset().top}, 'slow');
				$("#phone").addClass("error");
			} else if(upassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#password").parent().offset().top}, 'slow');
				$("#password").addClass("error");
			} else if(repeatpassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#repeat-password").parent().offset().top}, 'slow');
				$("#repeat-password").addClass("error");
			} else if(upassword != repeatpassword) {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#repeat-password").parent().offset().top}, 'slow');
				$("#repeat-password").addClass("error");
			} else {
					
			}
		});
		
		
		var addnewuserform = $("#addnewuserform");
		$(addnewuserform).on("submit", function(event){
			var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
			var mobile_pattern= /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
			var clientname = $("#clientname").val();
             
			var username = $("#username").val();
			var email = $("#email").val();
			var phone = $("#phone").val();
			var upassword = $("#password").val();
			var repeatpassword = $("#repeat-password").val();

			if(clientname == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientname").parent().offset().top}, 'slow');
				$("#clientname").addClass("error"); 
			 }else if(clientaddress == "") {
                             $('html, body').animate({scrollTop:$("#clientaddress").parent().offset().top}, 'slow');
				$("#clientaddress").addClass("error");
                         } else if(username == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#username").parent().offset().top}, 'slow');
				$("#username").addClass("errorimage");
			} else if(email == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#email").parent().offset().top}, 'slow');
				$("#email").addClass("error");
			} else if(!emailpattern.test(email)) {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#email").parent().offset().top}, 'slow');
				$("#email").addClass("error");
			} else if(phone == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#phone").parent().offset().top}, 'slow');
				$("#phone").addClass("error");
			} else if(upassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#password").parent().offset().top}, 'slow');
				$("#password").addClass("error");
			} else if(repeatpassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#repeat-password").parent().offset().top}, 'slow');
				$("#repeat-password").addClass("error");
			} else if(upassword != repeatpassword) {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#repeat-password").parent().offset().top}, 'slow');
				$("#repeat-password").addClass("error");
			} else {
			}
		});
		
		var addaclient = $("#addaclient");
		$(addaclient).on("submit", function(event){
			var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
			var mobile_pattern= /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
			var clientname = $("#clientname").val();
			var clientusername = $("#clientusername").val();
                        var clientaddress=$("#clientaddress").val();
			var clientemail = $("#clientemail").val();
			var clientphone = $("#phone").val();
			var clientbusiness = $("#clientbusiness").val();
			var clientpassword = $("#password").val();
			var reclientpassword = $("#reclientpassword").val();
			var clientpricingpackage = $("#clientpricingpackage").val();
			
			if(clientname == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientname").parent().offset().top}, 'slow');
				$("#clientname").addClass("error"); 
			 }else if(clientaddress==""){
                              event.preventDefault();
                             $('html, body').animate({scrollTop:$("#clientaddress").parent().offset().top}, 'slow');
			     $("#clientaddress").addClass("error");                            
                         } else if(clientusername == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientusername").parent().offset().top}, 'slow');
				$("#clientusername").addClass("errorimage");
			} else if(clientemail == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientemail").parent().offset().top}, 'slow');
				$("#clientemail").addClass("error");
			} else if(!emailpattern.test(clientemail)) {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientemail").parent().offset().top}, 'slow');
				$("#clientemail").addClass("error");
			} else if(clientphone == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#phone").parent().offset().top}, 'slow');
				$("#phone").addClass("error");
			} else if(clientbusiness == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientbusiness").parent().offset().top}, 'slow');
				$("#clientbusiness").addClass("error");
			} else if(clientpassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#password").parent().offset().top}, 'slow');
				$("#password").addClass("error");
			} else if(reclientpassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#reclientpassword").parent().offset().top}, 'slow');
				$("#reclientpassword").addClass("error");
			} else if(clientpassword != reclientpassword) {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#reclientpassword").parent().offset().top}, 'slow');
				$("#reclientpassword").addClass("error");
			}  else if(clientpricingpackage =="") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#clientpricingpackage").parent().offset().top}, 'slow');
				$("#clientpricingpackage").addClass("error");
			} else {
					
			}
		});
		

		var addnewUser = $("#add-new-user");
		$(addnewUser).on("submit", function(event){
			var emailpattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
			var username = $("#username").val();
			var useremail = $("#emailaddress").val();
			var userpassword = $("#userpassword").val();
			var role = $("#role").val();
			var userbusiness = $("#userbusiness").val();
			
	        if(userbusiness == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$("#userbusiness").parent().offset().top}, 'slow');
				$("#userbusiness").addClass("error");  
				
		    }
			else if(username == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#username").parent().offset().top}, 'slow');
				$("#username").addClass("errorimage");
			} else if(useremail == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#emailaddress").parent().offset().top}, 'slow');
				$("#emailaddress").addClass("error");
			} //else if(!emailpattern.test(useremail)) {
				//~ event.preventDefault();
				//~ $('html, body').animate({scrollTop:$("#emailaddress").parent().offset().top}, 'slow');
				//~ $("#emailaddress").addClass("error");
			//~ }
			else if(userpassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#userpassword").parent().offset().top}, 'slow');
				$("#userpassword").addClass("error");
			} else if(userpassword == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#userpassword").parent().offset().top}, 'slow');
				$("#userpassword").addClass("error");
			}else if(role == "") {
				event.preventDefault();
				$('html, body').animate({scrollTop:$("#role").parent().offset().top}, 'slow');
				$("#role").addClass("error");
			} else {
				
			}
		});
		

	

	//Store Phone Number Mask
	$('#phone')
	.keydown(function (e) {
		var key = e.charCode || e.keyCode || 0;
		$phone = $(this);
		if ($phone.val().length === 1 && (key === 8 || key === 46)) {
			$phone.val('('); 
		return false;
		} 
		else if ($phone.val().charAt(0) !== '(') {
			$phone.val('('); 
		}
		if (key !== 8 && key !== 9) {
			if ($phone.val().length === 4) {
				$phone.val($phone.val() + ')');
			}
			if ($phone.val().length === 5) {
				$phone.val($phone.val() + ' ');
			}			
			if ($phone.val().length === 9) {
				$phone.val($phone.val() + '-');
			}
		}
		return (key == 8 || 
				key == 9 ||
				key == 46 ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));	
	})
	.bind('focus click', function () {
		$phone = $(this);
		
		if ($phone.val().length === 0) {
			$phone.val('(');
		}
		else {
			var val = $phone.val();
			$phone.val('').val(val);
		}
	})
	.blur(function () {
		$phone = $(this);
		if ($phone.val() === '(') {
			$phone.val('');
		}
	});
//Store Phone Number Mask

$(document).ready(function() {
    $("#contact_number").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
 
 $(document).ready(function(){
	 var addRemoveform = $("#file-add");
	 $(addRemoveform).on('submit', function(event){
		var file_excel = $("#file_excel").val();
		var business_select = $("#business_select").val();
		if(file_excel == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$('#file_excel').parent().offset().top}, 'slow');
				$("#file_excel").addClass("error");
		} else if(business_select == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$('#business_select').parent().offset().top}, 'slow');
				$("#business_select").addClass("error");
		}
		else {
		}
	});	 
 });
 	
 $(document).ready(function(){
	var addCalenderform = $("#global-options");
	
	 $(addCalenderform).on('submit', function(event){
		 var default_business = $("#default_business").val(); 
		 var holidayname = $("#holidayname").val();
		 var datepicker = $("#datepicker").val();
		
		   if(default_business == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$('#default_business').parent().offset().top}, 'slow');
				$("#default_business").addClass("error");
			 }else if(holidayname == ""){
				 
				event.preventDefault();
				$('html, body').animate({scrollTop:$('#holidayname').parent().offset().top}, 'slow');
				$("#holidayname").addClass("error"); 
			 }else if(datepicker == ""){
			 	event.preventDefault();
				$('html, body').animate({scrollTop:$('#datepicker').parent().offset().top}, 'slow');
				$("#datepicker").addClass("error");  
			 }else{
				 
			} 
		 });
		 
		
		 var mediaForm = $("#media-form");
			$(mediaForm).on('submit', function(event){
				if(($("#filename").val()) == "") {
					event.preventDefault();
					$('html, body').animate({scrollTop:$('#filename').parent().parent().parent().find(".box-title").offset().top}, 'slow');
					$("#filename").addClass("error");
				} else {
					$("#u_load").addClass("disabled");
				}
			});	 
			
		var mediapopForm = $("#media-pop-up");
			$(mediapopForm).on('submit', function(event){
				if(($("#filename").val()) == "") {
					event.preventDefault();
					$("#filename").addClass("error");
				} else {
					event.preventDefault();
					$('#loading').show();
					$.ajax({
					url: "inc/submit.php",
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					success: function(data) {
						$("#filename").val("");
						$(".m-pop-up-images").prepend('<div class="col-sm-3"><div class="media"><img src="'+adminurl+'/uploads/'+data+'" style="height: 164px;"><input type="checkbox" value="'+data+'" class="select-image-box"></div></div>');
						$('#loading').hide();
						$('#image-preview').html("");
					}
					});
				}
			});
			
		 $("#standardprice, #bulkprice, #locationsquantity").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
		});	
		 var addapackage = $("#addapackage");
		 $(addapackage).on('submit', function(event){
		 var packagename = $("#packagename").val(); 
		 var startupfee = $("#startupfee").val(); 
		 var standardprice = $("#standardprice").val();
		 var bulkprice = $("#bulkprice").val();
		 var locationsquantity = $("#locationsquantity").val();
		
		   if(packagename == ""){
			    event.preventDefault();
				$('html, body').animate({scrollTop:$('#packagename').parent().offset().top}, 'slow');
				$("#packagename").addClass("error");
			 } else if(isNaN(startupfee) || startupfee == ""){
				event.preventDefault();
				$('html, body').animate({scrollTop:$('#startupfee').parent().offset().top}, 'slow');
				$("#startupfee").addClass("error"); 
			 }  else if(isNaN(standardprice) || standardprice == ""){
				event.preventDefault();
				$('html, body').animate({scrollTop:$('#standardprice').parent().offset().top}, 'slow');
				$("#standardprice").addClass("error"); 
			 } else if(isNaN(bulkprice) || bulkprice == ""){
			 	event.preventDefault();
				$('html, body').animate({scrollTop:$('#bulkprice').parent().offset().top}, 'slow');
				$("#bulkprice").addClass("error");  
			 }  else if(isNaN(locationsquantity) || locationsquantity == ""){
			 	event.preventDefault();
				$('html, body').animate({scrollTop:$('#locationsquantity').parent().offset().top}, 'slow');
				$("#locationsquantity").addClass("error");  
			 } else {
				 
			} 
		 });
			
                        function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}
                        
			$('body').on("click", "#delete-image", function(event){	
                            
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover again!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete!",
      closeOnConfirm: true,
      showLoaderOnConfirm: true
    },
    function (isConfirm) {
      if (isConfirm) {
        event.preventDefault();
                   //alert("This function is in progress. You can still delete an image from the media page.");
          var adminid = getUrlVars()["adminid"];
          var locationid = getUrlVars()["locationid"];

           var img_name=$(".current-value").val();
           $.ajax({
              type:'POST',
               url:'inc/submit',
               data:{operation:'delete_pop_image',img_name:img_name,adminid:adminid,locationid:locationid},
               success:function(data)
               {
                 if($.trim(data)==$.trim('success'))
                 {
                     $('input[value="'+img_name+'"]').closest('.col-sm-3').hide();
                     $(".select-image-container").html('<div class="select-image"><p>No image selected.</p></div>');
                 }
               }

           });
     
      }
    });
	
   });                     
   });
   
 	function stripeResponseHandler(status, response) {
	  // Grab the form:
	  var $form = $('#payment-form');
var enrol=$('#enrolled').val();
 		$form.find('[type=submit]').html('Validating...');
		$form.find('.submit').prop('disabled', true);
	  if (response.error) { // Problem!
	// Show the errors on the form:
		sweetAlert("Oops...", response.error.message, "error");
		$form.find('[type=submit]').html('Pay Now');
		$form.find('.submit').prop('disabled', false); // Re-enable submission
	  } else { // Token was created!
	// Get the token ID:
		var token = response.id;
		// Insert the token ID into the form so it gets submitted to the server:
		$form.append($('<input type="hidden" name="stripeToken">').val(token));
	
		// Submit the form:
		//$form.get(0).submit();
		//window.location.href="success.php";
		var data=$('#payment-form').serialize(); 
		// Send form to server with POST method
		
if(enrol==0)
{

$.ajax({
		type: "POST",
		url: "crack.php",
		data: data+"&createnew="+1,
		success: function(data){

		if(data.trim()=="success"){
  		$form.find('[type=submit]').html('Successful');
		swal("Congratulations!", "Payment method added successfully!", "success");
		$('#payment-form')[0].reset();
		}
else {
$form.find('[type=submit]').html('Error');
swal("Oops...", data, "error");		
}}
	});

}else{
alert("update in progress!!");
$.ajax({
		type: "POST",
		url: "crack.php",
		data: data+"&update="+1,
		success: function(data){

if(data.trim()=="success"){
  		$form.find('[type=submit]').html('Updated!');
		swal("Congratulations!", "Payment method updated successfully!", "success");
		$('#payment-form')[0].reset();
			}
		}
	});

  }




	  }
	}; 
