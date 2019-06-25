<!-- BOF PAGINATION PAGE -->
{{--*/ $i = 1; /*--}}
{{--*/ $idArr = array(); /*--}}
@if(sizeof($biz)>0)
	@foreach($biz as $prod)
		@if(!in_array($prod->id, $idArr))
			{{--*/ array_push($idArr, $prod->id); /*--}}
			{{--*/ $title = $prod->title; /*--}}
			{{--*/ $description = substr($prod->description, 0, 55); /*--}}
			@if(strtolower($lang->get('abbr'))=='ar')
				{{--*/ $title = $prod->title_ar; /*--}}
				{{--*/ $description = substr($prod->description_ar, 0, 55); /*--}}
			@endif
			{{--*/ $address = $prod->address1; /*--}}
			{{--*/ $address .= ', '.$prod->city_name; /*--}}
			@if(strlen($prod->description)>55){{--*/ $description .= '...'; /*--}}  @endif
			{{--*/ $pDir = 'p-left'; /*--}}
			@if(($i%2)==0) {{--*/ $pDir = 'p-right'; /*--}} @endif
			{{--*/ $i++; /*--}}
			{{--*/ $link    =   "/".slugify($prod->title)."/".$prod->id.".html"; /*--}}
			
			<div class="col-md-6 col-sm-6 {{$pDir}}">
				<div class="list-box">
					<div class="col-md-3 col-sm-3"> 
						@if(is_file(public_path($prod->biz_image)))
							<img src="{{url($prod->biz_image)}}" class="img-responsive company-logo"> 
						@else
							<img src="{{url('uploads/pictures/no-image.jpg')}}" class="img-responsive company-logo">
						@endif
					</div>
					<div class="col-md-9 col-sm-9">
						<div class="company-desc"> <a href="{{ lurl($link) }}" class="company-name-header" > 
						{{ ucwords(str_limit($title, 25)) }} </a>
							<div class="icons">
								<p class="span-star">
								{{--*/ $stravg	= $prod->rating ; /*--}}
								{{--*/ $strdif	= 5 - $stravg; /*--}}
								@if($stravg > 0)
									@if(strlen($stravg) == 1)
										@for($i=0;$i < $stravg;$i++)
											<span class='fa fa-star'></span>
										@endfor
										@for($i=0;$i < floor($strdif);$i++)
											<span class='fa fa-star-o'></span>
										@endfor
									@else
										{{--*/ $rate1 =	floor($stravg); /*--}}
										@for($i=0;$i < $rate1;$i++)
											<span class='fa fa-star'></span>
										@endfor
										<span class='fa fa-star-half-o'></span>
										@for($i=0;$i < floor($strdif);$i++)
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
								{{--*/ $dolavg	= $prod->expense ; /*--}}
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
										<span class='fa fa-dollar' style="color: #cccccc"></span>
									@endfor		
								@endif
								</span>
							</div>
							<div class="short-desc">
								<p> {{ ucfirst($description) }} </p>
							</div>
							<p class="street-name">{{ ucfirst($address) }}</p>
						</div>
					</div>
				</div>
			</div>
		@endif	
	@endforeach
@else
	 <div class="col-md-12 col-sm-12">{{ t('No Data Found!') }}</div>
@endif
<!-- EOF PAGINATION PAGE -->
<!-- BOF PAGINATION LINK -->
<div class="col-md-12 pagination-bar text-center">
	{{ $biz->links() }}
</div>
<!-- EOF PAGINATION LINK -->

