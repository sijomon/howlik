@extends('classified.layouts.layout')

@section('javascript-top')
	@parent
@endsection

@section('content')
<style>
	.no-margin-table{
		margin-bottom:0 !important;
		border-bottom:1px solid #f6f6f6;
	}
	.biz-hours{
		overflow:hidden;
	}
	.biz-hours-box{
		overflow:hidden;
		margin-bottom:5px;
	}
	.biz-hours-select{
		float:left;
		list-style:none;
		padding-left:0;
	}
	.biz-hours-select li{
		float:left;
		margin-right:3px;
	}
	.biz-hours-select select{
		padding:7px 4px;
	}
</style>
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (count($errors) > 0)
					<div class="col-lg-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<?php  if ($user->user_type_id  == 3) { ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--/.page-sidebar-->

				<div class="col-md-9 page-content">
					<div class="inner-box category-content">
						<h2 class="title-2"><strong> <i class="icon-docs"></i> {{ t('Edit Business Additional Informations') }}</strong></h2>
						<div class="row">
							<div class="col-sm-12">


								<form class="form-horizontal" id="updateExtraInformation" method="POST" action="{{ lurl('account/update-extra-information') }}">
									{!! csrf_field() !!}
									<fieldset>
										
										<input type="hidden" name="biz_id" id="biz_id" value="{{ $business->id }}">
										<!-- List of Additional Informations -->
										<div class="form-group required <?php echo ($errors->has('parent')) ? 'has-error' : ''; ?>" ></div>
											
											{{--*/ $more_infoA = unserialize($business->more_info); /*--}}
											
											@if(isset($informations))
											
												{{--*/ $i = '1' /*--}}
												@foreach ($informations as $info)
												
													<div class="col-md-6">
														<table class="table table-reponsive no-margin-table">
															
															<tr>
																<td style="width: 50%;"> {{ $info->info_title }} </td>
																<td style="width: 50%;"> 
																
																	{{--*/ $valuess = unserialize($info->info_vals); /*--}}
																	{{--*/ $count	= count($valuess) /*--}}
																
																	@if($info->info_type == 1)
																		
																		@if(isset($more_infoA[$info->translation_of]) && $more_infoA[$info->translation_of] != '')
																		
																			{{ Form::text('biz_info['.$info->translation_of.']', $more_infoA[$info->translation_of], array('class' => 'form-control','id' => 'text_box_'.$i,'placeholder' => $info->info_title )) }}
																		
																		@else	
																			
																			{{ Form::text('biz_info['.$info->translation_of.']', null, array('class' => 'form-control','id' => 'text_box_'.$i,'placeholder' => $info->info_title )) }}
																		
																		@endif
																		
																	@elseif($info->info_type == 2)
																		
																		@if($count>1)
																		
																			<select name="biz_info[{{$info->translation_of}}]" class="form-control" id="select_box_{{ $i }}" >

																				@if(isset($more_infoA[$info->translation_of]) && $more_infoA[$info->translation_of] != '')
																				
																					<option disabled="disabled"> - - select - - </option>
																					
																					@for($j = 0; $j < $count; $j++)
																					
																						<option <?php if($more_infoA[$info->translation_of] == $valuess[$j]) { echo 'selected=selected'; } ?> value="{{ $valuess[$j] }}"> {{ $valuess[$j] }} </option>
																						
																					@endfor
																					
																				@else
																				
																					<option selected="selected" disabled="disabled"> - - select - - </option>
																					
																					@for($j = 0; $j < $count; $j++)
																					
																						<option value="{{ $valuess[$j] }}"> {{ $valuess[$j] }} </option>
																						
																					@endfor
																					
																				@endif
																				
																			</select>
																			
																		@endif
																		
																	@elseif($info->info_type == 3)
																	
																		{{--*/ $yesV	= false; /*--}}
																		{{--*/ $noV		= true; /*--}}
																		
																		@if(isset($more_infoA[$info->translation_of]) && $more_infoA[$info->translation_of]==0)
																			{{--*/ $yesV	= true; /*--}}
																			{{--*/ $noV		= false; /*--}}
																		@endif
																		
																		<label>
																			
																			{{ Form::radio('biz_info['.$info->translation_of.']', 0, $yesV, ['id' => 'radio_'.$i]) }} &nbsp;&nbsp;&nbsp; Yes &nbsp;&nbsp;&nbsp;
																			
																			{{ Form::radio('biz_info['.$info->translation_of.']', 1, $noV, ['id' => 'radio_'.$i]) }} &nbsp;&nbsp;&nbsp; No
																		
																		</label>
																		
																	@endif
																	
																</td>
															</tr>
															
														</table>
													</div>
													
												{{--*/ $i ++ /*--}}	
												@endforeach
												
											@endif
											
										</div>

										<!-- Button  -->
										<div class="form-group">
											<div class="col-md-12 pull-right">
												<a href="{{lurl('account/bizinfo/'.$business->id)}}" class="btn btn-default btn-md"><span id="backBizBtn"> {{ t('Cancel') }} </span></a>
												<button id="updateBizBtn" class="btn btn-success btn-md"> {{ t('Update') }} </button>
											</div>
										</div>

									</fieldset>
								</form>


							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyCrX9ZJYwOfRbep-mEGjL4JoF_BAgnnUrM"></script>
	<script src="{{ url('/assets/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/js/fileinput_locale_'.$lang->get('abbr').'.js'))
		<script src="{{ url('/assets/js/fileinput_locale_'.$lang->get('abbr').'.js') }}" type="text/javascript"></script>
	@endif
	<script language="javascript">
		/* initialize with defaults (pictures) */
		$('.picimg').fileinput(
				{
					'showPreview': true,
					'allowedFileExtensions': ['jpg', 'gif', 'png'],
					'browseLabel': '{!! t("Browse") !!}',
					'showUpload': false,
					'showRemove': false,
					'maxFileSize': 1000
				});
		/* initialize with defaults (resume) */
		$('#resume').fileinput(
				{
					'showPreview': true,
					'allowedFileExtensions': ['pdf', 'doc', 'docx', 'odt', 'png', 'jpg'],
					'browseLabel': '{!! t("Browse") !!}',
					'showUpload': false,
					'showRemove': false,
					'maxFileSize': 1000
				});
	</script>
	<script language="javascript">
		var countries = <?php echo (isset($countries)) ? $countries->toJson() : '{}'; ?>;
		var countryCode = '<?php echo old('country', $business->country_code); ?>';
		var lang = {
			'select': {
				'category': "{{ t('Select a category') }}",
				'subCategory': "{{ t('Select a sub-category') }}",
				'country': "{{ t('Select a country') }}",
				'loc': "{{ t('Select a location') }}",
				'subLocation': "{{ t('Select a sub-location') }}",
				'city': "{{ t('Select a city') }}"
			}
		};
		var category = <?php echo old('parent', 0); ?>;
		var categoryType = '<?php echo old('parent_type'); ?>';
		if (categoryType=='') {
			var selectedCat = $('select[name=parent]').find('option:selected');
			categoryType = selectedCat.data('type');
		}
		var subCategory = <?php echo old('category', 0); ?>;
		var loc = '<?php echo old('location', $business->subadmin1_code); ?>';
		var subLocation = '<?php echo old('sub_location', 0); ?>';
		var city = '<?php echo old('city', $business->city_id); ?>';
		var hasChildren = '<?php echo old('has_children'); ?>';

		$(document).ready(function () {
			get_keywords();
			setBizHrs();
			initialize('{{$business->lat}}', '{{$business->lon}}');
		});
		
		var map;

		function initialize(lat, lon) {
			document.getElementById("lat1").value = lat;
			document.getElementById("lon1").value = lon;
			var myLatlng = new google.maps.LatLng(lat, lon);
	
			var myOptions = {
				zoom: 8,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
			var marker = new google.maps.Marker({
				draggable: true,
				position: myLatlng,
				map: map,
				title: "Your location"
			});
	
			google.maps.event.addListener(marker, 'dragend', function (event) {
				document.getElementById("lat1").value = event.latLng.lat();
				document.getElementById("lon1").value = event.latLng.lng();
			});
		}
		
		///////////////////////////////////////////////////////////
		function showResult(result) {
			var lat = result.geometry.location.lat();
			var lon = result.geometry.location.lng();
			initialize(lat, lon);
		}
		
		function getLatitudeLongitude(callback, address) {
			// If adress is not supplied, use default value 'Ferrol, Galicia, Spain'
			address = address || 'Ferrol, Galicia, Spain';
			// Initialize the Geocoder
			geocoder = new google.maps.Geocoder();
			if (geocoder) {
				geocoder.geocode({
					'address': address
				}, function (results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						callback(results[0]);
					}
				});
			}
		}

	</script>
	<script src="{{ url('/assets/js/app/d.select.category.js') }}"></script>
	<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
	
	<script language="javascript">
	function get_keywords(){
		var cat =  $('#category_id').val();
		var vals =  '{{$business->keywords}}';
		$.ajax({
			url: "{{ route('keywords') }}",
			type: 'post',
			data: {'cat':cat, 'vals':vals},
			dataType:'json',
			success: function(data)
			{
				$('#key_div').html(data.res);
				$(".chosen").trigger("chosen:updated");
				console.log("success");
				console.log(data);
				return false;
				
			},
			error : function(xhr, status,data){
			console.log("error");
			console.log(data);
			return false;
			}
		});     
	}
	
	$('#category_id').change(function() {
		get_keywords()
    });
	
	/* BOF Biz Hours */
	$('#biz-hr-btn').click(function() {
		var bhday_val = $('#bh-day').val();
		var bhday_txt = $('#bh-day').find(":selected").text();
		var bhstart_val = $('#bh-start').val();
		var bhstart_txt = $('#bh-start').find(":selected").text();
		var bhend_val = $('#bh-end').val();
		var bhend_txt = $('#bh-end').find(":selected").text();
		$('.biz-hours-box').append('<div><span><b>'+bhday_txt+' </b></span><span>'+bhstart_txt+' </span><span>- </span><span>'+bhend_txt+' </span><a href="#" class="rem-bh">{{t("Remove")}}</a><input name="biz_hours[]" value="'+bhday_val+' '+bhstart_val+' '+bhend_val+'" type="hidden"></div>');
		
		$('#bh-day').children("option").filter(function() {
			if(bhday_val==6){
				bhday_val=-1;
			}
			return  parseFloat(this.value) == parseFloat(bhday_val)+1;
		}).prop("selected", true);
		
	});
	
	$(".biz-hours-box").delegate("a", "click", function(){
		$(this).parent('div').remove();
		return false;
	});
	
	$('#bh-start').change(function() {
		setBizHrs();
	});
	
	function setBizHrs(){
		var fltrVal =  parseFloat($('#bh-start').val());
		$('#bh-end').children("option").filter(function() {
			return  (parseFloat(this.value) <= fltrVal) &&  (parseFloat(this.value) != 0);
		}).prop("disabled", true);
		
		$('#bh-end').children("option").filter(function() {
			return  parseFloat(this.value) > fltrVal;
		}).prop("disabled", false);
		
		$('#bh-end').children("option").filter(function() {
			return  parseFloat(this.value) == 0;
		}).prop("selected", true);
	}
	/* EOF Biz Hours */
	</script>
@endsection
