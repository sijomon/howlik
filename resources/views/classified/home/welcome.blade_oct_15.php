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

<!--listing holder start--> 

<!--<div class="listing_holder">

    <div class="container">

      <div class="Trending_section">

        <div class="listing_head"><span class="list_imgg"><img src="images/fire-element.svg"/></span><span class="trending">Trending Now</span></div>

        <div class="list_main">

          <div class="Starbucks">

            <div class="list_top">

              <div class="bitmap"><img src="images/Starbucks.png"></div>

              <div class="text_starbucks">

                <h4>Starbucks</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon"><img src="images/a_cup_of_tea_vector_154490.jpg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure><img src="images/28602-Holiday-Starbucks-.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">4.2/5</span> <span><img src="images/star_rating.png"></span> <span class="review">128 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

          <div class="Starbucks two">

            <div class="list_top">

              <div class="bitmap"><img src="images/rst_892219.jpg"></div>

              <div class="text_starbucks">

                <h4>KFC Dubai mall</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Dubai mall</h6>

              </div>

              <div class="tea_icon rest"><img src="images/restaurant.svg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure><img src="images/kfc-restaurants.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">3.0/2</span> <span><img src="images/star_rating.png"></span> <span class="review">128 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">120<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

          <div class="Starbucks theird">

            <div class="list_top">

              <div class="bitmap"><img src="images/460.jpg"></div>

              <div class="text_starbucks">

                <h4>Raffles Dubai</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon reffles"><img src="images/bed-filled.svg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure><img src="images/raffles-1.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">1.5/0</span> <span><img src="images/star_rating.png"></span> <span class="review">128 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

          <div class="Starbucks last">

            <div class="list_top">

              <div class="bitmap"><img src="images/nike.jpg"></div>

              <div class="text_starbucks">

                <h4>Nike</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon nike"><img src="images/layer-1.svg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure><img src="images/nike_bg.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">5/0.0</span> <span><img src="images/star_rating.png"></span> <span class="review">140 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

        </div>

        <div class="list_main">

          <div class="Starbucks">

            <div class="list_top">

              <div class="bitmap"><img src="images/span.png"></div>

              <div class="text_starbucks">

                <h4>Spa Cordon</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon spa_cyr"><img src="images/page-1.svg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure> <img src="images/spa.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">2/1.5</span> <span><img src="images/star_rating.png"></span> <span class="review">128 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

          <div class="Starbucks theird zerro">

            <div class="list_top">

              <div class="bitmap"><img src="images/ea.jpg"></div>

              <div class="text_starbucks">

                <h4>Starbucks</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon"><img src="images/a_cup_of_tea_vector_154490.jpg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure><img src="images/starbucks.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">2.0/5</span> <span><img src="images/star_rating.png"></span> <span class="review">128 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

          <div class="Starbucks">

            <div class="list_top">

              <div class="bitmap"><img src="images/epvenue.JPG"></div>

              <div class="text_starbucks">

                <h4>Dubai Polo Club</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon"><img src="images/em_construcao.png"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure><img src="images/polo.jpg"> </figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">7.1/1</span> <span><img src="images/star_rating.png"></span> <span class="review">130 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

          <div class="Starbucks last">

            <div class="list_top">

              <div class="bitmap"><img src="images/Golds Gym.jpg"></div>

              <div class="text_starbucks">

                <h4>Golds Gym</h4>

                <h6><span class="location_icon"><img src="images/facebook-placeholder-for-locate-places-on-maps.svg"></span>Elverachester</h6>

              </div>

              <div class="tea_icon gym"><img src="images/gymnastics-filled.svg"></div>

            </div>

            <div class="image_holder zoom-effect-container hover08 column">

              <div class="image-card">

                <figure> <img src="images/gym_group.jpg"></figure>

              </div>

            </div>

            <div class="label_holder">

              <div class="lab_holder"> <span class="bol">4.2/0</span> <span><img src="images/star_rating.png"></span> <span class="review">128 Reviews</span> </div>

            </div>

            <div class="btns_holder"> <span class="chat">128<img src="images/chat.svg"></span> <span class="heart">128<img src="images/hearts.svg"></span> <span class="view">128<img src="images/visible.svg"></span> </div>

          </div>

        </div>

        <div class="view_more"> <span>view more</span><span class="nos">(12456)</span> </div>

      </div>

    </div>

  </div>-->

<div class="listing_holder">
  <div class="container">
    <div class="Trending_section">
      <div class="listing_head"> 
        <!--  <span class="list_imgg"><img src="{{ url('/assets/frontend/images/fire-element.svg') }}"/></span>--> 
        <span class="trending">Trending Now</span></div>
      <div class="list_main"> @foreach ($all_ads as $cate)
        <?php 
			
			$pos = $pos + 1 ;
			
			$ad_id =   $cate->id;
			 
			 
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
			
			 ?>
        <div class="Starbucks <?php if($pos % 4 == 0) { ?> last <?php } ?>" >
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
              <figure><img src="/uploads/pictures/{{ $ad_image }}"> </figure>
            </div>
          </div>
          <div class="label_holder">
            <div class="lab_holder"> <span class="bol">{{ $exact_rate }}/5</span> <span><img src="{{ url('/assets/frontend/images/star_rating.png') }}"></span> <span class="review">{{ $review_ads_count }} Reviews</span> </div>
          </div>
          <div class="btns_holder"> <span class="chat">128<img src="{{ url('/assets/frontend/images/chat.svg') }}"></span> <span class="heart">128<img src="{{ url('/assets/frontend/images/hearts.svg') }}"></span> <span class="view">128<img src="{{ url('/assets/frontend/images/visible.svg') }}"></span> </div>
        </div>
        @endforeach </div>
      <div class="view_more"> <span>view more</span><span class="nos">({{ $all_ads_count }})</span> </div>
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
            
            <!--              <li style="width: 270px;">

                <div class="label_event"><span class="date">September 8</span> <img src="{{ url('/assets/frontend/images/event2.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>Management Development Programme </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 10</span> <img src="{{ url('/assets/frontend/images/event3.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>Saloons Experience </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 12</span> <img src="{{ url('/assets/frontend/images/event4.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>National Circuit Car Track Morning </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px">

                <div class="label_event"> <span class="date">September 16</span> <img src="{{ url('/assets/frontend/images/event1.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>Management Development Programme </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 20</span> <img src="{{ url('/assets/frontend/images/event2.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>National Circuit Car Track Morning </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 17</span> <img src="{{ url('/assets/frontend/images/event3.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>Management Development Programme </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 11</span> <img src="{{ url('/assets/frontend/images/event4.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>National Circuit Car Track Morning </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 14</span> <img src="{{ url('/assets/frontend/images/event1.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>Management Development Programme </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>

              <li style="width: 270px;">

                <div class="label_event"> <span class="date">September 22</span> <img src="{{ url('/assets/frontend/images/event2.jpg') }}"> </div>

                <div class="img_inner">

                  <h4>National Circuit Car Track Morning </h4>

                  <div class="spa"> <span><img src="{{ url('/assets/frontend/images/location-pin.svg') }}"></span> <span>cavalli club dubai</span> </div>

                </div>

              </li>-->
            
          </ul>
        </div>
        <a class="jcarousel-control-prev brands_1" href="#" data-jcarouselcontrol="true">‹</a> <a class="jcarousel-control-next brands_2" href="#" data-jcarouselcontrol="true">›</a> </div>
    </div>
    <div class="more_events">
      <h4> <a class="" href="{{ lurl('events') }}"> More Events</a></h4>
    </div>
  </div>
</div>

<!---Most Popular In Dubai

  

  <div class="Most_popular">

    <div class="container">

      <div class="popular_holder">

        <div class="popular_head"> <span><img src="{{ url('/assets/frontend/images/group.svg') }}"></span>

          <h2>Most Popular In Dubai</h2>

        </div>

        <div class="main_nav">

          <nav>

            <ul id="navi" class="nav nav-tabs">

              <li><a data-toggle="tab" href="#home">Shopping</a></li>

              <li><a data-toggle="tab" href="#menu1">Health</a></li>

              <li><a href="#">Real Estate</a></li>

              <li><a href="#">Financial</a></li>

              <li><a href="#">Automotive</a></li>

              <li><a href="#">Education</a></li>

              <li><a href="#">Religious</a></li>

              <li><a href="#">Food</a></li>

              <li><a href="#">Active Life</a></li>

              <li><a href="#">Cafe</a></li>

              <li><a href="#">Test product1</a></li>

              <li><a href="#">Test product2</a></li>

            </ul>

            <span><img src="{{ url('/assets/frontend/images/right-arrow.svg') }}"></span> </nav>

        </div>

        <div class="tab-content">

          <div id="home" class="tab-pane fade in active">

            <div class="tab_content_1">

              <div class="img_holder hovereffect"> <img src="{{ url('/assets/frontend/images/slide.jpg') }}"/>

                <div class="overlay">

                  <div class="top_zro"> <span class="overlay_img"><img src="{{ url('/assets/frontend/images/Starbucks1.png') }}"></span>

                    <h2>Starbucks</h2>

                    <p> <a href="#">Elverachester </a> </p>

                    <p><a href="#" class="round">5/5</a></p>

                    <span class="star_imgholder"> <img src="{{ url('/assets/frontend/images/star_rating.png') }}"></span> </div>

                </div>

              </div>

              <div class="scrol_wrapper">

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">2</span><span class="img_section"><img src="{{ url('/assets/frontend/images/burger_king.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Burger King</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">3</span><span class="img_section"><img src="{{ url('/assets/frontend/images/kfc.jpg') }}"/></span>

                      <div class="rating">

                        <h5>KFC Dubai</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">4</span><span class="img_section"><img src="{{ url('/assets/frontend/images/nike.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Nike</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">5</span><span class="img_section"><img src="{{ url('/assets/frontend/images/Golds Gym.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Gold Gym</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">6</span><span class="img_section"><img src="{{ url('/assets/frontend/images/burger_king.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Burger King</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">7</span><span class="img_section"><img src="{{ url('/assets/frontend/images/460.jpg') }}"></span>

                      <div class="rating">

                        <h5>Raffles</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

              </div>

            </div>

          </div>

          <div id="menu1" class="tab-pane fade">

            <div class="tab_content_1">

              <div class="img_holder"> <img src="images/tab1_img.jpg"/> </div>

              <div class="scrol_wrapper">

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">2</span><span class="img_section"><img src="{{ url('/assets/frontend/images/burger_king.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Burger King</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">3</span><span class="img_section"><img src="{{ url('/assets/frontend/images/kfc.jpg') }}"/></span>

                      <div class="rating">

                        <h5>KFC Dubai</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">4</span><span class="img_section"><img src="{{ url('/assets/frontend/images/nike.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Nike</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">5</span><span class="img_section"><img src="{{ url('/assets/frontend/images/Golds Gym.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Gold Gym</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">6</span><span class="img_section"><img src="{{ url('/assets/frontend/images/burger_king.jpg') }}"/></span>

                      <div class="rating">

                        <h5>Burger King</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

                <div class="scro0l_holder">

                  <ul>

                    <li><span class="no">7</span><span class="img_section"><img src="{{ url('/assets/frontend/images/460.jpg') }}"></span>

                      <div class="rating">

                        <h5>Raffles</h5>

                        <span class="star_rat"><img src="{{ url('/assets/frontend/images/star_rating.png') }}"/></span><span class="sub_test"> <span class="location_icon new"><img src="{{ url('/assets/frontend/images/facebook-placeholder-for-locate-places-on-maps.svg') }}"></span>106 Sunshine Building </span> </div>

                    </li>

                  </ul>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>
  
  --> 

@stop