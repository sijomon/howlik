<div class="modal fade" id="contact_user" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">@lang('global.Close')</span></button>
				<h4 class="modal-title"><i class=" icon-mail-2"></i> @lang('global.Contact advertiser') </h4>
			</div>
			<form role="form" method="POST" action="{{ lurl($ad->id . '/contact') }}">
				<div class="modal-body">

					@if(count($errors) > 0 and old('msg_form')=='1')
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
					@if (Auth::check())
						<input type="hidden" name="sender_name" value="{{ $user->name }}">
						<input type="hidden" name="sender_email" value="{{ $user->email }}">
						<input type="hidden" name="sender_phone" value="{{ $user->phone }}">
					@else
						<div class="form-group required <?php echo ($errors->has('sender_name')) ? 'has-error' : ''; ?>">
							<label for="sender_name" class="control-label">@lang('global.Name'):</label>
							<input id="sender_name" name="sender_name" class="form-control" placeholder="@lang('global.Your name')" type="text"
								   value="{{ old('sender_name') }}">
						</div>

						<div class="form-group required <?php echo ($errors->has('sender_email')) ? 'has-error' : ''; ?>">
							<label for="sender_email" class="control-label">@lang('global.E-mail'):</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-mail"></i></span>
								<input id="sender_email" name="sender_email" type="text" placeholder="@lang('global.i.e. you@gmail.com')"
									   class="form-control" value="{{ old('sender_email') }}">
							</div>
						</div>

						<div class="form-group required <?php echo ($errors->has('sender_phone')) ? 'has-error' : ''; ?>">
							<label for="sender_phone" class="control-label">@lang('global.Phone Number'):</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-phone-1"></i></span>
								<input id="sender_phone" name="sender_phone" type="text" maxlength="60" class="form-control"
									   value="{{ old('sender_phone') }}">
							</div>
						</div>
					@endif

					<div class="form-group required <?php echo ($errors->has('message')) ? 'has-error' : ''; ?>">
						<label for="message" class="control-label">@lang('global.Message') <span class="text-count">(500 max) </span>:</label>
						<textarea id="message" name="message" class="form-control required" placeholder="@lang('global.Your message here...')"
								  rows="5">{{ old('message') }}</textarea>
					</div>

					<!-- Captcha -->
					@if (config('settings.activation_recaptcha'))
						<div class="form-group required <?php echo ($errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
							<label class="control-label" for="g-recaptcha-response">@lang('global.We do not like robots')</label>
							<div>
								{!! Recaptcha::render(['lang' => $lang->get('abbr')]) !!}
							</div>
						</div>
					@endif

					<input type="hidden" name="ad" value="{{ $ad->id }}">
					<input type="hidden" name="msg_form" value="1">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">@lang('global.Cancel')</button>
					<button type="submit" class="btn btn-success pull-right">@lang('global.Send message')</button>
				</div>
			</form>
		</div>
	</div>
</div>