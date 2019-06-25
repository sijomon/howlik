@extends('classified.layouts.layout')
<style>
	.search_friend a {
		width: 100%;
		float: left;
	}

	.search_friend {
		float: right;
		margin-top:-15px;
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
	.req-loc{
		float:left;
		margin-left:20px;
		width:50%;
	}
</style>
@section('content')
	<div class="listing_holder">
		<div class="container">
			<div class="Trending_section">
				<div class="listing_head"> </div>
			</div>
			<div class="event_holsection">
				@if(Session::has('flash_notification.message'))
					<div class="row">
						<div class="col-lg-12">
							@include('flash::message')
						</div>
					</div>
				@endif
				<div class="section_event_holder">
				@if(!empty($friend_request))  
					<h4 class="_TA_R">@lang('global.Friend Requests')</h4>
					@foreach($friend_request as $frnd_request)
						<form action="{{lurl('accept-friend')}}" method="post">
							<div class="list_event"> 
								@if($frnd_request->photo != '')
									<img style="height: 50px; border-radius: 50%;" src="{{ url('/uploads/pictures/dp/'.$frnd_request->photo) }}"/>
								@else
									<!-- <img style="height: 40px;" src="/assets/frontend/images/user_60_square.png"/> -->
									<img style="height: 50px; border-radius: 50%;" src="{{ url('/uploads/pictures/user-icon.png') }}"/>
								@endif
								<h4 style="text-indent: 20px;"><a href="{{ lurl('/profiles/'.$frnd_request->user_id) }}">{{$frnd_request->name}}</a></h4>
								<span class="req-loc">{{$frnd_request->asciiname}}</span>
								<div class="search_friend">
									<button type="submit" name="submit" value="1" class="btn btn-info">@lang('global.Accept')</button>
									<button type="submit" name="submit" value="0" class="btn btn-default">@lang('global.Decline')</button>
								</div>
								<input type="hidden" name="id" value="{{$frnd_request->id}}" />	
								<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />				
							</div>
						</form>
					@endforeach
				@else
					<h4>@lang('global.No New Friend Requests')</h4>
					<p>@lang('global.There are currently no pending friend requests.')</p>
					<a href="{{ lurl('/friends-lists/'.$user->id) }}" class="btn btn-default">@lang('global.View All Friends')</a>
				@endif				
				</div>
				<div class="section_event_list">
					<div class="list-category">
						<div class="main_eveholder">
							<div class="img_eve">
							   <h4 class="_TA_R"> @lang('global.Find Friends') </h4>
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
@stop