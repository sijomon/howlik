@extends('classified.layouts.layout')

@section('content')
	<style>
		.btn-loctn{
			/*margin-top:30%;*/
			margin:1rem 0;
		}
		.bordr-btm{
			border-bottom:1px solid #ccc;
			padding-bottom:1rem;
		} 
		.bordr-btm:last-child{
			border:none;
		}
		.d-box-div1 {
			height: 80px;
		}
		.claim-btn{
			padding:5px;
			font-size:12px;
			color:#666;
			border:1px dashed #666;
			border-radius:5px;
			z-index:999;
		}
		.claim-btn:hover{
			cursor:pointer;
		}
		.scam_div{
			position:absolute;
			right:0;
			top:30px;
			background:#f6f6f6;
			padding:10px;
			min-width:241px;
			border-radius:0 0 5px 5px;
			display:none;
			border:1px solid #eee;
			display:none;
			z-index:999;
		}
		font{
			float: right;
			margin-right: 15px;
			margin-top: 11px;
			padding-bottom: 8px;
		}
	</style>

	{{--*/ $title = $business->title; /*--}}
	{{--*/ $description = substr($business->description, 0, 55); /*--}}
	{{--*/ $city_name = ''; /*--}}
	@if(!empty($business->city))
		{{--*/ $city_name = $business->city->asciiname; /*--}}
	@endif
	@if(strtolower($lang->get('abbr'))=='ar')
		{{--*/ $title = $business->title_ar; /*--}}
		{{--*/ $description = substr($business->description_ar, 0, 55); /*--}}
		@if(!empty($business->city))
			{{--*/ $city_name = $business->city->name; /*--}}
		@endif
	@endif
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
	<!-- BOF CONTENTS -->
	<div class="content-holder">
		<!-- BOF CONTAINER -->
		<div class="container"> 
			
			<!-- BOF SHOW ERROR MESSAGES -->
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
			<!-- EOF SHOW ERROR MESSAGES -->
			
			<!-- BOF SHOW FLASH MESSAGES -->
			@if(Session::has('flash_notification.message'))
				<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
					<div class="row">
						<div class="col-lg-12">
							@include('flash::message')
						</div>
					</div>
				</div>
			@endif
			<!-- EOF SHOW FLASH MESSAGES -->
				
			<!-- BOF BREADCRUMB -->
			<div class="page-details">
				<ul class="breadcrumb">
					<li><a href="{{ lurl('/') }}"> {{ t('Home') }} </a></li>
					<li><a href="{{lurl('c/'.trim($cat->slug))}}"> {{ ucwords($cat->name) }} </a></li>
					<li class="active"> {{ ucwords($title) }} </li>
				</ul>
			</div>
			<!-- EOF BREADCRUMB -->
		  
			<!-- BOF SECTION -->
			<div class="section"> 
				<!-- BOF Slider -->
				<div class="col-md-4 col-sm-4 _Detail_slider" id="topslider">
					<div class="detail-row">
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
							
							@if(isset($picBigUrl))
							<div class="active item" data-slide-number="{{$key}}"> 
								<img src="{{ $picBigUrl }}" width="100%">
								<div class="slider-overlay">
									<h2> {{ str_limit(ucwords($title), 30) }} </h2>
									<p class="slider-city-name"> {{ $city_name }} </p>
								</div>
							</div>
							@else
							<div class="active item" data-slide-number="0"> <img src="{{url('uploads/pictures/no-image.jpg')}}" width="100%">
								<div class="slider-overlay">
									<h2> {{ str_limit(ucwords($title), 30) }}</h2>
									<p class="slider-city-name"> {{ $city_name }} </p>
								</div>
							</div>
							@endif
							
							<!-- Thumbnail Navigator Skin Begin -->
							<div u="thumbnavigator" class="jssort07" style="position: absolute; width: 720px; height: 100px; left: 0px; bottom: 0px; overflow: hidden; ">
								<div style=" background-color: #000; filter:alpha(opacity=30); opacity:.3; width: 100%; height:100%;"></div>
								<!-- Thumbnail Item Skin Begin -->
								
								<div u="slides" style="cursor: move;">
									<div u="prototype" class="p" style="position: absolute; WIDTH: 99px; HEIGHT: 66px; TOP: 0; LEFT: 0;">
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
                        <!-- Jssor Slider End -->
					</div>
				</div>
				</div>
				<!-- EOF Slider-->
			
				<!-- BOF Details Listing -->
				<div class="col-md-8 col-sm-8">
					<div class="detail-row">
						<div class="company-name">
							<h2> {{ ucwords($title) }} 
							@if(isset($business->user_id) && $business->user_id>1)
								<span class="span_claimed">{{t('Claimed')}}</span>
							@else
								<a  class="claim-btn" onclick="return false();" data-toggle="modal" data-target="#claimModal" > {{ t('Claim this business')}}</a>
							@endif
							</h2>
							
						</div>
                        
                        <!-----BOF RATING HOLDER----->
						<div class="rating-holder"> 
							<h4 class="top-rated"> 
							@if(isset($reviewArr) && count($reviewArr) > 0)
								
								{{--*/ $sum	= 0; /*--}}
								{{--*/ $cnt	= 0; /*--}}
								{{--*/ $avg	= 0; /*--}}
								
								@foreach($reviewArr as $key => $reviewCount)
									{{--*/ $sum += $reviewCount->rating; /*--}}
									{{--*/ $cnt += count($reviewCount->rating); /*--}}
								@endforeach 
								
								{{--*/ $avg	= $sum/$cnt ; /*--}}
								{{--*/ $dif	= 5 - $avg; /*--}}
								
								@if($avg > 0)
									@if(strlen($avg) == 1)
										@for($i=0;$i < $avg;$i++)
											<span class='fa fa-star'></span>
										@endfor
										@for($i=0;$i < floor($dif);$i++)
											<span class='fa fa-star-o'></span>
										@endfor
									@else
										{{--*/ $rate =	floor($avg); /*--}}
										@for($i=0;$i < $rate;$i++)
											<span class='fa fa-star'></span>
										@endfor
										<span class='fa fa-star-half-o'></span>
										@for($i=0;$i < floor($dif);$i++)
											<span class='fa fa-star-o'></span>
										@endfor
									@endif
								@else
									@for($i=0;$i < 5;$i++)
										<span class='fa fa-star-o'></span>
									@endfor		
								@endif
							@else
								@for($i=0;$i < 5;$i++)
									<span class='fa fa-star-o'></span>
								@endfor		
							@endif
							
							<small>
							@if(isset($reviewArr) && count($reviewArr) > 0)
								<span class="ratingcount"> {{ count($reviewArr) }}  {{ t('Reviews') }} </span>
							@else
								<span class="ratingcount"> 0 {{ t('Reviews') }} </span>
							@endif
							</small>
							
							@if(isset($reviewArr) && count($reviewArr) > 0)
								
								{{--*/ $dolsum	= 0; /*--}}
								{{--*/ $dolcnt	= 0; /*--}}
								{{--*/ $dolavg	= 0; /*--}}
								
								@foreach($reviewArr as $key => $reviewCount)
									{{--*/ $dolsum += $reviewCount->expense; /*--}}
									{{--*/ $dolcnt += count($reviewCount->expense); /*--}}
								@endforeach 
								
								{{--*/ $dolavg	= $dolsum/$dolcnt ; /*--}}
								{{--*/ $doldif	= 5 - $dolavg; /*--}}
								
								@if($dolavg > 0)
									
									@if(strlen($dolavg) == 1)
										@for($i=0;$i < $dolavg;$i++)
											<span class='fa fa-dollar' style="color: #00991f"></span>
										@endfor
										@for($i=0;$i < floor($doldif);$i++)
											<span class='fa fa-dollar' style="color: #999999"></span>
										@endfor
									@else
										{{--*/ $erate =	floor($dolavg); /*--}}
										@for($i=0;$i < $erate;$i++)
											<span class='fa fa-dollar' style="color: #00991f"></span>
										@endfor
										<span class='fa fa-dollar' style="color: #999999"></span>
										@for($i=0;$i < floor($doldif);$i++)
											<span class='fa fa-dollar' style="color: #999999"></span>
										@endfor
									@endif
								@else
									@for($i=0;$i < 5;$i++)
										<span class='fa fa-dollar' style="color: #999999"></span>
									@endfor		
								@endif
							@else
								@for($i=0;$i < 5;$i++)
									<span class='fa fa-dollar' style="color: #999999"></span>
								@endfor		
							@endif
							
							</h4>
							<div class="pull-right"> <span class="mt-dollar"> </span> </div>
                            
                            <!-----BOF ACTION HOLDER----->
                            <div class="action-holder">
                            <div class="dropdown">
								@if (!isset($reviews) && auth()->user() && $business->user_id != $user->id)
								<a class="write-review"><span class="fa fa-star-half-o"></span> {{ t('Write A Review') }} </a> 
								@endif
								<a @if(!auth()->user()) href="{{ lurl('/redirect/'.Request::segment(2).'/'.$business->id) }}" @endif class="add-photo" <?php if(auth()->user()) {?> onclick="return false();" data-toggle="modal" data-target="#adModal" <?php } ?> > <span class="fa fa-camera"></span> {{ t('Add a Photo') }} </a> 
								<a data-toggle="modal" data-target=".bd-share-modal-md" class="share"><span class="fa fa-share"></span> {{ t('Share') }} </a> 
								@if(isset($locationArr) && count($locationArr) > 1) <a data-toggle="modal" data-target=".bd-location-modal-md" class="share"><span class="fa fa-map-signs"></span> {{ t('Location') }} </a> @endif 
                                <a href="javascript:void(0);" class="write-review" id="scam"> <i class="fa fa-warning"></i></a>
                                  <div class="scam_div" id="scam_div">
								    @if($bscamFlag==1)
									<p style="color:#fc0000; text-align:center;"><i class="fa fa-warning"></i>&nbsp{{t('Already Reported!')}}</p>	
									@else
									<label>{{t('Reason')}}</label>
                                    <textarea style="margin-bottom:10px;" name="rep_msg" id="rep_msg" class="form-control" type="text"></textarea>
                                    <button class="btn btn-info" onclick="report_this();" style="float:right;">{{t('Report this business')}}</button>
									@endif
								  </div>
                                </div>
                            </div>
                            <!-----EOF ACTION HOLDER----->
                            
						</div>
                        <!-----EOF RATING HOLDER----->
                        
						<p class="company-content"> {{ str_limit(ucwords($description), 50) }} </p>
						<div class="directory">
							<div class="col-md-4 col-sm-4 _Map_holder" >
								<div class="row">
									@if(config('settings.show_ad_on_googlemap'))
										<iframe width="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={{$business->lat}},{{$business->lon}}&amp;key={{ config('services.googlemaps.key') }}"></iframe>
										<!-- <img alt="Map" src="https://maps.googleapis.com/maps/api/staticmap?center={{$business->lat}},{{$business->lon}}&markers=color:red%7Clabel:%7C{{$business->lat}},{{$business->lon}}&zoom=10&size=200x150&key={{ config('services.googlemaps.key') }}" width="100%"> -->
									@endif
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-box1">
									<div class="d-box-div1"> <img src="{{url('assets/frontend/images/placeholder.svg')}}"> </div>
									<div class="d-box-div2">
										<p class="span1">{{ ucfirst($business->address1) }}</p>
										<p class="span2">{{ ucfirst($city_name) }}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-box1">
									<div class="d-box-div1"> <img src="{{url('assets/frontend/images/phone.svg')}}"> </div>
									<div class="d-box-div2">
										<p class="span3">{{$business->phone}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-box2">
									<div class="d-box-div1"> <img src="{{url('assets/frontend/images/direction.svg')}}"> </div>
									<div class="d-box-div2"> <a href="#" class="span3" data-toggle="modal" data-target="#myModal"> {{ t('Get Direction') }} </a> </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="d-box2">
									<div class="d-box-div1"> <img src="{{url('assets/frontend/images/web.svg')}}"> </div>
									<div class="d-box-div2"> <a href="{{ $business->web }}" target="_blank" class="span3"> {{ ucwords($business->web) }} </a> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- EOF Details Listing -->
				
				<!-- BOF Get Direction Modal -->
				<div id="myModal" class="modal fade" role="dialog">
					<div class="modal-dialog" style="width:95%;">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">{{ ucfirst($title).', '.ucfirst($city_name) }}</h4>
							</div>
							<div class="modal-body">
								<iframe src="{{lurl('map/'.$business->id)}}" width="100%" height="400" style="border:none;"></iframe>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">{{t('Close')}}</button>
							</div>
						</div>
					</div>
				</div>
				<!-- EOF Get Direction Modal -->
				
				<!-- BOF Get Claim Modal -->
				<div id="claimModal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
					<div class="modal-dialog" style="width:95%;">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">{{ ucfirst($title).', '.ucfirst($city_name) }}</h4>
							</div>
							<div class="modal-body">
								<iframe src="{{lurl('claim/'.$business->id)}}" width="100%" height="500" style="border:none;"></iframe>
							</div>
						</div>
					</div>
				</div>
				<!-- EOF Get Claim Modal -->
				
				<!-- BOF Add Photos Modal -->
				<div id="adModal" class="modal fade" role="dialog">
					<div class="modal-dialog" style="width:95%;">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">{{ ucfirst($title).', '.ucfirst($city_name) }}</h4>
							</div>
							<div class="modal-body">
								<div class="col-sm-12 page-content">
									<div class="alert alert-success" id="success-alert" style="display: none;">
										<button type="button" class="close" data-dismiss="alert">x</button>
										<strong> @lang('global.Your Photos Uploaded Successfully.') </strong> @if(auth()->user() && $user->id != $business->user_id) @lang('global.Please wait some time for the approval.') @endif @lang('global.You can upload more photos here and also you can remove images uploaded just before.')
									</div>
									<div class="alert alert-danger" id="danger-alert" style="display: none;">
										<button type="button" class="close" data-dismiss="alert">x</button>
										<strong> @lang('global.Your Photo Uploading Failed.') </strong> @lang('global.Please remove the selected image and Try again.')
									</div>
									<div class="inner-box category-content">
										<h2 class="title-2"><strong> <i class="icon-docs"></i>{{t('Image Upload')}}</strong></h2>
										<div class="col-sm-12">
											<form action="" enctype="multipart/form-data" id="imgUpload" method="post">
												<div class="image_drop" style="margin-top:0;">
													<div class="dropzone" style="margin-bottom:0;" name="requestbizdropzone" id="requestbizdropzone"> </div>
													<p>{{ t('we recommend usung at least a 2160x1080px(2:1ratio) image thats no larger than 10MB learn more') }}</p>
												</div>
												<input type="hidden" id="biz_id" name="biz_id" value="{{ $business->id }}"/>
												@if(auth()->user())<input type="hidden" id="usr_id" name="usr_id" value="{{ $user->id }}"/>@endif
												<input type="hidden" id="imge1" name="imge1" value=""/>
												{!! Form::token() !!}
												<!-- <div class="pull-right">
													<button type="button" class="btn btn-default btn-md" data-dismiss="modal">{{t('Cancel')}}</button>
													<button type="submit" class="btn btn-success btn-md" id="postrequest"> {{ t('Upload') }} </button>
												</div> -->
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer"> 
								<button type="button" class="btn btn-default" data-dismiss="modal">{{t('Close')}}</button>
							</div>
						</div>
					</div>
				</div>
				<!-- EOF Add Photos Modal -->
				
			</div>
			<!-- EOF SECTION -->
			
			<!-- BOF SECTION ONE -->
			<div class="section-one"> 
				<!-- BOF SIDE NAVIGATION -->
				<div class="col-md-3 _Rev_NAV">
					<ul class="side_nav">
						<li class="active"><a data-toggle="pill" href="#review"> {{ t('Review') }} </a></li>
						<li><a data-toggle="pill" href="#description"> {{ t('Description') }} </a></li>
						<li><a data-toggle="pill" href="#addinfo"> {{ t('Additional Information') }} </a></li>
					</ul>
				</div>
				<!-- EOF SIDE NAVIGATION --> 
			
				<!-- BOF NAVIGATION CONTENT SECTION -->
				<div class="col-md-6 _Rev_NAV_det">
					<div class="tab-content"> 
						<!-- BOF REVIEW SECTION -->
						<div id="review" class="tab-pane fade in active">
						
							<!-- BOF WRITE A REVIEW -->
							@if (!isset($reviews) && auth()->user() && $business->user_id != $user->id)
							<h2 class="head-title"> {{ t('Write a Review') }} </h2>
							<div class="c-row">
								<form name="post_review" method="POST" action="{{ lurl('/place/reviews') }}" id="post_review">
									{!! csrf_field() !!}
									<div class="star-rating-div"> 
										<div class="col-md-6" id="rating-div">
											<label for="rating" class="control-label"> {{ t('Rate This') }} </label>
											<input id="rating" name="rating" class="rating" min="1" max="5" data-size="xs" data-show-clear="false" data-show-caption="false" />
										</div>
										<div class="col-md-6" id="expense-div">
											<label for="expense" class="control-label label-expence"> {{ t('Cost') }} </label>
											<input id="expense" name="expense" class="expense" min="1" max="5" data-size="xs" data-show-clear="false" data-show-caption="false" />
										</div>
										<div class="col-md-12 rating-comment-div">
											<textarea id="review" name="review" placeholder="{{ t('Comments') }}" rows="2" class="form-control" ></textarea>
										</div>
									</div>
									<!---<div class="rating-comment-div" id="comment-div">
										<textarea id="review" name="review" placeholder="{{ t('Comments') }}" rows="2" class="form-control" ></textarea>
									</div>--->
									<button type="submit" class="btn btn-md btn-primary btn-right"> {{ t('Send') }} </button>
									{{ Form::hidden('biz_id', $business->id) }}
									{{ Form::hidden('usr_id', $user->id ) }}
									{{ Form::hidden('usr_nm', $user->name) }}
								</form>
							</div>
							<!-- EOF WRITE A REVIEW -->
							@endif
							
							<!-- BOF REVIEW LIST -->
							<h2 class="head-title"> {{ t('Reviews') }} </h2>
							<div class="c-row">
								@if(isset($reviewArr) && count($reviewArr) > 0)
									@foreach($reviewArr as $review)
									<div class="col-md-2 col-sm-2"> 
										{{--*/ $userArr = \DB::table('users')->select('users.photo')->where('users.id',$review->user_id)->get(); /*--}}
										@if(!empty($userArr))
											@foreach($userArr as $userss)
												@if($userss->photo != '')
													<img src="{{ url('uploads/pictures/dp/'.$userss->photo) }}" alt="No Image" class="review-img-1" />
												@else
													<img src="{{ url('uploads/pictures/dp/1489643127.png') }}" alt="No Image" class="review-img-1" /> 
												@endif											
											@endforeach
										@else	
											<img src="{{ url('uploads/pictures/dp/1489643127.png') }}" alt="No Image" class="review-img-1" /> 
										@endif
									</div>
									<div class="col-md-10 col-sm-10" style="margin-bottom: 30px;">
										<div class="col-md-12">
											<div>
												<h4 class="head-title">
													@if($review->user_id != 0)
														<a href="{{ lurl('profiles/'.$review->user_id) }}"> {{ ucfirst($review->user_name) }} </a>
													@else
														{{ ucfirst($review->user_name) }}
													@endif
													<div class="right_exp_rate">
													{{--*/ $diff	= 5 - $review->rating; /*--}}
													{{--*/ $difff	= 5 - $review->expense; /*--}}
													@if($review->rating > 0 && strlen($review->rating) == 1)
														<div class="star-right">
															@for($i=0;$i < $review->rating;$i++)
																<span class='fa fa-star'></span>
															@endfor
															@for($i=0;$i < floor($diff);$i++)
																<span class='fa fa-star-o'></span>
															@endfor
														</div>
													@else
														<div class="star-right">
															{{--*/ $rate	=	floor($review->rating); /*--}}
															@for($i=0;$i < $rate;$i++)
																<span class='fa fa-star'></span>
															@endfor
															<span class='fa fa-star-half-o'></span>
															@for($i=0;$i < floor($diff);$i++)
																<span class='fa fa-star-o'></span>
															@endfor
														</div>
													@endif
													@if($review->expense > 0 && strlen($review->expense) == 1)
														<div class="doll-right">
															@for($i=0;$i < $review->expense;$i++)
																<span class='fa fa-dollar' style="color: #00991f"></span>
															@endfor
															@for($i=0;$i < floor($difff);$i++)
																<span class='fa fa-dollar' style="color: #999999"></span>
															@endfor
														</div>
													@else
														<div class="doll-right">
															@for($i=0;$i < 5;$i++)
																<span class='fa fa-dollar' style="color: #999999"></span>
															@endfor
														</div>
													@endif
													</div>
												</h4>
											</div>
											<div><p> {{ ucwords($review->review) }} </p></div>
											<div class="pull-right">
												<h6>{{ date("dS F Y",strtotime($review->created_at)) }}
												 <h6>
											</div>
										</div>
									</div>
									@endforeach	
								@else
									<div class="col-md-2 col-sm-2">
										{{--*/ $userAr = \DB::table('users')->select('users.photo')->where('users.id',$business->user_id)->get(); /*--}}
										@if(count($userAr) > 0)
											@foreach($userAr as $usersss)
												@if($usersss->photo != '')
													<img src="{{ url('uploads/pictures/dp/'.$usersss->photo) }}" alt="No Image" class="review-img-1" /> 
												@else
													<img src="{{ url('uploads/pictures/dp/1489643127.png') }}" alt="No Image" class="review-img-1" /> 
												@endif	
											@endforeach
										@else	
											<img src="{{ url('uploads/pictures/dp/1489643127.png') }}" alt="No Image" class="review-img-1" /> 
										@endif
									</div>
									<div class="col-md-10 col-sm-10">
										<div class="col-md-12">
											<div> &nbsp; </div>
											<div><p> {{ t('No More Reviews..!') }} </p></div>
											<div class="pull-right"> &nbsp; </div>
										</div>
									</div>
								@endif	
							</div>
							<!-- EOF REVIEW LIST -->
							
						</div>
						<!-- EOF REVIEW SECTION --> 
				
						<!-- BOF Description -->
						<div id="description" class="tab-pane fade">
							<h2 class="head-title"> {{ ucfirst($title) }} </h2>
							<p class="detail-desc"> 
								@if($description != '') {{ ucwords($description) }} @else {{ t('No More Descriptions..!') }} @endif
							</p>
						</div>
						<!-- EOF Description --> 
						
						<!-- BOF Additional Information -->
						<div id="addinfo" class="tab-pane fade">
							<div class="col-sm-12"> <h2 class="head-title"> {{ t('Informations') }} </h2> </div> </br>
							<div class="col-sm-12"></br></br>
								@if(!empty($busInfoA))
									@foreach($busInfoA as $key => $vals)
										<div class="col-sm-6">
											<div class="col-sm-8"> <p style="margin-top: 10px; margin-bottom: 10px;"> {{ $vals['label'] }}  </p> </div> 
											<div class="col-sm-4"> <p style="margin-top: 10px; margin-bottom: 10px;"> <b> {{ $vals['value'] }} </b>  </p> </div> 
										</div>
									@endforeach
								@else {{ t('No More Informations..!') }} @endif
							</div>
						</div>
						<!-- EOF Additional Information --> 
					
						<!-- BOF BUSINESS BOOKING --> 
						@if (auth()->user())
							@if(isset($business->booking ) && $business->booking =='1')
								@if($business->booking_type==5)
									<!-- BOF TABLE BOOKING -->
									<div id="booktable" class="tab-pane fade">
										<h2>{{t('Make a Reservation')}}</h2>
										<div class="time-slot-section" id="table_search"> 
											<div class="table-book-div">
												<div class="col-sm-12 ">
													<div class="row-m_b">
														<label class="tble-label">{{t('Date')}}</label>
														<input type="text" id="sr_date" class="form form-control tble-inp" placeholder="{{ t('Pick Date')}}">
														<span class="span-table-book"><i class="fa fa-calendar-check-o"></i></span>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="row-m_b">
														{{--*/ $mn_tm	= 0; /*--}}
														{{--*/ $mx_tm	= 0; /*--}}
														{{--*/ $st_tm	= 0; /*--}}
														@if(isset($rangesTbl) && count($rangesTbl) > 0)
															@foreach($rangesTbl as $range)
																{{--*/ $st_tm = date('h:i A',strtotime($range->min_time)); /*--}}
																{{--*/ $mn_tm = $range->min_time; /*--}}
																{{--*/ $mx_tm = $range->max_time; /*--}}
															@endforeach
														@endif
														<label class="tble-label"> {{t('Time')}} </label>
														<select class="form form-control tble-inp sr_time" id="sr_time">
															@if($st_tm > 0 && $mn_tm > 0 && $mx_tm > 0)
																{{--*/ $time =	$st_tm; /*--}}
																{{--*/ $dif	 =	$mx_tm - $mn_tm; /*--}}
																@for ($i = 0; $i <= $dif*2; $i++)
																	<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}</option>
																	{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
																@endfor
															@else
																{{--*/ $time		= strtotime('12:00 AM'); /*--}}
																@for ($i = 0; $i < 48; $i++)
																	<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}</option>
																	{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
																@endfor
															@endif
														</select>
														<span class="span-table-book"><i class="fa fa-clock-o"></i></span>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="row-m_b">
														{{--*/ $mn_st	= 0; /*--}}
														{{--*/ $mx_st	= 0; /*--}}
														@if(isset($rangesTbl) && count($rangesTbl) > 0)
															@foreach($rangesTbl as $range)
																{{--*/ $mn_st = $range->min_seat; /*--}}
																{{--*/ $mx_st = $range->max_seat; /*--}}
															@endforeach
														@endif
														<label class="tble-label">{{t('No of People')}}</label>
														<select class="form form-control tble-inp sr_people" id="sr_people">
															@if($mn_st > 0 && $mx_st > 0)
																@for ($i = $mn_st; $i <= $mx_st; $i++)
																	<option value="{{$i}}">{{$i}} {{t('people')}}</option>
																@endfor
															@else
																@for ($i = 1; $i < 11; $i++)
																	<option value="{{$i}}">{{$i}} {{t('people')}}</option>
																@endfor
															@endif
														</select>
														<span class="span-table-book"><i class="fa fa-users"></i></span>
													</div>
												</div>
											</div>
											<button class="btn find-table" onclick="return findatable();" >{{t('Find a Table')}}</button>
										</div>
							
										<div class="time-slot-div" id="table_details" style="display:none;">
											<table width="100%" border="0" cellspacing="0" cellpadding="2">
												<input type="hidden" name="tsbid" id="tsbid" value="">
												<tr>
													<td>{{t('Name')}}</td>
													<td><input type="text" name="tb_name" id="tb_name" value="{{ $user->name }}" class="time-slot-div-input"></td>
												</tr>
												<tr>
													<td>{{t('Email')}}</td>
													<td><input type="email" name="tb_email" id="tb_email" value="{{ $user->email }}" class="time-slot-div-input"></td>
												</tr>
												<tr>
													<td>{{t('Mobile')}}</td>
													<td><input type="text" name="tb_mobile" id="tb_mobile" value="{{ $user->phone }}" class="time-slot-div-input"></td>
												</tr>
												<tr>
													<td>{{t('Message')}}</td>
													<td><input type="text" name="tb_message" id="tb_message" value="" class="time-slot-div-input"></td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td><button class="btn btn-primary" onclick="cancelBookTable();"> {{t('Back')}} </button>
													<button class="comment btn" onclick="bookTable();" style="margin-left: 1% !important;"> {{t('Confirm Reservation')}} </button></td>
												</tr>
											</table>
										</div>
									</div>
									<!-- EOF TABLE BOOKING -->
									
									<!-- BOF TABLEBOOK MODAL -->
									<div id="table-book" class="modal fade" role="dialog">
										<div class="modal-dialog modal-sm"> 
											<!-- BOF Modal content -->
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">{{t('Pick Another Time')}}</h4>
												</div>
												<div class="modal-body">
													<p>{{t('Sorry, Pick Another Time.')}}</p>
												</div>
											</div>
											<!-- EOF Modal content -->
										</div>
									</div>
									<!-- EOF TABLEBOOK MODAL -->
								@elseif($business->booking_type==3)
									<!-- BOF Make An Appointment --> 
									<div id="makeappointment" class="tab-pane fade">
										<h2> {{t('Select Time Slot On').' '. date("d-m-Y", time())}}</h2>
										<div class="time-slot-section">
											<div class="time-slot-div" id="time_slot_select">
												<div class="time-slot-head">
													<div class="box-01"> <p>{{t('Start Time')}}</p> </div>
													<div class="box-02"> <p>{{t('End Time')}}</p> </div>
													<div class="box-03"> <p>{{t('Status')}}</p> </div>
												</div>
												
												@if(sizeof($bbtminfo)>0)
													@foreach($bbtminfo as $key => $value)
													{{--*/ $timeNow = date('H.i', time()); /*--}}
													{{--*/ $status = 0; /*--}}
													{{--*/ $clsBg = ''; /*--}}
													{{--*/ $price = $value->price; /*--}}
													@if($value->tm_from<=$timeNow)
														{{--*/ $status = 1; /*--}}
														{{--*/ $clsBg = 'graybg'; /*--}}
														{{--*/ $price = t('Passed'); /*--}}
													@elseif($value->booking >= $value->slots)
														{{--*/ $status = 2; /*--}}
														{{--*/ $clsBg = 'redbg'; /*--}}
													@endif
													<div class="time-slot-row {{$clsBg}}">
														<div class="box-01"> <p>{{date("h:i A", strtotime($value->tm_from))}}</p> </div>
														<div class="box-02"> <p>{{date("h:i A", strtotime($value->tm_to))}}</p> </div>
														<div class="box-03">
															<p>{{$price}}
															@if($status == 0)
																<a href="#" onclick="return bookTimeSlotNext({{$value->id}});"><span class="fa fa-plus-square span-action"></span></a>
															@else
																<span class="fa fa-plus-square span-action"></span>
															@endif
															</p>
														</div>
													</div>
													@endforeach
												@endif
											</div>
											<div class="time-slot-div" id="time_slot_details" style="display:none;">
												<table width="100%" border="0" cellspacing="0" cellpadding="2">
													<input type="hidden" name="tsbid" id="tsbid" value="">
													<tr>
														<td>{{t('Name')}}</td>
														<td><input type="text" name="tb_name" id="tb_name" value="{{ $user->name }}" class="time-slot-div-input"></td>
													</tr>
													<tr>
														<td>{{t('Email')}}</td>
														<td><input type="email" name="tb_email" id="tb_email" value="{{ $user->email }}" class="time-slot-div-input"></td>
													</tr>
													<tr>
														<td>{{t('Mobile')}}</td>
														<td><input type="text" name="tb_mobile" id="tb_mobile" value="{{ $user->phone }}" class="time-slot-div-input"></td>
													</tr>
													<tr>
														<td>{{t('Message')}}</td>
														<td><input type="text" name="tb_message" id="tb_message" value="" class="time-slot-div-input"></td>
													</tr>
													<tr>
														<td>&nbsp;</td>
														<td><button class="comment btn" onclick="bookTimeSlot();"> {{t('Confirm Reservation')}} </button></td>
													</tr>
												</table>
											</div>
										</div>
									</div>
									<!-- EOF Make An Appointment --> 
								@endif
							@endif
						@endif
						<!-- EOF BUSINESS BOOKING --> 
					</div>
				</div>
				<!-- EOF NAVIGATION CONTENT SECTION --> 
			
				<!-- BOF RIGHT SIDE INFO SECTION -->
				{{--*/ $bizhrsflag = 0; /*--}}
				{{--*/ $nowTm	= date("h:i A") /*--}}
				@if(isset($business->biz_hours ) && $business->biz_hours !='')
					{{--*/ $bizhrsflag = 1; /*--}}
					{{--*/ $bizhrs = unserialize($business->biz_hours); /*--}}
					{{--*/ $bizDayA = array(0=>'Mon',1=>'Tue',2=>'Wed',3=>'Thu',4=>'Fri',5=>'Sat',6=>'Sun'); /*--}}
				@endif
				<div class="col-md-3">
					@if($bizhrsflag && is_array($bizhrs))
						
						<!-- BOF STATUS -->
						<div class="open-now-box"> <img src="{{url('assets/frontend/images/clock.svg')}}" style="margin-top:34px">   
						<h5><b><span style="font-size: 15px;color: #14d41a;"> {{ t('Today') }}</span><br>
						@if($bizhrsflag)
							@foreach($bizhrs as $key => $value)
								{{--*/ $bizhrsA = explode(' ', $value); /*--}}
								@if($bizDayA[$bizhrsA[0]] == date("D"))
									{{--*/ $timeSt = strtotime($bizhrsA[1]); /*--}}
									{{--*/ $timeEd = strtotime($bizhrsA[2]); /*--}}
									{{--*/ $endTm	= date("h:i A", $timeEd); /*--}}
									{{--*/ $bizhrs2 = $bizhrsA[2];  /*--}}
									<span style="float:left;margin-top:18px; "> 
										{{ date("h:i A", $timeSt) }} - {{ date("h:i A", $timeEd) }} 
									</span><br>
								@endif
							@endforeach	
						@endif
						
						
						
						
						
						@if(isset($endTm) && $endTm!='')
								<small> {{($bizhrs2=='00.00')?'(midnight next day)':''}} </small>
							</b></h5>
							
							@if($bizhrsflag)
								@foreach($bizhrs as $key => $value)
									{{--*/ $bizhrsA = explode(' ', $value); /*--}}
									@if($bizDayA[$bizhrsA[0]] == date("D"))
										{{--*/ $timeStrt[] = strtotime($bizhrsA[1]); /*--}}
										{{--*/ $timeEnd[] = strtotime($bizhrsA[2]); /*--}}
									@endif
								@endforeach	
								
								
								{{--*/ $start1 = date('H:i a', $timeStrt[0]); /*--}}
								{{--*/ $end1 = date('H:i a', $timeEnd[0]); /*--}}
								
								<p>
								@if( isset($timeStrt[1]) && isset($timeEnd[1]))
									
									{{--*/ $start2 = date('H:i a', $timeStrt[1]); /*--}}
									{{--*/ $end2 = date('H:i a', $timeEnd[1]); /*--}}
									
								
									@if (($timeNow > $start1 && $timeNow < $end1) || ($timeNow > $start2 && $timeNow < $end2))
										<font color="green">  
											{{ t('Open') }} 
										</font>
									@else
										<font color="red"> 
											{{ t('Closed') }} 
										</font>
									@endif
								@else
									@if( ($timeNow > $start1 && $timeNow < $end1))
										<font color="green">  
											{{ t('Open') }} 
										</font>
									@else
										<font color="red" > 
											{{ t('Closed') }} 
										</font>
									@endif
								@endif
								</p>
							@endif
							
						@else
							<h5><b> {{ t('Off Day') }} </b></h5>
							<p><font color="red" > {{ t('Closed') }} </font></p>
						@endif
						</div>
						<!-- EOF STATUS -->
						
						<!-- BOF BOOKING LINK -->
						@if (auth()->user())
							@if(isset($business->booking ) && $business->booking =='1'  && $business->user_id != $user->id)
								{{--*/ $bookType = ''; /*--}}
								@if($business->booking_type==3)
									{{--*/ $bookType = 'makeappointment'; /*--}}
								@elseif($business->booking_type==5)
									{{--*/ $bookType = 'booktable'; /*--}}
								@endif
								<a href="#{{$bookType}}" data-toggle="pill" class="make-appointment"> {{ t('Book an Appointment') }} </a>
							@endif
						@else
							<a href="#" onclick="return makeappointment();" id="makeappbtn" class="make-appointment"> {{ t('Book an Appointment') }} </a>
						@endif
						<!-- EOF BOOKING LINK -->
						
						<!-- BOF OPENING HOUR -->
						<div class="rightbox" id="opendays">
							<h2> {{ t('Opening Hours') }}<br /><small>{{ t('* Holiday might effect business hours.') }}</small> </h2>
							<table class="table" style=" margin-top: 10px; margin-left: 5px; margin-bottom: 10px; ">
								<tbody>
								{{--*/ $dayRepeat		= 'null'; /*--}}
								@if($bizhrsflag)
									@foreach($bizhrs as $key => $value)
										{{--*/ $bizhrsA		= explode(' ', $value); /*--}}
										{{--*/ $day			= $bizDayA[$bizhrsA[0]]; /*--}}
										{{--*/ $timeSt		= strtotime($bizhrsA[1]); /*--}}
										{{--*/ $timeEd		= strtotime($bizhrsA[2]); /*--}}
										{{--*/ $timeStDate	= date("h:i A", $timeSt); /*--}}
										{{--*/ $timeEdDate	= date("h:i A", $timeEd); /*--}}
										<tr>
											@if($dayRepeat != $day)
												<td style="text-align: left;" width="10%"> {{ $day }} </td>
											@else
												<td style="text-align: left;" width="10%">  </td>
											@endif
											<td style="text-align: left;" width="90%"> {{ $timeStDate }} - {{ $timeEdDate  }} <small>{{($bizhrsA[2]=='00.00')?'(midnight next day)':''}}</small></td>
											<td style="text-align: left;" width="1%"> </td>
										</tr>
										
										{{--*/ $dayRepeat		= $day /*--}}
									@endforeach
								@endif
								</tbody>
							</table>
						</div>
						<!-- EOF OPENING HOUR -->
					@endif
					
					<!-- BOF CERTIFICATE LINK -->
					@if($business->gifting == 1)
						<a href="{{ lurl('/create/'.$business->id.'/certificate') }}" class="make-appointment"> {{ t('Create a Gift Certificate') }} </a>
					@endif
					<!-- EOF CERTIFICATE LINK -->
				  
					<!-- BOF OFFER LISTING -->
					@if(isset($offers) && count($offers) > 0)							
					<div class="offer-right-list">
						@foreach($offers as $offer)
						<div class="offer-right-list-content">
							<div class="u-row">
								<h6 class="title"> {{ $offertype[$offer->offertype] }} </h6>
								<span class="flat-rotate"> &nbsp; </span>
								<span class="flat-left"> 
									@if($offer->offertype == 2 || $offer->offertype == 4 && $currency != '') {{ $currency }} @endif {{ $offer->percent }} @if($offer->offertype == 1) @lang('global.% off') @elseif($offer->offertype == 2) @lang('global.off') @elseif($offer->offertype == 3) @lang('global.free') @elseif($offer->offertype == 4) @lang('global.for') @endif
								</span>
								<span class="flat-right"> {{ $offer->content }} </span>
							</div>
						</div>
						@endforeach
					</div>
					@endif
					<!-- EOF OFFER LISTING -->
				</div>
				<!-- EOF RIGHT SIDE INFO SECTION -->
			</div>
			<!-- EOF SECTION ONE --> 
		</div>
		<!-- EOF CONTAINER --> 
	</div>
	<!-- EOF CONTENTS --> 

	@if(isset($keywords) && count($keywords) >0)
	<!-- BOF BOTTOM SLIDER SECTION -->
	<div class="bottom-slider-holder">
		<div class="container">
			<div class="slider-cap">
				<h2> @lang('global.View Similar') {{ $cat->name }} </h2>
				<div class="pull-right view-all">
					<a class="left fa fa-chevron-left btn slider-control" href="#myCarousel" data-slide="prev"></a>
					<a class="right fa fa-chevron-right btn slider-control" href="#myCarousel" data-slide="next"></a>
				</div>
			</div>
			<div class="col-md-12 slider-section">
				<div class="row">
					<!-- BOF Carousel Inner-->
					<div id="myCarousel" class="carousel slide"> 
						<!-- BOF Carousel Items -->
						<div class="carousel-inner">
							<div class="item active">
								<div class="row">
									@foreach($keywords as $key => $val)
										{{--*/ $bizUrl = lurl(slugify($val->title.' '.$val->ciasciiname) . '/' . $val->id . '.html'); /*--}}
										@if(($key+1)%4==0)
											</div></div>
											<div class="item">
											<div class="row">
										@endif
										<div class="col-md-3 foto-div">
											<div class="slider-div"> 
												<div class="figure"> 
													{{--*/ $keyimages =	DB::table('businessImages')->where('biz_id', $val->id)->where('active', 1)->limit(1)->get(); /*--}}
													@if(!empty($keyimages))
														@foreach($keyimages as $image)
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
														@endforeach
														<img src="{{ $picBigUrl }}" />
													@else
														<img src="{{url('uploads/pictures/no-image.jpg')}}" />
													@endif
												</div>
												<div class="slider-div-desc">
													<h3> {{ ucwords(str_limit($val->title, 25)) }} </h3>
													<p class="span-star">
													{{--*/ $rvwArr = \DB::table('review')->where('biz_id',$val->id)->get(); /*--}}
													@if(isset($rvwArr) && count($rvwArr) > 0)
														
														{{--*/ $sum1	= 0; /*--}}
														{{--*/ $cnt1	= 0; /*--}}
														{{--*/ $avg1	= 0; /*--}}
														
														@foreach($rvwArr as $key => $rvw)
															{{--*/ $sum1 += $rvw->rating; /*--}}
															{{--*/ $cnt1 += count($rvw->rating); /*--}}
														@endforeach 
														
														{{--*/ $avg1	= $sum1/$cnt1 ; /*--}}
														{{--*/ $dif1	= 5 - $avg1; /*--}}
														
														@if($avg1 > 0)
															@if(strlen($avg1) == 1)
																@for($i=0;$i < $avg1;$i++)
																	<span class='fa fa-star'></span>
																@endfor
																@for($i=0;$i < floor($dif1);$i++)
																	<span class='fa fa-star-o'></span>
																@endfor
															@else
																{{--*/ $rate1 =	floor($avg1); /*--}}
																@for($i=0;$i < $rate1;$i++)
																	<span class='fa fa-star'></span>
																@endfor
																<span class='fa fa-star-half-o'></span>
																@for($i=0;$i < floor($dif1);$i++)
																	<span class='fa fa-star-o'></span>
																@endfor
															@endif
														@else
															@for($i=0;$i < 5;$i++)
																<span class='fa fa-star-o'></span>
															@endfor		
														@endif
													@else
														@for($i=0;$i < 5;$i++)
															<span class='fa fa-star-o'></span>
														@endfor		
													@endif
													</p>
													<p class="slider-div-desc-text"> {{ str_limit($val->description, 110) }} </p>
													<a href="{{ $bizUrl }}" class="view-more" style="width: 100%; text-decoration: none;"> @lang('global.View More') </a> 
												</div>
											</div>
										</div> 
									@endforeach
								</div>
							</div>
						</div>
						<!-- EOF Carousel Items -->
					</div>
					<!-- EOF Carousel Inner-->             
				</div>
			</div>
			<!--/well--> 
		</div>
	</div>
	<!-- EOF BOTTOM SLIDER SECTION -->
	@endif
	</div>
	
	<!-- BOF SOCIAL SHARE MODAL -->
	<div class="modal fade bd-share-modal-md" tabindex="-1" role="dialog" aria-labelledby="myShareModalLabel" aria-hidden="true" style="margin-top:15%">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">
					<div id="shareRoundIcons" style="text-align: center"> </div>
				</div>
			</div>
		</div>
	</div>
	<!-- EOF SOCIAL SHARE MODAL -->
	
	<div id="location-list" class="modal fade bd-location-modal-md" style="margin-top: 10%; padding-right: 0 !important;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
					<h5 class="modal-title" style="text-transform: uppercase;">
						@lang('global.Choose the Location')
					</h5>
				</div>
				<div class="modal-body">
					@if(isset($locationArr))
						{{--*/ $c = 1; /*--}}
						@foreach($locationArr as $locate)
							<div class="row bordr-btm" >
								<div class="col-md-1 col-sm-1">
									<h1>{{ $c }}<h1>
								</div>
								<div class="col-md-9 col-sm-9" onClick="return changeLoc({{$locate->id}});" style="cursor:pointer;">
									<h5><b>
										@if(strtolower(Request::segment(1)) == 'ar')
											{{ $business->title_ar }}
										@else
											{{ ucfirst($business->title) }}
										@endif
									</b><h5>
									<p class="text-muted">
										{{ ucwords($locate->address_1) }},&nbsp; 
										@if(strtolower(Request::segment(1)) == 'ar')
											{{ $locate->ciname }}, {{ $locate->loname }}, {{ $locate->coname }} @if($locate->zip_code != '') - {{ $locate->zip_code }} @endif
										@else
											{{ ucfirst($locate->ciasciiname) }}, {{ $locate->loasciiname  }}, {{ $locate->coasciiname  }} @if($locate->zip_code != '') - {{ $locate->zip_code }} @endif
										@endif
									</p>
									<p class="text-muted">{{ $locate->tele }} &nbsp; {{ $locate->phone }}</p>
								</div>
								<div class="col-md-2" style="cursor:pointer;">
									<span class="btn btn-primary btn-md btn-loctn" onClick="return changeLoc({{$locate->id}});"><i class="fa fa-location-arrow"></i></span>
								</div>
							</div>
						{{--*/ $c++; /*--}}
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
	
	<!-- BOF CHECK SESSION VALUE EXISTANCE -->
	@if(Session::has('bizLocationNow'))
		{{--*/ $bizSession = unserialize(Session::get('bizLocationNow')); /*--}}
		{{--*/ $biz_now = $bizSession->biz_id; /*--}}
	@else
		{{--*/ $biz_now = ''; /*--}}
	@endif
	<!-- EOF CHECK SESSION VALUE EXISTANCE -->
	
@stop

@section('javascript-top')
	@if (config('services.googlemaps.key')) 
		<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script> 
	@endif
@endsection 
@section('javascript')
	@if(isset($locationArr) && count($locationArr) > 1)
		@if($locationArr[0]->biz_id != $biz_now)
			<script type="text/javascript">
				$(document).ready(function() {
					$('#location-list').modal({backdrop: 'static', keyboard: false}); 
				});
			</script>
		@endif
	@endif
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
	
	<script>
		jQuery('#sr_date').datepicker ({
			autoclose: true,
			startDate: 'd'
		});
		jQuery(document).on('ready', function() {
			jQuery("#rating").rating();
			jQuery("#expense").expense();
		});
	</script>
	<script language="javascript">
	
		function findatable(){
			var sr_date = $.trim($("#sr_date").val());
			var sr_time = $.trim($("#sr_time").val());
			var sr_people = $.trim($("#sr_people").val());
			
			$("#sr_date").removeClass("error_border");
			$("#sr_time").removeClass("error_border");
			
			var err = 0;
			if(sr_date==''){
				$("#sr_date").addClass("error_border");
				err = 1;
			}
			if(sr_time==''){
				$("#sr_time").addClass("error_border");
				err = 1;
			}
			
			if(err == 0){
				$.ajax({
					url: "{{ lurl('find_table') }}",
					type: 'post',
					data: {'biz_id':"{{ $business->id }}", 'sr_date':sr_date, 'sr_time':sr_time, 'sr_people':sr_people},
					dataType:'json',
					success: function(data)
					{
						if(data['status']==1){
							$("#tsbid").val(data['setId']);
							$('#table_search').fadeOut("normal", function (){
								$('#table_details').fadeIn("normal");
							});
						}else{
							$('#table-book').modal('show');
						}
						/*tmSelectHtml = data['tmhtml'];
						$("#time_slot_select").html(data['html']);
						$('#time_slot_details').fadeOut("normal", function (){
							$('#time_slot_select').fadeIn("normal");
						});*/
						console.log("success");
						console.log(data);
						return false;					
					},
					error : function(xhr, status,data){
						$('#table-book').modal('show');
						console.log("error");
						console.log(data);
						return false;
					}
				});
			}
			return false;
		}
		
		function bookTimeSlotNext(id){
			$("#tsbid").val(id);
			$('#time_slot_select').fadeOut("normal", function (){
				$('#time_slot_details').fadeIn("normal");
			});
			return false;
		}
		
		function closeInfoMsg(){
			$("#time_slot_select").html(tmSelectHtml);
			return false;	
		}
		
		function closeInfoMsgTbl(){
			$("#table_search").html(tmSelectHtmlOld);
			return false;	
		}
		
		var tmSelectHtml = '';
		var tmSelectHtmlOld = '';
		
		function bookTimeSlot(){
			var tsbid = $.trim($("#tsbid").val());
			var tb_name = $.trim($("#tb_name").val());
			var tb_email = $.trim($("#tb_email").val());
			var tb_mobile = $.trim($("#tb_mobile").val());
			var tb_message = $.trim($("#tb_message").val());
			
			$("#tb_name").removeClass("error_border");
			$("#tb_email").removeClass("error_border");
			$("#tb_mobile").removeClass("error_border");
			$("#tb_message").removeClass("error_border");
			
			var err = 0;
			if(tb_name==''){
				$("#tb_name").addClass("error_border");
				err = 1;
			}
			if(tb_email==''){
				$("#tb_email").addClass("error_border");
				err = 1;
			}
			if(tb_mobile==''){
				$("#tb_mobile").addClass("error_border");
				err = 1;
			}
			if(tb_message==''){
				$("#tb_message").addClass("error_border");
				err = 1;
			}
			
			if(err == 1){
				return false;
			}
			
			$("#tb_message").val("");
			tmSelectHtmlOld = $("#time_slot_select").html();
			$("#time_slot_select").html('<img src="/images/loading-new.gif" width="15">');
			$('#time_slot_details').fadeOut("normal", function (){
				$('#time_slot_select').fadeIn("normal");
			});
			$.ajax({
				url: "{{ lurl('book_timeslot') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'tsbid':tsbid, 'tb_name':tb_name, 'tb_email':tb_email, 'tb_mobile':tb_mobile, 'tb_message':tb_message},
				dataType:'json',
				success: function(data)
				{
					//$("#tb_name").val("");
					//$("#tb_email").val("");
					//$("#tb_mobile").val("");
					
					tmSelectHtml = data['tmhtml'];
					$("#time_slot_select").html(data['html']);
					$('#time_slot_details').fadeOut("normal", function (){
						$('#time_slot_select').fadeIn("normal");
					});
					console.log("success");
					console.log(data);
					return false;					
				},
				error : function(xhr, status,data){
					$("#time_slot_select").html(tmSelectHtmlOld);
					$('#time_slot_details').fadeOut("normal", function (){
						$('#time_slot_select').fadeIn("normal");
					});
					console.log("error");
					console.log(data);
					return false;
				}
			});
			return false;
		}
		
		function cancelBookTable(){
			$('#table_details').fadeOut("normal", function (){
				$('#table_search').fadeIn("normal");
			});
			return false;
		}
		
		function bookTable(){
			var tsbid = $.trim($("#tsbid").val());
			var tb_name = $.trim($("#tb_name").val());
			var tb_email = $.trim($("#tb_email").val());
			var tb_mobile = $.trim($("#tb_mobile").val());
			var tb_message = $.trim($("#tb_message").val());
			
			$("#tb_name").removeClass("error_border");
			$("#tb_email").removeClass("error_border");
			$("#tb_mobile").removeClass("error_border");
			$("#tb_message").removeClass("error_border");
			
			var err = 0;
			if(tb_name==''){
				$("#tb_name").addClass("error_border");
				err = 1;
			}
			if(tb_email==''){
				$("#tb_email").addClass("error_border");
				err = 1;
			}
			if(tb_mobile==''){
				$("#tb_mobile").addClass("error_border");
				err = 1;
			}
			if(tb_message==''){
				$("#tb_message").addClass("error_border");
				err = 1;
			}
			
			if(err == 1){
				return false;
			}
			
			$("#tb_message").val("");
			tmSelectHtmlOld = $("#table_search").html();
			$("#table_search").html('<img src="/images/loading-new.gif" width="15">');
			$('#table_details').fadeOut("normal", function (){
				$('#table_search').fadeIn("normal");
			});
			$.ajax({
				url: "{{ lurl('book_table') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'tsbid':tsbid, 'tb_name':tb_name, 'tb_email':tb_email, 'tb_mobile':tb_mobile, 'tb_message':tb_message},
				dataType:'json',
				success: function(data)
				{
					$("#table_search").html(data['html']);
					
					console.log("success");
					console.log(data);
					return false;					
				},
				error : function(xhr, status,data){
					$("#table_search").html(tmSelectHtmlOld);
					$('#table_details').fadeOut("normal", function (){
						$('#table_search').fadeIn("normal");
					});
					console.log("error");
					console.log(data);
					return false;
				}
			});
			return false;
		}
		
		function makeappointment(){
			$("#makeappbtn").fadeOut('normal');
			$.ajax({
				url: "{{ lurl('set_back') }}",
				type: 'post',
				data: {'biz_id':"{{ $business->id }}", 'action':'business'},
				dataType:'json',
				success: function(data)
				{
					$("#makeappbtn").fadeIn('normal');
					window.location.href = "{{lurl('login')}}";
					console.log("success");
					console.log(data);
					return false;					
				},
				error : function(xhr, status,data){
					$("#makeappbtn").fadeIn('normal');
					console.log("error");
					console.log(data);
					return false;
				}
			});
			return false;
		}
		
		var stateId = '<?php echo (isset($city)) ? $country->get('code') . '.' . $city->subadmin1_code : '0' ?>';
		
		$(document).ready(function () {
			@if(config('settings.show_ad_on_googlemap'))
				genGoogleMaps(
				'<?php echo config('services.googlemaps.key'); ?>',
				'<?php echo (isset($business->city) and !is_null($business->city)) ? addslashes($business->city->name) . ',' . $country->get('name') : $country->get('name') ?>',
				'<?php echo $lang->get('abbr'); ?>'
				);
			@endif
		})
		
	</script> 
	
	<script language="javascript">
		$('#post_review').submit(function() {
			if($('input#rating').val() == '') {
				$('#rating-div').addClass("error_border");
				return false;
			}
			else if($('input#expense').val() == '') {
				$('#expense-div').addClass("error_border");
				return false;
			}
			else if($('textarea#review').val() == '') {
				$('textarea#review').focus();
				return false;
			}
			else {
				$('#rating-div').removeClass("error_border");
				$('#expense-div').removeClass("error_border");
				return true;
			}
		});
	</script> 
	
	<script language="javascript">	
		
		var fileList = new Array;
		$(function() {
			$("#requestbizdropzone").dropzone({
				
				url: "<?php echo lurl('account/postrequestbizimages'); ?>",
				addRemoveLinks : true,
				maxFilesize: 10,
				maxFiles: 10,
				params: { biz_id: $("#biz_id").val(),usr_id: $("#usr_id").val() }, 
				sending: function(file, xhr, formData) {
					// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
					formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
				},
				success : function(file, response){ 
					$("#imge1").val('uploads/pictures/business/'+response);
					fileList[file.lastModified] = response;
					if(response != 'fail') {
						$("#success-alert").alert();
						$("#success-alert").fadeTo(2000, 6000).slideUp(6000, function(){
							$("#success-alert").slideUp(6000);
						});   
					} else {
						$("#danger-alert").alert();
						$("#danger-alert").fadeTo(2000, 6000).slideUp(6000, function(){
							$("#danger-alert").slideUp(6000);
						});   
					}
				},
				removedfile: function(file) {
					$.post('<?php echo lurl('account/delrequestbizimages'); ?>', {fileName:fileList[file.lastModified], biz_id: $("#biz_id").val(), usr_id: $("#usr_id").val()}, function(data){});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;      
				}
			});
		});
		
	</script> 
	<script>
		$(document).ready(function() {
			$("#shareRoundIcons").jsSocials({
				shareIn: "popup",
				showLabel: false,
				showCount: false,
				shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "pinterest" ],
			});
			
			$('.write-review').click(function() {
				$('textarea#review').focus();
			});
		});
	</script>
	<script language="javascript">
		function changeLoc(id) {

			$.ajax({
				url: "{{ lurl('change/business/location/ajax') }}",
				type: 'post',
				data: {'id': id},
				dataType:'json',
				success: function(data)
				{
					$('#location-list').modal('toggle');
					$("div.directory").empty().html(data.content);
					$("p.slider-city-name").empty().html(data.cityname);
					console.log("success");
					console.log(data);
					return false;					
				},
				error : function(xhr, status,data) { 
				
					console.log("error");
					console.log(data);
					return false;
				}
			});
			return false;
		}
	</script>
	
    <script>
	$('#scam').click(function(){
		$('.scam_div').slideToggle();
	});
	
	function report_this(){
		$('#rep_msg').removeClass('error_border');
		var rep_msg = $.trim($('#rep_msg').val());
		if(rep_msg==''){
			$('#rep_msg').addClass('error_border');
			return false;
		}
		$('#scam_div').html('<p style="text-align:center;"><img src="{{url("assets/img/loading.gif")}}" /><p>');
		$.ajax({
			url: "{{ url('report_business') }}",
			type: 'post',
			data: {'biz_id': '{{ $business->id }}', 'rep_msg': rep_msg},
			dataType:'json',
			success: function(data)
			{
				$('#scam_div').html(data['res']);
				setTimeout("$('.scam_div').slideToggle();", 3000);
				console.log("success");
				console.log(data);
				return false;					
			},
			error : function(xhr, status,data) { 
				console.log("error");
				console.log(data);
				return false;
			}
		});
		return false;
	}
	</script>
@endsection 
