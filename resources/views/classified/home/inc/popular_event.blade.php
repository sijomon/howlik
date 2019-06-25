<!-- BOF PAGINATION PAGE -->
{{--*/ $pos= 0; /*--}}
@if(!empty($pop_events))
	@foreach($pop_events as $key => $events) 
		{{--*/ $pos = $pos + 1 ; /*--}} 
		<div class="offer_holder">
			<div class="top_con">
				<p style="margin-bottom: 15px; margin-top: 15px;">{{ ucwords($events->event_name) }}</p>
			</div>
			<a href="{{ lurl('/preview/event/'.$events->id) }}">
			<div class="hovereffect"> 
				@if($events->event_image1 != '')
					<img src="{{ url($events->event_image1) }}" pagespeed_url_hash="2541112653" onload="pagespeed.CriticalImages.checkImageForCriticality(this);" alt=""/>
				@else
					<img src="{{ url('/uploads/pictures/no-image.jpg') }}" pagespeed_url_hash="2541112653" onload="pagespeed.CriticalImages.checkImageForCriticality(this);" alt=""/>
				@endif
				<div class="overlay">
					<h2 > {{ date('F d', strtotime($events->event_date)) }} </h2>
					<p style="text-align: center; margin-bottom: 5px; margin-top: 5px;"><b> {{ date('h : i A', strtotime($events->event_starttime)) }} </b></p>
					<p style="text-align: center; margin-bottom: 10px; margin-top: 10px;">
					@if(isset($lang) && strtolower($lang->get('abbr'))=='ar')
						{{ $events->cname  }}
					@else
						{{ $events->asciiname }}
					@endif
					</p>
				</div>
			</div>
			</a>
			<div class="bottom_con"></div>
		</div>
	@endforeach
@endif
<!-- EOF PAGINATION PAGE -->

<!-- BOF PAGINATION LINK -->
<div class="col-md-12 pagination-bar text-center pagination-div" id="popular">
	{!! $pop_events->appends(Request::except('page'))->render() !!}
</div>
<!-- EOF PAGINATION LINK -->