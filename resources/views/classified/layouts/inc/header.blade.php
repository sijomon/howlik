	<style>
.dropup .dropdown-menu, .navbar-fixed-bottom .dropdown .dropdown-menu {
    top: auto !important;
    bottom: 100% !important;
    margin-bottom: 2px !imortant;  
}
</style>

	<?php
		/**
		 * Logo manipulation
		 */
		if (config('settings.app_logo') != '' and file_exists(public_path() . '/' . config('settings.app_logo2'))) {
			$logo2x = config('settings.app_logo2');
		} else {
			$logo2x = 'assets/frontend/images/logo2.png';
		}
		if (config('settings.app_logo') != '' and file_exists(public_path() . '/' . config('settings.app_logo3'))) {
			$logo3x = config('settings.app_logo3');
		} else {
			$logo3x = 'assets/frontend/images/logo1.png';
		}
	?>
	<div class="header_wrapper">
	<!----------HEADER HOLDER STARTS HERE--------------->
	<div class="header-wrapper-top">
	  <div class="container">
		<div class="navigation">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
		  <div class="" id="collapsiblelogo">
		  	{{--*/ $cntry = '';/*--}}
			@if(isset($country) && $country->has('code'))
				{{--*/ $cntry = $country->get('code');/*--}}
			@endif
			<a href="{{ url('/' . $lang->get('abbr') . '/?d=' . $cntry) }}">
				<img src="{{url($logo2x)}}" alt="{{ strtolower(config('settings.app_name')) }}" />
			</a>
		  </div>
		  <!---------STARTS COLLAPSIBLE NAVIGATION-------------->
		  <div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav left-nav">
			  <li class="active"><a href="{{ lurl('account') }}"> @lang('global.Home') </a></li>
			  <li><a href="{{ lurl('events') }}"> @lang('global.Events') </a></li>
			  <li>@if(auth()->user())<a href="{{ lurl('profiles/'.auth()->user()->id) }}"> @lang('global.My Page') </a>@endif</li>
			  <li><a href="{{ lurl('find_friends') }}"> @lang('global.Find Friends') </a></li>
			  <li><a href="{{ lurl(trans('routes.add-business')) }}"> @lang('global.Add Your Business') </a></li>
			</ul>
			<ul class="nav navbar-nav right-nav">
			  @if (count(LaravelLocalization::getSupportedLocales()) > 1)
			  <li class=""> <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false"><div class="language">{{ strtoupper(config('app.locale')) }} <span class = "caret lang-caret"></span> </div></a>
				<ul class="dropdown-menu choose-language">
				  @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
              	  @if (!(isset($lang) && strtolower($localeCode) == strtolower($lang->get('abbr'))))
					<?php
						$link        = LaravelLocalization::getLocalizedURL($localeCode);
						$localeCode = strtolower($localeCode);

						// Laravel Routing don't support PHP rawurlencode() function
						if (str_contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'SearchController@location'))
						{
							$link = url($localeCode . '/' . trans('routes.v-search-location', [
								'country_code'    => $country->get('icode'),
								'title'        => \Illuminate\Support\Facades\Request::segment(4),
								'id'            => \Illuminate\Support\Facades\Request::segment(5)
							], 'messages', $localeCode));
						}
					?>
					<li><a href="{{ $link }}">{{{ $properties['native'] }}}</a></li>
				  @endif
              	  @endforeach
				</ul>
			  </li> 
			  @endif
              
              <li>
				<div class="message_div">
					<a href="{{ lurl('/messages') }}" title="{{ t('Messages') }}">
						<span class="fa fa-envelope message_icon" aria-hidden="true"></span>@if(isset($msgcount) && $msgcount > 0)<span class="message_badge"> {{ $msgcount }} </span>@endif
					</a>
                </div>
			  </li> 
			  <li>
				<div class="message_div">
					<a href="{{ lurl('friends-confirm') }}" title="{{ t('Friend Requests') }}">
						<span class="fa fa-bell-o message_icon" aria-hidden="true"></span>@if(isset($rqtcount) && $rqtcount > 0)<span class="notify_badge"> {{ $rqtcount }} </span>@endif
					</a>
                </div>
			  </li>

			  @if (!auth()->user())
			  <li>
				<div class="login"><a href="{{ lurl(trans('routes.login')) }}">{{ t('Login') }}</a></div>
			  </li>
			  <li>
				<div class="signup"><a href="{{ lurl(trans('routes.signup')) }}" >{{ t('Signup') }}</a></div>
			  </li>
			  @else
			  <li>
				<div class="login"><a href="{{ lurl(trans('routes.logout')) }}">{{ t('Signout') }}</a></div>
			  </li>
			  <li>
				<div class="signup"><a href="{{ lurl('/account') }}" >{{ auth()->user()->name }}</a></div>
			  </li>
			  @endif
			</ul>
		  </div>
		  <!--------END COLLAPSIBLE NAVIGATION-------------->
		</div>
	  </div>
	</div>
	<div class="header-wrapper-bottom">
	  <div class="container">
		@if(isset($logo2_status) && $logo2_status==1)
			<a href="{{ url('/' . $lang->get('abbr') . '/?d=' . $cntry) }}">
				<img src="{{url($logo3x)}}" class="bottom-logo" alt="{{ strtolower(config('settings.app_name')) }}" />
			</a>
		@endif
		
		
		<div class="bottom-align">
		@if (Request::is('*/*/googlesearch'))
			{{--*/ $searchUrl = lurl((isset($country) and $country->has('icode')) ? $country->get('icode') : 'CA'). '/googlesearch'; /*--}}
		@else
			{{--*/ $searchUrl = lurl((isset($country) and $country->has('icode')) ? $country->get('icode') : 'CA'). '/'.trans('routes.t-search'); /*--}}
		@endif
		<form id="seach" name="search" action="{{$searchUrl}}" method="GET">
		  <div id="countryselection">
			<div class="choose-country">
				<?php
				/*
				<select id="l_region" name="r" class="selectpicker l_region" data-live-search="true" data-size="3">
				@foreach($vlocations as $v_loc)
					<option value="{{ $v_loc['name'] }}" {{ (isset($vregion) and $vregion==$v_loc['name']) ? 'selected="selected"' : '' }}> {{ $v_loc['name'] }} </option>
				@endforeach
				</select>
				*/?>
				<select id="l_region" name="cn" onchange="chgFun();" class="selectpicker l_region" data-live-search="true" data-size="4">
				@if(isset($countries) && !empty($countries))
				@foreach($countries as $v_cn)
					@if(isset($lang) && strtolower($lang->get('abbr'))=='ar')
						{{--*/ $cname = $v_cn['name']; /*--}}
					@else
						{{--*/ $cname = $v_cn['asciiname']; /*--}}
					@endif
					<option value="{{ $v_cn['code'] }}" {{ (isset($country) and $country->get('code')==$v_cn['code']) ? 'selected="selected"' : '' }}> {{ $cname }} </option>
				@endforeach
				@endif
				</select>
			</div> 
			<div class="location-name"> <img src="{{url('assets/frontend/images/location-filled.svg')}}">
			  <input type="hidden" id="l_search" name="l" value="@if(isset($scityid)){{$scityid}}@endif"/>
              <input type="text" id="loc_search" class="loc_search" name="location" placeholder="{{ t('Current Location') }}" value="@if(isset($scity)){{$scity}}@endif"/>
			</div>
		  </div>
		  <div class="searchbar-holder">
			<div class="dropdown-category">
			  <span class="dropbtn-category" id="cat_id"> <span class="pull-right cat_img"><img src="{{url('assets/frontend/images/four-horizontal-lines-with-down-arrow.svg')}}"></span></span>
			  <div class="dropdown-content-category">
				<div style="background:#FFFFFF; overflow:hidden;">
					@foreach($vcategory as $cat)
					<div class="dropdown-content-one drop_cat" id="category_{{$cat->id}}" data-id="{{$cat->id}}"> <a href="#" onclick="return false;"><span id="cateImge_{{$cat->id}}" ><img src="{{ url($cat->picture) }}" class="h_img"></span><span class="tst_hold">{{$cat->name}}</span></a></div>
					@endforeach
					<input type="hidden" id="search_category" value="@if(isset($scat)){{$scat}}@endif" class="search_category" name="c">
				</div>
			  </div>
			</div>
			<input type="text" class="searchterm" name="q" value="@if(isset($sterm)){{$sterm}}@endif" placeholder="Search Term">
		  </div>
		  <!--<div class="search-btn"> <span class="fa fa-search"></span> </div>-->
		  <button class="btn search-btn" type="submit"> <span class="fa fa-search"></span> </button>
		</form>
		</div>
	  </div>
	</div>
	
	<!----------HEADER HOLDER ENDS HERE--------------->
	</div>
	
	<script language="javascript">
	function chgFun(){
		var loc = "{{url()->current()}}";

		window.location.href = loc+'?p='+$("#l_region").val();
		return false;
	}
	
	function chgFunMob(){
		var loc = "{{url()->current()}}";
		window.location.href = loc+'?p='+$("#l_region_mob").val();
		return false;
	}
	
	$(".drop_cat").click(function(){
		var cat_id = $(this).data("id");
		var cat_image = $('#cateImge_'+cat_id).html();
		var cat_text = $(this).find(".tst_hold").html();
		$(this).closest('form').find('.cat_img').html(cat_image);
		$(this).closest('form').find('.search_category').val(cat_id);
	});
	
	$(document).ready(function(){
		@if(isset($scat) && $scat>0)
			var cat_id = "{{$scat}}";
			var cat_image = $('#cateImge_'+cat_id).html();
			var cat_text = $("#category_"+cat_id).find(".tst_hold").html();
			$("#category_"+cat_id).closest('form').find('.cat_img').html(cat_image);
			$("#category_"+cat_id).closest('form').find('.search_category').val(cat_id);
		@endif
	});
	</script>