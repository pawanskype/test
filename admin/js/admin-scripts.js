$(document).ready(function(){
	
	/*Script - Function Back - Start*/
	function goBack() {
		window.history.go(-1);
	}
	/*Script - Function Back - End*/

$('#select_location_type').change(function(){
   $("#AdminID").val($(this).val()); 
});
$('#select_loc_business').change(function(){
  	var currentbusiness = $(this).val();
	window.location.href = currentbusiness;
});
/*Delete Function Start*/
	$('.delete').on('click',function(e, data){
	if(!data){
		handleDelete(e, 1);
    } else {
		window.location = $(this).attr('href');
    }
	});
function handleDelete(e, stop){
  if(stop){
    e.preventDefault();
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover again!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete!",
      closeOnConfirm: false
    },
    function (isConfirm) {
      if (isConfirm) {
        $('.delete').trigger('click', {});
      }
    });
  }
}
/*Delete Function End*/

/*Deactivate Function Start*/
	$('.deactivate').on('click',function(e, data){
	if(!data){
		handleDeactivate(e, 1);
    } else {
		window.location = $(this).attr('href');
    }
	});
function handleDeactivate(e, stop){
  if(stop){
    e.preventDefault();
    swal({
      title: "Are you sure?",
      text: "You can update it again!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#f0ad4e",
      confirmButtonText: "Yes, activate/deactivate!",
      closeOnConfirm: false
    },
    function (isDeactivate) {
      if (isDeactivate) {
        $('.deactivate').trigger('click', {});
      }
    });
  }
}
/*Deactivate Function End*/

/*Delete Client Function Start*/
$('.deleteclient').on('click',function(e, data){
	if(!data){
		handledeleteClient(e, 1);
    } else {
		window.location = $(this).attr('href');
    }
	});
function handledeleteClient(e, stop){
  if(stop){
    e.preventDefault();
    swal({
      title: "Think again. Are you sure?",
      text: "All the data related to this business will be deleted permanently & you will not be able to recover again! You have option to deactivate the client(s).",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete!",
      closeOnConfirm: false
    },
    function (isconfirmClient) {
      if (isconfirmClient) {
        $('.deleteclient').trigger('click', {});
      }
    });
  }
}
/*Delete Client Function End*/

	 var imgHeight = $('.media img').width();
	$('.media img').css({'height':imgHeight+'px'});
	$(window).resize(function(){
		var imgHeight = $('.media img').width();
		$('.media img').css({'height':imgHeight+'px'});
	});	
	
	var imgselectHeight = $('.select-image img').width();
	$('.select-image img').css({'height':imgselectHeight+'px'});
	$(window).resize(function(){
		var imgselectHeight = $('.select-image img').width();
		$('.select-image img').css({'height':imgselectHeight+'px'});
	});
	
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#image-preview').html('<img src="'+e.target.result+'" alt="Image Preview" />');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#filename").change(function(){
		readURL(this);
	});
	$('body').on("change", ".select-image-box", function(){
        
		$('.select-image-box').not(this).prop('checked', false);
		var currentImage = $(this).val();
		$(".select-image").html('<img src="uploads/'+currentImage+'" alt="Image Select" /><input class="current-value" type="hidden" value="'+currentImage+'"><button class="btn btn-success btn-round single-image-select" id="select-image">Select Image</button>');
		var imgselectHeight = $('.select-image img').width();
		$('.select-image img').css({'height':imgselectHeight+'px'});
	});
        
        	$('body').on("change", ".select_tag", function(){
                     var select_val=$(this).val();
                     var total_radio=0;
               
                     if(select_val=='file')
                     {
                       $(this).parent().siblings(':first').find('.select_text').text('Attachment');
                        $(this).parent().siblings(':first').find('.select_text').attr('readOnly','readOnly');
                     }
                      if(select_val=='select')
                     {

                       $(this).parent().siblings(':first').find('.select_text').val('');
                        $(this).parent().siblings(':first').find('.select_text').attr("placeholder", "E.g Option/Option2");
                     }
                    
                      if(select_val=='radio')
                      {
                          $(".select_tag").each(function(){
                              var previous_val=$(this).val();
                              if(previous_val=='radio')
                              {
                                 total_radio++;
                              }
                          });
                        if(total_radio >1)
                        {
                            
                            $("#select_tag_error").text("You can add only one radio button.");
                            $(".select_tag_error_div").show();
                            $(this).parents('.form-group:first').remove();
                        }
                          
                      }
	});
        
        

        
	$('body').on("click", ".add-image-media", function(event){	
		event.preventDefault();
		$(".media-pop-up").show();
		$(".image-holder").removeClass("current-image");
		$(this).parent().find(".image-holder").addClass("current-image");
		var imgHeight = $('.media img').width();
		$('.media img').css({'height':imgHeight+'px'});
	});
	$('body').on("click", "#select-image", function(event){
		event.preventDefault();
		$(".media-pop-up").hide();
		var currentselectedImage = $(".current-value").val();
		$(".current-image").html('<img src="uploads/'+currentselectedImage+'" alt="Selected Image" style="width:80px; height:80px; margin-right:20px; margin-bottom:15px;"/>');
		$(".current-image").parent().find("input").val(currentselectedImage);
	});
	$(".material-close").click(function(){
		$(".media-pop-up").hide();
	});
	$('body').on("click", ".select-delete-image", function(event){
    
		event.preventDefault();
		$(this).parent().parent().find("input").val("");
		$(this).parents().closest('.trust-bagde-group').remove();
	});
	
	/*Date picker function start*/
   $("#datepicker").datepicker({
		showWeek: true,
		firstDay: 1,
		format: "dd-mm-yyyy"
	});
	$("#datepicker").on("changeDate", function(ev){
		$(this).datepicker('hide');
	});
	
	 $("#max_date").datepicker({
		showWeek: true,
		firstDay: 1,
		format: "yyyy-mm-dd"
	});
	$("#max_date").on("changeDate", function(ev){
		$(this).datepicker('hide');
	});
	
	$("#min_date").datepicker({
		showWeek: true,
		firstDay: 1,
		format: "yyyy-mm-dd"
	});
	$("#min_date").on("changeDate", function(ev){
		$(this).datepicker('hide');
	});
	/*Date picker function end*/
	
	/*Script - Check Multiple Checkboxes - Start*/
	$('#checkAll').click(function(event) {
	    if(this.checked) {
            $('.checkbox').each(function() {
                this.checked = true;           
            });
        }else{
            $('.checkbox').each(function() {
                this.checked = false;                     
            });        
        }
    });
/*Script - Check Multiple Checkboxes - End*/
/*Script - Datable - Global Page - Start*/
	$('#holiday-table').DataTable({
		"aLengthMenu": [[3, 5, 10, 20, -1], [3, 5, 10, 20, "All"]],
        "iDisplayLength": 3
	});
/*Script - Datable - Global Page - End*/

/*Script - Datable - Analytics by Location - Start*/
	$('#analytics-by-location').DataTable({
		"aLengthMenu": [[5, 10, 20, 25, -1], [5, 10, 20, 25, "All"]],
        "iDisplayLength": 5
	});
/*Script - Datable - Analytics by Location - End*/

/*Script - Datable - Adminpage - Start*/
	$('#admin-page').DataTable({
		"aLengthMenu": [[5, 10, 20, 25, -1], [5, 10, 20, 25, "All"]],
        "iDisplayLength": 5
	});
/*Script - Datable - Adminpage - End*/

/*Script - Datable - Client Page - Start*/
	$('#client-list').DataTable({
		"aLengthMenu": [[5, 10, 20, 25, -1], [5, 10, 20, 25, "All"]],
        "iDisplayLength": 5
	});
/*Script - Datable - Client Page - End*/
});
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	var typingTimer;
	var doneTypingInterval = 3000;

	$("#address, #city, #state").on("keyup", function () {
		addressValue = $(this).val();
		clearTimeout(typingTimer);
				
	if(addressValue) {
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	}
});
function doneTyping(){
	codeAddress();
	return false;
}
i = 1;
	$("#add-review-btn").click(function(event){
		i++;
		var buttontitle = "buttontitle"+i;
		var buttonlink = "buttonlink"+i;
		event.preventDefault();
		var reviewGroup = '<div class="review-group"><div class="form-group"><label for="'+buttontitle+'">Button Title</label><input type="text" id="'+buttontitle+'" name="buttontitle[]" class="form-control buttontitletest" placeholder="Enter button title (ex. Review Us On Yelp)" /></div><div class="form-group"><label for="'+buttonlink+'">Button Link</label><input type="text" id="'+buttonlink+'" name="buttonlink[]" class="form-control buttonlinktest" placeholder="Enter button link (ex. http://www.example.com)" /></div><div class="remove-review-btn"><button class="btn btn-default btn-round remove-btn">Remove Button</button></div></div>';
		$(".review-group-container").append(reviewGroup);
	});
	$('body').on("click", ".remove-btn", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();
	});
	
	$("#add-review-btn-zip").click(function(event){
		i++;
		var buttontitle = "buttontitle"+i;
		var buttonlink = "buttonlink"+i;
		event.preventDefault();
		var reviewGroup = '<div class="review-group"><div class="form-group"><label for="'+buttontitle+'">Location Name</label><input type="text" id="'+buttontitle+'" name="zip_name[]" class="form-control buttontitletest" placeholder="Enter location name" /></div><div class="form-group" required><label for="'+buttonlink+'">Zip Code</label><input type="text" id="'+buttonlink+'" name="zipcode[]" class="form-control buttonlinktest" placeholder="Enter zipcode (ex. 12345)" required /><label for="'+buttonlink+'">State</label><input type="text" id="'+buttonlink+'" name="state[]" class="form-control buttonlinktest" placeholder="Enter State" /><label for="'+buttonlink+'">County</label><input type="text" id="'+buttonlink+'" name="country[]" class="form-control buttonlinktest" placeholder="Enter county" /><label for="'+buttontitle+'">Location ID</label><input type="text" id="'+buttonlink+'" name="loc_id[]" class="form-control buttonlinktest" placeholder="Enter Location ID" /><label for="'+buttontitle+'">pageconent</label><textarea type="text" class="form-control tinymce" id="page-content" name="page_content"></textarea></div><div class="remove-review-btn"><button class="btn btn-default btn-round remove-btn-zip">Remove</button></div></div>';
		$(".review-group-container1").append(reviewGroup);
	});
	$('body').on("click", ".remove-btn-zip", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();
	});
	
	$("#add-badge").click(function(event){
		event.preventDefault();
		i++;
		var uploadimage = "uploadimage"+i;
		var trustwebsitelink = "trustwebsitelink"+i;
		var addbadge = '<div class="trust-bagde-group"><div class="form-group"><label for="'+uploadimage+'">Add Image</label><p class="recommend-size">Recommend Size: 120*100px</p><input type="hidden" id="'+uploadimage+'" class="uploadimage" name="uploadimage[]" /><button class="btn btn-default btn-round add-image-media">Select Image</button><div class="image-holder"></div></div><div class="clearfix"></div><div class="form-group"><label for="'+trustwebsitelink+'">Trust Website Link(optional)</label><input type="text" class="form-control" id="'+trustwebsitelink+'" name="trustwebsitelink[]"></div><div class="remove-badges"><button class="btn btn-default btn-round remove-badge">Remove Badge</button></div></div>';
		$(".trust-bagde-group-container").append(addbadge);
	});
	$('body').on("click", ".remove-badge", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});
	
	$('#addchildcheck').click(function(){
		if($(this).prop('checked')){
			$("#childBoxblock").css('display','block');
		}else{
			$("#childBoxblock").css('display','none');
		}
		
		
		
	});
	
	$('#extraAddress').click(function(){
		if($(this).prop('checked')){
			$("#addressBoxblock").css('display','block');
		}else{
			$("#addressBoxblock").css('display','none');
		}
		
	});
	
	/* Child license*/
	$("#add-child-license").click(function(event){
		event.preventDefault();
		i++;
		var childL = "childL"+i;
		var addchildLi = '<div class="trust-bagde-group1"><div class="form-group"><label for="'+childL+'">Enter License Number</label><input type="text" class="form-control childL" id="'+childL+'" name="childL[]"></div><div class="remove-badges"><button class="btn btn-default btn-round remove-childs">Remove Child</button></div></div>';
		$(".child-group-container").append(addchildLi);
	});
	$('body').on("click", ".remove-childs", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});
	
	
	/*parent duplicate check*/
	$('#suiteLicense').focusout(function(){
		$('#MesgError').css('display','none');
		if($("#suiteLicense").val()!=''){
			$.ajax({
			   url: 'server_processing.php',
			   type: 'post',
			   data: { licVal: $("#suiteLicense").val(),AID:$('#AdminID').val()},
				success: function(data){				
						if(data==1){
							$('#MesgError').css('display','block');
							$('#MesgError').text('This license number is already in use.');
							$("#suiteLicense").val('');
						   return false;
						}else{							
							$('#MesgError').css('display','none');
							return true;
						}
					},
					error: function(data){
					 
					}

			});
		}else{
			return false;
		}
	});
	
	$('#suiteLicenseUpdate').focusout(function(){
		$('#MesgError').css('display','none');
		if($("#suiteLicenseUpdate").val()!=''){
			$.ajax({
			   url: 'server_processing.php',
			   type: 'post',
			   data: { licOldVal: $("#suiteLicenseUpdate").val(),update:1,lid:$("#id").val(),AID:$('#AdminID').val()},
				success: function(data){				
						if(data==1){
							$('#MesgError').css('display','block');
							$('#MesgError').text($("#suiteLicenseUpdate").val()+' License number is already in use.');
							$("#suiteLicenseUpdate").val('');
						   return false;
						}else{							
							$('#MesgError').css('display','none');
							return true;
						}
					},
					error: function(data){
					 
					}

			});
		}else{
			return false;
		}
	});
	
	/*END*/
	/*Child duplicate check*/
	
	$(".tbody").on("focusout", "input", function() {
		
		$('#MesgErrorchild').css('display','none');
		if($(this).val()!=''){
			var childValue = $(this);
			$.ajax({
			   url: 'server_processing.php',
			   type: 'post',
			   data: { ClicVal: $(this).val(),AID:$('#AdminID').val()},
				success: function(data){
					var Data = JSON.parse(data);
					
						if(Data.status == '1'){
							$('#MesgErrorchild').css('display','block');
							$('#MesgErrorchild').text('This child license number is associated with '+Data.response);
							childValue.val('');
							childValue.focus();
						   return false;
						}else{													
							$('#MesgErrorchild').css('display','none');
							return true;
						}
					},
					error: function(data){
					 
					}

			});
		}else{
			return false;
		}
	});
	
	/*END*/
	
	
	
	
	/* Child license end*/
	
	/* Addresses code start*/
	$("#add-additional-address").click(function(event){
		event.preventDefault();
		i++;
		var Extraaddress = "Extraaddress"+i;
		var ExtraHide = "ExtraHide"+i;
		var ExtraHidehidden = "ExtraHide"+i+"1";
		var Extracity = "Extracity"+i;
		var Extrastate = "Extrastate"+i;
		var Extrazipcode = "Extrazipcode"+i;
		var Extraphone = "Extraphone"+i;
		var addAddress = '<hr><div class="trust-bagde-address"><div class="form-group"><label for="'+Extraaddress+'">Address</label><input type="text" class="form-control" id="'+Extraaddress+'" name="additionaladdress[]" placeholder="Enter Address"></div><div class="form-group"><label for="'+ExtraHide+'" style="word-wrap:break-word"><input type="checkbox" value="1" id="'+ExtraHide+'" name="additionaladdressshow[]">Hide Address</label><input type="hidden" value="0" id="'+ExtraHidehidden+'" name="additionaladdressshow[]"></div><div class="form-group"><label for="'+Extracity+'">City</label><input type="text" class="form-control" id="'+Extracity+'" name="additionalcity[]" placeholder="Enter City"></div><div class="form-group"><label for="'+Extrastate+'">State</label><input type="text" class="form-control" id="'+Extrastate+'" name="additionalstate[]" placeholder="Enter State (Ex. CA)"></div><div class="form-group"><label for="'+Extrazipcode+'">Zipcode</label><input type="text" class="form-control" id="'+Extrazipcode+'" name="additionalzipcode[]" placeholder="Enter Zipcode"></div><div class="form-group"><label for="'+Extraphone+'">Phone</label><input type="text" class="form-control" id="'+Extraphone+'" name="additionalphone[]" placeholder="Enter Phone"></div><div class="remove-badges"><button class="btn btn-default btn-round remove-address">Remove Address</button></div></div>';
		$(".address-group-container").append(addAddress);
	});
	$('body').on("click", ".remove-address", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});
	
	$(".tbody1").on("change", ":checkbox", function() {
		var IDVal = $(this).prop('id');
		var hiddenId = $('#'+IDVal+'1').prop('id');
		if($(this).prop('checked')){			
			$('#'+hiddenId).attr('disabled', true);
		}else{
			
			$('#'+hiddenId).attr('disabled', false);
		}
	});
	
	
	
	/* Addresses code end*/
	
	
	$("#add-custom-review").click(function(event){
		event.preventDefault();
		i++;
		var uploadprofileimage = "uploadprofileimage"+i;
		var reviewername = "reviewername"+i;
		var reviewsite = "reviewsite"+i;
		var rating = "rating"+i;
		var review = "review"+i;
		var addreview = '<div class="add-custom-review"><div class="form-group"><label for="'+uploadprofileimage+'">Add Profile Image</label><p class="recommend-size">Recommend Size: 70*70px</p><input type="hidden" id="'+uploadprofileimage+'" name="uploadprofileimage[]" /><button class="btn btn-default btn-round add-image-media">Select Image</button><div class="image-holder"></div></div><div class="clearfix"></div><div class="row"><div class="col-sm-4"><div class="form-group"><label for="'+reviewername+'">Reviewer Name</label><input type="text" id="'+reviewername+'" name="reviewername[]" class="form-control" placeholder="Enter the reviewer"s name" /></div></div><div class="col-sm-4"><div class="form-group"><label for="'+reviewsite+'">Review Site</label><select id="'+reviewsite+'" name="reviewsite[]" class="form-control"><option value="" selected>Select</option><option value="Yelp">Yelp</option><option value="Google">Google</option><option value="Superpages">Superpages</option><option value="Foursquare">Foursquare</option></select></div></div><div class="col-sm-4"><div class="form-group"><label for="'+rating+'">Rating</label><select class="form-control" id="'+rating+'" name="rating[]"><option value="" selected>Select</option><option value="1">1</option><option value="1.5">1.5</option><option value="2">2</option><option value="2.5">2.5</option><option value="3">3</option><option value="3.5">3.5</option><option value="4">4</option><option value="4.5">4.5</option><option value="5">5</option></select></div></div></div><div class="form-group"><label for="'+review+'">Review</label><textarea type="text" id="'+review+'" name="review[]" class="form-control" rows="4"></textarea></div><div class="remove-reviews"><button class="btn btn-default btn-round remove-review">Remove Review</button></div></div>';
		$(".add-custom-review-container").append(addreview);
	});
	$('body').on("click", ".remove-review", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});
	$("#add-coupan").click(function(event){
		event.preventDefault();
		i++;
		var uploadcoupanimage = "uploadcoupanimage"+i;
		var coupontitle = "coupontitle"+i;
		var coupantext = "coupantext"+i;
		var coupanlink = "coupanlink"+i;
		var addcoupan = '<div class="add-coupon"><div class="form-group"><label for="'+uploadcoupanimage+'">Add Coupon Image</label><p class="recommend-size">Recommend Size: 260*140px</p><input type="hidden" id="'+uploadcoupanimage+'" name="uploadcoupanimage[]" /><button class="btn btn-default btn-round add-image-media">Select Image</button><div class="image-holder"></div></div><div class="clearfix"></div><div class="form-group"><label for="'+coupontitle+'">Coupon Title</label><input type="text" id="'+coupontitle+'" name="coupontitle[]" class="form-control" placeholder="Enter coupon title (ex. Friday Sale)" /></div><div class="form-group"><label for="'+coupantext+'">Coupon Text (optional)</label><textarea type="text" id="'+coupantext+'" name="coupantext[]" class="form-control" rows="4"></textarea></div><div class="form-group"><label for="'+coupanlink+'">Coupon Link (optional)</label><input type="url" id="'+coupanlink+'" name="coupanlink[]" class="form-control" placeholder="Enter coupon link (ex. http://www.couponlink.com)" /></div><div class="remove-coupans"><button class="btn btn-default btn-round remove-coupan">Remove Coupan</button></div></div>';
		$(".add-coupon-container").append(addcoupan);
	});
	$('body').on("click", ".remove-coupan", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});
	
	$("#add-new-services").click(function(event){ 
         event.preventDefault();
		i++; 
		  var addservice = "addservice"+i;
         var addsevices='<div class="add_services"><div class="form-group"><label for="'+addservice+'">Service</label><textarea id="'+addservice+'" name="addservice[]" class="form-control" rows="2"></textarea><label for="addservice1">Service Link</label><input id="addservice1" name="addservicelink[]" id="addservice" class="form-control"></div><div class="remove-services"><button class="btn btn-default btn-round remove-service">Remove Service</button></div></div>';  
		$(".add-service-container").append(addsevices);
    });	
    $('body').on("click", ".remove-service", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});
	
	$("#add-new-zipcode").click(function(event){ 
         event.preventDefault();
		i++; 
		  var addzip = "addzip"+i;
         var addzip='<div class="add_zip"><div class="form-group"><label for="'+addzip+'">Zipcode</label><input id="'+addzip+'" name="extra_zipcode[]" class="form-control"><label for="addservice1">Zipcode page link</label><input id="addservice1" name="extra_zipcode_link[]" id="addzip" class="form-control"></div><div class="remove-services"><button class="btn btn-default btn-round remove-zip">Remove Zipcode</button></div></div>';  
		$(".add-zip-container").append(addzip);
    });	
    $('body').on("click", ".remove-zip", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();	
	});

	
/*Script - Datable - Locations Page - Start*/
	$('#locations-table').DataTable({
		"aLengthMenu": [[5, 10, 20, 50, -1], [5, 10, 20, 50, "All"]],
        "iDisplayLength": 10
	});
/*Script - Datable - Locations Page - End*/
//
// Pipelining function for DataTables. To be used to the `ajax` option of DataTables
//
$.fn.dataTable.pipeline = function ( opts ) {
    // Configuration options
    var conf = $.extend( {
        pages: 5,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
                      // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts );
 
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
 
    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
         
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                  JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                  JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
         
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );
 
        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));
 
                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
             
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);
 
            request.start = requestStart;
            request.length = requestLength*conf.pages;
 
            // Provide the same `data` options as DataTables.
            if ( typeof conf.data === 'function' ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }
 
            settings.jqXHR = $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                     
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );
 
            drawCallback(json);
        }
    }
};
 
// Register an API method that will empty the pipelined data, forcing an Ajax
// fetch on the next draw (i.e. `table.clearPipeline().draw()`)
$.fn.dataTable.Api.register( 'clearPipeline()', function () {
    return this.iterator( 'table', function ( settings ) {
        settings.clearCache = true;
    } );
} );
 
 
//
// DataTables initialisation
//
$(document).ready(function() {
    $('#locationsbrand-table').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": $.fn.dataTable.pipeline( {
            url: 'server_processing.php',
            pages: 5 // number of pages to cache
        } )
    } );
} );

/*Script - Remove Images - Global Options Page && Location Edit Page - Start*/
	$(".remove-j-image").click(function(){
		$("#image_global").val("");
		$(".image-holder").remove();
	});	
	$(".remove-t-image").on("click", function(){
		$(this).parent().parent().find(".image-holder").remove();
		$(this).parent().parent().find(".image-t-trust").val("");
		$(this).parent().parent().find(".remove-t-image").remove();
	});	
	$(".remove-r-image").on("click", function(){
		$(this).parent().parent().find(".image-holder").remove();
		$(this).parent().parent().find(".image-r-trust").val("");
		$(this).parent().parent().find(".remove-r-image").remove();
	});
	$(".remove-c-image").on("click", function(){
		$(this).parent().parent().find(".image-holder").remove();
		$(this).parent().parent().find(".image-c-coupon").val("");
		$(this).parent().parent().find(".remove-c-image").remove();
	});
/*Script - Remove Images - Global Options Page && Location Edit Page - End*/

/*Script - Add Fields - Form Builder - Start*/
	$("#add_form_field").click(function(event){
		event.preventDefault();
		i++;
		$(".form-builder-bottom").append('<div class="row"><div class="form-group"><div class="col-sm-4"><select class="form-control select_tag" name="forminput[]" id="select_tag"><option value="text">Text</option><option value="checkbox">Checkbox</option><option value="date">Date</option><option value="email">Email</option><option value="file">File</option><option value="number">Number</option><option value="tel">Tel</option><option value="url">Url</option><option value="select">Select</option><option value="textarea">Textarea</option></select></div><div class="col-sm-4"><div class="enter_plo"><textarea class="form-control select_text" placeholder="Placeholder/Label/Options" name="formplaceholder[]"></textarea></div></div><div class="col-sm-2"><div class="is_required_checkbox"><select class="form-control" name="formrequired[]" ><option value="no">No</option><option value="yes">Yes</option></select></div></div><div class="col-sm-2"><div class="remove-form-field"><i class="fa fa-window-close remove_input" aria-hidden="true"></i></div></div></div></div>');
	});
	$('body').on("click", ".remove_input", function(event){
		event.preventDefault();
		$(this).parentsUntil(".row").parent().remove();
	});
	
/*Script - Add Fields - Form Builder - End*/

});

//Password Checker
$(document).ready(function() {
$('#password').keyup(function() {
$('#result').html(checkStrength($('#password').val()))
})
function checkStrength(password) {
var strength = 0
if (password.length < 6) {
$('#result').removeClass()
$('#result').addClass('short')
return 'Too Short'
}
if (password.length > 7) strength += 1
// If password contains both lower and uppercase characters, increase strength value.
if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
// If it has numbers and characters, increase strength value.
if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
// If it has one special character, increase strength value.
if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
// If it has two special characters, increase strength value.
if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
// Calculated strength value, we can return messages
// If value is less than 2
if (strength < 2) {
$('#result').removeClass()
$('#result').addClass('weak')
return 'Weak'
} else if (strength == 2) {
$('#result').removeClass()
$('#result').addClass('good')
return 'Good'
} else {
$('#result').removeClass()
$('#result').addClass('strong')
return 'Strong'
}
}
});



function add_more_email_option(){
	//generate the email input box html and append in to the email box div
	let email_input_html=`<div class="form-group ">
							<input type="text" class="form-control"  name="emailmesageid[]" placeholder="Enter another email" value="" />
							<button class="btn btn-danger" onclick="removeInputBox(this)"><span><i class="fa fa-minus"></i></span></button>
						</div>`;

	$('.contact-form-email-override-box').append(email_input_html);

}

function removeInputBox(ref){
	$(ref).parent().remove();
}