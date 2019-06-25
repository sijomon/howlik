<?php
/**
 * Logo manipulation
 */
if (config('settings.app_logo') != '' and file_exists(public_path() . '/' . config('settings.app_logo'))) {
	$logoFilename = last(explode('/', config('settings.app_logo')));
	$logo = 'pic/x/cache/logo/' . $logoFilename;
	$logo2x = 'pic/x/cache/logo2x/' . $logoFilename;
} else {
	$logo = 'images/logo.png';
	$logo2x = 'images/logo@2x.png';
}
?>
<div class="container">
	<div class="header">
		<nav class="navbar navbar-site navbar-default" role="navigation">
			<div class="container" style="padding-left: 0; padding-right: 0;">
				<div class="navbar-header">
					<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="{{ url('/' . $lang->get('abbr') . '/?d=' . $country->get('code')) }}" class="navbar-brand logo logo-title">
						<img src="{{ url($logo) }}" data-at2x="{{ url($logo2x) }}" style="float: left; margin: 0 5px 0 0;"
							 alt="{{ strtolower(config('settings.app_name')) }}" class="tooltipHere" title="" data-placement="bottom"
							 data-toggle="tooltip" type="button"
							 data-original-title="{{ config('settings.app_name') . ((isset($country) and $country->has('name')) ? ' ' . $country->get('name') : '') }}"/>
						@if (config('settings.activation_country_flag'))
							@if (isset($country) and !$country->isEmpty())
								@if (file_exists(public_path() . '/images/flags/iso/24/'.strtolower($country->get('code')).'.png'))
									<span><img src="{{ url('images/flags/iso/24/'.strtolower($country->get('code')).'.png') }}"
											   style="float: left; margin: 11px 0 0 0;" data-no-retina/> </span>
								@endif
							@endif
						@endif
					</a>
				</div>
				<div class="navbar-collapse collapse">

					<ul class="nav navbar-nav navbar-right">
						@if (!auth()->user())
							<li><a href="{{ lurl(trans('routes.login')) }}">{{ t('Login') }}</a></li>
							<li><a href="{{ lurl(trans('routes.signup')) }}">{{ t('Signup') }}</a></li>
							<li class="postadd">
							<!--<a class="btn btn-block btn-post btn-danger"
								   href="{{ lurl(trans('routes.create-ad')) }}"> {{ t('Create Free Ads') }}</a>-->
                                <a class="btn btn-block btn-post btn-danger"
								   href="{{ lurl(trans('routes.login')) }}"> {{ t('Create Free Ads') }}</a>
							</li>
						@else
							@if (isset($user))
								<li><a href="{{ lurl(trans('routes.logout')) }}">{{ t('Signout') }} <i class="glyphicon glyphicon-off"></i> </a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">
										<span>{{ $user->name }}</span>
										<i class="icon-user fa"></i>
										<i class=" icon-down-open-big fa"></i>
									</a>
									<ul class="dropdown-menu user-menu">
										<li class="active"><a href="{{ lurl('account') }}"><i class="icon-home"></i> @lang('global.Personal Home')
											</a></li>
										<li><a href="{{ lurl('account/myads') }}"><i class="icon-th-thumb"></i> @lang('global.My ads') </a></li>
										<li><a href="{{ lurl('account/favourite') }}"><i class="icon-heart"></i> @lang('global.Favourite ads') </a>
										</li>
										<li><a href="{{ lurl('account/saved-search') }}"><i
														class="icon-star-circled"></i> @lang('global.Saved search') </a></li>
										<li><a href="{{ lurl('account/archived') }}"><i class="icon-folder-close"></i> @lang('global.Archived ads')
											</a></li>
										<li><a href="{{ lurl('account/pending-approval') }}"><i
														class="icon-hourglass"></i> @lang('global.Pending approval') </a></li>
										<?php /* <li><a href="{{-- lurl('account/statements') --}}"><i class=" icon-money "></i> lang('global.Payment history') </a></li> */ ?>
									</ul>
								</li>
								<li class="postadd">
									<a class="btn btn-block btn-post btn-danger"
									   href="{{ lurl(trans('routes.create-ad')) }}">{{ t('Create Free Ads') }}</a>
								</li>
							@endif
						@endif

						@if (count(LaravelLocalization::getSupportedLocales()) > 1)
						<!-- Language selector -->
						<div class="dropdown" style="float:right; margin: 2px 0 0 5px;">
							<button class="btn dropdown-toggle btn-default-lite" type="button" id="dropdownMenu1" data-toggle="dropdown"
									style="padding: 9px;">
								{{ strtoupper(config('app.locale')) }}
								<span class="caret" style="margin-left: 5px;"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
								@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
									@if (strtolower($localeCode) != strtolower($lang->get('abbr')))
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
										<li role="presentation">
											<a role="menuitem" tabindex="-1" rel="alternate" hreflang="{{ $localeCode }}" href="{{ $link }}">
												{{{ $properties['native'] }}}
											</a>
										</li>
									@endif
								@endforeach
							</ul>
						</div>
						@endif
					</ul>

				</div>
			</div>
		</nav>
	</div>
</div>