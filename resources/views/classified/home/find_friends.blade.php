@extends('classified.layouts.layout')
<style>
	.MBT-FB a {
	  font-family: tahoma, verdana, arial, sans-serif !important;
	  font-weight:bold !important;
	  font-size:12px !important;
	  width:300px !important;
	  border:solid #263961 1px !important;
	  border-bottom:solid #29447e 1px !important;
	  cursor:pointer !important;
	  padding:6px 6px 6px 6px !important;
	  background-color:#29447e !important;
	  border-top:solid #263961 1px !important;
	  text-align:center !important;
	  color:#fff !important;
	  text-decoration:none  ! important;
	}
	.MBT-FB a:active {
	  background-color:#4f6aa3 !important;
	} 
	.hidden{display:none;}
	div#main-list li {
		list-style: none;
	}	
	.invite input {
		margin-bottom: 17px;
		height: 32px;
	}
	.invite {
		width: 100% !important;
		
	}
	.direct_invite span {
		color: #0073bb;
		cursor: pointer;
	}
	.message_box {
		margin-top: 10px;
	}
	.input-delete{
		background-color: #fff;
		background-image: none;
		border: 1px solid #ddd;
		border-radius: 4px;
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
		color: #555;
		display: block;
		font-size: 12px;
		height: 43px;
		line-height: 1.42857;
		padding: 6px 12px;
		transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
		width: 80%;
		float:left;
	}
	.btn-delete{
		width:100px;
		height: 36px !important;
		margin-bottom:20px;
		margin-left:2px;
	}
	#btn-del {
		margin-top: -10px;
		margin-bottom: 5px;
	}
.invite-link-to{
    width: auto !important;
    padding: 0 !important;
    margin-top: 0 !important;
    float: none !important;
	}
	.btn-del-right{
		position: absolute;
    	float: right;
		padding: 7px !important;
		margin: 2px !important;
		right:0;
	}
	.add-email-addr{
		cursor:pointer;
		color:#009;
	}
	.add-email-div{
		float:left;
		width:100%;
		height:auto;
		position:relative;
	}
</style>
<script src='https://connect.facebook.net/en_US/all.js'></script>
<script src="https://apis.google.com/js/client.js"></script>
<script src="//js.live.net/v5.0/wl.js"></script>

@section('content') 
	<!--listing holder start-->
	<div class="container-fluid">
		<div class="container">
			<div class="vertical-tab">
				@if(Session::has('flash_notification.message'))
					<div class="row">
						<div class="col-lg-12">
							@include('flash::message')
						</div>
					</div>
				@endif
				<h4> @lang('global.Find Friends') </h4>
				<div class="row">
					<div class="col col-sm-3 vertical-click">
						<ul class="nav nav-tabs nav-stacked text-center" role="tablist">
							<li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"> @lang('global.On Facebook') </a></li>
							<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"> @lang('global.In Your Email Contacts') </a></li>
							<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"> @lang('global.Invite Friends to Howlik') </a></li>
						</ul>
						<div class="friend-search fsearch">
							<h4> @lang('global.Search friends on Howlik') </h4>
							<form method="POST" action="{{lurl('post-friend')}}" id="post-friend-form">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="text" name="friend" id="friend-search" placeholder="{{ t('e.g. example@email.com') }}"/>
								<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
							</form>
						</div>
					</div>
					<div class="col col-sm-9">
						<div class="row tab-content vertical-content">
							<div role="tabpanel" class="tab-pane fade active in" id="home">
								<h4> @lang('global.You haven’t connected with your friends on Facebook yet!') </h4>
								<p> @lang('global.You may have signed up with your Facebook account, but Howlik still needs your permission to see your friends list. Mind sharing? Doing so will make it easy to stay connected to all the awesome things your friends are doing on Howlik.') </p>
								<div id='fb-root'></div>
								<span class='MBT-FB'>
								 <a href='javascript:;' onclick='FacebookInviteFriends();'><i class="fa fa-facebook" aria-hidden="true"></i> @lang('global.Find Your Facebook Friends on Howlik') </a>
								</span>
							</div>
							<div role="tabpanel" class="tab-pane fade" id="profile">
								<div class="mails_div">
									<div class="abc">
										<a href="javascript:;"onclick="auth();">
											<img class="u-block" src="{{ url('/assets/frontend/images/gmail.png') }}">
											@lang('global.Gmail')
										</a>
									</div>
									<div class="abc">
										<a href="<?php echo $url;?>">
											<img class="u-block" src="{{ url('/assets/frontend/images/yahoo.png') }}">
											@lang('global.Yahoo')
										</a>
									</div>
									<div class="abc">
										<a href="javascript:;" onclick="importoutlook();">
											<img class="u-block" src="{{ url('/assets/frontend/images/outlook.png') }}">
											@lang('global.Outlook')
										</a>
									</div>
									<div class="abc">
										<a href="javascript:;">
											<img class="u-block" src="{{ url('/assets/frontend/images/aol.png') }}">
											@lang('global.AOL')
										</a>
									</div>
									<p> @lang('global.Don’t see your email provider here? Don’t worry, you can still')<a href="#messages" aria-controls="messages" role="tab" data-toggle="tab" class="invite-link-to">@lang('global.invite your friends to Howlik.')</a></p>
								</div>
								<div class="alert alert-danger invite-social-form-error-msg" style="display: none;"> @lang('global.Select Atleast One Contact.') </div>
								<form action="{{lurl('invite-friends')}}" method="Post" class="invite-social-form">
									<div class="gmail-frnds  hidden">
										<label class="select_all " >
											<input type="checkbox"  id="checkAll"/> @lang('global.Select All')
										</label>
										<div class="main-list " id="main-list" >
											<ul class="contact-list" id="contact-list"></ul>
										</div>
										<button type="submit" class="btn btn-primary btn-lg" id="send"> @lang('global.Send Friend Request') </button>
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
										<input type="hidden" name="invited_by" value="<?php echo auth()->user()->id;?>">
									</div>
								</form>
								
							</div>
							<div role="tabpanel" class="tab-pane fade" id="messages">
								<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>-->
								<div class="direct_invite">
									<form method="Post" action="{{lurl('invite-friends')}}" class="invite-friends-form">
										<div class="col-md-6" >
											<div class="invite">
												<label> @lang('global.Email Address')<sup>*</sup></label>
												<input type="email" class="form-control invite-input" id="invite-1" name="invite1[]" placeholder="{{ t('e.g. example@email.com') }}">
												<input type="email" class="form-control invite-input" id="invite-2" name="invite1[]" placeholder="{{ t('e.g. example@email.com') }}">
												<input type="email" class="form-control invite-input" id="invite-3" name="invite1[]" placeholder="{{ t('e.g. example@email.com') }}">
												<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
											  <div id="email-text"></div>
										
											<p onclick="add_text();" class="add-email-addr"> @lang('global.Add another email address') </p>
											<input type="hidden" name="invited_by" value="<?php echo auth()->user()->id;?>">
											<div class="message_box">
												<button type="submit" class="btn btn-primary"> @lang('global.Send Message') </button> 
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        </div>
	</div>

	<!-- BOF JAVASCRIPT --> 
	<script type="text/javascript">

		/* Import Outlook contacts*/

		WL.init({
			client_id: '87158c1c-e588-4bd4-8f13-7495c07dd1ad',
			redirect_uri: "{{ url('/') }}/en/find_friends",
			scope: ["wl.basic","wl.contacts_emails"],
			response_type: "token"
		});

		function importoutlook()
		{
			WL.login({
				scope: ["wl.basic", "wl.contacts_emails"]
			}).then(function (response) 
			{
				WL.api({
					path: "/me/contacts",
					method: "GET"
				}).then(
					function (response) {
							//your response data with contacts 
						console.log(response.data);
					},
					function (responseFailed) {
						//console.log(responseFailed);
					}
				);
				
			},
			function (responseFailed) 
			{
				//console.log("Error signing in: " + responseFailed.error_description);
			});
		}
	</script>
	<script>

		$("#checkAll").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});

		/* Function to add additonal textbox.*/ 
		var numAdd	= 1;
		var inc = 4;
		var add_text = function() {
			
			if($.trim($("#invite-1").val()) == "") {
				$("#invite-1").focus();
				return false;
			} else if($.trim($("#invite-2").val()) == "") {
				$("#invite-2").focus();
				return false;
			} else if($.trim($("#invite-3").val()) == "") {
				$("#invite-3").focus();
				return false;
			} else {
				
				if (numAdd >= 8) return;
				$('#email-text').append('<div class="add-email-div"><input type="email" class="form-control input-delete" id="invite-'+inc+'" name="invite1[]" placeholder="{{ t("e.g. example@email.com") }}" /><button onclick="del(this)" class="btn btn-sm btn-del-right"><i class="fa fa-close"></i></button></div>');
				numAdd++;
				inc++;
				return true;
			}
		};

		var del = function(btn) {
			$(btn).parent().remove();
		};
			
		/*************/
	</script>
	<script type="text/javascript">

		/* Bof Get Google Contacts */
		function auth() {
			var config = {
			  'client_id': '976415397008-n8kumlhdr8qa1r2jpgaqd578agqbusmi.apps.googleusercontent.com',
			  'scope': 'https://www.google.com/m8/feeds'
			};
			gapi.auth.authorize(config, function() {
			  fetch(gapi.auth.getToken());  
			 
			});
		}
		
		function fetch(token) {
			$.ajax({
				url: "https://www.google.com/m8/feeds/contacts/default/full?access_token=" + token.access_token + "&alt=json",
				dataType: "jsonp",
				success:function(data) {
					// display all your data in console
					console.log(data);
					//console.log(data.feed.entry[0].gd$email[0].address);
					//console.log(data.feed.entry[0].title.$t);
					var txt = "";
					$.each(data.feed.entry, function (index1, value1) {
						console.log(value1.gd$email[0].address);
						console.log(value1.title.$t);
						if(value1.title.$t != "") {
							txt += "<li><label><span><input type='checkbox' class='invite1-emails' name='invite1[]' value="+value1.gd$email[0].address+"/></span><span class='email_name'>"+value1.title.$t+"</span><span class='email_address'>"+value1.gd$email[0].address+"</span></label></li>";
						}
					});
					if(txt != "") {
						$("#contact-list").append(txt);
						$(".gmail-frnds").removeClass("hidden");
						$(".mails_div").addClass("hidden");	 
					}
				}
			});
		}
		/* Eof Get Google Contacts */
	</script>
	<script> 
		/* Bof Get Facebook Contacts */
		FB.init({
			appId:'1142198975815695',
			cookie:true,
			status:true,
			xfbml:true
		});
		function FacebookInviteFriends() {
			FB.ui({
				method: 'send',
				message: 'Invite your friends',
				link: "{{ url('/') }}/en",
			},function(response) {
				if (response) {
					console.log(response);
					//alert('Successfully Invited');
				} else {
					console.log(response);
					//alert('Failed To Invite');
				}
			});
		}
		/* Eof Get Facebook Contacts */
	</script>
	<script type='text/javascript'>
		if (top.location!= self.location)
		{
			top.location = self.location
		}
	</script>
	<script>
		$(document).ready(function () {

			/* Bof Get Yahoo Contacts */
			
			var txt = "";
			var arrayFromPHP = <?php if(!empty($yahoo_contact)) {echo json_encode($yahoo_contact);} ?>;
			$.each(arrayFromPHP, function (index1, value1) {
				 //console.log(value1);
				var val2 = value1.split(':');
				console.log(val2[1]);
				if(val2[1] != "") 
				{
					//console.log(val2[1]);
					txt += "<li><label><span><input type='checkbox' name='invite1[]' value="+val2[0]+"/></span><span class='email_name'>"+val2[1]+"</span><span class='email_address'>"+val2[0]+"</span></label></li>";
				}
			});
			if(txt != "") {
				$("#contact-list").append(txt);
				$(".gmail-frnds").removeClass("hidden");
				$(".mails_div").addClass("hidden");	 
			}				
			/* Eof Get Yahoo Contacts */

			$(".next-step").click(function (e) {

				var $active = $('.nav-tabs li.active');
				$active.next().removeClass('disabled');
				nextTab($active);

			});
			$(".prev-step").click(function (e) {

				var $active = $('.nav-tabs li.active');
				prevTab($active);

			});
		});
		function nextTab(elem) {
			$(elem).next().find('a[data-toggle="tab"]').click();
		}
		function prevTab(elem) {
			$(elem).prev().find('a[data-toggle="tab"]').click();
		}
	</script>
	<script>
		$( ".invite-social-form" ).submit(function (event) {
			
			if($.trim($("input:checkbox[name='invite1[]']:checked").val()) == "") {
				$(".invite-social-form-error-msg").show();
				return false;
			} else {
				$(".invite-social-form-error-msg").hide();	 
				return true;
			}
			
		});
		
		$( ".invite-friends-form" ).submit(function (event) {
			if($.trim($("#invite-1" ).val()) == "") {
				$("#invite-1").focus();
				return false;
			} else {
					 
				return true;
			}
		});
	</script>
	<!-- EOF JAVASCRIPT --> 
@stop





    
	