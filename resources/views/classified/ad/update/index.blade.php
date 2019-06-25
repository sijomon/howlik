@extends('classified.layouts.layout')
<?php
// Category
if ($ad->category) {
	$adCatParentId = $ad->category->parent_id;
} else {
	$adCatParentId = 0;
}
?>
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (count($errors) > 0)
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>@lang('global.Oops ! An error has occurred. Please correct the red fields in the form')</strong></h5>
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
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Update My Ad') }}</strong></h2>
						<div class="row">
							<div class="col-sm-12">
								<form class="form-horizontal" id="createAd" method="POST" action="{{ lurl('post/' . $ad->id) }}"
									  enctype="multipart/form-data">
									{!! csrf_field() !!}
									<input type="hidden" name="ad_id" value="{{ $ad->id }}">
									<fieldset>
										<!-- Category -->
										<div class="form-group required <?php echo ($errors->has('parent')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select name="parent" id="parent" class="form-control selecter">
													<option value="0" data-type=""
															@if(old('parent', $adCatParentId)=='' or old('parent', $adCatParentId)==0)selected="selected"@endif>
														{{ t('Select a category') }}
													</option>
													@foreach ($categories as $cat)
														<option value="{{ $cat->tid }}" data-type="{{ $cat->type }}"
																@if(old('parent', $adCatParentId)==$cat->tid)selected="selected"@endif>
															{{ $cat->name }}
														</option>
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
															@if(old('category', $ad->category_id)=='' or old('category', $ad->category_id)==0)selected="selected"@endif>
														{{ t('Select a sub-category') }}
													</option>
												</select>
											</div>
										</div>

										<!-- Add Type -->
										<div id="adTypeBloc" class="form-group required <?php echo ($errors->has('ad_type')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label">{{ t('Add Type') }} <sup>*</sup></label>
											<div class="col-md-8">
												@foreach ($ad_types as $type)
													<label class="radio-inline" for="ad_type{{ $type->id }}">
														<input name="ad_type" id="ad_type{{ $type->tid }}" value="{{ $type->tid }}"
															   type="radio" {{ (old('ad_type', $ad->ad_type_id)==$type->tid) ? 'checked="checked"' : '' }}>
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
													   type="text" value="{{ old('title', $ad->title) }}">
												<span class="help-block">{{ t('A great title needs at least 60 characters.') }} </span>
											</div>
										</div>

										<!-- Describe ad -->
										<div class="form-group required <?php echo ($errors->has('description')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="description">{{ t('Describe ad') }} <sup>*</sup></label>
											<div class="col-md-8">
												<textarea class="form-control" id="description" name="description" rows="10"
														  required="">{{ old('description', $ad->description) }}</textarea>
												<p class="help-block">{{ t('Describe what makes your ad unique') }}</p>
											</div>
										</div>

										<!-- Price -->
										<div id="priceBloc" class="form-group required <?php echo ($errors->has('price')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="price">{{ t('Price') }}</label>
											<div class="col-md-4">
												<div class="input-group">
													@if ($country->get('currency')->in_left == 1) <span
															class="input-group-addon">{{ $country->get('currency')->symbol }}</span> @endif
													<input id="price" name="price" class="form-control" placeholder="{{ t('e.i. 15000') }}"
														   type="text" value="{{ old('price', $ad->price) }}">
													@if ($country->get('currency')->in_left == 0) <span
															class="input-group-addon">{{ $country->get('currency')->symbol }}</span> @endif
												</div>
											</div>
											<div class="col-md-4">
												<div class="checkbox">
													<label>
														<input id="negotiable" name="negotiable" type="checkbox"
															   value="1" {{ (old('negotiable', $ad->negotiable)=='1') ? 'checked="checked"' : '' }}>
														{{ t('Negotiable') }}
													</label>
												</div>
											</div>
										</div>


										@if(isset($ads_pictures_number) and is_numeric($ads_pictures_number) and $ads_pictures_number > 0)
										@if (isset($ad->pictures) and $ad->pictures->count() > 0)
										<!-- Pictures -->
										<div id="picturesBloc" class="form-group required <?php echo ($errors->has('pictures')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="pictures"> {{ t('Pictures') }} <sup>*</sup></label>
											<div class="col-md-8">
												@for($i = 0; $i <= $ads_pictures_number-1; $i++)
												<div class="mb10">
													<input id="img{{ $i }}"
														   name="pictures[<?php if (isset($ad->pictures->get($i)->id)): echo $ad->pictures->get($i)->id; endif ?>]"
														   type="file" class="file picimg">
													<input id="pic_del_img{{ $i }}" type="hidden" name="pic_del[<?php if (isset($ad->pictures->get($i)->id)): echo $ad->pictures->get($i)->id; endif ?>]" value="<?php if (isset($ad->pictures->get($i)->id)): echo $ad->pictures->get($i)->id; endif ?>" />
												</div>
												@endfor
												<p class="help-block">{{ t('Add up to :pictures_number photos. Use a real image of your product, not catalogs.', ['pictures_number' => $ads_pictures_number]) }}</p>
											</div>
										</div>
										@else
											<div id="picturesBloc" class="form-group required <?php echo ($errors->has('pictures')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="pictures"> {{ t('Pictures') }} <sup>*</sup></label>
												<div class="col-md-8">
													@for($i = 0; $i <= $ads_pictures_number-1; $i++)
													<div class="mb10">
														<input id="img{{ $i }}" name="pictures[]" type="file" class="file picimg">
														<input id="pic_del_img{{ $i }}" type="hidden" name="pic_del[]" value="0" />
													</div>
													@endfor
													<p class="help-block">{{ t('Add up to :pictures_number photos. Use a real image of your product, not catalogs.', ['pictures_number' => $ads_pictures_number]) }}</p>
												</div>
											</div>
										@endif
										@endif

										<!-- Resume -->
										<div id="resumeBloc" class="form-group <?php echo ($errors->has('resume')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="pictures"> {{ t('Your resume') }} </label>
											<div class="col-md-8">
												<div class="mb10">
													<input id="resume" name="resume" type="file" class="file">
												</div>
												<p class="help-block">{{ t('Resume format') }}</p>
												@if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume))
													<div>
														<a class="btn btn-default" href="{{ url('uploads/resumes/' . $ad->resume) }}"
														   target="_blank">
															<i class="icon-attach-2"></i> {{ t('Donwload current Resume') }}
														</a>
													</div>
												@endif
											</div>
										</div>


										<div class="content-subheading"><i class="icon-user fa"></i>
											<strong>{{ t('Seller information') }}</strong></div>

										<div class="form-group required <?php echo ($errors->has('seller_name')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_name">{{ t('Seller Name') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="seller_name" name="seller_name" placeholder="{{ t('Seller Name') }}"
													   class="form-control input-md" type="text"
													   value="{{ old('seller_name', $ad->seller_name) }}">
											</div>
										</div>

										<!-- Seller Email -->
										<div class="form-group required <?php echo ($errors->has('seller_email')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_email"> {{ t('Seller Email') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div class="input-group">
													<span class="input-group-addon"><i class="icon-mail"></i></span>
													<input id="seller_email" name="seller_email" class="form-control"
														   placeholder="{{ t('Email') }}" type="text"
														   value="{{ old('seller_email', $ad->seller_email) }}">
												</div>
											</div>
										</div>

										<!-- Phone Number -->
										<div class="form-group required <?php echo ($errors->has('seller_phone')) ? 'has-error' : ''; ?>">
											<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }}</label>
											<div class="col-md-8">
												<div class="input-group"><span id="phone_country" class="input-group-addon"><i
																class="icon-phone-1"></i></span>
													<input id="seller_phone" name="seller_phone"
														   placeholder="{{ t('Phone Number (in local format)') }}" class="form-control input-md"
														   type="text" value="{{ old('seller_phone', $ad->seller_phone) }}">
												</div>
												<div class="checkbox">
													<label>
														<input id="seller_phone_hidden" name="seller_phone_hidden" type="checkbox"
															   value="1" {{ (old('negotiable', $ad->seller_phone_hidden)=='1') ? 'checked="checked"' : '' }}>
														<small> {{ t('Hide the phone number on this ads.') }}</small>
													</label>
												</div>
											</div>
										</div>


										<!-- Button  -->
										<div class="form-group">
											<label class="col-md-3 control-label"></label>
											<div class="col-md-8">
												<button id="createAdBtn" class="btn btn-success btn-lg"> {{ t('Update') }} </button>
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
	<script src="{{ url('assets/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script language="javascript">
		/* initialize with defaults (pictures) */
		@if(isset($ads_pictures_number) and is_numeric($ads_pictures_number) and $ads_pictures_number > 0)
		@for($i = 0; $i <= $ads_pictures_number-1; $i++)
		$('#img<?php echo $i; ?>').fileinput(
				{
					'showPreview': true,
					'allowedFileExtensions': ['jpg', 'jpeg', 'gif', 'png'],
					'browseLabel': '{!! t("Browse") !!}',
					'showUpload': false,
					'showRemove': false,
					'maxFileSize': 1000,
					@if (isset($ad->pictures) and isset($ad->pictures->get($i)->filename))
					/* setup initial preview with data keys */
					initialPreview: [
						'<img src="<?php echo url('pic/x/cache/small/' . $ad->pictures->get($i)->filename); ?>" class="file-preview-image" data-no-retina>',
					],
					/* initial preview configuration */
					initialPreviewConfig: [
						{
							caption: 'desert.jpg',
							width: '120px',
							url: '<?php echo url('ajax/pictures/delete/' . $ad->pictures->get($i)->id); ?>',
							key: <?php echo $ad->pictures->get($i)->id; ?>,
							extra: {id: <?php echo $ad->pictures->get($i)->id; ?>}
						}
					]
					@endif
				});
		@endfor
		@endif

		/* initialize with defaults (resume) */
		$('#resume').fileinput(
				{
					'showPreview': true,
					'allowedFileExtensions': ['pdf', 'doc', 'docx', 'odt', 'png', 'jpg', 'jpeg'],
					'browseLabel': '{!! t("Browse") !!}',
					'showUpload': false,
					'showRemove': false,
					'maxFileSize': 1000,
					@if (!is_null($ad->resume) and $ad->resume != '')
					initialPreview: [
						/* '<img src="<?php echo url('uploads/resumes/' . $ad->resume); ?>" class="file-preview-image" alt="Desert" title="Desert">', */
					],
					/* initial preview configuration */
					initialPreviewConfig: [
						{
							caption: 'desert.jpg',
							width: '120px',
							url: '<?php echo url('ajax/resumes/delete/' . $ad->resume); ?>',
							key: <?php echo $ad->id; ?>,
							extra: {id: <?php echo $ad->id; ?>}
						}
					]
					@endif
				});
	</script>
	<script language="javascript">
		var lang = {
			'select': {
				'category': "{{ t('Select a category') }}",
				'subCategory': "{{ t('Select a sub-category') }}",
			}
		};
		var stepParam = 0;
		var category = <?php echo old('parent', intval($adCatParentId)); ?>;
		var categoryType = '<?php echo old('parent_type'); ?>';
		if (categoryType=='') {
			var selectedCat = $('select[name=parent]').find('option:selected');
			categoryType = selectedCat.data('type');
		}
		var subCategory = <?php echo old('category', intval($ad->category_id)); ?>;
		{{-- START / Fake fields to skip JS errors --}}
		var countryCode = '<?php echo old('country', $ad->country_code); ?>';
		var loc = '<?php echo old('location', 0); ?>';
		var subLocation = '<?php echo old('sub_location', 0); ?>';
		var city = '<?php echo old('city', 0); ?>';
		var hasChildren = '<?php echo old('has_children'); ?>';
		{{-- END / Fake fields to skip JS errors --}}
	</script>

	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
