@extends('classified.layouts.layout')
@section('content')
	<style>

		.fileContainer [type=file] {
			
			cursor: inherit;
			position: absolute;
		}
		.interestIcon {
			
			height: 25px;
			width: 25px;
		}
		.profile_pic_dlt{
			position: absolute;
			top: -8px;
			right: -8px;
			background: #e40046;
			color: #fff;
			border-radius: 100px;
			border: 3px solid #fff;		
			padding: 0 4px;
			cursor: pointer;
		}
		.profile-pic-div{
			width:100px;
			position:relative;
		}
		.profile_pic_img{
			width:100px;
			height:100px;
			border: 1px solid #ddd;
			border-radius: 3px;
			display: inline-block;
			padding: 3px;
		}

	</style>
	
	<div class="main-container" dir="ltr">
		<div class="container">
			<div class="row">
			
				<?php  if ($user->user_type_id  == 3) { ?>
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				<?php  }else{ ?>
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				<?php }?>
				<!--/.page-sidebar-->
				<?php /*?><div class="<?php if($user->user_type_id  == 2) { ?> col-sm-9 <?php  }else{ ?> col-sm-12  <?php } ?>page-content"><?php */?>
    
				<div class=" col-sm-9 page-content">
				
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>@lang('global.Oops ! An error has occurred. Please correct the red fields in the form')</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
						  </ul>
						</div>
					@endif
					
					<!-- BOF SHOW FLASH MESSAGES -->
					@if(Session::has('flash_notification.message'))
						@include('flash::message')
					@endif
					<!-- EOF SHOW FLASH MESSAGES -->
						
					<div class="alert alert-success del-msg" style="display: none;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h5>@lang('global.Your profile picture has deleted successfully.')</h5>
					</div>
					
					<div class="inner-box">
						<div class="row">
							<div class="col-md-5 col-xs-4 col-xxs-12">
								<h3 class="no-padding text-center-480 useradmin"> <a>
								@if(is_file('uploads/pictures/dp/'.$user->photo))
									<img class="userImg" src="{{ url('uploads/pictures/dp/'.$user->photo) }}" alt="{{ $user->name }} ">
								@else
									<img class="userImg" src="{{ url('images/user.jpg') }}" alt="{{ $user->name }} ">
								@endif
								<h3 class="page-sub-header2 clearfix no-padding">@lang('global.Hello') {{ $user->name }} ! </h3>
								<span class="page-sub-header-sub small">@lang('global.You last logged in at')
									: {{ $user->last_login_at->format('d-m-Y H:i:s') }}</span>  </a> </h3>
							</div>
						</div>
					</div>
					
					<div class="inner-box">
          
						<div id="accordion" class="panel-group">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#collapseB1" data-toggle="collapse"> @lang('global.My details') </a></h4>
								</div>
								<div class="panel-collapse collapse in" id="collapseB1">
									<div class="panel-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/details') }}">
											
											{!! csrf_field() !!}
										
											<!-- Gender -->
											<div class="form-group required <?php echo ($errors->has('gender')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label">@lang('global.Gender') <sup>*</sup></label>
												<div class="col-md-9"> @foreach ($genders as $gender)
													<label class="radio-inline" for="gender">
													<input name="gender" id="gender-{{ $gender->tid }}" value="{{ $gender->tid }}"
																							   type="radio" {{ (old('gender', $user->
													gender_id)==$gender->tid) ? 'checked="checked"' : '' }}>
													{{ $gender->name }} </label>
													@endforeach 
												</div>
											</div>
											
											<div class="form-group required <?php echo ($errors->has('name')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">@lang('global.Name') <sup>*</sup></label>
												<div class="col-sm-9">
													<input name="name" type="text" class="form-control" placeholder="" value="{{ $user->name }}">
												</div>
											</div>
											
											<div class="form-group required <?php echo ($errors->has('email')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label">@lang('global.Email') <sup>*</sup></label>
												<div class="col-sm-9">
													<input id="email" name="email" type="email" class="form-control" placeholder=""
																				   value="{{ $user->email }}">
												</div>
											</div>
											
											<!-- Country -->
											<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
												<label class="col-md-3 control-label" for="country">@lang('global.Your Country') <sup>*</sup></label>
												<div class="col-md-9">
													<select id="country" name="country" class="form-control">
														<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}>
															{{ t('Select your Country...') }}				
														</option>
														@if(!empty($countries))
														@foreach($countries as $code => $name)
															{{--*/ $slct = ''; /*--}}
															@if($user->country_code == $code)
																{{--*/ $slct = 'selected'; /*--}}
															@endif
															@if(isset($lang) && strtolower($lang->get('abbr'))=='ar')
																{{--*/ $cname = $name['name']; /*--}}
															@else
																{{--*/ $cname = $name['asciiname']; /*--}}
															@endif
															<option value="{{ $code }}" {{ $slct }}> {{ $cname }} </option>
														@endforeach	
														@endif
													</select>
												</div>
											</div>
											
											<div class="form-group required <?php echo ($errors->has('phone')) ? 'has-error' : ''; ?>">
												<label for="phone" class="col-sm-3 control-label">@lang('global.Phone') <sup>*</sup></label>
												<div class="col-sm-6">
													<div class="input-group"><span id="phone_country" class="input-group-addon">+000</span>
														<input id="phone" name="phone" type="text" class="form-control" placeholder="" value="{{ old('phone', $user->phone) }}">
													</div>
													<?php /*?><div class="checkbox">
													  <label>
													  <input name="phone_hidden" type="checkbox"
																							   value="1" {{ (old('phone_hidden', $user->
													  phone_hidden)=='1') ? 'checked="checked"' : '' }}> <small> @lang('global.Hide the phone number on the published ads.')</small> </label>
													</div><?php */?>
													<input type="hidden" id="phone_hidden" name="phone_hidden" value="0" />
												</div>
											</div>
                    
											<!-- About Yourself -->
											<div class="form-group">
												<label for="about" class="col-sm-3 control-label"> @lang('global.About Yourself')</label>
												<div class="col-md-9">
													<textarea id="about" name="about" class="form-control" rows="4">{{ old('about', $user->about) }}</textarea>
												</div>
											</div>
											
											<?php /*?><div class="form-group">
											  <label for="phone" class="col-sm-3 control-label">&nbsp;</label>
											  <div class="col-sm-6">
												<div class="checkbox">
												  <label>
												  <input id="receive_newsletter" name="receive_newsletter" value="1"
																						   type="checkbox" {{ (old('receive_newsletter', $user->
												  receive_newsletter)==1) ? 'checked' : '' }}>
												  @lang('global.I want to receive newsletter.') </label>
												</div>
												<div class="checkbox">
												  <label>
												  <input id="receive_advice" name="receive_advice" value="1"
																						   type="checkbox"{{ (old('receive_advice', $user->
												  receive_advice)==1) ? 'checked' : '' }}>
												  @lang('global.I want to receive advice on buying and selling.') </label>
												</div>
											  </div>
											</div><?php */?>
											
											<input type="hidden" id="receive_newsletter" name="receive_newsletter" value="0" />
											<input type="hidden" id="receive_advice" name="receive_advice" value="0" />
                    
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9"></div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary">@lang('global.Update')</button>
												</div>
											</div>
											
										</form>
									</div>
								</div>
							</div>
            
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#collapseB2" data-toggle="collapse"> @lang('global.Settings') </a></h4>
								</div>
								<div class="panel-collapse collapse <?php echo ($errors->has('pass')) ? 'in' : ''; ?>" id="collapseB2">
									<div class="panel-body">
										<form name="settings" class="form-horizontal" role="form" method="POST"
																  action="{{ lurl('account/settings/update') }}">
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											
											<?php /*?>@if( $user->user_type_id  == 2)
											<div class="form-group">
											  <div class="col-sm-12">
												<div class="checkbox">
												  <label>
												  <input id="comments_enabled" name="comments_enabled" value="1"
																						   type="checkbox" {{ ($user->
												  comments_enabled==1) ? 'checked' : '' }}>
												  @lang('global.Comments are enabled on my ads') </label>
												</div>
											  </div>
											</div>
											@endif<?php */?>
											
											<div class="form-group <?php echo ($errors->has('pass')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label"> @lang('global.Current Password') <sup>*</sup> </label>
												<div class="col-sm-9">
													<input id="password" name="password_current" type="password" class="form-control" placeholder="{{ t('Current Password') }}" required="" />
												</div>
											</div>
											
											<div class="form-group <?php echo ($errors->has('pass')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label"> @lang('global.New Password') <sup>*</sup> </label>
												<div class="col-sm-9">
													<input id="password" name="password" type="password" class="form-control" placeholder="{{ t('New Password') }}" required="" />
												</div>
											</div>
											
											<div class="form-group <?php echo ($errors->has('pass')) ? 'has-error' : ''; ?>">
												<label class="col-sm-3 control-label"> @lang('global.Confirm Password') <sup>*</sup> </label>
												<div class="col-sm-9">
													<input id="password_confirmation" name="password_confirmation" type="password" class="form-control" placeholder="{{ t('Confirm Password') }}" required="" />
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" class="btn btn-primary"> @lang('global.Update') </button>
												</div>
											</div>
											
										</form>
									</div>
								</div>
							</div>
            
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#collapseB5" data-toggle="collapse"> @lang('global.Profile Picture Settings') </a></h4>
								</div>
								<div class="panel-collapse collapse <?php echo ($errors->has('pass')) ? 'in' : ''; ?>" id="collapseB5">
									<div class="panel-body">
										<form name="settings" class="form-horizontal" id="upload_photo" role="form" enctype="multipart/form-data" method="POST" action="{{ lurl('account/dp_settings/update') }}">
											{!! csrf_field() !!}
											
											<input name="_method" type="hidden" value="PUT">
											<div class="form-group">
												<label class="col-sm-3 control-label"></label>
												<div class="col-sm-9">
													<div class="col-sm-3" style="padding-left:0;">
													@if(is_file('uploads/pictures/dp/'.$user->photo))
														<div class="profile-pic-div"> 
														<span id="rmv-dp-btn" class="profile_pic_dlt"><i class="fa fa-close"></i></span>
														<img class="profile_pic_img" src="{{ url('uploads/pictures/dp/'.$user->photo) }}" alt="{{ $user->name }} ">
														</div>
													@else
														<img class="profile_pic_img" src="{{ url('images/user.jpg') }}" alt="{{ $user->name }} ">
													@endif
													</div>
													<div class="col-sm-9" style="padding: 8px 10px 5px 25px; background: #f5f5f5; border-bottom: 2px solid #E40046;">
													 <ul>
														<li>{{t('The picture must be a file of type: jpeg, bmp, png')}}</li>
														<li>{{t('The picture may not be greater than 5000 kilobytes.')}}</li>
														<li>{{t('Recommended image resolution is 100 X 100.')}}</li>
													 </ul>
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-3 control-label"> @lang('global.Change Picture') <sup>*</sup></label>
												<div class="col-sm-9">
													<label class="fileContainer">
														<div id="picture_div"> <input type="file" name="picture" id="picture" required="" /> </div>
													</label>
												</div>
											</div>
									
											<div class="form-group">
												<div class="col-sm-offset-3 col-sm-9">
													<button type="submit" id="upload_photo_btn" class="btn btn-primary btn-md">@lang('global.Upload')</button>
												</div>
											</div>
									
										</form>
									</div>
								</div>
							</div>
            
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a href="#collapseB7" data-toggle="collapse"> @lang('global.Interest Settings') </a></h4>
								</div>
								<div class="panel-collapse collapse <?php echo ($errors->has('pass')) ? 'in' : ''; ?>" id="collapseB7">
									<div class="panel-body">
										<form name="in_settings" class="form-horizontal" id="interest_form" role="form" enctype="multipart/form-data" method="POST" action="{{ lurl('account/in_settings/update') }}">
											{!! csrf_field() !!}
											
											<input name="_method" type="hidden" value="PUT">
									
											<div class="form-group" id="interest_div"></br>
												@if(isset($interests) && !empty($interests))
													{{--*/ $i = 1; /*--}}
													@foreach($interests as $interest)
													
														<div class="col-sm-4">
														
															<p style="text-align: left; margin-left: 30px;">
															
															@if($interest->int_img != '')
																<img class="interestIcon" src="{{ url($interest->int_img) }}" />
															@else
																<img class="interestIcon" src="{{ url('uploads/pictures/interest/no_image.png') }}" />
															@endif
															
															<label style="text-align: left; margin-left: 10px; min-width: 50%;"> {{ $interest->int_title }} </label>
															
															<label style="text-align: left;">
																@if($user->interests != '')
																	{{--*/ $interestA = unserialize($user->interests); /*--}}
																	@if(isset($interestA[$interest->translation_of]) && $interestA[$interest->translation_of] == 1)
																		{{--*/ $chkd = "checked='checked'"; /*--}}
																	@else
																		{{--*/ $chkd = ""; /*--}}
																	@endif
																	<input type="checkbox" name="interests[{{ $interest->translation_of }}]" value="1" class="interest_value" id="interests_{{ $i }}" {{ $chkd }} />
																@else
																	<input type="checkbox" name="interests[{{ $interest->translation_of }}]" value="1" class="interest_value" id="interests_{{ $i }}" />
																@endif
															</label>
															
															</p>
															
														</div>
														
													{{--*/ $i++; /*--}}	
													@endforeach
													
												@endif
											</div>
									
											<div class="form-group"></br>
												<div class="col-sm-offset-10 col-sm-2">
													<button type="submit" class="btn btn-primary" id="interest_btn"> @lang('global.Update') </button>
												</div>
											</div>
									
										</form>
									</div>
								</div>
							</div>

							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"> <a href="#collapseB3"  data-toggle="collapse"> @lang('global.Privacy Settings') </a> </h4>
								</div>
								<div class="panel-collapse collapse" id="collapseB3">
									<div class="panel-body">
										<form name="settings" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/pr_settings/update') }}">
											{!! csrf_field() !!}
											
											<input name="_method" type="hidden" value="PUT">
											
											<div class="form-group">
												<div class="col-sm-12">
													<div class="checkbox">
														<label>
															<p><strong>@lang('global.Find Friends')</strong></p>
															<p><input id="find_friends" name="find_friends" value="1" type="checkbox" {{ ($user->find_friends==1) ? 'checked' : '' }}>
															@lang('global.Let others find my profile using my name or email address.')
															<br /><span class="gray">@lang('global.Users added as friends can always find your profile.')</span></p>
														</label>
													</div>
													@if( $user->user_type_id  == 3)
													<div class="checkbox">
														<label>
															<p><strong>@lang('global.Direct Messages from Businesses')</strong></p>
															<p><input id="direct_messages" name="direct_messages" value="1" type="checkbox"{{ ($user->direct_messages==1) ? 'checked' : '' }}>
															@lang('global.Allow business owners to send you direct messages in response to your review.')</p>
														</label>
													</div>
													@endif
													<div class="checkbox">
														<label>
															<p><strong>@lang('global.Profile Viewing Options')</strong></p>
															<span class="gray">@lang('global.Choose wheather you\'re visible or viewing in private mode.')</span></p>
														</label>
													</div>
													<div class="col-sm-offset-1 col-sm-11" id="rec_email_div">
														<div class="checkbox">
															<label>
																<p><input id="anyone" name="profile_view" value="0" type="radio" {{ ($user->profile_view == 0) ? 'checked' : '' }} />
																@lang('global.Anyone')</p>
															</label>
														</div>
														<div class="checkbox">
															<label>
																<p><input id="someone" name="profile_view" value="1" type="radio" {{ ($user->profile_view == 1) ? 'checked' : '' }} />
																@lang('global.Someone in Howlik')</p>
															</label>
														</div>
														<div class="checkbox">
															<label>
																<p><input id="noone" name="profile_view" value="2" type="radio" {{ ($user->profile_view == 2) ? 'checked' : '' }} />
																@lang('global.No One')</p>
															</label>
														</div>
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-offset-0 col-sm-9">
													<button type="submit" class="btn btn-primary">@lang('global.Update')</button>
												</div>
											</div>
											
										</form>
									</div>
								</div>
							</div>
			
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"> <a href="#collapseB4"  data-toggle="collapse"> @lang('global.Email Notification Settings') </a> </h4>
								</div>
								<div class="panel-collapse collapse" id="collapseB4">
									<div class="panel-body">
										<form name="settings" class="form-horizontal" role="form" method="POST" action="{{ lurl('account/en_settings/update') }}">
											{!! csrf_field() !!}
											
											<input name="_method" type="hidden" value="PUT">
											
											<div class="form-group">
												<div class="col-sm-12">
													<div class="checkbox">
														<label>
															<p><input id="receive_emails" name="receive_emails" value="1" type="checkbox" {{ (isset($user_email_notifications['receive_emails']) && $user_email_notifications['receive_emails']==1) ? 'checked' : '' }} /><strong>@lang('global.Receive emails from Howlik')</strong>
															<br />
															<span class="gray">@lang('global.Note: you will still receive certain legal, transactional or administrative emails.')</span></p>
														</label>
													</div>
												</div>
												
												<div class="col-sm-offset-1 col-sm-11" id="rec_email_div">
													<div class="checkbox">
														<label>
															<p><input id="friend_requests" name="friend_requests" value="1" type="checkbox" {{ (isset($user_email_notifications['friend_requests']) && $user_email_notifications['friend_requests']==1) ? 'checked' : '' }} {{ (isset($user_email_notifications['receive_emails']) && $user_email_notifications['receive_emails']==1) ? '' : 'disabled="disabled"' }}  />
															@lang('global.Friend requests.')</p>
														</label>
													</div>
													<div class="checkbox">
														<label>
															<p><input id="messages" name="messages" value="1" type="checkbox" {{ (isset($user_email_notifications['messages']) && $user_email_notifications['messages']==1) ? 'checked' : '' }}  {{ (isset($user_email_notifications['receive_emails']) && $user_email_notifications['receive_emails']==1) ? '' : 'disabled="disabled"' }}/>
															@lang('global.Messages from other users.')</p>
														</label>
													</div>
													<div class="checkbox">
														<label>
															<p><input id="order_updates" name="order_updates" value="1" type="checkbox" {{ (isset($user_email_notifications['order_updates']) && $user_email_notifications['order_updates']==1) ? 'checked' : '' }}  {{ (isset($user_email_notifications['receive_emails']) && $user_email_notifications['receive_emails']==1) ? '' : 'disabled="disabled"' }}/>
															@lang('global.Order Updates.')</p>
														</label>
													</div>
													<div class="checkbox">
														<label>
															<p><input id="disc_promo" name="disc_promo" value="1" type="checkbox" {{ (isset($user_email_notifications['disc_promo']) && $user_email_notifications['disc_promo']=1) ? 'checked' : '' }}  {{ (isset($user_email_notifications['receive_emails']) && $user_email_notifications['receive_emails']==1) ? '' : 'disabled="disabled"' }}/>
															@lang('global.Discounts and promotions.')</p>
														</label>
													</div>
												</div>
											</div>
											
											<div class="form-group">
											  <div class="col-sm-offset-0 col-sm-9">
												<button type="submit" class="btn btn-primary">@lang('global.Update')</button>
											  </div>
											</div>
											
										</form>
									</div>
								</div>
							</div>

						</div>
						<!--/.row-box End-->
					</div>
				</div>
				<!--/.page-content-->
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('javascript')

	@parent
	
	<script language="javascript">
		$(document).ready(function () {
			var countries = <?php echo (isset($countries)) ? $countries->toJson() : '{}'; ?>;
			var countryCode = $('#country').val();
			/* Set Country Phone Code */
			setCountryPhoneCode(countryCode, countries);
			$('#country').change(function () {
				setCountryPhoneCode($(this).val(), countries);
			});
			
			$('#receive_emails').change(function () {
				if(this.checked){
					$("#rec_email_div").find("input[type='checkbox']").prop('disabled', false);
				}else{
					$("#rec_email_div").find("input[type='checkbox']").prop('disabled', true);
				}
			});
			
		});
	</script>
	
	<script language="javascript">
	 
		$(document).ready(function () {
			
			$("#interest_btn").click(function() {
				
				var i;
				var amount	=	'';
				var count 	=	$('.interest_value').length;
				
				for (i = 1; i <= count; i++) {
				
					if($('#interests_'+i).prop( "checked" )) {
					
						amount 	+=	$.trim($('#interests_'+i).val())+'*';
					}
				}
				
				if(amount == '') {
					
					$('#interest_div').addClass("error_border");
					return false;
				}
				else {
					
					$('#interest_div').removeClass("error_border");
					return true;
				}
				
			});
		});	
		
	</script>
	<script language="javascript">
		$("#rmv-dp-btn").click(function(event) {
			event.stopPropagation();
			if(confirm("Do you want to delete?")) {
				this.click;
				$.ajax({
					url: "{{ lurl('account/dp_settings/delete') }}",
					type: 'post',
					data: {'id':"{{ auth()->user()->id }}"},
					dataType:'json',
					success: function(data)
					{
						location.reload();
						$('.del-msg').show();
					},
					error : function(xhr, status,data){
						return false;
					}
				});
			}
			else
			{
			   return false;
			}       
			event.preventDefault();
		});
	</script>
	
@endsection 
