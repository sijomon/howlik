<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		{{-- Encrypted CSRF token for Laravel, in order for Ajax requests to work --}}
		<meta name="csrf-token" content="{{ csrf_token() }}" />

		<title>
		  {{ isset($title) ? $title.' :: '.config('backpack.base.project_name').' Admin' : config('backpack.base.project_name').' Admin' }}
		 
		</title>

		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/dist/css/skins/_all-skins.min.css">

		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/iCheck/flat/blue.css">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/morris/morris.css">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/datepicker/datepicker3.css">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/daterangepicker/daterangepicker-bs3.css">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
		<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/pace/pace.min.css">
		<link rel="stylesheet" href="{{ asset('vendor/backpack/pnotify/pnotify.custom.min.css') }}">

		<!-- BackPack Base CSS -->
		<link rel="stylesheet" href="{{ asset('vendor/backpack/backpack.base.css') }}">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<!-- Site wrapper -->
		<div class="wrapper">

			@yield('content')

		</div>
		<!-- ./wrapper -->

		<!-- jQuery 2.1.4 -->
		<script src="{{ asset('vendor/adminlte') }}/plugins/jquery/jquery-2.1.4.min.js"></script>
		<!-- Bootstrap 3.3.5 -->
		<script src="{{ asset('vendor/adminlte') }}/bootstrap/js/bootstrap.min.js"></script>
		<script src="{{ asset('vendor/adminlte') }}/plugins/pace/pace.min.js"></script>
		<script src="{{ asset('vendor/adminlte') }}/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<script src="{{ asset('vendor/adminlte') }}/plugins/fastclick/fastclick.js"></script>
		<script src="{{ asset('vendor/adminlte') }}/dist/js/app.min.js"></script>

		@include('backpack::inc.alerts')
		<!-- JavaScripts -->
		{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
		
	</body>
</html>
