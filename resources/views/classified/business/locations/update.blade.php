@extends('classified.layouts.layout')
@section('javascript-top')
	@parent
@endsection
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				<!-- BOF SIDEBAR -->
				@if ($user->user_type_id  == 3)
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				@else
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				@endif
				<!-- EOF SIDEBAR -->
				
				@if (count($errors) > 0)
					<div class="col-lg-9">
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

				<!-- BOF CONTENT -->
				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						@if (Session::has('flash_notification.message')) @include('flash::message') @endif
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Update the Location of') }} @if(isset($locations)) @if(Request::segment(1) == 'ar') {{ $locations->title_ar }} @else {{ $locations->title }} @endif @endif </strong></h2>
						<div class="row">
							<div class="col-sm-12">
								<form class="form-horizontal create-location" method="POST" action="{{ lurl('account/business/location/update') }}">
									{!! csrf_field() !!}
									{{ Form::hidden('id', $locations->id) }}
									<fieldset>
										
										<!-- Address 1 -->
										<div class="form-group required <?php echo ($errors->has('address1')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address 1') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="address1" name="address1" class="form-control input-md" type="text" value="{{ $locations->address_1 }}">
											</div>
										</div>
										
										<!-- Address 2 -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Address 2') }}</label>
											<div class="col-md-8">
												<input id="address2" name="address2" class="form-control input-md" type="text" value="{{ $locations->address_2 }}">
											</div>
										</div>
										
										<!-- Zipcode -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Zip code') }}</label>
											<div class="col-md-8">
												<input id="zip" name="zip" class="form-control input-md" type="text" value="{{ $locations->zip }}">
											</div>
										</div>
										
										<!-- Phone Number -->
										<div class="form-group required <?php echo ($errors->has('phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }} <sup>*</sup></label>
											<div class="col-md-8">
												<!-- <div class="input-group">
													<span id="phone_country" class="input-group-addon"><i class="icon-phone-1"></i></span>
												</div> -->
												<input id="phone" name="phone"  placeholder="{{ t('Phone Number (in local format)') }}" class="form-control" type="text" value="{{ $locations->phone }}" />
											</div>
										</div>
										
										<!-- Country -->
										<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="country">{{ t('Country') }} <sup>*</sup></label>
											<div class="col-md-8">
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
										</div>
										
										<!-- City selectpicker -->
										<div class="form-group required <?php echo ($errors->has('city')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('City') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="citys" name="city" class="form-control sselecter" onchange="return auto_locate();"></select>
												<input type="hidden" id="subadmin1" value="{{ $locations->city_id }}" />
											</div>
										</div>
										
										<!-- Map -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title"></label>
											<div class="col-md-8">
												<div style="display: none;">
													<label class="control-label" for="lat1"> {{ t('Lat') }}</label>
													<input id="lat1" name="lat1" style="width:50%;" class="form-control input-md" value="{{ $locations->lat }}" readonly />
													<label class="control-label" for="lon1"> {{ t('Long') }}</label>
													<input id="lon1" name="lon1" style="width:50%;" class="form-control input-md" value="{{ $locations->lon }}" readonly />
													<br />
												</div>
												<a href="#" onClick="return auto_locate();" style="float:right;"> {{ t('Auto Locate')}} </a>
												<div id="map_canvas" style="width: 100%; height: 250px;"></div>
											</div>
										</div>
										
										<!-- Button  -->
										<div class="form-group">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8">
												@if(isset($locations->user_id))
													{{--*/ $burl = 'account/business/location/'.$locations->id; /*--}}
												@else	
													{{--*/ $burl = 'account/business/location/'.$locations->biz_id; /*--}}
												@endif
												<a href="{{ lurl($burl) }}" class="btn btn-default btn-md"> @lang('global.Cancel') </a>
												<button id="submit-btn" class="btn btn-success btn-md"> {{ t('Submit') }} </button>
											</div>
										</div>

									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></script>
	<!-- BOF MAP LOCATION SETTINGS -->
	<script language="javascript">
	
		$(document).ready(function () {
			
			initialize('{{ $locations->lat }}', '{{ $locations->lon }}');
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
	
		$('form.create-location').submit(function() {
			if($.trim($('#address1').val()) == '') {
				
				$('#address1').focus();
				return false;
			}
			else if($.trim($('#phone').val()) == '') {
			
				$('#phone').focus();
				return false;
			}
			else if($.trim($('#countrys').val()) == '') {
			
				$('#countrys').focus();
				return false;
			}
			else if($.trim($('#citys').val()) == '') {
			
				$('#citys').focus();
				return false;
			}
			else {
				
				return true;
			}
		});
		
	</script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
