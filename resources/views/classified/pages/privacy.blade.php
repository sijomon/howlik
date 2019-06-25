@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content')
	
<div class="listing_holder priva">
	<div class="container">
		<div class="Trending_section aut">
			<div class="listing_head Privacy"> 
				<span class="trending abut ">{{ trans('privacy.Howlik Privacy Policy') }}</span>
				<p>{!! trans('privacy.short_text') !!}</p>
			</div>
		</div>
		<div class="about_holder Priv">
			{!! trans('privacy.privacy_content') !!}
		</div>
	</div>
</div>
    
    
@endsection

@section('info')
@endsection

@section('javascript')
	@parent
@endsection
