<?php
$advertising = \App\Larapen\Models\Advertising::where('slug', 'top')->first();
?>
@if (!is_null($advertising))
	<div class="container hidden-md hidden-sm hidden-xs">
		<div class="text-center">
			{!! $advertising->tracking_code_large !!}
		</div>
	</div>
	<div class="container hidden-lg hidden-xs">
		<div class="text-center">
			{!! $advertising->tracking_code_medium !!}
		</div>
	</div>
	<div class="container hidden-sm hidden-md hidden-lg">
		<div class="text-center">
			{!! $advertising->tracking_code_small !!}
		</div>
	</div>
@endif