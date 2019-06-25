@extends('classified.layouts.layout')
<style>
	#gift_allow {
		
		margin: 0px 10px 0px 30px;
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
				
				<?php  if ($user->user_type_id  == 3) { ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					<div class="inner-box">
						<h2 class="title-2"><strong> {{ $business->title }} </strong></h2>
						
						<div class="col-sm-8">
						
							<div class="col-sm-9">
								<p class="p-bg-row"><strong> {{t('Category')}} : </strong> <span> {{ (isset($business->category->name))?$business->category->name:'' }} </span></p>
								<p class="p-bg-row"><strong> {{t('Keywords')}} : </strong> 
									<span>
										@foreach($keywords as $key => $val)
											@if($key>0){{', '}}@endif
											<a href="#"> {{$val->name}} </a>
										@endforeach
									</span>
								</p>
								{{--*/ $city_name = ''; /*--}}
								{{--*/ $location_name = ''; /*--}}
								@if(isset($business->city->asciiname)) {{--*/ $city_name = $business->city->asciiname; /*--}} @endif
								@if(isset($business->location->asciiname)) {{--*/ $location_name = $business->location->asciiname; /*--}} @endif
								@if(strtolower($lang->get('abbr'))=='ar')
									@if(isset($business->city->name) && trim($business->city->name)!='') {{--*/ $city_name = $business->city->name; /*--}} @endif
									@if(isset($business->location->name) && trim($business->location->name)!='') {{--*/ $location_name = $business->location->name; /*--}} @endif
								@endif
								<p class="p-bg-row"><strong> {{ t('Address') }} : </strong><br />
									{{ $business->address1 }} <br />
									@if($business->address2!='') {{$business->address1}} <br /> @endif
										{{$city_name.', '.$location_name}}
									<br />
								</p>
								<p>
								<p class="p-bg-row"><strong> {{ t('Mobile') }} : </strong> <span> @if($business->phone!=''){{$business->phone}}<br />@endif </span></p>
								<p class="p-bg-row"><strong> {{ t('Email') }} : </strong> <span> @if($business->web!=''){{$business->web}}<br />@endif </span></p>
								<div class="col-md-12" style="padding:0;"> <a href="{{lurl('account/editbiz/'.$business->id)}}" class="dir-link btn"><span class="fa fa-edit"></span> {{t('Edit Business Info')}} </a> </div>
							</div>
							
							<!-- Offer Info Edit-->
							<div class="col-sm-9">
							
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
											<span> @if($offer->offertype == 2 || $offer->offertype == 4) @lang('global.$') @endif {{ $offer->percent }} @if($offer->offertype == 1) @lang('global.% off') @elseif($offer->offertype == 2) @lang('global.off') @elseif($offer->offertype == 3) @lang('global.free') @elseif($offer->offertype == 4) @lang('global.for') @endif {{ $offer->content }} </span>
											
											<span class="pull-right itemoffer">
												<a href="{{ lurl('account/editbizoffer/'.$offer->id) }}"><i class="fa fa-edit"></i></a> 
												<a href="{{ lurl('account/'.$business->id.'/deletebizoffer/'.$offer->id) }}" onClick="return confirm('{{ t('Are you Sure?') }}')" ><i class="fa fa-trash"></i></a>
											</span>
                         
                                        </div> 
									 </div>
                                    @endforeach
								@endif
								
								<div class="col-md-12" style="padding:0;"> <a href="{{lurl('account/addbizoffer/'.$business->id)}}" class="dir-link btn"><span class="fa fa-plus"></span> @lang('global.Add More Offer') </a> </div>
							
							</div>
							<!--/ Offer Info Edit-->
							
							<!-- Booking Section -->
							<div class="col-sm-9">
								<div class="offer-list-card" style="margin-bottom: 15px;">
									@if(isset($business->booking) && $business->booking==1)
										{{--*/$chk = ' checked="checked"'; /*--}}
										{{--*/$chkTxt = t('Enabled'); /*--}}
									@else	
										{{--*/$chk = ''; /*--}}
										{{--*/$chkTxt = t('Disabled'); /*--}}
									@endif
									
									{{--*/$chkBtype = ''; /*--}}
									@foreach($bookings as $key => $value)
										@if($value['translation_of']==$business->booking_type)
											{{--*/$chkBtype = $value['title']; /*--}}
										@endif
									@endforeach	
									<div class="offer-list-card-title">
										<strong> {{t('Booking')}} </strong>
									</div>
									<div class="offer-list-card-content" id="bookClose">
										<div id="bookSetStatus">
										<span> <strong>{{$chkTxt}}</strong> </span>
										@if(isset($business->booking) && $business->booking==1)
										<br /><span> {{$chkBtype}} </span>
										@endif
										</div>
										<span class="pull-right itemoffer">
											<a href="#" onClick="return openBooking();"><i class="fa fa-edit"></i></a> 
										</span>
									</div>
									<div class="offer-list-card-content" id="bookOpen" style="display:none;">
									
										<span> <input type="checkbox" name="bizBook" id="bizBook" {{$chk}} value="1" />{{t('Enable Booking')}} </span> <br/>
										<span> 
										<ul>
										@foreach($bookings as $key => $value)
											@if($value['translation_of']==$business->booking_type)
												{{--*/$chk = ' checked="checked"'; /*--}}
											@else	
												{{--*/$chk = ''; /*--}}
											@endif
											<li><input type="radio" name="booking_type" id="booking_type_$value['translation_of']" {{$chk}} value="{{$value['translation_of']}}" />{{$value['title']}}</li>
										@endforeach
										</ul>
										</span></br>
										
										<span class="pull-right itemoffer">
											<a href="#" onClick="return closeBooking();" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Back') </a>
											<a href="#" onClick="return nextBooking();" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Next') </a>
										</span>
					 
									</div> 
									
									<div class="offer-list-card-content bookOpenNext" id="bookOpenNext3" style="display:none;">
										<div class="tm-content-box">
											
											@foreach($bookTmSettings as $key => $value)
											<div id="tmbox_{{$value['id']}}"><span>[{{date("h:i A", strtotime($value['tm_from']))}} </span><span>- </span><span>{{date("h:i A", strtotime($value['tm_to']))}} {{($value['tm_to']=='00.00')?'('.t('midnight next day').') ':''}}] </span>&nbsp;<span>[{{$value['price']}}]</span>&nbsp;<span>[{{$value['slots']}}]</span>&nbsp;<a href="#" class="rem-bhd"><i class="fa fa-minus-square"></i></a><input name="booking_settingsd[]" value="{{$value['id']}}" type="hidden"></div>
											@endforeach
										</div>
										<ul class="biz-hours-select" id="tm_select">
											<li>
												{{--*/ $time = strtotime('12:00 AM'); /*--}}
												<select class="tm-from" id="tm-from" style="width:80px;">
													@for ($i = 0; $i < 48; $i++)
														<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}</option>
														{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
													@endfor
												</select>
											</li>
											<li>
												{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
												<select class="tm-to" id="tm-to" style="width:80px;">
													@for ($i = 0; $i < 47; $i++)
														<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}@if($i==47){{ ' ('.t('midnight next day').')'}}@endif</option>
														{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
													@endfor
												</select>
											</li>
											<li>
												<input type="text" name="tm-price" id="tm-price" value="" placeholder="{{t('Price')}}" style="width:70px;">
											</li>
											<li>
												<select class="tm-slot" id="tm-slot" style="width:48px;">
													@for ($i = 1; $i < 11; $i++)
														<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</li>
											<li>
												<button type="button" id="tm-slot-btn" class="btn" style="padding:7px 9px;"><i class="fa fa-plus-square"></i></button>
											</li>
										</ul>

										<div class="alert alert-success fade in" id="showMsg" style="display:none; overflow: hidden; margin: 0px; padding: 5px 10px;">
											<a href="#" class="close" data-dismiss="alert">&times;</a>
											<strong>{{t('Success')}}</strong> {{t('Successfully updated.')}}
										</div>

										<span class="pull-right itemoffer">
											<a href="#" onClick="return backBooking();" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Back') </a>
											<a href="#" onClick="return updateBook('{{$business->id}}');" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Update Booking') </a>
										</span>
									</div>
								 </div>
									 
							</div>
							<!--/ Booking Section -->
							
							<!-- BOF Gift Certificate Section -->
							<div class="col-sm-9">
							
								<h3>{{t('Gift Certificate')}}</h3>
								
								<label class="form-control">
									{{ Form::radio('gift_allow', 1, false, ['id' => 'gift_allow']) }} {{ t('Enable') }}
									{{ Form::radio('gift_allow', 0, true, ['id' => 'gift_allow']) }} {{ t('Disable') }}
								</label>
								
								<div class="col-sm-12" id="prices_div" style="display: none;">
									@if(isset($giftPrice) && $giftPrice != '')
										@foreach($giftPrice as $key => $value)
											<div class="col-sm-3"> <label class="control-label"> {{ Form::checkbox('gift_price['.$key.']', $key, null, ['id' => 'gift_price_'.$key]) }} {{ $value }} </label></div>
										@endforeach
									@endif
								</div>
								
								<div class="col-md-12" id="button_div" style="display: none; padding: 0;"> <a href="#" onClick="return updateBook('{{$business->id}}');" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Update Gift Certificate') </a> </div>
								<!--
								@if(isset($business->booking) && $business->booking==1)
									{{--*/$chk = ' checked="checked"'; /*--}}
								@else	
									{{--*/$chk = ''; /*--}}
								@endif
								<input type="checkbox" name="bizBook" id="bizBook" {{$chk}} value="1" />{{t('Enable Booking')}}
								<ul>
								@foreach($bookings as $key => $value)
									@if($value['translation_of'] == $business->booking_type)
										{{--*/$chk = ' checked="checked"'; /*--}}
									@else	
										{{--*/$chk = ''; /*--}}
									@endif
									<li><input type="radio" name="booking_type" id="booking_type_$value['translation_of']" {{$chk}} value="{{$value['translation_of']}}" />{{$value['title']}}</li>
								@endforeach
								</ul>
								-->
								
							
							</div>
							<!--/ EOF Gift Certificate Section -->
							
						</div>
						
						<!------OPEN RIGHT DIVISION------>
						<div class="col-sm-4"> 
						  
							<div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="4000"> 
							<!-- Wrapper for slides -->
								<div class="carousel-inner">
								
									@if(isset($business->businessimages))
										@foreach($business->businessimages as $key => $image)
										<div class="item active">
											<div class="container-fluid">
												<div class="row">
													<div class="custom-slider-div">
														<img src="{{ url($image->filename) }}" width="100%">
													</div>
												</div>
											</div>
										</div>
										@endforeach
									@endif
									
								</div>
							
								<a data-slide="prev" href="#custom_carousel" class="izq carousel-control"> ‹ </a> 
								<a data-slide="next" href="#custom_carousel" class="der carousel-control"> › </a> 
								
								<!-- End Carousel Inner -->
								<div class="controls draggable ui-widget-content col-md-12 col-xs-12">
									<ul class="nav ui-widget-header">
										@if(isset($business->businessimages))
											@foreach($business->businessimages as $key => $image)
												<li data-target="#custom_carousel" data-slide-to="{{ $key }}" class="<?php if($key==0) echo 'active';?>"><a href="#"><img src="{{ url($image->filename) }}" width="100%"></a></li>
											@endforeach
										@endif
									</ul>
								</div>
								
							</div>
							<!-- End Carousel --> 
						  
							<!------CLOSE SLIDER------>
							<div class="rows"> <a href="{{lurl('account/bizimages/'.$business->id)}}" class="dir-link btn"><span class="fa fa-edit"></span> {{ t('Change Picture') }} </a> </div>
							
							<!--Map View-->
							<div class="rows">
								<img alt="Map" src="https://maps.googleapis.com/maps/api/staticmap?center={{$business->lat}},{{$business->lon}}&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}&zoom=10&size=200x150&key={{ config('services.googlemaps.key') }}" width="100%">
								<!--<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d15716.726967104516!2d76.3116122!3d10.0018418!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1489666418678" width="100%" height="100%" frameborder="0" style="border:1" allowfullscreen></iframe>-->
							</div>
							<!--/.Map View-->
							
							@if(!empty($busInfoA))
								<div class="qa-div">
								
									@foreach($busInfoA as $key => $vals)
										
										<p> {{ $vals['label'] }} : <b> {{ $vals['value'] }} </b> </p>
											
									@endforeach
								
								</div>
							@endif
								
							<div class="rows"> <a href="{{lurl('account/biziadditional/'.$business->id)}}" class="dir-link btn"><span class="fa fa-edit"></span> {{ t('Add/Edit Informations') }} </a> </div>

						</div>
						<!------CLOSE RIGHT DIVISION------> 
					</div>
				</div>
				<!-- /.page-content -->
				
			</div>
		</div>
	</div>
@endsection

@section('modal-message')
<div class="modal fade" id="more_business_info" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">@lang('global.Close')</span></button>
        <h4 class="modal-title"><i class=" icon-mail-2"></i> @lang('global.More business info')</h4>
      </div>
      <form role="form" method="POST" action="{{ lurl('account/update-business-info') }}">
        <div class="modal-body"> @if(count($errors) > 0 and old('msg_form')=='1')
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul class="list list-check">
              @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          
          {!! csrf_field() !!}
          
		  {{--*/ $more_infoA = unserialize($business->more_info); /*--}}
		  
		  @foreach($busInfo as $key => $value)
		  	@if($value->info_type==1)
				<div class="form-group">
					<label for="sender_name" class="control-label">{{$value->info_title}}</label>
					<input id="biz_info_{{$value->id}}" name="biz_info[{{$value->id}}]" class="form-control" placeholder="{{$value->info_title}}" type="text" value="{{isset($more_infoA['en'][$value->id]['value'])?$more_infoA['en'][$value->id]['value']:''}}">
				</div>
			@elseif($value->info_type==2)
				<div class="form-group">
					<label for="sender_name" class="control-label">{{$value->info_title}}</label>
					{{--*/ $infovals = unserialize($value->info_vals); /*--}}
					<select id="biz_info_{{$value->id}}" name="biz_info[{{$value->id}}]" class="form-control">
						@foreach($infovals as $key1 => $val1)
							<option value="{{$key1}}" @if(isset($more_infoA['en'][$value->id]['value']) && $more_infoA['en'][$value->id]['value']==$val1) selected="selected" @endif>{{$val1}}</option>
						@endforeach
					</select>
				</div>
			@elseif($value->info_type==3)
				<div class="form-group">
					<label for="sender_name" class="control-label">{{$value->info_title}}</label><br />
					{{--*/ $infovals = unserialize($value->info_vals); $nTag = 0; /*--}}
					@foreach($infovals as $key1 => $val1)
						{{--*/ $chkd=''; /*--}}
						@if(isset($more_infoA['en'][$value->id]['value']) && $more_infoA['en'][$value->id]['value']==$val1)
							{{--*/ $chkd =  'checked="checked"';  $nTag = 1; /*--}}
						@endif
						@if($nTag == 0 && $key1==(sizeof($infovals)-1))
							{{--*/ $chkd =  'checked="checked"';  /*--}}
						@endif
						<input id="biz_info_{{$value->id}}" name="biz_info[{{$value->id}}]" {{$chkd}} type="radio" value="{{ $key1 }}">&nbsp;{{ $val1 }}
					@endforeach
				</div>
			@endif
		  @endforeach
          
          <input type="hidden" name="business" value="{{ $business->id }}">
          <input type="hidden" name="msg_form" value="1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" data-dismiss="modal">@lang('global.Cancel')</button>
          <button type="submit" class="btn btn-success pull-right">@lang('global.Update business info')</button>
        </div>
      </form>
    </div>
  </div>
</div>	

@endsection 

@section('javascript')

	<script language="javascript">	
		$('#tm-slot-btn').click(function() {
			$('#tm-price').removeClass("error_border");
			$('#tm_select').removeClass("error_border");
			var tm_from_val = $('#tm-from').val();
			var tm_from_txt = $('#tm-from').find(":selected").text();
			var tm_to_val = $('#tm-to').val();
			var tm_to_txt = $('#tm-to').find(":selected").text();
			var tm_slot   = $('#tm-slot').val();
			var tm_price  = $('#tm-price').val();
			if(!(tm_price>0)){
				$('#tm-price').addClass("error_border");
				return false;
			}
			$('#tm-price').val('');
			$('.tm-content-box').append('<div><span>['+tm_from_txt+' </span><span>- </span><span>'+tm_to_txt+'] </span>&nbsp;<span>['+tm_price+']</span>&nbsp;<span>['+tm_slot+']</span>&nbsp;<a href="#" class="rem-bh"><i class="fa fa-minus-square"></i></a><input name="booking_settings[]" value="'+tm_from_val+'#'+tm_to_val+'#'+tm_price+'#'+tm_slot+'" type="hidden"></div>');
		});
		
		$('#tm-from').change(function() {
			setTmHrs();
		});
		
		function setTmHrs(){
			var fltrVal =  parseFloat($('#tm-from').val());
			$('#tm-to').children("option").filter(function() {
				return  (parseFloat(this.value) <= fltrVal) &&  (parseFloat(this.value) != 0);
			}).prop("disabled", true);
			
			$('#tm-to').children("option").filter(function() {
				return  parseFloat(this.value) > fltrVal;
			}).prop("disabled", false);
			
			$('#tm-to').children("option").filter(function() {
				return  parseFloat(this.value) == 0;
			}).prop("selected", true);
		}
		
		$(".tm-content-box").delegate("a.rem-bh", "click", function(){
			$(this).parent('div').remove();
			return false;
		});
		
		function vchk(){
			//par.find("img").replaceWith( '<img src="/images/loading-new.gif" width="15">' );
		}
		
		$(".tm-content-box").delegate("a.rem-bhd", "click", function(){
			//$(this).parent('div').remove();
			var par = $(this).parent('div');
			var ele = $(this);
			var set = par.find("[name='booking_settingsd[]']").val();
			$(this).replaceWith( '<img src="/images/loading-new.gif" width="15">' );
			$.ajax({
				url: "{{ lurl('biz_bookTmCheck') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'set':set},
				dataType:'json',
				success: function(data)
				{
					if(data['status']=='success'){
						par.remove();
					}else{
						par.find('img').replaceWith( ele );
					}
					console.log("success");
					console.log(data);
					return false;
				},
				error : function(xhr, status,data){
				console.log("error");
				console.log(data);
				return false;
				}
			});
			//alert('yes');
			return false;
		});
	
		function backBooking(){
			$('.bookOpenNext').fadeOut("normal", function (){
				$('#bookOpen').fadeIn("normal");
			});
			return false;
		}
		
		function nextBooking(){
			var booking_type =  parseInt($('[name="booking_type"]:checked').val());
			if(booking_type==3){
				$('#bookOpen').fadeOut("normal", function (){
					$('#bookOpenNext'+booking_type).fadeIn("normal");
				});
			}
			return false;
		}
		
		function openBooking(){
			$('#bookClose').fadeOut("normal", function (){
				$('#bookOpen').fadeIn("normal");
			});
			return false;
		}
		
		function closeBooking(){
			$('#bookOpen').fadeOut("normal", function (){
				$(bookClose).fadeIn("normal");
			});
			return false;
		}
		
		function updateBook(){
			$('#tm_select').removeClass("error_border");
			var booking =  $('#bizBook:checked').length;
			var booking_type =  parseInt($('[name="booking_type"]:checked').val());
			var forFlag = 0;
			var booking_settings = '';
			$("[name='booking_settings[]']").each(function( index ) {
			  booking_settings += $( this ).val()+'V#V';
			  forFlag = 1;
			});
			$("[name='booking_settingsd[]']").each(function( index ) {
			  forFlag = 1;
			});
			if(forFlag == 0){
				$('#tm_select').addClass("error_border");
				return false;
			}
			$('#showMsg').fadeIn('normal');
			setTimeout("$('#showMsg').fadeOut('normal');", 2000);
			$.ajax({
				url: "{{ lurl('biz_book') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'booking':booking, 'booking_type':booking_type, 'booking_settings':booking_settings},
				dataType:'json',
				success: function(data)
				{
					$('#bookSetStatus').html(data['statusInfo']);
					console.log("success");
					console.log(data);
					return false;
					
				},
				error : function(xhr, status,data){
				console.log("error");
				console.log(data);
				return false;
				}
			});
			return false;
		}
		
		$(document).ready(function(ev){
			var items = $(".nav li").length;
			var leftRight=0;
			if(items>5){
				leftRight=(items-5)*50*-1;
			}
			$('#custom_carousel').on('slide.bs.carousel', function (evt) {
				
				$('#custom_carousel .controls li.active').removeClass('active');
				$('#custom_carousel .controls li:eq('+$(evt.relatedTarget).index()+')').addClass('active');
				
			});
			$('.nav').draggable({ 
				axis: "x",
				 stop: function() {
					var ml = parseInt($(this).css('left'));
					if(ml>0)
					$(this).animate({left:"0px"});
						if(ml<leftRight)
							$(this).animate({left:leftRight+"px"});
							
				}
			  
			});
			
			$('#gift_allow').click(function(){
				
				if($('#gift_allow checked:checked').val()== 1)
				{
					$("#prices_div").show();
					$("#button_div").show();
				}
				else
				{
					$("#prices_div").hide();
					$("#button_div").hide();
				}
				
			}).trigger('change');
			
		});
		
	</script>
	@parent	
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
