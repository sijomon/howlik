@extends('classified.layouts.master')

@section('javascript-top')
	@parent
	<?php
	/*
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
	*/
	?>
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

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Post a Free Classified Ad') }}</strong></h2>
						<div class="row">
							<div class="col-sm-12">


								<form class="form-horizontal" id="createAd-1" method="POST" action="{{ lurl('create-ad-post') }}"
									  enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>

										<!-- Category -->
										<div class="form-group required <?php echo ($errors->has('parent')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="parent" id="parent" class="form-control selecter">
													<option value="0" data-type=""
															@if(old('parent')=='' or old('parent')==0)selected="selected"@endif> {{ t('Select a category') }} </option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if(old('parent')==$cat->tid)selected="selected"@endif> {{ $cat->name }} </option>
													@endforeach
												</select>
												<input type="hidden" name="parent_type" id="parent_type" value="{{ old('parent_type') }}">
											</div>
										</div>

										<!-- Sub-Category -->
										<div class="form-group required <?php echo ($errors->has('category')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Sub-Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="category" id="category" class="form-control selecter">
													<option value="0"
															@if(old('category')=='' or old('category')==0)selected="selected"@endif> {{ t('Select a sub-category') }} </option>
												</select>
											</div>
										</div>

										<!-- Ad Type -->
										<div id="adTypeBloc" class="form-group required <?php echo ($errors->has('ad_type')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Add Type') }} <sup>*</sup></label>
											<div class="col-md-8">
												@foreach ($ad_types as $type)
													<label class="radio-inline" for="ad_type{{ $type->tid }}">
														<input name="ad_type" id="ad_type{{ $type->tid }}" value="{{ $type->tid }}"
															   type="radio" {{ (old('ad_type')==$type->tid) ? 'checked="checked"' : '' }}>
														{{ $type->name }}
													</label>
												@endforeach
											</div>
										</div>

										<!-- Ad title -->
										<div class="form-group required <?php echo ($errors->has('title')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Title') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="{{ t('Ad title') }}" class="form-control input-md"
													   type="text" value="{{ old('title') }}">
												<span class="help-block">{{ t('A great title needs at least 60 characters.') }} </span>
											</div>
										</div>

										<!-- Describe ad -->
										<div class="form-group required <?php echo ($errors->has('description')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="description">{{ t('Describe ad') }} <sup>*</sup></label>
											<div class="col-md-8">
												<textarea class="form-control" id="description" name="description"
														  rows="10">{{ old('description') }}</textarea>
												<p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
											</div>
										</div>

										<!-- Price -->
										<div id="priceBloc" class="form-group <?php echo ($errors->has('price')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="price">{{ t('Price') }}</label>
											<div class="col-md-4">
												<div class="input-group">
													@if ($country->get('currency')->in_left == 1) <span
															class="input-group-addon">{{ $country->get('currency')->symbol }}</span> @endif
													<input id="price" name="price" class="form-control" placeholder="{{ t('e.i. 15000') }}"
														   type="text" value="{{ old('price') }}">
													@if ($country->get('currency')->in_left == 0) <span
															class="input-group-addon">{{ $country->get('currency')->symbol }}</span> @endif
												</div>
											</div>
											<div class="col-md-4">
												<div class="checkbox">
													<label>
														<input id="negotiable" name="negotiable" type="checkbox"
															   value="1" {{ (old('negotiable')=='1') ? 'checked="checked"' : '' }}>
														{{ t('Negotiable') }}
													</label>
												</div>
											</div>
										</div>


										<!-- Pictures -->
										@if(isset($ads_pictures_number) and is_numeric($ads_pictures_number) and $ads_pictures_number > 0)
										<div id="picturesBloc" class="form-group <?php echo ($errors->has('pictures')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="pictures"> {{ t('Pictures') }} </label>
											<div class="col-md-8">
												@for($i = 1; $i <= $ads_pictures_number; $i++)
												<div class="mb10 <?php echo ($errors->has('pictures.'.$i)) ? 'has-error' : ''; ?>">
													<input id="img{{ $i }}" name="pictures[]" type="file" class="file picimg">
												</div>
												@endfor
												<p class="help-block">{{ t('Add up to :pictures_number photos. Use a real image of your product, not catalogs.', ['pictures_number' => $ads_pictures_number]) }}</p>
											</div>
										</div>
										@endif

										<!-- Resume -->
										<div id="resumeBloc" class="form-group <?php echo ($errors->has('resume')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="pictures"> {{ t('Your resume') }} </label>
											<div class="col-md-8">
												<div class="mb10">
													<input id="resume" name="resume" type="file" class="file">
												</div>
												<p class="help-block">{{ t('Resume format') }}</p>
											</div>
										</div>


										@if(Auth::check())
											<input id="seller_name" name="seller_name" type="hidden" value="{{ $user->name }}">
											<input id="seller_email" name="seller_email" type="hidden" value="{{ $user->email }}">
											<!--<input id="seller_phone" name="seller_phone" type="hidden" value="{{-- $user->phone --}}">-->
										@else
											<div class="form-group required <?php echo ($errors->has('seller_name')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="seller_name">{{ t('Seller Name') }} <sup>*</sup></label>
												<div class="col-md-8">
													<input id="seller_name" name="seller_name" placeholder="{{ t('Seller Name') }}"
														   class="form-control input-md" type="text" value="{{ old('seller_name') }}">
												</div>
											</div>

											<!-- Seller Email -->
											<div class="form-group required <?php echo ($errors->has('seller_email')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="seller_email"> {{ t('Seller Email') }} <sup>*</sup></label>
												<div class="col-md-8">
													<div class="input-group">
														<span class="input-group-addon"><i class="icon-mail"></i></span>
														<input id="seller_email" name="seller_email" class="form-control"
															   placeholder="{{ t('Email') }}" type="text" value="{{ old('seller_email') }}">
													</div>
												</div>
											</div>
										@endif

										<!-- Country -->
										@if(!$ip_country)
											<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
												<div class="col-md-8">
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

										<!-- Phone Number -->
										<div class="form-group required <?php echo ($errors->has('seller_phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }}</label>
											<div class="col-md-8">
												<div class="input-group"><span id="phone_country" class="input-group-addon"><i
																class="icon-phone-1"></i></span>
													<input id="seller_phone" name="seller_phone"
														   placeholder="{{ t('Phone Number (in local format)') }}"
														   class="form-control input-md" type="text"
														   value="{{ old('seller_phone', ((Auth::check() and isset($user->phone)) ? $user->phone : '')) }}">
												</div>
												<div class="checkbox">
													<label>
														<input id="seller_phone_hidden" name="seller_phone_hidden" type="checkbox"
															   value="1" {{ (old('seller_phone_hidden')=='1') ? 'checked="checked"' : '' }}>
														<small> {{ t('Hide the phone number on this ads.') }}</small>
													</label>
												</div>
											</div>
										</div>

										<?php
										/*
										@if (\Illuminate\Support\Facades\Schema::hasColumn('ads', 'address'))
										<!-- Address -->
										<div class="form-group required <?php echo ($errors->has('address')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address') }} </label>
											<div class="col-md-8">
												<input id="address" name="address" placeholder="{{ t('Address') }}" class="form-control input-md"
													   type="text" value="{{ old('address') }}">
												<span class="help-block">{{ t('Fill an address to display on Google Maps.') }} </span>
											</div>
										</div>
										@endif
										*/
										?>

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

										<!-- Sub-Location -->
										<div id="sub_location_box"
											 class="form-group <?php echo ($errors->has('sub_location')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="sub_location">{{ t('Sub-location') }}</label>
											<div class="col-md-8">
												<select id="sub_location" name="sub_location" class="form-control sselecter">
													<option value="0" {{ (!old('sub_location') or old('sub_location')==0) ? 'selected="selected"' : '' }}> {{ t('Please select your location before') }} </option>
												</select>
											</div>
										</div>
										<input type="hidden" id="has_children" name="has_children" value="{{ old('has_children') }}">

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



										@if (isset($packs) and isset($payment_methods) and !$packs->isEmpty() and !$payment_methods->isEmpty())
											<div class="well" style="padding-bottom: 0;">
												<h3><i class="icon-certificate icon-color-1"></i> {{ t('Premium Ad') }} </h3>
												<p>
													{{ t('The premium pack help sellers promote their products or services by giving more visibility to their ads to attract more buyers and sell what they want faster.') }}
												</p>
												<div class="form-group <?php echo ($errors->has('pack')) ? 'has-error' : ''; ?>"
													 style="margin-bottom: 0;">
													<table id="packsTable" class="table table-hover checkboxtable" style="margin-bottom: 0;">
														@foreach ($packs as $pack)
															<tr>
																<td>
																	<div class="radio">
																		<label>
																			<input class="pack-selection" type="radio" name="pack"
																				   id="pack-{{ $pack->tid }}"
																				   value="{{ $pack->tid }}" {{ (old('pack')==$pack->tid) ? 'checked' : (($pack->price==0) ? 'checked' : '') }}>
																			<strong>{{ $pack->name }} </strong>
																		</label>
																	</div>
																</td>
																<td>
																	<p id="price-{{ $pack->tid }}">
																		@if ($pack->currency->in_left == 1) <span
																				class="priceCurr">{{ $pack->currency->symbol }}</span> @endif
																		<span class="priceInt">{{ $pack->price }}</span>
																		@if ($pack->currency->in_left == 0) <span
																				class="priceCurr">{{ $pack->currency->symbol }}</span> @endif
																	</p>
																</td>
															</tr>
														@endforeach

														<tr>
															<td>
																<div class="form-group <?php echo ($errors->has('payment_method')) ? 'has-error' : ''; ?>"
																	 style="margin-bottom: 0;">
																	<div class="col-md-8">
																		<select class="form-control selecter" name="payment_method"
																				id="payment_method">
																			{{--<option value="">{{ t('Payment Method') }}</option>--}}
																			@foreach ($payment_methods as $paymentMethod)
																				<option value="{{ $paymentMethod->id }}" {{ (old('payment_method')==$paymentMethod->id) ? 'selected="selected"' : '' }}>
																					{{ $paymentMethod->name }}
																				</option>
																			@endforeach
																		</select>
																	</div>
																</div>
															</td>
															<td>
																<p style="margin-top: 7px;">
																	<strong>{{ t('Payable Amount') }} :
																		@if ($packs->get(0)->currency->in_left == 1) <span
																				class="priceCurr">{{ $packs->get(0)->currency->symbol }}</span> @endif
																		<span id="payableAmount">0</span>
																		@if ($packs->get(0)->currency->in_left == 0) <span
																				class="priceCurr">{{ $packs->get(0)->currency->symbol }}</span> @endif
																	</strong>
																</p>
															</td>
														</tr>

													</table>
												</div>
											</div>
										@endif


										<!-- Captcha -->
										@if (config('settings.activation_recaptcha'))
											<div class="form-group required <?php echo ($errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="g-recaptcha-response"></label>
												<div class="col-md-8">
													{!! Recaptcha::render(['lang' => $lang->get('abbr')]) !!}
												</div>
											</div>
										@endif

										<!-- Terms -->
										<div class="form-group required <?php echo ($errors->has('term')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8">
												<label class="checkbox-inline" for="term-0" style="margin-left: -20px;">
													<?php
													/*
													 <input name="term" id="term" value="1" type="checkbox" {{ (old('term', (isset($frm['term']) ? $frm['term'] : ''))=='1') ? 'checked="checked"' : '' }}>
													 */
													?>
													{!! t('By continuing on this website, you accept our <a href=":url">Terms of Use</a>', ['url' => lurl(trans('routes.terms'))]) !!}
												</label>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8">
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
	@parent
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
		var loc = '<?php echo old('location', 0); ?>';
		var subLocation = '<?php echo old('sub_location', 0); ?>';
		var city = '<?php echo old('city', 0); ?>';
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

			<?php
			/*
			@if (\Illuminate\Support\Facades\Schema::hasColumn('ads', 'address'))
			// Google Suggest
			google.maps.event.addDomListener(window, 'load', initialize);
			@endif
			*/
			?>

		});

		function initialize() {
			var input = document.getElementById('address');
			var autocomplete = new google.maps.places.Autocomplete(input);
		}

	</script>
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
