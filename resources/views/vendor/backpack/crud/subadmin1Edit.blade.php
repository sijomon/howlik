@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.edit') }} <span class="text-lowercase"></span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/dashboard') }}">Admin</a></li>
	    <li><a href="{{ url('admin/ad') }}" class="text-capitalize">Business</a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section>
	<link href="{{ url('vendor/backpack/colorbox/example2/colorbox.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		
			<a href=""><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase"></span></a><br><br>
		

			{!! Form::open( array('route' => 'subadmin1postaddajax1', 'method' => 'POST', 'id' => 'ajax_user')) !!}
		  <div class="box">
		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
		    </div>
		    <div class="box-body">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
			  @foreach($cat as $c)
		       			 			    
			<div class="form-group">
				<label>Name (Arabic)</label>
				<input type="text" class="form-control" name="localname" placeholder="Enter the location name in(In Arabic)." value="{{$c->name}}"  />
			  </div>	      <!-- load the view from the application if it exists, otherwise load the one in the package -->
						<!-- text input -->
			  <div class="form-group">
				<label>Name</label>
				<input type="text" class="form-control" name="asciiname" placeholder="Enter the location name in(In English)." value="{{$c->asciiname}}" />
			  </div>	
				
			<div class="checkbox">
				<label>
				  <input type="checkbox" name="active" label="Active" type="checkbox" {{ ($c->active == 1)?'checked="checked"':'' }}> Active
				</label>
			</div>
			<input type="hidden" value= "<?php  echo Request::segment(3);?>" name="id"/>
			@endforeach
		    </div><!-- /.box-body -->
		    <div class="box-footer">

			  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>
		      <a href="" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		  {!! Form::close() !!}
	</div>
</div>
@endsection

@section('after_scripts')
<!-- include browse server js -->
<script src="{{ url('vendor/backpack/colorbox/jquery.colorbox-min.js')}}"></script>
<script src="{{ url('vendor/backpack/elfinder/standalonepopup.js')}}"></script>																								

<script type="text/javascript">
	jQuery(document).ready(function($) {

		$.ajaxPrefilter(function(options, originalOptions, xhr) {
			var token = $('meta[name="csrf_token"]').attr('content');

			if (token) {
				return xhr.setRequestHeader('X-XSRF-TOKEN', token);
			}
		});

		// make the delete button work in the first result page
		register_delete_button_action();

		function register_delete_button_action() {
			$("[data-button-type=delete]").unbind('click');
			// CRUD Delete
			// ask for confirmation before deleting an item
			$("[data-button-type=delete]").click(function(e) {
				e.preventDefault();
				var delete_button = $(this);
				var delete_url = $(this).attr('href');

				if (confirm("Are you sure you want to delete this item?") == true) {
					$.ajax({
						url: delete_url,
						type: 'DELETE',
						success: function(result) {
							// Show an alert with the result
							new PNotify({
								title: "Item Deleted",
								text: "The item has been deleted successfully.",
								type: "success"
							});
							// delete the row from the table
							window.location.replace($("input[name=edit_url]").val());
							window.location.href = $("input[name=edit_url]").val();
						},
						error: function(result) {
							// Show an alert with the result
							new PNotify({
								title: "NOT deleted",
								text: "There&#039;s been an error. Your item might not have been deleted.",
								type: "warning"
							});
						}
					});
				} else {
					new PNotify({
						title: "Not deleted",
						text: "Nothing happened. Your item is safe.",
						type: "info"
					});
				}
			});
		}


	});
</script>
@endsection