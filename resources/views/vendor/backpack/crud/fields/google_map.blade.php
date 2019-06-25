<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Google Map Pin Location -->
<?php
/*$ticket = unserialize($field['value']);
echo "<pre>";
print_r($field);*/
?>
<div class="info">
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></script>
	<body>Lat:
		<input id="lat1" name="lat1" value="" />Long:
		<input id="lon1" name="lon1" value="" />
		<br />
		<br />
		<a href="#" onClick="return auto_locate();" style="float:right;">Auto Locate</a>
		<div id="map_canvas" style="width: 100%; height: 250px;"></div>
	</body>
</div>

<script language="javascript">
    var map;

    function initialize(lat, lon) {
		document.getElementById("lat1").value = lat;
		document.getElementById("lon1").value = lon;
        var myLatlng = new google.maps.LatLng(lat, lon);

        var myOptions = {
            zoom: 15,
            center: myLatlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var marker = new google.maps.Marker({
            draggable: true,
            position: myLatlng,
            map: map,
            title: "Your location"
        });

        google.maps.event.addListener(marker, 'dragend', function (event) {
            document.getElementById("lat1").value = event.latLng.lat();
            document.getElementById("lon1").value = event.latLng.lng();
        });
    }
    
	function auto_locate() {
		var address = $.trim($("#address1").val());
		var address2 = $.trim($("#address2").val());
		var zip = $.trim($("#zip").val());
		var city = $.trim($("#city_id option:selected").text());
		var country = $.trim($("#countryCode").val());
		geocoder = new google.maps.Geocoder();
		//In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
		//var address = document.getElementById( 'address' ).value;
		var address = address+', '+address2+', '+city+'-'+zip+', '+country;
		geocoder.geocode( { 'address' : address }, function( results, status ) {
			if( status == google.maps.GeocoderStatus.OK ) {
				initialize(results[0].geometry.location.lat(), results[0].geometry.location.lng());
			} 
		});
		return false;
	}
		
	///////////////////////////////////////////////////////////
	function showResult(result) {
		var lat = result.geometry.location.lat();
		var lon = result.geometry.location.lng();
		initialize(lat, lon);
	}
	
	function getLatitudeLongitude(callback, address) {
		// If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
		address = address || 'Ferrol, Galicia, Spain';
		// Initialize the Geocoder
		geocoder = new google.maps.Geocoder();
		if (geocoder) {
			geocoder.geocode({
				'address': address
			}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					callback(results[0]);
				}
			});
		}
	}
	
	jQuery(document).ready(function($) {
		//getLatitudeLongitude(showResult, address);
	});
</script>

<style> 
html, body, #map_canvas {
    margin: 0;
    padding: 0;
    height: 100%
}
</style>