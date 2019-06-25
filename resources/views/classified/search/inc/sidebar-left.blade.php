<div class="col-sm-3 page-sidebar mobile-filter-sidebar" style="padding-bottom: 20px;">
	<aside>
		<div class="inner-box">

			@if(isset($cat))
				<?php $parent_id = ($cat->parent_id == 0) ? $cat->tid : $cat->parent_id; ?>
				<div id="sub_cat_list" class="categories-list list-filter">
					<h5 class="list-title"><strong><a href="#"><i class="fa fa-angle-left"></i> {{ t('Others Categories') }}</a></strong></h5>
					<ul class="list-unstyled">
						<li>
							<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$cats->get($parent_id)->slug) }}"
							   title="{{ $cats->get($parent_id)->name }}">
                    			<span class="title"><strong>{{ $cats->get($parent_id)->name }}</strong>
                    			</span><span class="count">&nbsp;{{ $count_cat_ads->get($parent_id)->total or 0 }}</span>
							</a>
							<ul class="list-unstyled long-list">
								@foreach ($cats->groupBy('parent_id')->get($parent_id) as $sub_cat)
									<li>
										@if(Request::segment(5) == $sub_cat->slug)
											<strong>
												<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$cats->get($sub_cat->parent_id)->slug.'/'.$sub_cat->slug) }}"
												   title="{{ $sub_cat->name }}">
													{{ str_limit($sub_cat->name, 100) }} <span
															class="count">({{ $count_sub_cat_ads->get($sub_cat->id)->total or 0 }})</span>
												</a>
											</strong>
										@else
											<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$cats->get($sub_cat->parent_id)->slug.'/'.$sub_cat->slug) }}"
											   title="{{ $sub_cat->name }}">
												{{ str_limit($sub_cat->name, 100) }} <span
														class="count">({{ $count_sub_cat_ads->get($sub_cat->id)->total or 0 }})</span>
											</a>
										@endif
									</li>
								@endforeach
							</ul>
						</li>
					</ul>
				</div>
				<?php $style = 'style="display: none;"'; ?>
			@endif

			<div id="cat_list" class="categories-list list-filter" <?php echo (isset($style)) ? $style : ''; ?>>
				<h5 class="list-title"><strong><a href="#">{{ t('All Categories') }}</a></strong></h5>
				<ul class=" list-unstyled">
					@foreach ($cats->groupBy('parent_id')->get(0) as $cat)
						<li>
							@if (Request::segment(4) == $cat->slug)
								<strong>
									<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$cat->slug) }}"
									   title="{{ $cat->name }}">
										<span class="title">{{ $cat->name }}</span>
										<span class="count">&nbsp;{{ $count_cat_ads->get($cat->id)->total or 0 }}</span>
									</a>
								</strong>
							@else
								<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.slugify($country->get('name')).'/'.$cat->slug) }}"
								   title="{{ $cat->name }}">
									<span class="title">{{ $cat->name }}</span>
									<span class="count">&nbsp;{{ $count_cat_ads->get($cat->id)->total or 0 }}</span>
								</a>
							@endif
						</li>
					@endforeach
				</ul>
			</div>

			<div class="locations-list list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Locations') }}</a></strong></h5>
				<ul class="browse-list list-unstyled long-list">
					@foreach ($cities as $city)
						@if (Request::segment(4) == rawurlencode($city->name))
							<li>
								<strong>
									<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.trans('routes.t-search-location').'/'.rawurlencode($city->name)) }}"
									   title="{{ $city->name }}">
										{{ $city->name }}
									</a>
								</strong>
							</li>
						@else
							<li>
								<a href="{{ url($lang->get('abbr').'/'.$country->get('icode').'/'.trans('routes.t-search-location').'/' . rawurlencode($city->name)) }}"
								   title="{{ $city->name }}">
									{{ $city->name }}
								</a>
							</li>
						@endif
					@endforeach
				</ul>
			</div>

			<div class="locations-list list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Price range') }}</a></strong></h5>
				<form role="form" class="form-inline" action="{{ Request::url() }}" method="GET">
					@foreach(Request::except(['minPrice', 'maxPrice', '_token']) as $key => $value)
						<input type="hidden" name="{{ $key }}" value="{{ $value }}">
					@endforeach
					{!! csrf_field() !!}
					<div class="form-group col-sm-4 no-padding">
						<input type="text" placeholder="2000" id="minPrice" name="minPrice" class="form-control"
							   value="{{ Request::get('minPrice') }}">
					</div>
					<div class="form-group col-sm-1 no-padding text-center"> -</div>
					<div class="form-group col-sm-4 no-padding">
						<input type="text" placeholder="3000" id="maxPrice" name="maxPrice" class="form-control"
							   value="{{ Request::get('maxPrice') }}">
					</div>
					<div class="form-group col-sm-3 no-padding">
						<button class="btn btn-default pull-right" type="submit">GO</button>
					</div>
				</form>
				<div style="clear:both"></div>
			</div>

			<div class="locations-list list-filter">
				<h5 class="list-title"><strong><a href="#">{{ t('Condition') }}</a></strong></h5>
				<ul class="browse-list list-unstyled long-list">
					<li><a href="{!! qsurl(Request::url(), array_merge(Request::except('page'), ['new'=>'1'])) !!}">{{ t('New') }} <span
									class="count"></span></a></li>
					<li><a href="{!! qsurl(Request::url(), array_merge(Request::except('page'), ['new'=>'0'])) !!}">{{ t('Used') }} <span
									class="count"></span></a></li>
					<li><a href="{!! qsurl(Request::url(), array_merge(Request::except('page'), ['new'=>''])) !!}">{{ t('None') }} </a></li>
				</ul>
			</div>

			<div style="clear:both"></div>
		</div>
	</aside>

</div>