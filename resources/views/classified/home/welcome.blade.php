@extends('classified.layouts.master')

@section('content')

<!----------STARTS CATEGORY LISTING--------------->
<div class="category-listing demo">
<div class="category-container">
  <div class="category-row">
  	@if(isset($cats) && sizeof($cats)>0)
		@foreach($cats as $key => $value)
		<div class="cat-div">
		  <div class="cat-div-inner">
			<div class="cat-div-inner-content"><a href="{{lurl('c/'.trim($value->slug))}}"><img src="{{url($value->picture)}}"></a></div>
			<h2><a href="{{lurl('c/'.trim($value->slug))}}">{{$value->name}}</a></h2>
		  </div>
		</div>
		@endforeach
	@else
		<div class="cat-div">
		  <div class="cat-div-inner">
			<div class="cat-div-inner-content">&nbsp;</div>
			<h2>{{ t('No Data Found!') }}</h2>
		  </div>
		</div> 
	@endif
	
  </div>
</div>
</div>
<!----------STARTS CATEGORY LISTING--------------->

<!----------STARTS ADD YOUR BUSINESS--------------->
<div class="add-business-holder">
  <div class="add-business-container">
    <h3>{{t('Add Your Business')}}</h3>
    <div class="business-form">
		<form method="get" action="{{ lurl('/add-business') }}">
			<div class="col-md-6">
				<div class="business-name"> <!--<span id="businessname">{{t('Business name')}}</span>-->
					<input name="business_title" style="width:100%;" type="text" placeholder="{{t('Business name')}}">
				</div>
			</div>
			<div class="col-md-4">
				<div class="business-location"> <!--<span id="businesslocation">{{t('Location')}}</span>-->
					<input name="business_location" style="width:100%;" type="text" class="loc_search" placeholder="{{t('Location')}}">
				</div>
			</div>
			<div class="col-md-2">
				<div class="business-add-button">
					<button type="submit">{{t('Get Start')}}</button>
				</div>
			</div>
		</form>
    </div>
  </div>
</div>
<!----------ENDS ADD YOUR BUSINESS--------------->
@if(!$gotoweb)
	{{--*/ $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android"); /*--}}
	{{--*/ $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod"); /*--}}
	{{--*/ $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone"); /*--}}
	{{--*/ $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad"); /*--}}
	{{--*/ $detectShow = true; /*--}}
	@if (config('settings.app_logo_red') != '' and file_exists(public_path() . '/' . config('settings.app_logo_red')))
		{{--*/ $logo = config('settings.app_logo_red'); /*--}}
	@else
		{{--*/ $logo = 'assets/frontend/images/logo.png'; /*--}}
	@endif
	
	@if($Android || $iPod || $iPhone || $iPad)
	<div id="app_download" class="modal fade bd-location-modal-md" style="margin-top: 10%; padding-right: 0 !important;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" style="text-transform: uppercase;">
						@lang('global.Download Application')
					</h5>
				</div>
				<div class="modal-body">
					<div class="banner-section-app-download"> <img src="{{url('assets/frontend/images/banner01.jpg')}}">
					  <div class="banner-overlay">
						<div class="logo-section"> 
						<a href="{{ url('/' . $lang->get('abbr') . '/?d=' . $country->get('code')) }}">
							<img src="{{url($logo)}}" alt="{{ strtolower(config('settings.app_name')) }}" /> 
						</a>
						</div>
						<h1 class="banner-caption">{{ t('Howlik application is available, Please download it') }}</h1>
						<div class="app-icon"> 
							@if($iPod || $iPhone || $iPad)
							<span class="ios"><a href="https://itunes.apple.com/in/app/howlik-find-whats-nearby/id1404841444?mt=8"><img src="{{url('assets/frontend/images/appstore.png')}}"></a></span> 
							@elseif($Android)
							<span class="android"><a href="https://play.google.com/store/apps/details?id=nearby.business.events.howlik"><img src="{{url('assets/frontend/images/playstore.png')}}"/></a></span>
							@endif
							<br /><br />
							<div id="webtn">
							<button type="button" onclick="gotoweb();" class="btn btn-success btn-md">{{t('Go to Web')}}</button>
							</div>
						</div>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
@endif
@stop

@section('javascript')
	@if(!$gotoweb)
		@if($Android || $iPod || $iPhone || $iPad)
		<script type="text/javascript">
			$(document).ready(function() {
				$('#app_download').modal({backdrop: 'static', keyboard: false}); 
			});
			
			function gotoweb(){
				$("#webtn").html('<img src="{{ url("images/loading-new.gif")}}" width="10">');
				/*$.post("{{ url('gotoweb') }}", {'setval': 'setval'}, function(data){alert(data);
					$('#app_download').modal('toggle');
				},'json');*/
				$.ajax({
					url: "{{ lurl('gotoweb') }}",
					type: 'post',
					data: {'setval': 'setval'},
					dataType:'json',
					success: function(data)
					{
						$('#app_download').modal('toggle');
						//$("#webtn").html(
						console.log("success");
						console.log(data);
						return false;					
					},
					error : function(xhr, status,data) {
						console.log("error");
						console.log(data);
						return false; 
					},
					async: false
				});
				//setTimeout("$('#app_download').modal('toggle');", 500);
				return false;
			}
		</script>
		@endif
	@endif
@stop