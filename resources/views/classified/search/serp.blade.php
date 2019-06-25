@extends('classified.layouts.layout')
<style>
	.sort-by a {
		cursor: pointer;
	}
	.dropdown {
		margin-top: 1% !important;
	}
	.sort{
	  float:right;
	  border:1px solid #e40046;
	  color:#fff;  border-radius:30px;
	  position:relative;
	  padding:0px;
	  background:#e40046;
	  transition:ease-in-out all .2s;
	  margin: 5px 8px;
	}
	.sort-click{
	  padding:10px 18px;   
	  border-radius:100px; 
	  text-align:center; 
	  margin:0;float:left; 
	  cursor:pointer;
	}
	.lis{
	  list-style-type:none;  
	  padding:0;  
	  margin:0; 
	  text-align:center;
	  display:none; 
	  width:auto;
	 
	}
	.lis li{
	  padding:10px;
	  float:left;
	}
	.lis li.active a{
		/*background:#ccc;*/
		color:#e40046 !important;
	}
	.sort_a{
		color:#000 ;
		cursor:pointer;
	}
	.breadcrumb {
		float: left;
		width: auto;
	}
</style>
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
		'count_cat_biz' => (isset($count_cat_biz) and !is_null($count_cat_biz)) ? $count_cat_biz : null,
		'count_sub_cat_biz' => (isset($count_sub_cat_biz) and !is_null($count_sub_cat_biz)) ? $count_sub_cat_biz : null,
	])
	@include('classified/layouts/inc/advertising/top')
@endsection

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">
				{{--*/$realAdsWasFound = 0;/*--}}
				@if(1!=1)
				<div class="col-sm-12 page-content col-thin-left">
					<div class="category-list">
						<p style="margin:100px;">Milestone 2</p>
					</div>
				</div>
				@else
				<!-- Sidebar -->
				@if (config('settings.activation_serp_left_sidebar'))
				@include('classified/search/inc/sidebar-left')
					{{--*/ $contentColSm = 'col-sm-9'; /*--}}
				@else
					{{--*/ $contentColSm = 'col-sm-12'; /*--}}
				@endif

				<!-- Content -->
				<div class="{{ $contentColSm }} page-content col-thin-left">
					<div class="category-list">
						<div class="tab-box ">

							<!-- Nav tabs -->
							{{--*/
								$classAllActive = $classProActive = $classPersoActive = '';
								$classAllBadge = $classProBadge = $classPersoBadge = 'alert-danger';
								$realAdsWasFound = 0; 
							/*--}}
							@if (is_null(Request::get('type')) or Request::get('type') == '')
							{{--*/
								$classAllActive = 'class="active"';
								$classAllBadge = 'progress-bar-danger';
								$realAdsWasFound = $count->get('all');
							/*--}}
							@elseif (Request::get('type') == 2)
							{{--*/
								$classProActive = 'class="active"';
								$classProBadge = 'progress-bar-danger';
								$realAdsWasFound = $count->get('b');
							/*--}}
							@elseif (Request::get('type') == 1)
							{{--*/
								$classPersoActive = 'class="active"';
								$classPersoBadge = 'progress-bar-danger';
								$realAdsWasFound = $count->get('p');
							/*--}}
							@endif
							<ul id="ad_type" class="nav nav-tabs add-tabs" role="tablist">
								<li {!! $classAllActive !!}>
									<a href="{!! qsurl(Request::url(), Request::except(['page', 'type'])) !!}" role="tab" data-toggle="tab">
										{{ t('All Businesses') }} <span class="badge {!! $classAllBadge !!}">{{ $count->get('all') }}</span>
									</a>
								</li>
								<!--<li class="pull-right dropdown">
									<button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> {{ t('Sort by') }} &nbsp;<span class="caret"></span></button>
									<ul class="dropdown-menu sort-by">
										<li class="active"><a id="sort-by-date" class="active">{{ t('Date') }}</a></li>
										<li><a id="sort-by-rate">{{ t('Rating') }}</a></li>
										<li><a id="sort-by-expe">{{ t('Expense') }}</a></li>
									</ul>
								</li>-->
                                <div class="sort">
                                    <p id="click" class="sort-click">Sort by</p>
                                    <p id="close" class="sort-click"><i class="fa fa-long-arrow-right" style="margin-top: 5px;"></i></p> 
                                    <ul class="lis inline sort-by" id="list">
                                      <li class="active"><a id="sort-by-date" class="select sort_a">{{ t('Date') }}</a></li>
                                      <li><a id="sort-by-rate" class="sort_a">{{ t('Rating') }}</a></li>
                                      <li><a id="sort-by-expe" class="sort_a">{{ t('Expense') }}</a></li>
                                    </ul>
                                </div>
                                
							</ul>
							<div class="tab-filter" style="padding-right: 25px; padding-top: 20px;"></div>
						</div>

						<div class="listing-filter">
							<div class="pull-left col-xs-6">
								<div class="breadcrumb-list">
									<a href="{{ url($country->get('icode').'/'.trans('routes.t-search')) }}" class="current"> <span>{{ t('All business') }}</span></a>
									@if (Request::has('l') or Request::segment(3) == trans('routes.t-search-location') or Request::has('r'))
										<?php /*{!! t('in :distance km around :city', ['distance' => \App\Larapen\Helpers\Search::$distance, 'city' => $city->name]) !!}*/?>
										@if(strtolower($lang->get('abbr'))=='ar')
											{!! t('in :city', ['city' => $city->name]) !!}
										@else
											{!! t('in :city', ['city' => $city->asciiname]) !!}
										@endif
									@endif
									@if (Request::has('c') or Request::segment(3) == slugify($country->get('name')))
										@if (isset($cat))
											{!! t('in :category', ['category' => $cat->name]) !!}
										@endif
									@endif
								</div>
							</div>
							<div style="clear:both"></div>
						</div>
						<div class="adds-wrapper">
							<div  id="product_container">
								@include('classified/search/inc/business')
							</div>
						</div>
					</div>

					<!-- BOF ADD YOUR BUSINESS -->
					<div class="add-business-holder">
						<div class="add-business-container">
							<h3>{{t('Add Your Business')}}</h3>
							<div class="business-form">
								<form method="get" action="{{ lurl('/add-business') }}">
									<div class="col-md-6">
										<div class="business-name"> <!--<span id="businessname">{{t('Business name')}}</span>-->
											<input name="business_title" type="text" placeholder="{{t('Business name')}}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="business-location"> <!--<span id="businesslocation">{{t('Location')}}</span>-->
											<input name="business_location" type="text" class="loc_search" placeholder="{{t('Location')}}">
										</div>
									</div>
									<div class="col-md-2">
										<div class="business-add-button">
											<button type="submit">{{t('Get Start')}}</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- EOF ADD YOUR BUSINESS -->

				</div>

				<!-- Advertising -->
				@include('classified/layouts/inc/advertising/bottom')
				@endif
			</div>
		</div>
	</div>
@endsection

@section('modal-location')
	@include('classified/layouts/inc/modal/location')
@endsection

@section('javascript')
<!-- BOF PAGINATION AJAX SCRIPT -->
<script type="text/javascript">
	$(document).ready(function()
	{
		$(document).on('click', 'ul.sort-by li a',function(event)
		{
			event.preventDefault();
			$('ul.sort-by li').removeClass('active');
			$(this).parent('li').addClass('active'); 
			$('ul.sort-by li a').removeClass('select');
			$('ul.sort-by li.active a').addClass('select'); 
			var sort = $('ul.sort-by li.active a').html().toLowerCase();
			var url  = window.location.href;
			
			getData(url, sort);
		});
		
		$(document).on('click', '.pagination a',function(event)
		{
			event.preventDefault();
			$('li').removeClass('active');
			$(this).parent('li').addClass('active');
			var url  = $(this).attr('href');
			var sort = $('ul.sort-by li a.select').html().toLowerCase();
			
			getData(url, sort);
		});
	}); 
	function getData(url, sort) 
	{
		$.ajax({
			url : url,
			type: "get",
			data: { sort : sort }
		}).done(function (data) {
			$('#product_container').empty().html(data);
		}).fail(function () {
			alert('Data could not be loaded.');
		});
	}
</script>
<script>
	$("#close").hide();
	$("#click").click (function(){
	$("#list").show(); 
	$("#close").show();
	$("#click").hide();
	$("#list").css({display:"inline-block"});
	$(".lis").css({"background" :"#FFF", "border-radius": "0 100px 100px 0" })
	//$(".sort_a").css({"color":"#000"}) 
	});
	$("#close").click (function(){
	$("#list").hide();
	$("#click").show();
	$("#close").hide();
	});
</script>
<!-- EOF PAGINATION AJAX SCRIPT -->
<script type="text/javascript" src="{{ url('assets/js/app/load.cities.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/js/app/make.favorite.js') }}"></script>
@endsection
