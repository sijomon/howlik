@extends('classified.layouts.layout')
<style>
	.sort-by a {
		cursor: pointer;
	}
	.sort{
	  float:right;  border:1px solid #e40046;
	  color:#fff;  border-radius:30px;
	  position:relative;
	  padding:0px ;background:#e40046;
	  transition:ease-in-out all .2s;
	}
	.sort-click{
	  padding:10px 18px;  border-radius:100px;  
	  text-align:center; margin:0;float:left; cursor:pointer;
	}
	.lis{
	  list-style-type:none;  padding:0;  margin:0; 
	  text-align:center;
	  display:none; width:auto;
	 
	}
	.lis li{
	  padding:10px;
	  float:left;
	}
	.lis li.active a{
		/*background:#ccc;*/
		color:#e40046 !important;
	}
	.sort_a{
		color:#000 ;
		cursor:pointer;
	}
	.breadcrumb {
		float: left;
		width: auto;
	}
</style>
@section('content')

<!-- BOF CONTENTS -->
<div class="content-holder">
	<div class="container"> 
		<!-- BOF BREADCRUMB -->
		<div class="page-details">
			<ul class="breadcrumb">
				<li><a href="{{ lurl('/') }}"> {{ t('Home') }} </a></li>
				<li class="active"> {{$cat->name}}</li>
				<!--<li class="pull-right dropdown">
					<button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown"> {{ t('Sort by') }} &nbsp;<span class="caret"></span></button>
					<ul class="dropdown-menu sort-by">
						<li class="active"><a id="sort-by-date" class="select">{{ t('Date') }}</a></li>
						<li><a id="sort-by-rate">{{ t('Rating') }}</a></li>
						<li><a id="sort-by-expe">{{ t('Expense') }}</a></li>
					</ul>
				</li>--->
                
			</ul>
            <div class="sort">
                    <p id="click" class="sort-click">Sort by</p>
                    <p id="close" class="sort-click"><i class="fa fa-long-arrow-right" style="margin-top: 5px;"></i></p> 
                    <ul class="lis inline sort-by" id="list">
                      <li class="active"><a id="sort-by-date" class="select sort_a">{{ t('Date') }}</a></li>
					  <li><a id="sort-by-rate" class="sort_a">{{ t('Rating') }}</a></li>
					  <li><a id="sort-by-expe" class="sort_a">{{ t('Expense') }}</a></li>
                    </ul>
                </div>
		</div>
		<!-- EOF BREADCRUMB -->
	
		<!-- BOF COMPANY LISTING -->
		<div class="Company-listing">
			<div class="Company-listing-container">
				<!-- <h2 class="specify-caption">{{$cat->name.' '.t('in').' '.$vregion}}</h2> -->
				<h2 class="specify-caption">{{$cat->name}}</h2>
				<div class="company-list-holder">
					<div id="product_container">
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
									@if(($i%2)==0){{--*/ $pDir = 'p-right'; /*--}}  @endif
									{{--*/ $i++; /*--}}
									{{--*/ $link    =   "/".slugify($prod->title.' '.$prod->city_name)."/".$prod->id.".html"; /*--}}
									
									<div class="col-md-6 cpl-sm-6 {{$pDir}}">
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
							<div class="col-md-12">{{ t('No Data Found!') }}</div>
						@endif
						<!-- EOF PAGINATION PAGE -->
						<!-- BOF PAGINATION LINK -->
						<div class="col-md-12 pagination-bar text-center">
							{{ $biz->links() }}
						</div>
						<!-- EOF PAGINATION LINK -->
					</div>
				</div>
			</div>
		</div>
		<!-- EOF COMPANY LISTING -->
	</div>
</div>
<!-- EOF CONTENTS --> 
				
<!-- BOF BOTTOM CATEGORY LISTING --> 
<div class="bottom-category-list">
	<div class="container">
		<div class="list-cap">
			<h2>{{t('Categories')}}</h2>
		</div>
		<div class="col-md-12 col-sm-12">
			<div class="col-md-3 col-sm-3">
				<ul>
					{{--*/ $catLim = ceil(sizeof($cats)/4); $k = 1; /*--}}
					@if(isset($cats) && sizeof($cats)>0)
					@foreach($cats as $key => $value)
						@if($k>$catLim)
							</ul></div><div class="col-md-3 col-sm-3"><ul>
							{{--*/ $k = 1; /*--}}
						@endif
						<li><a href="{{lurl('c/'.trim($value->slug))}}"> {{$value->name}} </a></li>
						{{--*/ $k++; /*--}}
					@endforeach
					@endif
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- EOF BOTTOM CATEGORY LISTING --> 
@endsection

@section('javascript')
<!-- BOF PAGINATION AJAX SCRIPT -->
<script type="text/javascript">
	$(document).ready(function()
	{
		$(document).on('click', 'ul.sort-by li a',function(event)
		{ 
			event.preventDefault();
			$('ul.sort-by li').removeClass('active');
			$(this).parent('li').addClass('active'); 
			$('ul.sort-by li a').removeClass('select');
			$('ul.sort-by li.active a').addClass('select'); 
			var sort = $('ul.sort-by li.active a').html().toLowerCase();
			var url  = window.location.href;
			
			getData(url, sort);
		});
		
		$(document).on('click', '.pagination a',function(event)
		{
			event.preventDefault();
			$('li').removeClass('active');
			$(this).parent('li').addClass('active');
			var url  = $(this).attr('href');
			var sort = $('ul.sort-by li a.select').html().toLowerCase();
			
			getData(url, sort);
		});
	}); 
	function getData(url, sort) 
	{
		$.ajax({
			url : url,
			type: "get",
			data: { sort : sort }
		}).done(function (data) {
			$('#product_container').empty().html(data);
		}).fail(function () {
			alert('gloval.Data could not be loaded.');
		});
	}
</script>
<!-- EOF PAGINATION AJAX SCRIPT -->
<script>

//$('#click').click(function(){
//		var $this = $(this);
//		$this.toggleClass('sortoption');
//		if($this.hasClass('sortoption')){
//			$this.text('Sort by');			
//		} else {
//			$this.html('<span class="fa fa-long-arrow-right"></span>');
//		}
//	});
	
$("#close").hide();
$("#click").click (function(){
$("#list").show(); 
$("#close").show();
$("#click").hide();
$("#list").css({display:"inline-block"});
$(".lis").css({"background" :"#FFF", "border-radius": "0 100px 100px 0" })
//$(".sort_a").css({"color":"#000"}) 
});
$("#close").click (function(){
$("#list").hide();
$("#click").show();
$("#close").hide();
});
</script>
@endsection
