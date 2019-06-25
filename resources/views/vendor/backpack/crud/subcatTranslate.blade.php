@extends('backpack::layout')

@section('header')
	<section class="content-header">
	  <h1>
	    {{ trans('backpack::crud.edit') }} <span class="text-lowercase"></span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/dashboard') }}">Admin</a></li>
	    <li><a href="" class="text-capitalize"></a></li>
	    <li class="active">{{ trans('backpack::crud.edit') }}</li>
	  </ol>
	</section>
	<link href="http://localhost/Classified/vendor/backpack/colorbox/example2/colorbox.css" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<!-- Default box -->
		
			<a href=""><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase"></span></a><br><br>
		

			{!! Form::open( array('route' => 'subcategorytanslate', 'method' => 'POST', 'id' => 'ajax_user')) !!}
		  <div class="box">
		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
		    </div>
		    <div class="box-body">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
			  @foreach($cat as $c)
		       			 			    
			<input type="hidden" value="{{$c->cat_id}}" name="category"/>
			<input type="hidden" value="{{$c->subCat_id}}" name="subcategory"/>
			<input type="hidden" value="{{$lang}}" name="lang"/>
			<input type="hidden" value="{{$id}}" name="id1"/>
			<div class="form-group">
				<label>Name</label>
				<input
					type="text"
					class="form-control"

								name="name"
								label="Name"
								type="text"
								placeholder="Enter a name"
								value=""
							/>
			  </div>	      <!-- load the view from the application if it exists, otherwise load the one in the package -->
						<!-- text input -->
			  <div class="form-group">
				<label>Slug (URL)</label>
				<input
					type="text"
					class="form-control"

								name="slug"
								label="Slug (URL)"
								type="text"
								placeholder="Will be automatically generated from your name, if left empty."
								hint="Will be automatically generated from your name, if left empty."
								value=""
							>
			  </div>	
			 <div class="form-group">
				<label>Description</label>
				<textarea
					class="form-control"

								name="description"
								label="Description"
								type="textarea"
								placeholder="Enter a description"
								
					></textarea>
			  </div>	
			   <div class="form-group">
				<label>Picture</label>
				<input type="text" class="form-control"	id="picture-filemanager" name="picture"	label="Picture"	type="browse" value=""readonly>
				<div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
				  <button type="button" data-inputid="picture-filemanager" class="btn btn-default popup_selector">
					<i class="fa fa-cloud-upload"></i> Browse uploads</button>
					<button type="button" data-inputid="picture-filemanager" class="btn btn-default clear_elfinder_picker">
					<i class="fa fa-eraser"></i> Clear</button>
				</div>
		    </div>
			<div class="checkbox">
				<label>
				  <input type="hidden" name="active" value="0">
				  <input type="checkbox" name="active" label="Active" type="checkbox"> Active
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
<script src="http://localhost/Classified/vendor/backpack/colorbox/jquery.colorbox-min.js"></script>
<script src="http://localhost/Classified/vendor/backpack/elfinder/standalonepopup.js"></script>																								

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