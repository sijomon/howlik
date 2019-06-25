<div class="col-lg-12 content-box">
	<div class="row row-featured row-featured-category">
		<div class="col-lg-12 box-title no-border">
			<div class="inner">
				<h2>
					<span class="title-3" style="font-weight: bold;"><span>{{ t('Browse by') }}</span> {{ t('Category') }}</span>
					<a href="{{ url('/' . $lang->get('abbr') . '/' . trans('routes.v-sitemap', ['country_code' => $country->get('icode')])) }}"
					   class="sell-your-item">
						{{ t('View more') }} <i class="icon-th-list"></i>
					</a>
				</h2>
			</div>
		</div>

		@if (!$cats->isEmpty())
			@foreach($cats as $key => $cat)
				<?php
				$cat->picture = last(explode('/', $cat->picture));
				$theme = config('app.theme') ? config('app.theme') : 'default';
				$catPicFilename = 'uploads/app/categories/' . $theme . '/' . $cat->picture;
				if (!is_file(public_path($catPicFilename))) {
					$catPicFilename = 'images/cats/fa-folder_' . $theme . '.png';
					if (!is_file(public_path($catPicFilename))) {
						$catPicFilename = 'images/cats/fa-folder_default.png';
					}
				}
				?>
				<div class="col-lg-2 col-md-3 col-sm-3 col-xs-4 f-category">
					<a href="{{ url('/' . $lang->get('abbr') . '/' . $country->get('icode') . '/' . slugify($country->get('name')) . '/' . $cat->slug) }}">
						<img src="{{ url($catPicFilename) }}" class="img-responsive" alt="img" data-no-retina>
						<h6> {{ $cat->name }} </h6>
					</a>
				</div>
			@endforeach
		@endif

	</div>
</div>

<div style="clear: both"></div>
