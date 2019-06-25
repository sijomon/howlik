{{--

 * LaraClassified - Geo Classified Ads CMS

 * Copyright (c) Mayeul Akpovi. All Rights Reserved

 *

 * Email: mayeul.a@larapen.com

 * Website: http://larapen.com

 *

 * LICENSE

 * -------

 * This software is furnished under a license and may be used and copied

 * only in accordance with the terms of such license and with the inclusion

 * of the above copyright notice. If you Purchased from Codecanyon,

 * Please read the full License from here - http://codecanyon.net/licenses/standard

--}}

@extends('classified.layouts.layout')



@section('content')

	<div class="main-container">

		<div class="container">

			<div class="row">

            

             @if( $user->user_type_id  == 2)

            

				<div class="col-sm-3 page-sidebar">

					@include('classified/account/inc/sidebar-left')

				</div>

                

              @endif 

                

				<!--/.page-sidebar-->



				<div class="<?php if($user->user_type_id  == 2) { ?> col-sm-9 <?php  }else{ ?> col-sm-12  <?php } ?>page-content">



					@include('flash::message')



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



					<div class="inner-box">

						<div class="row">

							<div class="col-md-5 col-xs-4 col-xxs-12">

								<h3 class="no-padding text-center-480 useradmin">

									<a href="">

										<!--<img class="userImg" src="{{ url('images/user.jpg') }}" alt="user">&nbsp;-->

										<img class="userImg" src="{{ $gravatar }}" alt="user">&nbsp;

										{{ $user->name }}

									</a>

								</h3>

							</div>

                            

                            @if (count($errors) > 0)

                            

							<div class="col-md-7 col-xs-8 col-xxs-12">

								<div class="header-data text-center-xs">

									<!-- Traffic data -->

									<div class="hdata">

										<div class="mcol-left">

											<!-- Icon with red background -->

											<i class="fa fa-eye ln-shadow"></i>

										</div>

										<div class="mcol-right">

											<!-- Number of visitors -->

											<p>

												<a href="{{ lurl('account/myads') }}">{{ $ad_counter->total_visits or 0 }}</a>

												<em>{{ trans_choice('global.visits', (isset($ad_counter) ? $ad_counter->total_visits : 0)) }}</em>

											</p>

										</div>

										<div class="clearfix"></div>

									</div>



									<!-- Ads data -->

									<div class="hdata">

										<div class="mcol-left">

											<!-- Icon with green background -->

											<i class="icon-th-thumb ln-shadow"></i>

										</div>

										<div class="mcol-right">

											<!-- Number of ads -->

											<p>

												<a href="{{ lurl('account/myads') }}">{{ \App\Larapen\Models\Ad::where('user_id', $user->id)->count() }}</a>

												<em>@lang('global.Ads')</em>

											</p>

										</div>

										<div class="clearfix"></div>

									</div>



									<!-- Favorites data -->

									<div class="hdata">

										<div class="mcol-left">

											<!-- Icon with blue background -->

											<i class="fa fa-user ln-shadow"></i>

										</div>

										<div class="mcol-right">

											<!-- Number of favorites -->

											<p>

												<a href="{{ lurl('account/favourite') }}">{{ \App\Larapen\Models\SavedAd::where('user_id', $user->id)->count() }}</a>

												<em>@lang('global.Favorites') </em>

											</p>

										</div>

										<div class="clearfix"></div>

									</div>

								</div>

							</div>

                            

                            

                             @endif

						</div>

					</div>



					<div class="inner-box">

						<div class="welcome-msg">

							<h3 class="page-sub-header2 clearfix no-padding">@lang('global.Hello') {{ $user->name }} ! </h3>

							<span class="page-sub-header-sub small">@lang('global.You last logged in at')

								: {{ $user->last_login_at->format('d-m-Y H:i:s') }}</span>

						</div>

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

												<div class="col-md-9">

													@foreach ($genders as $gender)

														<label class="radio-inline" for="gender">

															<input name="gender" id="gender-{{ $gender->tid }}" value="{{ $gender->tid }}"

																   type="radio" {{ (old('gender', $user->gender_id)==$gender->tid) ? 'checked="checked"' : '' }}>

															{{ $gender->name }}

														</label>

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

															Select your Country...

														</option>

														@foreach ($countries as $item)

															<option value="{{ $item->get('code') }}" {{ (old('country', $user->country_code)==$item->get('code')) ? 'selected="selected"' : '' }}>

																{{ $item->get('name') }}

															</option>

														@endforeach

													</select>

												</div>

											</div>



											<div class="form-group required <?php echo ($errors->has('phone')) ? 'has-error' : ''; ?>">

												<label for="phone" class="col-sm-3 control-label">@lang('global.Phone') <sup>*</sup></label>

												<div class="col-sm-6">

													<div class="input-group"><span id="phone_country" class="input-group-addon">+000</span>

														<input id="phone" name="phone" type="text" class="form-control" placeholder=""

															   value="{{ old('phone', $user->phone) }}">

													</div>

													<div class="checkbox">

														<label>

															<input name="phone_hidden" type="checkbox"

																   value="1" {{ (old('phone_hidden', $user->phone_hidden)=='1') ? 'checked="checked"' : '' }}>

															<small> @lang('global.Hide the phone number on the published ads.')</small>

														</label>

													</div>

												</div>

											</div>



											<!-- About Yourself -->

											<div class="form-group">

												<label class="col-md-3 control-label" for="about">@lang('global.About Yourself')</label>

												<div class="col-md-9">

													<textarea id="about" name="about" class="form-control"

															  rows="4">{{ old('about', $user->about) }}</textarea>

												</div>

											</div>



											<div class="form-group">

												<label for="phone" class="col-sm-3 control-label">&nbsp;</label>

												<div class="col-sm-6">

													<div class="checkbox">

														<label>

															<input id="receive_newsletter" name="receive_newsletter" value="1"

																   type="checkbox" {{ (old('receive_newsletter', $user->receive_newsletter)==1) ? 'checked' : '' }}>

															@lang('global.I want to receive newsletter.')

														</label>

													</div>



													<div class="checkbox">

														<label>

															<input id="receive_advice" name="receive_advice" value="1"

																   type="checkbox"{{ (old('receive_advice', $user->receive_advice)==1) ? 'checked' : '' }}>

															@lang('global.I want to receive advice on buying and selling.')

														</label>

													</div>

												</div>

											</div>



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

											

                                              @if( $user->user_type_id  == 2)

                                            

                                            <div class="form-group">

												<div class="col-sm-12">

													<div class="checkbox">

														<label>

															<input id="comments_enabled" name="comments_enabled" value="1"

																   type="checkbox" {{ ($user->comments_enabled==1) ? 'checked' : '' }}>

															@lang('global.Comments are enabled on my ads')

														</label>

													</div>

												</div>

											</div>

                                            @endif



											<div class="form-group <?php echo ($errors->has('pass')) ? 'has-error' : ''; ?>">

												<label class="col-sm-3 control-label">@lang('global.New Password')</label>

												<div class="col-sm-9">

													<input id="password" name="password" type="password" class="form-control" placeholder="Password">

												</div>

											</div>



											<div class="form-group <?php echo ($errors->has('pass')) ? 'has-error' : ''; ?>">

												<label class="col-sm-3 control-label">@lang('global.Confirm Password')</label>

												<div class="col-sm-9">

													<input id="password_confirmation" name="password_confirmation" type="password"

														   class="form-control" placeholder="Password confirmation">

												</div>

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



							<?php /*

						<div class="panel panel-default">

							<div class="panel-heading">

								<h4 class="panel-title"> <a href="#collapseB3"  data-toggle="collapse"> @lang('global.Preferences') </a> </h4>

							</div>

							<div class="panel-collapse collapse" id="collapseB3">

								<div class="panel-body">

									<div class="form-group">

										<div class="col-sm-12">

											<div class="checkbox">

												<label>

													<input id="receive_newsletter" name="receive_newsletter" value="1" type="checkbox" {{ ($user->receive_newsletter==1) ? 'checked' : '' }}>

													@lang('global.I want to receive newsletter.')

												</label>

											</div>



											<div class="checkbox">

												<label>

													<input id="receive_advice" name="receive_advice" value="1" type="checkbox"{{ ($user->receive_advice==1) ? 'checked' : '' }}>

													@lang('global.I want to receive advice on buying and selling.')

												</label>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

 						*/

							?>



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

		});

	</script>

@endsection

