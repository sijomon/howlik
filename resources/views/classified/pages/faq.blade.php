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

@section('search')
	@parent
@endsection

@section('content')
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row ">
					<h1 class="text-center title-1"><strong>{!! trans('page.Site FAQ') !!}</strong></h1>
					<hr class="center-block small text-hr">
				</div>
				<div class="faq-content">

					<div aria-multiselectable="true" role="tablist" id="accordion" class="panel-group faq-panel">
						<div class="panel">
							<div id="headingOne" role="tab" class="panel-heading">
								<h4 class="panel-title">
									<a aria-controls="collapseOne" aria-expanded="true" href="#collapseOne" data-parent="#accordion"
									   data-toggle="collapse">
										{!! trans('page.How do I place an ad?') !!}
									</a>
								</h4>
							</div>
							<div aria-labelledby="headingOne" role="tabpanel" class="panel-collapse collapse in" id="collapseOne">
								<div class="panel-body">
									{!! trans('page.How do I place an ad? - Content') !!}
								</div>
							</div>
						</div>

						<div class="panel">
							<div id="headingTwo" role="tab" class="panel-heading">
								<h4 class="panel-title">
									<a aria-controls="collapseTwo" aria-expanded="false" href="#collapseTwo" data-parent="#accordion"
									   data-toggle="collapse" class="collapsed">
										{!! trans('page.What does it cost to advertise?') !!}
									</a>
								</h4>
							</div>
							<div aria-labelledby="headingTwo" role="tabpanel" class="panel-collapse collapse" id="collapseTwo">
								<div class="panel-body">
									{!! trans('page.What does it cost to advertise? - Content') !!}
								</div>
							</div>
						</div>

						<div class="panel">
							<div id="headingThree" role="tab" class="panel-heading">
								<h4 class="panel-title">
									<a aria-controls="collapseThree" aria-expanded="false" href="#collapseThree" data-parent="#accordion"
									   data-toggle="collapse" class="collapsed">
										{!! trans('page.If I post an ad, will I also get more spam e-mails?') !!}
									</a>
								</h4>
							</div>
							<div aria-labelledby="headingThree" role="tabpanel" class="panel-collapse collapse" id="collapseThree">
								<div class="panel-body">
									{!! trans('page.If I post an ad, will I also get more spam e-mails? - Content') !!}
								</div>
							</div>
						</div>

						<div class="panel">
							<div id="heading_04" role="tab" class="panel-heading">
								<h4 class="panel-title">
									<a aria-controls="collapse_04" aria-expanded="false" href="#collapse_04" data-parent="#accordion"
									   data-toggle="collapse" class="collapsed">
										{!! trans('page.How long will my ad remain on the website?') !!}
									</a>
								</h4>
							</div>
							<div aria-labelledby="heading_04" role="tabpanel" class="panel-collapse collapse" id="collapse_04">
								<div class="panel-body">
									{!! trans('page.How long will my ad remain on the website? - Content') !!}
								</div>
							</div>
						</div>

						<div class="panel">
							<div id="heading_05" role="tab" class="panel-heading">
								<h4 class="panel-title">
									<a aria-controls="collapse_05" aria-expanded="false" href="#collapse_05" data-parent="#accordion"
									   data-toggle="collapse" class="collapsed">
										{!! trans('page.I sold my item. How do I delete my ad?') !!}
									</a>
								</h4>
							</div>
							<div aria-labelledby="heading_05" role="tabpanel" class="panel-collapse collapse" id="collapse_05">
								<div class="panel-body">
									{!! trans('page.I sold my item. How do I delete my ad? - Content') !!}
								</div>
							</div>
						</div>
					</div>

				</div>

				@include('classified/layouts/inc/social/horizontal')
			</div>
		</div>
	</div>
@endsection

@section('info')
@endsection

@section('javascript')
	@parent
@endsection
