<?php
/**
 * Logo manipulation
 */
if (config('settings.app_logo_red') != '' and file_exists(public_path() . '/' . config('settings.app_logo_red'))) {
	$logo = config('settings.app_logo_red');
} else {
	$logo = 'assets/frontend/images/logo.png';
}
?>
<!----------BANNER SECTION STARTS HERE--------------->
<div class="banner-section"> <img src="{{url('assets/frontend/images/banner01.jpg')}}">
  <div class="banner-overlay">
    <div class="logo-section"> 
	<a href="{{ url('/' . $lang->get('abbr') . '/?d=' . $country->get('code')) }}">
		<img src="{{url($logo)}}" alt="{{ strtolower(config('settings.app_name')) }}" /> 
	</a>
	</div>
    <h1 class="banner-caption">{{ t('" Locate Anything You Want Any Where You Are At "') }}</h1>
    <div class="app-icon"> <span class="ios"><a target="_blank" href="https://itunes.apple.com/in/app/howlik-find-whats-nearby/id1404841444?mt=8"><img src="{{url('assets/frontend/images/appstore.png')}}"></a></span> <span class="android"><a target="_blank" href="https://play.google.com/store/apps/details?id=nearby.business.events.howlik"><img src="{{url('assets/frontend/images/playstore.png')}}"/></a></span> </div>
  </div>
</div>
<!----------BANNER SECTION ENDS HERE------------------>
