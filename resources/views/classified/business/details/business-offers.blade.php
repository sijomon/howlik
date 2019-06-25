@extends('backpack::offer_layout')

@section('content')
	<style>
		.offer-list-card{
			width:100%;
			height:100px;
			float:left;
			background:#fff;
			border:1px solid #ccc;
			box-shadow:0 0 1px #ccc;
			position:relative;
		}
		.offer-list-card-title{
			padding:10px;
			background:#f6f6f6;
		}
		.offer-list-card-content{
			padding:10px
		}

		#triangle-topright {
			width: 0;
			height: 0;
			border-top: 50px solid #0ebc67;
			border-left: 50px solid transparent;
			right:0;
			position:relative;
			float:right;
		}
		#triangle-topright span{
			position: absolute;
			color: #fff;
			z-index: 10;
			top: 0;
			margin-top: -40px;
			transform: rotate(45deg);
			margin-left: -30px;
			font-size: 12px;
		}
		.offer-list-card-content span a{
			text-decoration:none;
			color:#000 !important;
			transition:all ease-out .5s;
		}

		.offer-right-list{
			background:#f6f6f6;
			border:#ccc;
			width:100%;
			height:auto;
			float:left;
		}
		.offer-right-list-header{
			padding:5px;
			background:#0ebc67;
			font-size:14px;
			text-align:center;
			color:#FFF;
			font-weight:bold;
			text-transform:uppercase;
		}
		.offer-right-list-content{
			width:100%;
			float:left;
			position:relative;
			height:auto;
			padding:10px 5px;
		}
		.offer-right-list-content .u-row{
			border-bottom:1px solid #999;
			width:100%;
			float:left;
			padding-bottom:10px;
			background:#FFF;
			padding:5px;
			margin-bottom:8px;
		}
		.offer-right-list-content .title{
			width:100%;
			font-size:14px;
			font-weight:600;
		}
		.offer-right-list-content .flat-left{
			float:left;
			font-size:35px;
			color: #0ebc67;
		}
		.offer-right-list-content .flat-right{
			float:left;
			font-size:14px;
			color: #666;
			margin:16px; 
		}
		.offer-right-list-content .flat-rotate{
			float:left;
			transform: rotate(-90deg);
			margin-top: 15px;
			text-transform: uppercase; 
			color:#000;
		}
		.detail-offer{
			background:#FFF;
			margin-bottom:20px;
			padding:10px;
			border:1px solid #ccc;
		}
		.offer-left-box{
			width:40%;
			float:left;
		}

		.offer-right-box{
			width:60%;
			float:left;
		}
	</style>
	
		{{--*/ $title = $business->title; /*--}}
	@if(strtolower($lang->get('abbr'))=='ar')
		{{--*/ $title = $business->title_ar; /*--}}
	@endif

	<!--- BOF CONTENTS --->
	<div class="content-holder">
		<!--- BOF CONTAINER --->
		<div class="container"> 
		  
			<!--- BOF Listing --->
			<div class="col-md-8 col-sm-8">
			
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
			
			<!--- EOF Listing ---> 
			</div>

		</div>
		<!--- EOF CONTAINER ---> 
	</div>
	<!--- EOF CONTENTS ---> 

@stop

