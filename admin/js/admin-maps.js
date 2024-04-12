	var geocoder;
	var map;
	var markersArray = [];
	var mapOptions = {
		center: new google.maps.LatLng(36.2427347, -113.7459252),
		zoom: 5,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	var marker;
	function createMarker(latLng) {
		if (!!marker && !!marker.setMap)marker.setMap(null);
		marker = new google.maps.Marker({
			map: map,
			position: latLng,
			draggable: true
		});

		document.getElementById('lat').value = marker.getPosition().lat().toFixed(6);
		document.getElementById('lng').value = marker.getPosition().lng().toFixed(6);

		google.maps.event.addListener(marker, "dragend", function () {
			document.getElementById('lat').value = marker.getPosition().lat().toFixed(6);
			document.getElementById('lng').value = marker.getPosition().lng().toFixed(6);
		});
	}
	function initialize() {
		geocoder = new google.maps.Geocoder();
		map = new google.maps.Map(document.getElementById('adminmap'), mapOptions);
		
		google.maps.event.addListener(map, 'click', function (event) {
			map.panTo(event.latLng);
			map.setCenter(event.latLng);
			createMarker(event.latLng);
		});
		if(document.getElementById("lat").value && document.getElementById("lng").value) {
			codeAddress();
			return false;
		}
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	$("#wpsl-lookup-location").on("click", function () {
		codeAddress();
		return false;
	});
	
	function codeAddress() {
		var address = document.getElementById("address").value;
		var city = document.getElementById("city").value;
		var state = document.getElementById("state").value;
		var totalAddress = address + ' ' + ' ' + city + ' ' + state;
		geocoder.geocode({
			'address': totalAddress
		}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				createMarker(results[0].geometry.location);
			} else {
				swal({
				title: status,
				text: "Please enter valid details & try again",
				timer: 3000,
				type: "error",
			});
			}
		});
	}
