<!DOCTYPE html>
<html>
  <head>
  	{{--*/ $title = $business->title; /*--}}
	{{--*/ $city = $business->city->asciiname; /*--}}
	{{--*/ 
		if(isset($business->location->asciiname)){
			$location = $business->location->asciiname;
		}
		else{
			$location = null;
		}
		 
	/*--}}
	@if(strtolower($lang->get('abbr'))=='ar')
		{{--*/ $title = $business->title_ar; /*--}}
		{{--*/ $city = $business->city->name; /*--}}
		{{--*/ $location = $business->location->name; /*--}}
	@endif
    <title>{{$title.' '.$city.', '.$location}}</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	
	<meta name="description" content="{{$title.' '.$city.', '.$location}}" />
	<meta name="keywords" content="{{$title.' '.$city.', '.$location}}" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHJSZW2HT2YXPFpfEOfPOO3LV-4tpEf4&v=3.exp&sensor=true&libraries=places"></script>
	<link href="{{url('direction/style.css')}}" type="text/css" rel="stylesheet" />
    
  </head>
  <body>
	
    <div id="mapCanvas">&#160;</div>
    <div id="directionsPanel">
    	<a href="#geoLocation" id="useGPS">{{t('Use My Location')}}</a>
        <p class="or">[{{t('OR')}}]</p>
    	<div class="directionInputs">
    		<form>
	    		<p><label><img src="{{url('direction/m1.png')}}" width="20"></label><input type="text" placeholder="{{t('Enter a location')}}" value="" id="dirSource" /></p>
	    		<p><label><img src="{{url('direction/m2.png')}}" width="20"></label>
				{!! $title.'<br />'.$business->address1.'<br />'.$city.', '.$location !!}
				<input type="hidden" value="" id="dirDestination" /></p>
	    		<a href="#getDirections" id="getDirections">{{t('Get Directions')}}</a>
                <a href="#reset" id="paneReset">{{t('Reset')}}</a>
    		</form>	
    	</div>
    	<div id="directionSteps">
    		<p class="msg">{{t('Direction Steps Will Render Here')}}</p>
    	</div>
    	<a href="#toggleBtn" id="paneToggle" class="out">&lt;</a>
    </div>
    <script type="text/javascript">
		var markers = [];
		var myLatlng = new google.maps.LatLng({{$business->lat}}, {{$business->lon}});
		var geocoder  = new google.maps.Geocoder();             // create a geocoder object
		//var location  = new google.maps.LatLng(myLatlng); 
		var geoaddress = '';
		geocoder.geocode({'latLng': myLatlng}, function (results, status) {
			if(status == google.maps.GeocoderStatus.OK) {           // if geocode success
				geoaddress=results[0].formatted_address; alert(add);
			} 
		});
		
		(function(mapDemo, $, undefined) {
		mapDemo.Directions = (function() {
			function _Directions() {
				var map,   
					directionsService, directionsDisplay, 
					autoSrc, autoDest, pinA, pinB, 
					
					markerA = new google.maps.MarkerImage("{{url('direction/m1.png')}}",
							new google.maps.Size(24, 27),
							new google.maps.Point(0, 0),
							new google.maps.Point(12, 27)),		
					markerB = new google.maps.MarkerImage("{{url('direction/m2.png')}}",
							new google.maps.Size(24, 28),
							new google.maps.Point(0, 0),
							new google.maps.Point(12, 28)), 
					
					// Caching the Selectors		
					$Selectors = {
						mapCanvas: jQuery('#mapCanvas')[0], 
						dirPanel: jQuery('#directionsPanel'),
						dirInputs: jQuery('.directionInputs'),
						dirSrc: jQuery('#dirSource'),
						dirDst: jQuery('#dirDestination'),
						getDirBtn: jQuery('#getDirections'),
						dirSteps: jQuery('#directionSteps'), 
						paneToggle: jQuery('#paneToggle'), 
						useGPSBtn: jQuery('#useGPS'), 
						paneResetBtn: jQuery('#paneReset')
					},
					
					autoCompleteSetup = function() {
						autoSrc = new google.maps.places.Autocomplete($Selectors.dirSrc[0]);
						autoDest = new google.maps.places.Autocomplete($Selectors.dirDst[0]);
					}, // autoCompleteSetup Ends
				
					directionsSetup = function() {
						directionsService = new google.maps.DirectionsService();
						directionsDisplay = new google.maps.DirectionsRenderer({
							suppressMarkers: true
						});	
						
						directionsDisplay.setPanel($Selectors.dirSteps[0]);											
					}, // direstionsSetup Ends
					
					trafficSetup = function() {					
						// Creating a Custom Control and appending it to the map
						var controlDiv = document.createElement('div'), 
							controlUI = document.createElement('div'), 
							trafficLayer = new google.maps.TrafficLayer();
								
						jQuery(controlDiv).addClass('gmap-control-container').addClass('gmnoprint');
						jQuery(controlUI).text('Traffic').addClass('gmap-control');
						jQuery(controlDiv).append(controlUI);				
								
						// Traffic Btn Click Event	  
						google.maps.event.addDomListener(controlUI, 'click', function() {
							if (typeof trafficLayer.getMap() == 'undefined' || trafficLayer.getMap() === null) {
								jQuery(controlUI).addClass('gmap-control-active');
								trafficLayer.setMap(map);
							} else {
								trafficLayer.setMap(null);
								jQuery(controlUI).removeClass('gmap-control-active');
							}
						});							  
						map.controls[google.maps.ControlPosition.TOP_RIGHT].push(controlDiv);								
					}, // trafficSetup Ends
					
					mapSetup = function() {	
						
						map = new google.maps.Map($Selectors.mapCanvas, {
								zoom: 9,
								center: myLatlng,	
								
								mapTypeControl: true,
								mapTypeControlOptions: {
									style: google.maps.MapTypeControlStyle.DEFAULT,
									position: google.maps.ControlPosition.TOP_RIGHT
								},
			
								panControl: true,
								panControlOptions: {
									position: google.maps.ControlPosition.RIGHT_TOP
								},
			
								zoomControl: true,
								zoomControlOptions: {
									style: google.maps.ZoomControlStyle.LARGE,
									position: google.maps.ControlPosition.RIGHT_TOP
								},
								
								scaleControl: true,
								streetViewControl: true, 
								overviewMapControl: true,
															
								mapTypeId: google.maps.MapTypeId.ROADMAP
						});
						
						var marker = new google.maps.Marker({
							position: myLatlng,
							map: map,
							icon: markerB
						});
	
	
						autoCompleteSetup();
						directionsSetup();
						trafficSetup();
					}, // mapSetup Ends 
					
					directionsRender = function(source, destination) {
						
						for (var i = 0; i < markers.length; i++) {
							markers[i].setMap(null);
						}
						$Selectors.dirSteps.find('.msg').hide();
						directionsDisplay.setMap(map);
						
						var request = {
							origin: source,
							destination: myLatlng,
							provideRouteAlternatives: false, 
							travelMode: google.maps.DirectionsTravelMode.DRIVING
						};		
						
						directionsService.route(request, function(response, status) {
							if (status == google.maps.DirectionsStatus.OK) {
	
								directionsDisplay.setDirections(response);
								
								var _route = response.routes[0].legs[0]; 
								
								pinA = new google.maps.Marker({position: _route.start_location, map: map, icon: markerA}), 
								pinB = new google.maps.Marker({position: myLatlng, map: map, icon: markerB});
								
								markers.push(pinA);
								markers.push(pinB);
							}
						});
					}, // directionsRender Ends
					
					fetchAddress = function(p) {
						var Position = new google.maps.LatLng(p.coords.latitude, p.coords.longitude),  
							Locater = new google.maps.Geocoder();
						
						Locater.geocode({'latLng': Position}, function (results, status) {
							if (status == google.maps.GeocoderStatus.OK) {
								var _r = results[0];
								$Selectors.dirSrc.val(_r.formatted_address);
							}
						});
					}, // fetchAddress Ends
					
					invokeEvents = function() {
						// Get Directions
						$Selectors.getDirBtn.on('click', function(e) {
							e.preventDefault();
							var src = $Selectors.dirSrc.val(), 
								dst = $Selectors.dirDst.val();
							
							directionsRender(src, geoaddress);
						});
						
						// Reset Btn
						$Selectors.paneResetBtn.on('click', function(e) {
							$Selectors.dirSteps.html('');
							$Selectors.dirSrc.val('');
							$Selectors.dirDst.val('');
							
							if(pinA) pinA.setMap(null);
							if(pinB) pinB.setMap(null);		
							
							directionsDisplay.setMap(null);					
						});
						
						// Toggle Btn
						$Selectors.paneToggle.toggle(function(e) {
							$Selectors.dirPanel.animate({'left': '-=305px'});
							jQuery(this).html('&gt;');
						}, function() {
							$Selectors.dirPanel.animate({'left': '+=305px'});
							jQuery(this).html('&lt;');
						});
						
						// Use My Location / Geo Location Btn
						$Selectors.useGPSBtn.on('click', function(e) {		
							if (navigator.geolocation) {
								navigator.geolocation.getCurrentPosition(function(position) {
									fetchAddress(position);
								});	
							}
						});
					}, //invokeEvents Ends 
					
					_init = function() {
						mapSetup();
						invokeEvents();
					}; // _init Ends
					
				this.init = function() {
					_init();
					return this; // Refers to: mapDemo.Directions
				}
				return this.init(); // Refers to: mapDemo.Directions.init()
			} // _Directions Ends
			return new _Directions(); // Creating a new object of _Directions rather than a funtion
		}()); // mapDemo.Directions Ends
	})(window.mapDemo = window.mapDemo || {}, jQuery);
	</script> 
  </body>
</html>