@extends('classified.layouts.layout')

@section('javascript-top')
	@parent
	@if (config('services.googlemaps.key')) 
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script> 
@endif
@endsection

@section('content')
	{!! csrf_field() !!}
<input type="hidden" id="ad_id" value="{{ $ad->id }}">
<?php
	$exact_rate =0;
	$vendor = 0;
	$org_vendor =0;
	$reviews_for_this_ad ="";
	$ad_rate_value = 0;
	$reviewed_by_this_user = 0;
	$fav_of_this_user = 0;
	$ad_org_id     = $ad->id;
	
	
	
	
	////////////// finding  user rating ///////////////////////
				
				$rate_ads = DB::table("ratings")
						->selectRaw('sum(ratings) as sumratings')
						->where("ads_id", "=", $ad_org_id) // "=" is optional
						->get();
				$rate_ads_check = DB::table("ratings")
						->where("ads_id", "=", $ad_org_id) // "=" is optional
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
	////////////// finding  user rating //////////////// //////
	
	
	////////////// user reviews ////////////////////////////// 
			$reviews_for_this_ad  = DB::table("review")
			                      ->select('*')
				                  ->where("ads_id",  "=", $ad_org_id) 
				                  ->get();
	///////////////////////// user reviews /////////////////
	
	
	
	
	
	
	
	
	
	
	if (!auth()->user())
	{
		     $logined_user = "";
	}
	else
	{
		if (isset($user))
		{
			
			 if( $user->user_type_id  == 2)
			 {
				 $vendor = 1;
				 ////////////// find owner of this ad///////
				 $owner_of_this_ad  = DB::table("ads")
			    ->select('user_id')
				->where("id",  "=", $ad_org_id) 
				->get();
				
				$owner_id =    $owner_of_this_ad[0]->user_id;
				
				if($user->id == $owner_id)
				{
					$org_vendor =1;
				}
				else
				{
					$org_vendor =0;
				}
				
				
				//echo $user->id."---".$owner_id;exit;
				 
				////////////// find owner of this ad///////
				 
				 
				
					
				 
			 }
			 else
			 {
				 $vendor = 0;
			 }
			
			
			$logined_user = $user->id;
			
			
			
			
			 $rated_by_this_user = DB::table("ratings")
			    ->select('ratings')
				->where("ads_id",  "=", $ad_org_id) 
				->where("user_id", "=", $logined_user) 
				->get();
				
			
			if(!empty($rated_by_this_user))	
				{
					$ad_rate_value = $rated_by_this_user[0]->ratings;
				}
			else
				{
					$ad_rate_value = 0;
				}
				
			/////////////////////////////////////// checking review done or not ////////////////////////////
			
			 $reviewed_by_this_user = DB::table("review")
			    ->select('review')
				->where("ads_id",  "=", $ad_org_id) 
				->where("user_id", "=", $logined_user) 
				->get();
				
			
			if(!empty($reviewed_by_this_user))	
				{
					$reviewed_by_this_user = $reviewed_by_this_user[0]->review;
				}
			else
				{
					$reviewed_by_this_user = 0;
				}	
				/////////////////////////////////////// checking ad is favourite ////////////////////////////
			
		    $fav_by_this_user = DB::table("saved_ads")
			    ->select('id')
				->where("ad_id",  "=", $ad_org_id) 
				->where("user_id", "=", $logined_user) 
				->get();
				
			
			if(!empty($fav_by_this_user))	
				{
					$fav_of_this_user = 1;
				}
			else
				{
					$fav_of_this_user = 0;
				}	
			/////////////////////////////////////// checking  ad is favourite  ////////////////////////////	
		}
	}
	 ?>
<div class="main-container"> @if (Session::has('flash_notification.message'))
  <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
    <div class="row">
      <div class="col-lg-12"> @include('flash::message') </div>
    </div>
  </div>
  <?php Session::forget('flash_notification.message'); ?>
  @endif
  
  @include('classified/layouts/inc/advertising/top')
  <div class="container">
    <ol class="breadcrumb pull-left">
      <li><a href="{{ lurl('/') }}"><i class="icon-home fa"></i></a></li>
      <li><a href="{{ lurl('/') }}">{{ $country->get('name') }}</a></li>
      <li> <a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('asciiname')).'/'.$parent_cat->slug) }}"> {{ $parent_cat->name }} </a> </li>
      @if ($parent_cat->id != $cat->id)
      <li> <a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('asciiname')).'/'.$parent_cat->slug.'/'.$cat->slug) }}"> {{ $cat->name }} </a> </li>
      @endif
      <li class="active">{{ $ad->title }}</li>
    </ol>
    <div class="pull-right backtolist"><a href="{{ URL::previous() }}"> <i
							class="fa fa-angle-double-left"></i> {{ t('Back to Results') }}</a></div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 page-content col-thin-right">
        <div class="inner inner-box ads-details-wrapper">
          <h2> <strong> <a href="{{ lurl(slugify($ad->title).'/'.$ad->id.'.html') }}"
										title="{{ mb_ucfirst($ad->title) }}">{{ mb_ucfirst($ad->title) }}</a> </strong> <small class="label label-default adlistingtype">{{ t(':type ad', ['type' => t(''.$ad->adType->name)]) }}</small> <span class="avarage_rating" dir="ltr">
            <?php  //if($vendor == 1  && $org_vendor ==1)  { 
                                     
                                     
                                      $rate =  $exact_rate;     ?>
            <fieldset id='demo2' class="rating rate_style_vendor">
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
            <?php //} ?>
            </span> </h2>
          <span class="info-row"> <span class="date_holder da_1"><i class=" icon-clock"> </i> {{ $ad->created_at_ta }} &nbsp;&nbsp;-</span> <span class="category cate_1">{{ $parent_cat->name }} &nbsp;&nbsp;-</span> <span class="item-location loca_1"><i class="fa fa-map-marker mar"></i> {{ $ad->city->name }} &nbsp;&nbsp;-</span>  <span class="category ca_2"><i class="icon-eye-3"></i>
			@if ($lang->get('abbr') == 'ar')
				@if ($ad->visits>1)
					{{ $ad->visits.' '.t('v_views') }}
				@else
					{{ $ad->visits.' '.t('v_view') }}
				@endif 
			@else
				{{ trans_choice('global.v_views', $ad->visits) }}
			@endif 
		  </span> </span> @if (count($ad->pictures) > 0)
          <div class="ads-image" dir="ltr">
            <h1 class="pricetag"> @if ($ad->price > 0)
              @if ($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
              {{ \App\Larapen\Helpers\Number::short($ad->price) }}
              @if ($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
              @else
              @if ($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
              {{ '--' }}
              @if ($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
              @endif </h1>
            <ul class="bxslider">
              <?php $picBigUrl = ''; ?>
              @foreach($ad->pictures as $key => $image)
              <?php
					if (is_file(public_path() . '/uploads/pictures/'. $image->filename)) {
						$picBigUrl = url('pic/x/cache/big/' . $image->filename);
					}
					if ($picBigUrl=='') {
						if (is_file(public_path() . '/'. $image->filename)) {
							$adImg = url('pic/x/cache/big/' . $image->filename);
						}
					}
					// Default picture
					if ($picBigUrl=='') {
						$picBigUrl = url('pic/x/cache/big/' . config('larapen.laraclassified.picture'));
					}
				?>
              <li><img src="{{ $picBigUrl }}" alt="img" data-no-retina/></li>
              @endforeach
            </ul>
            <div id="bx-pager">
              <?php $picSmallUrl = ''; ?>
              @foreach($ad->pictures as $key => $image)
              <?php
				if (is_file(public_path() . '/uploads/pictures/'. $image->filename)) {
					$picSmallUrl = url('pic/x/cache/small/' . $image->filename);
				}
				if ($picSmallUrl=='') {
					if (is_file(public_path() . '/'. $image->filename)) {
						$adImg = url('pic/x/cache/small/' . $image->filename);
					}
				}
				// Default picture
				if ($picSmallUrl=='') {
					$picSmallUrl = url('pic/x/cache/small/' . config('larapen.laraclassified.picture'));
				}
				?>
              <a class="thumb-item-link" data-slide-index="{{ $key }}" href=""> <img src="{{ $picSmallUrl }}" alt="img" data-no-retina/> </a> @endforeach </div>
          </div>
          <!--ads-image--> 
          @endif
          
          @if(config('settings.show_ad_on_googlemap'))
          <div class="Ads-OnGoogleMaps">
            <h5 class="list-title"><strong>{{ t('Location') }}</strong></h5>
            <iframe id="googleMaps" width="100%" height="170" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
          </div>
          @endif
          <div class="Ads-Details">
            <h5 class="list-title"><strong>{{ t('Ads Details') }}</strong></h5>
            <div class="row" style="padding-bottom: 20px;">
              <div class="ads-details-info col-md-8">
                <div class="ad_discription">
                  <p> {!! nl2br(auto_link(str_clean($ad->description))) !!} </p>
                </div>
                <?php  // if($reviews_for_this_ad != "" && $vendor == 1 && $org_vendor ==1)  { ?>
                <h4>{{ t('User reviews') }}</h4>
                <hr />
                <div class="all_reviews"> @foreach ($reviews_for_this_ad as $reviews)
                  <?php 
					$user_id = $reviews->user_id; 
					$should_reply = "";
					/* $reviewed_user = DB::table("users")
											->select('name')
											->where("id",  "=", $user_id) 
											->get();*/
					$reviewed_reply = DB::table("review_reply")
											->select('*')
											->where("review_id",  "=", $reviews->id) 
											->get();	
						//echo "<pre>";print_r($reviewed_reply); exit;
					if(!empty($reviewed_reply))	
					{
						$should_reply = $reviewed_reply[0]->reply;
						$vendor_id    = $reviewed_reply[0]->vendor_id;
						
						$vendor_user = DB::table("users")
							->select('name')
							->where("id",  "=", $vendor_id) 
							->get();
						$vendor_name     =	$vendor_user[0]->name;			
					}
					else
					{
						$should_reply = "";
					}
					
					$user_name     =	$reviews->user_name; 		
				  ?>
                  <div class="single_review">
                    <div class="default_image"><img src="{{ url('/assets/frontend/images/default.png') }}" /></div>
                    <div class="three_span"> <span style="float:left; width: 83%;">{{ $user_name }}</span> <span class="date_new"  style="float:right;"><?php echo date('d/m/Y',strtotime($reviews->created_at)) ?></span>
                      <p> {{ $reviews->review }} </p>
                    </div>
                    
                    <?php 
					
					//echo "<pre>";echo $should_reply ; exit;
					
					if($should_reply != "" )
					{ 
					//echo "<pre>";echo $should_reply ; exit;
					
					?>
                      <div class="single_reply">
                          <div class="default_image replyimage"><img src="{{ url('/assets/frontend/images/default.png') }}" /></div>
                           <div class="three_span reply_name"> <span style="float:left; width: 83%;">{{ $vendor_name }}</span> 
                           <p class="reply_content"><?php  echo $should_reply; ?></p>
                           </div>
                      </div>
                    <?php } ?>
                    
                    
                  </div>
                  @endforeach </div>
                <?php // } ?>
              </div>
              <div class="col-md-4">
                <aside class="panel panel-body panel-details">
                  <ul>
                    <li>
                      <p class=" no-margin"> <strong>{{ (isset($parent_cat->type) and !in_array($parent_cat->type, ['job-offer', 'job-search'])) ? t('Price') : t('Salary') }}:</strong>&nbsp;
                        @if ($ad->price > 0)
                        @if ($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
                        {{ \App\Larapen\Helpers\Number::short($ad->price) }}
                        @if ($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
                        @else
                        @if ($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
                        {{ '--' }}
                        @if ($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
                        @endif </p>
                    </li>
                    <li>
                      <p class="no-margin"> <strong>{{ t('Location') }}:</strong>&nbsp; 
                        <!--<a href="{!! url($lang->get('abbr').'/'.$country->get('icode').'/'.str_slug(trans('routes.t-search-location')).'/'.slugify($ad->city->name).'/'.$ad->city->id) !!}">
														{{ $ad->city->name }}
													</a>--> 
                        {{ $ad->city->name }} </p>
                    </li>
                    @if (!in_array($parent_cat->type, ['service', 'job-offer', 'job-search']))
                    <li>
                      <p class="no-margin"> <strong>{{ t('Item') }}:</strong>&nbsp;
                        {{ ($ad->new==1) ? t('New') : (($ad->new=1) ? t('Used') : t('None')) }} </p>
                    </li>
                    @endif
                  </ul>
                </aside>
                <div class="ads-action">
                  <ul class="list-border">
                    @if (isset($ad->user) and $ad->user->id != 1)
                    <li> <a href="{{ url($lang->get('abbr') . '/' . $country->get('icode') .'/' . trans('routes.t-search-user') . '/' . $ad->user->id) }}"> <i class="fa fa-user"></i> {{ t('More ads by User') }} </a> </li>
                    @endif
                    <?php if($logined_user != "" && $vendor == 0 )  { ?>
                    <li>
                      <?php if($fav_of_this_user == 0 )  { ?>
                      <a class="favorite_link" id="fav_id" onclick="save_fav(<?php echo $ad_org_id; ?>,<?php echo $logined_user; ?>);" > <i class="fa fa-heart"></i> {{ t('Select Favourite') }} </a> <a class="favorite_link" id="extra_remove_id" style="display:none;" onclick="remove_fav(<?php echo $ad_org_id; ?>,<?php echo $logined_user; ?>);" > <i class="fa fa-heart"></i> {{ t('Remove Favourite') }}</a>
                      <?php }else{ ?>
                      <a class="favorite_link" id="extra_fav_id" style="display:none;"  onclick="save_fav(<?php echo $ad_org_id; ?>,<?php echo $logined_user; ?>);" > <i class="fa fa-heart"></i> {{ t('Select Favourite') }} </a> <a class="favorite_link" id="remove_id" onclick="remove_fav(<?php echo $ad_org_id; ?>,<?php echo $logined_user; ?>);" > <i class="fa fa-heart"></i> {{ t('Remove Favourite') }}</a>
                      <?php  } ?>
                    </li>
                    <li>
                      <?php  if($reviewed_by_this_user === 0)  {    ?>
                      <a href="javascript:write_review();" id="write_review_link" > <i class="fa fa-comment"></i> {{ t('Write Review') }}</a>
                      <form id="review_form"  style="display:none;" >
                        <textarea name="review_text" id="review_text"></textarea>
                        <input type="button" value="submit" onclick="post_review(<?php echo $ad_org_id; ?>,<?php echo $logined_user; ?>,<?php echo $reviewed_by_this_user; ?>);" />
                        <span id="review_success" style="display:none;"> {{ t('Reviewed Successfully') }}</span>
                      </form>
                      <?php }else {
										 ?>
                      <a href="javascript:show_review();" id="review_link" > <i class="fa fa-comment"></i> {{ t('Show Review') }}</a> <a href="javascript:hide_review();" id="review_hide_link" style="display:none" > <i class="fa fa-comment"></i>{{ t('Hide Review') }}</a>
                      <div id="review_show" style="display:none; border:1px solid black;" > <?php echo $reviewed_by_this_user;   ?> </div>
                      <?php  }?>
                    </li>
                    <li>
                      <table class="demo-table">
                        <tbody>
                          <?php
                                                    $i=0;
													$rating = $ad_rate_value ;
                                                    ?>
                          <tr>
                            <td valign="top"><div id="tutorial-<?php echo $ad_org_id; ?>" >
                                <input type="hidden" name="rating" id="rating" value="<?php echo $rating; ?>" />
                                <ul onMouseOut="resetRating(<?php echo $ad_org_id; ?>);">
                                  <?php
                                                                              for($i=1;$i<=5;$i++) {
                                                                              $selected = "";
                                                                              if(!empty($rating) && $i<=$rating) {
                                                                                $selected = "selected";
                                                                              }
                                                                              ?>
                                  <li class='<?php echo $selected; ?>' onMouseOver="highlightStar(this,<?php echo $ad_org_id; ?>);" onMouseOut="removeHighlight(<?php echo $ad_org_id; ?>);" onClick="addRating(this,<?php echo $ad_org_id; ?>,<?php echo $logined_user; ?>,<?php echo $ad_rate_value?>);">&#9733;</li>
                                  <?php }  ?>
                                </ul>
                                <span id="rating_success" style="display:none;">{{ t('Rated Successfully')}}</span> </div></td>
                          </tr>
                        </tbody>
                      </table>
                    </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
              <br>
              &nbsp;<br>
            </div>
            <div class="content-footer text-left"> @if (Auth::check())
              @if ($user->id == $ad->user_id) <a class="btn btn-default" href="{{ lurl('post/'.$ad->id) }}"><i class="icon-pencil-2"></i> {{ t('Update') }} </a> @if (isset($parent_cat->type) and $parent_cat->type=='job-search')
              @if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume)) <a class="btn btn-primary" href="{{ url('uploads/resumes/'.$ad->resume) }}"
												   title="Download my resume"> <i class="icon-attach-1"></i> {{ t('My Resume') }} </a> @endif
              @endif
              @else
              @if (isset($parent_cat->type) and $parent_cat->type=='job-search')
              @if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume)) <a class="btn btn-primary" href="{{ url('uploads/resumes/'.$ad->resume) }}"
												   title="Download this resume"> <i class="icon-attach-1"></i> {{ t('Download the resume') }} </a> @endif
              @endif
              <?php  if($logined_user != "" && $vendor == 0 )  { ?>
              @if ($ad->seller_email != '') <a class="btn btn-default" data-toggle="modal" href="#contact_user"><i
														class=" icon-mail-2"></i> {{ t('Send a message') }} </a> @endif
              <?php } ?>
              @endif
              @else
              @if (isset($parent_cat->type) and $parent_cat->type=='job-search')
              @if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume)) <a class="btn btn-primary" href="{{ url('uploads/resumes/'.$ad->resume) }}" title="Download this resume"> <i class="icon-attach-1"></i> {{ t('Download the resume') }} </a> @endif
              @endif
              <?php  if($logined_user != "" && $vendor == 0 )  { ?>
              @if ($ad->seller_email != '') <a class="btn btn-default" data-toggle="modal" href="#contact_user"><i
													class=" icon-mail-2"></i> {{ t('Send a message') }} </a> @endif
              <?php } ?>
              @endif
              @if ($ad->seller_phone_hidden != 1 and !empty($ad->seller_phone)) <a class="btn btn-success showphone"><i
												class="icon-phone-1"></i> {!! $ad->seller_phone !!}{{-- t('View phone') --}} </a> @endif </div>
            @include('classified/layouts/inc/tools/facebook-comments') </div>
        </div>
        <!--/.ads-details-wrapper--> 
      </div>
      <!--/.page-content-->
      
      <div class="col-sm-3  page-sidebar-right">
        <aside>
          <div class="panel sidebar-panel panel-contact-seller">
            <div class="panel-heading">{{ t('Contact Seller') }}</div>
            <div class="panel-content user-info">
              <div class="panel-body text-center">
                <div class="seller-info"> @if (isset($ad->seller_name) and $ad->seller_name != '')
                  @if (isset($ad->user) and $ad->user->id != 1)
                  <h3 class="no-margin"> <a href="{{ url($lang->get('abbr') . '/' . $country->get('icode') .'/' . trans('routes.t-search-user') . '/' . $ad->user->id) }}"> {{ $ad->seller_name }} </a> </h3>
                  @else
                  <h3 class="no-margin">{{ $ad->seller_name }}</h3>
                  @endif
                  @endif
                  <p> {{ t('Location') }}:&nbsp; <strong> 
                    <!--<a href="{!! url($lang->get('abbr').'/'.$country->get('icode').'/'.trans('routes.t-search-location').'/'.slugify($ad->city->name).'/'.$ad->city->id) !!}">
													{{ $ad->city->name }}
												</a>--> 
                    {{ $ad->city->name }} </strong> </p>
                  @if($ad->user and !is_null($ad->user->created_at_ta))
                  <p> {{ t('Joined') }}: <strong>{{ $ad->user->created_at_ta }}</strong></p>
                  @endif </div>
                <div class="user-ads-action"> @if (Auth::check())
                  @if ($user->id == $ad->user_id) <a href="{{ lurl('post/'.$ad->id) }}" data-toggle="modal" class="btn btn-default btn-block"> <i class=" icon-pencil-2"></i> {{ t('Update') }} </a> @if (isset($parent_cat->type) and $parent_cat->type=='job-search')
                  @if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume)) <a class="btn btn-primary btn-block" href="{{ url('uploads/resumes/'.$ad->resume) }}"
														   title="Download my resume"> <i class="icon-attach-1"></i> {{ t('My Resume') }} </a> @endif
                  @endif
                  @else
                  @if (isset($parent_cat->type) and $parent_cat->type=='job-search')
                  @if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume)) <a class="btn btn-primary btn-block" href="{{ url('uploads/resumes/'.$ad->resume) }}"
														   title="Download this resume"> <i class="icon-attach-1"></i> {{ t('Download the resume') }} </a> @endif
                  @endif
                  <?php  if($logined_user != "" && $vendor == 0 )  { ?>
                  @if ($ad->seller_email != '') <a href="#contact_user" data-toggle="modal" class="btn btn-default btn-block"><i
																class=" icon-mail-2"></i> {{ t('Send a message') }} </a> @endif
                  <?php } ?>
                  @endif
                  @else
                  @if (isset($parent_cat->type) and $parent_cat->type=='job-search')
                  @if (trim($ad->resume) != '' and file_exists(public_path() . '/uploads/resumes/' . $ad->resume)) <a class="btn btn-primary btn-block" href="{{ url('uploads/resumes/'.$ad->resume) }}"
													   title="Download this resume"> <i class="icon-attach-1"></i> {{ t('Download the resume') }} </a> @endif
                  @endif
                  <?php  if($logined_user != "" && $vendor == 0 )  { ?>
                  @if ($ad->seller_email != '') <a href="#contact_user" data-toggle="modal" class="btn btn-default btn-block"><i
															class=" icon-mail-2"></i> {{ t('Send a message') }} </a> @endif
                  <?php } ?>
                  @endif
                  @if ($ad->seller_phone_hidden != 1 and !empty($ad->seller_phone)) <a class="btn btn-success btn-block showphone"><i
														class=" icon-phone-1"></i> {!! $ad->seller_phone !!}{{-- t('View phone') --}} </a> @endif </div>
              </div>
            </div>
          </div>
          @include('classified/layouts/inc/social/horizontal')
          <div class="panel sidebar-panel">
            <div class="panel-heading">{{ t('Safety Tips for Buyers') }}</div>
            <div class="panel-content">
              <div class="panel-body text-left">
                <ul class="list-check">
                  <li> {{ t('Meet seller at a public place') }} </li>
                  <li> {{ t('Check the item before you buy') }} </li>
                  <li> {{ t('Pay only after collecting the item') }} </li>
                </ul>
                <p><a class="pull-right" href="{{ lurl(trans('routes.anti-scam')) }}"> {{ t('Know more') }} <i
													class="fa fa-angle-double-right"></i> </a></p>
              </div>
            </div>
          </div>
        </aside>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal-abuse')
	@include('classified/ad/details/inc/modal-abuse')
@endsection 

@section('modal-message')
<div class="modal fade" id="contact_user" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">@lang('global.Close')</span></button>
        <h4 class="modal-title"><i class=" icon-mail-2"></i> @lang('global.Contact vendor')</h4>
      </div>
      <form role="form" method="POST" action="{{ lurl($ad->id . '/contact') }}">
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
          @if (Auth::check())
          <input type="hidden" name="sender_name" value="{{ $user->name }}">
          <input type="hidden" name="sender_email" value="{{ $user->email }}">
          <input type="hidden" name="sender_phone" value="{{ $user->phone }}">
          @else
          <div class="form-group required <?php echo ($errors->has('sender_name')) ? 'has-error' : ''; ?>">
            <label for="sender_name" class="control-label">@lang('global.Name'):</label>
            <input id="sender_name" name="sender_name" class="form-control" placeholder="@lang('global.Your name')" type="text"
								   value="{{ old('sender_name') }}">
          </div>
          <div class="form-group required <?php echo ($errors->has('sender_email')) ? 'has-error' : ''; ?>">
            <label for="sender_email" class="control-label">@lang('global.E-mail'):</label>
            <div class="input-group"> <span class="input-group-addon"><i class="icon-mail"></i></span>
              <input id="sender_email" name="sender_email" type="text" placeholder="@lang('global.i.e. you@gmail.com')"
									   class="form-control" value="{{ old('sender_email') }}">
            </div>
          </div>
          <div class="form-group required <?php echo ($errors->has('sender_phone')) ? 'has-error' : ''; ?>">
            <label for="sender_phone" class="control-label">@lang('global.Phone Number'):</label>
            <div class="input-group"> <span class="input-group-addon"><i class="icon-phone-1"></i></span>
              <input id="sender_phone" name="sender_phone" type="text" maxlength="60" class="form-control"
									   value="{{ old('sender_phone') }}">
            </div>
          </div>
          @endif
          <div class="form-group required <?php echo ($errors->has('message')) ? 'has-error' : ''; ?>">
            <label for="message" class="control-label">@lang('global.Message') <span class="text-count">(500 max) </span>:</label>
            <textarea id="message" name="message" class="form-control required" placeholder="@lang('global.Your message here...')"
								  rows="5">{{ old('message') }}</textarea>
          </div>
          
          <!-- Captcha --> 
          @if (config('settings.activation_recaptcha'))
          <div class="form-group required <?php echo ($errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
            <label class="control-label" for="g-recaptcha-response">@lang('global.We do not like robots')</label>
            <div> {!! Recaptcha::render(['lang' => $lang->get('abbr')]) !!} </div>
          </div>
          @endif
		  
          <input type="hidden" name="ad" value="{{ $ad->id }}">
          <input type="hidden" name="msg_form" value="1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">@lang('global.Cancel')</button>
          <button type="submit" class="btn btn-success pull-right">@lang('global.Send message')</button>
        </div>
      </form>
    </div>
  </div>
</div>	
@endsection 

@section('javascript')
	@parent 
<script src="{{ url('assets/plugins/bxslider/jquery.bxslider.min.js') }}"></script> 
<script>
		var stateId = '<?php echo (isset($city)) ? $country->get('code') . '.' . $city->subadmin1_code : '0' ?>';

		/* JS translation */
		var lang = {
			loginToSaveAd: "@lang('global.Please log in to save the Ads.')",
			loginToSaveSearch: "@lang('global.Please log in to save your search.')",
			confirmationSaveSearch: "@lang('global.Search saved successfully !')",
			confirmationRemoveSaveSearch: "@lang('global.Search deleted successfully !')"
		};

		$('.bxslider').bxSlider({
			pagerCustom: '#bx-pager',
			@if($ad->pictures->count() > 1)
			controls: true,
			@else
			controls: false,
			@endif
			nextText: " @lang('global.Next') &raquo;",
			prevText: "&laquo; @lang('global.Previous') "
		});

		$(document).ready(function () {
			@if(count($errors) > 0)
				@if(count($errors) > 0 and old('msg_form')=='1')
					$('#contact_user').modal();
				@endif
				@if(count($errors) > 0 and old('abuse_form')=='1')
					$('#report_abuse').modal();
				@endif
			@endif
			@if(config('settings.show_ad_on_googlemap'))
				genGoogleMaps(
				'<?php echo config('services.googlemaps.key'); ?>',
				'<?php echo (isset($ad->city) and !is_null($ad->city)) ? addslashes($ad->city->name) . ',' . $country->get('name') : $country->get('name') ?>',
				'<?php echo $lang->get('abbr'); ?>'
				);
			@endif
		})
	</script> 
<script src="{{ url('assets/js/form-validation.js') }}"></script> 
<script src="{{ url('assets/js/app/show.phone.js') }}"></script> 
<script type="text/javascript" src="{{ url('assets/js/app/make.favorite.js') }}"></script> 
<script>
function highlightStar(obj,id) {
	removeHighlight(id);		
	$('.demo-table #tutorial-'+id+' li').each(function(index) {
		$(this).addClass('highlight');
		if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
			return false;	
		}
	});
}

function removeHighlight(id) {
	$('.demo-table #tutorial-'+id+' li').removeClass('selected');
	$('.demo-table #tutorial-'+id+' li').removeClass('highlight');
}

function addRating(obj,id,user_id,already) {
	if(already != 0)
	{
		alert("{{ t('You already rated') }}");
		exit;
	}
	
	$('.demo-table #tutorial-'+id+' li').each(function(index) {
	$(this).addClass('selected');
	$('#tutorial-'+id+' #rating').val((index+1));
	if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
		return false;	
	}
	});
	$.ajax({
		url: siteUrl + '/ajax/ajax_add_rating',
		data:'id='+id+'&user_id='+user_id+'&rating='+$('#tutorial-'+id+' #rating').val(),
		type: "POST"
	});
	$('#rating_success').css("display", "block");
}
function show_review()
{
	$("#review_show").css("display", "block");
	$('#review_hide_link').css("display", "block");
	$('#review_link').css("display", "none");

}
function hide_review()
{
	$("#review_show").css("display", "none");
	$('#review_hide_link').css("display", "none");
	$('#review_link').css("display", "block");
}		 
function write_review()
{
	$("#review_form").css("display", "block");
	$('#write_review_link').css("display", "none");

}		 
function post_review(id,user_id,already) {
	var message = $('textarea#review_text').val();
	if(already != 0)
	{
	  alert("{{ t('You already Reviewed') }}");
	  exit;
	}
	
	if(message == "")
	{
	  alert("{{ t('Please Enter Reviews') }}");
	  exit;
	}
	else
	{
		$.ajax({
			url: siteUrl + '/ajax/ajax_add_reviews',
			data:'id='+id+'&user_id='+user_id+'&msg='+message,
			type: "POST"
		});
		
		$('#review_success').css("display", "block");
		
		exit;
	}
}

function save_fav(id,user_id) {
	$.ajax({
		url: siteUrl + '/ajax/ajax_add_fav',
		data:'id='+id+'&user_id='+user_id,
		type: "POST"
	});
	
	$('#extra_remove_id').css("display", "block");
	$('#remove_id').css("display", "block");
	$('#fav_id').css("display", "none");
	$('#extra_fav_id').css("display", "none");
	
	exit;
}

function remove_fav(id,user_id) {
	$.ajax({
		url: siteUrl + '/ajax/ajax_remove_fav',
		data:'id='+id+'&user_id='+user_id,
		type: "POST"
	});
	
	$('#extra_remove_id').css("display", "none");
	$('#remove_id').css("display", "none");
	$('#fav_id').css("display", "block");
	$('#extra_fav_id').css("display", "block");
	
	exit;
}

function resetRating(id) {
	if($('#tutorial-'+id+' #rating').val() != 0) {
		$('.demo-table #tutorial-'+id+' li').each(function(index) {
			$(this).addClass('selected');
			if((index+1) == $('#tutorial-'+id+' #rating').val()) {
				return false;	
			}
		});
	}
} 
</script>
<style>
.demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
.demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
.demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
.demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
.demo-table ul{margin:0;padding:0;}
.demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
.demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
.ad_discription {
    width: 100%;
    float: left;
    height: 100px;
}
</style>
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
	div#tutorial-9 li {
		font-size: 35px !important;
	}
</style>
@endsection