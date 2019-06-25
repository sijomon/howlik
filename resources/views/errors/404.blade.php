@extends('classified.layouts.layout')

@section('title', t('Page not found', []))

@section('search')
	@parent
	@include('errors/layouts/inc/search')
@endsection

@section('content')
	<div class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						<div class="error-page" style="margin: 100px 0;">
							<h2 class="headline text-center" style="font-size: 180px; float: none;"> 404</h2>
							<div class="text-center m-l-0" style="margin-top: 60px;">
								<h3 class="m-t-0"><i class="fa fa-warning"></i> :-( {{ t('Page not found') }} !</h3>
								<p>
									<?php
									$default_error_message = "Meanwhile, you may <a href='" . url('/') . "'>return to homepage</a>";
									?>
									{!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
								</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- /.main-container -->
@endsection

@section('javascript')
	@parent
@endsection
