@extends('classified.layouts.layout')
@section('content')
<style>

	.fileContainer [type=file] {
		
		cursor: inherit;
		position: absolute;
	}

</style>
<div class="main-container" dir="ltr">
  <div class="container">
    <div class="row">
      <?php  if ($user->user_type_id  == 3) { ?>
      <div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
      <?php  }else{ ?>
      <div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
      <?php }?>
      <!--/.page-sidebar-->
      <?php /*?><div class="<?php if($user->user_type_id  == 2) { ?> col-sm-9 <?php  }else{ ?> col-sm-12  <?php } ?>page-content"><?php */?>
      <div class=" col-sm-9 page-content"> @include('flash::message')
        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <h5><strong>@lang('global.Oops ! An error has occurred. Please correct the red fields in the form')</strong></h5>
          <ul class="list list-check">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <div class="inner-box">
          <div class="row">
            <div class="col-md-5 col-xs-4 col-xxs-12">
              <h3 class="no-padding text-center-480 useradmin"> <a>
				@if(is_file('uploads/pictures/dp/'.$user->photo))
					<img class="userImg" src="{{ url('uploads/pictures/dp/'.$user->photo) }}" alt="{{ $user->name }} ">
				@else
					<img class="userImg" src="{{ url('images/user.jpg') }}" alt="{{ $user->name }} ">
				@endif
				<h3 class="page-sub-header2 clearfix no-padding">@lang('global.Hello') {{ $user->name }} ! </h3>
            <span class="page-sub-header-sub small">@lang('global.You last logged in at')
            : {{ $user->last_login_at->format('d-m-Y H:i:s') }}</span>  </a> </h3>
            </div>
            @if (count($errors) > 0)
            <div class="col-md-7 col-xs-8 col-xxs-12">
              <div class="header-data text-center-xs">
                <!-- Traffic data -->
                <div class="hdata">
                  <div class="mcol-left">
                    <!-- Icon with red background -->
                    <i class="fa fa-eye ln-shadow"></i> </div>
                  <div class="mcol-right">
                    <!-- Number of visitors -->
                    <p> <a href="{{ lurl('account/myads') }}">{{ $ad_counter->total_visits or 0 }}</a> <em>{{ trans_choice('global.visits', (isset($ad_counter) ? $ad_counter->total_visits : 0)) }}</em> </p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <!-- Ads data -->
                <div class="hdata">
                  <div class="mcol-left">
                    <!-- Icon with green background -->
                    <i class="icon-th-thumb ln-shadow"></i> </div>
                  <div class="mcol-right">
                    <!-- Number of ads -->
                    <p> <a href="{{ lurl('account/myads') }}">{{ \App\Larapen\Models\Ad::where('user_id', $user->id)->count() }}</a> <em>@lang('global.Ads')</em> </p>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <!-- Favorites data -->
                <div class="hdata">
                  <div class="mcol-left">
                    <!-- Icon with blue background -->
                    <i class="fa fa-user ln-shadow"></i> </div>
                  <div class="mcol-right">
                    <!-- Number of favorites -->
                    <p> <a href="{{ lurl('account/favourite') }}">{{ \App\Larapen\Models\SavedAd::where('user_id', $user->id)->count() }}</a> <em>@lang('global.Favorites') </em> </p>
                  </div>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            @endif </div>
        </div>
        
      </div>
      <!--/.page-content-->
    </div>
    <!--/.row-->
  </div>
  <!--/.container-->
</div>
<!-- /.main-container -->
@endsection

@section('javascript')
	@parent
	<script language="javascript">
		$(document).ready(function () {
			var countries = <?php echo (isset($countries)) ? $countries->toJson() : '{}'; ?>;
			var countryCode = $('#country').val();
			/* Set Country Phone Code */
			setCountryPhoneCode(countryCode, countries);
			$('#country').change(function () {
				setCountryPhoneCode($(this).val(), countries);
			});
			
			$('#receive_emails').change(function () {
				if(this.checked){
					$("#rec_email_div").find("input[type='checkbox']").prop('disabled', false);
				}else{
					$("#rec_email_div").find("input[type='checkbox']").prop('disabled', true);
				}
			});
		});
	</script>
@endsection 
