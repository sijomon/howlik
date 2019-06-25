@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content')
	
      
  <div class="listing_holder press_holder">
    <div class="container">
      <div class="Trending_section aut">
        <div class="listing_head"> 
        <span class="trending abut">{{ trans('press.Press') }}</span>
        </div>
      </div>
		<div class="about_holder press">
			{!! trans('press.press_content') !!}
			<span class="pre"><a href="#">{{ trans('press.Our Media Kit Dowload') }}</a></span>
		</div>
    </div>
  </div>
    
    
@endsection

@section('info')
@endsection

@section('javascript')
	@parent
@endsection
