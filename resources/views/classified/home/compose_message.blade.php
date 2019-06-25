@extends('classified.layouts.layout')  
<style>
	.Messaging_section {
		width: 45%;
		float: left;
	}
	.message_box {
		width: 100%;
		float: left;
		margin-top: 5%;
		margin-bottom: 14px;
	}
	.autocomplete-suggestions {
	    min-height: 40px !important;
	}

</style>
@section('content') 

<div class="listing_holder">
	<div class="container"><br>
		<div class="Messaging_section"> 
			<div class="event_tab">
				@if(Session::has('flash_notification.message'))
					<div class="row">
						<div class="col-lg-12">
							@include('flash::message')
						</div>
					</div>
				@endif
				<form method="POST" action="send-compose" class="compose-message-form">
					<input type="hidden" id="lang" value="{{ Request::segment(1) }}" />
					<input type="hidden" name="_token" value="{{ csrf_token() }}" />
					<input type="hidden" name="_email" value="{{ $user->email }}" class="user-email" />
					<div class="form-group">
					
						<div class="col-md-12">
							<div class="row">
								<label>@lang('global.To')<sup>*</sup></label>
								<input type="hidden" class="form-control" name="tomail" id="tomail" />
								<div class="multiple-val-input">
									<ul>
										<input type="text" class="emailinput" />
										<span class="input_hidden" style="width: 95% !important;"></span>
									</ul>
								</div>
							</div>
						</div>
						
						<label>@lang('global.Subject')<sup>*</sup></label>
						<input type="text" class="form-control" name="subject" id="subject" />
			  
						<label>@lang('global.Message')<sup>*</sup></label>
						<textarea name="message" id="message" rows="7" class="form-control"></textarea>
	
						<div class="message_box">
							<a href="javascript:window.history.back();" class="btn btn-default btn-md">@lang('global.Cancel')</a>
							<button type="submit" class="btn btn-primary btn-md">@lang('global.Send Message')</button>
						</div>
					</div>	
				</form>	
			</div>
		</div>
	</div>
	<br>
	
	<script>
		var value = '';
		$('.multiple-val-input').on('click', function(){
			$(this).find('input:text').focus();
		});
		$('.multiple-val-input ul input:text').on('input propertychange', function(){
			$(this).siblings('span.input_hidden').text($(this).val());
			var inputWidth = $(this).siblings('span.input_hidden').width();
			$(this).width(inputWidth);
		});
		$(document).on('click','.multiple-val-input ul li a', function(e){
			e.preventDefault();
			$(this).parents('li').remove();
		});
		function isValidEmailAddress(toAppend) {
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			return pattern.test(toAppend);
		}
		function remove(toAppend) {
			$("input#tomail").val($("input#tomail").val().replace(toAppend+",", ""));
			var str = toAppend.toString()+',';
			value = value.replace(str,'').trim();
		}
	</script>
	<script>
		$( ".compose-message-form" ).submit(function (event) {
			if($.trim($("#tomail" ).val()) == "" ) {
				$(".emailinput").focus();
				return false;
			} else if($.trim($(".input_hidden" ).html()) == "" ) {
				$(".emailinput").focus();
				return false;
			} else if($.trim($("#subject" ).val()) == "") {
				$("#subject").focus();
				return false;
			} else if($.trim($("#message" ).val()) == "") {
				$("#message").focus();
				return false;
			} else {
				return true;
			}
		});
	</script>
@stop