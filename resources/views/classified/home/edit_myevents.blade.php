@extends('classified.layouts.layout')
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row"> 
			
				@if (Session::has('flash_notification.message'))
				<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
					<div class="row">
						<div class="col-lg-12"> @include('flash::message') </div>
					</div>
				</div>
				@endif
				
				<?php  if ($user->user_type_id  == 3) { ?>
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					<div class="inner-box"> 
					
						@if (Session::has('flash_notification.message'))
							<div class="container">
								<div class="row">
									<div class="col-lg-12">
										@include('flash::message')
									</div>
								</div>
							</div>
						@endif
						
						@if (count($errors) > 0)
						<div class="alert alert-danger">
						  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						  <h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
						  <ul class="list list-check">
							@foreach ($errors->all() as $error)
								<li> {{ $error }} </li>
							@endforeach
						  </ul>
						</div>
						@endif
						
						<div class="alert alert-danger" style="display: none;" id="showError">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								<li id="error">  </li>
							</ul>
						</div>
						
						<h2 class="title-2"><i class="icon-docs"></i> @lang('Edit My Events') </h2>
						<div class="table-responsive">
							<form method="POST" action="{{ lurl('account/myevents/post') }}" enctype='multipart/form-data' id="my_event_post">
								@if(!empty($events))
									@foreach($events as $event)
									<div class="event_detail_section">
										<div class="detai_section">
											<!-- <div class="top_head"> <span>1</span>
											  <h4>{{ t('event details') }}</h4>
											</div> -->
											<div class="eve_conte">
											
												<!-- Title -->
												<label>{{ t('event title') }}<sup>*</sup></label>
												<input type="text" class="form-control" name="event_title" value="{{ $event->event_name }}" placeholder="{{ t('give it a short distinct name') }}">
												<input type="hidden" id="event_id" name="event_id" value="{{ $event->id }}">
												
												<!-- Type -->
												<div class="select_box">
													<div class="form-group">
														<label for="sel1">{{ t('Event type') }}<sup>*</sup></label>
														{!! Form::select('event_type_id',(['' => t('Event type')] +$event_type->toArray()), $event->event_type_id, array('class' => 'form-control sselecter','id' => 'sel1')) !!}
													</div>
												</div>
												
												<!-- Start Date & Time -->
												<div class="start">
													<div class="col-md-6">
														<div class="row">
															<label>{{ t('starts') }}<sup>*</sup></label>
															<input type="text" class="form-control datetimepicker" name="startDate" style="font-size: 12px" value="{{ $event->event_date }} {{ $event->event_starttime }}" readonly />
														</div>
													</div>

													<div class="col-md-6">
														<div class="row">
															<label class="start-label-secnd">{{ t('ends') }}<sup>*</sup></label>
															<input type="text" class="form-control datetimepicker start-secnd" name="endDate" style="font-size: 12px" value="{{ $event->eventEnd_date }} {{ $event->event_endtime }}" readonly />
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
												
												<input type="hidden" id="sub_location" name="sub_location" value="" />
												<input type="hidden" id="has_children" name="has_children" value="{{ old('has_children') }}">
							 
												<!-- City selectpicker -->
												<div class="form-group">
													<label class="control-label">{{ t('City') }} <sup>*</sup></label>
													<select id="citys" name="event_location" class="form-control sselecter" onchange="return auto_locate();"></select>
													<input type="hidden" id="subadmin1" value="{{ $event->event_place }}" />
												</div>
												
												<!-- Map -->
												<div class="form-group">
													<label class="control-label" for="title">{{ t('Locations') }}</label>
													<div>
														<div id="map_canvas" style="width: 100%; height: 200px;"></div>
													</div>
													<div style="display: none;">
														<label class="control-label" for="lat1"> {{ t('Latitude') }}</label>
														<input type="text" id="lat1" name="lat1" class="form-control" value="{{ $event->latitude }}" readonly />
														<label class="control-label" for="lon1"> {{ t('Longitude') }}</label>
														<input type="text" id="lon1" name="lon1" class="form-control" value="{{ $event->longitude }}" readonly />
													</div>
												</div>
											
												<!-- Social Share -->
												<div class="social_section1">
													@if($event->social_share == 1)
														{{--*/ $chkd = 'checked'; /*--}}
													@else
														{{--*/ $chkd = ''; /*--}}
													@endif
													<label>
														<input type="checkbox" name="social_share" value="1" id="social_share" {{ $chkd }} />
														<span style="margin-left: 5%; color: #000;">{{ t('Allow links to Facebook, Twitter and Instagram') }}</span>
													</label>
												</div>
												
											</div>
										</div>
						  
										<!-- Event Descreption -->
										<div class="descreption">
											<label>{{ t('Event Details') }}<sup>*</sup></label>
											<div class="tst_area1">
												<textarea id="messageArea" name="event_description" rows="7" class="form-control ckeditor" placeholder="Write your message..">{{ $event->about_event }} </textarea>
											</div>
							
											<!-- Organization description -->
											<label style="margin-top: 5%;">{{ t('Organization details') }}</label>
											<div class="tst_area2">
												<!-- <img src="images/html_editor.jpg" pagespeed_url_hash="3410061205" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>-->
												<textarea id="messageArea1" name="messageArea1" rows="7" class="form-control ckeditor" placeholder="Write your message..">{{ $event->org_description }}</textarea>
											</div>
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
											@if($event->event_image1 != '')
												<img class="thumbnail img-responsive" src="{{ url($event->event_image1) }}" alt="" height="auto" width="auto" />
											@else
												<img class="thumbnail img-responsive" src="{{ url('/uploads/pictures/no-image.jpg') }}" alt="" height="auto" width="auto" />
											@endif
										</div>
										
										<div class="image_drop_1">
											<div class="dropzone" id="mydropzonevent" name="mydropzone"> </div>
											<!-- <p> {{ t('we recommend use at least a 2160x1080px(2:1ratio) image thats no larger than 3MB') }} </p> -->
										</div>

										<input type="hidden" id="imge2" name="imge1" value=""/>
										<input type="hidden" id="imge2" name="imge2" value="{{ $event->event_image1 }}"/>
										
										<div class="setting_holder1">
											<label>{{ t('Create Tickets') }}</label>
											<div class="private">
												@if($event->ticket_type == 0)
													{{--*/ $chkd = 'checked'; /*--}}
												@else
													{{--*/ $chkd = ''; /*--}}
												@endif
												<input type="radio" name="ticket_type" value="0" {{ $chkd }} />
												<span><strong>{{ t('None') }}</strong></span><br>
											</div>
											<div class="private">
												{{--*/ $tickets = ''; /*--}}
												@if($event->ticket_type == 1)
													{{--*/ $chkd = 'checked'; /*--}}
													{{--*/ $data = unserialize($event->ticket_details); /*--}}
													{{--*/ $tickets = $data['tickets']; /*--}}
												@else
													{{--*/ $chkd = ''; /*--}}
												@endif
												<input type="radio" name="ticket_type" value="1" {{(old('ticket_type')==1)?'checked="checked"':''}} {{ $chkd }} />
												<span><strong>{{ t('Free Ticket') }}</strong></span><br>
												<input type="text" id="free_tickets" name="free_tickets" value="{{ $tickets }}" style="width:30%; float:left;" class="form-control" placeholder="#">
											</div>
											<div class="public">
												{{--*/ $tickets = ''; /*--}}
												{{--*/ $price = ''; /*--}}
												@if($event->ticket_type == 2)
													{{--*/ $chkd = 'checked'; /*--}}
													{{--*/ $data = unserialize($event->ticket_details); /*--}}
													{{--*/ $tickets = $data['tickets'] /*--}}
													{{--*/ $price = $data['price'] /*--}}
												@else
													{{--*/ $chkd = ''; /*--}}
												@endif
												<input type="radio" name="ticket_type" value="2" {{(old('ticket_type')==2)?'checked="checked"':''}} {{ $chkd }} />
												<span><strong>{{ t('Paid Ticket') }}</strong></span><br>
												<input type="text" id="paid_tickets" name="paid_tickets" value="{{ $tickets }}" style="width:30%; float:left;" class="form-control" placeholder="#">
												<input type="text" id="ticket_price" name="ticket_price" value="{{ $price }}" style="width:30%; float:left; margin-left:5px;" class="form-control" placeholder="{{t('Price')}}">
											</div>
										</div>
						  
										<!-- Additional Settings -->
										<!-- <div class="top_head"> <span>3</span>
											<h4>{{ t('Additional Settings') }}</h4>
										</div> -->
										
										<div class="setting_holder">
											<label>{{ t('listing privacy') }}</label>
											<div class="private">
												@if($event->privacy == 0)
													{{--*/ $chkd = 'checked'; /*--}}
												@else
													{{--*/ $chkd = ''; /*--}}
												@endif
												<input type="radio" name="privacy" class="privacy" id="public" value="0" {{ $chkd }} />
												<span><strong>{{ t('Public page') }}: </strong> {{ t('list this events on a Eventbrite and search engines.') }}</span><br>
											</div>
											<div class="public">
												@if($event->privacy == 1)
													{{--*/ $chkd = 'checked'; /*--}}
												@else
													{{--*/ $chkd = ''; /*--}}
												@endif
												<input type="radio" name="privacy" class="privacy" id="private" value="1" {{ $chkd }} />
												<span><strong>{{ t('Private page') }}: </strong> {{ t('do not list this event plublicly') }}</span><br>
											</div>
										</div>
						  
										<div class="form-group private_div" id="now-visible">
										@if($event->visible_to != '')
											<label for="sel1"><small> {{ t('Sended Invitations') }} </small></label>
											<div> 
												{{--*/ $visible = unserialize($event->visible_to); /*--}}
												{{--*/ $i = 0; /*--}}
												@foreach($visible as $key => $val)
													<div><span class="label label-default visible-label" id="label-visible-{{$i}}">{{$val}}</span></div>
												{{--*/ $i++; /*--}}
												@endforeach
											</div>
										@endif
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
										
										<a href="javascript:window.history.back();" class="btn btn-default btn-md">{{ t('Cancel') }}</a>
										<button type="submit" class="btn btn-primary btn-md">{{ t('Submit') }}</button>
										
									</div>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									@endforeach
								@endif
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
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
			
			var lati = $("#lat1").val();
			var loni = $("#lon1").val();
			initialize( lati, loni);
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
					data: {'code': $("select#countrys option:selected").val(), 'city': $("#subadmin1").val()},
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
		{
			if($('select#citys').val() == 0)
			{
				$('#showError').show(function(){
					$('#error').html('The City field is required');  
				});
				return false;
			}
			
			if($('input#private').is(":checked")) {
				
				if($.trim($("#now-visible").html()) = '' && $.trim($("#visible_to").val()) == '') {
					$('.emaillist').focus();
					return false;
				} else {
					return true;
				}
			}
			
		});
	</script>
	
	<script>
		var value = '';
		$('.multiple-val-input').on('click', function(){
			$('.emaillist').focus();
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
			$('.emaillist').focus();
		});
		function isValidEmailAddress(toAppend) {
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(toAppend);
		}
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
			}).trigger('change');
		});
	</script>
	
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
