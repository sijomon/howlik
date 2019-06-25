@if(Request::segment('2') != 'create' && Request::segment('3') != 'edit')
<style>
	.location-list-card {
		
		border:1px solid #ccc;
		margin-bottom:10px;
	}
	.location-list-card-title{
		padding:10px;
		background:#fff;
	}
	.location-list-card-content{
		padding:10px
	}
	.location-list-card-content ul{
		list-style-type:none;
	}
	.location-list-card-content ul li{
		margin:10px 10px 0;
	}
	.form-control {
		
		margin-top: 5px;
		display: inline;
	}
	.location-left-box {
		
		width: 40%;
		float: left;
	}
	.location-right-box {
		
		width: 60%;
		float: left;
	}
	.modal-label{
		display: block !important; 
		float: left !important; 
		width: 100% !important; 
		text-align: left !important;
	}
	#location-percent-error {
		float: left !important; 
		width: 100% !important; 
		text-align: left !important;
		color: red; 
		margin-top: 5px;
	}
	.map_canvas {
		margin: 0;
		padding: 0;
		height: 100%
	}
</style>
<div class="info"></br>

	<label>{{ $field['label'] }}</label></br></br>
	
	{{--*/ 	$biz_id		=	''; /*--}}
	@if(isset($field['value']) && $field['value']!='')
		{{--*/ 	$biz_id		=	$field['value']; /*--}}
	@endif	
	{{--*/ 
	
		$locations	= 	\DB::table('businessLocations')
						->select('businessLocations.*', 'business.title as title', 'cities.name as ciname', 'cities.asciiname as ciasciiname', 'subadmin1.name as loname', 'subadmin1.asciiname as loasciiname', 'countries.name as coname', 'countries.asciiname as coasciiname')
						->leftjoin('business', 'businessLocations.biz_id', '=', 'business.id')
						->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
						->leftjoin('subadmin1', 'businessLocations.location_id', '=', 'subadmin1.code')
						->leftjoin('countries', 'businessLocations.country_id', '=', 'countries.code')
						->where('businessLocations.biz_id', $biz_id)
						->where('businessLocations.base', 0)
						->orderBy('created_at', 'asc')
						->get(); 
	/*--}}	
	
	{{--*/ $countries = \DB::table('countries')->where('active', 1)->orderBy('asciiname')->lists('asciiname', 'code'); /*--}}	
	
	@if(!empty($locations))
		<div class="row">
			@foreach($locations as $loc)
				@if($loc->base == 0)
					<div class="col-md-6"  id="loc-{{$loc->id}}">
						<div class="location-list-card">
							<div class="location-list-card-title">
								<span class="pull-right itemoffer">
									<a id="edit-location-{{ $loc->id }}" class="btn btn-xs btn-default" onClick="return editLocation({{ $loc->id }});" data-toggle="modal" data-target="#editLocationModal-{{ $loc->id }}"><i class="fa fa-edit"></i></a>
									<a id="drop-location-{{ $loc->id }}" class="btn btn-xs btn-danger" onClick="return dropLocation({{ $loc->id }});"><i class="fa fa-trash"></i></a>
								</span>
								<span> <strong><i class="fa fa-map-marker"></i> &nbsp; {{ $loc->ciasciiname }}, &nbsp;{{ $loc->coasciiname }} </strong> </span>
							</div>
							
							<div class="location-list-card-content">
								<span class="text-muted">  {{ str_limit($loc->address_1, 40) }} </span><br>
								<span class="text-muted"><i class="fa fa-phone"></i>  &nbsp;{{ $loc->phone }} </span>
							</div> 
						</div>
					</div>
				@endif
			@endforeach
			<div class="location-list-ajax"></div>
		</div>
		<div style="width:100%; float:left;">  <a id="more-location" class="btn btn-primary btn-sm" onClick="return postLocation();"  data-toggle="modal" data-target="#postLocationModal"><span class="fa fa-plus"></span> @lang('global.Add More Locations') </a> </div>
	@else
		<div class="row">
			<div class="location-list-ajax"></div>
		</div>
		<div style="width:100%; float:left;"> <a id="more-offer" class="btn btn-primary btn-sm" onClick="return postLocation();" data-toggle="modal" data-target="#postLocationModal"><span class="fa fa-plus"></span> @lang('global.Add Locations') </a> </div></br>
	@endif
</div>	


<!-- BOF CREATE MODAL -->
<div class="modal fade location-modals" id="postLocationModal" tabindex="-1" role="dialog" aria-labelledby="moreModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" id="moreModalLabel"> Create a New Location </h3>
				<span id="currency" style="display: none"> </span>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" id="success-alert-loc" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Created!') </strong>
				</div>
				<div class="alert alert-danger" id="danger-alert-loc" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Error!') </strong>
				</div>
				<div class="col-sm-12">
					<form class="form-horizontal" id="create-location-loc" method="POST" action="">
						{!! csrf_field() !!}
						<fieldset>
							
							<input type="hidden" id="biz_id" value="{{ $biz_id }}" />
							
							<!-- Address 1 -->
							<div class="form-group required">
								<label class="col-md-3 control-label" for="title">{{ t('Address 1') }} <sup>*</sup></label>
								<div class="col-md-8">
									<input id="address1z" name="address1" class="form-control input-md" type="text" value="">
								</div>
							</div>
							
							<!-- Address 2 -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="title">{{ t('Address 2') }}</label>
								<div class="col-md-8">
									<input id="address2z" name="address2" class="form-control input-md" type="text" value="">
								</div>
							</div>
							
							<!-- Zipcode -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="title">{{ t('Zip code') }}</label>
								<div class="col-md-8">
									<input id="zipz" name="zip" class="form-control input-md" type="text" value="">
								</div>
							</div>
							
							<!-- Phone Number -->
							<div class="form-group required">
								<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }} <sup>*</sup></label>
								<div class="col-md-8">
									<!-- <div class="input-group">
										<span id="phone_country" class="input-group-addon"><i class="icon-phone-1"></i></span>
									</div> -->
									<input id="phonez" name="phone"  placeholder="{{ t('Phone Number (in local format)') }}" class="form-control" type="text" value="" />
								</div>
							</div>
							
							<!-- Country -->
							<div class="form-group required">
								<label class="col-md-3 control-label" for="country">{{ t('Country') }} <sup>*</sup></label>
								<div class="col-md-8">
									<select id="countryz" name="country" class="form-control sselecter" onchange="return get_locationx($(this).val());">
										<!-- <option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}>
										 {{ t('Select your Country') }} 
										</option> -->
										@foreach($countries as $key => $val)
											<option value="{{$key}}">{{$val}}</option>
										@endforeach
									</select>
								</div>
							</div>
							
							<!-- Location -->
							<div class="form-group required">
								<label class="col-md-3 control-label">{{ t('Location') }} <sup>*</sup></label>
								<div class="col-md-8">
									<select id="locationz" name="location" class="form-control sselecter" onchange="return get_cityx($(this).val());">
										<option> {{ t('Location') }} </option>
									</select>
								</div>
							</div>
							
							<!-- City -->
							<div class="form-group required">
								<label class="col-md-3 control-label">{{ t('City') }} <sup>*</sup></label>
								<div class="col-md-8">
									<select id="cityz" name="city" class="form-control sselecter" onchange="return get_mapx();">
										<option> {{ t('City') }} </option>
									</select>
								</div>
							</div>
							
							<!-- Map -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="title"></label>
								<div class="col-md-8">
									<div style="display: block;">
										<label class="control-label" for="lat1z"> {{ t('Lat') }}</label>
										<input id="lat1z" name="lat" style="width:40%;" class="form-control input-md" value="" readonly />
										<label class="control-label" for="lon1z"> {{ t('Long') }}</label>
										<input id="lon1z" name="lon" style="width:40%;" class="form-control input-md" value="" readonly />
										<br />
									</div>
									<a href="#" onClick="return auto_locatex();" style="float:right;"> {{ t('Auto Locate')}} </a>
									<div class="map_canvas" id="map_canvasz" style="width: 100%; height: 250px;"></div>
								</div>
							</div>

						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ t('Cancel') }}</button>
				<button type="button" class="btn btn-primary" id="loc-submit-post">{{ t('Create') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- EOF CREATE MODAL -->

@if(!empty($locations))
@foreach($locations as $loc)
<!-- BOF UPDATE MODAL -->
<div class="modal fade location-modals" id="editLocationModal-{{ $loc->id }}" tabindex="-1" role="dialog" aria-labelledby="moreModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h3 class="modal-title" id="moreModalLabel"> @lang('global.Update the Location of') {{ $loc->title }}</h3>
				<span id="currency" style="display: none"> </span>
			</div>
			<div class="modal-body">
				<div class="alert alert-success" id="success-alert-loc-up" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Created!') </strong>
				</div>
				<div class="alert alert-danger" id="danger-alert-loc-up" style="display: none">
					<button type="button" class="close" data-dismiss="alert">x</button>
					<strong> @lang('global.Error!') </strong>
				</div>
				<div class="col-sm-12">
					<form class="form-horizontal" id="create-location" method="POST" action="">
						{!! csrf_field() !!}
						<fieldset>
						
							<!-- Address 1 -->
							<div class="form-group required">
								<label class="col-md-3 control-label" for="title">{{ t('Address 1') }} <sup>*</sup></label>
								<div class="col-md-8">
									<input id="address1z-{{ $loc->id }}" name="address1" class="form-control input-md" type="text" value="{{ $loc->address_1 }}">
								</div>
							</div>
							
							<!-- Address 2 -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="title">{{ t('Address 2') }}</label>
								<div class="col-md-8">
									<input id="address2z-{{ $loc->id }}" name="address2" class="form-control input-md" type="text" value="{{ $loc->address_2 }}">
								</div>
							</div>
							
							<!-- Zipcode -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="title">{{ t('Zip code') }}</label>
								<div class="col-md-8">
									<input id="zipz-{{ $loc->id }}" name="zip" class="form-control input-md" type="text" value="{{ $loc->zip_code }}">
								</div>
							</div>
							
							<!-- Phone Number -->
							<div class="form-group required">
								<label class="col-md-3 control-label" for="seller_phone">{{ t('Phone Number') }} <sup>*</sup></label>
								<div class="col-md-8">
									<!-- <div class="input-group">
										<span id="phone_country" class="input-group-addon"><i class="icon-phone-1"></i></span>
									</div> -->
									<input id="phonez-{{ $loc->id }}" name="phone"  placeholder="{{ t('Phone Number (in local format)') }}" class="form-control" type="text" value="{{ $loc->phone }}" />
								</div>
							</div>
							
							<!-- Country -->
							<div class="form-group required">
								<label class="col-md-3 control-label" for="country">{{ t('Country') }} <sup>*</sup></label>
								<div class="col-md-8">
									<select id="countryz-{{ $loc->id }}" name="country_id" class="form-control sselecter" onchange="return get_locationz($(this).val(), {{ $loc->id }});">
										<!-- <option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}>
										 {{ t('Select your Country') }} 
										</option> -->
										@foreach($countries as $key => $val)
											{{--*/ $slct = ''; /*--}}
											@if($key == $loc->country_id)
												{{--*/ $slct = "selected=selected"; /*--}}
											@endif
											<option value="{{$key}}" {{ $slct }} >{{$val}}</option>
										@endforeach
									</select>
								</div>
							</div>
							
							<!-- Location -->
							<div class="form-group required">
								<label class="col-md-3 control-label">{{ t('Location') }} <sup>*</sup></label>
								<div class="col-md-8">
									<select id="locationz-{{ $loc->id }}" name="location_id" class="form-control sselecter" onchange="return get_cityz($(this).val(), {{ $loc->id }});"></select>
									<input type="hidden" id="locnow-{{ $loc->id }}" value="{{ $loc->location_id }}" />
								</div>
							</div>
							
							<!-- City -->
							<div class="form-group required">
								<label class="col-md-3 control-label">{{ t('City') }} <sup>*</sup></label>
								<div class="col-md-8">
									<select id="cityz-{{ $loc->id }}" name="city_id" class="form-control sselecter" onchange="return get_mapz({{ $loc->id }});"></select>
									<input type="hidden" id="citnow-{{ $loc->id }}" value="{{ $loc->city_id }}" />
								</div>
							</div>
							
							<!-- Map -->
							<div class="form-group">
								<label class="col-md-3 control-label" for="title"></label>
								<div class="col-md-8">
									<div style="display: block;">
										<label class="control-label" for="lat1z"> {{ t('Lat') }}</label>
										<input id="lat1z-{{ $loc->id }}" name="lat1" style="width:40%;" class="form-control input-md" value="{{ $loc->lat }}" readonly />
										<label class="control-label" for="lon1z"> {{ t('Long') }}</label>
										<input id="lon1z-{{ $loc->id }}" name="lon1" style="width:40%;" class="form-control input-md" value="{{ $loc->lon }}" readonly />
										<br />
									</div>
									<a href="#" onClick="return auto_locatez({{ $loc->id }});" style="float:right;"> {{ t('Auto Locate')}} </a>
									<div class="map_canvas" id="map_canvasz-{{ $loc->id }}" style="width: 100%; height: 250px;"></div>
								</div>
							</div>
							<span id="id-now" style="display: none"></span>
						</fieldset>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="button-cancel">{{ t('Cancel') }}</button>
				<button type="button" class="btn btn-primary" id="more-submit" onClick="return updateLocationForm({{$loc->id}});">{{ t('Update') }}</button>
			</div>
		</div>
	</div>
</div>
<!-- EOF UPDATE MODAL -->
@endforeach
@endif
@endif
