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
?>
<!--------------STARTS FOOTER SECTION------------>
<div class="footer">
	<div class="container">
		<div class="footer-content">  
			{{--*/ $cntry = '';/*--}}
			@if(isset($country) && $country->has('code'))
				{{--*/ $cntry = $country->get('code');/*--}}
			@endif
			<ul class="footer-nav">
				<li> <a href="{{ lurl(trans('routes.about')) }}"> {{ t('About') }} </a> </li>
				<li> <a href="{{ lurl(trans('routes.faq')) }}"> {{ t('FAQ') }} </a> </li>
				<li> <a href="{{ lurl(trans('routes.contact')) }}"> {{ t('Contact') }} </a> </li>
				<li> <a href="{{ lurl(trans('routes.anti-scam')) }}"> {{ trans('page.Anti-scam') }} </a> </li>
				<li> <a href="{{ url('/' . $lang->get('abbr') . '/?d=' . $cntry) }}"> <img src="{{url($logo2x)}}" alt="{{ config('settings.app_name') }}"> </a></li>
				<li> <a href="{{ lurl(trans('routes.terms')) }}"> {{ t('Terms') }} </a> </li>
				<li> <a href="{{ lurl(trans('routes.privacy')) }}"> {{ t('Privacy') }} </a> </li>
			<li> <a href="{{ lurl(trans('routes.guidelines')) }}"> {{ t('Guidelines') }} </a> </li>
				<li> <a href="{{ lurl(trans('routes.press')) }}"> {{ t('Press') }} </a> </li>
			</ul>
			
			<ul class="footer-social">
			    <li><a href="#"><img class="store" src="{{url('assets/frontend/images/playstore.png')}}"></a></li> 
				<li><a href="#"><img src="{{url('assets/frontend/images/fb.png')}}"></a></li>
				<li><a href="#"><img src="{{url('assets/frontend/images/tw.png')}}"></a></li>
				<li><a href="#"><img src="{{url('assets/frontend/images/insta.png')}}"></a></li>
				<li><a href="#"><img class="store" src="{{url('assets/frontend/images/appstore.png')}}"></a></li> 
			</ul>
		</div>
		<div class="copyright-holder">
			<div class="copyright-center">
				<p>&copy {{ config('settings.app_name') }} {{ t('All Rights Reserved') }} {{date("Y", time())}}</p>
			</div>
		</div>
	</div>
</div>
<!--------------ENDS FOOTER SECTION--------------> 

<!--------START LOCATION OELECTION ONLY MOBILE VIEW------------------->
<div class="location-mobile-holder">
	<div class="location-mobile-holder-left">
		
		<select id="l_region_mob" onchange="chgFunMob();" class="selectpicker" data-live-search="true" data-size="3">
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
	<div class="location-mobile-holder-right">
		<span class="fa fa-map-marker"></span> <input type="text" id="loc_search_mob" class="loc_search_mob" name="location" placeholder="{{ t('Current Location') }}" />
	</div>
</diV>
<!-------- ENDS LOCATION OELECTION ONLY MOBILE VIEW------------------->
