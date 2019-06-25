@extends('classified.layouts.layout')

@section('javascript-top')
	@parent
@endsection
<style>
	
	.form-control {
		
		margin-top: 5px;
		display: inline;
	}
	
	.sideInfo {
		
		border: 1px solid #E4E4E4;
		border-radius: 10px 10px 10px 10px;
		height: 60%;
	}

</style>
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (count($errors) > 0)
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<!--*/ BOF page-sidebar /*-->
				<?php  if ($user->user_type_id  == 3) { ?>
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--*/ EOF page-sidebar /*-->

				<!--*/ BOF page-content /*-->
				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> @lang('global.Update Offer Info') </strong></h2>
						<div class="row">
							<div class="col-sm-12">

								<!--*/ BOF Left Content /*-->
								<div class="col-md-7">
									<form class="form-horizontal" id="updateOfferInfo" method="POST" action="{{ lurl('account/update-offer-post') }}">
										{!! csrf_field() !!}
										<fieldset>
											
											<input type="hidden" name="off_id" id="off_id" value="{{ $offers->id }}">
											<input type="hidden" name="biz_id" id="biz_id" value="{{ $offers->biz_id }}">
											
											<!-- Offer Type -->
											<div class="form-group" >
												<label class="control-label"> @lang('global.Offer Type') </label>
												{!! Form::select('offer_type',(['' => t('- - select one type - -')] +$offertype->toArray()), $offers->offertype, array('class' => 'form-control','id' => 'offer_type','required' => '')) !!}
											</div>
											
											<!-- Offer Headline -->
											<div class="form-group" id="headline_div">
												<label class="control-label" style="display: block; float:left; width:100%; text-align:left"> @lang('global.Offer Headline') </label>
												<span style="float:left; margin: 10px 3px;" id="left_span"> </span>
												<input type="text" name="offer_percent" value="{{ $offers->percent }}" class="form-control" style="width: 20%; float:left;" placeholder="{{ t('Amount')}}" required="" /> 
												<span style="float:left; margin:10px 3px" id="right_span">  </span>
												<input type="text" name="offer_content" value="{{ $offers->content }}" class="form-control" style="width: 70%; float:left;" placeholder="{{ t('Description')}}" required="" /> 
											</div>
											
											<!-- Offer Optional Details -->
											<div class="form-group" >
												<label class="control-label"> @lang('global.Offer Details ( optional )') </label>
												{{ Form::textarea('offer_details', $offers->details, ['size' => '30x5','class' => 'form-control']) }}
											</div>

											<!-- Button  -->
											<div class="form-group">
												<div class="col-md-offset-7 col-md-5 pull-right">
													<a href="{{lurl('account/bizinfo/'.$offers->biz_id)}}"><span id="backBizBtn" class="btn btn-default btn-md"> {{ t('Cancel') }} </span></a>
													<button id="updateBizBtn" class="btn btn-success btn-md"> {{ t('Update') }} </button>
												</div>
											</div>

										</fieldset>
									</form>
								</div>
								<!--*/ EOF Left Content /*-->
								
								<!--*/ BOF Right Content /*-->
								<div class="col-md-5"> 
								
									<div class="col-md-12">
                                    	<div class="offer-right-list">
                                    	
                                            <div class="offer-right-list-header">
                                                <h5> @lang('global.Sample Offer') </h5>
                                            </div>
                                            
                                            <div class="offer-right-list-content">
												
												<div class="u-row">
													<h6 class="title"> @lang('global.Percent Off') </h6>
													<span class="flat-rotate"> &nbsp; </span>
													<span class="flat-left"> @lang('global.20 %') </span>
													<span class="flat-right"> @lang('global.off your order') </span>
												</div>
												
												<div class="u-row">
													<h6 class="title"> @lang('global.Price Off') </h6>
													<span class="flat-rotate"> &nbsp; </span>
													<span class="flat-left"> @if(isset($offers->currency) && $offers->currency != '') <span id="currency"> {{ $offers->currency }} </span> @endif @lang('global.20') </span>
													<span class="flat-right"> @lang('global.off any service') </span>
												</div>
												
												<div class="u-row">
													<h6 class="title"> @lang('global.Free Offer') </h6>
													<div>
														<span class="flat-rotate"> &nbsp; </span>
														<span class="flat-left"> @lang('global.1') </span>
													</div>
													<div>
														<span class="flat-right"> @lang('global.free gift voucher') </span>
													</div>
												</div>
												
												<div class="u-row">
													<h6 class="title"> @lang('global.Fixed Price') </h6>
													<div>
														<span class="flat-rotate"> &nbsp; </span>
														<span class="flat-left"> @if(isset($offers->currency) && $offers->currency != '') <span id="currency"> {{ $offers->currency }} </span> @endif @lang('global.25') </span>
													</div>
													<div>
														<span class="flat-right"> @lang('global.for our price menu') </span>
													</div>
													 
													
												</div>
												
                                            </div>
                                            
                                            
                                        </div>
                                    </div>
								
								</div>
								<!--*/ EOF Right Content /*-->
								
							</div>
						</div>
					</div>
				</div>
				<!--*/ EOF page-content /*-->

			</div>
		</div>
	</div>
@endsection

@section('javascript')

	@parent
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></script>
	<script src="{{ url('/assets/js/fileinput.min.js') }}" type="text/javascript"></script>
	
	<script type="text/javascript">
	
		$(document).ready(function(){
			
			$('#offer_type').change(function(){
				
				if($('#offer_type option:selected').val()== 1)
				{
					$("#headline_div").show();
					
					$("#left_span").html("");
					$("#right_span").html("% off");
					
					$("#offer_percent").removeAttr("disabled", "disabled");
					$("#offer_content").removeAttr("disabled", "disabled");
				}
				else if($('#offer_type option:selected').val()== 2)
				{
					$("#headline_div").show();
					
					$("#left_span").html($("#currency").html());
					$("#right_span").html("off");
					
					$("#offer_percent").removeAttr("disabled", "disabled");
					$("#offer_content").removeAttr("disabled", "disabled");
				}
				else if($('#offer_type option:selected').val()== 3)
				{
					$("#headline_div").show();
					
					$("#left_span").html("");
					$("#right_span").html("free");
					
					$("#offer_percent").removeAttr("disabled", "disabled");
					$("#offer_content").removeAttr("disabled", "disabled");
				}
				else if($('#offer_type option:selected').val()== 4)
				{
					$("#headline_div").show();
					
					$("#left_span").html($("#currency").html());
					$("#right_span").html("for");
					
					$("#offer_percent").removeAttr("disabled", "disabled");
					$("#offer_content").removeAttr("disabled", "disabled");
				}
				else
				{
					$("#headline_div").hide();
					
					$("#left_span").html("");
					$("#left_span").html("");
					$("#right_span").html("");
					
					$("#offer_percent").attr("disabled", "disabled");
					$("#offer_content").attr("disabled", "disabled");
				}
				
			}).trigger('change');
		});
		
	</script>
@endsection
