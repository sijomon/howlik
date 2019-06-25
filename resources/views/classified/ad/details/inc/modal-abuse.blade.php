<div class="modal fade" id="report_abuse" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">@lang('global.Close')</span></button>
				<h4 class="modal-title"><i class="fa icon-info-circled-alt"></i> @lang('global.There\'s something wrong with this  ads?') </h4>
			</div>
			<form role="form" method="POST" action="{{ lurl($ad->id . '/report') }}">
				<div class="modal-body">

					@if(count($errors) > 0 and old('abuse_form')=='1')
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					{!! csrf_field() !!}
					<div class="form-group required <?php echo ($errors->has('report_type')) ? 'has-error' : ''; ?>">
						<label for="report_type" class="control-label">@lang('global.Reason'):</label>
						<select id="report_type" name="report_type" class="form-control">
							<option value="">@lang('global.Select a reason')</option>
							@foreach($report_types as $reportType)
								<option value="{{ $reportType->id }}" {{ (old('report_type', 0)==$reportType->id) ? 'selected="selected"' : '' }}>
									{{ $reportType->name }}
								</option>
							@endforeach
						</select>
					</div>

					@if (Auth::check())
						<input type="hidden" name="report_sender_email" value="{{ $user->email }}">
					@else
						<div class="form-group required <?php echo ($errors->has('report_sender_email')) ? 'has-error' : ''; ?>">
							<label for="report_sender_email" class="control-label">@lang('global.Your E-mail'):</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-mail"></i></span>
								<input id="report_sender_email" name="report_sender_email" type="text" maxlength="60" class="form-control"
									   value="{{ old('report_sender_email') }}">
							</div>
						</div>
					@endif

					<div class="form-group required <?php echo ($errors->has('report_message')) ? 'has-error' : ''; ?>">
						<label for="report_message" class="control-label">@lang('global.Message') <span class="text-count">(300) </span>:</label>
						<textarea id="report_message" name="report_message" class="form-control" rows="5">{{ old('report_message') }}</textarea>
					</div>

					<!-- Captcha -->
					@if (config('settings.activation_recaptcha'))
						<div class="form-group required <?php echo ($errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
							<label class="control-label" for="g-recaptcha-response"><!-- lang('global.We do not like robots') --></label>
							<div>
								{{--Recaptcha::render(['lang' => $lang->get('abbr')]) --}}
							</div>
						</div>
					@endif

					<input type="hidden" name="ad" value="{{ $ad->id }}">
					<input type="hidden" name="abuse_form" value="1">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">@lang('global.Cancel')</button>
					<button type="submit" class="btn btn-primary">@lang('global.Send Report')</button>
				</div>
			</form>
		</div>
	</div>
</div>