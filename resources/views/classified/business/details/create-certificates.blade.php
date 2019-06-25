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

				@if(count($errors) > 0)
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong> @lang('global.Oops ! An error has occurred. Please correct the red fields in the form') </strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if(Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				@if(Session::has('message'))
				{{--*/ Session::forget('message'); /*--}}
				<div class="col-lg-12">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h5><strong> @lang("global.Gift Certificate Created Successfully!") </strong></h5>
					</div>
				</div>
				{{--*/ Session::forget('message'); /*--}}
				@endif
				
				<!--*/ BOF PAGE CONTENT /*-->
				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> @lang('global.Create a Gift Certificate') </strong></h2>
						<form id="certificate_post" method="POST" action="{{ url('giftpay/index.php') }}">
							{!! csrf_field() !!}
							<div class="row">
								<div class="col-sm-12">
									<div style="display: none;">
										{{--*/ $curr_code	=	\App\Larapen\Models\Country::select('currency_code')->where('code', $business->country_code)->first(); /*--}}
										@if(isset($curr_code) && count($curr_code) > 0)
										{{ Form::hidden('curr_code', $curr_code['currency_code']) }}
										@endif
									</div>
									<div class="gift-header-wrapper">
										<h2> @lang('global.Checkout') </h2>
										{{ Form::hidden('biz_id', $business->id) }}
										{{ Form::hidden('lan_id', $lang->get('abbr')) }}
									</div>
									<div class="gift-body-wrapper">
										<div class="giftbox-div"> 
											{{--*/ $thumb = ''; /*--}}
											@if(isset($business->businessimages) && sizeof($business->businessimages)>0)
												@foreach($business->businessimages as $key => $image)
													
													{{--*/ $picBigUrl = ''; /*--}}
													@if (is_file(public_path() . '/uploads/pictures/'. $image->filename))
														{{--*/ $picBigUrl = url('pic/x/cache/big/' . $image->filename); /*--}}
													@endif
													
													@if ($picBigUrl=='')
														@if (is_file(public_path() . '/'. $image->filename))
															{{--*/ $picBigUrl = url('pic/x/cache/big/' . $image->filename); /*--}}
														@endif
													@endif
													
													@if ($picBigUrl=='')
														{{--*/ $picBigUrl = url('pic/x/cache/big/' . config('larapen.laraclassified.picture')); /*--}}
													@endif
													<?php	
														$thumb .= '<div  class="col-md-4 col-sm-4">';
														$thumb .= '<div class="row"> <a class="" id="carousel-selector-'.$key.'"><img src="'.$picBigUrl.'" width="100%"></a> </div>';
														$thumb .= '</div>'; 
													?>
												
												@endforeach
												<img src="{{ $picBigUrl }}" class="image-org" / >
											@else
												<img src="{{url('uploads/pictures/no-image.png')}}" class="image-org" />
											@endif
											
											<div class="gift-org-name">
												<h3> @lang('global.Gift Certificate') </h3>
												<h5> @lang('global.at') {{ $business->title }} </h5>
											</div>
										</div>
										<div class="giftbox-div">
											<table class="table ofr-table table-bordered">
												<thead>
													<tr>
														<th> @lang('global.Quantity') </th>
														<th> @lang('global.Price') </th>
														<th> @lang('global.Total') </th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>
															{{ Form::select('gift_quantity', ['1' => '1','2' => '2','3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10'], null, ['class' => 'form-control','id' => 'gift_quantity','onchange'=>'addRow(this.value)']) }}
														</td>
														<td>
															{{--*/ $select = unserialize($business->gift_info); /*--}}
															@if(count($select) > 0)
																<select name="gift_amount" class="form-control" id="gift_amount">
																	@foreach($prices as $key => $value)
																		@if(in_array($key,$select))
																			<option value="{{ $value }}"> @if(isset($currency) && count($currency) > 0) {{ $currency }} @endif{{ $value }} </option>
																		@endif
																	@endforeach
																</select>
															@else
																<select name="gift_amount" class="form-control" id="gift_amount">
																	@foreach($prices as $key => $value)
																		<option value="{{ $value }}"> @if(isset($currency) && count($currency) > 0) {{ $currency }} @endif{{ $value }} </option>
																	@endforeach
																</select>
															@endif
														</td>
														<td> <p style="color:#666; padding: 3px 0px 0px 0px;"> <span class="quantity"> </span> x <span class="amount"></span> </p></td>
													</tr>
													<tr class="gift-total-bottom">
														<td> @lang('global.Total') </td>
														<td> </td>
														<td> @if(isset($currency) && count($currency) > 0) {{ $currency }} @endif <span class="total"> </span> </td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						
							<div class="row" id="recipient_div">
							
								<div class="col-md-12 a2">
								
									<div class="gift-header-wrapper">
										<h2> @lang('global.Gift Recipient') <span id="count_reciept"> </span> </h2>
									</div>
									<div class="gift-content-wrapper">
										<div class="gift-row">
											<div class="col-md-6">
												<div class="form-group">
													<label> @lang('global.Full Name') </label>
													<input name="recipient_name[]" type="text" id="name_1" class="form-control" placeholder="{{ t('Recipient Name') }}" required="" />
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label> @lang('global.Email Address') </label>
													<input name="recipient_email[]" type="email" id="address_1" class="form-control" placeholder="{{ t('email@example.com') }}" required="" />
												</div>
											</div>
										</div>
										<div class="gift-row">
											<div class="col-md-6">
												<div class="form-group">
													<label> @lang('global.Message')</label>
													<textarea name="recipient_message[]" id="message_1" class="form-control" placeholder="{{ t('Here is a gift for you!') }}"> {{ t('Here is a gift for you!') }} </textarea>
												</div>
											</div>
											<div class="col-md-6">
											  <div class="gif-preview"> 
												<!--<img src="" />--> <a onClick="getPopup(1)"> @lang('global.Live Preview') </a> 
											  </div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label> @lang('global.Sender Name') </label>
												<input name="sender_name[]" type="text" id="sender_1" class="form-control" value="{{ $user->name }}" placeholder="{{ t('Your Name') }}" required="" />
												<input name="sender_id" type="hidden" id="sender_id" class="form-control" value="{{ $user->id }}">
											</div>
										</div>
									</div>
								</div>
								
							</div>
							
							<div class="row">
								<div class="col-md-12">
									<div class="gift-section-footer">
										<p> @lang('global.By purchasing, you agree you have read and accept the terms of this Certificate, the General Terms, the Howlik Terms of Service and Privacy Policy.') </p>
										<a href="{{ lurl('/'.$business->title.'/'.$business->id.'.html') }}" class="btn btn-default"> @lang('global.Back') </a>
										<input class="btn btn-success" type='submit' name='pay_now' id='pay_now' value="{{ t('Purchase') }}" />
									</div>
								</div>
							</div>
						</form>
						
						@if(Session::has('string') && Session::get('string') != '')
							<p id="session_id" style="display: none;"> {{ implode(Session::get('string')) }} </p>
						@endif
						
						<!-- BOF Modal -->
						<div id="myModal" class="modal fade gift-certificate" role="dialog" >
							<div class="modal-dialog">
								<div class="modal-content" style="background:url('/uploads/pictures/bg-gift.jpg') no-repeat">
                                	<!--<div class="certificate-ribbon"><img src="{{url('uploads/pictures/ribbon.png')}}"  style="width:100px;"/></div>-->
									<div class="modal-header">
										<h4 class="modal-title" style="text-align:center; color:#e40046"> <b>@lang('global.Preview')</b> </h4>
									</div>
									<div class="col-md-12 modal-body" >
										<div class="col-md-6">
                                            <h3> @lang('global.Gift Certificate') </h2>
                                            <h4><b> @lang('global.at') {{ $business->title }} </b></h4>
                                                
											@if(isset($picBigUrl) && $picBigUrl != '')
												<img src="{{ $picBigUrl }}" class="image-modal" / >
											@else
												<img src="{{url('uploads/pictures/no-image.png')}}" class="image-modal" />
											@endif
										</div>
										<div class="col-md-6"> 
											<div class="col-md-12"> 
												<h4> @lang('global.To') : </h4>
												<p id="modal_to"> (@lang('global.Not Yet Entered')) </p> <br>
												
												<h4> @lang('global.From') : </h4>
												<p id="modal_from"> (@lang('global.Not Yet Entered')) </p> <br>
												
												<h4> @lang('global.Redemption Code') : </h4>
												<p id="modal_code"> @lang('global.SAMPLE') </p> <br>
											</div>
										
										</div>
										<p> @lang('global.The printed Gift Certificate will also include the business address and phone number, terms of use, restrictions, and redemption instructions.') </p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default certificate-close" data-dismiss="modal"> @lang('global.Close') </button> <img src="{{url('/uploads/app/logo/logo2.png')}}" class="pull-right certificate-logo" />
									</div>
								</div>
							</div>
						</div>
						<!-- EOF Modal -->
	
					</div>
				</div>
				<!--*/ EOF PAGE CONTENT /*--> 
				
			</div>
		</div>
	</div>
	
	@if(Session::has('string') && Session::get('string') != '')
	{{--*/ $str = implode(Session::get('string')); /*--}}
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
				type: "POST",
				url: '{{ url("test.php") }}',
				data: {id:'{{ $str }}'},
				dataType:'json',
				success: function(data)	{}
			});
		});
	</script>
	@endif
	
@endsection

@section('javascript')
	
	<script type="text/javascript">
	
		$(document).ready(function(){
			
			$('#gift_quantity').on('change', function() {
				
				if($('#gift_quantity option:selected').val()!='')
				{
					$('.quantity').html($('#gift_quantity option:selected').val());
				}
				
			}).trigger('change');
			
			$('#gift_amount').on('change', function() {
				
				if($('#gift_amount option:selected').val()!='')
				{
					$('.amount').html($('#gift_amount option:selected').val());
				}
				
			}).trigger('change');
			
			/*** To Print the Total if quantity changed ***/
			$('#gift_quantity').on('change', function() {
				
				var quantity 	= $('#gift_quantity option:selected').val();
				var amount		= $('.amount').html();
				var multiply 	= quantity * amount;
				var amount		= $('.total').html(multiply);
				
			}).trigger('change');
			
			/*** To Print the Total if amount changed ***/
			$('#gift_amount').on('change', function() {
				
				var quantity 	= $('.quantity').html();
				var amount		= $('#gift_amount option:selected').val();
				var multiply 	= quantity * amount;
				var amount		= $('.total').html(multiply);
				
			}).trigger('change');
			
			/*** To Print the Recipient Count ***/
			$('#gift_quantity').change(function(){
				if($('#gift_quantity option:selected').val() > 1)
				{
					$('#count_reciept').html(1);
				}
				else
				{
					$('#count_reciept').html('');
				}
			});
			
			
		});
			
	</script>
	
	
	<script type="text/javascript">
		
		function getPopup(e){
			
			$('#myModal').modal('show');
			
			if($("#name_"+e).val() != "") {
				
				$('#modal_to').html($("#name_"+e).val());
			}
			if($("#sender_"+e).val() != "") {
				
				$('#modal_from').html($("#sender_"+e).val());
			}
			
			return false;
		}
		
		function addRow(e) {
			
			if(e>1)
			{
				if($('.a2').length == 1)
				{
					var i = 2;
					
					do
					{
						//$('#manual_div').hide();
						/** Hotel Details **/
						
						var div = document.createElement('div');
						
						div.className = 'rower';
						
						div.innerHTML = '<div class="col-md-12 a2">\
											<div class="gift-header-wrapper">\
												<h2> @lang("global.Gift Recipient") '+ i +' </h2>\
											</div>\
											<div class="gift-content-wrapper">\
												<div class="gift-row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label> @lang("global.Full Name") </label>\
															<input name="recipient_name[]" type="text" id="name_'+i+'" class="form-control" placeholder="{{ t('Recipient Name') }}" required="" />\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label> @lang("global.Email Address") </label>\
															<input name="recipient_email[]" type="email" id="email_'+i+'" class="form-control" placeholder="{{ t('email@example.com') }}" required="" />\
														</div>\
													</div>\
												</div>\
												<div class="gift-row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label> @lang("global.Message")</label>\
															<textarea name="recipient_message[]" id="message_'+i+'" class="form-control" placeholder="{{ t('Here is a gift for you!') }}"> {{ t('Here is a gift for you!') }} </textarea>\
														</div>\
													</div>\
													<div class="col-md-6">\
													  <div class="gif-preview">\
														<!--<img src="">--> <a onClick="getPopup('+i+')"> @lang("global.Live Preview") </a>\
													  </div>\
													</div>\
												</div>\
												<div class="col-md-6">\
													<div class="form-group">\
														<label> @lang("global.Sender Name") </label>\
														<input name="sender_name[]" type="text" id="sender_'+i+'" class="form-control" value="{{ $user->name }}" placeholder="{{ t('Your Name') }}" required="" />\
													</div>\
												</div>\
											</div>\
										</div>';
										
						document.getElementById('recipient_div').appendChild(div);
						
						i++;
					
					}
					while(i<=e);
				}
				else
				{
					$( ".rower" ).remove();
					
					var i = 2;
					var ss =$('#gift_quantity option:selected').val();	
					do
					{
						
						var div = document.createElement('div');
						
						div.className = 'rower';
						
						div.innerHTML = '<div class="col-md-12 a2">\
											<div class="gift-header-wrapper">\
												<h2> @lang("global.Gift Recipient") '+ i +' </h2>\
											</div>\
											<div class="gift-content-wrapper">\
												<div class="gift-row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label> @lang("global.Full Name") </label>\
															<input name="recipient_name[]" id="name_'+i+'" type="text" class="form-control" placeholder="{{ t('Recipient Name') }}" required="" />\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label> @lang("global.Email Address") </label>\
															<input name="recipient_email[]" id="email_'+i+'" type="email" class="form-control" placeholder="{{ t('email@example.com') }}" required="" />\
														</div>\
													</div>\
												</div>\
												<div class="gift-row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label> @lang("global.Message")</label>\
															<textarea name="recipient_message[]" id="message_'+i+'" class="form-control" placeholder="{{ t('Here is a gift for you!') }}"> {{ t('Here is a gift for you!') }} </textarea>\
														</div>\
													</div>\
													<div class="col-md-6">\
													  <div class="gif-preview">\
														<!--<img src="">--> <a onClick="getPopup('+i+')"> @lang("global.Live Preview") </a>\
													  </div>\
													</div>\
												</div>\
												<div class="col-md-6">\
													<div class="form-group">\
														<label> @lang("global.Sender Name") </label>\
														<input name="sender_name[]" type="text" id="sender_'+i+'" class="form-control" value="{{ $user->name }}" placeholder="{{ t('Your Name') }}" required="" />\
													</div>\
												</div>\
											</div>\
										</div>';
											
						document.getElementById('recipient_div').appendChild(div);
						
						i++;
							
					}
					while(i<=ss);
				}
				
			}else if(e<=1) {
			
				$( ".rower" ).remove();
			}
		}
		
	</script>
	
@endsection
