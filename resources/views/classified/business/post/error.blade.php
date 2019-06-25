@extends('classified.layouts.layout')

@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12 page-content">

					<div class="error-page" style="margin: 100px 0;">
						<h2 class="headline text-center" style="font-size: 30px; float: none;"> @lang('global.You didn\'t have the permission to access this page.') <br> @lang('global.Please login as a business user right now!') </h2>
						<div class="text-center m-l-0" style="margin-top: 60px;">
							<p>@lang('global.Meanwhile, you may') <a href="{{ lurl('/') }}"> @lang('global.return to homepage.')</a></p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection