<!-- Modal Change City -->
<div class="modal fade" id="selectRegion" tabindex="-1" role="dialog" aria-labelledby="regionCitiesModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">@lang('global.Close')</span>
				</button>
				<h4 class="modal-title" id="regionCitiesModalLabel">
					<i class=" icon-map"></i> @lang('global.Select your region')
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<p id="select_state">@lang('global.Popular cities in') <strong>{{ $country->get('name') }}</strong></p>
						<div style="clear:both"></div>
						<div class="col-sm-6 no-padding">
							<form id="stateForm" name="stateForm" method="POST">
								<input type="hidden" id="curr_search" name="curr_search" value="{{ base64_encode(serialize(Request::except(['l', 'location', '_token']))) }}">
								<select class="form-control" id="region_state" name="region_state">
									<option selected value="">@lang('global.All regions')</option>
									@foreach($states as $state)
										<option value="{{ $state->code }}">{{ $state->name }}</option>
									@endforeach
								</select>
								{!! csrf_field() !!}
							</form>
						</div>
						<div style="clear:both"></div>
						<hr class="hr-thin">
					</div>
					<div id="state_cities"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- /.modal -->