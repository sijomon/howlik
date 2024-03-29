@extends('classified.layouts.layout')
<style>
	.eobox-top{
		border-bottom: 1px solid #ccc;
		float: left;
		width: 100%;
		margin-bottom:10px;
	}
	.eobox-bottom{
		float: left;
		width: 100%;
		padding:20px 0;	
		height:auto;
		max-height:325px;
		overflow-y: scroll;
	}
	.eobox-bottom-div{
		border: 1px solid #0ebc67;
		padding: 10px;
		margin-bottom: 10px;
	}
	.eobox-bottom-div p{
		color:#666; 
	}
</style>
@section('content')
<div class="main-container">
	<div class="container">
		<div class="row"> 
			@if (Session::has('flash_notification.message'))

				<div class="container" style="margin-bottom: -10px; margin-top: -10px;">

					<div class="row">

						<div class="col-lg-12"> @include('flash::message') </div>

					</div>

				</div>
			@endif
			<?php  if ($user->user_type_id  == 3) { ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
			<?php  }else{ ?>
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
			<?php }?>
			<!--/.page-sidebar-->
			<div class="col-sm-9 page-content">
				<div class="inner-box">
					<h2 class="title-2">
						@if(strtolower(Request::segment('1')) == 'ar')
							@lang('global.Gift Certificates of')  {{ $business->title_ar }}
						@else
							@lang('global.Gift Certificates of')  {{ $business->title }}
						@endif 
						<a href="{{ lurl('account/mybusinesslistings') }}" style="float:right;" class="btn btn-default btn-xs"> @lang('global.Go Back') </a>
					</h2>
					<div class="table-responsive">
						<div id="b-book-div">
							@include('classified.business.details.inc.view-certificates-ajax')
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
</div>
@endsection


@section('javascript')
	@parent
	<script type="text/javascript">
		$(window).on('hashchange', function() {
			if (window.location.hash) {
				var page = window.location.hash.replace('#', '');
				if (page == Number.NaN || page <= 0) {
					return false;
				} else {
					getPosts(page);
				}
			}
		});
		$(document).ready(function() {
			$(document).on('click', '.pagination a', function (e) {
				getPosts($(this).attr('href').split('page=')[1]);
				e.preventDefault();
			});
		});
		function getPosts(page) {
			$.ajax({
				url : '?page=' + page,
				dataType: 'html',
			}).done(function (data) {
				$('#b-book-div').html(data);
				location.hash = page;
			}).fail(function () {
				alert('Posts could not be loaded.');
			});
		}
	</script>
	<!-- include custom script for business table [select all checkbox]  -->
@endsection 
