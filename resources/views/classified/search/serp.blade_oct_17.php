@extends('classified.layouts.layout')

@section('css')
@endsection

@section('search')
	@parent
	@include('classified/search/inc/form')
	@include('classified/search/inc/breadcrumbs', [
		'city' 		=> (isset($city) and !is_null($city)) ? $city : null,
		'cat' 		=> (isset($cat) and !is_null($cat)) ? $cat : null,
		'sub_cat' 	=> (isset($sub_cat) and !is_null($sub_cat)) ? $sub_cat : null
	])
	@include('classified/search/inc/categories', [
		'lang' => (isset($lang) and !is_null($lang)) ? $lang : null,
		'country' => (isset($country) and !is_null($country)) ? $country : null,
		'cat' => (isset($cat) and !is_null($cat)) ? $cat : null,
		'cats' => (isset($cats) and !is_null($cats)) ? $cats : null,
		'sub_cats' => (isset($sub_cats) and !is_null($sub_cats)) ? $sub_cats : null,
		'count_cat_ads' => (isset($count_cat_ads) and !is_null($count_cat_ads)) ? $count_cat_ads : null,
		'count_sub_cat_ads' => (isset($count_sub_cat_ads) and !is_null($count_sub_cat_ads)) ? $count_sub_cat_ads : null,
	])
	@include('classified/layouts/inc/advertising/top')
@endsection

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				<!-- Sidebar -->
				@if (config('settings.activation_serp_left_sidebar'))
				@include('classified/search/inc/sidebar-left')
				<?php $contentColSm = 'col-sm-9'; ?>
				@else
				<?php $contentColSm = 'col-sm-12'; ?>
				@endif

				<!-- Content -->
				<div class="{{ $contentColSm }} page-content col-thin-left">
					<div class="category-list">
						<div class="tab-box ">

							<!-- Nav tabs -->
							<?php
							$classAllActive = $classProActive = $classPersoActive = '';
							$classAllBadge = $classProBadge = $classPersoBadge = 'alert-danger';
							$realAdsWasFound = 0;
							if (is_null(Request::get('type')) or Request::get('type') == '') {
								$classAllActive = 'class="active"';
								$classAllBadge = 'progress-bar-danger';
								$realAdsWasFound = $count->get('all');
							} elseif (Request::get('type') == 2) {
								$classProActive = 'class="active"';
								$classProBadge = 'progress-bar-danger';
								$realAdsWasFound = $count->get('b');
							} elseif (Request::get('type') == 1) {
								$classPersoActive = 'class="active"';
								$classPersoBadge = 'progress-bar-danger';
								$realAdsWasFound = $count->get('p');
							}
							?>
							<ul id="ad_type" class="nav nav-tabs add-tabs" role="tablist">
								<li {!! $classAllActive !!}>
									<a href="{!! qsurl(Request::url(), Request::except(['page', 'type'])) !!}" role="tab" data-toggle="tab">
										{{ t('All Ads') }} <span class="badge {!! $classAllBadge !!}">{{ $count->get('all') }}</span>
									</a>
								</li>
								<li {!! $classProActive !!}>
									<a href="{!! qsurl(Request::url(), array_merge(Request::except('page'), ['type'=>2])) !!}" role="tab"
									   data-toggle="tab">
										{{ t('Professionals') }} <span class="badge {!! $classProBadge !!}">{{ $count->get('b') }}</span>
									</a>
								</li>
								<li {!! $classPersoActive !!}>
									<a href="{!! qsurl(Request::url(), array_merge(Request::except('page'), ['type'=>1])) !!}" role="tab"
									   data-toggle="tab">
										{{ t('Personals') }} <span class="badge {!! $classPersoBadge !!}">{{ $count->get('p') }}</span>
									</a>
								</li>
							</ul>
							<div class="tab-filter" style="padding-top: 6px; padding-right: 6px;">
								<select id="order_by" class="selecter" data-style="btn-select" data-width="auto">
									<option value="{!! qsurl(Request::url(), Request::except(['orderBy', 'distance'])) !!}">{{ t('Sort by') }}</option>
									<option{{ (Request::get('orderBy')=='priceAsc') ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('orderBy'), ['orderBy'=>'priceAsc'])) !!}">{{ t('Price : Low to High') }}</option>
									<option{{ (Request::get('orderBy')=='priceDesc') ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('orderBy'), ['orderBy'=>'priceDesc'])) !!}">{{ t('Price : High to Low') }}</option>
									<option{{ (Request::get('orderBy')=='relevance') ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('orderBy'), ['orderBy'=>'relevance'])) !!}">{{ t('Relevance') }}</option>
									<option{{ (Request::get('orderBy')=='date') ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('orderBy'), ['orderBy'=>'date'])) !!}">{{ t('Date') }}</option>
									@if (Request::has('l') or Request::segment(3) == trans('routes.t-search-location') or Request::has('r'))
										<option{{ (Request::get('distance')==100) ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('distance'), ['distance'=>100])) !!}">{{ t('Around') . ' 100 km' }}</option>
										<option{{ (Request::get('distance')==300) ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('distance'), ['distance'=>300])) !!}">{{ t('Around') . ' 300 km' }}</option>
										<option{{ (Request::get('distance')==500) ? ' selected="selected"' : '' }} value="{!! qsurl(Request::url(), array_merge(Request::except('distance'), ['distance'=>500])) !!}">{{ t('Around') . ' 500 km' }}</option>
									@endif
								</select>
							</div>

						</div>

						<div class="listing-filter">
							<div class="pull-left col-xs-6">
								<div class="breadcrumb-list">
									<a href="{{ url($country->get('icode').'/'.trans('routes.t-search')) }}" class="current"> <span>{{ t('All ads') }}</span></a>
									@if (Request::has('l') or Request::segment(3) == trans('routes.t-search-location') or Request::has('r'))
										{!! t('in :distance km around :city', ['distance' => \App\Larapen\Helpers\Search::$distance, 'city' => $city->name]) !!}
									@endif
									@if (Request::has('c') or Request::segment(3) == slugify($country->get('name')))
										@if (isset($cat))
											{!! t('in :category', ['category' => $cat->name]) !!}
										@endif
									@endif

								</div>
							</div>

							@if ($ads->getCollection()->count() > 0)
								<div class="pull-right col-xs-6 text-right listing-view-action">
									<span class="list-view"><i class="icon-th"></i></span>
									<span class="compact-view"><i class="icon-th-list"></i></span>
									<span class="grid-view active"><i class="icon-th-large"></i></span>
								</div>
							@endif

							<div style="clear:both"></div>
						</div>

						<div class="adds-wrapper">
							@include('classified/search/inc/ads')
						</div>

						<div class="tab-box save-search-bar text-center">
							@if(Request::has('q') and Request::get('q') != '' and $count->get('all') > 0)
								<a name="{!! qsurl(Request::url(), Request::except(['_token', 'location'])) !!}" id="save_search"
								   count="{{ $count->get('all') }}">
									<i class="icon-star-empty"></i> {{ t('Save Search') }}
								</a>
							@else
								<a href="#"> &nbsp; </a>
							@endif
						</div>
					</div>

					<div class="pagination-bar text-center">
						{!! $ads->appends(Request::except('page'))->render() !!}
					</div>

					<div class="post-promo text-center" style="margin-bottom: 30px;">
						<h2> {{ t('Do you get anything for sell ?') }} </h2>
						<h5>{{ t('Sell your products and services online FOR FREE. It\'s easier than you think !') }}</h5>
						<a href="{{ lurl(trans('routes.create-ad')) }}" class="btn btn-lg btn-border btn-post btn-danger">{{ t('Start Now!') }}</a>
					</div>

				</div>

				<!-- Advertising -->
				@include('classified/layouts/inc/advertising/bottom')

			</div>
		</div>
	</div>
@endsection

@section('modal-location')
	@include('classified/layouts/inc/modal/location')
@endsection


@section('javascript')
	@parent
	<script>
		/* Default view (See in /js/script.js) */
		@if ($realAdsWasFound > 0)
			gridView('.grid-view');
		@else
			listView('.list-view');
		@endif

		/* JS translation */
		var lang = {
			loginToSaveAd: "@lang('global.Please log in to save the Ads.')",
			loginToSaveSearch: "@lang('global.Please log in to save your search.')",
			confirmationSaveSearch: "@lang('global.Search saved successfully !')",
			confirmationRemoveSaveSearch: "@lang('global.Search deleted successfully !')"
		};

		var stateId = '<?php echo (isset($city)) ? $country->get('code').'.'.$city->subadmin1_code : '0' ?>';
		$(document).ready(function () {
			$('#ad_type a').click(function (e) {
				e.preventDefault();
				var goToUrl = $(this).attr('href');
				window.location.replace(goToUrl);
				window.location.href = goToUrl;
			});
			$('#order_by').change(function () {
				var goToUrl = $(this).val();
				window.location.replace(goToUrl);
				window.location.href = goToUrl;
			});
		});
	</script>
	<script type="text/javascript" src="{{ url('assets/js/app/load.cities.js') }}"></script>
	<script type="text/javascript" src="{{ url('assets/js/app/make.favorite.js') }}"></script>
@endsection
