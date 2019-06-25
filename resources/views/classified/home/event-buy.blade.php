@extends('classified.layouts.layout')
<style>
	.image-modal {
		    width: 100%;
		border: 5px solid #ccc;
		border-radius: 2px;
	}
	.gift-certificate h3{
		font-size:18px;
		font-weight:bold;
	}
	.gift-certificate h4{
		font-size:16px;
		font-weight:200;
	}
	.certificate-ribbon{
		position:absolute;
		top:0;
		height:auto;
		float:left;
		z-index:999;
	}
	.certificate-ribbon img{
		width:120px;
		margin:-10px;
		transform:rotate(-15deg);
	}
	.gift-certificate p{
		 font-size:14px !important;
	}
	.certificate-close{
		background:#fff !important;
		border:1px solid #000 !important;
		color:#000 !important;
		float:left;
		padding:4 8px;
		border-radius:0;
	}
	.certificate-logo{
		width:80px
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
							<h5><strong>@lang('global.Oops ! An error has occurred. Please correct the red fields in the form')</strong></h5>
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
				
				<!--*/ BOF PAGE CONTENT /*-->
				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> @lang('global.Ticket Purchase') </strong></h2>
						@if($event->ticket_type > 1)
						<form id="buy-tickets-post" method="POST" action="{{ url('eventpay/index.php') }}">
						@else
						<form id="buy-tickets-post" method="POST" action="{{ lurl('/buy/tickets/post') }}">
						@endif
							{!! csrf_field() !!}
							<div class="row">
								<div class="col-sm-12">
									<div style="display: none;">
										{{--*/ $curr_code	=	\App\Larapen\Models\Country::select('currency_code')->where('code', $event->country_code)->first(); /*--}}
										@if(isset($curr_code) && count($curr_code) > 0)
										{{ Form::hidden('curr_code', $curr_code['currency_code']) }}
										@endif
									</div>
									<div class="gift-header-wrapper">
									  <h2> @lang('global.Checkout') </h2>
									  {{ Form::hidden('eve_id', $event->id) }}
									  {{ Form::hidden('usr_id', $user->id) }}
									  {{ Form::hidden('usr_name', $user->name) }}
									  {{ Form::hidden('usr_email', $user->email) }}
									  {{ Form::hidden('lan_id', $lang->get('abbr')) }}
									</div>
									<div class="gift-body-wrapper">
										<div class="giftbox-div"> 
											@if(isset($event) && $event->event_image1 != '')
												<img src="{{ url($event->event_image1) }}" class="image-org" />
											@else
												<img src="{{ url('uploads/pictures/no-image.png') }}" class="image-org" />
											@endif
											<div class="gift-org-name">
												<h3 style="overflow:hidden;text-overflow:ellipsis;"> @if($event->event_name != '') {{ $event->event_name }} @endif </h3>
												@if($event->ticket_type > 0) 
													{{--*/ $value = unserialize($event->ticket_details); /*--}}
													@if(isset($event->decrement) && $event->decrement != '')
														{{--*/ $tckts = $value['tickets'] - $event->decrement; /*--}}
														<p style="color: green;"> <span id="available"> {{ $tckts }} </span> @lang('global.tickets available!') </p>
													@else
														<p style="color: green;"> <span id="available"> {{ $value['tickets'] }} </span> @lang('global.tickets available!') </p>
													@endif
												@endif
											</div>
										</div>
										<div class="giftbox-div">
											<table class="table ofr-table table-bordered">
												<thead>
													<tr>
														<th> @lang('global.Quantity') </th>
														@if($event->ticket_type != 0 && $event->ticket_type == 2) 
														<th> @lang('global.Price') </th> 
														@endif
														<th> @lang('global.Total') </th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															{{ Form::select('ticket_quantity', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10'], null, ['class' => 'form-control','id' => 'ticket_nos']) }}
														</td>
														@if($event->ticket_type != 0 && $event->ticket_type == 2) 
															{{--*/ $value = unserialize($event->ticket_details); /*--}}
														<td>
															{{ Form::select('ticket_amount', [$value['price'] => $value['price']], null, ['class' => 'form-control','id' => 'ticket_amount']) }}
														</td> 
														@endif
														<td> <p style="color:#666; padding: 3px 0px 0px 0px;"> <span class="quantity"> </span> @if($event->ticket_type != 0 && $event->ticket_type == 2) x <span class="amount"> </span> @endif </p></td>
													</tr>
													@if($event->ticket_type != 0 && $event->ticket_type == 2)
														{{--*/ $value = unserialize($event->ticket_details); /*--}}
													<tr class="gift-total-bottom">
														<td> @lang('global.Total') </td>
														<td> </td>
														<td> <span> @if($event->currency != '') {{ $event->currency }} @endif </span> <span class="total"> </span> </td>
													</tr>
													@endif
												</tbody>
											</table>
											<p id="quantity_notify" style="color:red;"> @lang('global.Selected Quantity of Tickets are not Available!') </p>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<div class="gift-section-footer">
										<a href="{{ lurl('/preview/event/'.$event->id) }}" class="btn btn-default"> @lang('global.Back') </a>
										<input class="btn btn-success" type='submit' name='pay_now' id='pay_now' value="{{ t('Purchase') }}" />
									</div>
								</div>
							</div>
						</form>
	
					</div>
				</div>
				<!--*/ EOF PAGE CONTENT /*--> 
				
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	
	<script type="text/javascript">
	
		$(document).ready(function(){
			
			$('#ticket_nos').on('change', function() {
				
				var quantity	=	$('#ticket_nos option:selected').val();
				var	available	=	$('#available').html();
				
				if(parseInt(quantity) > parseInt(available)) {
					
					$('#quantity_notify').show();
					$('#sbmt_btn').prop('disabled', true);
				}
				else
				{
					$('#quantity_notify').hide();
					$('#sbmt_btn').prop('disabled', false);
				}
			}).trigger('change');
			
			$('#ticket_nos').on('change', function() {
				
				if($('#ticket_nos option:selected').val()!='')
				{
					$('.quantity').html($('#ticket_nos option:selected').val());
				}
				
			}).trigger('change');
			
			$('#ticket_amount').on('change', function() {
				
				if($('#ticket_amount option:selected').val()!='')
				{
					$('.amount').html($('#ticket_amount option:selected').html());
				}
				
			}).trigger('change');
			
			/*** To Print the Total if quantity changed ***/
			$('#ticket_nos').on('change', function() {
				
				var quantity 	= $('#ticket_nos option:selected').html();
				var amount		= $('.amount').html();
				var multiply 	= quantity * amount;
				var amount		= $('.total').html(multiply);
				
			}).trigger('change');
			
			/*** To Print the Total if amount changed ***/
			$('#ticket_amount').on('change', function() {
				
				var quantity 	= $('.quantity').html();
				var amount		= $('#ticket_amount option:selected').html();
				var multiply 	= quantity * amount;
				var amount		= $('.total').html(multiply);
				
			}).trigger('change');
			
		});
			
	</script>
	
@endsection
