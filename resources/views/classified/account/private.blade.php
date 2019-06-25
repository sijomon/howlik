@extends('classified.layouts.layout')

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12 page-content">

					<div class="error-page" style="margin: 100px 0;">
						<h2 class="headline text-center" style="font-size: 30px; float: none;"> @lang('global.This is a private account.') </h2>
						<span class="fa fa-lock" style="display: block; font-size: 100px; text-align: center; margin-top: 30px;"></span>
						<div class="text-center m-l-0" style="margin-top: 30px;">
							<p>@lang('global.Meanwhile, you may') <a href="{{ lurl('/') }}"> @lang('global.return to homepage.')</a></p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection