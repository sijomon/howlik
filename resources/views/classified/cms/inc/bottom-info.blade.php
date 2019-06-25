@if (config('settings.activation_home_stats'))
	<div class="page-info page-info-lite rounded">
		<div class="text-center section-promo">
			<div class="row">

				<div class="col-sm-3 col-xs-6 col-xxs-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="icon icon-docs"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5><span>{{ $count_ads }}</span></h5>
								<div class="iconbox-wrap-text">{{ t('Free ads') }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-3 col-xs-6 col-xxs-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="icon icon-group"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5><span>{{ $count_users }}</span></h5>
								<div class="iconbox-wrap-text">{{ t('Trusted Seller') }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-3 col-xs-6  col-xxs-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="icon icon-map"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5><span>{{ $count_cities . '+' }}</span></h5>
								<div class="iconbox-wrap-text">{{ t('Locations') }}</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-3 col-xs-6 col-xxs-12">
					<div class="iconbox-wrap">
						<div class="iconbox">
							<div class="iconbox-wrap-icon">
								<i class="icon icon-facebook"></i>
							</div>
							<div class="iconbox-wrap-content">
								<h5><span>{{ $count_facebook_fans }}</span></h5>
								<div class="iconbox-wrap-text">{{ t('Facebook Fans') }}</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

	<?php
	/*
	<div class="page-bottom-info rounded-bottom">
		<div class="page-bottom-info-inner" style="padding: 20px;">

			<div class="page-bottom-info-content text-center">
				<h1>If you have any questions, comments or concerns, please call the Classified Advertising department at {{ config('settings.app_phone_number') }}</h1>
				<a class="btn  btn-lg btn-primary-dark" href="tel:{{ config('settings.app_phone_number') }}">
				<i class="icon-mobile"></i> <span class="hide-xs color50">Call Now:</span> {{ config('settings.app_phone_number') }} </a>
			</div>

		</div>
	</div>
	*/
	?>
@endif
