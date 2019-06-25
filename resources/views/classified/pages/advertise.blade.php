@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content')
	
      
  <div class="listing_holder">
    <div class="container">
      <div class="Trending_section aut">
        <div class="listing_head advice">
         <span class="trending abut">{{ trans('advertise.Advertise on Howlik') }}</span>
          <p>{!! trans('advertise.short_text') !!}</p>
        </div>
      </div>
      <div class="about_holder advertise">
	  	{!! trans('advertise.advertise_content') !!}
      </div>
    </div>
  </div>
    
    
@endsection

@section('info')
@endsection

@section('javascript')
	@parent
@endsection
