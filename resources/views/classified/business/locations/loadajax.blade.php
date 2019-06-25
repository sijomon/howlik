<!-- BOF LOCATION LISTING -->
@if(isset($location) && count($location) > 0)
	@foreach($location as $loc)
	<div class="col-sm-6" id="loc-{{$loc->id}}">
		<div class="eo-box">
			<div class="eo-box-title loc-box-title">
				<h2> 
					@if(Request::segment(1) == 'ar')
						{{ $loc->ciname }}
					@else
						{{ $loc->ciasciiname }}
					@endif
					@if($loc->base == 0) <a onclick="return dropLocation({{$loc->id}});" class="loc-opt-btn btn_dlt"><i class="fa fa-trash"></i></a> @endif
					<a href="{{ lurl('account/business/location/update/'.$loc->id) }}" class="loc-opt-btn btn_edit"><i class="fa fa-pencil"></i></a>
					<br>
					<span class="loc-box-sub-title">
						@if(Request::segment(1) == 'ar')
							{{ $loc->loname }}, &nbsp;{{ $loc->coname }} - {{ $loc->zip }}
						@else
							{{ $loc->loasciiname }}, &nbsp;{{ $loc->coasciiname }} @if($loc->zip != '')- {{ $loc->zip }}@endif
						@endif
					</span>
				</h2>
			</div>
			<div class="eo-box-content loc-box">
				<iframe frameborder="0" style="border:0; float:left;" src="https://www.google.com/maps/embed/v1/place?q={{$loc->lat}},{{$loc->lon}}&amp;key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></iframe>
			</div>
		</div>
	</div>
	@endforeach
@endif
<!-- EOF LOCATION LISTING -->

<!-- BOF PAGINATION LINK -->
<div class="col-lg-12 pagination-bar text-center">
	{!! $location->appends(Request::except('page'))->render() !!}
</div>
<!-- EOF PAGINATION LINK -->