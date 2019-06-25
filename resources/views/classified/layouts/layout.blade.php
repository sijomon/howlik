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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.3/css/bootstrap-dialog.min.css" type="text/css" >
	
		<link href="{{ url('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
		<link href="{{ url('/assets/plugins/select/select.min.css') }}" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
		<link rel="stylesheet" href="{{ url('/assets/css/bootstrap-select.min.css') }}">
		<link rel="stylesheet" href="/assets/css/owl.carousel.css">

		@if(isset($hdr_datepicker) and $hdr_datepicker==1)
		<link rel="stylesheet" href="{{ url('/assets/frontend/css/bootstrap-datepicker.css') }}">
		<link rel="stylesheet" href="{{ url('/assets/frontend/css/bootstrap-timepicker.min.css') }}">
		@endif
		
		@if(isset($hdr_datetimepicker) and $hdr_datetimepicker==1)
		<link rel="stylesheet" href="{{ url('/assets/frontend/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') }}">
		<link rel="stylesheet" href="{{ url('/assets/frontend/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
		@endif
		
		@if(isset($hdr_dropzone) and $hdr_dropzone==1)
		<link rel="stylesheet" href="{{ url('/assets/frontend/css/dropzone.css') }}">
		@endif
		
		@if(isset($hdr_profile) and $hdr_profile==1)
			<link rel="stylesheet" href="{{ url('/assets/frontend/css/profiles.css') }}">
		@endif

		@if(isset($hdr_rating) and $hdr_rating==1)
			<link rel="stylesheet" href="{{ url('/assets/frontend/rating/css/star-rating.css') }}" media="all" type="text/css"/>
			<link rel="stylesheet" href="{{ url('/assets/frontend/rating/css/themes/krajee-fa/theme.css') }}" media="all" type="text/css"/>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
			<script src="{{ url('/assets/frontend/rating/js/star-rating.js') }}" type="text/javascript"></script>
			<script src="{{ url('/assets/frontend/rating/js/dollar-rating.js') }}" type="text/javascript"></script>
			<script src="{{ url('/assets/frontend/rating/js/themes/krajee-fa/theme.js') }}" type="text/javascript"></script>
		@endif
		
		<script src="{{ url('/assets/js/jquery/1.10.1/jquery-1.10.1.js') }}" type="text/javascript"></script>
		<script src="{{ url('/assets/frontend/js/bootstrap.min.js') }}" type="text/javascript"></script>
		<script src="{{ url('/assets/js/script.js?time=' . time()) }}"></script>
		<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.mockjax.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.autocomplete.min.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/js/app/autocomplete.cities.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/js/app/autocomplete.users.js') }}"></script>
		<script type="text/javascript" src="{{ url('/assets/js/app/autocomplete.names.js') }}"></script>
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
			} else {
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
					window.location.href=data['re_url'];
				}
				//$('#product_container').empty().html(data);
			});
		}
		
		$(document).ready(function () {
			getGeoLocation();
		});
		
		</script>
		<!-- EOF Geolocation script -->
		
		@if(isset($hdr_ckeditor) and $hdr_ckeditor==1)
		<!-- <script src="//cdn.ckeditor.com/4.5.11/basic/ckeditor.js"></script> -->
		<script src="{{ url('/assets/ckeditor/ckeditor.js') }}"></script>
		@endif

		@if(isset($hdr_datepicker) and $hdr_datepicker==1)
		<script src="{{ url('/assets/frontend/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
		<script src="{{ url('/assets/frontend/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
				$(".datepicker" ).datepicker({
					format: 'yyyy-mm-dd',
					changeMonth: true,
					changeYear: true,
					startDate: 'd'
				});
			});
			$('#timepicker').timepicker('showWidget');
		</script>
		@endif

		@if(isset($hdr_datetimepicker) and $hdr_datetimepicker==1)
		<script src="{{ url('/assets/frontend/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
		<script type="text/javascript">
			$(function() {
				$(".datetimepicker").datetimepicker({
					format: "yyyy-mm-dd hh:ii:ss",
					startDate: '-0d',
					autoclose: true,
					minuteStep: 5,
					todayHighlight:'TRUE',
					showMeridian: true
				});
			});
		</script>
		@endif
		
		@if(isset($hdr_dropzone) and $hdr_dropzone==1)
		<script src="{{ url('/assets/frontend/js/dropzone.js') }}" type="text/javascript"></script>
		<script type="text/javascript">
			var vin_biz_error = '{{ t("Error!") }}';
			$(function() {
				var fileList = new Array;
				$("#bizdropzone").dropzone({
					url: "<?php echo lurl('account/postbizimages'); ?>",
					addRemoveLinks : true,
					maxFilesize: 10,
					maxFiles: 10,
					params: { biz_id: $("#biz_id").val() }, 
					sending: function(file, xhr, formData) {
						// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
						formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
					},
					success : function(file, response){//alert(response);
						$("#imge1").val('uploads/pictures/business/'+response);
						fileList[file.lastModified] = response;
					},
					removedfile: function(file) {
						$.post('<?php echo lurl('account/delbizimages'); ?>', {fileName:fileList[file.lastModified]}, function(data){});
						var _ref;
						return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;      
					}
				});
				
				$("#mydropzone").dropzone({
					url: "event-image",
					addRemoveLinks : true,
					maxFilesize: 3,
					maxFiles: 1,
					sending: function(file, xhr, formData) {
						// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
						formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
					},
					success : function(file, response){
						$("#imge1").val('uploads/pictures/events/'+response);
					}
				});
				
				$("#mydropzonevent").dropzone({
					
					url: "myevent-image",
					addRemoveLinks : true,
					maxFilesize: 3,
					maxFiles: 1,
					sending: function(file, xhr, formData) {
						// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
						formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
					},
					success : function(file, response){
						$("#imge2").val('uploads/pictures/events/'+response);
					}
				});
				
				/* Drag and drop image in post offer page */ 
			
				$("#Offermydropzone").dropzone({ 
					url: "offer-image",
					addRemoveLinks : true,
					maxFilesize: 3,
					maxFiles: 1,
					sending: function(file, xhr, formData) {
						// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
						formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
					},
					success : function(file, response){
						//console.log(response);
						$("#offer_image").val('uploads/pictures/offers/'+response);
					}
				});
				
				$("#mydropzone1").dropzone({ 
					url: "offerCompany-logo",
					addRemoveLinks : true,
					maxFilesize: 3,
					maxFiles: 1,
					sending: function(file, xhr, formData) {
						// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
						formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
					},
					success : function(file, response){
						//console.log(response);
						$("#company_logo").val('uploads/pictures/offers/'+response);
					}
				});
			});
		</script>
		@endif
		
		@if(isset($hdr_amchart) and $hdr_amchart == 1)
		<script src="{{ url('/assets/frontend/amchart/amcharts.js') }}"></script>
		<script src="{{ url('/assets/frontend/amchart/serial.js') }}"></script>
		<script src="{{ url('/assets/frontend/amchart/plugins/export/export.min.js') }}"></script>
		<script src="{{ url('/assets/frontend/amchart/plugins/dataloader/dataloader.min.js') }}"></script>
		<link rel="stylesheet" href="{{ url('/assets/frontend/amchart/plugins/export/export.css') }}" type="text/css" media="all" />
		@endif
		
		@if(isset($hdr_socialsharejs) and $hdr_socialsharejs == 1)
		<script src="{{ url('/assets/frontend/socialsharejs/jssocials.js') }}"></script>
		<script src="{{ url('/assets/frontend/socialsharejs/jssocials.min.js') }}"></script>
		<link href="{{ url('/assets/frontend/socialsharejs/jssocials.css') }}" rel="stylesheet" type="text/css" media="all" />
		<link href="{{ url('/assets/frontend/socialsharejs/jssocials-theme-classic.css') }}" rel="stylesheet" type="text/css" media="all" />
		<link href="{{ url('/assets/frontend/socialsharejs/jssocials-theme-flat.css') }}" rel="stylesheet" type="text/css" media="all" />
		<link href="{{ url('/assets/frontend/socialsharejs/jssocials-theme-minima.css') }}" rel="stylesheet" type="text/css" media="all" />
		<link href="{{ url('/assets/frontend/socialsharejs/jssocials-theme-plain.css') }}" rel="stylesheet" type="text/css" media="all" />
		@endif
		
		
		
		<script language="javascript">
			var siteUrl = '<?php echo url('/'); ?>';
			var languageCode = "{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}";
			var langLayout = {
				'hideMaxListItems': {
					'moreText': "{{ t('View More') }}",
					'lessText': "{{ t('View Less') }}"
				}
			};
			$(document).ready(function () {
				$("#fb").hide(); 
				$("#twitter").hide();
				$("#gift_code").hide();
				$('#social_links').click(function(){
					if($(this).prop("checked") == true){
					   $("#fb").show();  // checked
					   $("#twitter").show(); 
					}
					else if($(this).prop("checked") == false){
						 $("#fb").hide(); 
						 $("#twitter").hide();
					}
				});
				
				
				$('#gift').click(function(){
					if($(this).prop("checked") == true){
						// checked
					   $("#gift_code").show(); 
					}
					else if($(this).prop("checked") == false){
					   $("#gift_code").hide(); 
					}
				});
				
				/* Select Boxes */
				$(".selecter").select2({
					language: "{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}",
					dropdownAutoWidth: 'true',
					minimumResultsForSearch: Infinity
				});
				/* Searchable Select Boxes */
				$(".sselecter").select2({
					language: "{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}",
					dropdownAutoWidth: 'true',
				});
				/* Social Share */
				$('.share').ShareLink({
					title: '<?php echo addslashes(MetaTag::get('title')); ?>',
					text: '<?php echo addslashes(MetaTag::get('title')); ?>',
					url: '<?php echo \Illuminate\Support\Facades\URL::full(); ?>'
				});
			});
		</script>
		
		
		
		@yield('javascript-top')
	</head>

	<body>

		<div class="main-container"> 
			{{--*/ $logo2_status = 1; /*--}}
			@include('classified.layouts.inc.header') 
			
			@yield('content') 
			
			@include('classified.layouts.inc.footer')
			
		</div>

		{!! config('settings.seo_google_analytics') !!}
		@yield('javascript')

	</body>
</html>
