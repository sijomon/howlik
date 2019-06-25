@extends('backpack::layout')
@section('after_styles')
	<!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">Review List</span>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/ad') }}">Ads</a></li>
	    <li class="active">Review List</li>
	  </ol>
	</section>
@endsection

@section('content')

		<!-- Default box -->

		<div class="box">
		
		<div class="box-header with-border">
     
      		
		</div>
    <div class="box-body">

		<table id="crudTable" class="table table-bordered table-striped display">
                    <thead>
                      <tr>
                       
                          <th>Sl.No </th> <!-- expand/minimize button column -->
                      
						  <th>User</th>
                       
						  <th>Review</th>
                        
                          <th>created at</th>
                          <th></th>
                      </tr>
                    </thead>
                    <tbody>
					@if(!empty($query))
						 <?php $count = 1; ?>
						@foreach($query as $q)
                     
                      <tr data-entry-id="">

                      
                          <!-- expand/minimize button column
                          <td class="details-control text-center cursor-pointer">
                            <i class="fa fa-plus-square-o"></i>
                          </td> -->
						 
							<td> <?php echo $count;?></td>
                            <td>{{$q->name}} </td>
                          
                            <td>{{$q->review}}</td>
                          
                            <td>{{$q->created_at}}</td>
                          
                           
                         
                        <td>
                            @if (
								(
									!(isset($crud['delete_permission']) && !$crud['delete_permission']) &&
									/* Security for SuperAdmin */
									!str_contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'UserController')
								)
								or
								(
								 	/* Security for SuperAdmin */
									!(isset($crud['delete_permission']) && !$crud['delete_permission']) &&
									str_contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'UserController') && $entry->id != 1
								)
                           )                      
                       
						 <a onclick="return confirm('Remove this Review ?');" style="color:red" href="{{url('admin/review_delete/'.$q->rid)}}" class="btn btn-xs btn-default " title="Delete User">
											  <i class="fa fa-trash"></i>
											</a>
                           @endif
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
              "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
              "info":           "{{ trans('backpack::crud.info') }}",
              "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
              "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
              "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
              "thousands":      "{{ trans('backpack::crud.thousands') }}",
              "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
              "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
              "processing":     "{{ trans('backpack::crud.processing') }}",
              "search":         "{{ trans('backpack::crud.search') }}",
              "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
              "paginate": {
                  "first":      "{{ trans('backpack::crud.paginate.first') }}",
                  "last":       "{{ trans('backpack::crud.paginate.last') }}",
                  "next":       "{{ trans('backpack::crud.paginate.next') }}",
                  "previous":   "{{ trans('backpack::crud.paginate.previous') }}"
              },
              "aria": {
                  "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
                  "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
              }
          }
      });

      @if (isset($crud['details_row']) && $crud['details_row']==true)
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
                url: '{{ Request::url() }}/'+tr.data('entry-id')+'/details',
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
      @endif

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

          if (confirm("{{ trans('backpack::crud.delete_confirm') }}") == true) {
              $.ajax({
                  url: delete_url,
                  type: 'DELETE',
                  success: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "{{ trans('backpack::crud.delete_confirmation_title') }}",
                          text: "{{ trans('backpack::crud.delete_confirmation_message') }}",
                          type: "success"
                      });
                      // delete the row from the table
                      delete_button.parentsUntil('tr').parent().remove();
                  },
                  error: function(result) {
                      // Show an alert with the result
                      new PNotify({
                          title: "{{ trans('backpack::crud.delete_confirmation_not_title') }}",
                          text: "{{ trans('backpack::crud.delete_confirmation_not_message') }}",
                          type: "warning"
                      });
                  }
              });
          } else {
              new PNotify({
                  title: "{{ trans('backpack::crud.delete_confirmation_not_deleted_title') }}",
                  text: "{{ trans('backpack::crud.delete_confirmation_not_deleted_message') }}",
                  type: "info"
              });
          }
        });
      }


	  });
	</script>
@endsection
