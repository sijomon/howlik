@extends('classified.layouts.layout')
@section('content')
<style>
	.search_friend a {
		width: 100%;
		float: left;
	}

	.search_friend {
		float: right;
	}

	/* model style*/
	.modalDialog {
		position: fixed;
		font-family: Arial, Helvetica, sans-serif;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background: rgba(0,0,0,0.8);
		z-index: 99999;
		opacity:0;
		-webkit-transition: opacity 400ms ease-in;
		-moz-transition: opacity 400ms ease-in;
		transition: opacity 400ms ease-in;
		pointer-events: none;
	}
	.modalDialog:target {
		opacity:1;
		pointer-events: auto;
	}

	.modalDialog > div {
		width: 400px;
		position: relative;
		margin: 10% auto;
		padding: 5px 20px 13px 20px;
		border-radius: 10px;
		background: #fff;
		/*background: -moz-linear-gradient(#fff, #999);
		background: -webkit-linear-gradient(#fff, #999);
		background: -o-linear-gradient(#fff, #999);*/
	}
	.close {
		background: #606061;
		color: #FFFFFF;
		line-height: 25px;
		position: absolute;
		right: -12px;
		text-align: center;
		top: -10px;
		width: 24px !important;
		text-decoration: none;
		font-weight: bold;
		-webkit-border-radius: 12px !important;
		-moz-border-radius: 12px;
		border-radius: 12px !important;
		-moz-box-shadow: 1px 1px 3px #000;
		-webkit-box-shadow: 1px 1px 3px #000 !important;
		box-shadow: 1px 1px 3px #000 !important;
		opacity: 1;
		font-size: 12px;
	}
	.close:hover {
		background: #00d9ff;
		opacity: 1;
		text-shadow: none;
		color: #fff;
	}
	.search_friend p {
		height: auto;
	}
	.search_friend label {
		width: 100%;
	}
	.search_friend text,textarea {
		width: 100% !important;
	}
</style>
<div class="listing_holder">
	<div class="container">
		<div class="Trending_section mt-20">
			<div class="listing_head"> </div>
		</div>
		@if (Session::has('message'))
			<div class="alert alert-info">{{ Session::get('message') }}</div>
		@endif
	
		<div class="event_holsection">
			<div class="section_event_holder">
				<div class="friend-search">
					<form method="POST" action="{{lurl('post-friend')}}" id="post-friend-form">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="text" name="friend" id="friend-search" placeholder="{{ t('e.g. example@email.com') }}" />
						<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
					</form> 
				</div>
				<h4>@lang('global.Member Search Results')</h4>
			
				@if(!empty($members))
					{{--*/ $i=1; /*--}}
					@foreach($members as $mem)
						<div class="list_event"> 
							@if($mem->photo != '')
								<img style="width:100px;" src="{{ url('/uploads/pictures/dp/'.$mem->photo) }}">
							@else
								<img style="width:100px;" src="{{ url('/uploads/pictures/user-icon.png') }}">
							@endif
							<div class="member_detail">
								<h4><a href="{{ lurl('/profiles/'.$mem->id) }}">{{ $mem->name}}</a></h4>
								<span>{{$mem->member_country}}</span>
							</div>
							<div class="search_friend">
								<a href="#openMessageModal_{{$i}}"><i class="fa fa-comments-o" aria-hidden="true" style="margin-right: 10px;"></i>@lang('global.Send Message')</a>
								<form method="post" action="{{lurl('send-message')}}" class="send-message-form">
									<div id="openMessageModal_{{$i}}" class="modalDialog">
										<div class="add-friend-popup">
											<a href="#close" title="Close" class="close">X</a>
											<h2>@lang('global.Send a Message to') {{ $mem->name}}</h2>
											<label>@lang('global.Subject')<sup>*</sup></label>
											<input type="text" name="subject" id="subject" class="subject-send-{{$i}}" />
											<label>@lang('global.Message')<sup>*</sup></label>
											<textarea name="message" class="message-send-{{$i}}"></textarea>
											<button type="submit" onClick="return messageValidate({{$i}});">@lang('global.Send')</button>
											<a href="#close" class="cancel_btn">@lang('global.Cancel')</a>
											<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
											<input type="hidden" name="customer_id" id="customer_id" value="{{ $mem->id}}"/>
										</div>
									</div>
								</form>
								{{--*/
									\DB::setFetchMode(PDO::FETCH_ASSOC);
										$sts = \DB::table('add_friend')->select('status')
													->where('user_id',auth()->user()->id)
													->where('friend_id',$mem->id)
													->get();
									\DB::setFetchMode(PDO::FETCH_CLASS);
								/*--}}
								
								@if(empty($sts) || $sts[0]['status'] == 'Declined')
									<a href="#openRequestModal_{{$i}}"><i class="fa fa-user-plus" aria-hidden="true" style="margin-right: 10px;"></i>@lang('global.Add Friend')</a>
									<form method="post" action="{{lurl('add-friend')}}" class="add-friend-form">
										<div id="openRequestModal_{{$i}}" class="modalDialog">
											<div class="add-friend-popup">
												<a href="#close" title="Close" class="close">X</a>
												<h2>@lang('global.Add Friend')</h2>
												<label>@lang('global.Message') <small>@lang('global.(optional)')</small></label>
												<textarea name="message" class="friend-message-{{$i}}"></textarea>
												<button type="submit" onClick="return requestValidate({{$i}});">@lang('global.Send')</button>
												<a href="#close" class="cancel_btn">@lang('global.Cancel')</a>
												<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
												<input type="hidden" name="customer_id" id="customer_id" value="{{ $mem->id}}"/>
											</div>
										</div>
									</form>
								@elseif(!empty($sts) && $sts[0]['status'] == 'Send')
									<p style="font-size: 14px color: #337ab7;"><i class="fa fa-check" aria-hidden="true" style="margin-right: 10px;"></i>@lang('global.Request Send')</p>
								@endif
							</div>
						</div>
					{{--*/ $i++; /*--}}
					@endforeach
				@else
					<span> @lang('global.Check the spelling of their name or') <a href="">@lang('global.invite')</a> @lang('global.them to join Howlik.') </span>
				@endif
			</div>
			<div class="section_event_list">
				<div class="list-category">
					<div class="main_eveholder">
						<div class="img_eve">
						   <h4> @lang('global.Find Friends') </h4>
						   <p>@lang('global.Find out which friends are already on Howlik!')</p>
						   <p><a href="{{ lurl('/find_friends') }}"><button>@lang('global.Find Your Friends')</button></a></p>
						   <span><img src="{{ url('/assets/frontend/images/yahoo.png') }}" /><span>
						   <span><img src="{{ url('/assets/frontend/images/gmail.png') }}" /><span>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
</div>

<script>
	function messageValidate(a) {
		if($.trim($(".subject-send-"+a).val()) == "") {
			$(".subject-send-"+a).focus();
			return false;
		} else if($.trim($(".message-send-"+a).val()) == "") {
			$(".message-send-"+a).focus();
			return false;
		} else {
			$('#openMessageModal_'+a).modal('hide');
			return true;
		}
	}
	function requestValidate(b) {
		$('#openRequestModal_'+b).modal('hide');
		return true;
	}
</script>
@stop