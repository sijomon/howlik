<!DOCTYPE html> 
<html dir="{{ (isset($lang) and $lang->has('abbr') and $lang->get('abbr')=='ar' ) ? 'rtl' : 'ltr' }}" lang="{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}">
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
@if (isset($lang) and isset($country) and $country->has('lang'))
	@if ($lang->get('abbr') != $country->get('lang')->get('abbr'))
		<meta name="robots" content="noindex">
		<meta name="googlebot" content="noindex">
	@endif
@endif
<title>Find Everything Around You Saudi Arabia, Kuwait, Bahrain</title>
<meta name="description" content="">

<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="shortcut icon" href="{{ url('/assets/frontend/images/favicon.png') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ url('/assets/frontend/css/bootstrap.min.css') }}" type="text/css" >
@if (isset($lang) and $lang->has('abbr') and $lang->get('abbr')=='ar')
<link rel="stylesheet" href="{{ url('/assets/frontend/css/style.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('/assets/frontend/css/responsive.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ url('/assets/frontend/css/style_ar.css') }}" type="text/css" />
@else
<link rel="stylesheet" href="{{ url('/assets/frontend/css/style.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('/assets/frontend/css/responsive.css') }}" type="text/css"/>
@endif

<link rel="stylesheet" href="{{ url('/assets/frontend/fonts/font.css') }}" type="text/css">
<link rel="stylesheet" href="{{ url('/assets/frontend/fonts/font-awesome-4.4.0/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ url('/assets/css/bootstrap-select.min.css') }}">

		<script src="{{ url('/assets/js/jquery/1.10.1/jquery-1.10.1.js') }}" type="text/javascript"></script>
		<script src="{{ url('/assets/frontend/js/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ url('/assets/js/script.js?time=' . time()) }}"></script>
		<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.mockjax.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.autocomplete.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/js/app/autocomplete.cities.js') }}"></script>
		
		<?php /*<script src="{{ url('/assets/plugins/retina/1.3.0/retina.js') }}" type="text/javascript"></script>*/ ?>
		<script src="{{ url('/assets/js/jquery.matchHeight-min.js') }}"></script>
		<script src="{{ url('/assets/plugins/jquery.fs.scroller/jquery.fs.scroller.min.js') }}"></script>
		<script src="{{ url('/assets/plugins/select2/js/select2.full.min.js') }}"></script>
		<script src="{{ url('/assets/plugins/SocialShare/SocialShare.min.js') }}"></script>
		<script src="{{ url('/assets/js/owl.carousel.min.js') }}"></script>
		<script src="{{ url('/assets/js/hideMaxListItem-min.js') }}"></script>
		
		<script src="{{ url('/assets/js/bootstrap-select.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/plugins/select/select.min.js') }}"></script>
		<script language="javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}); 
		</script>
		<!-- BOF Geolocation script -->
		<script>
		//var x = document.getElementById("demo");
		function getGeoLocation() {
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(showPosition);
			} else {alert("Geolocation is not supported by this browser.");
				//x.innerHTML = "Geolocation is not supported by this browser.";
			}
		}
		
		function showPosition(position) {
			//x.innerHTML = "Latitude: " + position.coords.latitude + 
			//"<br>Longitude: " + position.coords.longitude; 
			//alert(position.coords.latitude+','+position.coords.longitude);
			$.ajax({
				url : "{{url('setIpAddress')}}",
				type: "post",
				dataType: "json",
				async: false,
				data: { latitude : position.coords.latitude, longitude:position.coords.longitude, location:window.location.pathname }
			}).done(function (data) {
				if(data['re_url']!=''){
					window.location.href = data['re_url'];
				}
				//$('#product_container').empty().html(data);
			});
		}
		
		$(document).ready(function () {
			getGeoLocation();
		});
		
		</script>
		<!-- EOF Geolocation script -->
		<script language="javascript">
			var siteUrl = '<?php echo url('/'); ?>';
			var languageCode = "{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}";
			var langLayout = {
				'hideMaxListItems': {
					'moreText': "{{ t('View More') }}",
					'lessText': "{{ t('View Less') }}"
				}
			};
			
		</script>
		@yield('javascript-top')
</head>

<body>

<div class="main-container"> 
	{{--*/ $logo2_status = 0; /*--}}
	@include('classified.layouts.inc.banner')
	
	@include('classified.layouts.inc.header') 
	
	@yield('content') 
	
	@include('classified.layouts.inc.footer')
</div>

{!! config('settings.seo_google_analytics') !!}
@yield('javascript')
</body>
</html>