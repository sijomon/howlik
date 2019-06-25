<?php
// Fix: 404 error page don't know language and country objects.
$searchUrl = '/';
if (isset($lang) and isset($country)) {
	$searchUrl = url($lang->get('abbr') . '/' . $country->get('icode') . '/' . trans('routes.t-search'));
}
?>
<div class="container">
	<div class="intro rounded-bottom">
		<div class="dtable hw100">
			<div class="dtable-cell hw100">
				<div class="container text-center" style="padding: 0 5px;">
					<?php
					/*
                    <p class="sub animateme fittext3 animated fadeIn">
                        {!! t('Sell and Buy products and services on :app_name in Minutes', ['app_name' => ucfirst(getDomain())]) !!}
                    </p>
					*/
					?>
					<div class="row search-row animated fadeInUp">
						<form id="seach" name="search" action="{{ $searchUrl }}" method="GET">

							<div class="col-lg-5 col-sm-5 search-col relative">
								<i class="icon-docs icon-append"></i>
								<input type="text" name="q" class="form-control has-icon" placeholder="{{ t('What?') }}" value="">
							</div>
							<div class="col-lg-5 col-sm-5 search-col relative locationicon">
								<i class="icon-location-2 icon-append"></i>
								<input type="hidden" id="l_search" name="l" value="">
								<input type="text" id="loc_search" name="location" class="form-control locinput input-rel searchtag-input has-icon"
									   placeholder="{{ t('Where?') }}" value="">
							</div>
							<div class="col-lg-2 col-sm-2 search-col">
								<button class="btn btn-success btn-search btn-block"><i class="icon-search"></i><strong>{{ t('Find') }}</strong>
								</button>
							</div>
							{!! csrf_field() !!}
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>