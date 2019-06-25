@if(isset($tickets) && count($tickets) > 0)
							
{{--*/ $i = 0; /*--}}
@foreach($tickets as $key => $val)

{{--*/ $dateSt		= strtotime($val->event_date); /*--}}

{{--*/ $dateEd		= strtotime($val->eventEnd_date); /*--}}

{{--*/ $timeSt		= strtotime($val->event_starttime); /*--}}

{{--*/ $timeEd		= strtotime($val->event_endtime); /*--}}

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
			<h2><a href="{{ lurl('preview/event/'.$val->event_id) }}" title="{{ $val->event_name }}"> {{ $val->event_name }} </a></h2>
		</div>
		<div class="eo-box-content">
			<p> {{ $timeStDate }} - {{ $timeEdDate  }} </p>
			<p> {{ $dateStDate }} </p>
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
				<button type="button" class="btn eo-close" data-dismiss="modal">&times;</button>
				<div class="left-box">
					<img src="{{ url($val->event_image1) }}" alt="No Img">
				</div>
				<div class="right-box">
				
					<h2> {{ $val->event_name }} </h2>
					
					<p> {{ $timeStDate }} - {{ $timeEdDate  }} </p>
					
					<p> @if($dateSt == $dateEd) {{ $dateStDate }} @else {{ $dateStDate }} - {{ $dateEdDate  }} @endif </p>
				
					<h5> {{ $quant }} <span> @lang('global.Tickets') </span> </h5>
				
					@if($price != 0 ) <h4> @if(isset($tickets->currency) && $tickets->currency != '') {{ $tickets->currency }} @endif {{ $price }} </h4> @endif
					
				</div>
			</div>
		</div>
		<!-- EOF CONTENT -->
	</div>
</div>
<!-- EOF MODAL -->

{{--*/ $i++; /*--}}	@endforeach

<div style="float: left; width: 100%;"> {{ $tickets->links() }} </div>

@else
<div class="alert alert-danger">
  <h5><strong> @lang('global.Empty!') </strong></h5>
</div>
@endif