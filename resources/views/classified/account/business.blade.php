@extends('classified.layouts.layout')
@section('content')
<div class="main-container">
  <div class="container">
    <div class="row"> @if (Session::has('flash_notification.message'))
      <div class="container" style="margin-bottom: -10px; margin-top: -10px;">
        <div class="row">
          <div class="col-lg-12"> @include('flash::message') </div>
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
        <div class="inner-box"> @if (Request::segment(3)=='mybusiness')
          <h2 class="title-2"><i class="icon-docs"></i> @lang('global.My Business Listings') </h2>
          @elseif (Request::segment(3)=='archived')
          <h2 class="title-2"><i class="icon-folder-close"></i> @lang('global.Archived business') </h2>
          @elseif (Request::segment(3)=='favourite')
          <h2 class="title-2"><i class="icon-heart-1"></i> @lang('global.Favourite business') </h2>
          @elseif (Request::segment(3)=='pending-approval')
          <h2 class="title-2"><i class="icon-hourglass"></i> @lang('global.Pending approval') </h2>
          @else
          <h2 class="title-2"><i class="icon-docs"></i> @lang('global.My Business Listings') </h2>
          @endif
          <div class="table-responsive">
            <form method="POST" action="{{ lurl('account/'.Request::segment(3).'/delete') }}">
              {!! csrf_field() !!}
              <div class="table-action">
                <label for="checkAll">
                <input type="checkbox" id="checkAll">
                @lang('global.Select'): @lang('global.All') |
                <button type="submit" class="btn btn-primary btn-xs">@lang('global.Delete') <i class="glyphicon glyphicon-remove"></i></button>
                </label>
                <div class="table-search pull-right col-xs-7">
                  <div class="form-group">
                    <label class="col-xs-5 control-label text-right">@lang('global.Search') <br>
                    <a title="clear filter" class="clear-filter" href="#clear">[@lang('global.clear')]</a> </label>
                    <div class="col-xs-7 searchpan">
                      <input type="text" class="form-control" id="filter">
                    </div>
                  </div>
                </div>
              </div>
              <table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo" data-filter="#filter" data-filter-text-only="true">
                <thead>
                  <tr>
                    <th data-type="numeric" data-sort-initial="true"></th>
                    <th>{{ t('Photo') }}</th>
                    <th data-sort-ignore="true"> @lang('global.Business Details') </th>
					<th>{{ t('Option') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
					$k =1;
					$count_business = count($business);
					foreach($business as $key => $biz):
						// Fixed 1
						if (Request::segment(3) == 'favourite') {
							if (isset($biz->biz)) {
								if (!is_null($biz->biz)) {
									$biz = $biz->biz;
								} else {
									continue;
								}
							} else {
								continue;
							}
						}
						// Fixed 2
						if (!$countries->has($biz->country_code)) continue;
						// Business URL setting
						$bizUrl = lurl(slugify($biz->title) . '/' . $biz->id . '.html');
						//$bizUrl ="#";
						// Picture setting
						$bizImg = '';
						$pictures = \App\Larapen\Models\BusinessImage::where('biz_id', $biz->id);
						$countPictures = $pictures->count();
						if ($countPictures > 0) {
							if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename)) {
								$bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
							}
							if ($bizImg=='') {
								if (is_file(public_path() . '/'. $pictures->first()->filename)) {
									$bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
								}
							}
						}
						// Default picture
						if ($bizImg=='') {
							$bizImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture'));
						}
						// Ad City
						if ($biz->city) {
							$city = $biz->city->name;
						} else {
							$city = '-';
						}
					?>
                {{-- dd($biz) --}}
                <tr>
                  <td style="width:2%" class="add-img-selector"><div class="checkbox">
                      <label>
                      <input type="checkbox" name="biz[]" value="{{ $biz->id }}">
                      </label>
                    </div></td>
                  <td style="width:14%" class="add-img-td"><a href="{{ $bizUrl }}"><img class="thumbnail img-responsive" src="{{ $bizImg }}" alt="img" data-no-retina/></a></td>
                  <td style="width:58%" class="ads-details-td">
						<div>
							<p><strong> <a href="{{ $bizUrl }}" title="{{ $biz->title }}">{{ $biz->title }}</a> </strong></p>
							<p> <strong> @lang('global.Posted On') </strong>: {{ $biz->created_at->formatLocalized('%d %B %Y %H:%M') }} </p>
							<p><strong> @lang('global.Visitors') </strong>: {{ $biz->visits or 0 }} <strong>@lang('global.Located In'):</strong> {{ $city }} </p>
							<?php   
							if (Request::segment(3) == 'mybusiness') { 
								$review_business_count = 0;
							
								$biz_org_id = $biz->id;
							 
								$reviews_for_this_biz  = DB::table("review")
												   ->select('*')
												   ->where("biz_id",  "=", $biz_org_id) 
												   ->get();
								$review_business_count = count($reviews_for_this_biz);					   
								if($review_business_count > 0)
								{
							?>
							<p><strong> <a  data-toggle="modal" href="#user_reviews" onclick="show_reviews('<?= $k ?>','<?= $count_business?>')" title="Reviews">{{ $review_business_count }} Reviews</a> </strong></p>
							<?php }else{ ?>
							<p><strong> <a   title="Reviews">{{ $review_business_count }} Reviews</a> </strong></p>
							<?php }  } ?>
						</div>
					</td>
					<td style="width:10%" class="action-td">
						<div> 
							{{--*/ $certificates =	DB::table('gift_certificates')->where('biz_id', $biz->id)->where('active', '1')->first(); /*--}}
							@if(count($certificates) > 0)
								<p><a class="btn btn-primary btn-xs" href="{{ lurl('account/certificate/view/'.$biz->id) }}"> <i class="fa fa-certificate"></i> @lang('global.Certificates') </a></p>
							@endif
							@if ($biz->booking==1)
								<p><a class="btn btn-primary btn-xs" href="{{ lurl('account/businessbooking/' . $biz->id) }}"> <i class="fa fa-edit"></i> @lang('global.Bookings') </a></p>
							@endif
							<p><a class="btn btn-primary btn-xs" href="{{ lurl('account/business/location/'.$biz->id) }}"><i class="fa fa-map-marker" style="color: #fff"></i> @lang('global.Locations') </a></p>
							@if ($biz->user_id==$user->id and in_array($biz->active, array(0, 1)) and $biz->archived==0)
								<p><a class="btn btn-primary btn-xs" href="{{ lurl('account/bizinfo/' . $biz->id) }}"> <i class="fa fa-edit"></i> @lang('global.Edit') </a></p>
							@endif
							<p><a class="btn btn-danger btn-xs" href="{{ lurl('account/'.Request::segment(3).'/delete/'.$biz->id) }}"><i class="fa fa-trash"></i> @lang('global.Delete') </a></p>
						</div>
					</td>
                </tr>
				{{--*/ $k =$k + 1; /*--}}
				<?php
				endforeach;
				?>
                </tbody>
              </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal-message')
<div class="modal fade" id="user_reviews" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">@lang('global.Close')</span></button>
        <h4 class="modal-title"><i class=" icon-mail-2"></i>@lang('User Reviews')</h4>
      </div>
      <!--<form role="form" method="POST" action="">-->
      <div class="modal-body" style=" width: 100%;float: left;">
        <div class="all_reviews">
          <?php  
			  $h =1;
			  foreach($business as $key => $biz): 
              
				$biz_org_id = $biz->id;
				
				$reviews_for_this_biz  = DB::table("review")
								   ->select('*')
								   ->where("biz_id",  "=", $biz_org_id) 
								   ->get();
				$review_business_count     = count($reviews_for_this_biz);
              ?>
          <div class="single_review" id="single_review_<?= $h ?>"  style="display:none;"> @foreach ($reviews_for_this_biz as $reviews)
            <div class="single_one">
              <?php
				$user_id 	= $reviews->user_id; 
				$user_name 	= $reviews->user_name; 	
			   ?>
              <div class="default_image"><img src="{{ url('assets/frontend/images/default.png') }}" /></div>
              <div class="three_span"> <span style="float:left; width: 83%;">{{ $user_name }}</span> <span class="date_new" style="float:right;"><?php echo date('d/m/Y',strtotime($reviews->created_at)) ?></span>
                <p> {{ $reviews->review }} </p>
                <?php  
									 
					$already_replyed_by_vendor = DB::table("review_reply")
					->select('reply')
					->where("review_id", "=", $reviews->id) 
					->get();

					if(!empty($already_replyed_by_vendor))	
					{
						$reply_by_vendor = $already_replyed_by_vendor[0]->reply;
					}
					else
					{
						$reply_by_vendor = 0;
					}								
					
					if($reply_by_vendor === 0)  {   
						if (auth()->user())
						{
							if (isset($user))
							{
								$vendor = $user->id;
							}
						}
				?>
                <a href="javascript:write_reply('<?= $reviews->id ?>');" id="write_reply_link_<?= $reviews->id ?>" > <i class="fa fa-comment"></i>{{ t('Write Reply') }}</a>
                <form id="reply_form_<?= $reviews->id ?>"  style="display:none;" >
                  <textarea name="review_text" class="text_arr" id="review_text_<?= $reviews->id ?>"></textarea>
                  <input type="button" class="tst_btnn" value="submit" onclick="post_review_reply(<?php echo $vendor; ?>,<?php echo $reviews->id; ?>);" />
                </form>
                <span id="review_reply_success_<?= $reviews->id ?>" style="display:none;">{{ t('Replied Successfully') }}</span>
                <?php }else {
										 ?>
                <a href="javascript:show_reply('<?= $reviews->id ?>');" id="reply_link_<?= $reviews->id ?>" > <i class="fa fa-comment"></i>{{ t('Show Reply') }}</a> <a href="javascript:hide_reply('<?= $reviews->id ?>');" id="reply_hide_link_<?= $reviews->id ?>" style="display:none" > <i class="fa fa-comment"></i>{{ t('Hide Reply') }}</a>
                <div class="rpy_holder" id="reply_show_<?= $reviews->id ?>" style="display:none; border:1px solid black;" > <?php echo $reply_by_vendor;   ?> </div>
                <?php   }?>
              </div>
            </div>
            @endforeach </div>
          <?php 
				$h =$h +1;
				endforeach; ?>
        </div>
      </div>
      <div class="modal-footer">
        <!--<button type="submit" class="btn btn-success pull-right">reply</button>-->
      </div>
      <!--</form>-->
    </div>
  </div>
</div>
@endsection

@section('javascript')
	@parent
<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});
			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});
			$('#checkAll').click(function () {
				checkAll(this);
			});
		});
	</script>
<!-- include custom script for business table [select all checkbox]  -->
<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
		function show_reviews(rev,count) {
			for (i = 1; i <= count; i++)
			 {
				var biz_div_scr = '#single_review_' + i;
				$(biz_div_scr).css("display", "none");
             }
			
			var biz_div = '#single_review_' + rev;
			$(biz_div).css("display", "block");
			
		}
		
function show_reply(review_id)
         {
			 
			  var reply_message_show = '#reply_show_' + review_id;
		 
		      var reply_show_link = '#reply_link_' + review_id;
			  
			  var reply_hide_link = '#reply_hide_link_' + review_id;
			 
			
			 $(reply_message_show).css("display", "block");
			 $(reply_hide_link).css("display", "block");
			 $(reply_show_link).css("display", "none");
			 
		 }
function hide_reply(review_id)
         {
			  var reply_message_show = '#reply_show_' + review_id;
		 
		      var reply_show_link = '#reply_link_' + review_id;
			  
			  var reply_hide_link = '#reply_hide_link_' + review_id;
			 
			
			 $(reply_message_show).css("display", "none");
			 $(reply_hide_link).css("display", "none");
			 $(reply_show_link).css("display", "block");
		 }		 
function write_reply(id)
         {
			 var reply_form = '#reply_form_' + id;
			 var wite_reply_link =  '#write_reply_link_' + id;
			 
			 $(reply_form).css("display", "block");
			//$("#review_form").css("display", "block");
			 $(wite_reply_link).css("display", "none");
			 
		 }		 
function post_review_reply(vendor,review_id) {
	
	     var text_message  = 'textarea#review_text_' + review_id;
		 
		 var form_id       = '#reply_form_' + review_id;
		 
		 var reply_success = '#review_reply_success_' + review_id;
	
	     var message       = $(text_message).val();
		 
		 if(message == "")
		 {
			  alert("Please Enter Reply Message");
		      exit;
		 }
		 else
		 {
			 //alert(message);
			 
			 $.ajax({
			//url: "add_rating.php",
			url: siteUrl + '/ajax/ajax_add_reviews_reply',
			data:'review_id='+review_id+'&vendor='+vendor+'&msg='+message,
			type: "POST"
			});
			
			
			$(reply_success).css("display", "block");
			$(form_id).css("display", "none");
			
			 
		     exit;
		 }
}
	
	</script>
@endsection 
