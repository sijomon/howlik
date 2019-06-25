@extends('classified.layouts.layout')

@section('javascript-top')
	@parent
@endsection
{{--*/ $biztitle 	= ''; /*--}}
{{--*/ $location 	= 0; /*--}}
{{--*/ $city 		= 0; /*--}}
@if(isset($_GET['business_title']) && isset($_GET['business_location']))
	{{--*/ $biztitle = $_GET['business_title']; /*--}}
	{{--*/ $bizlocat = $_GET['business_location']; /*--}}
	@if($bizlocat != '')
		{{--*/ 
			$bizlocation = \DB::table('cities')->select('cities.id','cities.country_code','cities.subadmin1_code')->where('cities.asciiname', $bizlocat)->first();
		/*--}}	
		@if(count($bizlocation))
		{{--*/ 
			   $location	 =	$bizlocation->country_code.'.'.$bizlocation->subadmin1_code;
			   $city	 	 =	$bizlocation->id;
		/*--}}
		@endif
	@endif
@endif
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

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Post a Business Listing') }}</strong></h2>
						<div class="row">
							<div class="col-sm-12">


								<form class="form-horizontal" id="createAd-1" method="POST" action="{{ lurl('add-business-post') }}"
									  enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>

										<!-- Category -->
										<div class="form-group required <?php echo ($errors->has('parent')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<select name="category_id" id="category_id" class="form-control selecter">
													<option value="0" data-type=""
															@if(old('parent')=='' or old('parent')==0)selected="selected"@endif> {{ t('Select a category') }} </option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if(old('category_id')==$cat->tid)selected="selected"@endif> {{ $cat->name }} </option>
													@endforeach
												</select>
											</div>
										</div>

										<!-- Keywords -->
										<div class="form-group">
											<label class="col-md-3 control-label">{{ t('Keywords') }} </label>
											<div class="col-md-8 _INP_R">
												<p id="key_div"></p>
											</div>
										</div>
										
										<!-- Business title -->
										<div class="form-group required <?php echo ($errors->has('title')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Title') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<input id="title" name="title" placeholder="{{ t('Business name') }}" class="form-control input-md"type="text" value="{{ $biztitle }}">
												<span class="help-block">{{ t('A great title needs at least 60 characters.') }} </span>
											</div>
										</div>
										
										<!-- Describe business -->
										<div class="form-group required <?php echo ($errors->has('description')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="description">{{ t('Describe business') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<textarea class="form-control" id="description" name="description"
														  rows="10">{{ old('description') }}</textarea>
												<p class="help-block">{{ t('Describe what makes your business unique') }}</p>
											</div>
										</div>
										
										<!-- Additional Informations -->
										<div class="form-group">
											@if(isset($bizMoreInfo))
												<label class="col-md-3 control-label" for="title">{{ t('Informations') }}</label>
												<div class="col-md-8 _INP_R">
													<div class="row">
													{{--*/ $i = '1'; /*--}}
													@foreach($bizMoreInfo as $info)
														<div class="col-md-6" style="padding:0;">
															<table class="table table-reponsive no-margin-table" style="margin:0;">
																<tr>
																	<td style="width: 65%;"> 
																		{{ ucfirst($info->info_title) }}
																	</td>
																	<td style="width: 35%;"> 
																	
																		{{--*/ $infos = unserialize($info->info_vals); /*--}}
																		{{--*/ $cinfo = count($infos) /*--}}
																	
																		@if($info->info_type == 1)	
																				
																			{{ Form::text('biz_info['.$info->translation_of.']', null, array('class' => 'form-control','id' => 'text_box_'.$i,'placeholder' => $info->info_title )) }}
																			
																		@elseif($info->info_type == 2)
																			
																			@if($cinfo>1)
																				<select name="biz_info[{{$info->translation_of}}]" class="form-control" id="select_box_{{ $i }}" >

																					<option selected="selected" disabled="disabled"> - - select - - </option>
																					@for($j = 0; $j < $cinfo; $j++)
																						<option value="{{ $infos[$j] }}"> {{ $infos[$j] }} </option>
																					@endfor
																				</select>
																			@endif
																			
																		@elseif($info->info_type == 3)
																		
																			{{--*/ $yesV	= false; /*--}}
																			{{--*/ $noV		= true; /*--}}
																			<label>
																				{{ Form::radio('biz_info['.$info->translation_of.']', 0, $yesV, ['id' => 'radio_'.$i]) }}&nbsp;Yes&nbsp;
																				{{ Form::radio('biz_info['.$info->translation_of.']', 1, $noV, ['id' => 'radio_'.$i]) }}&nbsp;No&nbsp;
																			</label>
																			
																		@endif
																		
																	</td>
																</tr>
															</table>
														</div>
													{{--*/ $i++; /*--}}	
													@endforeach
													</div>
												</div>
											@endif
										</div>
										
										<!-- Pictures -->
										
										<input id="seller_name" name="seller_name" type="hidden" value="{{ $user->name }}">
										<input id="seller_email" name="seller_email" type="hidden" value="{{ $user->email }}">
										
										<!-- Business hours -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Business hours') }}</label>
											<div class="col-md-8 _INP_R">
												<div class="input-group">
													<div class="biz-hours" id="biz-hours">
														<div class="biz-hours-box"></div>
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
																		<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}@if($i==47){{ ' (midnight next day)'}}@endif</option>
																		{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
																	@endfor
																</select>
															</li>
															<li>
																<button type="button" id="biz-hr-btn" class="btn" style="padding:7px 9px;"><span>Add Hours</span></button>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										
										<!-- Phone Number -->
										<div class="form-group required <?php echo ($errors->has('phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<div class="input-group"><span id="phone_country" class="input-group-addon"><i
																class="icon-phone-1"></i></span>
													<input id="phone" name="phone"
														   placeholder="{{ t('Phone Number (in local format)') }}"
														   class="form-control input-md" type="text"
														   value="{{ old('phone', ((Auth::check() and isset($user->phone)) ? $user->phone : '')) }}">
												</div>
											</div>
										</div>
										
										<!-- Website -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Website') }}</label>
											<div class="col-md-8 _INP_R">
												<input id="web" name="web" placeholder="{{ t('www.your-site.com') }}" class="form-control input-md"
													   type="text" value="{{ old('web') }}">
											</div>
										</div>
										
										<!-- Address 1 -->
										<div class="form-group required <?php echo ($errors->has('address1')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address 1') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<input id="address1" name="address1" class="form-control input-md" type="text" value="{{ old('address1') }}">
											</div>
										</div>
										
										<!-- Address 2 -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Address 2') }}</label>
											<div class="col-md-8 _INP_R">
												<input id="address2" name="address2" class="form-control input-md" type="text" value="{{ old('address2') }}">
											</div>
										</div>
										
										<!-- Country -->
										@if(!$ip_country)
											<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-8 _INP_R">
													<select id="country" name="country" class="form-control sselecter">
														<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}> {{ t('Select your Country') }} </option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country', ($country) ? $country->get('code') : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="country" name="country" type="hidden" value="{{ $country->get('code') }}">
										@endif

										
										<!-- Location -->
										<div id="locationBox"
											 class="form-group required <?php echo ($errors->has('location')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="location">{{ t('Location') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<select id="location" name="location" class="form-control sselecter">
													<option value="0" {{ (!old('location') or old('location')==0) ? 'selected="selected"' : '' }}> {{ t('Select your Location') }} </option>
												</select>
											</div>
										</div>

										<!-- City -->
										<div id="city_box"
											 class="form-group required <?php echo ($errors->has('city')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="city">{{ t('City') }} <sup>*</sup></label>
											<div class="col-md-8 _INP_R">
												<select id="city" name="city" class="form-control sselecter">
													<option value="0" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}> {{ t('Please select your location before') }} </option>
												</select>
											</div>
										</div>
										
										<!-- Zipcode -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Zip code') }}</label>
											<div class="col-md-8 _INP_R">
												<input id="zip" name="zip" class="form-control input-md" type="text" value="{{ old('zip') }}">
											</div>
										</div>
										
										<!-- Map -->
										<div class="form-group">
											<label class="col-md-3 control-label" for="title">{{ t('Pin Location') }}</label>
											<div class="col-md-8 _INP_R">
												<div style="display: none;">
													<label class="control-label" for="lat1"> {{ t('Lat') }}</label>
													<input type="text" id="lat1" name="lat1" style="width:50%;" class="form-control input-md" value="" />
													<label class="control-label" for="lon1"> {{ t('Long') }}</label>
													<input type="text" id="lon1" name="lon1" style="width:50%;" class="form-control input-md" value="" />
													<br />
												</div>
												<a href="#" onClick="return auto_locate();" style="float:right;">{{ t('Auto Locate')}}</a>
												<div id="map_canvas" style="width: 100%; height: 250px;"></div>
											</div>
										</div>
										
										<!-- Captcha -->
										@if (config('settings.activation_recaptcha'))
											<div class="form-group required <?php echo ($errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="g-recaptcha-response"></label>
												<div class="col-md-8 _INP_R">
													{!! Recaptcha::render(['lang' => $lang->get('abbr')]) !!}
												</div>
											</div>
										@endif

										<!-- Terms -->
										<div class="form-group required <?php echo ($errors->has('term')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8 _INP_R">
												<label class="checkbox-inline" for="term-0" style="margin-left: -20px;">
													<?php
													/*
													 <input name="term" id="term" value="1" type="checkbox" {{ (old('term', (isset($frm['term']) ? $frm['term'] : ''))=='1') ? 'checked="checked"' : '' }}>
													 */
													?>
													{!! t('By continuing on this website, you accept our <a target="_blank" href=":url">Terms of Use</a>', ['url' => lurl(trans('routes.terms'))]) !!}
												</label>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8 _INP_R">
												<button id="createAdBtn" class="btn btn-success btn-lg"> {{ t('Submit') }} </button>
											</div>
										</div>

									</fieldset>
								</form>


							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					<div class="reg-sidebar-inner text-center">
						<div class="promo-text-box"><i class=" icon-picture fa fa-4x icon-color-1"></i>
							<h3><strong>{{ t('Post a Free Ads') }}</strong></h3>
							<p>
								{{ t('Do you have something to sell, to rent, any service to offer or a job offer? Post it at :app_name, its free, local, easy, reliable and super fast!', ['app_name' => getDomain()]) }}
							</p>
						</div>

						<div class="panel sidebar-panel">
							<div class="panel-heading uppercase">
								<small><strong>{{ t('How to sell quickly?') }}</strong></small>
							</div>
							<div class="panel-content">
								<div class="panel-body text-left">
									<ul class="list-check">
										<li> {{ t('Use a brief title and description of the item') }} </li>
										<li> {{ t('Make sure you post in the correct category') }}</li>
										<li> {{ t('Add nice photos to your ad') }}</li>
										<li> {{ t('Put a reasonable price') }}</li>
										<li> {{ t('Check the item before publish') }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
@endsection

@section('javascript')
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
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
		var countryCode = '<?php echo old('country', ($country) ? $country->get('code') : 0); ?>';
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
		var loc = '<?php echo old('location', $location); ?>';
		var subLocation = '<?php echo old('sub_location', 0); ?>';
		var city = '<?php echo old('city', $city); ?>';
		var hasChildren = '<?php echo old('has_children'); ?>';

		$(document).ready(function () {

			/* Set Country Phone Code */
			setCountryPhoneCode(countryCode, countries);
			$('#country').change(function () {
				setCountryPhoneCode($(this).val(), countries);
			});

			/* Show price & Payment Methods */
			showAmount($('input[name=pack]:checked').val());
			$('.pack-selection').click(function () {
				showAmount($(this).val());
			});
			
			get_keywords();
			setBizHrs();
			initialize('{{$vlat}}', '{{$vlon}}');
			//codeAddress();
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
	
	
	<script language="javascript">
	function get_keywords(){
		var cat =  $('#category_id').val();
		var vals =  $('#category_id_val').val();
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
		$('.biz-hours-box').append('<div><span><b>'+bhday_txt+' </b></span><span>'+bhstart_txt+' </span><span>- </span><span>'+bhend_txt+' </span><a href="#" class="rem-bh">Remove</a><input name="biz_hours[]" value="'+bhday_val+' '+bhstart_val+' '+bhend_val+'" type="hidden"></div>');
		
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
