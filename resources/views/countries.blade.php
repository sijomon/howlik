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

@section('header')
	@if (Auth::check())
		@include('classified.layouts.inc.header', ['country' => $country, 'user' => $user])
	@else
		@include('classified.layouts.inc.header', ['country' => $country])
	@endif
@endsection

@section('search')
	@parent
@endsection


@section('content')
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<h1 class="text-center title-1" style="text-transform: none;">
						<strong>{{ t('Our websites abroad') }}</strong>
					</h1>
					<hr class="center-block small text-hr">

					@if (isset($country_cols))
						<div class="col-md-12 page-content">
							<div class="inner-box relative">
								<div class="row">
									<div>
										<h3 class="title-2"><i class="icon-location-2"></i> {{ t('Select a country') }} </h3>
										<div class="row" style="padding: 0 20px">
											@foreach ($country_cols as $key => $col)
												<ul class="cat-list col-xs-3 {{ (count($country_cols) == $key+1) ? 'cat-list-border' : '' }}">
													@foreach ($col as $k => $country)
														<?php
														$country_lang = CountryLocalization::getLangFromCountry($country->get('languages'));
														?>
														<li>
															<img src="{{ url('/images/blank.gif') }}" class="flag-16 flag-{{ $country->get('icode') }}"
																 style="margin-bottom: 4px; margin-right: 5px;" data-no-retina/>
															<a href="{{ url('/' . $country_lang->get('abbr') . '/?d=' . $country->get('code')) }}">
																<i class="flag flag-{{ $country->get('icode') }}"></i>
																{{ str_limit($country->get('name'), 100) }}
															</a>
														</li>
													@endforeach
												</ul>
											@endforeach
										</div>
									</div>
								</div>
							</div>
						</div>
					@endif

				</div>

				@include('classified.layouts.inc.social.horizontal')

			</div>
		</div>
	</div>
	<!-- /.main-container -->
@endsection

@section('info')
@endsection

@section('javascript')
	@parent
	<script>
		$(document).ready(function () {
			$('#countries').change(function () {
				var goToUrl = $(this).val();
				window.location.replace(goToUrl);
				window.location.href = goToUrl;
			});
		});
	</script>
@endsection
