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
@extends('classified.layouts.layout')

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-sm-3 page-sidebar">
					@include('classified/account/inc/sidebar-left')
				</div>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><i class="icon-cancel-circled "></i> @lang('global.Close account') </h2>
						<p>@lang('global.You are sure you want to close your account?')</p>

						<form role="form" method="POST" action="{{ lurl('account/close') }}">
							{!! csrf_field() !!}
							<div>
								<label class="radio-inline">
									<input type="radio" name="close_account_confirmation" id="closeAccountConfirmation1"
										   value="1"> @lang('global.Yes')
								</label>
								<label class="radio-inline">
									<input type="radio" name="close_account_confirmation" id="closeAccountConfirmation0" value="0"
										   checked> @lang('global.No')
								</label>
							</div>
							<br>
							<button type="submit" class="btn btn-primary">@lang('global.Submit')</button>
						</form>
					</div><!--/.inner-box-->
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
@endsection
