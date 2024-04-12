    var map;
    var markers = [];
    var infoWindow;
    var locationSelect;
	
    $(window).load(function($) {	  
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(37.09024, -95.712891),
        zoom: 5,
        mapTypeId: 'roadmap',
        enableHighAccuracy:false,
        maximumAge:Infinity, 
        timeout:60000,
        mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU}
      });
      infoWindow = new google.maps.InfoWindow();
      locationSelect = document.getElementById("locationSelect");

	  if (navigator.geolocation) {

			navigator.geolocation.getCurrentPosition(showPosition);
		} else {

			enableBtn();	
			swal({
			title: "Oops...",
			text: "Your browser didn't support geolocations",
			type: "error",
		});      
		}
	});
	
	function disableBtn() {
		//$("#searchBtn").prop("disabled", true);
                $("#searchBtn").attr("disabled","disabled");
		$("#myaddressInput").attr("disabled","disabled");
	}
    function enableBtn() {
	//	$("#searchBtn").prop("disabled", false);
                $("#searchBtn").removeAttr("disabled");
		$("#myaddressInput").removeAttr("disabled");
	}
    
   function searchLocations() {
		$("#searchid").css('display','none');
		var oldaddress = document.getElementById("addressInput").value;
		var address=oldaddress;
	if(oldaddress.length == 2)
		{
			//for State Code
			window.location.href = "https://www.restoration1.com/locations/?state="+oldaddress;
			   
		}else{
			//For zipcode
			 if(oldaddress.length < 5){
				 let address_length=oldaddress.length;
				 if(address_length == 4){
					 address="0"+oldaddress;
				 }else if(address_length == 3){
					address="00"+oldaddress;
				}
			 }
			 
			 var geocoder = new google.maps.Geocoder();
		
			 geocoder.geocode({address: address}, function(results, status) {
		   
			   if (status == google.maps.GeocoderStatus.OK) {
				searchLocationsNear(results[0].geometry.location,address);
			   } else {

					enableBtn();
					$('.loading').hide();	
					swal({
					title: status,
					text: "Please enter a valid zipcode",
					timer: 3000,
					type: "error",
				});      
				}
			 });
		}
	     
   }
  
  
  
  
	function getLocation(event) {
      //     console.log(navigator.geolocation);
    
      
		if (navigator.geolocation) {
                  $("#myaddressInput").removeAttr("disabled");
                  $("#searchBtn").removeAttr("disabled");
	          navigator.geolocation.getCurrentPosition(showPosition);
          
                        
		} else {
                     
			enableBtn();				
			swal({
			title: "Oops...",
			text: "Your browser didn't support geolocations",
			type: "error",
		});      
		}
	}

	function showPosition(position) {

		var lat = position.coords.latitude;
		var lng = position.coords.longitude;
              
		var latlng = new google.maps.LatLng(lat, lng);
		var geocoder = new google.maps.Geocoder();
		geocoder.geocode({'latLng': latlng }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
				if(adminid!='50'){
                      searchLocationsNear(results[0].geometry.location,results[1].formatted_address);
					}
		  if (results[1]) {
                        var myCurrentAddress = results[1].formatted_address; 
                        if(adminid!='50'){                 
							document.getElementById("addressInput").value = myCurrentAddress;	
						}					
                        enableBtn();
	        }
		} else {
			enableBtn();
			swal({
			title: "",
			text: address + " not found",
			timer: 3000,
			type: "error",
		});      
       }
     });
	}
  
   function clearLocations() {
     infoWindow.close();
     for (var i = 0; i < markers.length; i++) {
       markers[i].setMap(null);
     }
     markers.length = 0;
     locationSelect.innerHTML = "";
 }
   function searchLocationsNear(center,edata) {
    clearLocations();     
    var radius = 999999999999999;
     var searchUrl = scripturl+'/phpsqlsearch_genxml.php?lat=' + center.lat() + '&lng=' + center.lng() + '&radius=' + radius + '&adminid=' + adminid + '&edata=' +edata;
     downloadUrl(searchUrl, function(data) {
		 $('.loading').hide();
       var xml = parseXml(data);
       var markerNodes = xml.documentElement.getElementsByTagName("marker");
       
       var bounds = new google.maps.LatLngBounds();
	  var len = markerNodes.length;
	  
		   for (var i = 0; i < markerNodes.length; i++) {
			var zipnewId = 0;					var pageurl ='';
			   if(markerNodes[i].hasAttribute('zipnewId'))
			   		zipnewId=markerNodes[i].getAttribute("zipnewId");
			
				var id = markerNodes[i].getAttribute("id");
				var slug = markerNodes[i].getAttribute("slug");
				var adminid = markerNodes[i].getAttribute("adminid");
				var name = markerNodes[i].getAttribute("name");
				var address = markerNodes[i].getAttribute("address");
				var AddresshOW = markerNodes[i].getAttribute("addressshow");
				var city = markerNodes[i].getAttribute("city");
				var state = markerNodes[i].getAttribute("state");
				var distance = parseFloat(markerNodes[i].getAttribute("distance"));
				var phone = markerNodes[i].getAttribute("phone");
				var zip = markerNodes[i].getAttribute("zip");
				if(markerNodes[i].hasAttribute("pageurl"))
					pageurl = markerNodes[i].getAttribute("pageurl");

				var latlng = new google.maps.LatLng(
				  parseFloat(markerNodes[i].getAttribute("lat")),
				  parseFloat(markerNodes[i].getAttribute("lng")));
				createOption(id, slug, adminid, name, address, city, state, phone,zip,i,AddresshOW,zipnewId,pageurl);
				  
			 createMarker(latlng, name, address, city, state, phone, distance,zip, id, slug,AddresshOW,zipnewId,pageurl);
			 bounds.extend(latlng);
		   }  
       map.fitBounds(bounds);
       if(len==1){
			google.maps.event.addListenerOnce(map, 'bounds_changed', function(event) {
				if (this.getZoom()){
					this.setZoom(10);
				}
			});
      }
       locationSelect.style.visibility = "visible";
       locationSelect.onchange = function() {
         var markerNum = locationSelect.options[locationSelect.selectedIndex].value;
			google.maps.event.trigger(markers[markerNum], 'click');
       };
      });
    }
  
    function createMarker(latlng, name, address, city, state, phone, distance,zip, id, slug,Addresshow,zipnewId,pageurl='') {
		 var showaddress='';
		if(Addresshow==0){
		  showaddress = '';
		}
		var CITY = city.replace(" ", "_");
		var plink='';
		if(pageurl != ''){
				plink=pageurl;
			}else{
				if(zipnewId != 0)
					plink = location.href+'/'+CITY+'/'+zip+'/'+zipnewId+'/detail';
				else
					plink = '/find-my-location/'+'/'+CITY+'/'+zip+'/detail';
			}
      var html = '<div class="marker-store-name"><a href="'+plink+'">' + name + '</a></div><div class="marker-store-address">' + showaddress + '' + city + ', ' + state + ' ' + zip + '</div><div class="marker-phone-number">' + phone + '</div>';
      var marker = new google.maps.Marker({
        map: map,
        position: latlng
      });
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
      markers.push(marker);
    }
    function createOption(id, slug, adminid, name, address, city, state, phone,zip,num,Addresshow,zipnewId, pageurl ='') {
	  var locationLetter = String.fromCharCode(65 + num);
	  var li = document.createElement("li");
	  li.value = num;
	  li.className = "multilistings-item";
	  locationSelect.appendChild(li);
	  var a = document.createElement("a");
	  var showaddress='';
		if(Addresshow==0){
		  showaddress = '';
		}
	  a.innerHTML = '<div class="location-letter">' + locationLetter + '</div><div class="multilistings-location-name">' + name + '</div><div class="store-address">' + showaddress + '' + city + ', ' + state + ' <span class="zipshow">'+zip+'</span></div><div class="store-phone-number">' + phone + '</div>';	  
			//var CITY = city.replace(" ", "_");
			var CITY =city.split(' ').join('_');
			if(pageurl != ''){
				a.href=pageurl;
			}else{
				if(zipnewId != 0)
					a.href = location.href+'/'+CITY+'/'+zip+'/'+zipnewId+'/detail';
				else
					a.href = location.href+'/'+CITY+'/'+zip+'/detail';
			}
		
	  li.appendChild(a);
	  li.onmouseover = function(e) {
		  google.maps.event.trigger(markers[this.value], 'click');
		  e.preventDefault();
	  }
		var prtitle = 'Choose';
		var prtitle1 = 'Select a Store';
		if(adminid=='50'){
			prtitle = 'Find Your Local';
			prtitle1 = 'Restoration1';
		}
	  var choose = document.getElementsByClassName("locate-pre-title");
		choose[0].innerHTML = prtitle;
      var selectStore = document.getElementsByClassName("locate-title");
		selectStore[0].innerHTML = prtitle1;
		$(".locate").addClass("location-height");
		$("#map").addClass("location-height");
        google.maps.event.trigger(map, "resize");
		enableBtn();
	 }
	 
	  
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
		  jQuery('.loading_state').hide(); 	
        }
      };
      request.open('GET', url, true);
      request.send(null);
    }
    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }
    function doNothing() {}
    //]]>
$(document).keypress(function(e) {
	// $("#searchid").css('display','none');
    if(e.which == 13) {
       $("#searchBtn").click();
        $('.loading').show();
       //$("#searchid").css('display','block');
    }
});
