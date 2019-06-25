@extends('classified.layouts.layout')
@section('content')
	{{--*/ $thumb = ''; /*--}}
	@if(isset($business->businessimages) && sizeof($business->businessimages)>0)
		@foreach($business->businessimages as $key => $image)
			<?php
				$picBigUrl = '';
				if (is_file(public_path() . '/uploads/pictures/'. $image->filename)) {
					$picBigUrl = url('pic/x/cache/big/' . $image->filename);;
				}
				if ($picBigUrl=='') {
					if (is_file(public_path() . '/'. $image->filename)) {
						$picBigUrl = url('pic/x/cache/big/' . $image->filename);
					}
				}
				// Default picture
				if ($picBigUrl=='') {
					$picBigUrl = url('pic/x/cache/big/' . config('larapen.laraclassified.picture'));
				}
				$thumb .= '<div>';
				$thumb .= '<img u="image" src="'.$picBigUrl.'" width="100%" />';
				$thumb .= '<img u="thumb" src="'.$picBigUrl.'" width="100%" />';
				$thumb .= '</div>';
			?>
		@endforeach
	@endif
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
						
							<div class="col-sm-11">
								<p class="p-bg-row"><strong> {{t('Category')}} : </strong> <span>
								{{ (isset($business->category->name))?$business->category->name:'' }} </span></p>
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
								@if(isset($business->city->asciiname))
									{{--*/ $city_name = $business->city->asciiname; /*--}}
								@endif
								@if(isset($business->location->asciiname))
									{{--*/ $location_name = $business->location->asciiname; /*--}}
								@endif
								@if(strtolower($lang->get('abbr'))=='ar')
									@if(isset($business->city->name) && trim($business->city->name)!='') {{--*/ $city_name = $business->city->name; /*--}} @endif
									@if(isset($business->location->name) && trim($business->location->name)!='') {{--*/ $location_name = $business->location->name; /*--}} @endif
								@endif
								<p class="p-bg-row"><strong> {{ t('Address') }} : </strong><br />
									{{ ucwords($business->address1) }} <br />
									@if($business->address2!='') {{ ucwords($business->address1) }} <br /> @endif
										{{ ucfirst($city_name).', '.ucfirst($location_name) }}
									<br />
								</p>
								<p>
								<p class="p-bg-row"><strong> {{ t('Mobile') }} : </strong> <span> @if($business->phone!=''){{$business->phone}}<br />@endif </span></p>
								<p class="p-bg-row"><strong> {{ t('Email') }} : </strong> <span> @if($business->web!=''){{$business->web}}<br />@endif </span></p>
								<div class="col-md-12" style="padding:0;"> <a href="{{lurl('account/editbiz/'.$business->id)}}" class="dir-link btn"><span class="fa fa-edit"></span> {{t('Edit Business Info')}} </a> </div>
							</div>
							
							<br><br>
							
							<!-- Booking Section -->
							<div class="col-sm-11">
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
											<span id="bookSetStatuz"> 
												<strong> {{$chkTxt}} </strong>
												@if(isset($business->booking) && $business->booking==1)
												<span style="margin-left: 10px;"> {{$chkBtype}} </span>
												@endif
											</span>
											
											<span class="pull-right itemoffer">
												<button class="btn btn-xs btn-default" onClick="return openBooking();"><i class="fa fa-edit"></i></button> 
											</span>
										</div>
									</div>
									
									<div class="offer-list-card-content" id="bookOpen" style="display:none;">
										<span> <input type="checkbox" name="bizBook" id="bizBook" {{$chk}} value="1" />{{t('Enable Booking')}} </span> <br/>
										<div> 
											<ul>
											@foreach($bookings as $key => $value)
												@if($value['translation_of']==$business->booking_type)
													{{--*/$chk = ' checked="checked"'; /*--}}
												@else	
													{{--*/$chk = ''; /*--}}
												@endif
												<li><input type="radio" name="booking_type" id="booking_type_{{$value['translation_of']}}" {{$chk}} value="{{$value['translation_of']}}" />{{$value['title']}}</li>
											@endforeach
											</ul>
										</div></br>
										
										<span class="pull-right itemoffer">
											<a href="#" onClick="return closeBooking();" class="dir-link btn-white btn"><span class="fa fa-file"></span> @lang('global.Back') </a>
											<a href="#" onClick="return nextBooking();" class="dir-link btn-white btn"><span class="fa fa-file"></span> @lang('global.Next') </a>
										</span>
									</div> 
									
									<!-- BOF TIME SLOT BOOKING -->
									<div class="offer-list-card-content bookOpenNext" id="bookOpenNext3" style="display:none;">
										<div class="tm-heading-box">
											<ul style="width:100%; margin-bottom: 5px;">
												<li style="width: 35%;"> {{ t('Availability [From-To]') }} </li>
												<li style="width: 25%;"> {{ t('Price') }} </li>
												<li style="width: 20%;"> {{ t('Slots') }} </li>
												<li style="width: 10%;"> &nbsp; </li>
											</ul>
										</div>
										<div class="tm-content-box">
											@foreach($bookTmSettings as $key => $value)
											<div id="tmbox_{{$value['id']}}">
												<ul style="width: 100%;">
													<li style="width: 35%;">[{{date("h:i A", strtotime($value['tm_from']))}} - {{date("h:i A", strtotime($value['tm_to']))}} {{($value['tm_to']=='00.00')?'('.t('midnight next day').') ':''}}] </li>
													<li style="width: 25%;">[{{$value['price']}}]</li>
													<li style="width: 20%;">[{{$value['slots']}}]</li>
													<li style="width: 10%;">
														<a href="#" class="rem-bhd" data-id="{{$value['id']}}"><i class="fa fa-minus-square"></i></a>
														<input name="booking_settingsd[]" value="{{$value['id']}}" type="hidden">
													</li>
												</ul>
											</div>
											@endforeach
										</div>
										<ul class="biz-hours-select" style="margin-bottom: -10px;">
											<li> <label style="width: 80px;"> @lang('global.From') </label> </li>
											<li> <label style="width: 80px;"> @lang('global.To') </label> </li>
											<li> <label style="width: 70px;"> @lang('global.Price') </label> </li>
											<li> <label style="width: 48px;"> @lang('global.Slots') </label> </li>
										</ul>
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
												<input type="text" name="tm-price" class="form-control" id="tm-price" value="" placeholder="{{t('Price')}}" style="width:70px;">
											</li>
											<li>
												<select class="tm-slot" id="tm-slot" style="width:48px;">
													@for ($i = 1; $i < 11; $i++)
														<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</li>
											<li>
												<button type="button" id="tm-slot-btn" class="btn" style="margin-top: 0;"><i class="fa fa-plus-square"></i></button>
											</li>
										</ul>

										<div class="alert alert-success fade in" id="showMsg" style="display:none; overflow: hidden; margin: 0px; padding: 5px 10px; width:100%;">
											<a href="#" class="close" data-dismiss="alert">&times;</a>
											<strong>{{t('Success')}}</strong> {{t('Successfully updated.')}}
										</div>

										<span class="pull-right itemoffer">
											<a href="#" onClick="return backBooking();" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Back') </a>
											<a href="#" onClick="return updateBook('{{$business->id}}');" class="dir-link btn"><span class="fa fa-file"></span> @lang('global.Update Booking') </a>
										</span>
									</div>
									<!-- EOF TIME SLOT BOOKING -->
									
									<!-- BOF TABLE BOOKING -->
									<div class="offer-list-card-content bookOpenNext" id="bookOpenNext5" style="display:none;">
										<div class="tbl-heading-box">
											<ul style="width:100%; margin-bottom: 5px;">
												<li style="width: 35%;"> {{ t('Availability [From-To]') }} </li>
												<li style="width: 25%;"> {{ t('Seats [Min-Max]') }} </li>
												<li style="width: 20%;"> {{ t('Table(s)') }} </li>
												<li style="width: 10%;"> &nbsp; </li>
											</ul>
										</div>
										<div class="tbl-content-box">
											@foreach($bookTblSettings as $key => $value)
											<div id="tblbox_{{$value['id']}}">
												<ul style="width: 100%;">
													<li style="width: 35%;">[{{date("h:i A", strtotime($value['tbl_from']))}} - {{date("h:i A", strtotime($value['tbl_to']))}} {{($value['tbl_to']=='00.00')?'('.t('midnight next day').') ':''}}] </li>
													<li style="width: 25%;">[{{$value['seat_min']}} - {{$value['seat_max']}}]</li>
													<li style="width: 20%;">[{{$value['tbl_table']}}]</li>
													<li style="width: 10%;">
														<a href="" class="rem-bhd-tbl"><i class="fa fa-minus-square"></i></a>
														<input name="booking_settings_tbld[]" value="{{$value['id']}}" type="hidden">
													</li>
												</ul>
											</div>
											@endforeach
										</div>
										<ul class="biz-hours-select" style="margin-bottom: -10px;">
											<li> <label style="width: 100%;"> @lang('global.From') </label> </li>
											<li> <label style="width: 100%;"> @lang('global.To') </label> </li>
											<li> <label style="width: 48px;"> @lang('global.Min') </label> </li>
											<li> <label style="width: 48px;"> @lang('global.Max') </label> </li>
											<li> <label style="width: 48px;"> @lang('global.Table') </label> </li>
										</ul>
										<ul class="biz-hours-select" id="tbl_select">
											<li>
												{{--*/ $time = strtotime('12:00 AM'); /*--}}
												<select class="tbl-from" id="tbl-from" style="width:100%;">
													@for ($i = 0; $i < 48; $i++)
														<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}</option>
														{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
													@endfor
												</select>
											</li>
											<li>
												{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
												<select class="tbl-to" id="tbl-to" style="width:100%;">
													@for ($i = 0; $i < 47; $i++)
														<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}@if($i==47){{ ' ('.t('midnight next day').')'}}@endif</option>
														{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
													@endfor
												</select>
											</li>
											<li>
												<select class="seat-min" id="seat-min" style="width:48px;">
													@for ($i = 1; $i < 11; $i++)
														<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</li>
											<li>
												<select class="seat-max" id="seat-max" style="width:48px;">
													@for ($i = 1; $i < 11; $i++)
														<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</li>
											<li>
												<select class="tbl-table" id="tbl-table" style="width:48px;">
													@for ($i = 1; $i < 11; $i++)
														<option value="{{$i}}">{{$i}}</option>
													@endfor
												</select>
											</li>
											<li>
												<button type="button" id="tbl-slot-btn" class="btn" style="margin-top: -5px;"><i class="fa fa-plus-square"></i></button>
											</li>
										</ul>

										<div class="alert alert-success fade in" id="showMsgTbl" style="display:none; overflow: hidden; margin: 0px; padding: 5px 10px; width:100%;">
											<a href="#" class="close" data-dismiss="alert">&times;</a>
											<strong>{{t('Success')}}</strong> {{t('Successfully updated.')}}
										</div>

										<span class="pull-right itemoffer">
											<a href="#" onClick="return backBooking();" class="btn-white dir-link btn"><span class="fa fa-file"></span> @lang('global.Back') </a>
											<a href="#" onClick="return updateBookTbl('{{$business->id}}');" class="btn-white dir-link btn "><span class="fa fa-file"></span> @lang('global.Update Booking') </a>
										</span>
									</div>
									<!-- EOF TABLE BOOKING -->
								</div> 
							</div>
							<!--/ Booking Section -->
							
							<!-- BOF Gift Certificate Section -->
							<div class="col-sm-11">
							
								<div class="offer-list-card" style="margin-bottom: 15px;">
									<div class="offer-list-card-title">
										<strong> @lang('global.Gift Certificate') </strong>
										<span id="viewGiftMsg" class="pull-right" style="color: green; display: none;"><small> @lang('global.Successfully updated.') </small></span>
									</div>
									
									<div class="offer-list-card-content" id="viewPanel">
										<span id="show_access"> 
											<label class="control-label" id="status_panel">
												@if(isset($business->gifting) && $business->gifting ==1)
													{{ t('Enabled') }} 
												@else
													{{ t('Disabled') }} 
												@endif
											</label>
										</span>
										<span class="pull-right itemoffer">
											{{ Form::hidden('biz_id', $business->id, array('id' => 'biz_id','class' => 'form-control')) }}
											<button class="btn btn-xs btn-default" onClick="editGift()" id="editGift"> <i class="fa fa-edit"></i> </button>
										</span>
									</div> 
								
									<div id="viewGift" style="display: none;">
										<div class="offer-list-card-content">
											<span> 
												@if(isset($business->gifting) && $business->gifting ==1 )
													{{--*/ $chk = 'checked="checked"'; /*--}}
												@else	
													{{--*/ $chk = ''; /*--}}
												@endif
												{{ Form::checkbox('gift_status', 1, $chk, ['id' => 'gift_status','style' => 'margin: 0 10px 0 20px;']) }} <span id="status" style='margin: 0 3px 0 0;'> @lang('global.Enable') </span>@lang('global.Gift Certificate')
											</span>
										</div> 
										<div class="offer-list-card-content" id="viewAmount" style="display: none;">
											<span> 
												<strong> @lang('global.Pick Certificate Prices') </strong> </br></br>
												<div id="amount_div">
													<label>
													
														{{--*/ $yes	= false; /*--}}
														{{--*/ $values = unserialize($business->gift_info); /*--}}
														
														@if(isset($giftPrice) && $giftPrice != '')
															{{--*/ $i = 1; /*--}}
															@foreach($giftPrice as $key => $value)
																
																@if($business->gifting == 1 && $values != '' && in_array($key, $values))
																	{{--*/ $yes	= true; /*--}}
																@else
																	{{--*/ $yes	= false; /*--}}
																@endif
																
																<div class="col-sm-3" style="padding:0 6px;"> <label> {{ Form::checkbox('gift_amount['.$key.']', $key, $yes, ['id' => 'gift_amount_'.$i,'class' => 'gift_amount']) }} @if(count($business->currency) >0) {{ $business->currency }} @endif {{ $value }} </label></div>
															
																{{--*/ $i++; /*--}}
															
															@endforeach
														@endif
													</label>
												</div>
											</span>
										</div> 
										<div class="offer-list-card-content pull-right">
											<button class="btn btn-sm" onClick="" id="backEdit"> <i class="fa fa-chevron-left"></i> </button>
											<button class="btn btn-sm btn-success" onClick="saveGift()" id="saveGift"> <i class="fa fa-save"></i> </button>
										</div>
									</div>
								</div>
								
							</div>
							<!--/ EOF Gift Certificate Section -->
							
							<!-- Offer Info Add-->
							@if(isset($offers) && count($offers) == 0)
							<div class="col-sm-11" >
								<div class="offer-list-card" style="margin-bottom: 15px;">
									<div class="offer-list-card-title">
										<strong> @lang('global.Offers & Discounts') </strong>
									</div>
									<div class="offer-list-card-content">
										<p> @lang('global.Empty!') </p>
									</div> 
								</div>
								<div class="col-md-12" style="padding:0; margin-top: -20px;"> <a href="{{lurl('account/addbizoffer/'.$business->id)}}" class="dir-link btn"><span class="fa fa-plus"></span> @lang('global.Add Offers') </a> </div>
							</div>
							@endif
							<!--/ Offer Info Add-->
							
							<!-- Offer Info Edit-->
							@if(isset($offers) && count($offers) > 0)
							<div class="col-sm-11" >
							
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
										<span> @if($offer->offertype == 2 || $offer->offertype == 4 && $business->currency) {{ $business->currency }} @endif {{ $offer->percent }} @if($offer->offertype == 1) @lang('global.% off') @elseif($offer->offertype == 2) @lang('global.off') @elseif($offer->offertype == 3) @lang('global.free') @elseif($offer->offertype == 4) @lang('global.for') @endif {{ $offer->content }} </span>
										
										<span class="pull-right itemoffer">
											<a href="{{ lurl('account/editbizoffer/'.$offer->id) }}"><button class="btn btn-xs btn-default"><i class="fa fa-edit"></i></button></a>
											<a href="{{ lurl('account/'.$business->id.'/deletebizoffer/'.$offer->id) }}" onClick="return confirm('{{ t('Are you Sure?') }}')" ><button class="btn btn-xs btn-primary"><i class="fa fa-trash"></i></button></a>
										</span>
					 
									</div> 
								 </div>
								@endforeach
								
								<div class="col-md-12" style="padding:0; margin-top: -20px;"> <a href="{{lurl('account/addbizoffer/'.$business->id)}}" class="dir-link btn"><span class="fa fa-plus"></span> @lang('global.Add More Offers') </a> </div>
							
							</div>
							@endif
							<!--/ Offer Info Edit-->
							
						</div>
						
						<!------OPEN RIGHT DIVISION------>
						<div class="col-sm-4 col-md-4"> 
						 <div class="row">  
							<div id="slider1_container" style="position: relative; width: 720px;
							height: 480px; overflow: hidden;">

								<!-- Loading Screen -->
								<div u="loading" style="position: absolute; top: 0px; left: 0px;">
									<div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
										background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
									</div>
									<div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
										top: 0px; left: 0px;width: 100%;height:100%;">
									</div>
								</div>

								<!-- Slides Container -->
								<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 720px; height: 480px; overflow: hidden;">
									@if(empty($thumb))
										<div>
											<img u="image" src="{{ url('/uploads/pictures/no-image.jpg') }}" width="100%" />
											<img u="thumb" src="{{ url('/uploads/pictures/no-image.jpg') }}" width="100%" />
										</div>
									@else
										{{!!$thumb!!}}
									@endif
								</div>
								
								<!-- Thumbnail Navigator Skin Begin -->
								<div u="thumbnavigator" class="jssort07" style="position: absolute; width: 720px; height: 100px; left: 0px; bottom: 0px; overflow: hidden; ">
									<div style=" background-color: #000; filter:alpha(opacity=30); opacity:.3; width: 100%; height:100%;"></div>
									<!-- Thumbnail Item Skin Begin -->
									
									<div u="slides" style="cursor: move;">
										<div u="prototype" class="p" style="POSITION: absolute; WIDTH: 99px; HEIGHT: 66px; TOP: 0; LEFT: 0;">
											<div u="thumbnailtemplate" class="i" style="position:absolute;"></div>
											<div class="o">
											</div>
										</div>
									</div>
									<!-- Thumbnail Item Skin End -->
									<!-- Arrow Navigator Skin Begin -->
								   
									<!-- Arrow Left -->
									<span u="arrowleft" class="jssora11l" style="width: 37px; height: 37px; top: 123px; left: 8px;">
									</span>
									<!-- Arrow Right -->
									<span u="arrowright" class="jssora11r" style="width: 37px; height: 37px; top: 123px; right: 8px">
									</span>
									<!-- Arrow Navigator Skin End -->
								</div>
								<!-- ThumbnailNavigator Skin End -->
								<!-- Trigger -->
							</div>
							</div>
							<!-- Jssor Slider End -->
						  
							<!------CLOSE SLIDER------>
							<div class="rows"> <a href="{{lurl('account/bizimages/'.$business->id)}}" class="dir-link btn"><span class="fa fa-edit"></span> {{ t('Change Picture') }} </a> </div>
							
							<!--Map View-->
							<div class="rows">
								<iframe width="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{$business->lat}},{{$business->lon}}&amp;key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></iframe>
								<!-- <img alt="Map" src="https://maps.googleapis.com/maps/api/staticmap?center={{$business->lat}},{{$business->lon}}&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}&zoom=10&size=200x150&key={{ config('services.googlemaps.key') }}" width="100%">
								<iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d15716.726967104516!2d76.3116122!3d10.0018418!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1489666418678" width="100%" height="100%" frameborder="0" style="border:1" allowfullscreen></iframe> -->
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

	<script src="{{ url('/assets/frontend/jssor/jssor.js') }}" type="text/javascript"></script>
	<script src="{{ url('/assets/frontend/jssor/jssor.slider.js') }}" type="text/javascript"></script>
	<script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $UISearchMode: 0,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $Loop: 2,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                    $SpacingX: 3,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 3,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 6,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 204,                          //[Optional] The offset position to park thumbnail,

                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 6                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$ScaleWidth(Math.min(parentWidth, 720));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
	
	<!--- BOF AJAX Script To Save/Edit Gift Certificate --->
	<script language="javascript">
		
		$(document).ready(function () {
			
			$("#gift_status").change(function() { 
				
				if($(this).is(':checked')) {
					$("#status").html("@lang('global.Disable')");
					$("#viewAmount").fadeIn("normal");
				} else {
					$("#status").html("@lang('global.Enable')");
					$("#viewAmount").fadeOut("normal");
				}
				
			}).trigger('change');
			
			$("#editGift").click(function(){
				
				$("#viewGift").fadeIn("normal");
				$("#viewPanel").fadeOut("normal");
			});
			
			$("#backEdit").click(function(){
				
				$("#viewGift").fadeOut("normal");
				$("#viewPanel").fadeIn("normal");
			});
			
		});
		
		function saveGift() {
			
			var i;
			var arr;
			var amount = '';
			var biz_id 	= $.trim($('#biz_id').val());
			var count 	= $('.gift_amount').length;
			
			if($("#gift_status").prop( "checked" )) {
				var status = 1;
			} else {
				var status = 0;
			}

			for (i = 1; i <= count; i++) {
				
				if($('#gift_amount_'+i).prop( "checked" )) {
				
					amount 	+=	$.trim($('#gift_amount_'+i).val())+'*';
				}
			}
			
			if(status == 1) {
				
				if(amount == '') {
					
					$('#amount_div').addClass("error_border");
					return false;
				}
				else {
					
					$('#amount_div').removeClass("error_border");
				}
			}
			
			if(biz_id != '') {
				
				$.ajax({
					
					url	: '{{url("/biz_gift")}}',
					type: 'get',
					data: {biz_id:biz_id,status:status,amount:amount},
					dataType:'json',
					success: function(data)					 
					{
						if(data == 1)
						{
							$("#viewGiftMsg").fadeIn("normal");
							setTimeout("$('#viewGiftMsg').fadeOut('normal');", 2000);
							$("#status_panel").html("{{ t('Enabled') }}");
						}
						else
						{
							$("#viewGiftMsg").fadeIn("normal");
							setTimeout("$('#viewGiftMsg').fadeOut('normal');", 2000);
							$("#status_panel").html("{{ t('Disabled') }}");
						}
					}
				});
			}
		}
		
	</script>
	<!--- EOF AJAX Script To Save/Edit Gift Certificate --->
	
	<script language="javascript">
	
		$('#tbl-slot-btn').click(function() {
			$('#tbl_select').removeClass("error_border");
			var tbl_from_val = $('#tbl-from').val();
			var tbl_from_txt = $('#tbl-from').find(":selected").text();
			var tbl_to_val = $('#tbl-to').val();
			var tbl_to_txt = $('#tbl-to').find(":selected").text();
			var seat_min_val = $('#seat-min').val();
			var seat_min_txt = $('#seat-min').find(":selected").text();
			var seat_max_val = $('#seat-max').val();
			var seat_max_txt = $('#seat-max').find(":selected").text();
			var tbl_table   = $('#tbl-table').val();
			$('.tbl-content-box').append('<div id="tbl_div">' + 
											'<ul style="width: 100%;">' +
												'<li style="width: 35%;">['+tbl_from_txt+' - '+tbl_to_txt+']</li>' +
												'<li style="width: 25%;">['+seat_min_txt+' - '+seat_max_txt+']</li>' +
												'<li style="width: 20%;">['+tbl_table+']</li>' +
												'<li style="width: 10%;">' +
													'<a href="#" class="rem-bh-tbl"><i class="fa fa-minus-square"></i></a>' +
													'<input name="booking_settings_tbl[]" value="'+tbl_from_val+'#'+tbl_to_val+'#'+seat_min_val+'#'+seat_max_val+'#'+tbl_table+'" type="hidden">' +
												'</li>' +
											'</ul>' +
										'</div>');
		});
		
		$('#tm-slot-btn').click(function() {
			$('#tm_select').removeClass("error_border");
			var tm_amount	= '';
			var tm_from_val = $('#tm-from').val();
			var tm_from_txt = $('#tm-from').find(":selected").text();
			var tm_to_val = $('#tm-to').val();
			var tm_to_txt = $('#tm-to').find(":selected").text();
			var tm_slot   = $('#tm-slot').val();
			var tm_price  = $('#tm-price').val();
			if(tm_price > 0 && tm_price != '') {
				var tm_amount  = '['+tm_price+'.00]';
			}
			$('.tm-content-box').append('<div id="tm_div">' + 
											'<ul style="width: 100%">' +
												'<li style="width: 35%">['+tm_from_txt+' - '+tm_to_txt+']</li>' + 
												'<li style="width: 25%">'+tm_amount+'</li>' + 
												'<li style="width: 20%">['+tm_slot+']</li>' + 
												'<li style="width: 10%">' +
													'<a href="#" data-id="'+tm_from_val+'#'+tm_to_val+'#'+tm_price+'#'+tm_slot+'" class="rem-bh"><i class="fa fa-minus-square"></i></a>' +
													'<input name="booking_settings[]" value="'+tm_from_val+'#'+tm_to_val+'#'+tm_price+'#'+tm_slot+'" type="hidden">' +
												'</li>' + 
											'</ul>' + 
										'</div>');				
		});
		
		$('#tbl-from').change(function() {
			setTblHrs();
		});
		
		function setTblHrs(){
			var fltrVal =  parseFloat($('#tbl-from').val());
			$('#tbl-to').children("option").filter(function() {
				return  (parseFloat(this.value) <= fltrVal) &&  (parseFloat(this.value) != 0);
			}).prop("disabled", true);
			
			$('#tbl-to').children("option").filter(function() {
				return  parseFloat(this.value) > fltrVal;
			}).prop("disabled", false);
			
			$('#tbl-to').children("option").filter(function() {
				return  parseFloat(this.value) == 0;
			}).prop("selected", true);
		}
		
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
			$('#tm_div').remove();
			return false;
		});
		
		$(".tbl-content-box").delegate("a.rem-bh-tbl", "click", function(){
			$('#tbl_div').remove();
			return false;
		});
		
		$(".tbl-content-box").delegate("a.rem-bhd-tbl", "click", function(){
			//$(this).parent('div').remove();
			var par = $(this).parent('div');
			var ele = $(this);
			var set = par.find("[name='booking_settings_tbld[]']").val();
			$(this).replaceWith( '<img src="/images/loading-new.gif" width="15">' );
			$.ajax({
				url: "{{ lurl('biz_bookTmCheck') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'set':set, 'type':'5'},
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
		
		$(".tm-content-box").delegate("a.rem-bhd", "click", function(){
			//$(this).parent('div').remove();
			var par = $(this).parent('div');
			var ele = $(this);
			//var set = par.find("[name='booking_settingsd[]']").val();
			var set = $(this).data('id');
			
			//alert($(this).data('id'));return false;
			$(this).replaceWith( '<img src="/images/loading-new.gif" width="15">' );
			$.ajax({
				url: "{{ lurl('biz_bookTmCheck') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'set':set},
				dataType:'json',
				success: function(data)
				{
					if(data['status']=='success'){
						//par.remove(); 
						$('div#tmbox_' + set).remove();
						$('#showMsg').fadeIn('normal');
						setTimeout("$('#showMsg').fadeOut('normal');", 2000);
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
			$("#bizBook").parent('span').removeClass('error_border');
			$('[name="booking_type"]').closest('div').removeClass('error_border');
			var booking_type =  parseInt($('[name="booking_type"]:checked').val());
			var booking =  parseInt($("#bizBook:checked").val());
			if(booking==1){
				if(booking_type==3){
					$('#bookOpen').fadeOut("normal", function (){
						$('#bookOpenNext'+booking_type).fadeIn("normal");
					});
				
				}else if(booking_type==5){
					$('#bookOpen').fadeOut("normal", function (){
						$('#bookOpenNext'+booking_type).fadeIn("normal");
					});
				}else{
					$('[name="booking_type"]').closest('div').addClass('error_border');
				}
			}else{
				$("#bizBook").parent('span').addClass('error_border');
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
		
		function updateBookTbl(){
			$('#tbl_select').removeClass("error_border");
			var booking =  $('#bizBook:checked').length;
			var booking_type =  parseInt($('[name="booking_type"]:checked').val());
			var forFlag = 0;
			var booking_settings = '';
			$("[name='booking_settings_tbl[]']").each(function( index ) {
			  booking_settings += $( this ).val()+'V#V';
			  forFlag = 1;
			});
			$("[name='booking_settings_tbld[]']").each(function( index ) {
			  forFlag = 1;
			});
			if(forFlag == 0){
				$('#tbl_select').addClass("error_border");
				return false;
			}
			$('#showMsgTbl').fadeIn('normal');
			setTimeout("$('#showMsgTbl').fadeOut('normal');", 2000);
			$.ajax({
				url: "{{ lurl('biz_book') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'booking':booking, 'booking_type':booking_type, 'booking_settings':booking_settings},
				dataType:'json',
				success: function(data)
				{
					$('#bookSetStatuz').html(data['statusInfo']);
					$('.tbl-content-box').html(data['content']);
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
					$('#bookSetStatuz').html(data['statusInfo']);
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
			
		});
		
	</script>
	
	@parent	
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@endsection
