@extends('backpack::layout')

@section('after_styles')
	<!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('header')
	<section class="content-header">
	  <h1>
	    <span class="text-capitalize">{{ $crud['entity_name_plural'] }}</span>
	    <small>{{ trans('backpack::crud.all') }} <span class="text-lowercase">{{ $crud['entity_name_plural'] }}</span> {{ trans('backpack::crud.in_the_database') }}.</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="{{ url('admin/dashboard') }}">Admin</a></li>
	    <li><a href="{{ url($crud['route']) }}" class="text-capitalize">{{ $crud['entity_name_plural'] }}</a></li>
	    <li class="active">{{ trans('backpack::crud.list') }}</li>
	  </ol>
	</section>
@endsection

@section('content')

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
    width: 28%;
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

a.btn.btn-primary.ladda-button {
       float: left;
	}
a.btn.btn-default.ladda-button {
    float: left;
	margin-left: 10px;
    margin-right: 10px;
	}
	
.box-header.with-border select {
    float: left;
    margin-right: 10px;
    padding: 7px;
    border-radius: 4px;
    border-color: #999;
}


.offer-list-card{
	width:100%;
	height:100px;
	float:left;
	background:#fff;
	border:1px solid #ccc;
	box-shadow:0 0 1px #ccc;
	position:relative;
}
.offer-list-card-title{
	padding:10px;
	background:#f6f6f6;
}
.offer-list-card-content{
	padding:10px
}

#triangle-topright {
	width: 0;
	height: 0;
	border-top: 50px solid #0ebc67;
	border-left: 50px solid transparent;
	right:0;
	position:relative;
	float:right;
}
#triangle-topright span{
	position: absolute;
    color: #fff;
    z-index: 10;
    top: 0;
    margin-top: -40px;
    transform: rotate(45deg);
    margin-left: -30px;
    font-size: 12px;
}
.offer-list-card-content span a{
	text-decoration:none;
	color:#000 !important;
	transition:all ease-out .5s;
}

.offer-right-list{
	background:#f6f6f6;
	border:#ccc;
	width:100%;
	height:auto;
	float:left;
}
.offer-right-list-header{
	padding:5px;
	background:#0ebc67;
	font-size:14px;
	text-align:center;
	color:#FFF;
	font-weight:bold;
	text-transform:uppercase;
}
.offer-right-list-content{
	width:100%;
	float:left;
	position:relative;
	height:auto;
	padding:10px 5px;
}
.offer-right-list-content .u-row{
	border-bottom:1px solid #999;
	width:100%;
	float:left;
	padding-bottom:10px;
	background:#FFF;
	padding:5px;
	margin-bottom:8px;
}
.offer-right-list-content .title{
	width:100%;
	font-size:14px;
	font-weight:600;
}
.offer-right-list-content .flat-left{
	float:left;
	font-size:35px;
    color: #0ebc67;
}
.offer-right-list-content .flat-right{
	float:left;
	font-size:14px;
    color: #666;
	margin:16px; 
}
.offer-right-list-content .flat-rotate{
	float:left;
	transform: rotate(-90deg);
    margin-top: 15px;
    text-transform: uppercase; 
	color:#000;
}
.detail-offer{
	background:#FFF;
	margin-bottom:20px;
	padding:10px;
	border:1px solid #ccc;
}
.offer-left-box{
	width:40%;
	float:left;
}

.offer-right-box{
	width:60%;
	float:left;
}
#modal_body {
	
	max-height: 450px;
	overflow-y: scroll;
}
</style>

@if ($errors->any()) <div class="callout callout-danger"> <h4>Please fix</h4> <ul> @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul> </div> @endif

<!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      @if (!(isset($crud['add_permission']) && !$crud['add_permission']))
      		<a href="{{ url($crud['route'].'/create') }}" class="btn btn-primary ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud['entity_name'] }}</span></a>
      @endif
      @if ((isset($crud['reorder']) && $crud['reorder']))
        @if (!(isset($crud['reorder_permission']) && !$crud['reorder_permission']))
          <a href="{{ url($crud['route'].'/reorder') }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-arrows"></i> {{ trans('backpack::crud.reorder') }} {{ $crud['entity_name_plural'] }}</span></a>
          @endif
      @endif
	  
	  @if ((isset($crud['csv']) && $crud['csv']))
				 {!! Form::open( array('route' => 'upload_category_csv', 'method' => 'POST','files'=>true , 'id' => 'csv_upload','class'=>'form')) !!}
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
          @endif
    </div>
    <div class="box-body">
		@if ((isset($crud['filter']) && $crud['filter']))
			<div class="portlet-body" style="padding-bottom:10px;padding-top:20px;background:#EFF3F8;min-height:76px; margin-bottom:15px;">
				<form method="post" action="{{url('admin/payreport')}}" id="filter_form">
				  <div class="col-lg-9" style="float:right; text-align:right;">
					<b>Type&nbsp;</b>
					<select id="etype" name="etype" class="form-control" style="display: inline; width: 25%;">
						<option value="all">All</option>
						<option value="event">Event Ticket</option>
						<option value="gift">Gift Certificate</option>
					</select> 
					<b>From&nbsp;</b>
					<input style="width:25%; display:inline;" readonly="" class="datepicker form-control" name="frm" type="text">
					<b>To&nbsp;&nbsp;</b>
					<input style="width:25%; display:inline;" readonly="" class="datepicker form-control" name="to" type="text">
					<button type="submit" class="btn btn-success"><i class="fa fa-filter"></i>&nbsp;Filter</button>
				  </div>
				</form>
			</div>
		@endif
		<div id="dTbleBox">
		<table id="crudTable" class="table table-bordered table-striped display">
                    <thead>
                      <tr>
                        @if (isset($crud['details_row']) && $crud['details_row']==true)
                          <th></th> <!-- expand/minimize button column -->
                        @endif

                        {{-- Table columns --}}
                        @foreach ($crud['columns'] as $column)
                          <th>{{ $column['label'] }}</th>
                        @endforeach

                        @if ( !( isset($crud['edit_permission']) && $crud['edit_permission'] === false && isset($crud['delete_permission']) && $crud['delete_permission'] === false ) )
                          <th>{{ trans('backpack::crud.actions') }}</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>

                      @foreach ($entries as $k => $entry)
                      <tr data-entry-id="{{ $entry->id }}">

                        @if (isset($crud['details_row']) && $crud['details_row']==true)
                          <!-- expand/minimize button column -->
                          <td class="details-control text-center cursor-pointer">
                            <i class="fa fa-plus-square-o"></i>
                          </td>
                        @endif
						
						@if(isset($crud['special']))
							<td id="imgOut{{$entry->id}}">
								<table class="table table-bordered table-striped display">
									<tr>
										<td>{!!$entry->business->getTitleHtml()!!}</td>
									</tr>
									<tr>
										<td><img width="400" src="{{ url($entry->filename)}}" /></td>
										<td>
											<p>Posted by : @if(isset($entry->user->name)){{$entry->user->name}}@else -NA- @endif</p>
											<p>Posted at : {{$entry->created_at}}</p>
											<p id="imgAction{{$entry->id}}">
												<a href="#" onclick="return imgAction({{$entry->id}}, 1);" class="btn btn-xs btn-success"><i class="fa fa-thumbs-o-up"></i> Approve</a>
												<a href="#" onclick="return imgAction({{$entry->id}}, 0);" class="btn btn-xs btn-danger"><i class="fa fa-thumbs-o-down"></i> Discard</a>
											</p>
										</td>
									</tr>
								</table>
							<?php
									//echo "<pre>";
									//print_r($entry);exit;
								 ?>
							</td>
						@else
							@foreach ($crud['columns'] as $column)
							  @if (isset($column['type']) && $column['type']=='select_multiple')
								{{-- relationships with pivot table (n-n) --}}
								<td><?php
								$results = $entry->{$column['entity']}()->getResults();
								if ($results && $results->count()) {
									$results_array = $results->lists($column['attribute'], 'id');
									echo implode(', ', $results_array->toArray());
								  }
								  else
								  {
									echo '-';
								  }
								 ?></td>
							  @elseif (isset($column['type']) && $column['type']=='select')
								{{-- single relationships (1-1, 1-n) --}}
								<td><?php
								if ($entry->{$column['entity']}()->getResults()) {
									echo $entry->{$column['entity']}()->getResults()->{$column['attribute']};
								  }
								 ?></td>
							  @elseif (isset($column['type']) && $column['type']=='select')
								{{-- single relationships (1-1, 1-n) --}}
								<td><?php
								if ($entry->{$column['entity']}()->getResults()) {
									echo $entry->{$column['entity']}()->getResults()->{$column['attribute']};
								  }
								 ?></td>
							  @elseif (isset($column['type']) && $column['type']=='model_function')
								<td><?php
									echo $entry->{$column['function_name']}()
								 ?></td>
							  @else
								{{-- regular object attribute --}}
								<td>{{ str_limit(strip_tags($entry->{$column['name']}), 80, "[...]") }}</td>
							  @endif

							@endforeach
						@endif
						
                        @if ( !( isset($crud['edit_permission']) && $crud['edit_permission'] === false && isset($crud['delete_permission']) && $crud['delete_permission'] === false ) )
                        <td>
                          {{-- <a href="{{ Request::url().'/'.$entry->id }}" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> {{ trans('backpack::crud.preview') }}</a> --}}
                          @if (!(isset($crud['edit_permission']) && !$crud['edit_permission']))
                            <a href="{{ Request::url().'/'.$entry->id }}/edit" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> {{ trans('backpack::crud.edit') }}</a>
                          @endif
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
                          <a href="{{ Request::url().'/'.$entry->id }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> {{ trans('backpack::crud.delete') }}</a>
                          @endif
                        </td>
                        @endif
                      </tr>
                      @endforeach

                    </tbody>
                    <tfoot>
                      <tr>
                        @if (isset($crud['details_row']) && $crud['details_row']==true)
                          <th></th> <!-- expand/minimize button column -->
                        @endif

                        {{-- Table columns --}}
                        @foreach ($crud['columns'] as $column)
                          <th>{{ $column['label'] }}</th>
                        @endforeach

                        @if ( !( isset($crud['edit_permission']) && $crud['edit_permission'] === false && isset($crud['delete_permission']) && $crud['delete_permission'] === false ) )
                          <th>{{ trans('backpack::crud.actions') }}</th>
                        @endif
                      </tr>
                    </tfoot>
                  </table>
				</div>
    </div><!-- /.box-body -->
  </div><!-- /.box -->
  
	<!-- BOF Modal -->
	<div id="myModal" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header" id="modal_head"></div>
				<div class="modal-body" id="modal_body"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"> @lang('global.Close') </button>
				</div>
			</div>
		</div>
	</div>
	<!-- EOF Modal -->
		
@endsection


@section('after_scripts')
	
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
	<script src="{{ asset('vendor/adminlte/') }}/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		function imgAction(id, status){
			if(confirm('Are you sure to do this?')){
				if(parseInt(id)> 0 ) 
				{
					//imgOut
					$("#imgAction"+id).fadeOut('normal');
					$.ajax({
						
						url: 'http://www.howlik.com/admin/imgaction',
						type: 'post',
						data: {'id':id, 'status':status},
						dataType:'json',
						success: function(data)
						{
							if(status==1){
								// Show an alert with the result
								new PNotify({
								  title: "Approved",
								  text: "Image has been approved!",
								  type: "success"
								});
							}else{
								// Show an alert with the result
								new PNotify({
								  title: "Discarded",
								  text: "Image has been discarded!",
								  type: "error"
								});
							}
							$("#imgOut"+id).fadeOut('normal');
						}
					});   
					return false;
				}
			}
			return false;
		}
		
		var pay_status = '';
		function focusPayStatus(id){
			pay_status = $("#pay_status"+id).val();
		}
		
		function updatePayStatus(id){
			if(confirm("Are you sure to change Pay Status?")){
				var p_status = $("#pay_status"+id).val();
				var url = "{{url('admin/payreportstatus')}}"; // the script where you handle the form input.
				$.ajax({
				   type: "POST",
				   url: url,
				   data: {'id':id, 'p_status':p_status},
				   success: function(data)
				   {
					   if(p_status==1){
						   new PNotify({
							  title: "Approved",
							  text: "Pay Status has been changed to 'Paid'",
							  type: "success"
							});
					   }else{
							new PNotify({
							  title: "Approved",
							  text: "Pay Status has been changed to 'Pending'",
							  type: "success"
							});
					   }
					   
				   }
				});
			}else{
				$("#pay_status"+id+" option[value='"+pay_status+"']").prop('selected', true);
			}
		}
		
		function getPopup(id){
			
			if(parseInt(id)> 0 ) 
			{
				$.ajax({
					
					url: '{{ url("admin/getofferslist") }}',
					type: 'get',
					data: {'id':id},
					dataType:'json',
					success: function(data)
					{
						$('#modal_head').html(data.modal_head);
						
						$('#modal_body').html(data.modal_body);
						
						$('#myModal').modal('show');
					}
				});   
				return false;		
			}
		}
		
		function getGiftPopup(id){
			
			if(parseInt(id)> 0 ) 
			{
				$.ajax({
					
					url: '{{ url("admin/getgiftslist") }}',
					type: 'get',
					data: {'id':id},
					dataType:'json',
					success: function(data)
					{
						$('#modal_head').html(data.modal_head);
						
						$('#modal_body').html(data.modal_body);
						
						$('#myModal').modal('show');
					}
				});   
				return false;		
			}
		}
		
		function getReviewPopup(id){
			
			if(parseInt(id)> 0 ) 
			{
				$.ajax({
					
					url: '{{ url("admin/getreviewslist") }}',
					type: 'get',
					data: {'id':id},
					dataType:'json',
					success: function(data)
					{
						$('#modal_head').html(data.modal_head);
						
						$('#modal_body').html(data.modal_body);
						
						$('#myModal').modal('show');
					}
				});   
				return false;		
			}
		}
		
		var table = '';
		function makeDtable(){
			table = $("#crudTable").DataTable({

			@if(isset($crud['sort'])) 
			 "order": [[ "{{$crud['sort']['col']}}", "{{$crud['sort']['type']}}" ]],
			@endif

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
		}
		
		jQuery(document).ready(function($) {
			jQuery('.datepicker').datepicker({
			  format: "yyyy-mm-dd",
			  autoclose: true
			});
	
			$("#filter_form").submit(function(e) {
				var url = "{{url('admin/payreport')}}"; // the script where you handle the form input.
				$.ajax({
				   type: "POST",
				   url: url,
				   data: $("#filter_form").serialize(), // serializes the form's elements.
				   success: function(data)
				   {
					   //alert(data); // show response from the php script.
					   $("#dTbleBox").html(data);
					   makeDtable();
				   }
				});
				e.preventDefault(); // avoid to execute the actual submit of the form.
			});
	
			makeDtable();

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
      
      $('#title_ar').on('click', function () {
		  
		//alert('a');
			//var tr = $(this).closest('tr');
			//var row = table.row( tr );
          
              
              //$.ajax({
                //url: '{{ Request::url() }}/'+tr.data('entry-id')+'/details',
                //type: 'GET',
                // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                // data: {param1: 'value1'},
              //})
          //}
      });
      
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
	  
	function showfiletrResponse(){
		alert(5);
	}	
	
	
	</script>
@endsection