@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content') 

<!--about page holder-->
<div class="listing_holder">
  <div class="container">
    <div class="Trending_section aut">
      <div class="listing_head"> <span class="trending abut">{{ trans('about.About Howlik') }}</span>
        <p>{!! trans('about.short_text') !!}</p>
      </div>
    </div>
    <div class="about_holder">
      {!! trans('about.about_content') !!}
    </div>
  </div>
</div>

<!--about us page--> 

<!---Most Popular In Dubai--> 

@endsection

@section('info')
@endsection

@section('javascript')
	@parent 
<script src="{{ url('assets/js/form-validation.js') }}"></script> 
@endsection 