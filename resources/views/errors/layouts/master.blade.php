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
<!DOCTYPE html>
<html lang="{{ (isset($lang) and $lang->has('abbr')) ? $lang->get('abbr') : 'en' }}">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex,nofollow"/>
	<meta name="googlebot" content="noindex">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ url('/assets/ico/apple-touch-icon-144-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ url('/assets/ico/apple-touch-icon-114-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ url('/assets/ico/apple-touch-icon-72-precomposed.png') }}">
	<link rel="apple-touch-icon-precomposed" href="{{ url('/assets/ico/apple-touch-icon-57-precomposed.png') }}">
	<link rel="shortcut icon" href="{{ url('/assets/ico/favicon.png') }}">
	<title>@yield('title')</title>
	<link href="{{ url('/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ url('/assets/css/style.css') }}" rel="stylesheet">
	<link href="{{ url('/assets/css/style/default.css') }}" rel="stylesheet">
	<link href="{{ url('/assets/css/fileinput.min.css') }}" media="all" rel="stylesheet" type="text/css"/>
	<link href="{{ url('/assets/css/owl.carousel.css') }}" rel="stylesheet">
	<link href="{{ url('/assets/css/owl.theme.css') }}" rel="stylesheet">
	<link href="{{ url('/assets/css/flags/flags.css') }}" rel="stylesheet">
	@section('css')
    @show

    <!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

	<script>
		paceOptions = {
			elements: true
		};
	</script>
	<script src="{{ url('/assets/js/pace.min.js') }}"></script>
</head>
<body>
<div id="wrapper">

	@section('header')
		@if (Auth::check() and isset($user))
			@include('errors/layouts/inc/header', ['user' => $user])
		@else
			@include('errors/layouts/inc/header')
		@endif
	@show

	@section('search')
	@show

	@yield('content')

	@section('info')
	@show

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				@section('footer')
					@include('errors/layouts/inc/footer')
				@show
			</div>
		</div>
	</div>

</div>

@section('javascript')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"> </script> -->
<script src="{{ url('/assets/js/jquery/1.10.1/jquery-1.10.1.js') }}"></script>
<script src="{{ url('/assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/plugins/retina/1.3.0/retina.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.mockjax.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/plugins/autocomplete/jquery.autocomplete.min.js') }}"></script>
<script type="text/javascript" src="{{ url('/assets/js/app/autocomplete.cities.js') }}"></script>
@show

{!! config('settings.seo_google_analytics') !!}
</body>
</html>