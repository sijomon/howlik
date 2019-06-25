@extends('classified.layouts.layout')

@section('javascript-top')
	@parent
	
@endsection

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (count($errors) > 0)
					<div class="col-lg-12">
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

				@if (Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<?php  if ($user->user_type_id  == 3) { ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--/.page-sidebar-->

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Update Business Listing') }}</strong></h2>
						<div class="row">
							<div class="col-sm-12">


								<form class="form-horizontal" id="createAd-1" method="POST" action="{{ lurl('account/update-business-post') }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>

										<!-- Category -->
										<div class="form-group required <?php echo ($errors->has('parent')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8">{{old('parent', $business->parent)}}
												<select name="category_id" id="category_id" class="form-control selecter">
													<option value="0" data-type=""
															@if(old('category_id', $business->category_id)=='' or old('category_id', $business->category_id)==0)selected="selected"@endif> {{ t('Select a category') }} </option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if(old('category_id', $business->category_id)==$cat->tid)selected="selected"@endif> {{ $cat->name }} </option>
													@endforeach
												</select>
											</div>
										</div>

										<!-- Keywords -->
										<div class="form-group">
											<label class="col-md-3 control-label">{{ t('Keywords') }} </label>
											<div class="col-md-8">
												<p id="key_div"></p>
											</div>
										</div>

										<!-- Business title -->
										<div class="form-group required <?php echo ($errors->has('title')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Title') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="{{ t('Business name') }}" class="form-control input-md"
													   type="text" value="{{ old('title', $business->title) }}">
												<span class="help-block">{{ t('A great title needs at least 60 characters.') }} </span>
											</div>
										</div>

										<!-- Describe business -->
										<div class="form-group required <?php echo ($errors->has('description')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="description">{{ t('Describe business') }} <sup>*</sup></label>
											<div class="col-md-8">
												<textarea class="form-control" id="description" name="description"
														  rows="10">{{ old('description', $business->description) }}</textarea>
												<p class="help-block">{{ t('Describe what makes your business unique') }}</p>
											</div>
										</div>

										<input id="seller_name" name="seller_name" type="hidden" value="{{ $user->name }}">
										<input id="seller_email" name="seller_email" type="hidden" value="{{ $user->email }}">
										<input id="biz_id" name="biz_id" type="hidden" value="{{ $business->id }}">
										<!-- Business hours -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Business hours') }}</label>
											<div class="col-md-8">
												<div class="input-group">
													<div class="biz-hours" id="biz-hours">
														<div class="biz-hours-box">
														@if(isset($business->biz_hours) && $business->biz_hours!='')
															{{--*/ $bizhrs = unserialize($business->biz_hours); /*--}}
															{{--*/ $bizDayA = array(0=>'Mon',1=>'Tue',2=>'Wed',3=>'Thu',4=>'Fri',5=>'Sat',6=>'Sun'); /*--}}
															@foreach($bizhrs as $key => $value)
																{{--*/ $bizhrsA = explode(' ', $value); /*--}}
																{{--*/ $timeSt = strtotime($bizhrsA[1]); /*--}}
																{{--*/ $timeEd = strtotime($bizhrsA[2]); /*--}}
																<div><span><b>{{$bizDayA[$bizhrsA[0]]}} </b></span><span>{{date("h:i A", strtotime($timeSt))}} </span><span>- </span><span>{{date("h:i A", strtotime($timeEd))}} {{($bizhrsA[2]=='00.00')?'('.t('midnight next day').') ':''}}</span><a href="#" class="rem-bh">{{t('Remove')}}</a><input name="biz_hours[]" value="{{$value}}" type="hidden"></div>
															@endforeach
														@endif
														</div>
														<ul class="biz-hours-select">
															<li>{{--*/ $date = '2016-11-21' /*--}}
																<select class="bh-day" id="bh-day">
																	@for ($i = 0; $i < 7; $i++)
																		<option value="{{ $i }}">{{date("D", strtotime($date))}}</option>
																		{{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))); /*--}}
																	@endfor
																</select>
															</li>
															<li>{{--*/ $time = strtotime('12:00 AM'); /*--}}
																<select class="bh-start" id="bh-start">
																	@for ($i = 0; $i < 48; $i++)
																		<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}</option>
																		{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
																	@endfor
																</select>
															</li>
															<li>{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
																<select class="bh-end" id="bh-end" style="width:90px;">
																	@for ($i = 0; $i < 48; $i++)
																		<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}@if($i==47){{ ' ('.t('midnight next day').')'}}@endif</option>
																		{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
																	@endfor
																</select>
															</li>
															<li>
																<button type="button" id="biz-hr-btn" class="btn" style="padding:7px 9px;"><span>{{t('Add Hours')}}</span></button>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										
										<!-- Phone Number -->
										<div class="form-group required <?php echo ($errors->has('phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div class="input-group"><span id="phone_country" class="input-group-addon"><i
																class="icon-phone-1"></i></span>
													<input id="phone" name="phone"
														   placeholder="{{ t('Phone Number (in local format)') }}"
														   class="form-control input-md" type="text"
														   value="{{ old('phone', $business->phone) }}">
												</div>
											</div>
										</div>
										
										<!-- Website -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Website') }}</label>
											<div class="col-md-8">
												<input id="web" name="web" placeholder="{{ t('www.your-site.com') }}" class="form-control input-md"
													   type="text" value="{{ old('web', $business->web) }}">
											</div>
										</div>
										
										<!-- Address 1 -->
										<div class="form-group required <?php echo ($errors->has('address1')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address 1') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="address1" name="address1" class="form-control input-md" type="text" value="{{ old('address1', $business->address1) }}">
											</div>
										</div>
										
										<!-- Address 2 -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Address 2') }}</label>
											<div class="col-md-8">
												<input id="address2" name="address2" class="form-control input-md" type="text" value="{{ old('address2', $business->address2) }}">
											</div>
										</div>
										
										<!-- Country -->
										@if(!$ip_country)
											<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="country" name="country" class="form-control sselecter">
														<option value="0" {{ (!old('country', $business->country_code) or old('country', $business->country_code)==0) ? 'selected="selected"' : '' }}> {{ t('Select your Country') }} </option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country', $business->country_code)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="country" name="country" type="hidden" value="{{ $business->country_code }}">
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
												<input id="zip" name="zip" class="form-control input-md" type="text" value="{{ old('zip', $business->zip) }}">
											</div>
										</div>
										
										<!-- Map -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Pin Location') }}</label>
											<div class="col-md-8">
												<label class="control-label" for="lat1"> {{ t('Lat') }}</label>
												<input id="lat1" name="lat1" style="width:50%;" class="form-control input-md" value="{{ old('lat1', $business->lat) }}" />
												<label class="control-label" for="lon1"> {{ t('Long') }}</label>
												<input id="lon1" name="lon1" style="width:50%;" class="form-control input-md" value="{{ old('lon1', $business->lon) }}" />
												<br />
												<div id="map_canvas" style="width: 500px; height: 250px;"></div>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8">
												<a href="{{lurl('account/bizinfo/'.$business->id)}}"><button id="backBizBtn" class="btn btn-lg"> {{ t('Back') }} </button></a>
												<button id="updateBizBtn" class="btn btn-success btn-lg"> {{ t('Update') }} </button>
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

<style>
	.biz-hours{
		overflow:hidden;
	}
	.biz-hours-box{
		overflow:hidden;
		margin-bottom:5px;
	}
	.biz-hours-select{
		float:left;
		list-style:none;
		padding-left:0;
	}
	.biz-hours-select li{
		float:left;
		margin-right:3px;
	}
	.biz-hours-select select{
		padding:7px 4px;
	}
</style>

@section('javascript')
	@parent
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></script>
	<script src="{{ url('/assets/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/js/fileinput_locale_'.$lang->get('abbr').'.js'))
		<script src="{{ url('/assets/js/fileinput_locale_'.$lang->get('abbr').'.js') }}" type="text/javascript"></script>
	@endif
	<script language="javascript">
		/* initialize with defaults (pictures) */
		$('.picimg').fileinput(
				{
					'showPreview': true,
					'allowedFileExtensions': ['jpg', 'gif', 'png'],
					'browseLabel': '{!! t("Browse") !!}',
					'showUpload': false,
					'showRemove': false,
					'maxFileSize': 1000
				});
		/* initialize with defaults (resume) */
		$('#resume').fileinput(
				{
					'showPreview': true,
					'allowedFileExtensions': ['pdf', 'doc', 'docx', 'odt', 'png', 'jpg'],
					'browseLabel': '{!! t("Browse") !!}',
					'showUpload': false,
					'showRemove': false,
					'maxFileSize': 1000
				});
	</script>
	<script language="javascript">
		var countries = <?php echo (isset($countries)) ? $countries->toJson() : '{}'; ?>;
		var countryCode = '<?php echo old('country', $business->country_code); ?>';
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
		var loc = '<?php echo old('location', $business->subadmin1_code); ?>';
		var subLocation = '<?php echo old('sub_location', 0); ?>';
		var city = '<?php echo old('city', $business->city_id); ?>';
		var hasChildren = '<?php echo old('has_children'); ?>';

		$(document).ready(function () {
			get_keywords();
			setBizHrs();
			initialize('{{$business->lat}}', '{{$business->lon}}');
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
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
	
	<script language="javascript">
	function get_keywords(){
		var cat =  $('#category_id').val();
		var vals =  '{{$business->keywords}}';
		$.ajax({
			url: "{{ route('keywords') }}",
			type: 'post',
			data: {'cat':cat, 'vals':vals},
			dataType:'json',
			success: function(data)
			{
				$('#key_div').html(data.res);
				$(".chosen").trigger("chosen:updated");
				console.log("success");
				console.log(data);
				return false;
				
			},
			error : function(xhr, status,data){
			console.log("error");
			console.log(data);
			return false;
			}
		});     
	}
	
	$('#category_id').change(function() {
		get_keywords()
    });
	
	/* BOF Biz Hours */
	$('#biz-hr-btn').click(function() {
		var bhday_val = $('#bh-day').val();
		var bhday_txt = $('#bh-day').find(":selected").text();
		var bhstart_val = $('#bh-start').val();
		var bhstart_txt = $('#bh-start').find(":selected").text();
		var bhend_val = $('#bh-end').val();
		var bhend_txt = $('#bh-end').find(":selected").text();
		$('.biz-hours-box').append('<div><span><b>'+bhday_txt+' </b></span><span>'+bhstart_txt+' </span><span>- </span><span>'+bhend_txt+' </span><a href="#" class="rem-bh">{{t("Remove")}}</a><input name="biz_hours[]" value="'+bhday_val+' '+bhstart_val+' '+bhend_val+'" type="hidden"></div>');
		
		$('#bh-day').children("option").filter(function() {
			if(bhday_val==6){
				bhday_val=-1;
			}
			return  parseFloat(this.value) == parseFloat(bhday_val)+1;
		}).prop("selected", true);
		
	});
	
	$(".biz-hours-box").delegate("a", "click", function(){
		$(this).parent('div').remove();
		return false;
	});
	
	$('#bh-start').change(function() {
		setBizHrs();
	});
	
	function setBizHrs(){
		var fltrVal =  parseFloat($('#bh-start').val());
		$('#bh-end').children("option").filter(function() {
			return  (parseFloat(this.value) <= fltrVal) &&  (parseFloat(this.value) != 0);
		}).prop("disabled", true);
		
		$('#bh-end').children("option").filter(function() {
			return  parseFloat(this.value) > fltrVal;
		}).prop("disabled", false);
		
		$('#bh-end').children("option").filter(function() {
			return  parseFloat(this.value) == 0;
		}).prop("selected", true);
	}
	/* EOF Biz Hours */
	</script>
@endsection
