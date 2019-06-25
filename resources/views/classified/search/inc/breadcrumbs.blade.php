<?php
/**
 * TITLE BREADCRUMBS
 */
$tabTitle = [];
//if (Request::has('l') or Request::segment(3) == trans('routes.t-search-location') or Request::has('r'))
if (isset($city)) {
	$title = t('in :distance km around :city', [
			'distance' => \App\Larapen\Helpers\Search::$distance,
			'city'     => $city->name
	]);
	$tabTitle[] = [
			'name'     => (isset($cat) ? t('All ads') . ' ' . $title : $city->name),
			'url'      => url($lang->get('abbr') . '/' . $country->get('icode') . '/' . str_slug(trans('routes.t-search-location')) . '/' . rawurlencode($city->name)),
			'position' => (isset($cat) ? 5 : 3),
			'location' => true
	];
}
//if (Request::has('c') or Request::segment(3) == slugify($country->get('name')))
if (isset($cat)) {
	if (isset($cat)) {
		if (isset($sub_cat)) {
			$title = t('in :category', ['category' => $sub_cat->name]);
			$tabTitle[] = [
					'name'     => $cat->name,
					'url'      => url($lang->get('abbr') . '/' . $country->get('icode') . '/' . slugify($country->get('name')) . '/' . $cat->slug),
					'position' => 3
			];
			$tabTitle[] = [
					'name'     => (isset($city) ? $sub_cat->name : t('All ads') . ' ' . $title),
					'url'      => url($lang->get('abbr') . '/' . $country->get('icode') . '/' . slugify($country->get('name')) . '/' . $cat->slug . '/' . $sub_cat->slug),
					'position' => 4
			];
		} else {
			$title = t('in :category', ['category' => $cat->name]);
			$tabTitle[] = [
					'name'     => (isset($city) ? $cat->name : t('All ads') . ' ' . $title),
					'url'      => url($lang->get('abbr') . '/' . $country->get('icode') . '/' . slugify($country->get('name')) . '/' . $cat->slug),
					'position' => 3
			];
		}
	}
}
$tabTitle = array_values(array_sort($tabTitle, function ($value) {
	return $value['position'];
}));
?>
<div class="container">
	<div class="breadcrumbs">
		<ol class="breadcrumb pull-left">
			<li><a href="{{ lurl('/') }}"><i class="icon-home fa"></i></a></li>
			<li>
				<a href="{{ url('/' . $lang->get('abbr') . '/' . $country->get('icode') . '/' . trans('routes.t-search')) }}">
					{{ $country->get('name') }}
				</a>
			</li>
			@if (isset($tabTitle) and count($tabTitle) > 0)
				<?php $pos = 3; ?>
				@foreach($tabTitle as $key => $value)
					<?php
					$value = collect($value);
					?>
					@if ($value->get('position') > count($tabTitle)+1)
						<li class="active">
							{!! $value->get('name') !!}
							&nbsp;
							@if (isset($city) and $value->has('location'))
								<a href="#selectRegion" id="dropdownMenu1" data-toggle="modal"> <span class="caret"></span> </a>
							@endif
						</li>
					@else
						<li><a href="{{ $value->get('url') }}">{!! $value->get('name') !!}</a></li>
					@endif
				@endforeach
			@endif
		</ol>
	</div>
</div>