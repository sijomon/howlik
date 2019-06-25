@if(isset($tickets) && count($tickets) > 0)
{{--*/ $i = 0; /*--}}
@foreach($tickets as $key => $val)

{{--*/ $dateSt		= strtotime($event->event_date); /*--}}

{{--*/ $dateEd		= strtotime($event->eventEnd_date); /*--}}

{{--*/ $timeSt		= strtotime($event->event_starttime); /*--}}

{{--*/ $timeEd		= strtotime($event->event_endtime); /*--}}

{{--*/ $dateStDate	= date("m/d/Y", $dateSt); /*--}}

{{--*/ $dateEdDate	= date("m/d/Y", $dateEd); /*--}}

{{--*/ $timeStDate	= date("h:i A", $timeSt); /*--}}

{{--*/ $timeEdDate	= date("h:i A", $timeEd); /*--}}

{{--*/ $day		= strtotime($val->created_at); /*--}}

{{--*/ $date	= date("m/d/Y", $day); /*--}}

{{--*/ $time	= date("h:i A", $day); /*--}}

{{--*/ $quant	= $val->ticket_quantity; /*--}}

{{--*/ $price	= $val->total_amount; /*--}}

<div class="col-sm-3">
	<div class="eo-box">
		<div class="eo-box-title">
			<h2><a href="{{ lurl('preview/event/'.$event->id) }}" title="{{ $event->event_name }}"> {{ $event->event_name }} </a></h2>
		</div>
		<div class="eo-box-content">
			<p> {{ $timeStDate }} - {{ $timeEdDate  }} </p>
			
			<p> {{ $dateStDate }} </p>
			
			<p> {{ $val->name }} </p>
			
			<a href="#" data-toggle="modal" data-target="#eo-modal_{{ $i }}"><button class="btn btn-oprtn" onclick="getMore({{ $i }})"> @lang('global.More') </button> </a>
		
		</div>
	</div>
</div>

<!-- BOF MODAL -->
<div id="eo-modal_{{ $i }}" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- BOF CONTENT -->
		<div class="modal-content">
			<div class="eo-modal-box">
				<button type="button" class="eo-close" data-dismiss="modal">&times;</button>
				<div class="left-box">
					<img src="{{ url($event->event_image1) }}" alt="No Img">
				</div>
				<div class="right-box">
				
					<h2> {{ $event->event_name }} </h2>
					
					<p> {{ $timeStDate }} - {{ $timeEdDate  }} </p>
					
					<p> @if($dateSt == $dateEd) {{ $dateStDate }} @else {{ $dateStDate }} - {{ $dateEdDate  }} @endif </p>
				
					<h4> {{ $val->name }} </h4>
				
					<h5> {{ $quant }} @lang('global.Tickets') </h5>
				
					@if($price != 0 ) <h5> {{ $event->currency }} {{ $price }} </h5> @endif
					
				</div>
			</div>
		</div>
		<!-- EOF CONTENT -->
	</div>
</div>
<!-- EOF MODAL -->

{{--*/ $i++; /*--}}	
@endforeach

<div style="float: left; width: 100%;"> {{ $tickets->links() }} </div>

@endif