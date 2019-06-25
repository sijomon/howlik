@extends('backpack::layout')
@section('after_styles')
	<!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">SubCategory List</span>
		 <small>{{ trans('backpack::crud.all') }} <span class="text-lowercase"></span> {{ trans('backpack::crud.in_the_database') }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/ad') }}">Ads</a></li>
	    <li class="active">SubCategory List</li>
	  </ol>
	</section>
@endsection

@section('content')
<!-- Default box -->	
<style>
	.file_holder {
	width: 100%;
	float: left;
	margin-bottom: 10px;
}
.sub_cateholder {
    width: 13%;
    float: left;
}
.Upload_holder {
    width: 9%;
    float: left;
}
.input_holder {
    width: 30%;
    float: left;
}

.ja_holder {
    background: #3c8dbc;
    border: none;
    padding: 8px 30px 8px;
    color: #fff;
    border-radius: 4px;
}
.Upload_holder label {
    padding-top: 8px;
}

</style>
@if ($errors->any()) <div class="callout callout-danger"> <h4>Please fix</h4> <ul> @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> </div> @endif
		<div class="box">
		
		<div class="box-header with-border">
		<div class="col-lg-12 file_holder" >
		
<div class="sub_cateholder">
<a href="{{url('admin/subcategoryadd')}}" class="btn btn-primary ladda-button" data-style="zoom-in">
<span class="ladda-label"><i class="fa fa-plus"></i> Subcategory</a>
			
		</div>
		
      {!! Form::open( array('route' => 'upload_csv', 'method' => 'POST','files'=>true , 'id' => 'csv_upload','class'=>'form')) !!}
		<div class="Upload_holder">
			<label>Upload File</label>
		</div>
		<div class="input_holder">
			<input type="file" name="Upload_file" class="btn btn-primary ladda-button" />
		</div>
		<div class="subt_btn">
			<button type="submit" class="ja_holder" id="ajax_submit">Submit</button>
		</div>
		{!! Form::close()!!}

	</div>
	
	
	
    <div class="box-body">

		<table id="crudTable" class="table table-bordered table-striped display">
                    <thead>
                      <tr>
                       
                          <th></th> <!-- expand/minimize button column -->
						  <th>Sl.No </th> 
						  <th>SubCategory name</th>
                       
						  <th>Active</th>
                        
                          <th>Actions</th>
                          
                      </tr>
                    </thead>
                    <tbody>
					@if(!empty($cat))
						 <?php $count = 1; 
					 //echo "<pre>";print_r($cat);die;
					 ?>
						@foreach($cat as $q)
                     
                      <tr data-entry-id="{{ $q->id }}">

                      
                          <!-- expand/minimize button column-->
                          <td class="details-control text-center cursor-pointer">
                            <i class="fa fa-plus-square-o"></i>
                          </td> 
						 
							<td> <?php echo $count;?></td>
                            <td>{{$q->name}} </td>
                          
                            <td>{{$q->slug}}</td>
                          
                            
                          
                           
                         
                        <td>
                            <a href="{{url('admin/subcategoryEdit/'.$q->id)}}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> </a>
						 <a onclick="return confirm('Remove this subcategory ?');" style="color:red" href="{{url('admin/subcategory_delete/'.$q->id)}}" class="btn btn-xs btn-default " title="Delete User">
											  <i class="fa fa-trash"></i>
											</a>
                           
                        </td>
                       
                      </tr>
					   <?php $count++;?>
					  @endforeach
                    @endif

                    </tbody>
                    <tfoot>
                      <tr>
                       
                          <th></th> <!-- expand/minimize button column -->
                      
                          <th></th>
                     
                          <th></th><th></th><th></th>
                      
                      </tr>
                    </tfoot>
                  </table>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</div>
</div>

@endsection


@section('after_scripts')
	<!-- DATA TABES SCRIPT -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

	<script type="text/javascript">
	  jQuery(document).ready(function($) {

	  	var table = $("#crudTable").DataTable({
        "language": {
              "emptyTable":     "No data available in table",
              "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
              "infoEmpty":      "Showing 0 to 0 of 0 entries",
              "infoFiltered":   "(filtered from _MAX_ total entries)",
              "infoPostFix":    "",
              "thousands":      ",",
              "lengthMenu":     "_MENU_ records per page",
              "loadingRecords": "Loading...",
              "processing":     "Processing...",
              "search":         "Search: ",
              "zeroRecords":    "No matching records found",
              "paginate": {
                  "first":      "First",
                  "last":       "Last",
                  "next":       "Next",
                  "previous":   "Previous"
              },
              "aria": {
                  "sortAscending":  ": activate to sort column ascending",
                  "sortDescending": ": activate to sort column descending"
              }
          }
      });

            // Add event listener for opening and closing details
      $('#crudTable tbody').on('click', 'td.details-control', function () {
		  
          var tr = $(this).closest('tr');
          var row = table.row( tr );

          if ( row.child.isShown() ) {
              // This row is already open - close it
              $(this).children('i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
              $('div.table_row_slider', row.child()).slideUp( function () {
                  row.child.hide();
                  tr.removeClass('shown');
              } );
          }
          else {
              // Open this row
              $(this).children('i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
              // Get the details with ajax
              $.ajax({
                url: 'a/'+tr.data('entry-id')+'/details1',
                type: 'GET',
                // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                // data: {param1: 'value1'},
              })
              .done(function(data) {
				  // console.log("-- success getting table extra details row with AJAX");
                row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                tr.addClass('shown');
                $('div.table_row_slider', row.child()).slideDown();
                register_delete_button_action();
              })
              .fail(function(data) {
                // console.log("-- error getting table extra details row with AJAX");
                row.child("<div class='table_row_slider'>There was an error loading the details. Please retry. </div>").show();
                tr.addClass('shown');
                $('div.table_row_slider', row.child()).slideDown();
              })
              .always(function(data) {
                // console.log("-- complete getting table extra details row with AJAX");
              });
          }
      } );
      
      $.ajaxPrefilter(function(options, originalOptions, xhr) {
          var token = $('meta[name="csrf_token"]').attr('content');

          if (token) {
                return xhr.setRequestHeader('X-XSRF-TOKEN', token);
          }
    });

      // make the delete button work in the first result page
      register_delete_button_action();

      // make the delete button work on subsequent result pages
      $('#crudTable').on( 'draw.dt',   function () {
         register_delete_button_action();
      } ).dataTable();

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
                      delete_button.parentsUntil('tr').parent().remove();
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
