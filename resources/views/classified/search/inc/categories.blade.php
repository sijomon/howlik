<?php
$cats = $sub_cats = $cats->groupBy('parent_id');
$cats = $cats->get(0);
$sub_cats = $sub_cats->forget(0);
?>
<div class="container">
	<div class="category-links">
		<ul>
			@if (!isset($cat))
				@if (isset($cats) and !is_null($cats))
					@foreach ($cats as $categorie)
						<li>
							<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$categorie->slug) }}">
								{{ $categorie->name }}
							</a>
							<!--<span class="badge">{{-- $count_cat_ads->get($categorie->id)->total or 0 --}}</span>-->
						</li>
					@endforeach
				@endif
			@else
				@if (isset($sub_cats) and $sub_cats->has($cat->id))
					@foreach ($sub_cats->get($cat->id) as $sub_cat)
						<li>
							<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$cat->slug.'/'.$sub_cat->slug) }}">
								{{ $sub_cat->name }}
							</a>
							<!--<span class="badge">{{-- $count_sub_cat_ads->get($sub_cat->id)->total or 0 --}}</span>-->
						</li>
					@endforeach
				@endif
			@endif
		</ul>
	</div>
</div>