@extends('classified.layouts.layout')

@section('content')

	<!-- BOF INTERNAL STYLE -->
	<style>
		
	</style>
	<!-- BOF INTERNAL STYLE -->
	
	<!-- BOF MAIN CONTENT -->
	<div class="content-holder">
		<div class="container">
			<div class="event-desc-holder">
				@if($event->event_image1 != '')
					<img src="{{ url($event->event_image1) }}" alt="" />
				@else
					<img src="{{ url('/uploads/pictures/no-image-cover.jpg') }}" alt="" />
				@endif
				<!-- BOF SHARE AN EVENT -->
				<div class="event-share-wrapper">
					@if($event->social_share == 1 && Request::segment(3) != 'private')<a class="share-event-box" data-toggle="modal" data-target=".event-share-modal-md"><span class="fa fa-share-square-o"></span></a>@endif
				</div>
				<!-- EOF SHARE AN EVENT -->
				<div class="left-detail-overlay">
				
					<!-- <div id="triangle-bottomleft"> <span class=""> Free </span></div>-->
					<h5> <span> {{ date('d',strtotime($event->event_date)) }} </span> {{ date('F',strtotime($event->event_date)) }} </h5>
					<h1> @if($event->event_name != '') {{ ucfirst($event->event_name) }} @endif </h1>
					<!-- <h3> <span style="font-size: 12px;"> @lang('global.By') </span> @if($event->organization != '') {{ $event->organization }} @endif </h3> -->
					<h4> @if(isset($expiry) && count($expiry) > 0 && $event->ticket_type == 2) <span> @if($event->currency != '') {{ $event->currency }} @endif </span> {{--*/ $price = unserialize($event->ticket_details); /*--}} {{ $price['price'] }} @endif </h5>
					<?php /*
					@if(isset($user->id))
					*/ ?>
						@if(isset($expiry) && count($expiry) > 0)
							@if($event->ticket_type > 0)
								{{--*/ $value	= unserialize($event->ticket_details); /*--}}
								@if(isset($event->decrement) && $event->decrement != '')
									{{--*/ $tckts = $value['tickets'] - $event->decrement; /*--}}
									@if($tckts == 0) 
										<a style="background: #e40046 none repeat scroll 0 0;"> <i class="fa fa-ticket"></i>&nbsp; @lang('global.Sold Out') </a>
									@else
										<a href="{{ lurl('/buy/tickets/'.$event->id) }}"><i class="fa fa-ticket"></i>&nbsp; @lang('global.Buy Tickets') </a>
									@endif
								@else
									<a href="{{ lurl('/buy/tickets/'.$event->id) }}"><i class="fa fa-ticket"></i>&nbsp; @lang('global.Buy Tickets') </a>
								@endif
							@else
								<a> <i class="fa fa-ticket"></i>&nbsp; @lang('global.Free Pass') </a>
							@endif
						@else
							<a style="background: #e40046 none repeat scroll 0 0;"> <i class="fa fa-ticket"></i>&nbsp; @lang('global.Expired') </a>
						@endif
					<?php /*
					@elseif($event->ticket_type > 0)
						<a style="background: #e40000 none repeat scroll 0 0;"> <i class="fa fa-ticket"></i>&nbsp; @lang('global.Login Now!') </a>
					@else
						<a> <i class="fa fa-ticket"></i>&nbsp; @lang('global.Free Pass') </a>
					@endif
					*/ ?>
				</div>
			</div>
			<div class="event-desc-holder-botoom">
				<div class="col-md-8 event-left-box">
				
					@if($event->about_event != '')
						<div class="event-row">
							<h3 class="event-title"> @lang('global.Description') </h3>
							<h2 class="event-subtitle"> 
								<!-- @lang('global.A') @if(isset($event->event_type_name) && $event->event_type_name != '') {{ $event->event_type_name }} @else event @endif @lang('global.running until') {{ date('l j F Y',strtotime($event->event_date)) }}. -->
								@lang('global.An event') @lang('global.running until') {{ date('l j F Y',strtotime($event->event_date)) }}. 
							</h2>
							<p> {{ $event->about_event }} </p>
						</div>
					@endif
					
					<!-- Direction -->
					<div class="event-row">
						<h3 class="event-title"> @lang('global.Direction') </h3>
						<iframe width="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{$event->latitude}},{{$event->longitude}}&amp;key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></iframe>
					</div>
					
					@if(count($event->event_image1) >1 )
						<div class="event-row">
							<h3 class="event-title"> @lang('global.More Images') </h3>
							<div class="col-md-6">
								<div class="row">
									<img src="{{ url($event->event_image1) }}" class="event-more-images">
								</div>
							</div>
							<div class="col-md-6">
								<div class="row">
									<img src="{{ url($event->event_image1) }}" class="event-more-images">
								</div>
							</div>
						</div>
					@endif
					
				</div>
			
				<!-- BOF RIGHT INFO BOX -->
				<div class="col-md-4 event-right-box">
					<div class="event-right-info-box">
						<div class="event-row-right">
							<h3 class="event-title">  @lang('global.Date And Time') </h3>
							<div class="event-rightbox-padd">
								<h6> 
									@if($event->event_date == $event->eventEnd_date)
										{{ date('F d l',strtotime($event->event_date)) }} 
									@else
										@if(date('F',strtotime($event->event_date)) == date('F',strtotime($event->eventEnd_date)))
											{{ date('F d l',strtotime($event->event_date)) }} <b> - </b> {{ date('d l',strtotime($event->eventEnd_date)) }} 
										@else
											{{ date('F d l',strtotime($event->event_date)) }} <b> - </b> {{ date('F d l',strtotime($event->eventEnd_date)) }}
										@endif										
									@endif
								</h6>
								<h6> {{ date('h:i A',strtotime($event->event_starttime)) }} <b> - </b> {{ date('h:i A',strtotime($event->event_endtime)) }} </h6>
								<!-- <h6> {{ date('F d l',strtotime($event->event_date)) }} </h6>
								<h6> {{ date('h:i A',strtotime($event->event_starttime)) }} </h6> -->
							</div>
						</div>
						<div class="event-row-right">
							<h3 class="event-title"> @lang('global.Location') </h3>
							<div class="event-rightbox-padd">
								<h6>  @if(isset($event->city_name) && $event->city_name != '') {{ $event->city_name }} , @endif @if(isset($event->location_name) && $event->location_name != '') {{ $event->location_name }} @endif</h6>
							</div>
						</div>
					</div>
				</div>
				<!-- EOF RIGHT INFO BOX -->
			</div>
		</div> 
	</div> 
	<!-- EOF MAIN CONTENT -->
	
	<!-- BOF SOCIAL SHARE MODAL -->
	<div class="modal fade event-share-modal-md" tabindex="-1" role="dialog" aria-labelledby="myEventShareModalLabel" aria-hidden="true" style="margin-top:15%">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">
					<div id="shareitems" style="text-align: center"> </div>
				</div>
			</div>
		</div>
	</div>
	<!-- EOF SOCIAL SHARE MODAL -->
	
@endsection

@section('javascript')
	<script type="text/javascript">
		$(document).ready(function() {
			$("#shareitems").jsSocials({
				shareIn: "popup",
				showLabel: false,
				showCount: false,
				shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest"],
			});
		});
	</script>
@endsection
