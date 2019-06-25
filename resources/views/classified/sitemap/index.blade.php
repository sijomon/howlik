@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content')
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

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

					<h1 class="text-center title-1"><strong>{{ trans('page.Sitemap') }}</strong></h1>
					<hr class="center-block small text-hr">

					<div class="col-sm-12 page-content">
						<div class="inner-box category-content">
							<h2 class="title-2">{{ t('List of Categories and Sub-categories') }}</h2>
							<div class="row" style="padding: 10px;">
								@foreach ($cats as $key => $col)
									<div class="col-md-4 col-sm-4 {{ (count($cats) == $key+1) ? 'last-column' : '' }}">
										@foreach ($col as $categorie)
											<div class="cat-list">
												<h3 class="cat-title">
													<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$categorie->slug) }}">
														<i class="{{ $categorie->css_class }} ln-shadow"></i>
														{{ $categorie->name }} <span class="count"></span>
													</a>
                                        <span data-target=".cat-id-{{ $categorie->position }}" data-toggle="collapse"
											  class="btn-cat-collapsed collapsed">
                                            <span class=" icon-down-open-big"></span>
										</span>
												</h3>
												<ul class="cat-collapse collapse in cat-id-{{ $categorie->position }} long-list-home"
													style="padding-bottom: 20px;">
													@if ($sub_cats->get($categorie->tid))
														@foreach ($sub_cats->get($categorie->tid) as $sub_cat)
															<li>
																<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$categorie->slug.'/'.$sub_cat->slug) }}">
																	{{ $sub_cat->name }}
																</a>
															</li>
														@endforeach
													@endif
												</ul>
											</div>
										@endforeach
									</div>
								@endforeach
							</div>
						</div>

						@if(isset($cities))
							<div class="inner-box relative">
								<div class="row">
									<div class="col-md-12">
										<div>
											<h2 class="title-2"><i
														class="icon-location-2"></i> {{ t('List of Cities in') }} {{ $country->get('name') }} </h2>
											<div class="row" style="padding: 0 10px 0 10px;">
												<ul>
													@foreach ($cities as $key => $cols)
														<ul class="cat-list col-xs-3 {{ ($cities->count() == $key+1) ? 'cat-list-border' : '' }}">
															@foreach ($cols as $j => $city)
																<li>
																	<a title="{{ t('Free Ads') }} {{ $city->name }}"
																	   href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.trans('routes.t-search-location').'/' . slugify($city->name) . '/' . $city->id) }}">
																		<strong>{{ $city->name }}</strong>
																	</a>
																</li>
															@endforeach
														</ul>
													@endforeach
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif

					</div>

				</div>
				@include('classified/layouts/inc/social/horizontal')
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent
@endsection
