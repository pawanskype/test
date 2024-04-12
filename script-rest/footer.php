
<script src="<?php echo $scripturl; ?>/js/script.js"></script>

<script>
	$(function(){
		$('#addressInput').focusout( function() {
			  $('#CursorShow').css('display','none');
		});
		$('#addressInput').keyup( function() {
			  $('#CursorShow').css('display','block');
			  var value = $(this).val();
				if ( value.length <1){
					 $('#CursorShow').css('display','none');
				}
		});
	});
</script>
<?php switch ($loadpage) { 
	case "location":
	case "locationdetails":	?>
<script>
$(function(){
	// Street View
	var sv = new google.maps.StreetViewService();
	var geocoder = new google.maps.Geocoder();
	var directionsService = new google.maps.DirectionsService();
	var panorama;
	var address = '"'+ locationaddress + locationcity + locationstate +'"';
	var myLatLng;
	
	function initialize() {
	panorama = new google.maps.StreetViewPanorama(document.getElementById("pano"));
	
	geocoder.geocode({
		'address': address
	}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		myLatLng = (latitude, longitude);
	
		// find a Streetview location on the road
		var request = {
			origin: address,
			destination: address,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
		};
		directionsService.route(request, directionsCallback);
		} else {
			$('#pano').html("<img src='<?php echo $adminurl; ?>/defaultimages/no-photo-available.jpg' alt='No Photo'>");
		}
	});
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	
	function processSVData(data, status) {
	if (status == google.maps.StreetViewStatus.OK) {
		panorama.setPano(data.location.pano);
		$('#pano').show();
		var heading = google.maps.geometry.spherical.computeHeading(data.location.latLng, myLatLng);
		panorama.setPov({
		heading: heading,
		pitch: 0,
		zoom: 2
		});
		panorama.setVisible(true);
	
	} else {
		$('#pano').html("<img src='<?php echo $adminurl; ?>/defaultimages/no-photo-available.jpg' alt='No Photo'>");
	}
	}
	
	function directionsCallback(response, status) {
	if (status == google.maps.DirectionsStatus.OK) {
		var latlng = response.routes[0].legs[0].start_location;
		sv.getPanoramaByLocation(latlng, 50, processSVData);
	} else {
		$('#pano').html("<img src='<?php echo $adminurl; ?>/defaultimages/no-photo-available.jpg' alt='No Photo'>");
	}
	}
	$('#pano').css("background-color", "transparent");
	
	
});
</script>
<?php } ?>
