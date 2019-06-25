@extends('classified.layouts.layout')
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (count($errors) > 0)
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>@lang('global.Oops ! An error has occurred. Please correct the red fields in the form')</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
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
				
				<?php  if ($user->user_type_id  == 3) { ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i>{{t('Image Upload')}} - {{ $business->title }}</strong></h2>
						<div class="col-sm-12">
							<form action="" enctype="multipart/form-data" id="imgUpload" method="post">
							<div class="image_drop" style="margin-top:0;">
								<div class="dropzone" id="bizdropzone" style="margin-bottom:0;" name="bizdropzone"> </div>
								<p>{{ t('we recommend usung at least a 2160x1080px(2:1ratio) image thats no larger than 10MB learn more') }}</p>
							</div>
							<input type="hidden" id="biz_id" name="biz_id" value="{{ $business->id }}"/>
							<input type="hidden" id="imge1" name="imge1" value=""/>
							{!! Form::token() !!}
							</form>
						</div>
					</div>
				</div>
				<!-- /.page-content -->
				
				<!-- Button  -->
				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-8">
						<a href="{{lurl('account/bizinfo/'.$business->id)}}"><button class="btn btn-success btn-lg"> {{ t('Back') }} </button></a>
					</div>
				</div>
				<!-- Button  -->
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent
	
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
