@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content') 

<!--cms page holder-->
<div class="listing_holder">
  <div class="container">
    <div class="Trending_section aut">
      <div class="listing_head"> <span class="trending abut">{{ $title }}</span>
      </div>
    </div>
    <div class="about_holder">
      {!! $description !!}
    </div>
  </div>
</div>

<!--cms us page--> 


@endsection

@section('info')
@endsection

@section('javascript')
	@parent 

@endsection 