@extends('classified.layouts.layout')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.cs">
<style>
	.message_list ul li {
		list-style: none;
		float: left;
		margin-right: 11px;
	}
	.img_inner.inner.compose {
		float: right;
		bottom: 31px;
		position: relative;
		width: 50%;
		text-align:right;
	}
	.message-operation-div{
		float:left;
		margin:10px 0;
		border-bottom:1px solid #ccc;
		border-top:1px solid #ccc;
		width:100%;
		padding: 10px 0;
	}
	.fsize-14{
		font-size:14px !important;
	}
	.message-row{
		border-bottom: 1px solid #f6f6f6;
		background: #f6f6f6;
		box-shadow: 0 1px 1px 0 #ccc;
		margin-bottom: 5px;
		float: left;
		width: 100%;
	}
	.message-check{
		float:left;
		width:2%;
	}
	.message-check input[type=checkbox]{
		margin-top:15px;
	}
	.message-img{
		float:left;
		width:5%;
	}
	.message-img img{
		width:40px;
		height:40px;
		border-radius:100px;
	}
	.message-sender{
		width:20%;
		float:left;
	}
	.message-sender p{
		margin:10px 0;
	}
	.message-content{
		width:50%; 
		float:left;
		overflow:hidden;
		height:49px;
	}  
	.message-dateinfo{
		width:20%;
		float:right !important;
	}
	.message-dateinfo p{
		text-align:right;
		color:#666 !important;
		padding-right:10px;
		margin:10px 0;
		font-weight:400;
		font-size:14px;
	}
</style>
@section('content') 
<!-- BOF LISTING HOLDER -->
<div class="listing_holder">
	<div class="container">
		<div class="Trending_section"> 
			<div class="event_tab">
				<!-- BOF SHOW SUCCESS MESSAGES -->
				<div class="row yes-msg" style="display:none;">
					<div class="col-lg-12">
						<div class="alert alert-success">
						  <strong> @lang('global.Your Message Deleted Successfully.') </strong>
						</div>
					</div>
				</div>
				<!-- EOF SHOW SUCCESS MESSAGES -->
				
				<ul class="nav nav-tabs">
					<li class="active" ><a data-toggle="tab" href="#home" id="inbox-link">@lang('global.Inbox')<span class="badge ml-05" style="margin-left:5px;">@if(isset($inbox)) {{ count($inbox) }} @endif</span></a></li>
					<li><a data-toggle="tab" href="#menu1" id="sent-link">@lang('global.Sent')<span class="badge ml-05" style="margin-left:5px;">@if(isset($sent)) {{ count($sent) }} @endif</span></a></li>
                    <a href="{{ lurl('compose_message') }}"><button type="submit" class="btn btn-primary pull-right btn_CPSE" style="background:#FFF">@lang('global.Compose')</button></a>
                </ul>
				<div class="tab-content">
					
					<!-- BOF INBOX TAB -->
					<div id="home" class="tab-pane fade  <?php if (!count($errors) > 0): echo 'in active'; endif; ?>">
						<div class="events_holder events mt-20">
							<div class="latest_events">
								<div class="message_list">
									<!--<span> Want to communicate on a more personal level with your Howlik friends? Send a message now!</span>-->
									<ul>
										@if(!empty($inbox))
										<div class="message-operation-div">
											<ul class="list-inline">
												<li><input type="checkbox" name="inbox" value="1" style="margin-left: 8px; margin-right: 10px;" id="inbox-check-all" /></li>
												<li class="pull-right"><button class="inbox_delete_btn"> @lang('global.Delete') </button></li>
											</ul>
										</div>
										@endif
										
										<table id="example" class="table fsize-14">
											<tbody>
											@if(!empty($inbox))
												@foreach($inbox as $in)
													<tr class="message-row">
														<td class="message-check"><input type="checkbox" name="inbox_messages" value="{{ $in->id }}" /></td>
														<td class="message-img">
															@if($in->photo != '')
																<img src="{{ url('/uploads/pictures/dp/'.$in->photo) }}"/>
															@else
																<img style="height: 40px; border-radius: 50%;" src="{{ url('/uploads/pictures/user-icon.png') }}"/>
															@endif
														</td>
														<td class="message-sender"><p>@lang('global.From'): <span style="color:#337ab7"> {{ $in->name }} @if($in->count > 1) ({{ $in->count - 1 }}) @endif</span></p></td>
														
														<td class="message-content"><a href="{{ lurl('view-message/'.$in->id) }}" style="width:100%;float:left;" onclick="read({{ $in->id }})"><span> @if($in->notify > 0) @lang('global.RE'): @endif {{ $in->subject }} </span>  </a>                                 
															<span class="text">{{ str_limit($in->message, 100) }}</span>
														</td>
														<td class="message-dateinfo"> <p>{{ date("M d h:i A", strtotime($in->cre_at)) }}</p></td>
													</tr>
												@endforeach
											@endif
											</tbody> 
										</table>
										
										@if(empty($inbox))
											<br><span>@lang('global.Want to communicate on a more personal level with your Howlik friends? Send a message now!')</span>
										@endif	
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- EOF INBOX TAB -->
	  
					<!-- BOF SEND TAB -->
					<div id="menu1" class="tab-pane fade">
						<div class="latest_events mt-20">
							<div class="message_list">
								<!--<span>Want to communicate on a more personal level with your Howlik friends? Send a message now!</span>-->
								<ul>
									@if(!empty($sent))
									<div class="message-operation-div">
										<ul class="list-inline">
											<li><input type="checkbox" value="1" style="margin-left: 8px; margin-right: 10px;" id="sendbox-check-all" /></li>
											<li class="pull-right"><button class="send_delete_btn"> @lang('global.Delete') </button></li>
										</ul>
									</div>
									@endif
									
									<table id="example" class="table" cellspacing="0" width="100%">							  
										<tbody>
										@if(!empty($sent))
											@foreach($sent as $se)
												<tr class="message-row">
													<td class="message-check"><input type="checkbox" name="sendbox_messages" value="{{ $se->id }}" /></td>
													<td class="message-img">
														@if($se->photo != '')
															<img style="height: 40px; border-radius: 50%;" src="{{ url('/uploads/pictures/dp/'.$se->photo) }}"/>
														@else
															<!-- <img style="height: 40px;" src="/assets/frontend/images/user_60_square.png"/> -->
															<img style="height: 40px; border-radius: 50%;" src="{{ url('/uploads/pictures/user-icon.png') }}"/>
														@endif
													</td>
													<td class="message-sender"><p>@lang('global.To'): <span style="color:#337ab7"> {{ ucfirst($se->name) }} @if($se->count > 1) ({{ $se->count - 1 }}) @endif</span></p></td>
													<td class="message-content"><a href="view-message/{{ $se->id }}" style="width:100%;float:left;"> {{ $se->subject }}</a>                                 
														{{ str_limit($se->message, 100) }}
													</td>
													<td class="message-dateinfo"><p>{{ date("M d h:i A", strtotime($se->cre_at)) }}</p></td>
												</tr>  
											@endforeach    
										@endif
										</tbody>
									</table>
									
									@if(empty($sent))
										<br><span>@lang('global.Want to communicate on a more personal level with your Howlik friends? Send a message now!')</span>
									@endif	
								</ul>
							</div>
						</div>
					</div>
					<!-- EOF SEND TAB -->
				</div>
			</div>
		</div>
    </div>
</div>
<!-- EOF LISTING HOLDER -->


<!-- BOF JAVASCRIPT --> 
<script language="javascript">

	$(document).ready(function() {
		$('#example').DataTable();
	});
				
	var countries = {};
	var countryCode = 'IN';
	var lang = {
		'select': {
			'country': "Select a country",
			'loc': "Select a location",
			'subLocation': "Select a sub-location",
			'city': "Select a city"
		}
	};
	
	var loc = '0';
	var subLocation = '0';
	var city = '0';
	var hasChildren = '';
	
</script>
<script>
	$("#inbox-check-all").click(function (e) {
		 $('input[name=inbox_messages]:checkbox').prop('checked', this.checked);  
	});
	$("#sendbox-check-all").click(function (e) {
		 $('input[name=sendbox_messages]:checkbox').prop('checked', this.checked);  
	});
	$("#inbox-link").click(function (e) {
		$('input:checkbox').prop('checked', '');  
		$('#check-all').prop('checked', '');   
	});
	$("#sent-link").click(function (e) {
		$('input:checkbox').prop('checked', '');  
		$('#check-all').prop('checked', '');  
	});
</script>
<script type="text/javascript">
	$('.inbox_delete_btn').click(function(){
		var checkValues1 = $('input[name=inbox_messages]:checked').map(function() {
			return $(this).val();
		}).get();
		if(checkValues1 != '') {
			$.ajax({
				url: '{{ lurl('drop-messages') }}',
				type: 'post',
				data: { ids: checkValues1 },
				success:function(data) {
					$('.yes-msg').fadeIn('360000');
					location.reload();
				}
			});
		}
	});
	$('.send_delete_btn').click(function(){
		var checkValues2 = $('input[name=sendbox_messages]:checked').map(function() {
			return $(this).val();
		}).get();
		if(checkValues2 != '') {
			$.ajax({
				url: '{{ lurl('drop-messages') }}',
				type: 'post',
				data: { ids: checkValues2 },
				success:function(data) {
					$('.yes-msg').fadeIn('360000');
					location.reload();
				}
			});
		}
	});
</script>
<script>
	function read(id) {
		$.ajax({
			url: "{{ lurl('/msg/read') }}",
			type: 'post',
			data: {id: id},
			dataType: 'json',
			success:function(data) { }
		});
	}
</script>
<script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
<!-- EOF JAVASCRIPT --> 
@stop





    
	