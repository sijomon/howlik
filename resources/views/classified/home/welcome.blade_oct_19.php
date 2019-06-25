@extends('classified.layouts.layout')

@section('content')
<?php $pos= 0; 
  
  //echo "<pre>";print_r($all_ads); exit;
  
  ?>
<div class="banner_section">
  <div class="container">
    <div class="banner_text">
      <h2>A Personal Assistant in your Pocket! isn't it cool?</h2>
      <h5>DOWNLOAD THE APP</h5>
      <span class="ios"><img src="{{ url('/assets/frontend/images/o-o-apple.svg') }}"></span> <span class="android"><img src="{{ url('/assets/frontend/images/o-o-google-play.svg') }}"/></span> </div>
  </div>
</div>


<div class="listing_holder">
  <div class="container">
    <div class="Trending_section">
      <div class="listing_head"> 
        <!--  <span class="list_imgg"><img src="{{ url('/assets/frontend/images/fire-element.svg') }}"/></span>--> 
        <span class="trending">Trending Now</span></div>
      <div class="list_main"> @foreach ($all_ads as $cate)
        <?php 
			
			$pos = $pos + 1 ;
			
			$fav_ads_count = 0;
			
			$ad_id =   $cate->id;
			
			$visits =   $cate->visits;
			 
			 
			 $rate_ads = DB::table("ratings")
			    ->selectRaw('sum(ratings) as sumratings')
				->where("ads_id", "=", $ad_id) // "=" is optional
				->get();
			 $rate_ads_check = DB::table("ratings")
				->where("ads_id", "=", $ad_id) // "=" is optional
				->get();	
				
			$rate_ads_count = count($rate_ads_check);
			
			if($rate_ads_count >0)
			{
			$total_rate           =   $rate_ads[0]->sumratings;
			$exact_rate           =   $total_rate / $rate_ads_count;
			}
			else
			{
				$exact_rate =0;
			}
	       
		   
		   
		    $review_contents = DB::table("review")
				->where("ads_id", "=", $ad_id) // "=" is optional
				->get();
			$review_ads_count = count($review_contents);
			
			$ad_images = DB::table("pictures")
				->where("ad_id", "=", $ad_id) // "=" is optional
				->get();
			$ad_images_count = count($ad_images);
			
			if($ad_images_count >0)
			{
			$ad_image           =   $ad_images[0]->filename;
			}
			else
			{
				$ad_image ="";
			}
			// style="height:259px;"
			
			////////////// find likes of ads //////////////////////
			$fav_ads_check = DB::table("saved_ads")
				->where("ad_id", "=", $ad_id) // "=" is optional
				->get();	
				
			$fav_ads_count = count($fav_ads_check);
			
			////////////// find likes of ads //////////////////////	
			
			////////////// creating links of ads //////////////////////
			
			
			$link    =   "/".str_replace(' ', '-', $cate->title)."/".$cate->id.".html";
			
			////////////// creating links of ads //////////////////////
			
			 ?>
             
        <div class="Starbucks <?php if($pos % 4 == 0) { ?> last <?php } ?> <?php if($pos > 8) { ?> extra <?php } ?>"    >
          <div class="list_top">
            <div class="bitmap"><img src="/uploads/pictures/{{ $ad_image }}"></div>
            <div class="text_starbucks">
              <h4>{{ ucwords($cate->title) }}</h4>
              <h6><span class="location_icon"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>{{ ucwords($cate->city_name) }}</h6>
            </div>
            <div class="tea_icon">
              <?php if ($cate->category_image == "") { ?>
              <img src="{{ url('/assets/frontend/images/a_cup_of_tea_vector_154490.jpg') }}">
              <?php } else{?>
              <?php } ?>
            </div>
          </div>
          <div class="image_holder zoom-effect-container hover08 column">
            <div class="image-card">
              <figure><a href="<?php echo $link; ?>"><img src="/uploads/pictures/{{ $ad_image }}"></a> </figure>
            </div>
          </div>
          <div class="label_holder">
            <div class="lab_holder"> <span class="bol">{{ $exact_rate }}/5</span> <span>
            
            <?php $rate =  $exact_rate;?>
            
             <fieldset id='demo2' class="rating new_rate_style">
                      
                        <label class = "full" for="star5" title="5" <?php if($rate == 5) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class="half" for="star4half" title="4.5" <?php if($rate >= 4.5) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class = "full" for="star4" title="4" <?php if($rate >= 4) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class="half" for="star3half" title="3.5" <?php if($rate >= 3.5) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class = "full" for="star3" title="3" <?php if($rate >= 3) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class="half" for="star2half" title="2.5" <?php if($rate >= 2.5) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class = "full" for="star2" title="2" <?php if($rate >= 2) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class="half" for="star1half" title="1.5" <?php if($rate >= 1.5) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class = "full" for="star1" title="1" <?php if($rate >= 1) { ?> style="color: #FFD700;" <?php } ?>></label>
                        <label class="half" for="starhalf" title="0.5" <?php if($rate >= 0.5) { ?> style="color: #FFD700;" <?php } ?>></label>
                    </fieldset>
            
            
            </span> <!--<span class="review">{{ $review_ads_count }} Reviews</span>--> </div>
          </div>
          <div class="btns_holder"> <span class="chat">{{ $review_ads_count }}<img src="{{ url('/assets/frontend/images/chat.svg') }}"></span> <span class="heart">{{ $fav_ads_count }}<img src="{{ url('/assets/frontend/images/hearts.svg') }}"></span> <span class="view">{{ $visits }}<img src="{{ url('/assets/frontend/images/visible.svg') }}"></span> </div>
        </div>
        
        
        
        
        
        @endforeach </div>
      <div class="view_more">
                  <span id="view_more" ><a href="javascript:show_more();" >view more ({{ $all_ads_count }})</a></span>
                  <span id="hide_more" style="display:none;" ><a href="javascript:hide_more();"> Hide Ads ({{ $all_ads_count }})</a></span>
                  
                  <!--<span class="nos">({{ $all_ads_count }})</span> </div>-->
    </div>
  </div>
</div>

<!--Latest Events-->

<div class="events_holder">
  <div class="container">
    <div class="latest_events">
      <div class="evients-holder">
        <h3>Latest Events</h3>
        <h5>DUBAI</h5>
      </div>
      <div class="jcarousel-wrapper">
        <div class="jcarousel products_li" data-jcarousel="true">
          <ul style="left: -600px; top: 0px;">
            @foreach ($all_events as $events)
            <li style="width: 270px;">
              <div class="label_event"> <span class="date"><?php echo date('F d',strtotime($events->event_date)); ?></span> <img src="{{ $events->event_image1 }}"> </div>
              <div class="img_inner">
                <h4>{{ ucwords($events->event_name) }}</h4>
                <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>{{ $events->event_place }}</span> </div>
              </div>
            </li>
            @endforeach 
            
         
            
          </ul>
        </div>
        <a class="jcarousel-control-prev brands_1" href="#" data-jcarouselcontrol="true">‹</a> <a class="jcarousel-control-next brands_2" href="#" data-jcarouselcontrol="true">›</a> </div>
    </div>
    <div class="more_events">
      <h4> <a class="" href="{{ lurl('events') }}"> More Events</a></h4>
    </div>
  </div>
</div>
<style>
            /****** Rating Starts *****/
            .rating { 
                border: none;
                float: left;
            }
            .rating > label:before { 
                margin: 5px;
                font-size: 1.25em;
                font-family: FontAwesome;
                display: inline-block;
                content: "\f005";
            }
            .rating > .half:before { 
                content: "\f089";
                position: absolute;
            }
            .rating > label { 
                color: #ddd; 
                float: right; 
            }
			 .extra { 
                display:none; 
            }
        </style>
        <script type="text/javascript">
        function show_more()
         {
			 $(".extra").css("display", "block");
			 $('#hide_more').css("display", "block");
			 $('#view_more').css("display", "none");
			 
		 }
        function hide_more()
         {
			 $(".extra").css("display", "none");
			 $('#hide_more').css("display", "none");
			 $('#view_more').css("display", "block");
		 }	
		 </script>

@stop