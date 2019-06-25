{{--
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('classified.layouts.layout')
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row">

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
				<div class="col-sm-3 page-sidebar">
					@include('classified/account/inc/sidebar-left-user')
				</div>
                <?php  }else{ ?>
                <div class="col-sm-3 page-sidebar">
					@include('classified/account/inc/sidebar-left')
				</div>
                
                <?php }?>
				<!--/.page-sidebar-->

				<div class="col-sm-9 page-content">
					<div class="inner-box">
						@if (Request::segment(3)=='myads')
							<h2 class="title-2"><i class="icon-docs"></i> @lang('global.My Ads') </h2>
						@elseif (Request::segment(3)=='archived')
							<h2 class="title-2"><i class="icon-folder-close"></i> @lang('global.Archived ads') </h2>
						@elseif (Request::segment(3)=='favourite')
							<h2 class="title-2"><i class="icon-heart-1"></i> @lang('global.Favourite ads') </h2>
						@elseif (Request::segment(3)=='pending-approval')
							<h2 class="title-2"><i class="icon-hourglass"></i> @lang('global.Pending approval') </h2>
						@else
							<h2 class="title-2"><i class="icon-docs"></i> @lang('global.Ads') </h2>
						@endif

						<div class="table-responsive">
							<form method="POST" action="{{ lurl('account/'.Request::segment(3).'/delete') }}">
								{!! csrf_field() !!}
								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										@lang('global.Select'): @lang('global.All') |
										<button type="submit" class="btn btn-xs btn-danger">@lang('global.Delete') <i
													class="glyphicon glyphicon-remove"></i></button>
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
								<table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo"
									   data-filter="#filter" data-filter-text-only="true">
									<thead>
									<tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th> Photo</th>
										<th data-sort-ignore="true"> @lang('global.Adds Details') </th>
										<th data-type="numeric"> --</th>
										<th> Option</th>
									</tr>
									</thead>
									<tbody>

									<?php
									foreach($ads as $key => $ad):
										// Fixed 1
										if (Request::segment(3) == 'favourite') {
											if (isset($ad->ad)) {
												if (!is_null($ad->ad)) {
													$ad = $ad->ad;
												} else {
													continue;
												}
											} else {
												continue;
											}
										}

										// Fixed 2
										if (!$countries->has($ad->country_code)) continue;

										// Ad URL setting
										$adUrl = lurl(slugify($ad->title) . '/' . $ad->id . '.html');

                                        //$adUrl ="#";
										// Picture setting
										$adImg = '';
										$pictures = \App\Larapen\Models\Picture::where('ad_id', $ad->id);
										$countPictures = $pictures->count();
										if ($countPictures > 0) {
											if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename)) {
												$adImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
											}
											if ($adImg=='') {
												if (is_file(public_path() . '/'. $pictures->first()->filename)) {
													$adImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
												}
											}
										}
										// Default picture
										if ($adImg=='') {
											$adImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture'));
										}

										// Ad City
										if ($ad->city) {
											$city = $ad->city->name;
										} else {
											$city = '-';
										}
									?>
									{{-- dd($ad) --}}
									<tr>
										<td style="width:2%" class="add-img-selector">
											<div class="checkbox">
												<label><input type="checkbox" name="ad[]" value="{{ $ad->id }}"></label>
											</div>
										</td>
										<td style="width:14%" class="add-img-td">
											<a href="{{ $adUrl }}"><img class="thumbnail img-responsive" src="{{ $adImg }}" alt="img" data-no-retina/></a>
										</td>
										<td style="width:58%" class="ads-details-td">
											<div>
												<p><strong> <a href="{{ $adUrl }}" title="{{ $ad->title }}">{{ $ad->title }}</a> </strong></p>
												<p>
													<strong> @lang('global.Posted On') </strong>: {{ $ad->created_at->formatLocalized('%d %B %Y %H:%M') }}
												</p>
												<p><strong> @lang('global.Visitors') </strong>: {{ $ad->visits or 0 }}
													<strong>@lang('global.Located In'):</strong> {{ $city }} </p>
                                                    
                                                     <?php   if (Request::segment(3) == 'myads') { 
													 
													         $review_ads_count = 0;
													        
															 $ad_org_id = $ad->id;
															 
															 $reviews_for_this_ad  = DB::table("review")
																			       ->select('*')
																				   ->where("ads_id",  "=", $ad_org_id) 
																				   ->get();
															 $review_ads_count = count($reviews_for_this_ad);					   
													 
													 ?>								 
													
                                                          <p><strong> <a  data-toggle="modal" href="#user_reviews" onclick="show_reviews('<?= $ad_org_id ?>')" title="Reviews">{{ $review_ads_count }} Reviews</a> </strong></p>
                                                     
                                                     <?php } ?>
                                                    
											</div>
										</td>
										<td style="width:16%" class="price-td">
											<div>
												<strong>
													@if($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
													{{ \App\Larapen\Helpers\Number::short($ad->price) }}
													@if($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
												</strong>
											</div>
										</td>
										<td style="width:10%" class="action-td">
											<div>
												@if ($ad->user_id==$user->id and in_array($ad->active, array(0, 1)) and $ad->archived==0)
													<p><a class="btn btn-primary btn-xs" href="{{ lurl('post/' . $ad->id) }}"> <i
																	class="fa fa-edit"></i> @lang('global.Edit') </a></p>
												@endif
												@if ($ad->active==1 and $ad->archived==0)
													<!--<p>
														<a class="btn btn-info btn-xs"> <i class="fa fa-mail-forward"></i> @lang('global.Share') </a>
													</p>-->
												@endif
												@if ($ad->archived==1)
													<p><a class="btn btn-info btn-xs"
														  href="{{ lurl('account/'.Request::segment(3).'/repost/'.$ad->id) }}"> <i
																	class="fa fa-recycle"></i> @lang('global.Repost') </a></p>
												@endif
												<p><a class="btn btn-danger btn-xs"
													  href="{{ lurl('account/'.Request::segment(3).'/delete/'.$ad->id) }}"> <i
																class="fa fa-trash"></i> @lang('global.Delete') </a></p>
											</div>
										</td>
									</tr>
									<?php endforeach; ?>

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

<div class="modal fade" id="user_reviews" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
							class="sr-only">@lang('global.Close')</span></button>
				<h4 class="modal-title"><i class=" icon-mail-2"></i> <!--@lang('global.Contact advertiser')--> Conatct Vendor</h4>
			</div>
			<form role="form" method="POST" action="">
				
                <div class="modal-body">
                test
                </div>
				<div class="modal-footer">
					
					<button type="submit" class="btn btn-success pull-right">reply</button>
				</div>
			</form>
		</div>
	</div>
</div>




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
	<!-- include custom script for ads table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
		function show_reviews(rev) {
			alert(rev);
			exit;
		}
			
	</script>
@endsection
