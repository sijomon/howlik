<div class="footer" id="footer">
	<div class="container">
		<ul class="pull-left navbar-link footer-nav list-inline" style="margin-left: -20px;">
			<li>
				<a href="{{ url(config('app.locale') . '/' . trans('routes.faq')) }}"> {{ t('FAQ') }} </a>
				<a href="{{ url(config('app.locale') . '/' . trans('routes.contact')) }}"> {{ trans('page.Contact') }} </a>
				<a href="{{ url(config('app.locale') . '/' . trans('routes.anti-scam')) }}"> {{ trans('page.Anti-scam') }} </a>
				<a href="{{ url(config('app.locale') . '/' . trans('routes.terms')) }}"> {{ t('Terms') }} </a>
				<a href="{{ url(config('app.locale') . '/' . trans('routes.privacy')) }}"> {{ t('Privacy') }} </a>
				@if (isset($lang) and isset($country))
					<a href="{{ url(config('app.locale') . '/' . trans('routes.v-sitemap', ['country_code' => $country->get('icode')])) }}"> {{ t('Sitemap') }} </a>
				@endif
				<a href="{{ url(config('app.locale') . '/' . trans('routes.countries')) }}"> {{ t('Countries') }} </a>
			</li>
			<li>

			</li>
		</ul>
		<ul class="pull-right navbar-link footer-nav list-inline" style="padding-right: 10px;">
			<li>
				&copy; {{ date('Y') }} <a href="{{ url('/') }}" style="padding: 0;">{{ strtolower(getDomain()) }}</a>
			</li>
			<li>
				<a href="{{ config('settings.facebook_page_url') }}" target="_blank"><i class="icon-facebook-rect"></i></a><a
						href="{{ config('settings.twitter_url') }}" target="_blank"><i class="icon-twitter-bird"></i></a>
			</li>
		</ul>
	</div>

</div>
<!-- /.footer -->