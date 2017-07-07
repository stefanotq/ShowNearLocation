<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Directions Service</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
	#floating-panel {
	 /* position: absolute;*/
	  top: 10px;
	  left: 25%;
	  z-index: 5;
	  background-color: #fff;
	  padding: 5px;
	  border: 1px solid #999;
	  text-align: center;
	  font-family: 'Roboto','sans-serif';
	  line-height: 30px;
	  padding-left: 10px;
	}

    </style>
  </head>
  <body>
  
  <?php
  	$location = NULL;
  	foreach($near as $a){
		$location .="['".$a['name']."',".$a['lat'].",".$a['lon'].",'".$a['place']."'],"; 
	}
	$location = rtrim($location, ",");
   ?>
   
    <div id="floating-panel">
    <input name="start" id="start" type="hidden" value="<?=$latitud?>,<?=$longitud?>" />
   
      <strong>Destination:</strong>
      <select id="end">
       <option value="<?=$latitud?>,<?=$longitud?>">Select Place to go..</option>
        <?php foreach($near as $r){ ?>
			<option value="<?=$r['place'] ?>"><?=$r['name']?></option>
		<?php } ?>
      </select>
    </div>
    <div id="map"></div>
    <script>
	
	var locations = [<?= $location?>];
	
function initMap() {
  var directionsService = new google.maps.DirectionsService;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: {lat:<?=$latitud?>, lng: <?=$longitud?>}
  });
  directionsDisplay.setMap(map);
  
   //////////////////
  google.maps.event.addListenerOnce(map, 'idle', function(){

      var marker = new google.maps.Marker({
      	map: map,
        animation: google.maps.Animation.DROP,
		position: {lat:<?=$latitud?>, lng: <?=$longitud?>}
       }); 
            
       var infoWindow = new google.maps.InfoWindow({
       		content: "My location"
       });
	 	infoWindow.open(map, marker); 

        google.maps.event.addListener(marker, 'click', function () {
              infoWindow.open(map, marker);
          });    	
       });
  ////////////
  
  setMarkers(map,locations);
  
  

  var onChangeHandler = function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  };
  document.getElementById('start').addEventListener('change', onChangeHandler);
  document.getElementById('end').addEventListener('change', onChangeHandler);
}

function calculateAndDisplayRoute(directionsService, directionsDisplay) {
  var destino =  document.getElementById('end').value;
  directionsService.route({
    origin: document.getElementById('start').value,
    //destination: document.getElementById('end').value,
	destination: {placeId: destino},
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}


function setMarkers(map,locations){

    var marker, i
	 	
		for (i = 0; i < locations.length; i++)
		 {  
		
		 var loan = locations[i][0]
		 var lat = locations[i][1]
		 var long = locations[i][2]
		 var place =  locations[i][3]
		 //var add =  'null'
		 
		 latlngset = new google.maps.LatLng(lat, long);
		 var infowindow = new google.maps.InfoWindow();
		 var service = new google.maps.places.PlacesService(map);
		
		  service.getDetails({
			placeId: place
		  }, function(place, status) {
			if (status === google.maps.places.PlacesServiceStatus.OK) {
			  var marker = new google.maps.Marker({
				map: map,
				position: place.geometry.location
			  });
			  google.maps.event.addListener(marker, 'click', function() {
				infowindow.setContent(place.name);
				infowindow.open(map, this);
			  });
			}
		  });
		}				
		

  }

    </script>
         <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_JAVASCRIPT_API_KEY" async defer></script>
  </body>
</html>