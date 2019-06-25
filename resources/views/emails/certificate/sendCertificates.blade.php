<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="robots" content="noindex" />
		<meta name="googlebot" content="noindex" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	
	<body>
		<table class="body-wrap"  style="font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 20px;">
			<tr style="font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
				<td style="font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
				<td class="container" style=" font-size: 100%; line-height: 1.6em; clear: both !important; display: block !important; max-width: 600px !important; Margin: 0 auto; padding:0px;">
					<div class="row" style="margin-bottom:20px">
						<h3 style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; line-height: 1.2em; color: #111111; font-weight: bold; margin: 0 0 10px; padding: 0;"> 
							@lang('global.Congratulations') {{ $recipient }}! 
						</h3>
						<p> @lang('global.You have received a Gift Certificate from') {{ $sender }}. </p>
					</div>
					<div class="row" style="background: url('http://www.howlik.com/uploads/pictures/bg-gift.jpg') no-repeat; background-size: cover;  border: 1px solid #e5e5e5;">
						<div class="content" style="font-size: 100%; line-height: 1.6em; display: block; max-width: 600px; margin: 0 auto; padding: 0;">
							<table style="font-size: 100%; line-height: 1.6em; width: 100%; margin: 0; padding: 0;">
								<tr style="font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
									<td style="font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
										<table cellpadding="0" cellspacing="0" border="0" >
											<tr>
												<td>
													<div class="modal-content" style=" ">
														<div class="modal-header" style="padding:0 0 15px; border-bottom: 1px solid #e5e5e5; ">
															<h2 class="modal-title" style="text-align:center; color:#e40046; font-size:18px; font-weight:bold; margin-bottom:0"> 
																@lang('global.Gift Certificate')
															</h2>
														</div>
														<div class="modal-body" style="width: 100%; float: left; padding:0 20px;" >
															<div  style=" float: left; width:45%; overflow:hidden">
																<h2 style="margin-bottom:0"> @lang('global.Gift Certificate') </h2>
																<h4 style="margin-top:0"> @lang('global.at') {{ $title }} @if(isset($location)), &nbsp;<small>{{ $location }}</small>@endif</h4>
																	
																<!-- Picture setting -->

																{{--*/ $bizImg = ''; /*--}}
																
																@if(isset($biz) && $biz > 0) 
																	{{--*/ $bizId = $biz; /*--}} 
																@else
																	{{--*/ $bizId = ''; /*--}}
																@endif
																
																{{--*/ $pictures = \App\Larapen\Models\BusinessImage::where('biz_id', $bizId); /*--}}

																{{--*/ $countPictures = $pictures->count(); /*--}}

																@if ($countPictures > 0)

																	@if (is_file(public_path() . '/uploads/pictures/'. $pictures->first()->filename))

																		{{--*/ $bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename); /*--}}

																	@endif

																	@if ($bizImg=='')

																		@if (is_file(public_path() . '/'. $pictures->first()->filename))

																			{{--*/ $bizImg = url('pic/x/cache/medium/' . $pictures->first()->filename); /*--}}

																		@endif

																	@endif

																@endif

																<!-- Default picture -->

																@if ($bizImg=='')

																	{{--*/ $bizImg = url('pic/x/cache/medium/' . config('larapen.laraclassified.picture')); /*--}}

																@endif		
																
																<img src="{{ url($bizImg) }}" class="image-modal" style="width: 100%; border: 5px solid #ccc; border-radius: 2px;" />
																
															</div>
															
															<div  style=" float: right; padding:0 20px 20px; width:45%;">
																<h5 style="margin-bottom:0"> @lang('global.From') : </h5>
																<h3 id="modal_from" style="margin-top:0"> {{ $sender }} </h3> 
																
																<h5 style="margin-bottom:0"> @lang('global.To') : </h5>
																<h3 id="modal_to" style="margin-top:0"> {{ $recipient }} </h3>
																
																<h5 style="margin-bottom:0"> @lang('global.Gift Code') : </h5>
																<h3 id="modal_code" style="margin-top:0"> {{ $code }} </h3>  
															</div>
														</div> 
														<div class="modal-footer" style="float: left; width: 100%; padding: 0 0 30px;">
															<img src="http://www.howlik.com/uploads/app/logo/logo2.png" style="float:right; width:80px; margin-right:15px; margin-top:36px" >
														</div>
													</div>
												</td>						
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div> 
					</div> 
					<div class="row" style="margin-bottom:20px">
						<p style="font-family: 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif; font-size: 15px; " > 
							@lang('global.Thank You!') 
						</p>       
					</div>
				</td>
				<td style="font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;"></td>
			</tr>
		</table>
	</body>
</html>
