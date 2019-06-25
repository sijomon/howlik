@extends('classified.layouts.layout')
<style>
	.message_list ul li {
		list-style: none;
		float: left;
		margin-right: 11px;
		margin-bottom: 4%;
	}
	.reply-message textarea {
		width: 450px;
		height: 146px;
		float: left;
		background: rgba(238, 238, 238, 0.57);
	}
	
	.reply-message {
		width:80%;
    float: left;
    margin-top: 20px;
    border: 1px solid #ccc;
    margin: 30px 10%;
    padding: 20px;
	border-radius:2px;
	}
	.reply-message label {
		width: 100%;
		float: left;
	}
	.reply-btn {
		width: 100%;
		float: left;
		margin-top: 10px;
		margin-bottom: 10px;
	}
	.back-to-home {
		float: right;
		margin-top: 10px;
		padding: 10px;
		border: 1px solid #ccc;
		border-radius: 5px;
		color: #212121;
	} 
	.back-to-home:hover {
		text-decoration:none;
		background:#ccc;
	}
</style>
@section('content') 
	<div class="listing_holder">
		<div class="container"><br>
			<div class="Trending_section">
				<h4 style="display: inline-block;"> @if(!empty($mail_msge)) {{ $mail_msge[0]->subject }} @endif	</h4>
				<a href="javascript:window.history.back();" class="back-to-home"><i class="fa fa-mail-reply "></i> &nbsp; @lang('global.Back to Inbox')</a>
				<div class="event_tab">
                
                @if(!empty($mail_msge))
				<form method="POST" action="{{ lurl('message-reply') }}" class="message-replay-form">
					<div class="col-md-8"> 
						<div class="message-replay-section">
							@foreach($mail_msge as $mess)
								@if($mess->to_id == Auth::user()->id)
									{{--*/ $align = "right-row"; /*--}}
								@else	
									{{--*/ $align = ""; /*--}}
								@endif
								<div class="message-replay-row {{ $align }}">
									<div class="col-md-1 col-sm-2 col-xs-3 message-replay-image">
										@if($mess->userphoto != '')
											<img  class="replay-pro-pic" src="{{ url('/uploads/pictures/dp/'.$mess->userphoto) }}"/>
										@else
											<img class="replay-pro-pic" src="{{ url('/uploads/pictures/user-icon.png') }}"/>
										@endif
									</div>
									<div class="col-md-11 com-sm-10 col-xs-9">
										<div class="message-replay-content">
											<p class="name">{{ $mess->username }}</p>
											<p class="message">{{ str_limit($mess->reply, 100) }}</p>
											<p class="date">{{ date("M d g:i A", strtotime($mess->created_at)) }}</p>
										</div>
										@if($mess->from_id == Auth::user()->id)
											<input type="hidden" value="{{ $mess->to_id }}" name="from"/>	
										@else
											<input type="hidden" value="{{ $mess->from_id }}" name="from"/>
										@endif	
										<input type="hidden" value="{{ $mess->subject }}" name="subj"/>
									</div>
								</div>
							@endforeach 
							
							<div class="reply-message">
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
								<input type="hidden" value="{{ Request::segment(3) }}" name="msg_id"/>
								<label>@lang('global.Reply') : </label>
								<textarea name="mess" class="form-control" id="message-reply" cols="5" rows="4"></textarea>
								<div class="reply-btn"> 
									<a href="javascript:window.history.back();" class="btn btn-default">@lang('global.Cancel')</a>
									<button type="submit" class="btn btn-primary">@lang('global.Reply')</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				@endif 
				
				</div>
			</div>
		</div>
	</div>
	</div>
@endsection

@section('javascript')
	<script language="javascript">
		function goBack() {
			window.history.go(-1);
		}
		var countries = {};
		var countryCode = 'IN';
		var lang = {
			'select': {
				'country': "Select a country",
				'loc': "Select a location",
				'subLocation': "Select a sub-location",
				'city': "Select a city"
			}
		};
		var loc = '0';
		var subLocation = '0';
		var city = '0';
		var hasChildren = '';
	</script>
	<script>
		$( ".message-replay-form" ).submit(function (event) {
			
			if($.trim($("#message-reply" ).val()) == "" ) {
				$("#message-reply").focus();
				return false;
			} else {
				return true;
			}
			
		});
	</script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
