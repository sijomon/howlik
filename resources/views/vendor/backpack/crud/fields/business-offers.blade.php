
		{{--*/ $title = $business->title; /*--}}
	@if(strtolower($lang->get('abbr'))=='ar')
		{{--*/ $title = $business->title_ar; /*--}}
	@endif

			
	<!-- BOF Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog" style="width: 80%;">

			<div class="modal-content">
			
				<div class="modal-header">
					<h4 class="modal-title"> {{ $title }} </h4>
				</div>
				
				<div class="modal-body">
					<div class="col-md-12">
						@if(isset($offers) && !empty($offers))
							@foreach($offers as $offer)
							<div class="offer-list-card" style="margin-bottom: 15px;">
								<div id="triangle-topright"><span> {{t('Offers')}} </span></div>
								<div class="offer-list-card-title">
								
									<strong> @lang('global.Offer Type') : </strong>
									<span>  
										{{ $offertype[$offer->offertype] }}
									</span>
								</div>
								<div class="offer-list-card-content">
								
									<span> <strong> @lang('global.Offer Headline') : </strong> </span> </br>
									<span> {{ $offer->percent }} @if($offer->offertype != 3) @lang('global.% off') @endif {{ $offer->content }} </span> </br>
									
									@if($offer->details != '')
										<span> <strong> @lang('global.Optional Details') : </strong> </span> </br>
										<span> {{ $offer->details }} </span> </br>
									@endif
									
								</div> 
							 </div>
							@endforeach
						@else
							<h4> No Offers in this Package..! </h4>
						@endif
					</div>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{t('Close')}}</button>
				</div>
			</div>

		</div>
	</div>
	<!-- EOF Modal -->

