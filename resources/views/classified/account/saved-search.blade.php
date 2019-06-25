{{--
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('classified.layouts.layout')

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-sm-3 page-sidebar">
					@include('classified/account/inc/sidebar-left')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-star-circled"></i> @lang('global.Saved search') </h2>
						<div class="row">

							<div class="col-sm-4">
								<ul class="list-group list-group-unstyle">
									@if (isset($saved_search) and count($saved_search) > 0)
										@foreach ($saved_search as $search)
											<li class="list-group-item {{ (Request::get('q')==$search->keyword) ? 'active' : '' }}">
												<a href="{{ lurl('account/saved-search/?'.$search->query) }}" class="">
													<span> {{ str_limit(strtoupper($search->keyword), 20) }} </span>
													<span class="label label-warning" id="{{ $search->id }}">{{ $search->count }}+</span>
												</a>
												<span class="delete-search-result"><a
															href="{{ lurl('account/saved-search/delete/'.$search->id) }}">&times;</a></span>
											</li>
										@endforeach
									@else
										<div class="item-list">
											@lang('global.You have no save search.')
										</div>
									@endif
								</ul>
							</div>

							<div class="col-sm-8">
								<div class="adds-wrapper">

									@if (isset($ads) and $ads->getCollection()->count() > 0)
										<?php
										foreach($ads->getCollection() as $key => $ad):
										if (!$countries->has($ad->country_code)) continue;

										// Ad URL setting
										$adUrl = lurl(slugify($ad->title) . '/' . $ad->id . '.html');

										// Picture setting
										$adImg = '';
										$pictures = \App\Larapen\Models\Picture::where('ad_id', $ad->id)->where('active', 1);
										$countPictures = $pictures->count();
										if ($countPictures > 0) {
											if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename)) {
												$adImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
											}
											if ($adImg=='') {
												if (is_file(public_path() . '/'. $pictures->first()->filename)) {
													$adImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
												}
											}
										}
										// Default picture
										if ($adImg=='') {
											$adImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture'));
										}
										?>
										<div class="item-list">
											<div class="col-sm-2 no-padding photobox">
												<div class="add-image">
													<span class="photo-count"><i class="fa fa-camera"></i> {{ $countPictures }} </span>
													<a href="{{ $adUrl }}">
														<img class="thumbnail no-margin" src="{{ $adImg }}" alt="img" data-no-retina/>
													</a>
												</div>
											</div>
											<!--/.photobox-->
											<div class="col-sm-8 add-desc-box">
												<div class="ads-details">
													<h5 class="add-title"><a href="{{ $adUrl }}"> {{ $ad->title }} </a></h5>
										<span class="info-row">
											<span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right"
												  title="{{ ($ad->ad_type_id==2) ? t('Business Ads') : t('Private Ads') }}">
												{{ ($ad->ad_type_id==2) ? t('B') : t('P') }}
											</span>
											<?php
											// Convert the created_at date to Carbon object
											$ad->created_at = \Carbon\Carbon::parse($ad->created_at)->timezone(session('time_zone'));
											$ad->created_at = time_ago($ad->created_at, session('time_zone'), session('language_code'));
											?>
											<span class="date"><i class=" icon-clock"> </i> {{ $ad->created_at }} </span>
											- <span class="category">{{ $cats->get(\App\Larapen\Models\Category::find($ad->category_id)->parent_id)->name }} </span>
											- <span class="item-location"><i
														class="fa fa-map-marker"></i> {{ \App\Larapen\Models\City::find($ad->city_id)->name }} </span>
										</span>
												</div>
											</div>

											<div class="col-sm-2 text-right text-center-xs price-box">
												<h4 class="item-price">
													@if($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
													{{ \App\Larapen\Helpers\Number::short($ad->price) }}
													@if($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
												</h4>
											</div>
										</div>
										<?php endforeach; ?>
									@else
										<div class="item-list">
											@if (isset($saved_search) and count($saved_search) > 0)
												@lang('global.Please select a saved search to show the result')
											@else
												@lang('global.No result. Refine your search using other criteria.')
											@endif
										</div>
									@endif
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

	<!-- include checkRadio plugin //Custom check & Radio  -->
	<script type="text/javascript" src="{{ url('assets/plugins/icheck/icheck.min.js') }}"></script>

	<!-- include footable   -->
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});

			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});

		});
	</script>
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>

		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}

	</script>
@endsection
