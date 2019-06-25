@extends('classified.layouts.layout')
@section('content')
<style>
	.loc-box {
		height:170px;
		background:#eee;
	}
	.loc-box iframe{
		width:100%;
		float:left;
	}
	.loc-box-title {
		background: #2a3744;
	}
	.loc-box-title h2 {
		color:#fff;
		text-align:left; 
	}
	.loc-opt-btn{
		float: right;
		padding: 5px;
		border-radius: 5px;
		font-size: 16px;
		margin:0 5px;
		
	}
	.btn_dlt{
		background:#e40046;
		cursor: pointer;
	}
	.btn_edit{
		background:#2aa2af;
	}
	.eo-box-title h2 a {
		color:#FFF !important; 
	}
	.loc-box-sub-title { font-size: 9px; }
	.alert-msg { display: none; }
	.btn-more { margin-top: -10px; }
</style>
<div class="main-container" dir="ltr">
	<div class="container">
		<div class="row">
			<!-- BOF SIDEBAR -->
			@if ($user->user_type_id  == 3)
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
			@else
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
			@endif
			<!-- EOF SIDEBAR -->
			
			<!-- BOF CONTENT -->
			<div class=" col-sm-9 page-content"> 
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
					<div class="alert alert-success alert-msg">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						@lang('global.Your Business Location Deleted Successfully.')
					</div>
					<div class="inner-title">
						<h2 class="title-2">
							<i class="icon-docs"></i> @lang('global.Locations of') @if(isset($business)) @if(Request::segment(1) == 'ar') {{ $business->title_ar }} @else {{ $business->title }} @endif @endif
							<span class="pull-right btn-more"> <a href="{{ lurl('account/business/location/create/'.$business->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> @lang('global.Add More') </a> </span>
						</h2>
					</div>
					<div class="table-responsive">
						<div id="b-book-div">
							@include('classified.business.locations.loadajax')
						</div>
					</div>
				</div>
			</div>
			<!-- EOF CONTENT -->
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
				//location.hash = page;
			}).fail(function () {
				alert('Posts could not be loaded.');
			});
		}
	</script>
	<script type="text/javascript">
		function dropLocation(id) {
			if (confirm("Do you want to delete this?")) {
				$.ajax({
					url : "{{ lurl('account/business/location/delete') }}",
					type: 'post',
					dataType: 'json',
					data: {'id' : id},
					success: function(data) {
						
						$('div.alert-msg').show();
						$('div#loc-'+id).remove();
						//location.reload();
					},
					error : function(xhr, status,data) {
						
						console.log("error");
						console.log(data);
						return false;
					}
					
				});
			}
			return false;
		}
	</script>
	
@endsection 
