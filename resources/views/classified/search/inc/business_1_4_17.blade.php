@if ($biz->getCollection()->count() > 0)
<?php
	
	foreach($biz->getCollection() as $key => $bus):
	if (!$countries->has($bus->country_code)) continue;

	// Ads URL setting
	$bizUrl = lurl(slugify($bus->title) . '/' . $bus->id . '.html');
	?>
<div class="item-list"> @if ($bus->p_pack_id==2)
  <div class="cornerRibbons urgentAds"><a href="#"> {{ t('Urgent') }}</a></div>
  @endif
  @if ($bus->p_pack_id==3)
  <div class="cornerRibbons topAds"><a href="#"> {{ t('Top Ads') }}</a></div>
  @endif
  @if ($bus->p_pack_id==4)
  <div class="cornerRibbons featuredAds"><a href="#"> {{ t('Featured Ads') }}</a></div>
  @endif
  <?php
		// Picture setting
		$bizImg = '';
		$pictures = \App\Larapen\Models\Picture::where('ad_id', $bus->id);
		$countPictures = $pictures->count();
		if ($countPictures > 0) {
			if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename)) {
				$bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
			}
			if ($bizImg=='') {
				if (is_file(public_path() . '/'. $pictures->first()->filename)) {
					$bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename);
				}
			}
		}
		// Default picture
		if ($bizImg=='') {
			$bizImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture'));
		}
		?>
  <div class="col-sm-2 no-padding photobox">
    <div class="add-image"> <span class="photo-count"><i class="fa fa-camera"></i> {{ $countPictures }} </span> <a href="{{ $bizUrl }}"> <img class="thumbnail no-margin" src="{{ $bizImg }}" alt="img" data-no-retina/> </a> </div>
  </div>
  <div class="col-sm-7 add-desc-box">
    <div class="add-details">
      <h5 class="add-title"><a href="{{ $bizUrl }}">{{ mb_ucfirst($bus->title) }} </a></h5>
      <span class="info-row"> <span class="add-type business-ads tooltipHere rty" data-toggle="tooltip" data-placement="right"
						  title=""> </span>&nbsp;
      <?php
					// Convert the created_at date to Carbon object
					$bus->created_at = \Carbon\Carbon::parse($bus->created_at)->timezone(session('time_zone'));
					$bus->created_at = time_ago($bus->created_at, session('time_zone'), session('language_code'));

					// Category
					$liveCat = \App\Larapen\Models\Category::find($bus->category_id);
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
      <span class="date_libu ner"><i class=" icon-clock"> </i> {{ $bus->created_at }} </span> @if (isset($cats) and !$cats->isEmpty())
      - <span class="category cate_00"> <a
href="{!! qsurl($country->get('icode').'/'.trans('routes.t-search'), array_merge(Request::except('c'), ['c'=>$liveCatParentId])) !!}"
									class="info-link">{{ $liveCatName }}</a> </span> @endif
      - <span class="item-location locat_11"><i class="fa fa-map-marker"></i>&nbsp; <a href="{!! qsurl($country->get('icode').'/'.trans('routes.t-search'), array_merge(Request::except(['l', 'location']), ['l'=>$bus->city_id])) !!}"
 class="info-link">{{ \App\Larapen\Models\City::find($bus->city_id)->name }}</a> {{ (isset($bus->distance)) ? '- ' . round($bus->distance, 2) . 'km' : '' }} </span> </span> </div>
  </div>
  <div class="col-sm-3 text-right price-box">
    <h4 class="item-price">  </h4>
    @if ($bus->p_pack_id==3) <a class="btn btn-danger btn-sm make-favorite"><i class="fa fa-certificate"></i><span> {{ t('Top Ads') }} </span></a>&nbsp;
    @endif
    @if ($bus->p_pack_id==4) <a class="btn btn-danger btn-sm make-favorite"><i class="fa fa-certificate"></i><span> {{ t('Featured Ads') }} </span></a>&nbsp;
    @endif
    @if (Auth::check()) 
    <!--<a class="btn btn-{{ (\App\Larapen\Models\SavedAd::where('user_id', $user->id)->where('ad_id', $bus->id)->count() > 0) ? 'success' : 'default' }} btn-sm make-favorite"
				   id="{{ $bus->id }}">
					<i class="fa fa-heart"></i><span> {{ t('Save') }} </span>
				</a>--> 
    @else 
    <!--<a class="btn btn-default btn-sm make-favorite" id="{{ $bus->id }}"><i class="fa fa-heart"></i><span> {{ t('Save') }} </span></a>--> 
    @endif </div>
</div>
<?php endforeach; ?>
@else
<div class="item-list"> {{ t('No result. Refine your search using other criteria.') }} </div>
@endif 