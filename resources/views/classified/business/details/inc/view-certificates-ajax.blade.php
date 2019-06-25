@if(isset($certificate) && count($certificate) > 0)				
{{--*/ $i = 0; /*--}}
@foreach($certificate as $key => $val)

<!-- Business URL setting -->

{{--*/ $bizUrl = lurl(slugify($business->title) . '/' . $val->biz_id . '.html'); /*--}}

<!-- Recipient Tab setting -->

{{--*/ $recipient = \App\Larapen\Models\GiftRecipient::where('gift_id', $val->id)->get(); /*--}}

{{--*/ $countRecipient = $recipient->count(); /*--}}

<!-- Picture setting -->

{{--*/ $bizImg = ''; /*--}}

{{--*/ $pictures = \App\Larapen\Models\BusinessImage::where('biz_id', $val->biz_id); /*--}}

{{--*/ $countPictures = $pictures->count(); /*--}}

@if ($countPictures > 0)

	@if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename))

		{{--*/ $bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename); /*--}}

	@endif

	@if ($bizImg=='')

		@if (is_file(public_path() . '/'. $pictures->first()->filename))

			{{--*/ $bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename); /*--}}

		@endif

	@endif

@endif

<!-- Default picture -->

@if ($bizImg=='')

	{{--*/ $bizImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture')); /*--}}

@endif

<div class="col-sm-3">
	<div class="eo-box">
		<div class="eo-box-title">
			<h2><a href="{{ $bizUrl }}" title="{{ $business->title }}">{{ $business->title }}</a></h2>
		</div>
		<div class="eo-box-content">
			<p> {{ date("h:i A", strtotime($val->created_at)) }} </p>
			<p> {{ date("m/d/Y", strtotime($val->created_at)) }} </p>
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
				<button class="btn eo-close" data-dismiss="modal">&times;</button>
				<div class="eobox-top">
					<div class="left-box">
						<img src="{{ url($bizImg) }}" alt="No Img">
					</div>
					<div class="right-box">
					
						<h2> {{ $business->title }} </h2>
						
						<p> {{ date("h:i A", strtotime($val->created_at)) }} </p>
						
						<p> {{ date("m/d/Y", strtotime($val->created_at)) }} </p>
						
						<h5> {{ $val->total_quantity }} @if($val->total_quantity > 1) @lang('global.Recipients') @else  @lang('global.Recipient') @endif </h5>
						
						<h4> @if(isset($business->currency) && $business->currency != '') {{ $business->currency }} @endif {{ $val->total_price }} </h4>
						
					</div>
				</div>
			
				@if ($countRecipient > 0)
				<div class="eobox-bottom">
					<div class="col-md-12">
						@foreach($recipient as $key1 => $val1)
							
							<div class="col-sm-6">
								<div class="eobox-bottom-div">
									<p> <span> @lang('global.Sender') : </span> <span class="pull-right"><b> {{ $val1->sender_name }} </b></span></p>
									
									<p> <span> @lang('global.Recipient') : </span> <span class="pull-right"><b> {{ $val1->recipient_name }} </b></span> </p>
									
									<p> <span> @lang('global.Gift Code') : </span> <span class="pull-right"><b> {{ $val1->gift_code }} </b></span></p>
									
									<p> <span> @lang('global.Price') : </span> <span class="pull-right"><b> @if(isset($business->currency) && $business->currency != '') {{ $business->currency }} @endif {{ $val->each_price }} </b></span></p>
								</div>
							</div>
							
						@endforeach
					</div>
				</div>
				@endif
			
			</div>
		</div>
		<!-- EOF CONTENT -->
	</div>
</div>
<!-- EOF MODAL -->

{{--*/ $i++; /*--}}								
@endforeach

<div style="float: left; width: 100%;"> {{ $certificate->links() }} </div>

@else
<div class="alert alert-info">
  <h5><strong> @lang('global.No Data Found!') </strong></h5>
</div>
@endif