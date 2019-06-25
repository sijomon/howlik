@extends('classified.layouts.layout')
@section('content')
<div class="content-holder">
  <div class="container">
    <div class="row"> @if (config('settings.activation_social_login'))
      <div class="container text-center" style="margin-bottom: 30px;">
        <div class="row">
          <div class="btn btn-fb" style="width: 194px; margin-right: 1px;"> <a href="{{ lurl('auth/facebook') }}" class="btn-fb"><i class="icon-facebook"></i>{{ t('Facebook') }}</a> </div>
          <div class="btn btn-danger" style="width: 194px; margin-left: 1px;"> <a href="{{ lurl('auth/google') }}" class="btn-danger"><i class="icon-googleplus-rect"></i>{{ t('Google+') }}</a> </div>
        </div>
      </div>
      @endif
      <div class="col-sm-5 login-box">
        <form id="loginForm" role="form" method="POST" action="{{ lurl('login-post') }}">
          {!! csrf_field() !!}
          <div class="panel panel-default"> @if (count($errors) > 0)
            <div class="col-sm-12 suce">
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
            <div class="panel-intro text-center"> 
				@if (Session::has('flash_notification.message'))
					<div class="col-lg-12"> @include('flash::message') </div>
				@endif
              <h2 class="logo-title"> <strong><span class="logo-icon"></span>{{ t('Log in') }}</strong> </h2>
            </div>
            <div class="panel-body">
              <div class="form-group <?php echo ($errors->has('email')) ? 'has-error' : ''; ?>">
                <label for="email" class="control-label">{{ t('Email Address') }}:</label>
                <div class="input-icon"><i class="fa fa-user"></i>
                  <input id="email" name="email" type="text" placeholder="{{ t('Email Address') }}" class="form-control email"
											   value="{{ (session('email')) ? session('email') : old('email') }}">
                </div>
              </div>
              <div class="form-group <?php echo ($errors->has('password')) ? 'has-error' : ''; ?>">
                <label for="password" class="control-label">{{ t('Password') }}:</label>
                <div class="input-icon"><i class="fa fa-lock"></i>
                  <input id="password" name="password" type="password" class="form-control" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
                <button id="loginBtn" class="btn btn-primary btn-block"> {{ t('Login') }} </button>
              </div>
            </div>
            <div class="panel-footer">
              <label class="checkbox pull-left" style="padding-left: 20px;">
              <input type="checkbox" value="1" name="remember" id="remember">
              {{ t('Keep me logged in') }} </label>
              <p class="text-center pull-right"><a href="<?php echo lurl('password/email'); ?>"> {{ t('Lost your password?') }} </a> </p>
              <div style=" clear:both"></div>
            </div>
          </div>
        </form>
        <div class="login-box-btm text-center">
          <p><a href="<?php echo lurl(trans('routes.signup')); ?>"><strong>{{ t('Register Now') }} !</strong> </a>  <br>
		  {{ t('For more customized feeds') }}
            </p>
        </div>
      </div>
      <?php /*@include('classified/layouts/inc/social/horizontal')*/ ?>
    </div>
  </div>
</div>
@endsection
@section('javascript')
	@parent
	<script language="javascript">
		$(document).ready(function () {
			$("#loginBtn").click(function () {
				$("#loginForm").submit();
				return false;
			});
		});
	</script>
@endsection 
