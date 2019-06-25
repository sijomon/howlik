@extends('classified.layouts.layout')
@section('content')
<!-- BOF MAIN CONTENTS --> 
<div class="content-holder">
	<div class="container"> 
		<!-- BOF BREADCRUMB -->
		<div class="page-details">
		  <ul class="breadcrumb">
			<li><a href="{{ lurl('/') }}">@lang('global.Home')</a></li>
			<li class="active">@lang('global.Find a Business')</li>
		  </ul>
		</div>
		<!-- EOF BREADCRUMB -->
		
		<!-- BOF COMPANY LISTING -->
		<div class="Company-listing">
			<div class="Company-listing-container">
				<h2 class="specify-caption">@lang('global.Search Business')</h2>
				<div class="company-list-holder"></div>
			</div>
		</div>
		<!-- EOF COMPANY LISTING -->
	</div>
</div>
<!-- EOF MAIN CONTENTS --> 
 
<!-- BOF BOTTOM CATEGORY LISTING -->  
<div class="bottom-category-list">
	<div class="container">
		<div class="list-cap">
			<h2>{{t('Categories')}}</h2>
		</div>
		<div class="col-md-12 col-sm-12">
			<div class="col-md-3 col-sm-3">
				<ul>
					{{--*/ $catLim = ceil(sizeof($cats)/4); $k = 1; /*--}}
					@if(isset($cats) && sizeof($cats)>0)
						@foreach($cats as $key => $value)
							@if($k>$catLim)
								</ul></div><div class="col-md-3 col-sm-3"><ul>
								{{--*/ $k = 1; /*--}}
							@endif
							<li><a href="{{lurl('c/'.trim($value->slug))}}">{{$value->name}}</a></li>
							{{--*/ $k++; /*--}}
						@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- EOF BOTTOM CATEGORY LISTING -->
@endsection