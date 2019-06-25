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
@extends('classified.layouts.master')

@section('css')
@endsection

@section('search')
	@parent
	@include('classified/home/inc/search')
@endsection

@section('content')
	<div class="main-container" id="homepage">
		<div class="container">
			<div class="row" style="margin-bottom: 30px;">

				@if (session('message'))
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						{{ session('message') }}
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

				<div class="col-lg-12 page-content">
					<div class="inner-box">
						<?php
						if (config('settings.show_country_svgmap') and file_exists(public_path('images/maps/' . strtolower($country->get('code')) . '.svg'))):
							$class_col_sm = 'col-sm-5';
							$class_col_md = 'col-md-12';
						else:
							$class_col_sm = 'col-sm-8';
							$class_col_md = 'col-md-12';
						endif
						?>
						<div class="{{ $class_col_sm }} page-content no-margin no-padding"> 
							@if (isset($city_cols))
								<div class="relative" style="text-align: center;">
									<div class="row" style="padding-top: 30px; padding-bottom: 30px; text-align: left;">
										<div class="{{ $class_col_md }}">
											<div>
												<h2 class="title-3">
													<i class="icon-location-2"></i>&nbsp;
													<?php
													/*
													@if (isset($cats) and !$cats->isEmpty())
														{{ t('Choose a city') }}
													@else
														{!! mb_ucfirst(t(':count free local classified ads', ['count' => ''])) !!}
													@endif
													*/
													?>
													{{ t('Choose a city') }}
												</h2>
												<div class="row" style="padding: 0 10px 0 20px;">
													@foreach ($city_cols as $key => $cities)
														<ul class="cat-list col-xs-6 {{ (count($city_cols) == $key+1) ? 'cat-list-border' : '' }}">
															@foreach ($cities as $k => $city)
																<li>
																	@if ($city->id == 999999999)
																		<a href="#selectRegion" id="dropdownMenu1"
																		   data-toggle="modal">{{ $city->name }}</a>
																	@else
																		<a href="{{ url('/'.$lang->get('abbr').'/'.$country->get('icode').'/'.str_slug(trans('routes.t-search-location')).'/'.slugify($city->name).'/'.$city->id) }}">
																			{{ $city->name }}
																		</a>
																	@endif
																</li>
															@endforeach
														</ul>
													@endforeach
												</div>
											</div>
										</div>
									</div>

									<a class="btn btn-lg btn-yellow" href="{{ lurl(trans('routes.create-ad')) }}"
									   style="padding-left: 30px; padding-right: 30px; text-transform: none;">
										{{ t('Post a Free Classified Ad') }}
									</a>

								</div>
							@endif
						</div>

						@if(config('settings.show_country_svgmap'))
							@if (file_exists(public_path('images/maps/' . strtolower($country->get('code')) . '.svg')))
								<div id="countrymap" class="col-sm-3 page-sidebar col-thin-left">&nbsp;</div>
							@endif
						@endif

						<div class="col-sm-3 page-sidebar col-thin-left" style="padding: 30px 0 30px 0;">
							<ul class="list list-check">
								<li>{{ t('Sell anything for free') }}</li>
								<li>{{ t('Hundreds of buyers every day') }}</li>
								<li>{{ t('We sponsor your Ad') }}</li>
							</ul>
							<br><br>

							<span class="title-3"><a
										href="{{ url('/' . $lang->get('abbr') . '/' . $country->get('icode') . '/' . trans('routes.t-search')) }}">&raquo; {{ t('View all Ads') }}</a></span>
						</div>
					</div>
				</div>
			</div>

			@include('classified/home/inc/categories')

			@include('classified/home/inc/bottom-info')

		</div>
	</div>
@endsection

@section('modal-location')
	@include('classified/layouts/inc/modal/location')
@endsection

@section('javascript')
	@parent
	<script>
		var stateId = '<?php echo (isset($city)) ? $country->get('code').'.'.$city->subadmin1_code : '0' ?>';
	</script>
	<script type="text/javascript" src="{{ url('assets/js/app/load.cities.js') }}"></script>
	@if (file_exists(public_path('images/maps/' . strtolower($country->get('code')) . '.svg')))
		<script src="{{ url('assets/plugins/twism/jquery.twism.js') }}"></script>
		<script>
			$(document).ready(function () {
				/* SVG Maps */
				@if(config('settings.show_country_svgmap'))
				$('#countrymap').twism("create",
				{
					map: "custom",
					customMap: '<?php echo 'images/maps/' . strtolower($country->get('code')) . '.svg'; ?>',
					backgroundColor: 'transparent',
					color: '#fcf8e3',
					border: '#ffd005',
					borderWidth: 4,
					width: '300px',
					height: '300px',
					click: function(region) {
						if (typeof region == "undefined") {
							return false;
						}
						region = rawurlencode(region);
						var searchPage = '<?php echo url($lang->get('abbr').'/'.$country->get('icode').'/'.trans('routes.t-search')); ?>';
						window.location.replace(searchPage + '?r=' + region);
						window.location.href = searchPage + '?r=' + region;
					},
					hover: function(region_id) {
						if (typeof region_id == "undefined") {
							return false;
						}
						var selectedIdObj = document.getElementById(region_id);
						if (typeof selectedIdObj == "undefined") {
							return false;
						}
						selectedIdObj.style.fill = '#2ecc71';
						return;
					},
					unhover: function(region_id) {
						if (typeof region_id == "undefined") {
							return false;
						}
						var selectedIdObj = document.getElementById(region_id);
						if (typeof selectedIdObj == "undefined") {
							return false;
						}
						selectedIdObj.style.fill = '#fcf8e3';
						return;
					}
					/* @fixme: hoverColor attribute doesn't work */
					/* hoverColor: '#2ecc71' */
				});
				@endif
			});

			function rawurlencode(str) {
				str = (str + '').toString();
				return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
			}
		</script>
	@endif
@endsection
