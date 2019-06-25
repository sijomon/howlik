@if ($ads->getCollection()->count() > 0)
	<?php
	foreach($ads->getCollection() as $key => $ad):
	if (!$countries->has($ad->country_code)) continue;

	// Ads URL setting
	$adUrl = lurl(slugify($ad->title) . '/' . $ad->id . '.html');
	?>
	<div class="item-list">
		@if ($ad->p_pack_id==2)
			<div class="cornerRibbons urgentAds"><a href="#"> {{ t('Urgent') }}</a></div>
		@endif
		@if ($ad->p_pack_id==3)
			<div class="cornerRibbons topAds"><a href="#"> {{ t('Top Ads') }}</a></div>
		@endif
		@if ($ad->p_pack_id==4)
			<div class="cornerRibbons featuredAds"><a href="#"> {{ t('Featured Ads') }}</a></div>
		@endif

		<?php
		// Picture setting
		$adImg = '';
		$pictures = \App\Larapen\Models\Picture::where('ad_id', $ad->id);
		$countPictures = $pictures->count();
		if ($countPictures > 0) {
			if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename)) {
				$adImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
			}
			if ($adImg=='') {
				if (is_file(public_path() . '/'. $pictures->first()->filename)) {
					$adImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
				}
			}
		}
		// Default picture
		if ($adImg=='') {
			$adImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture'));
		}
		?>
		<div class="col-sm-2 no-padding photobox">
			<div class="add-image">
				<span class="photo-count"><i class="fa fa-camera"></i> {{ $countPictures }} </span>
				<a href="{{ $adUrl }}">
					<img class="thumbnail no-margin" src="{{ $adImg }}" alt="img" data-no-retina/>
				</a>
			</div>
		</div>

		<div class="col-sm-7 add-desc-box">
			<div class="add-details">
				<h5 class="add-title"><a href="{{ $adUrl }}">{{ mb_ucfirst($ad->title) }} </a></h5>
				<span class="info-row">
					<span class="add-type business-ads tooltipHere" data-toggle="tooltip" data-placement="right"
						  title="{{ ($ad->ad_type_id==2) ? t('Business Ads') : t('Private Ads') }}">{{ ($ad->ad_type_id==2) ? t('B') : t('P') }} </span>&nbsp;
					<?php
					// Convert the created_at date to Carbon object
					$ad->created_at = \Carbon\Carbon::parse($ad->created_at)->timezone(session('time_zone'));
					$ad->created_at = time_ago($ad->created_at, session('time_zone'), session('language_code'));

					// Category
					$liveCat = \App\Larapen\Models\Category::find($ad->category_id);
						// Check parent
						if (empty($liveCat->parent_id)) {
							$liveCatParentId = $liveCat->id;
						} else {
							$liveCatParentId = $liveCat->parent_id;
						}
						// Check translation
						if ($cats->has($liveCatParentId)) {
							$liveCatName = $cats->get($liveCatParentId)->name;
						} else {
							$liveCatName = $liveCat->name;
						}
					?>
					<span class="date"><i class=" icon-clock"> </i> {{ $ad->created_at }} </span>
					@if (isset($cats) and !$cats->isEmpty())
						- <span class="category"> <a
									href="{!! qsurl($country->get('icode').'/'.trans('routes.t-search'), array_merge(Request::except('c'), ['c'=>$liveCatParentId])) !!}"
									class="info-link">{{ $liveCatName }}</a> </span>
					@endif
					- <span class="item-location"><i class="fa fa-map-marker"></i>&nbsp;
						<a href="{!! qsurl($country->get('icode').'/'.trans('routes.t-search'), array_merge(Request::except(['l', 'location']), ['l'=>$ad->city_id])) !!}"
						   class="info-link">{{ \App\Larapen\Models\City::find($ad->city_id)->name }}</a> {{ (isset($ad->distance)) ? '- ' . round($ad->distance, 2) . 'km' : '' }}
					  </span>
				</span>
			</div>
		</div>

		<div class="col-sm-3 text-right price-box">
			<h4 class="item-price">
				@if ($ad->price > 0)
					@if ($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
					{{ \App\Larapen\Helpers\Number::short($ad->price) }}
					@if ($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
				@else
					@if ($country->get('currency')->in_left == 1){{ $country->get('currency')->symbol }}@endif
					{{ '--' }}
					@if ($country->get('currency')->in_left == 0){{ $country->get('currency')->symbol }}@endif
				@endif
			</h4>
			@if ($ad->p_pack_id==3)
				<a class="btn btn-danger btn-sm make-favorite"><i class="fa fa-certificate"></i><span> {{ t('Top Ads') }} </span></a>&nbsp;
			@endif
			@if ($ad->p_pack_id==4)
				<a class="btn btn-danger btn-sm make-favorite"><i class="fa fa-certificate"></i><span> {{ t('Featured Ads') }} </span></a>&nbsp;
			@endif
			@if (Auth::check())
				<a class="btn btn-{{ (\App\Larapen\Models\SavedAd::where('user_id', $user->id)->where('ad_id', $ad->id)->count() > 0) ? 'success' : 'default' }} btn-sm make-favorite"
				   id="{{ $ad->id }}">
					<i class="fa fa-heart"></i><span> {{ t('Save') }} </span>
				</a>
			@else
				<a class="btn btn-default btn-sm make-favorite" id="{{ $ad->id }}"><i class="fa fa-heart"></i><span> {{ t('Save') }} </span></a>
			@endif
		</div>
	</div>
	<?php endforeach; ?>
@else
	<div class="item-list">
		{{ t('No result. Refine your search using other criteria.') }}
	</div>
@endif
