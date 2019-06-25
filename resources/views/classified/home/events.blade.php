@extends('classified.layouts.layout')
<style>
	#locationBox{
		width:100% !important;
	}
	.select2-container {
		width: 100% !important;
	}
	.select2-dropdown {
		width: 0 !important;
	}
	.cke_top, .cke_contents, .cke_bottom {
		display: block;
		overflow: hidden !important;
		width: 100% !important;
	}
	.tst_area {
		width: 100%;
		float: left;
	}
	div#cke_1_contents {
		height: 165px !important;
	}
	div#cke_2_contents {
		height: 165px !important;
	}
</style>
@section('content')
	<div class="listing_holder">
		<div class="container">
			<div class="Trending_section">
				<div class="event_tab">
					
					@if (Session::has('flash_notification.message'))
						<div class="container">
							<div class="row">
								<div class="col-lg-12">
									@include('flash::message')
								</div>
							</div>
						</div>
					@endif
				
					<ul class="nav nav-tabs">
						<li @if (!count($errors) > 0)class="active" @endif><a data-toggle="tab" href="#home">{{ t('Upcoming Events') }}</a></li>
						<li><a data-toggle="tab" href="#menu1">{{ t('Popular Events') }}</a></li>
						<!-- BOF CHECK AUTH BEFORE POST AN EVENT -->
						<li>
							@if(auth()->user())
								<a data-toggle="tab" href="#menu2" >{{ t('Post an Event') }}</a>
							@else
								<a href="{{ lurl('/event/auth/check') }}" >{{ t('Post an Event') }}</a>
							@endif
						</li>
						<!-- EOF CHECK AUTH BEFORE POST AN EVENT -->
					</ul>
				
					<!--BOF Tab-->
					<div class="tab-content">
						<!--BOF Tab 1-->
						<div id="home" class="clo-md-12 tab-pane fade <?php if (!count($errors) > 0): echo 'in active'; endif; ?>" style="margin-bottom: 30px;">
							<div class="special_offerrs"style="margin-bottom: 40px;">
								<div id="product_container_1">
									<!-- BOF PAGINATION PAGE LOADING -->
									@include('classified.home.inc.upcome_event')
									<!-- EOF PAGINATION PAGE LOADING -->
								</div>
							</div>
						</div>
				
						<!--BOF Tab 2-->
						<div id="menu1" class="tab-pane fade" style="margin-bottom: 30px;">
							<div class="special_offerrs"style="margin-bottom: 40px;">
								<div id="product_container_2">
								<!-- BOF PAGINATION PAGE LOADING -->
									@include('classified.home.inc.popular_event')
								<!-- EOF PAGINATION PAGE LOADING -->
								</div>
							</div>
						</div>
				
						<!--BOF Tab 3-->
						<div id="menu2" class="tab-pane fade">
							<div class="event_tab_holder"> 
								@if (count($errors) > 0)
									<div class="">
										<div class="alert alert-danger">
											<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
											<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
											<ul class="list list-check">
												@foreach ($errors->all() as $error)
													<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									</div>
								@endif
							
								<div class="alert alert-danger" style="display: none;" id="showError">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
									<ul class="list list-check">
										<li id="error">  </li>
									</ul>
								</div>
							
								<form method="POST" action="{{lurl('post-events')}}" enctype='multipart/form-data' id="my_event_post">
									<div class="event_detail_section">
										<div class="detai_section">
											<!-- <div class="top_head"> <span>1</span>
											  <h4>{{ t('event details') }}</h4>
											</div> -->
											<div class="eve_conte">
												
												<!-- Event Title -->
												<label>{{ t('event title') }}<sup>*</sup></label>
												<input type="text" class="form-control" name="event_title" value="{{ old('event_title') }}" placeholder="{{ t('give it a short distinct name') }}">
												
												<!-- Event Type -->
												<div class="select_box">
													<div class="form-group">
														<label for="sel1">{{ t('Event type') }}<sup>*</sup></label>
														<select class="form-control sselecter" id="sel1" name="event_type_id">
															<option value="">{{ t('Event type')}}</option>
															@foreach ($event_type as $item)
																<option value="{{ $item->id }}" {{ (old('event_type_id')==$item->id) ? 'selected="selected"' : '' }}>{{ $item->name }}</option>
															@endforeach
														</select>
													</div>
													<!-- <div class="descre_box">
														<label>{{ t('Event Topic') }}<sup>*</sup></label>
														<input type="text" class="form-control" name="event_topic" value="{{ old('event_topic') }}" placeholder="{{ t('Event Topic')}}">
													</div> -->
												</div>
												
												<!-- Start Date & Time -->
												<div class="start">
													<div class="col-md-6">
														<div class="row">
															<label>{{ t('starts') }}<sup>*</sup></label>
															<input type="text" class="form-control datetimepicker" name="startDate" value="{{ old('startDate') }}" readonly />
														</div>
													</div>
													<div class="col-md-6">
														<div class="row">
															<label class="start-label-secnd">{{ t('ends') }}<sup>*</sup></label>
															<input type="text" class="form-control datetimepicker start-secnd" name="endDate" value="{{ old('endDate') }}" readonly />
														</div>
													</div>
												</div>
												
												<!-- Country -->
												<div class="form-group">
													<label class="control-label" for="country">{{ t('Country') }} <sup>*</sup></label>
													<select id="countrys" name="country" class="form-control sselecter">
														<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}>
														 {{ t('Select your Country') }} 
														</option>
														@if(isset($countries) && !empty($countries))
														@foreach($countries as $code => $name)
															{{--*/ $slct = ''; /*--}}
															@if($country->get('code') == $code)
																{{--*/ $slct = 'selected'; /*--}}
															@endif
															@if(isset($lang) && strtolower($lang->get('abbr'))=='ar')
																{{--*/ $cname = $name['name']; /*--}}
															@else
																{{--*/ $cname = $name['asciiname']; /*--}}
															@endif
															<option value="{{ $code }}" {{ $slct }}> {{ $cname }} </option>
														@endforeach	
														@endif
													</select>
												</div>
												
												<!-- Location -->
												<!-- <div class="form-group">
													<label class="control-label">{{ t('Location') }} <sup>*</sup></label>
													<select id="location" name="location" class="form-control">
														<option value="" {{ (!old('location') or old('location')== '') ? 'selected="selected"' : '' }}>
															{{ t('Select a Location') }} 
														</option>
													</select>
												</div> -->
												<input type="hidden" id="sub_location" name="sub_location" value="" />
												<input type="hidden" id="has_children" name="has_children" value="{{ old('has_children') }}">
							 
												<!-- City selectpicker -->
												<div class="form-group">
													<label class="control-label">{{ t('City') }} <sup>*</sup></label>
													<select id="citys" name="event_location" class="form-control sselecter" onchange="return auto_locate();"></select>
												</div>
							  
												<!-- Map -->
												<div class="form-group">
													<label class="control-label" for="title">{{ t('Locations') }}</label>
													<div>
														<div id="map_canvas" style="width: 100%; height: 200px;"></div>
													</div>
													<div style="display: none;">
														<label class="control-label" for="lat1"> {{ t('Latitude') }}</label>
														<input type="text" id="lat1" name="lat1" class="form-control" value="" readonly />
														<label class="control-label" for="lon1"> {{ t('Longitude') }}</label>
														<input type="text" id="lon1" name="lon1" class="form-control" value="" readonly />
													</div>
												</div>
											</div>
										</div>
						  
										<!-- Event Descreption -->
										<div class="descreption">
											
											<label>{{ t('Event Details') }}<sup>*</sup></label>
											<div class="tst_area1">
												<textarea id="messageArea" name="event_description" rows="7" class="form-control ckeditor" placeholder="Write your message..">{{ old('event_description') }}</textarea>
											</div>
											
											<!-- Organization name -->
											<div class="descre_box">
											  <!-- <label>{{ t('Organization name') }}<sup>*</sup></label>
											  <input type="text" class="form-control" name="organization_name" value="{{ old('organization_name') }}" placeholder="{{ t('give it a short distinct name')}}"> -->
											</div>
							
											<!-- Organization description -->
											<label>{{ t('Organization details') }}</label>
											<div class="tst_area2">
												<!-- <img src="images/html_editor.jpg" pagespeed_url_hash="3410061205" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>-->
												<textarea id="messageArea1" name="messageArea1" rows="7" class="form-control ckeditor" placeholder="Write your message..">{{ old('messageArea1') }}</textarea>
											</div>
							
											<!-- Social Share -->
											<div class="social_section">
												<label>
													<input type="checkbox" name="social_share" value="1" id="social_share" />
													{{ t('Allow links to Facebook, Twitter and Instagram') }}
												</label>
											</div>
											
											<!-- Social Section -->
											<!-- <div class="social_section">
												<label>
													<input type="checkbox" name="social_links" value="1" id="social_links">
													{{ t('Include links to Facebook, Twitter and Instagram') }}
												</label>
												<input type="text" id="fb" name="fb" class="form-control" placeholder="facebook link " style="margin-bottom: 5px;">
												<input type="text" id="twitter" name="twitter" class="form-control" placeholder="twitter link" style="margin-bottom: 5px;">
												<input type="text" id="insta" name="insta" class="form-control" placeholder="instagram link" style="margin-bottom: 5px;">
											</div> -->
										</div>
									</div>
						
									<div class="addectional_setting">
									
										<!-- Event Tickets -->
										<!-- <div class="top_head"> <span>2</span>
											<h4>{{ t('Create Tickets') }}</h4>
										</div> -->
										
										<!-- Event Image -->
										<div class="image_drop">
											<label>{{ t('event image') }}</label>
											<!--<img src="images/upload-files-here.png" pagespeed_url_hash="19921898" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>-->
											<div class="dropzone" id="mydropzone" name="mydropzone"> </div>
											<!-- <p> {{ t('we recommend usung at least a 2160x1080px(2:1ratio) image thats no larger than 10MB learn more') }} </p> -->
										</div>
										<input type="hidden" id="imge1" name="imge1" value=""/>
										
										<div class="setting_holder1">
											<label>{{ t('Create Tickets') }}</label>
											<div class="private">
												<input type="radio" name="ticket_type" value="0" checked="checked" />
												<span><strong>{{ t('None') }}</strong></span><br>
											</div>
											<div class="private">
												<input type="radio" name="ticket_type" value="1" {{(old('ticket_type')==1)?'checked="checked"':''}} />
												<span><strong>{{ t('Free Ticket') }}</strong></span><br>
												<input type="text" id="free_tickets" name="free_tickets" value="{{old('free_tickets')}}" style="width:30%; float:left;" class="form-control" placeholder="#">
											</div>
											<div class="public">
												<input type="radio" name="ticket_type" value="2" {{(old('ticket_type')==2)?'checked="checked"':''}} />
												<span><strong>{{ t('Paid Ticket') }}</strong></span><br>
												<input type="text" id="paid_tickets" name="paid_tickets" value="{{old('paid_tickets')}}" style="width:30%; float:left;" class="form-control" placeholder="#">
												<input type="text" id="ticket_price" name="ticket_price" value="{{old('ticket_price')}}" style="width:30%; float:left; margin-left:5px;" class="form-control" placeholder="{{t('Price')}}">
											</div>
										</div>
						  
										<!-- Additional Settings -->
										<!-- <div class="top_head"> <span>3</span>
											<h4>{{ t('Additional Settings') }}</h4>
										</div> -->
										
										<div class="setting_holder">
											<label>{{ t('listing privacy') }}</label>
											<div class="private">
												<input type="radio" name="privacy" class="privacy" id="public" value="0" checked>
												<span><strong>{{ t('Public page') }}: </strong> {{ t('list this events on a Eventbrite and search engines.') }}</span><br>
											</div>
											<div class="public">
												<input type="radio" name="privacy" class="privacy" id="private" value="1">
												<span><strong>{{ t('Private page') }}: </strong> {{ t('do not list this event plublicly') }}</span><br>
											</div>
										</div>
						  
										<div class="form-group private_div" style="display: none">
											<label for="sel1"><small> {{ t('Send Invitation to') }} </small></label>
											<input type="hidden" class="form-control" name="visible_to" id="visible_to">
											<div class="multiple-val-input">
												<ul>
													<input type="text" class="emaillist" placeholder="{{ t('Enter email addresses...') }}">
													<span class="input_hidden"></span>
												</ul>
											</div>
											<p id="visible_to_msg" style="color: red"></p>
										</div>
											
										<button type="submit" class="btn btn-primary btn-md pull-right">{{ t('Submit') }}</button>
										
									</div>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
								</form>
							</div>
						</div>
						<!--EOF Tab 3-->
					</div>
					<!--EOF Tab-->
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')

	<!-- BOF PAGINATION AJAX SCRIPT -->
	<script type="text/javascript">
		$(document).ready(function()
		{
			// pagination for upcoming events
			$(document).on('click', '#upcoming .pagination a',function(event)
			{
				event.preventDefault();
				$('li').removeClass('active');
				$(this).parent('li').addClass('active');
				var url  = $(this).attr('href');
				
				getUpcomingData(url);
			});
			
			// pagination for popular events
			$(document).on('click', '#popular .pagination a',function(event)
			{
				event.preventDefault();
				$('li').removeClass('active');
				$(this).parent('li').addClass('active');
				var url  = $(this).attr('href');
				
				getPopularData(url);
			});
		}); 
		// pagination for upcoming events
		function getUpcomingData(url) 
		{
			$.ajax({
				url : url,
				type: "get",
				data: { up: 'up'}
			}).done(function (data) {
				$('#product_container_1').empty().html(data);
			}).fail(function () {
				alert('Data could not be loaded.');
			});
		}
		// pagination for popular events
		function getPopularData(url) 
		{
			$.ajax({
				url : url,
				type: "get",
				data: { pop: 'pop'}
			}).done(function (data) {
				$('#product_container_2').empty().html(data);
			}).fail(function () {
				alert('Data could not be loaded.');
			});
		}
	</script>
	<!-- EOF PAGINATION AJAX SCRIPT -->
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></script>
	<script type="text/javascript">
		function show_more(tag)
		{
			$(".extra"+tag).fadeIn("normal");
			$("#view_more"+tag).fadeOut("normal", function(){
				$("#hide_more"+tag).fadeIn("normal");
			});
		}
		function hide_more(tag)
		{
			$(".extra"+tag).fadeOut("normal");
			$("#hide_more"+tag).fadeOut("normal", function(){
				$("#view_more"+tag).fadeIn("normal");
			});
		}	
	</script>
	
	<!-- BOF MAP LOCATION SETTINGS -->
	<script language="javascript">
	
		$(document).ready(function () {
			
			initialize('9.9833', '76.2833');
		});
		
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
			
			var city = $.trim($("#citys option:selected").text());
			var country = $.trim($("#countrys option:selected").text());
			geocoder = new google.maps.Geocoder();
			//In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
			//var address = document.getElementById( 'address' ).value;
			var address = city+','+country;
			geocoder.geocode( { 'address' : address }, function( results, status ) {
				if( status == google.maps.GeocoderStatus.OK ) {
					initialize(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				} 
			});
			return false;
		}
		
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
	</script>
	<!-- EOF MAP LOCATION SETTINGS -->
	
	<script type="text/javascript">
		$(document).ready(function () {
			$('select#countrys').on('change', function () {
				$.ajax({
					url: "{{ lurl('city/autogenerate') }}",
					type: 'post',
					data: {'code': $("select#countrys option:selected").val()},
					dataType:'json',
					success: function(data) {
						if(data.city_drop) {
							$('select#citys').html(data.city_drop);
						}
					}
				});
			}).trigger('change');
		});
	</script>
	<script type="text/javascript">
		
		$('#my_event_post').on( 'submit', function() 
		
			if($('#citys').val() == 0)
			{
				$('#showError').show(function(){
					$('#error').html('The City field is required');  
				});
				return false;
			}
			
			if($('#private').is(":checked")) {
				
				if($.trim($("#visible_to").val()) == '') {
					$('.emaillist').focus();
					return false;
				} else {
					return true;
				}
			}
			
		});
		
	</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			
			$('.privacy').change(function(){
				if($(this).is(":checked")) {
					if($(this).val() > 0) {
						$('.private_div').show();
					} else {
						$('.private_div').hide();
					}
				}
			});
			
		});
	</script>
	
	<script>
		var value = '';
		$('.multiple-val-input').on('click', function(){
			$('input.emaillist').focus();
		});
		$('.multiple-val-input ul input:text').on('input propertychange', function(){
			$(this).siblings('span.input_hidden').text($(this).val());
			var inputWidth = $(this).siblings('span.input_hidden').width();
			$(this).width(inputWidth);
		});
		$('.multiple-val-input ul input:text').on('keypress', function(event){
			if(event.which == 32 || event.which == 44){
				var toAppend  = $(this).val();
				if(toAppend != '' && isValidEmailAddress(toAppend)) {	
					$('<li><a href="#">×</a><div>'+toAppend+'</div></li>').insertBefore($(this));
					$(this).val('');
					value += toAppend + ',';
					$('#visible_to').val(value);
				}
				return false;
			};
		});
		$(document).on('click','.multiple-val-input ul li a', function(e){
			e.preventDefault();
			$(this).parents('li').remove();
			$('input.emaillist').focus();
		});
		function isValidEmailAddress(toAppend) {
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(toAppend);
		}
	</script>
	
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
