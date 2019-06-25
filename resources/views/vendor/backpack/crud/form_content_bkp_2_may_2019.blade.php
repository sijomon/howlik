<style>
	.required sup {
		
		color: red !important;
	}
</style>
<link rel="stylesheet" href="{{ url('/assets/css/dropzone.css') }}">
<form role="form">
  {{-- Show the erros, if any --}}
  @if ($errors->any())
  	<div class="callout callout-danger">
        <h4>{{ trans('Please Fix') }}</h4>
        <ul>
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
		</ul>
	</div>
  @endif
	
  {{-- Show the inputs --}}
  @foreach ($crud['fields'] as $field)
    <!-- load the view from the application if it exists, otherwise load the one in the package -->
	@if(view()->exists('vendor.backpack.crud.fields.'.$field['type']))
		@if(isset($crud['biz']) && $field['type'] == 'biz_offers')
			@if(!isset($field['value']))
			@else
				@include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
			@endif
		@else
			@include('vendor.backpack.crud.fields.'.$field['type'], array('field' => $field))
		@endif
	@else
		@include('crud::fields.'.$field['type'], array('field' => $field))
	@endif
  @endforeach
</form>

{{-- For each form type, load its assets, if needed --}}
{{-- But only once per field type (no need to include the same css/js files multiple times on the same page) --}}

{{--*/	$loaded_form_types_css = array(); /*--}}
{{--*/	$loaded_form_types_js = array(); /*--}}

@section('after_styles')
	<!-- FORM CONTENT CSS ASSETS -->
	@foreach ($crud['fields'] as $field)
		@if(!isset($loaded_form_types_css[$field['type']]) || $loaded_form_types_css[$field['type']]==false)
			@if (View::exists('vendor.backpack.crud.fields.assets.css.'.$field['type'], array('field' => $field)))
				@include('vendor.backpack.crud.fields.assets.css.'.$field['type'], array('field' => $field))
				{{--*/ $loaded_form_types_css[$field['type']] = true; /*--}}
			@elseif (View::exists('crud::fields.assets.css.'.$field['type'], array('field' => $field)))
				@include('crud::fields.assets.css.'.$field['type'], array('field' => $field))
				{{--*/ $loaded_form_types_css[$field['type']] = true; /*--}}
			@endif
		@endif
	@endforeach
@endsection

@section('after_scripts')
	<!-- FORM CONTENT JAVSCRIPT ASSETS -->
	@foreach ($crud['fields'] as $field)
		@if(!isset($loaded_form_types_js[$field['type']]) || $loaded_form_types_js[$field['type']]==false)
			@if (View::exists('vendor.backpack.crud.fields.assets.js.'.$field['type'], array('field' => $field)))
				@include('vendor.backpack.crud.fields.assets.js.'.$field['type'], array('field' => $field))
				{{--*/ $loaded_form_types_js[$field['type']] = true; /*--}}
			@elseif (View::exists('crud::fields.assets.js.'.$field['type'], array('field' => $field)))
				@include('crud::fields.assets.js.'.$field['type'], array('field' => $field))
				{{--*/ $loaded_form_types_js[$field['type']] = true; /*--}}
			@endif
		@endif
	@endforeach

<script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>

<script language="javascript">
	var checked = document.getElementById('link_to_social');
	checked.addEventListener('change', function() {
	  if (this.checked){
		$('#text_1').parent().show();
		$('#text_2').parent().show();
	  } else {
		$('#text_1').parent().hide();
		$('#text_2').parent().hide();
	  }
	});

	var siteUrl = '{{ url("") }}';
	
	var countries = {};
	var countryCode = '{{isset($entry->country_code) ? $entry->country_code : "CA"}}';
	var lang = {
		'select': {
			'country': "Select a country",
			'loc': "Select a location",
			'subLocation': "Select a sub-location",
			'city': "Select a city"
		}
	};
	
	var loc = '{{old("location", isset($entry->subadmin1_code) ? $entry->subadmin1_code : 0)}}';
	var subLocation = '0';
	var city = '{{old("city", isset($entry->event_place) ? $entry->event_place : 0)}}';
	var hasChildren = '';
</script>

<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>

<script language="javascript">
@if(isset($crud['entity_name']) && $crud['entity_name']=='city')
	var curLoc = '';
	var curCity = '';
	var curCountry = '';
	@if(isset($crud["fields"]))
		@foreach($crud["fields"] as $value)
			@if($value["name"]=='subadmin1_code' && isset($value["value"]))
				curLoc = '{{$value["value"]}}';
			@elseif($value["name"]=='city_id' && isset($value["value"]))
				curCity = '{{$value["value"]}}';
			@elseif($value["name"]=='country_code' && isset($value["value"]))
				curCountry = '{{$value["value"]}}';
			@endif
		@endforeach
	@endif
	vinChangeCountry();
@endif
	
/* Get location based on country */
	$('#country_code').change(function() {
		vinChangeCountry();
    });
	
	function vinChangeCountry(){
		var code = $('#country_code').val();
		console.log(code);
		
		$.ajax({
			url: "{{ route('getlocation') }}",
			type: 'post',
			data: {'code':code, 'curLoc':curLoc},
			dataType:'json',
			success: function(data)
			{
				$('#subadmin1').html(data.res);
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
	/* Get sub location based on location */
	
	$('#subadmin1').change(function() {
   
		var subadmin1_code1 = $('#subadmin1').val();
		var code = $('#country_code').val();
		var subadmin1_code	=	code+"."+subadmin1_code1;
		
		console.log(subadmin1_code);
		
		$.ajax({
				url: "{{ route('location') }}",
				type: 'post',
				data: {'subadmin1_code':subadmin1_code},
				dataType:'json',
				success: function(data)
				{
					$('#subadmin2').html(data.subadmin2_drop);
					$(".chosen").trigger("chosen:updated");
					console.log("success");
					console.log(data);
					return false;
					
				},
				error : function(xhr, status,data){
				console.log("error");
				
				}
				
		});    
    });
</script>

@if(isset($crud['entity_name']) && $crud['entity_name']=='business info')
<style>
.error_border{
	border:1px solid #FF0000 !important;
}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		setInfoVals();
	});
	
	$('#biz-info-btn').click(function() {
		$('#infoVal').removeClass('error_border');
		var infoVal = $.trim($('#infoVal').val());
		if(infoVal==''){
			$('#infoVal').addClass('error_border');
			return false;
		}
		$('.info-vals-box').append('<div><span><b>'+infoVal+' </b> </span><a href="#" class="rem-bh">Remove</a><input name="info_vals[]" value="'+infoVal+'" type="hidden"></div>');
		$('#infoVal').val('');
	});
	
	$(".info-vals-box").delegate("a", "click", function(){
		$(this).parent('div').remove();
		return false;
	});
	
	$('#info_type').change(function() {
		setInfoVals();
	});
	
	function setInfoVals(){
		var info_type =  $('#info_type').val();
		if(info_type==1){
			$("#biz-info-vals").fadeOut('normal');
		}else{
			$("#biz-info-vals").fadeIn('normal');
		}
	}
</script>
@endif

@if(isset($crud['entity_name']) && $crud['entity_name']=='Business Listing')
<script type="text/javascript">
	var curLoc = '';
	var curCity = '';
	
	var curLocTxt = '';
	var curCityTxt = '';
	var curCountry = '';
	var curZip = '';
	var curAddr1 = '';
	var curAddress = '';
	var curLat = 0;
	var curLon = 0;
	jQuery(document).ready(function($) {
		get_keywords();
		
		@if(isset($crud["fields"]))
			@foreach($crud["fields"] as $value)
				@if($value["name"]=='subadmin1_code' && isset($value["value"]))
					curLoc = '{{$value["value"]}}';
				@elseif($value["name"]=='city_id' && isset($value["value"]))
					curCity = '{{$value["value"]}}';
				@elseif($value["name"]=='country_code' && isset($value["value"]))
					curCountry = '{{$value["value"]}}';
				@elseif($value["name"]=='zip' && isset($value["value"]))
					curZip = '{{$value["value"]}}';
				@elseif($value["name"]=='address1' && isset($value["value"]))
					curAddr1 = '{{$value["value"]}}';
				@elseif($value["name"]=='lat' && isset($value["value"]))
					curLat = '{{$value["value"]}}';
				@elseif($value["name"]=='lon' && isset($value["value"]))
					curLon = '{{$value["value"]}}';
				@endif
			@endforeach
		@endif
		
		var code = $('#countryCode').val();
		if(curLat==0 && curLon==0){
			getLatitudeLongitude(showResult, code);
		}
		
		get_location(code, 'locationCode');
		
		setBizHrs();
	});
	
	function get_location(code, htDiv){
		
		$.ajax({
			url: "{{ route('getlocation') }}",
			type: 'post',
			data: {'code':code, 'curLoc':curLoc},
			dataType:'json',
			success: function(data)
			{
				$('#'+htDiv).html(data.res);
				$(".chosen").trigger("chosen:updated");
				console.log("success");
				console.log(data);
				
				var loc = $("#locationCode option:selected").val();
				get_city(loc, 'city_id');
				
				return false;
				
			},
			error : function(xhr, status,data){
			console.log("error");
			console.log(data);
			return false;
			}
		}); 
	}
	
	$('#countryCode').change(function() {
		var code = $('#countryCode').val();
		curCountry = code;
		get_location(code, 'locationCode');
    });
	
	function get_city(code, htDiv){
		$.ajax({
			url: "{{ route('getcity') }}",
			type: 'post',
			data: {'code':code, 'curCity':curCity},
			dataType:'json',
			success: function(data)
			{
				$('#'+htDiv).html(data.res);
				$(".chosen").trigger("chosen:updated");
				console.log("success");
				console.log(data);
				
				//BOF code to get Geo Location
				curLocTxt = $("#locationCode option:selected").text();
				curCityTxt = $("#city_id option:selected").text();
				curAddress = curAddr1+','+curCityTxt+','+curLocTxt+','+curCountry;
				
				if((curLat==0 && curLon==0) || curCityTxt=='City'){
					getLatitudeLongitude(showResult, curAddress);
				}else{
					initialize(curLat, curLon);
				}
				//EOF code to get Geo Location
				
				return false;
				
			},
			error : function(xhr, status,data){
			$('#'+htDiv).html('<option value="">City</option>');
			$(".chosen").trigger("chosen:updated");
			
			//BOF code to get Geo Location
			curCountry = $("#countryCode option:selected").val();
			curAddress = curCountry;
			getLatitudeLongitude(showResult, curAddress);
			//EOF code to get Geo Location
				
			console.log("error");
			console.log(data);
			return false;
			}
		}); 
	}
	
	$('#locationCode').change(function() {
		var code = $('#locationCode').val();
		get_city(code, 'city_id');
    });
	
	$('#city_id').change(function() {
		//BOF code to get Geo Location
		curAddr1 = $("#address1").val();
		curCountry = $("#countryCode option:selected").val();
		curLocTxt = $("#locationCode option:selected").text();
		curCityTxt = $("#city_id option:selected").text();
		curAddress = curAddr1+','+curCityTxt+','+curLocTxt+','+curCountry;
		
		getLatitudeLongitude(showResult, curAddress);
		//EOF code to get Geo Location
    });
	
	
	function get_keywords(){
		var cat =  $('#category_id').val();
		var vals =  $('#category_id_val').val();
		$.ajax({
			url: "{{ url('en/keywords') }}",
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
		$('.biz-hours-box').append('<div><span><b>'+bhday_txt+' </b></span><span>'+bhstart_txt+' </span><span>- </span><span>'+bhend_txt+' </span><a href="#" class="rem-bh">Remove</a><input name="biz_hours[]" value="'+bhday_val+' '+bhstart_val+' '+bhend_val+'" type="hidden"></div>');
		
		$('#bh-day').children("option").filter(function() {
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
@endif

@if(isset($crud['entity_name']) && $crud['entity_name']=='Business Listing')
<script type="text/javascript">

	jQuery(document).ready(function($) {
		
		@if(!(isset($entry->link_to_social) && $entry->link_to_social==1))
			$('#text_1').parent().hide();
			$('#text_2').parent().hide();
		@endif
		
		 webshims.setOptions('forms-ext', {types: 'date'});
		 webshims.polyfill('forms forms-ext');
	
		$.ajaxPrefilter(function(options, originalOptions, xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');

			if (token) {
				return xhr.setRequestHeader('X-XSRF-TOKEN', token);
			}
		});

		// make the delete button work in the first result page
		register_delete_button_action();

		function register_delete_button_action() {
			$("[data-button-type=delete]").unbind('click');
			// CRUD Delete
			// ask for confirmation before deleting an item
			$("[data-button-type=delete]").click(function(e) {
				e.preventDefault();
				var delete_button = $(this);
				var delete_url = $(this).attr('href');

				if (confirm("{{ trans('backpack::crud.delete_confirm') }}") == true) {
					$.ajax({
						url: delete_url,
						type: 'DELETE',
						success: function(result) {
							// Show an alert with the result
							new PNotify({
								title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
								text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
								type: "success"
							});
							// delete the row from the table
							window.location.replace($("input[name=edit_url]").val());
							window.location.href = $("input[name=edit_url]").val();
						},
						error: function(result) {
							// Show an alert with the result
							new PNotify({
								title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
								text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
								type: "warning"
							});
						}
					});
				} else {
					new PNotify({
						title: "{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}",
						text: "{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}",
						type: "info"
					});
				}
			});
		}


	});
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			
			$('.offer-type').change(function(){
				
				if($(this).val()== 1)
				{
					$("#offer-headline").show();
					$("#left_span").html("");
					$("#right_span").html("{{ t('% off') }}");
				}
				else if($(this).val()== 2)
				{
					$("#offer-headline").show();
					$("#left_span").html($("#currency").html());
					$("#right_span").html("{{ t('off') }}");
				}
				else if($(this).val()== 3)
				{
					$("#offer-headline").show();
					$("#left_span").html("");
					$("#right_span").html("{{ t('free') }}");
				}
				else if($(this).val()== 4)
				{
					$("#offer-headline").show();
					$("#left_span").html($("#currency").html());
					$("#right_span").html("{{ t('for') }}");
				}
				else
				{
					$("#offer-headline").hide();
					$("#left_span").html("");
					$("#right_span").html("");
				}
				
			});
			
		});
	</script>
	
	<script type="text/javascript">
	
		$( "#more-submit" ).click(function( event ) {
			
			if($('#offer-type option:selected').val() == 0) {
				
				$('#offer-type').focus();
				return false;
				
			} else if($.trim($('#offer-percent').val()) == '') {
				
				$('#offer-percent').focus();
				return false;
				
			} else if(!$.isNumeric($.trim($('#offer-percent').val()))) {
				
				$('#offer-percent').focus();
				$("#offer-percent-error").show().fadeOut("slow");
				return false;
				
			} else if($.trim($('#offer-content').val()) == '') {
				
				$('#offer-content').focus();
				return false;
				
			} else {
				
				var biz_id 	= $('#biz-id').val();
				var type 	= $('#offer-type option:selected').val();
				var percent	= $('#offer-percent').val();
				var content = $('#offer-content').val();
				var details	= $('#offer-details').val();
				
				$.ajax({
					
					url	: '{{ url("admin/postbizoffers") }}',
					type: 'post',
					data: {'biz_id':biz_id,'type':type,'percent':percent,'content':content,'details':details},
					dataType:'json',
					success: function(data)					 
					{
						if(data.success)
						{
							$('div.offer-list-load-ajax').prepend(data.success);
							$("#success-alert").alert();
							$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
								$("#success-alert").slideUp(500);
								$('#offer-type').val('');
								$('#offer-percent').val('');
								$('#offer-content').val('');
								$('#offer-details').val('');
								$("#offer-type option:contains('- - select one type - -')").prop('selected',true);
								$("#offer-headline").hide();
								$("#left_span").html("");
								$("#right_span").html("");
							});   
						}
						else
						{
							$("#danger-alert").alert();
							$("#danger-alert").fadeTo(2000, 500).slideUp(500, function(){
								$("#danger-alert").slideUp(500);
							}); 
						}
					}
				});
			}
		});
	</script>
	
	<script type="text/javascript">
	
		$( ".edit-submit" ).click(function( event ) {
			
			var	id	=	$(this).val();
			
			if($('#offer-type-'+id+' option:selected').val() == 0) {
				
				$('#offer-type-'+id).focus();
				return false;
				
			} else if($.trim($('#offer-percent-'+id).val()) == '') {
				
				$('#offer-percent-'+id).focus();
				return false;
				
			} else if(!$.isNumeric($.trim($('#offer-percent-'+id).val()))) {
				
				$('#offer-percent-'+id).focus();
				$('#offer-percent-error-'+id).show().fadeOut("slow");
				return false;
				
			} else if($.trim($('#offer-content-'+id).val()) == '') {
				
				$('#offer-content-'+id).focus();
				return false;
				
			} else {
				
				var type 	= $('#offer-type-'+id+' option:selected').val();
				var percent	= $('#offer-percent-'+id).val();
				var content = $('#offer-content-'+id).val();
				var details	= $('#offer-details-'+id).val();
				
				$.ajax({
					
					url	: '{{ url("admin/editbizoffers") }}',
					type: 'post',
					data: {'off_id':id,'type':type,'percent':percent,'content':content,'details':details},
					dataType:'json',
					success: function(data)					 
					{
						if(data > 0)
						{
							$("#success-alert-"+id).alert();
							$("#success-alert-"+id).fadeTo(2000, 500).slideUp(500, function(){
								$("#success-alert-"+id).slideUp(500);
							});   
						}
						else
						{
							$("#danger-alert-"+id).alert();
							$("#danger-alert-"+id).fadeTo(2000, 500).slideUp(500, function(){
								$("#danger-alert-"+id).slideUp(500);
							}); 
						}
					}
				});
			}
		});
	</script>
	
	<script type="text/javascript">
		
		function editChange(e) {
				
			$('#offer-type-'+e).change(function(){
				
				if($(this).val()== 1)
				{
					$("#offer-headline-"+e).show();
					$("#left-span-"+e).html("");
					$("#right-span-"+e).html("{{ t('% off') }}");
				}
				else if($(this).val()== 2)
				{
					$("#offer-headline-"+e).show();
					$("#left-span-"+e).html($("#currency").html());
					$("#right-span-"+e).html("{{ t('off') }}");
				}
				else if($(this).val()== 3)
				{
					$("#offer-headline-"+e).show();
					$("#left-span-"+e).html("");
					$("#right-span-"+e).html("{{ t('free') }}");
				}
				else if($(this).val()== 4)
				{
					$("#offer-headline-"+e).show();
					$("#left-span-"+e).html($("#currency").html());
					$("#right-span-"+e).html("{{ t('for') }}");
				}
				else
				{
					$("#offer-headline-"+e).hide();
					$("#left-span-"+e).html("");
					$("#right-span-"+e).html("");
				}
				
			}).trigger('change');
		}
			
		function dropOffer(id)
		{
			var alertmsg = confirm("{{ t('Are you Sure?') }}");
			if (alertmsg) {
				
				$.ajax({
					
					url	: '{{ url("admin/dropbizoffers") }}',
					type: 'post',
					data: {'id':id},
					dataType:'json',
					success: function(data)					 
					{
						if(data > 0)
						{
							$("div#off-"+id).remove();   
						}
						else
						{
							$("#danger-alert-msg").alert();
							$("#danger-alert-msg").fadeTo(2000, 500).slideUp(500, function(){
								$("#danger-alert-msg").slideUp(500);
							}); 
						}
					}
				});
				return true;
				
			} else {
				return false;
			}
		}
		
	</script>
	
	<script src="{{ url('/assets/js/dropzone.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		var vin_biz_error = "Error!";
		$(function() {
			var fileList = new Array;
			var biz_id 	= $('#bizid').val();
			$("#postbizpics").dropzone({
				
				url: "{{ url('admin/postbizpics') }}",
				addRemoveLinks : true,
				maxFilesize: 10,
				maxFiles: 10,
				params: { biz_id: biz_id}, 
				sending: function(file, xhr, formData) {
					// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
					formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
				},
				success : function(file, response) {
					// $('div.append-img-ajax').prepend(response.success);
					fileList[file.lastModified] = response.fileName;
				},
				removedfile: function(file) {
					$.post("{{ url('admin/dropbizpics') }}", {fileName:fileList[file.lastModified]}, function(data){});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;      
				}
			});
		});
		
		function deleteBizPic(id)
		{
			var alertmsg = confirm("{{ t('Are you Sure?') }}");
			if (alertmsg) {
				
				$.ajax({
					
					url	: '{{ url("admin/dropbizpics") }}',
					type: 'post',
					data: {'id':id},
					dataType:'json',
					success: function(data)					 
					{
						$('div#img-'+id).remove();
						return true;
					},
					error: function(xhr, status,data)			 
					{
						return false;
					}
				});
				return true;
					
			} else {
					
				return false;
			}
		}
		
	</script>
	
	<!-- BOF BUSINESS LOCATION EDIT PAGE SCRIPTS -->
	<script type="text/javascript">
	
		var mapx;
		var curLocx = '';
		var curCityx = '';
		var curLocTxtx = '';
		var curCityTxtx = '';
		var curCountryx = '';
		var curZipx = '';
		var curAddr1x = '';
		var curAddressx = '';
		var curLatx = 0;
		var curLonx = 0;
		
		function postLocation() {
			
			var code = $('select#countryz').val();
			if(curLat==0 && curLon==0){
				getLatitudeLongitudex(showResultx, code);
			}
			
			get_locationx(code);
			
		}
		
		function get_locationx(code){
			
			$.ajax({
				url: "{{ route('getlocation') }}",
				type: 'post',
				data: {'code':code, 'curLoc':curLocx},
				dataType:'json',
				success: function(data)
				{
					$('select#locationz').html(data.res);
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
		
		function get_cityx(code) {
			
			$.ajax({
				url: "{{ route('getcity') }}",
				type: 'post',
				data: {'code':code, 'curCity':curCityx},
				dataType:'json',
				success: function(data)
				{
					$('select#cityz').html(data.res);
					$(".chosen").trigger("chosen:updated");
					console.log("success");
					console.log(data);
					
					//BOF code to get Geo Location
					curLocTxtx = $("select#locationz option:selected").text();
					curCityTxtx = $("select#cityz option:selected").text();
					curAddressx = curAddr1x+','+curCityTxtx+','+curLocTxtx+','+curCountryx;
					
					if((curLatx==0 && curLonx==0) || curCityTxtx=='City'){
						getLatitudeLongitudex(showResultx, curAddressx);
					}else{
						initializex(curLatx, curLonx);
					}
					//EOF code to get Geo Location
					
					return false;
					
				},
				error : function(xhr, status,data) {
					
					//$('#'+htDiv).html('<option value="">City</option>');
					//$(".chosen").trigger("chosen:updated");
					
					//BOF code to get Geo Location
					curCountryx = $("select#countryz option:selected").val();
					curAddressx = curCountryx;
					getLatitudeLongitudex(showResultx, curAddressx);
					//EOF code to get Geo Location
						
					console.log("error");
					console.log(data);
					return false;
				}
			}); 
		}
			
		function get_mapx() {
			
			//BOF code to get Geo Location
			curAddr1x = $("#address1z").val();
			curCountryx = $("select#countryz option:selected").val();
			curLocTxtx = $("select#locationz option:selected").text();
			curCityTxtx = $("select#cityz option:selected").text();
			curAddressx = curAddr1x+','+curCityTxtx+','+curLocTxtx+','+curCountryx;
			
			getLatitudeLongitudex(showResultx, curAddressx);
			//EOF code to get Geo Location
		}
		
		function initializex(lat, lon) {
			
			document.getElementById("lat1z").value = lat;
			document.getElementById("lon1z").value = lon;
			var myLatlngx = new google.maps.LatLng(lat, lon);

			var myOptions = {
				zoom: 15,
				center: myLatlngx,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			mapx = new google.maps.Map(document.getElementById("map_canvasz"), myOptions);

			var marker = new google.maps.Marker({
				draggable: true,
				position: myLatlngx,
				map: mapx,
				title: "Your location"
			});

			google.maps.event.addListener(marker, 'dragend', function (event) {
				document.getElementById("lat1z").value = event.latLng.lat();
				document.getElementById("lon1z").value = event.latLng.lng();
			});
		}
		
		function auto_locatex() {
			var address = $.trim($("#address1z").val());
			var address2 = $.trim($("#address2z").val());
			var zip = $.trim($("#zipz").val());
			var city = $.trim($("#cityz option:selected").text());
			var country = $.trim($("#countryz option:selected").val());
			geocoder = new google.maps.Geocoder();
			//In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
			//var address = document.getElementById( 'address' ).value;
			var address = address+', '+address2+', '+city+'-'+zip+', '+country;
			geocoder.geocode( { 'address' : address }, function( results, status ) {
				if( status == google.maps.GeocoderStatus.OK ) {
					initializex(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				} 
			});
			return false;
		}
	
		function showResultx(result) {
			
			var lat = result.geometry.location.lat();
			var lon = result.geometry.location.lng();
			initializex(lat, lon);
		}
		
		function getLatitudeLongitudex(callback, address) {
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
	<!-- EOF BUSINESS LOCATION POST PAGE SCRIPTS -->
	
	<!-- BOF BUSINESS LOCATION EDIT PAGE SCRIPTS -->
	<script type="text/javascript">
	
		var mapz;
		var curLocz = '';
		var curCityz = '';
		var curLocTxtz = '';
		var curCityTxtz = '';
		var curCountryz = '';
		var curZipz = '';
		var curAddr1z = '';
		var curAddressz = '';
		var curLatz = 0;
		var curLonz = 0;

		function editLocation(lid) {
			
			var code = $('#countryz-'+lid).val();
			if(curLat==0 && curLon==0){
				getLatitudeLongitudez(showResultz, code);
			}
			$('#id-now').empty().html(lid);
			
			get_locationz(code, lid);
		}
		
		function get_locationz(code, lid){
			
			curLocz = $("#locnow-"+lid).val();
			
			$.ajax({
				url: "{{ route('getlocation') }}",
				type: 'post',
				data: {'code':code, 'curLoc':curLocz},
				dataType:'json',
				success: function(data)
				{
					$('#locationz-'+lid).html(data.res);
					$(".chosen").trigger("chosen:updated");
					console.log("success");
					console.log(data);
					
					var loc = $("#locationz-"+lid+" option:selected").val();
					get_cityz(loc, lid);
					return false;
					
				},
				error : function(xhr, status,data){
					console.log("error");
					console.log(data);
					return false;
				}
			}); 
		}
		
		function get_cityz(code, lid) {
			
			if(code == '') {
				
				$('#cityz-'+lid).html('<option selected="selected">City</option>');
				return false;
			}
			
			curCityz = $("#citnow-"+lid).val();
			
			$.ajax({
				url: "{{ route('getcity') }}",
				type: 'post',
				data: {'code':code, 'curCity':curCityz},
				dataType:'json',
				success: function(data)
				{
					$('#cityz-'+lid).html(data.res);
					$(".chosen").trigger("chosen:updated");
					console.log("success");
					console.log(data);
					
					//BOF code to get Geo Location
					curLocTxtz = $("#locationz-"+lid+" option:selected").text();
					curCityTxtz = $("#cityz-"+lid+" option:selected").text();
					curAddressz = curAddr1z+','+curCityTxtz+','+curLocTxtz+','+curCountryz;
					
					if((curLatz==0 && curLonz==0) || curCityTxtz=='City'){
						getLatitudeLongitudez(showResultz, curAddressz);
					}else{
						initializez(curLatz, curLonz);
					}
					//EOF code to get Geo Location
					
					return false;
					
				},
				error : function(xhr, status,data) {
					
					//$('#'+htDiv).html('<option value="">City</option>');
					//$(".chosen").trigger("chosen:updated");
					
					//BOF code to get Geo Location
					curCountryz = $("#countryz"+lid+" option:selected").val();
					curAddressz = curCountryz;
					getLatitudeLongitudez(showResultz, curAddressz);
					//EOF code to get Geo Location
						
					console.log("error");
					console.log(data);
					return false;
				}
			}); 
		}
			
		function get_mapz(lid) {
			
			//BOF code to get Geo Location
			curCountryz = $("select#countryz-"+lid+" option:selected").val();
			curLocTxtz 	= $("select#locationz-"+lid+" option:selected").text();
			curCityTxtz = $("select#cityz-"+lid+" option:selected").text();
			curAddressz = curCityTxtz+','+curLocTxtz+','+curCountryz;
			
			getLatitudeLongitudez(showResultz, curAddressz);
			//EOF code to get Geo Location
		}
		
		function initializez(lat, lon) {
			
			var lid = $.trim($('#id-now').html());
			
			document.getElementById("lat1z-"+lid).value = lat;
			document.getElementById("lon1z-"+lid).value = lon;
			var myLatlngz = new google.maps.LatLng(lat, lon);

			var myOptions = {
				zoom: 15,
				center: myLatlngz,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			mapz = new google.maps.Map(document.getElementById("map_canvasz-"+lid), myOptions);

			var marker = new google.maps.Marker({
				draggable: true,
				position: myLatlngz,
				map: mapz,
				title: "Your location"
			});

			google.maps.event.addListener(marker, 'dragend', function (event) {
				document.getElementById("lat1z-"+lid).value = event.latLng.lat();
				document.getElementById("lon1z-"+lid).value = event.latLng.lng();
			});
		}
		
		function auto_locatez(lid) {
			
			var address = $.trim($("#address1z-"+lid).val());
			var address2 = $.trim($("#address2z-"+lid).val());
			var zip 	= $.trim($("#zipz-"+lid).val());
			var city 	= $.trim($("#cityz-"+lid+" option:selected").text());
			var country = $.trim($("#countryz-"+lid+" option:selected").val());
			geocoder 	= new google.maps.Geocoder();
			//In this case it gets the address from an element on the page, but obviously you  could just pass it to the method instead
			//var address = document.getElementById( 'address' ).value;
			var address = address+', '+address2+', '+city+'-'+zip+', '+country;
			geocoder.geocode( { 'address' : address }, function( results, status ) {
				if( status == google.maps.GeocoderStatus.OK ) {
					initializez(results[0].geometry.location.lat(), results[0].geometry.location.lng());
				} 
			});
			return false;
		}
	
		function showResultz(result) {
		
			var lat = result.geometry.location.lat();
			var lon = result.geometry.location.lng();
			initializez(lat, lon);
		}
		
		function getLatitudeLongitudez(callback, address) {
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
	<!-- EOF BUSINESS LOCATION EDIT PAGE SCRIPTS -->
	
	<script type="text/javascript">
	
		$('button#loc-submit-post').click(function() {
			
			if($.trim($('#address1z').val()) == '') {
				
				$('#address1z').focus();
				return false;
			} 
			else if($.trim($('#phonez').val()) == '') {
			
				$('#phonez').focus();
				return false;
			}
			else if($.trim($('#countryz').val()) == '') {
			
				$('#countryz').focus();
				return false;
			}
			else if($.trim($('#locationz').val()) == '') {
			
				$('#locationz').focus();
				return false;
			}
			else if($.trim($('#cityz').val()) == '') {
			
				$('#cityz').focus();
				return false;
			}
			else {
				
				var bid = $.trim($('#biz_id').val());
				var ad1 = $.trim($('#address1z').val());
				var ad2 = $.trim($('#address2z').val());
				var zip = $.trim($('#zipz').val());
				var phn = $.trim($('#phonez').val());
				var cou = $.trim($('#countryz').val());
				var loc = $.trim($('#locationz').val());
				var cit = $.trim($('#cityz').val());
				var lat = $.trim($('#lat1z').val());
				var lon = $.trim($('#lon1z').val());
				
				$.ajax({
					url : '{{ url("admin/postbizlocations") }}',
					type: 'post',
					dataType: 'json',
					data: {
						
						'biz_id' : bid,
						'address1' : ad1,
						'address2' : ad2,
						'zip' : zip,
						'phone' : phn,
						'country' : cou,
						'location' : loc,
						'city' : cit,
						'lat' : lat,
						'lon' : lon
					},
					success: function(data) {
						
						$("#success-alert-loc").show();
						$('#address1z').val('');
						$('#address2z').val('');
						$('#zipz').val('');
						$('#phonez').val('');
						$('#countryz').val('');
						$('#locationz').val('');
						$('#cityz').val('');
						$('#lat1z').val('');
						$('#lon1z').val('');
						$('div.location-list-ajax').prepend(data.success);
					},
					error : function(xhr, status,data) {
						
						$("#danger-alert-loc").show();
						console.log("error");
						console.log(data);
						return false;
					}
				});
				return true;
			}
		});
		
		function updateLocationForm(lid) {
			
			if($.trim($('#address1z-'+lid).val()) == '') {
				
				$('#address1z-'+lid).focus();
				return false;
			} 
			else if($.trim($('#phonez-'+lid).val()) == '') {
			
				$('#phonez-'+lid).focus();
				return false;
			}
			else if($.trim($('#countryz-'+lid).val()) == '') {
			
				$('#countryz-'+lid).focus();
				return false;
			}
			else if($.trim($('#locationz-'+lid).val()) == '') {
			
				$('#locationz-'+lid).focus();
				return false;
			}
			else if($.trim($('#cityz-'+lid).val()) == '') {
			
				$('#cityz-'+lid).focus();
				return false;
			}
			else {
				
				var ad1 = $.trim($('#address1z-'+lid).val());
				var ad2 = $.trim($('#address2z-'+lid).val());
				var zip = $.trim($('#zipz-'+lid).val());
				var phn = $.trim($('#phonez-'+lid).val());
				var cou = $.trim($('#countryz-'+lid).val());
				var loc = $.trim($('#locationz-'+lid).val());
				var cit = $.trim($('#cityz-'+lid).val());
				var lat = $.trim($('#lat1z-'+lid).val());
				var lon = $.trim($('#lon1z-'+lid).val());
				
				$.ajax({
					url : '{{ url("admin/editbizlocations") }}',
					type: 'post',
					dataType: 'json',
					data: {
						
						'id' : lid,
						'address1' : ad1,
						'address2' : ad2,
						'zip' : zip,
						'phone' : phn,
						'country' : cou,
						'location' : loc,
						'city' : cit,
						'lat' : lat,
						'lon' : lon
					},
					success: function(data) {
						
						$("#success-alert-loc-up").show();
						location.reload();
					},
					error : function(xhr, status,data) {
						
						$("#danger-alert-loc-up").show();
						console.log("error");
						console.log(data);
						return false;
					}
				});
				return true;
			}
		}
		
		function dropLocation(id)
		{
			var alertmsg = confirm("{{ t('Are you Sure?') }}");
			if (alertmsg) {
				
				$.ajax({
					
					url	: '{{ url("admin/dropbizlocations") }}',
					type: 'post',
					data: {'id':id},
					dataType:'json',
					success: function(data)					 
					{
						$('div#loc-'+id).remove();
						return true;
					},
					error: function(xhr, status,data)			 
					{
						return false;
					}
				});
				return true;
					
			} else {
					
				return false;
			}
		}
		
		
	</script>
@endif	
@endsection