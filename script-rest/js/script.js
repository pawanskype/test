//Pages
	
	function goBack() {
		window.history.go(-1);
	}	
	var formConsultation = $('#consultation-form');
		formConsultation.submit(function(event){
		event.preventDefault();
         $(".contact_submit").attr("disabled","disabled");
                var formdata = new FormData(this);
				
               var file_length=$('#file').length;
       
             if(file_length!=0)
             {
                
                formdata.append('file', $('#file')[0].files);
             
            }
               formdata.append('consultation', 'consultation');
              
			   console.log(formdata);
		// var pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
		// var emailVal = $("#email").val();
		// var subVal = $("#subject").val();
		// var messageVal = $("#message").val();
		//if(emailVal == "" || !pattern.test(emailVal)) {
		//	$("#email").addClass("error");
		//} else if(subVal == "") {
		//	$("#subject").addClass("error");
		//} else if(messageVal == "") {
		//	$("#message").addClass("error");
		//} else {
			// var to = $("#to").val();
			// var email = $("#email").val();
			// var subject = $("#subject").val();
			// var message = $("#message").val();
			
			$.ajax({
				url: scripturl + "/inc/consultation.php",
				type:"POST",      
                                 cache: false,
                                processData: false, 
                                 //content-type: 'application/x-www-form-urlencoded', 
                                 contentType:false,
                                 data:formdata,
				//data : $('#consultation-form').serialize() + "&consultation=consultation",
				//data: {to: to, email: email, subject: subject, message: message, consultation: "consultation"},
				success : function(result) {
					console.log('in success of script.js');
					var pageURL = $(location). attr("href");
					var thankpage=pageURL.replace("detail","thank-you");
					window.location.replace(thankpage);
                   /*                        $(".contact_submit").removeAttr("disabled");
					$(formConsultation)[0].reset();
					$(".response-message").slideDown(500);
					$(".response-message").html('<span class="message-success"><i class="fa fa-check-square-o" aria-hidden="true"></i> Message sent successfully.</span>');
					setTimeout(function(){
						$(".response-message").slideUp(500);
						$(".response-message").html("");
					}, 5000);
					*/
				}
			});
		//}
	});
	$(document).on("keyup", "input.error, textarea.error", function(){
		$(this).removeClass("error");
	});
	
	//Call Clicks Function
	function callClicks() {
		$.ajax({
			url: scripturl + "/inc/consultation.php",
			type: "POST",
			data: {locationid: locationid, adminid: adminid, callclicks: "callclicks"},
			success: function(result){
				//alert(result);
			}
		});
	}	
	
	//Call Clicks Function
	function directionClicks() {
		$.ajax({
			url: scripturl + "/inc/consultation.php",
			type: "POST",
			data: {locationid: locationid, adminid: adminid, directionclicks: "directionclicks"},
			success: function(result){
				//alert(result);
			}
		});
	}
	
	// Reviews Read More
	 var showChar = 275;
    var ellipsestext = "...";
    var moretext = "read more";
    $('.review-text').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        $(this).parentsUntil(".review-text").find(".moreellipses").hide();
        $(this).parentsUntil(".review-text").find(".morecontent span").css("display", "inline");
		$(this).hide();
        return false;
    });	

$(document).ready(function() {
$(".sp-sub-list li").each(function() {
	var closed = $(this).find(".hours").html();
	if(closed == "Closed") {
		$(this).addClass("closed");
	}
});
});
