<!-- BOF COMPANY LISTING -->
<div class="Company-listing">
	<div class="Company-listing-container">
		<div class="company-list-holder">
			<div class="row">
			{{--*/ $k = 1; /*--}}
			{{--*/ $idArr = array(); /*--}}
			@if ($biz->getCollection()->count() > 0)
				@foreach($biz->getCollection() as $key => $prod)
						{{--*/ array_push($idArr, $prod->id); /*--}}
						{{--*/ $title = $prod->title; /*--}}
						{{--*/ $description = substr($prod->description, 0, 55); /*--}}
						@if(strtolower($lang->get('abbr'))=='ar')
							{{--*/ $title = $prod->title_ar; /*--}}
							{{--*/ $description = substr($prod->description_ar, 0, 55); /*--}}
						@endif
						{{--*/ $address = $prod->address1; /*--}}
						{{--*/ $city_name = ''; /*--}}
						@if(isset($prod->city_name))
							{{--*/ $city_name = $prod->city_name; /*--}}
							{{--*/ $address .= ', '.$prod->city_name; /*--}}
						@endif
						@if(strlen($prod->description)>55) {{--*/ $description .= '...'; /*--}} @endif
						{{--*/ $pDir = 'p-left'; /*--}}
						@if(($k%2)==0) {{--*/ $pDir = 'p-left'; /*--}} @endif
						{{--*/ $k++; /*--}}
						{{--*/ $link    =   "/".slugify(trim($prod->title.' '.$city_name))."/".$prod->id.".html"; /*--}}
						@if(($k%2)==0) 
						</div><div class="row">
						@endif
						<div class="col-md-6 {{$pDir}}">
							<div class="list-box">
								<div class="col-md-3 col-sm-3"> 
									@if(isset($prod->biz_image) && is_file(public_path($prod->biz_image)))
										<img src="{{url($prod->biz_image)}}" class="img-responsive company-logo">
									@else
										<img src="{{ url('/uploads/pictures/no-image.jpg') }}" class="img-responsive company-logo">
									@endif
								</div>
								<div class="col-md-9 col-sm-9">
									<div class="company-desc"> 
										@if(strlen($title)>35)
											{{--*/ $title = substr($title,0,20).'...'; /*--}}
										@endif
										<a href="{{ lurl($link) }}" class="company-name-header" > {{ ucfirst($title) }} </a>
										<div class="icons">
											<p class="span-star">
												{{--*/ $rvwArr = \DB::table('review')->where('biz_id',$prod->id)->get(); /*--}}
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
											<span class="span-dollar">
												@if(isset($rvwArr) && count($rvwArr) > 0)
													{{--*/ $dolsum	= 0; /*--}}
													{{--*/ $dolcnt	= 0; /*--}}
													{{--*/ $dolavg	= 0; /*--}}
													
													@foreach($rvwArr as $key => $reviewCount)
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
																<span class='fa fa-dollar' style="color: #cccccc"></span>
															@endfor
														@else
															{{--*/ $erate =	floor($dolavg); /*--}}
															@for($i=0;$i < $erate;$i++)
																<span class='fa fa-dollar' style="color: #00991f"></span>
															@endfor
															<span class='fa fa-dollar' style="color: #cccccc"></span>
															@for($i=0;$i < floor($doldif);$i++)
																<span class='fa fa-dollar' style="color: #cccccc"></span>
															@endfor
														@endif
													@else
														@for($i=0;$i < 5;$i++)
															<span class='fa fa-dollar' style="color: #cccccc"></span>
														@endfor		
													@endif
												@else
													@for($i=0;$i < 5;$i++)
														<span class='fa fa-dollar' style="color: #cccccc"></span>
													@endfor		
												@endif
											</span>
										</div>
										<div class="short-desc">
											<p>{{ ucwords($description) }}</p>
										</div>
										<p class="street-name">{{ ucwords($address) }}</p>
									</div>
								</div>
							</div>
						</div>
				@endforeach
			@else
				<div class="col-md-12"> {{ t('No result. Refine your search using other criteria.') }} </div>
			@endif
			</div>
		</div>
	</div>
</div>
<!-- EOF COMPANY LISTING -->

<!-- BOF PAGINATION LINK -->
<div class="pagination-bar text-center">
	{!! $biz->appends(Request::except('page'))->render() !!}
</div>
<!-- EOF PAGINATION LINK -->