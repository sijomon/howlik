@extends('classified.layouts.layout')
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (count($errors) > 0)
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (session('status'))
					<div class="col-lg-12">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p>{{ session('status') }}</p>
						</div>
					</div>
				@endif

				@if (session('email'))
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p>{{ session('email') }}</p>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-sm-5 login-box">
					<div class="panel panel-default">
						<div class="panel-intro text-center">
							<h2 class="logo-title">
								<span class="logo-icon"> </span> {{ t('Password') }} <span> </span>
							</h2>
						</div>
						<div class="panel-body">
							<form id="pwdForm" role="form" method="POST" action="{{ lurl('password/email') }}">
								{!! csrf_field() !!}
								<div class="form-group <?php echo ($errors->has('email')) ? 'has-error' : ''; ?>">
									<label for="email" class="control-label">{{ t('Email Address') }}:</label>
									<div class="input-icon"><i class="icon-user fa"></i>
										<input id="email" name="email" type="text" placeholder="{{ t('Email Address') }}" class="form-control email"
											   value="{{ old('email') }}">
									</div>
								</div>
								<div class="form-group">
									<button id="pwdBtn" type="submit"
											class="btn btn-primary btn-lg btn-block">{{ t('Send Password Reset Link') }}</button>
								</div>
							</form>
						</div>
						<div class="panel-footer">
							<p class="text-center "><a href="<?php echo lurl(trans('routes.login')); ?>"> {{ t('Back to Login') }} </a></p>
							<div style=" clear:both"></div>
						</div>
					</div>
					<div class="login-box-btm text-center">
						<p> {{ t('Don\'t have an account?') }} <br>
							<a href="<?php echo lurl(trans('routes.signup')); ?>"><strong>{{ t('Sign Up !') }}</strong> </a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent

	<script src="{{ url('assets/js/form-validation.js') }}"></script>

	<script language="javascript">
		$(document).ready(function () {
			$("#pwdBtn").click(function () {
				$("#pwdForm").submit();
				return false;
			});
		});
	</script>
@endsection