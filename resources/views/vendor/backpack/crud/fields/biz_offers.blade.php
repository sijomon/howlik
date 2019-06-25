@if(Request::segment('2') != 'create')
<style>
	.offer-list-card{
		width:100%;
		float:left;
		background:#fff;
		border:1px solid #ccc;
		box-shadow:0 0 1px #ccc;
		position:relative;
		z-index: 100;
	}
	.offer-list-card-title{
		padding:10px;
		background:#fff;
	}
	.offer-list-card-content{
		padding:10px
	}
	.offer-list-card-content ul{
		list-style-type:none;
	}
	.offer-list-card-content ul li{
		margin:10px 10px 0;
	}
	.form-control {
		
		margin-top: 5px;
		display: inline;
	}
	.offer-left-box {
		
		width: 40%;
		float: left;
	}
	.offer-right-box {
		
		width: 60%;
		float: left;
	}
	.modal-label{
		display: block !important; 
		float: left !important; 
		width: 100% !important; 
		text-align: left !important;
	}
	#offer-percent-error {
		float: left !important; 
		width: 100% !important; 
		text-align: left !important;
		color: red; 
		margin-top: 5px;
	}
</style>
<div class="info"></br>

	<label>{{ $field['label'] }}</label></br></br>
	
	{{--*/ 	$biz_id		=	''; /*--}}
	@if(isset($field['value']) && $field['value']!='')
		{{--*/ 	$biz_id		=	$field['value']; /*--}}
		
		{{--*/ 	$business 	= 	\DB::table('business')->select('currencies.html_entity as currency')
								->join('countries','countries.code','=','business.country_code')
								->join('currencies','currencies.code','=','countries.currency_code')
								->where('business.id', $biz_id)
								->first(); /*--}}	
	@endif		
	{{--*/ 	$offers	  	= 	\DB::table('businessOffers')->select('id','offertype', 'percent', 'content', 'details')->where('biz_id', $biz_id)->where('active', 1)->orderBy('created_at', 'DESC')->get(); /*--}}	

	{{--*/ 	$offertype	= 	\DB::table('offer_type')->where('translation_lang', 'en')->where('active', 1)->lists('title','translation_of'); /*--}}	
	
	@if(!empty($offers))
		<div>
			<div class="alert alert-success" id="success-alert-msg" style="display: none">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<strong> @lang('global.Deleted!') </strong> 
			</div>
			<div class="alert alert-danger" id="danger-alert-msg" style="display: none">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<strong> @lang('global.Error!') </strong>
			</div>	
			@foreach($offers as $offer)
			<div class="offer-list-card" style="margin-bottom: 15px;" id="off-{{$offer->id}}">
				<div class="offer-list-card-title">
					<span> @lang('global.Offer Type') : </span>
					<span> <strong> {{ $offertype[$offer->offertype] }} </strong> </span>
				</div>
				<div class="offer-list-card-content">
					<span> @lang('global.Offer Headline') : </span>
					<span> <strong> @if( isset($business->currency) && $offer->offertype == 2 || $offer->offertype == 4) {{ $business->currency }} @endif {{ $offer->percent }} @if($offer->offertype == 1) @lang('global.% off') @elseif($offer->offertype == 2) @lang('global.off') @elseif($offer->offertype == 3) @lang('global.free') @elseif($offer->offertype == 4) @lang('global.for') @endif {{ $offer->content }} </strong> </span>
						
					<span class="pull-right itemoffer">
						<a id="edit-offer-{{ $offer->id }}" class="btn btn-xs btn-default" onClick="return editChange({{ $offer->id }})" data-toggle="modal" data-target="#editModal{{ $offer->id }}"><i class="fa fa-edit"></i></a>
						<a id="drop-offer-{{ $offer->id }}" class="btn btn-xs btn-danger" onClick="return dropOffer({{ $offer->id }})"><i class="fa fa-trash"></i></a>
					</span>
				</div> 
			</div>
			@endforeach
			<div class="offer-list-load-ajax"></div>
		</div>
		<div style="display: block; z-index: 100;"> <a id="more-offer" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#moreModal"><span class="fa fa-plus"></span> @lang('global.Add More Offers') </a> </div>
	@else
		<div class="offer-list-load-ajax"></div>
		<div> <a id="more-offer" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#moreModal"><span class="fa fa-plus"></span> @lang('global.Add Offers') </a> </div></br>
	@endif
</div>	

<!-- BOF CREATE MODAL -->
<div class="modal fade" id="moreModal" tabindex="-1" role="dialog" aria-labelledby="moreModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" id="moreModalLabel"> @lang('global.Create New Offer') </h3>
				<span id="currency" style="display: none"> @if(isset($business->currency)) {{ $business->currency }} @endif</span>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" id="success-alert" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Created!') </strong>
				</div>
				<div class="alert alert-danger" id="danger-alert" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Error!') </strong>
				</div>
				<form role="form" id="add-offer-info">
					<input type="hidden" name="biz_id" id="biz-id" value="{{ $biz_id }}">
					<div class="form-group">
						<label class="control-label modal-label"> @lang('global.Offer Type') </label>
						<select name="offer_type" id="offer-type" class="form-control offer-type">
							<option selected="selected" value="0">{{ t('- - select one type - -') }}</option>
							@if(!empty($offertype))
								@foreach($offertype as $key => $title)
									<option value="{{ $key }}">{{ $title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group" id="offer-headline" style="display: none;">
						<label class="control-label modal-label"> @lang('global.Offer Headline') </label>
						<div id="headline-content">
							<span style="float:left; margin: 10px 3px; display: inline-block" id="left_span"> </span>
							<input type="text" name="offer_percent" id="offer-percent" class="form-control" style="width: 20%; float:left;" placeholder="{{ t('Amount')}}" /> 
							<span style="float:left; margin:10px 3px; display: inline-block" id="right_span">  </span>
							<input type="text" name="offer_content" id="offer-content" class="form-control" style="width: 70%; float:left;" placeholder="{{ t('Description')}}" /> 
							<span id="offer-percent-error" style="display: none;"> @lang('global.Numbers Only.') </span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label modal-label" style="margin-top: 10px !important;"> @lang('global.Offer Details ( optional )') </label>
						{{ Form::textarea('offer_details', null, ['size' => '30x5','class' => 'form-control', 'id' => 'offer-details']) }}
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="button-cancel">{{ t('Cancel') }}</button>
				<button type="button" class="btn btn-primary" id="more-submit">{{ t('Create') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- EOF CREATE MODAL -->

@if(!empty($offers))
@foreach($offers as $offerr)
<!-- BOF UPDATE MODAL -->
<div class="modal fade" id="editModal{{ $offerr->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" id="editModalLabel"> @lang('global.Update Offer Info') </h3>
				<span id="currency" style="display: none"> @if(isset($business)){{ $business->currency }}@endif </span>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" id="success-alert-{{ $offerr->id }}" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Updated!') </strong>
				</div>
				<div class="alert alert-danger" id="danger-alert-{{ $offerr->id }}" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Error!') </strong>
				</div>
				<form role="form" id="add-offer-info">
					<input type="hidden" name="biz_id" id="biz-id" value="{{ $biz_id }}">
					<div class="form-group">
						<label class="control-label modal-label"> @lang('global.Offer Type') </label>
						<select name="offer_type" id="offer-type-{{ $offerr->id }}" class="form-control offer-type-update">
							<option selected="selected" value="0">{{ t('- - select one type - -') }}</option>
							@if(!empty($offertype))
								@foreach($offertype as $key => $title)
									@if($offerr->offertype == $key)
										{{--*/ $slct= "selected"; /*--}}
									@else
										{{--*/ $slct= ""; /*--}}
									@endif
									<option {{ $slct }} value="{{ $key }}">{{ $title }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group" id="offer-headline-{{ $offerr->id }}">
						<label class="control-label modal-label"> @lang('global.Offer Headline') </label>
						<div id="headline-content">
							<span style="float:left; margin: 10px 3px; display: inline-block" id="left-span-{{ $offerr->id }}"> </span>
							<input type="text" name="offer_percent" id="offer-percent-{{ $offerr->id }}" value="{{ $offerr->percent }}" class="form-control" style="width: 20%; float:left;" placeholder="{{ t('Amount')}}" /> 
							<span style="float:left; margin:10px 3px; display: inline-block" id="right-span-{{ $offerr->id }}"> </span>
							<input type="text" name="offer_content" id="offer-content-{{ $offerr->id }}" value="{{ $offerr->content }}" class="form-control" style="width: 70%; float:left;" placeholder="{{ t('Description')}}" /> 
							<span id="offer-percent-error-{{ $offerr->id }}" style="margin-top: 5px; float: left !important; width: 100% !important; color: red; text-align: left !important; display: none;"> @lang('global.Numbers Only.') </span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label modal-label" style="margin-top: 10px !important;"> @lang('global.Offer Details ( optional )') </label>
						{{ Form::textarea('offer_details', $offerr->details, ['size' => '30x5','class' => 'form-control', 'id' => 'offer-details-'.$offerr->id]) }}
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ t('Cancel') }}</button>
				<button type="button" class="btn btn-primary edit-submit" value="{{ $offerr->id }}" id="edit-submit">{{ t('Update') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- EOF UPDATE MODAL -->
@endforeach
@endif
@endif
