@extends('classified.layouts.layout')
@section('content')
	<div class="main-container">
		<div class="container">
			<div class="row"> 
			
				@if (Session::has('flash_notification.message'))
				<div class="container">
					<div class="row">
						<div class="col-lg-offset-3 col-lg-9"> @include('flash::message') </div>
					</div>
				</div>
				@endif
				
				@if ($user->user_type_id  == 3)
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
				@else
					<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
				@endif
				<!--/.page-sidebar-->
				
				<div class="col-sm-9 page-content">
					<div class="inner-box"> 
						<h2 class="title-2"><i class="icon-docs"></i> @lang('My Events') </h2>
						<div class="table-responsive">
							<form method="POST" action="{{ lurl('account/'.Request::segment(3).'/delete') }}">
								{!! csrf_field() !!}
								<div class="table-action">
									<label for="checkAll">
										<input type="checkbox" id="checkAll">
										@lang('global.Select'): @lang('global.All') |
										<button type="submit" class="btn btn-primary btn-xs">@lang('global.Delete') <i class="glyphicon glyphicon-remove"></i></button>
									</label>
									<div class="table-search pull-right col-xs-7">
										<div class="form-group">
											<label class="col-xs-5 control-label text-right">@lang('global.Search') <br>
											<a title="clear filter" class="clear-filter" href="#clear">[@lang('global.clear')]</a> </label>
											<div class="col-xs-7 searchpan">
											  <input type="text" class="form-control" id="filter">
											</div>
										</div>
									</div>
								</div>
								<table id="addManageTable" class="table table-striped table-bordered add-manage-table table demo" data-filter="#filter" data-filter-text-only="true">
									
									<thead>
									  <tr>
										<th data-type="numeric" data-sort-initial="true"></th>
										<th>{{ t('Photo') }}</th>
										<th data-sort-ignore="true"> @lang('global.Event Details') </th>
										<th>{{ t('Option') }}</th>
									  </tr>
									</thead>
									
									<tbody>
									@if(!empty($events))
										@foreach($events as $event)
											<tr>
												<td style="width:2%" class="add-img-selector">
													<label> <input type="checkbox" name="event[]" value="{{$event->id}}"> </label>
												</td>
												<td style="width:14%" class="add-img-td">
													<a href="">
													@if($event->event_image1 != '')
													<img class="thumbnail img-responsive" src="{{ url($event->event_image1) }}" alt="img" data-no-retina/>
													@else
													<img class="thumbnail img-responsive" src="{{ url('uploads/pictures/no-image.jpg') }}" alt="img" data-no-retina/>
													@endif
													</a>
												
												</td>
												
												<td style="width:58%" class="ads-details-td">
													<div>
														<p><strong> <a href="{{ lurl('/preview/event/'.$event->id) }}"> {{ ucfirst($event->event_name) }} </a> </strong></p>
														<p> <strong> @lang('global.Posted On') </strong>: {{ date('d M Y H:i', strtotime($event->created_at)) }} </p>
														<p> <strong> @lang('global.Located In') </strong>:
															<?php 
																$cities	=	DB::table('cities')->where('cities.id', $event->event_place)->get();
																if(!empty($cities)) {
																	
																	foreach($cities as $city)
																	{
																		echo '<small>'.$city->asciiname.'</small>';
																	}
																}
															?> 
														</p>
													</div>
												</td>
												<td style="width:10%" class="action-td">
													<div> 
														{{--*/ $tickets	= DB::table('event_tickets')->where('event_tickets.event_id', $event->id)->first(); /*--}}
														@if(count($tickets) > 0)
															<p><a class="btn btn-primary btn-xs" href="{{ lurl('event/booking/'.$event->id) }}"> <i class="fa fa-ticket"></i> @lang('global.Booking') </a></p>
														@endif
														<p><a class="btn btn-primary btn-xs" href="{{ lurl('account/myevents/edit/'.$event->id) }}"> <i class="fa fa-edit"></i> @lang('global.Edit') </a></p>
														<p><a class="btn btn-danger btn-xs" href="{{ lurl('account/myevents/delete/'.$event->id) }}" onclick="return confirm('Do you want to delete?');"><i class="fa fa-trash"></i> @lang('global.Delete') </a></p>
													</div>
												</td>
											</tr>
										@endforeach
									@endif
									</tbody>	
									
								</table>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	@parent
	<script src="{{ url('assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
	<script src="{{ url('assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
	
	<script type="text/javascript">
		$(function () {
			$('#addManageTable').footable().bind('footable_filtering', function (e) {
				var selected = $('.filter-status').find(':selected').text();
				if (selected && selected.length > 0) {
					e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
					e.clear = !e.filter;
				}
			});
			$('.clear-filter').click(function (e) {
				e.preventDefault();
				$('.filter-status').val('');
				$('table.demo').trigger('footable_clear_filter');
			});
			$('#checkAll').click(function () {
				checkAll(this);
			});
		});
	</script>
	
	<!-- include custom script for business table [select all checkbox]  -->
	<script>
		function checkAll(bx) {
			var chkinput = document.getElementsByTagName('input');
			for (var i = 0; i < chkinput.length; i++) {
				if (chkinput[i].type == 'checkbox') {
					chkinput[i].checked = bx.checked;
				}
			}
		}
	</script>
	
@endsection 
