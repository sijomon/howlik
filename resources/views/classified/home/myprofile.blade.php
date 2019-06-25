@extends('classified.layouts.layout')
<style>
	#small_img {
		height: 50px;
		width: 50px;
	}
	#inner {
		float: left;
	}
	i.fa.fa-map-marker {
    color: #fff !important;
}
</style>
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row"> 
				<!-- BOF PAGE CONTEVT -->
				<div class=" page-content">
				@if(!empty($users))
					<!-- BOF CONTENTS -->
					<div class="content-holder">
						<div class="container">
							<div class="profile-holder">
								@if($users->cover != '')
								<div class="cover-image" style="background: url({{ URL::asset($users->cover) }}) !important;"> 
								@else
								<div class="cover-image" style="background: -webkit-linear-gradient(left, #e40046, #b40037) !important;"> 
								@endif
								
									<!---<img src="images/banner.jpg">--->
									<div class="cover-overlay">
										<div class="profile-pic-holder"> 
										@if($users->photo == '')
											<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image"> 
										@else
											<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image"> 
										@endif
										@if(auth()->user() && auth()->user()->id == Request::segment('3'))
											<a class="icon-cam" href="{{ lurl('account/edit') }}"> <i class="fa fa-camera"></i> </a> 
										@endif
										</div>
										<div class="profil-name-holder">
											<h1 class="pfofile-name"> {{ $users->name }} </h1>
											<h5>
												@if(Request::segment('1') == 'ar')
													{{ $users->cname }}
												@else
													{{ $users->asciiname }}
												@endif
											</h5>
										</div>
										<!-- @if(auth()->user() && auth()->user()->id == Request::segment('3'))
											{{--*/ $actions = 'dropdown'; /*--}}
										@else
											{{--*/ $actions = ''; /*--}}
										@endif -->
										@if(auth()->user() && auth()->user()->id == Request::segment('3'))
										<div class="profile-actions">
											<button class="btn dropdown-toggle btn-user-icon" data-toggle="modal" data-target="#coverModal" ><i class="fa fa-picture-o"></i></button>
											<!-- <div class="dropdown-menu profile-actions-div">
												<li><a data-toggle="modal" data-target="#coverModal"> @lang('global.Change Cover Photo') </a></li>
											</div> -->
										</div>
										@endif
									</div>
								</div>
								
								<!--Starts Profile page tabs-->
								<div class="profile-tab">  
									<a class="btn btn-1 btn-1c" id="reviews_btn"> <span class="fa fa-star-o icon-m-r"> </span> @lang('global.Reviews') </a> 
									<a class="btn btn-1 btn-1c" id="activity_btn"> <span class="fa fa-puzzle-piece icon-m-r"> </span> @lang('global.Activity') </a> 
									<a class="btn btn-1 btn-1c" id="interest_btn"> <span class="fa fa-heart-o icon-m-r"> </span> @lang('global.Intrests') </a>
									<a href="{{ lurl('/friends-lists/'.Request::segment('3')) }}" class="btn btn-1 btn-1c"> <span class="fa fa-users icon-m-r"> </span> @lang('global.Friends') </a> 
									@if(auth()->user() && $users->id == $user->id)<a href="{{ lurl('/messages') }}" class="btn btn-1 btn-1c" > <span class="fa fa-send icon-m-r"> </span> @lang('global.Messages') </a>@endif 
									<!-- <a class="btn btn-1 btn-1c" id="friends_btn"> <span class="fa fa-users icon-m-r"> </span> @lang('global.Friends') </a> 
									@if(auth()->user() && $users->id == $user->id)<a class="btn btn-1 btn-1c" id="message_btn"> <span class="fa fa-send icon-m-r"> </span> @lang('global.Messages') </a>@endif -->
								</div>
								<!--Ends Profile page tabs--> 
							</div>
						  
							<!--PROFILE CONTENT STARTS HERE-->
							<div class="profile-content-holder">
								<div class="col-md-7 col-sm-7 _PCH_LSec">
									<div class="u-row"> 
										<!-- BOF REVIEWS TAB -->
										<div id="reviews">
											<h2 class="p_c-title"> @lang('global.Recent Reviews')</h2>
											<div class="recent-activity">
												@if(!empty($reviewss))
													@foreach($reviewss as $valuess)
													@if($valuess->biz_title)
														<div class="r-a-box1">
														@if($valuess->biz_image == '')
															<img src="{{ url('uploads/pictures/no-image.jpg') }}" alt="No Image" id="small_img" /> 
														
														@else
															<img src="{{ url($valuess->biz_image) }}" alt="No Image" id="small_img" /> 
														@endif 
														</div>
														<div class="r-a-box2">
															@if($valuess->biz_title)
															{{--*/ $link    =   "/".slugify(trim($valuess->biz_title))."/".$valuess->biz_id.".html"; /*--}}
															<h4><a href="{{url($link)}}"> {{ ucfirst($valuess->biz_title) }} </a></h4>
															@endif
															<p class="ra-left"> {{ ucwords($valuess->review) }} </p></br> 
															<p class="ra-right"> {{ date("d F Y",strtotime($valuess->updated_at)) }} </p>
														</div>
													@endif
													@endforeach
												@else
												<div class="r-a-box1">
												@if($users->photo == '')
													<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" id="small_img" /> 
												@else
													<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image" id="small_img" /> 
												@endif 
												</div>
												<div class="r-a-box2">
													<p class="ra-left"> @lang("global.Sorry..! You didn't have any Reviews to display!") </p></br> 
													<p class="ra-right">&nbsp;  </p>
												</div>
												@endif
											</div>
											<!--<p class="p-c-text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>-->
										</div>
										<!-- EOF REVIEWS TAB -->
										
										<!-- BOF ACTIVITY TAB -->
										<div id="activity" style="display: none;">
											<h2 class="p_c-title"> @lang('global.Recent Activity') </h2>
											<div class="recent-activity">
												@if(!empty($eventss))
													@foreach($eventss as $valuess)
														<div class="r-a-box1">
														@if($users->photo == '')
															<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" id="small_img" /> 
														@else
															<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image" id="small_img" /> 
														@endif 
														</div>
														<div class="r-a-box2">
															<h4><a> {{ ucfirst($valuess->event_name) }}
															<span class="ra-right activity_date"> {{ date("d F Y",strtotime($valuess->updated_at)) }} </span></a></h4>
															<p class="ra-left"> {{ ucwords($valuess->about_event) }} 
															 <br>
															@if($valuess->event_image1 == '')
																<img class="activity_img" src="{{ url('uploads/pictures/no-image.jpg') }}" /> 
															@else
																<img class="activity_img" src="{{ url( $valuess->event_image1 ) }}" /> 
															@endif
														</div>
													@endforeach
												@else
													<div class="r-a-box1">
													@if($users->photo == '')
														<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" id="small_img" /> 
													@else
														<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image" id="small_img" /> 
													@endif 
													</div>
												  
													<div class="r-a-box2">
														<p class="ra-left"> @lang("global.Sorry..! You didn't have any Recent Activity to display!") </p></br> 
														<p class="ra-right">&nbsp;  </p>
													</div>
												@endif
											</div>
										</div>
										<!-- EOF ACTIVITY TAB -->
										
										<!-- BOF INTEREST TAB -->
										<div id="interest" style="display: none;">
											<h2 class="p_c-title"> @lang('global.Interests') </h2>
											<div class="recent-activity">
												<div class="r-a-box1">
													@if($users->photo == '')
														<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" id="small_img" /> 
													@else
														<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image" id="small_img" /> 
													@endif 
												</div>
												<div class="r-a-box2">
												@if($users->interests != '') 
													{{--*/ $interestA = unserialize($users->interests); /*--}}
													@if(isset($interests) && !empty($interests))
														@foreach($interests as $interest)
															@if(isset($interestA[$interest->translation_of]) && $interestA[$interest->translation_of] == 1)	
																<div class="col-sm-6 intrest_div">
																	<div class="col-sm-3 col-xs-3">
																		@if($interest->int_img != '')
																			<img class="intrest_img" src="{{ url($interest->int_img) }}" />
																		@else
																			<img class="intrest_img" src="{{ url('uploads/pictures/interest/no_image.png') }}" />
																		@endif
																	</div>
																	<div class="col-sm-9 col-xs-9"> <p class="intrest_text"> {{ $interest->int_title }} </p> </div>
																</div>
															@endif
														@endforeach
													@endif	
												@endif
												</div>
											</div>
										</div>
										<!-- EOF INTEREST TAB -->
										
										<!-- BOF FRIENDS TAB -->
										<div id="friends" style="display: none;">
											<h2 class="p_c-title"> @lang('global.Friends') </h2>
											<div class="recent-activity">
												<div class="r-a-box1">
													@if($users->photo == '')
														<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" id="small_img" /> 
													@else
														<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image" id="small_img" /> 
													@endif 
												</div>
											</div>
										</div>
										<!-- EOF FRIENDS TAB -->
										
										<!-- BOF MESSAGE TAB -->
										<div id="messages" style="display: none;">
											<h2 class="p_c-title"> @lang('global.Messages') </h2>
											<div class="recent-activity">
												<div class="r-a-box1">
													@if($users->photo == '')
														<img src="{{ url('uploads/pictures/dp/demo.jpg') }}" alt="No Image" id="small_img" /> 
													@else
														<img src="{{ url('uploads/pictures/dp/'.$users->photo) }}" alt="No Image" id="small_img" /> 
													@endif 
												</div>
											</div>
										</div>
										<!-- EOF MESSAGE TAB -->
									</div>
								</div>
							
								<div class="col-md-3 col-sm-4 profile-about-right _PA_right">
									<h2 class="p_c-title text-center"> @lang('global.Notifications') </h2>
									<h3> @lang('global.Last 10 days') </h3>
									<ul>
										<li><span class="icon-round"><i class="fa fa-user"></i></span>
										  <p> 0 @lang('global.Views of your Profile') </p>
										</li>
										<li><span class="icon-round"><i class="fa fa-camera"></i></span>
										  <p> 0 @lang('global.Views of your Photos') </p>
										</li>
										<li><span class="icon-round"><i class="fa fa-star"></i></span>
										  <p> 0 @lang('global.Views of your Reviews') </p>
										</li>
									</ul>
									<h3> @lang('global.Location') </h3>
									<ul>
										<li><span class="icon-round"> <i class="fa fa-map-marker"></i> </span>
											<p> 
												@if(Request::segment('1') == 'ar')
													{{ $users->cname }}, {{ $users->country_code }}
												@else
													{{ $users->asciiname }}, {{ $users->country_code }}
												@endif
											</p>
										</li>
									</ul>
									<h3> @lang('global.Howliking Since') </h3>
									<ul>
										<li><span class="icon-round"> <i class="fa fa-calendar-check-o"></i> </span>
											<p> {{ date("F Y",strtotime($users->created_at)) }} </p>
										</li>
									</ul>
								</div>
								<!--TECH SUPPORT-->
								<div class="tech-support"> 
									<a href="{{ lurl('contact.html') }}" style="color: #fff;"><span class="glyphicon glyphicon-phone-alt"></span><p> @lang('global.Support') </p></a>
								</div>
								<!--TECH SUPPORT--> 
							</div>
							<!--PROFILE CONTENT ENDS  HERE--> 
						</div>
					</div>
					<!-- EOF CONTENTS -->
				</div>
				<!-- BOF PAGE CONTEVT -->
				
				<!-- BOF UPDATE COVER MODAL -->
				<div id="coverModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"> {{t('Upload a Cover Photo')}} </h4>
							</div>
							<div class="modal-body">
								<div class="col-sm-12 page-content">
									<div class="alert alert-success" id="alert-info" style="display: none;">
										<button type="button" class="close" data-dismiss="alert">x</button>
										<span>{{ t('Your cover photo uploaded successfully.') }}</span>
									</div>
									<form action="" enctype="multipart/form-data" id="upload-cover-form" method="post">
										{!! Form::token() !!}
										<div class="image_drop" style="margin-top:0;">
											<div class="dropzone" style="margin-bottom:0;" name="uploadcover" id="uploadcover"> </div>
										</div>
										<input type="hidden" id="cover" name="cover" />
									</form>
								</div>
							</div>
							<div class="modal-footer"> 
								<button type="button" class="btn btn-default" data-dismiss="modal">{{t('Close')}}</button>
								<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="window.location.reload(true)">{{t('Done')}}</button>
							</div>
						</div>
					</div>
				</div>
				<!-- EOF UPDATE COVER MODAL -->
				@endif
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent
	<script language="javascript">
		$(document).ready(function () {
			$('#reviews_btn').click(function () {
				$("#reviews").show();
				$("#interest").hide();
				$("#activity").hide();
				$("#friends").hide();
				$("#messages").hide();
			});
			$('#interest_btn').click(function () {
				$("#reviews").hide();
				$("#interest").show();
				$("#activity").hide();
				$("#friends").hide();
				$("#messages").hide();
			});
			$('#activity_btn').click(function () {
				$("#reviews").hide();
				$("#interest").hide();
				$("#activity").show();
				$("#friends").hide();
				$("#messages").hide();
			});
			$('#friends_btn').click(function () {
				$("#reviews").hide();
				$("#interest").hide();
				$("#activity").hide();
				$("#friends").show();
				$("#messages").hide();
			});
			$('#message_btn').click(function () {
				$("#reviews").hide();
				$("#interest").hide();
				$("#activity").hide();
				$("#friends").hide();
				$("#messages").show();
			});
			$('#reviews_btn').submit(function () {
				if(status == 1) {
					if(amount == '') {
						$('#amount_div').addClass("error_border");
						return false;
					}
					else {
						$('#amount_div').removeClass("error_border");
					}
				}
			});
		});
	</script>
	
	<script language="javascript">	
		
		var fileList = new Array;
		$(function() {
			$("#uploadcover").dropzone({
				
				url: "{{ lurl('profiles/upload/cover') }}",
				addRemoveLinks : true,
				maxFilesize: 10,
				maxFiles: 1,
				params: {}, 
				sending: function(file, xhr, formData) {
					formData.append("_token", $('[name=_token').val()); // Laravel expect the token post value to be named _token by default
				},
				success : function(file, response){ 
					$("#cover").val('uploads/pictures/covers/'+response);
					fileList[file.lastModified] = response;
					$('#alert-info').alert();
				},
				removedfile: function(file) {
					$.post("{{ lurl('profiles/remove/cover') }}", {fileName:fileList[file.lastModified]}, function(data){});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;      
				}
			});
		});
		
	</script> 
@endsection 
