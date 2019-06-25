<!DOCTYPE html>
<html>
  <head>
    <title>{{$details['title'].' '.$details['city'].', '.$details['location']}}</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="description" content="{{$details['title'].' '.$details['city'].', '.$details['location']}}" />
	<meta name="keywords" content="{{$details['title'].' '.$details['city'].', '.$details['location']}}" />
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPHJSZW2HT2YXPFpfEOfPOO3LV-4tpEf4&v=3.exp&sensor=true&libraries=places"></script>
    
	<link rel="stylesheet" href="{{ url('/assets/frontend/css/bootstrap.min.css') }}" type="text/css" >
	<link rel="stylesheet" href="{{ url('/assets/frontend/fonts/font.css') }}" type="text/css">
	<link rel="stylesheet" href="{{ url('/assets/frontend/fonts/font-awesome-4.4.0/css/font-awesome.min.css') }}">
	
	<link href="{{ url('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ url('/assets/plugins/select/select.min.css') }}" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
	<link rel="stylesheet" href="{{ url('/assets/css/bootstrap-select.min.css') }}">
	<link rel="stylesheet" href="{{ url('/assets/frontend/css/style.css') }}">
	
	<script src="{{ url('/assets/frontend/js/bootstrap.min.js') }}" type="text/javascript"></script>
		
	<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.autocomplete.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('/assets/js/app/autocomplete.cities.js') }}"></script>
	<script src="{{ url('/assets/js/bootstrap-select.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('/assets/plugins/select/select.min.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
  </head>
  <style>
  .main-container{
	  position:relative;
  }
  .main-container-overlay{
	  position:absolute;
	  top:0;
	  left:0;
	  height:100%;
	  width:100%;
	  background:rgba(158,158,158 ,0.5);
	  text-align:center;
	  vertical-align:middle;
  }
  .load-img{
	  vertical-align:middle;
	  height:200px;
	  margin-top:8%;
  }
  </style>
  <body>
	<div class="main-container">
		<div class="container">
			<div class="alert alert-success" style="display:none;" id="msgAlert">
			  <strong>{{t('Success')}}</strong> Indicates a successful or positive action.
			</div>
			<div class="row">
				<form class="form-horizontal" id="createAd-1" method="POST" action="" enctype="multipart/form-data">
					{!! csrf_field() !!}
					<input type="hidden" name="biz_id" id="biz_id" value="{{$details['biz_id']}}" />
					<div class="col-sm-6">
					<!-- Category --> 
					<div class="form-group required <?php echo ($errors->has('parent')) ? 'has-error' : ''; ?>">
						<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
						<div class="col-md-8">
							<select name="category_id" id="category_id" class="form-control selecter">
								<option value="0" data-type=""
										@if(old('parent')=='' or old('parent')==0)selected="selected"@endif> {{ t('Select a category') }} </option>
								@foreach ($categories as $cat)
									<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
											@if(old('category_id', $details['cat'])==$cat->tid)selected="selected"@endif> {{ $cat->name }} </option>
								@endforeach
							</select>
						</div>
					</div>
										
					<!-- Phone Number -->
					<div class="form-group required <?php echo ($errors->has('phone')) ? 'has-error' : ''; ?>">
						<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }} <sup>*</sup></label>
						<div class="col-md-8">
							<input id="phone" name="phone"
									   placeholder="{{ t('Phone Number (in local format)') }}"
									   class="form-control input-md" type="text"
									   value="{{ old('phone', $details['phone']) }}">
						</div>
					</div>
					
					<!-- Website -->
					<div class="form-group required">
						<label class="col-md-3 control-label" for="title">{{ t('Business email') }} <sup>*</sup></label>
						<div class="col-md-8">
							<input id="email" name="email" placeholder="sample@your-site.com" class="form-control input-md"
								   type="text" value="{{ old('email', $details['email']) }}">
						</div>
					</div>
					
					<!-- Address 1 -->
					<div class="form-group required <?php echo ($errors->has('address1')) ? 'has-error' : ''; ?>">
						<label class="col-md-3 control-label" for="title">{{ t('Address 1') }} <sup>*</sup></label>
						<div class="col-md-8">
							<input id="address1" name="address1" class="form-control input-md" type="text" value="{{ old('address1', $details['address1']) }}">
						</div>
					</div>
					
					<!-- Address 2 -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="title">{{ t('Address 2') }}</label>
						<div class="col-md-8">
							<input id="address2" name="address2" class="form-control input-md" type="text" value="{{ old('address2', $details['address2']) }}">
						</div>
					</div>
					
					<!-- Country -->
					@if(!$ip_country)
						<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
							<label class="col-md-3 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
							<div class="col-md-8">
								<select id="country" name="country" class="form-control sselecter">
									<option value="0" {{ (!old('country', $details['country_code']) or old('country', $details['country_code'])==0) ? 'selected="selected"' : '' }}> {{ t('Select your Country') }} </option>
									@foreach ($countries as $item)
										<option value="{{ $item->get('code') }}" {{ (old('country', $details['country_code'])==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
									@endforeach
								</select>
							</div>
						</div>
					@else
						<input id="country" name="country" type="hidden" value="{{ $details['country_code']}}">
					@endif

					
					<!-- Location -->
					<div id="locationBox"
						 class="form-group required <?php echo ($errors->has('location')) ? 'has-error' : ''; ?>">
						<label class="col-md-3 control-label" for="location">{{ t('Location') }} <sup>*</sup></label>
						<div class="col-md-8">
							<select id="location" name="location" class="form-control sselecter">
								<option value="0" {{ (!old('location') or old('location')==0) ? 'selected="selected"' : '' }}> {{ t('Select your Location') }} </option>
							</select>
						</div>
					</div>

					<!-- City -->
					<div id="city_box"
						 class="form-group required <?php echo ($errors->has('city')) ? 'has-error' : ''; ?>">
						<label class="col-md-3 control-label" for="city">{{ t('City') }} <sup>*</sup></label>
						<div class="col-md-8">
							<select id="city" name="city" class="form-control sselecter">
								<option value="0" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}> {{ t('Please select your location before') }} </option>
							</select>
						</div>
					</div>
					
					<!-- Zipcode -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="title">{{ t('Zip code') }}</label>
						<div class="col-md-8">
							<input id="zip" name="zip" class="form-control input-md" type="text" value="{{ old('zip', $details['zip']) }}"> 
						</div>
					</div>
					
					@if($details['claim_id']>0)
					<!-- Zipcode -->
					<div class="form-group">
						<label class="col-md-3 control-label" for="title">{{ t('Status') }}</label>
						<div class="col-md-8" style="margin-top: 8px;">
							@if($details['status']==3)
								{{t('Rejected')}}
							@else
								{{t('Waiting for approval')}}
							@endif
							
						</div>
					</div>
						@if($details['status_msg']!='')
						<div class="form-group">
							<label class="col-md-3 control-label" for="title">{{ t('Status Message') }}</label>
							<div class="col-md-8" style="margin-top: 8px;">
								{{$details['status_msg']}}
							</div>
						</div> 
						@endif
					@endif
					
					</div>
					<div class="col-sm-6">
					<!-- Map -->
					<div class="form-group" style="margin-bottom:5px;">
						<div class="col-md-12 required">
						
							<div class="col-md-2" style="padding: 0px; margin: 25px 0px 7px;">
								<label class="control-label" style="padding-top:0;" for="title">Pin Location</label>
							</div>
							
							<div class="col-md-4" style="padding: 0px; margin: 0px 0px 10px;">
								<label class="control-label" style="padding-top:0;" for="lat1"> {{ t('Lat') }} <sup>*</sup></label>
								<input id="lat1" name="lat1" style="width:95%;" class="form-control input-md" value="{{ old('lat1', $details['lat']) }}" />
							</div>
							
							<div class="col-md-4" style="padding: 0px; margin: 0px 0px 10px;">
								<label class="control-label" style="padding-top:0;" for="lon1"> {{ t('Long') }} <sup>*</sup></label>
								<input id="lon1" name="lon1" style="width:95%;" class="form-control input-md" value="{{ old('lon1', $details['lon']) }}" />
							</div>
							<div class="col-md-2" style="padding: 0px; margin: 25px 0px 7px;">
								<a href="#" onClick="return auto_locate();" style="float:right;">{{ t('Auto Locate')}}</a>
							</div>
						</div>
						
						<div class="col-md-12">
							@if((isset(Auth::user()->id) && Auth::user()->id>0))
								{{--*/ $vH = '300px'; /*--}}
							@else
								{{--*/ $vH = '200px'; /*--}}
							@endif
							<div id="map_canvas" style="width: 100%; height: {{$vH}};"></div>
						</div>
						
						@if(!(isset(Auth::user()->id) && Auth::user()->id>0))
						<div class="col-md-12 required">
							<h4 style="border-bottom:1px solid #e5e5e5; margin:10px 0;"><b>{{t('Personal Details')}} <sup>*</sup></b></h4>
							<div class="col-md-6">
								<!-- Gender -->
								<div style="padding-right:5px;" class="form-group required <?php echo (isset($errors) and $errors->has('gender')) ? 'has-error' : ''; ?>">
									<select name="gender" id="gender" class="form-control selecter">
										<option value="0"
												@if(old('gender')=='' or old('gender')==0)selected="selected"@endif> {{ t('Select Gender') }} </option>
										@foreach ($genders as $gender)
											<option value="{{ $gender->tid }}" @if(old('gender')==$gender->tid)selected="selected"@endif>
												{{ $gender->name }}
											</option>
										@endforeach
									</select>
								</div>

								<!-- First Name -->
								<div style="padding-right:5px; margin-bottom:0;" class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
									<input id="name" name="name" placeholder="{{ t('Name') }}" class="form-control input-md" type="text"
										   value="{{ old('name') }}">
								</div>
							</div>
							
							<div class="col-md-6">
								<div style="padding-left:5px;" class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
									<input id="pemail" name="pemail" type="email" class="form-control" placeholder="{{ t('Email') }}"
										   value="{{ old('email') }}">
								</div>

								<div style="padding-left:5px; margin-bottom:0;" class="form-group required <?php echo (isset($errors) and $errors->has('password')) ? 'has-error' : ''; ?>">
									<input id="password" name="password" type="password" class="form-control"
										   placeholder="{{ trans('Password') }} {{ t('At least 5 characters') }}">
								</div>
							</div>
						</div>
						@endif
						
						<!-- Button  -->
						<div class="col-md-12" style="text-align: right; margin-top:10px;">
							<a id="claimBizBtn" href="#" onClick="return claimBiz();" style="padding:6px 16px;" class="btn btn-success btn-lg"> {{ t($details['btn']) }} </a>
						</div>
					</div>
					</div>

			</form>
		</div>
	</div>
    <div class="main-container-overlay" id="cload" style="display:none;">
    	<img src="{{url('uploads/pictures/loading.gif')}}" alt="Loaging" class="load-img" >
    </div>
	
	<script language="javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}); 
	</script>
	<script language="javascript">
		var siteUrl = '<?php echo url('/'); ?>';
		var countries = <?php echo (isset($countries)) ? $countries->toJson() : '{}'; ?>;
		var countryCode = '<?php echo old('country', $details['country_code']); ?>';
		var lang = {
			'select': {
				'category': "{{ t('Select a category') }}",
				'subCategory': "{{ t('Select a sub-category') }}",
				'country': "{{ t('Select a country') }}",
				'loc': "{{ t('Select a location') }}",
				'subLocation': "{{ t('Select a sub-location') }}",
				'city': "{{ t('Select a city') }}"
			}
		};
		var category = <?php echo old('parent', 0); ?>;
		var categoryType = '<?php echo old('parent_type'); ?>';
		if (categoryType=='') {
			var selectedCat = $('select[name=parent]').find('option:selected');
			categoryType = selectedCat.data('type');
		}
		var subCategory = <?php echo old('category', 0); ?>;
		var loc = '<?php echo old('location', $details['location_id']); ?>';
		var subLocation = '<?php echo old('sub_location', 0); ?>';
		var city = '<?php echo old('city', $details['city_id']); ?>';
		var hasChildren = '<?php echo old('has_children'); ?>';

		$(document).ready(function () {
			setTimeout("initialize(\"{{$details['lat']}}\", \"{{$details['lon']}}\");", 500);
		});
		
		var map;

		function initialize(lat, lon) {
			document.getElementById("lat1").value = lat;
			document.getElementById("lon1").value = lon;
			var myLatlng = new google.maps.LatLng(lat, lon);
	
			var myOptions = {
				zoom: 8,
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
		
		function isEmail(what) {
			// Works
			if (what.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/) != -1)
				return true;
			else
				return false;
		}

		function claimBiz(){
			var category_id = $.trim($("#category_id").val());
			var biz_id = $.trim($("#biz_id").val());
			var phone = $.trim($("#phone").val());
			var email = $.trim($("#email").val());
			var address = $.trim($("#address1").val());
			var address2 = $.trim($("#address2").val());
			var zip = $.trim($("#zip").val());
			var city = $.trim($("#city option:selected").val());
			var location = $.trim($("#location option:selected").val());
			var lat = $.trim($("#lat1").val());
			var lon = $.trim($("#lon1").val());
			$("#category_id").parent().removeClass('has-error');
			$("#phone").parent().removeClass('has-error');
			$("#email").parent().removeClass('has-error');
			$("#address1").parent().removeClass('has-error');
			$("#location").parent().removeClass('has-error');
			$("#city").parent().removeClass('has-error');
			$("#lat1").parent().removeClass('has-error');
			$("#lon1").parent().removeClass('has-error');
			var err = 0;
			if(category_id=='0'){
				err = 1;
				$("#category_id").parent().addClass('has-error');
			}
			if(phone==''){
				err = 1;
				$("#phone").parent().addClass('has-error');
			}
			if(!isEmail(email)){
				err = 1;
				$("#email").parent().addClass('has-error');
			}
			if(address==''){
				err = 1;
				$("#address1").parent().addClass('has-error');
			}
			if(location=='' || location=='0' ){
				err = 1;
				$("#location").parent().addClass('has-error');
			}
			if(city=='' || city=='0' ){
				err = 1;
				$("#city").parent().addClass('has-error');
			}
			if(lat=='' || lat=='0' ){
				err = 1;
				$("#lat1").parent().addClass('has-error');
			}
			if(lon=='' || lon=='0' ){
				err = 1;
				$("#lon1").parent().addClass('has-error');
			} 
			
			var gender 	 = '';
			var pemail 	 = ''; 
			var name 	 = '';
			var password = '';
			@if(!(isset(Auth::user()->id) && Auth::user()->id>0))
				gender = $.trim($("#gender").val());
				$("#gender").parent().removeClass('has-error');
				if(gender=='0'){
					err = 1;
					$("#gender").parent().addClass('has-error');
				}
				pemail = $.trim($("#pemail").val());
				$("#pemail").parent().removeClass('has-error');
				if(!isEmail(pemail)){
					err = 1;
					$("#pemail").parent().addClass('has-error');
				}
				name = $.trim($("#name").val());
				$("#name").parent().removeClass('has-error');
				if(name==''){
					err = 1;
					$("#name").parent().addClass('has-error');
				}
				password = $.trim($("#password").val());
				$("#password").parent().removeClass('has-error');
				if(password.length<5){
					err = 1;
					$("#password").parent().addClass('has-error');
				}
			@endif
			
			if(err == 0){
				$("#cload").fadeIn('normal');
				$.ajax({
					url: "{{url('en/claimpost')}}",
					type: 'post',
					data: {category_id:category_id, biz_id:biz_id, phone:phone, email:email, address:address, address2:address2, zip:zip, city:city, location:location, lat:lat, lon:lon, gender:gender, pemail:pemail, name:name, password:password},
					dataType:'json',
					success: function(data)
					{
						$("#msgAlert").removeClass('alert-success');
						$("#msgAlert").removeClass('alert-danger');
						if(data['status']=='success'){
							$("#msgAlert").html(data['statusMsg']);
							$("#msgAlert").addClass('alert-success');
						}else{
							$("#msgAlert").html(data['statusMsg']);
							$("#msgAlert").addClass('alert-danger');
						}
						$("#msgAlert").fadeIn('normal');
						setTimeout('$("#msgAlert").fadeOut("normal");', 5000);
						$("#cload").fadeOut('normal');
						console.log("success");
						console.log(data);
						return false;					
					},
					error : function(xhr, status,data){
						$("#msgAlert").removeClass('alert-success');
						$("#msgAlert").removeClass('alert-danger');
						$("#msgAlert").html("{{t('Unfortunately your request cannot be processed, Please contact Admin.')}}");
						$("#msgAlert").addClass('alert-danger');
						$("#msgAlert").fadeIn('normal');
						setTimeout('$("#msgAlert").fadeOut("normal");', 5000);
						$("#cload").fadeOut('normal');
						console.log("error");
						console.log(data);
						return false;
					}
				});
			}
			
			return false;
		}
		
		function auto_locate() {
			var address = $.trim($("#address1").val());
			var address2 = $.trim($("#address2").val());
			var zip = $.trim($("#zip").val());
			var city = $.trim($("#city option:selected").text());
			var country = $.trim($("#country").val());
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

	</script>
	

  </body>
</html>