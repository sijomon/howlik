@extends('classified.layouts.layout')

@section('search')
	@parent
@endsection

@section('content')

	<div class="listing_holder priva term">
		<div class="container">
			<div class="Trending_section aut">
				<div class="listing_head">
				 	<span class="trending abut">{{ trans('terms.Howlik Terms of Service') }} </span>
				</div>
			</div>
			<div class="about_holder Priv">
				{!! trans('terms.terms_content') !!}
			</div>
		</div>
	</div>
	
@endsection

@section('info')
@endsection

@section('javascript')
	@parent

	<script src="{{ url('assets/js/form-validation.js') }}"></script>
@endsection
