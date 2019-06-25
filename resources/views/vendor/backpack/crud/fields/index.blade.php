@extends('classified.layouts.layout')

@section('content')

{{--*/ $title = $business->title; /*--}}
{{--*/ $description = substr($business->description, 0, 55); /*--}}
{{--*/ $city_name = $business->city->asciiname; /*--}}
@if(strtolower($lang->get('abbr'))=='ar')
	{{--*/ $title = $business->title_ar; /*--}}
	{{--*/ $description = substr($business->description_ar, 0, 55); /*--}}
	{{--*/ $city_name = $business->city->name; /*--}}
@endif
<!---------CONTENTS STARTS HERE------------------>
<div class="content-holder">
	<div class="container"> 
	  <!-------STARTS BREADCRUMB------------>
	  <div class="page-details">
		<ul class="breadcrumb">
		  <li><a href="{{ lurl('/') }}">{{t('Home')}}</a></li>
		  <li><a href="{{lurl('c/'.trim($cat->slug))}}">{{$cat->name}}</a></li>
		  <li class="active">{{$title}}</li>
		</ul>
	  </div>
	  <!-------ENDS BREADCRUMB------------>
	  
	  <div class="section"> 
		<!----Starts Slider Section---->
		<div class="col-md-4 col-sm-4" id="topslider">
		  <div class="detail-row">
			<div class="row">
			  <div class="col-md-12" id="slider1"> 
				<!-- Top part of the slider -->
				<div class="row">
				  <div class="col-md-12" id="carousel-bounding-box">
					<div class="carousel slide" id="thumbCarousel"> 
					  <!-- Carousel items -->
					  <div class="carousel-inner">
					  	{{--*/ $thumb = ''; /*--}}
					  	@if(isset($business->businessimages) && sizeof($business->businessimages)>0)
						@foreach($business->businessimages as $key => $image)
						<?php
							if (is_file(public_path() . '/uploads/pictures/'. $image->filename)) {
								$picBigUrl = url('pic/x/cache/big/' . $image->filename);
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
							$thumb .= '<div  class="col-md-4 col-sm-4">';
							$thumb .= '<div class="row"> <a class="" id="carousel-selector-'.$key.'"><img src="'.$picBigUrl.'" width="100%"></a> </div>';
							$thumb .= '</div>';
						?>
						<div class="active item" data-slide-number="{{$key}}"> <img src="{{ $picBigUrl }}" width="100%">
						  <div class="slider-overlay">
							<h2>{{$title}}</h2>
							<p>@if(isset($business->city) && !is_null($business->city)) {{$business->city->name}}@endif</p>
						  </div>
						</div>
						@endforeach
						@else
						<div class="active item" data-slide-number="0"> <img src="{{url('uploads/pictures/no-image.png')}}" width="100%">
						  <div class="slider-overlay">
							<h2>{{$title}}</h2>
							<p>@if(isset($business->city) && !is_null($business->city)) {{$business->city->name}}@endif</p>
						  </div>
						</div>
						@endif
					  </div>
					  <!-- Carousel nav --> 
					</div>
				  </div>
				</div>
			  </div>
			</div>
			<!--/Slider-->
			
			<div class="row hidden-phone" id="slider-thumbs">
			  <div class="col-md-12"> 
				<!-- Bottom switcher of slider -->
				<ul class="thumbnails">
				  {!!$thumb!!}
				</ul>
			  </div>
			</div>
		  </div>
		</div>
		<!----ends Slider Section----> 
		
		<!-----Starts Details Listing----->
		<div class="col-md-8 col-sm-8">
		  <div class="detail-row">
			<div class="company-name">
			  <h2> {{$title}} </h2>
			  <div class="pull-right"> <a href="#" class="write-review"><span class="fa fa-star-half-o"></span> {{ t('Write A Review') }} </a> <a href="#" class="add-photo"> <span class="fa fa-camera"></span> {{ t('Add a Photo') }} </a> <a href="#" class="share"><span class="fa fa-share"></span> {{ t('Share') }} </a> </div>
			</div>
			<div class="rating-holder"> <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"> </span><span class="fa fa-star"></span> &nbsp; (4.5) <span class="ratingcount"> 100 {{ t('Ratings') }} </span> <span class="ratingcount"> 100 {{ t('Reviews') }} </span>
			  <div class="pull-right"><span class="mt-dollar"> <i class=" fa fa-dollar"></i> <i class=" fa fa-dollar"></i> <i class=" fa fa-dollar"></i>  <i class=" fa fa-dollar"></i> <i class=" fa fa-dollar"></i> </span></div>
			</div>
			<p class="company-content"> {{$description}} </p>
			<div class="directory">
			  <div class="col-md-4 col-sm-4">
				<div class="row">
				@if(config('settings.show_ad_on_googlemap'))
					<!--<iframe id="googleMaps" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>-->
					<img alt="Map" src="https://maps.googleapis.com/maps/api/staticmap?center={{$business->lat}},{{$business->lon}}&zoom=10&size=200x150&key={{ config('services.googlemaps.key') }}" width="100%">
				@endif
				</div>
			  </div>
			  <div class="col-md-4">
				<div class="d-box1">
				  <div class="d-box-div1"> <img src="{{url('assets/frontend/images/placeholder.svg')}}"> </div>
				  <div class="d-box-div2">
					<p class="span1">{{$business->address1}}</p>
					<p class="span2">{{$city_name}}</p>
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
				  <div class="d-box-div2"> <a href="#" class="span3"> {{ t('Get Direction') }} </a> </div>
				</div>
			  </div>
			  <div class="col-md-4">
				<div class="d-box2">
				  <div class="d-box-div1"> <img src="{{url('assets/frontend/images/web.svg')}}"> </div>
				  <div class="d-box-div2"> <a href="#" class="span3"> {{ t('www.google.com') }} </a> </div>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!-----Starts Details Listing-----> 
	  </div>
	  <div class="section-one"> 
		<!----START SIDE NAVIGATION--------->
		<div class="col-md-3">
		  <ul class="side_nav">
			<li class="active"><a data-toggle="pill" href="#review"> {{ t('Review') }} </a></li>
			<li ><a data-toggle="pill" href="#description"> {{ t('Description') }} </a></li>
			<li ><a data-toggle="pill" href="#addinfo"> {{ t('Additional Information') }} </a></li>
		  </ul>
		</div>
		<!----ENDS SIDE NAVIGATION---------> 
		
		<!----START NAVIGATION CONTENT SECTION--------->
		<div class="col-md-6">
		  <div class="tab-content"> 
			<!-----Review Section---->
			<div id="review" class="tab-pane fade in active">
			
			  <h2 class="head-title"> {{ t('Reviews') }}
				<div class="pull-right"> <span class="fa fa-star"></span> </div>
			  </h2>
			  
			  <div class="c-row">
			  
				<div class="col-md-3 col-sm-3"> 
					<?php $userArr = \DB::table('users')->select('users.photo')->where('users.id',$business->user_id)->get(); ?>
					<!--<img src="{{url('assets/frontend/images/r1.jpg')}}" class="review-img">-->
					@if(!empty($userArr))
						@foreach($userArr as $user)
							@if($user->photo == '')
								<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" class="review-img" /> 
							@else
								<img src="{{ url('uploads/pictures/dp/'.$user->photo) }}" alt="No Image" class="review-img" /> 
							@endif
						@endforeach
					@endif
				</div>
				
				<div class="col-md-9 col-sm-9">
					<?php $reviewArr = \DB::table('review')->select('review.review','review.user_name','review.updated_at')->where('review.user_id',$business->user_id)->where('review.biz_id',$business->id)->get(); ?>
					@if(!empty($reviewArr))
						@foreach($reviewArr as $review)
							<h3 class="sub-title"> {{ $review->user_name }} </h3>
							<p class="detail-desc"> {{ $review->review }} </p>
							<p class="name_person"><span> {{ $review->user_name }} </span> <span> {{ date("d-m-Y",strtotime($review->updated_at)) }} </span></p>
						@endforeach	
					@else
						<h3 class="sub-title"></h3>
						<p class="detail-desc"> {{ t('No More Reviews..!') }} </p>
						<p class="name_person"><span> &nbsp; </span> <span> &nbsp; </span></p>
					@endif
				</div>
				
			  </div>
			  
			</div>
			<!-----End Review Section----> 
			
			<!------Start Description---------->
			<div id="description" class="tab-pane fade">
			  <h2 class="head-title"> {{$title}} </h2>
			  <p class="detail-desc"> 
				@if($description != '')
					{{$description}}
				@else
					{{ t('No More Descriptions..!') }}
				@endif
			  </p>
			</div>
			<!------end description------------> 
			<!------Start Additional Information---------->
			<div id="addinfo" class="tab-pane fade">
			  <h2 class="head-title"> {{ t('Informations') }} </h2>
			  <p class="detail-desc"> {{ t('No More Informations..!') }} </p>
			</div>
			<!------Start Additional Information----------> 
			
		  </div>
		</div>
		<!----ENDS NAVIGATION CONTENT SECTION---------> 
		
		<!----RIGHT SIDE INFO SECTION-------->
		<div class="col-md-3">
		  <div class="open-now-box"> <img src="{{url('assets/frontend/images/clock.svg')}}">
			
			@if(isset($business->biz_hours ) && $business->biz_hours !='')
				<h5><b> {{ t('Today') }} 
				{{--*/ $bizhrs = unserialize($business->biz_hours); /*--}}
				{{--*/ $bizDayA = array(0=>'Mon',1=>'Tue',2=>'Wed',3=>'Thu',4=>'Fri',5=>'Sat',6=>'Sun'); /*--}}
				@foreach($bizhrs as $key => $value)
					{{--*/ $bizhrsA = explode(' ', $value); /*--}}
					@if($bizDayA[$bizhrsA[0]] == date("D"))
						{{--*/ $timeSt = strtotime($bizhrsA[1]); /*--}}
						{{--*/ $timeEd = strtotime($bizhrsA[2]); /*--}}
						{{ date("h:i A", $timeSt) }} - {{ date("h:i A", $timeEd) }}
						{{ date("h:i A", $timeEd) }}
						{{ date("h:i A") }}
					@endif
				@endforeach
				</b></h5>
				<p><font color="green"> @if(date("h:i A", $timeEd >= date("h:i A")) {{ t('Open') }} @else {{ t('Closed') }} @endif</font></p>	
			@else
				<h5><b> {{ t('Off Day') }} </b></h5>
				<p><font color="red"> {{ t('Closed') }} </font></p>
			@endif
		  </div>
		  <a href="#" class="make-appointment"> {{ t('Book an Appointment') }} </a>
		  <div class="rightbox" id="opendays">
			<h2> {{ t('Opening Hours') }} </h2>
			<table class="table" style=" margin-top: 10px; margin-left: 5px; margin-bottom: 10px; ">
			  <tbody>
				@if(isset($business->biz_hours ) && $business->biz_hours !='')
					{{--*/ $bizhrs = unserialize($business->biz_hours); /*--}}
					{{--*/ $bizDayA = array(0=>'Mon',1=>'Tue',2=>'Wed',3=>'Thu',4=>'Fri',5=>'Sat',6=>'Sun'); /*--}}
					@foreach($bizhrs as $key => $value)
						{{--*/ $bizhrsA		= explode(' ', $value); /*--}}
						{{--*/ $day			= $bizDayA[$bizhrsA[0]]; /*--}}
						{{--*/ $timeSt		= strtotime($bizhrsA[1]); /*--}}
						{{--*/ $timeEd		= strtotime($bizhrsA[2]); /*--}}
						{{--*/ $timeStDate	= date("h:i A", $timeSt); /*--}}
						{{--*/ $timeEdDate	= date("h:i A", $timeEd); /*--}}
						<tr>
							<td style="text-align: left;"> {{ $day }} </td>
							<td style="text-align: left;"> {{ $timeStDate }} - {{ $timeEdDate  }} </td>
							<td style="text-align: left;"> 
							</td>
						</tr>
					@endforeach
				@endif
			  </tbody>
			</table>
		  </div>
		  <div class="rightbox">
			<h2> {{ t('Write a Review') }} </h2>
			<input type="text" placeholder="Name" class="form-control">
			<div class="star-rating-div"> <span class="fa fa-star"><span class="fa fa-star"><span class="fa fa-star"><span class="fa fa-star"><span class="fa fa-star"> </div>
			<div class="rating-comment-div">
			  <input type="text" placeholder="Comment" class="form-control">
			</div>
			<button class="comment btn"> {{ t('Send') }} </button>
		  </div>
		</div>
		<!----ENDS NAVIGATION CONTENT SECTION---------> 
		
	  </div>
	</div>
<!---------END CONTAINER-----------------> 
</div>
<!---------CONTENTS END HERE------------------> 

<!--------------STARTS BOTTOM SLIDER SECTION------ --->
<div class="bottom-slider-holder">
	<div class="container">
	  <div class="slider-cap">
		<h2>View Similar Saloons</h2>
		<div class="pull-right view-all">
		 <a class="left fa fa-chevron-left btn slider-control" href="#myCarousel" data-slide="prev"></a>
		 <a class="right fa fa-chevron-right btn slider-control" href="#myCarousel" data-slide="next"></a>
		</div>
	  </div>
	  <div class="col-md-12 slider-section">
		<div class="row">
		  <div id="myCarousel" class="carousel slide"> 
			<!-- Carousel items -->
			<div class="carousel-inner">
			  <div class="item active">
				<div class="row">
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"><img src="{{url('assets/frontend/images/saloon1.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				  <div class="col-md-3 foto-div">
					<div class="slider-div"><div class="figure"> <img src="{{url('assets/frontend/images/saloon2.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"><img src="{{url('assets/frontend/images/saloon3.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"><img src="{{url('assets/frontend/images/saloon1.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				</div>
				<!--/row-fluid--> 
			  </div>
			  <!--/item-->
			  
			  <div class="item">
				<div class="row">
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"><img src="{{url('assets/frontend/images/saloon1.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"> <img src="{{url('assets/frontend/images/saloon2.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p  class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"><img src="{{url('assets/frontend/images/saloon3.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				  <div class="col-md-3 foto-div">
					<div class="slider-div"> <div class="figure"><img src="{{url('assets/frontend/images/saloon4.jpg')}}" /></div>
					  <div class="slider-div-desc">
						<h3>The Wackey Hair</h3>
						<p class="span-star"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></p>
						<p> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has</p>
						<a href="#" class="view-more">View More</a> <a href="#" class="book-now">Book Now</a> </div>
					</div>
				  </div>
				</div>
				<!--/row-fluid--> 
			  </div>
			  <!--/item--> 
			  
			</div>
			<!--/carousel-inner-->             
			</div>
		  <!--/myCarousel--> 
		  
		</div>
		<!--/well--> 
	  </div>
	</div>
</div>
<!--------------ENDS  BOTTOM SLIDER SECTION----------->
@stop

@section('javascript-top')
	@if (config('services.googlemaps.key')) 
		<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script> 
	@endif
@endsection

@section('javascript')
	<script language="javascript">
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
@endsection 
