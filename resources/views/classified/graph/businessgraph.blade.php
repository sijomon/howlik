@extends('classified.layouts.layout')
@section('content')
<style>
	#chartdiv {
		width		: 100%;
		height		: 500px;
		font-size	: 11px;
	}
	.outer-box {
		background: none repeat scroll 0 0 #FFFFFF;
		border-radius: 3px 3px;
		box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
		-webkit-box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
		box-shadow: 0 1px 1px rgba(180, 180, 180, 0.5);
		margin-bottom: 30px;
		padding: 20px 15px;
	}
	.title-3 {
		border-bottom: 1px solid #e6e6e6;
		margin-bottom: 20px;
		font-size: 15px;
		padding-bottom: 10px !important;
	}
</style>
<div class="main-container" dir="ltr">
	<div class="container">
		<div class="row">
			<!-- BOF SIDEBAR -->
			@if($user->user_type_id  == 3)
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left-user') </div>
			@else
				<div class="col-sm-3 page-sidebar"> @include('classified/account/inc/sidebar-left') </div>
			@endif
			<!-- EOF SIDEBAR -->
			
			<!-- BOF CONTENT -->
			<div class=" col-sm-9 page-content">
				<div class="inner-box">
					<h2 class="title-2"> @lang('global.Business Activity Graph') </h2>
					<div id="head-div">
						@if(isset($business) && count($business) > 0)
						<div  class="pull-left" style="display: inline-block;">
							{!! Form::select('business',($business->toArray()), null, array('class' => 'form-control','id' => 'business')) !!}
						</div>
						<div  class="pull-right" style="display: inline-block;">
							<label> @lang('global.Period') </label>
							<button type="button" class="btn btn-md btn-default period" value="1">@lang('global.Last 1 Month')</button>
							<button type="button" class="btn btn-md btn-default period" value="2">@lang('global.Last 12 Months')</button>
						</div>
						@else
							<div class="none-div">
								<div class="alert alert-danger" role="alert">
								  <strong> @lang('global.Empty!') </strong>
								</div>
							</div>
						@endif
					</div>
				</div>
				@if(isset($business) && count($business) > 0)
				<div class="outer-box">
					{{--*/ $months	 = date("F d"); /*--}}
					{{--*/ $yearrr 	 = date("F Y"); /*--}}
					{{--*/ $days31 	 = date("F d", strtotime("-30 day", strtotime($months))); /*--}}
					{{--*/ $month1 	 = date("F Y", strtotime("-11 month", strtotime($yearrr))); /*--}}
					<h3 class="title-3" id="one-month"><b> {{ $days31 }} - {{ $months }} </b></h3>
					<h3 class="title-3" id="one-year" style="display: none"><b> {{ $month1 }} - {{ $yearrr }} </b></h3>
					<div class="graph-responsive">
						<div id="chartdiv"></div>
					</div>
				</div>
				@endif
			</div>
			<!-- EOF CONTENT -->
		</div>
	</div>
</div>
@endsection

@section('javascript')
	@parent
	
	<script language="javascript">
		$( document ).ready(function() {
			
			$( "#business" ).on( "change", function() {
				
				var id  = $(this).val();
				var text = $(this).text();
				getGraphMonth(id);
				
			}).trigger( "change" );
			
			$( ".period" ).on( "click", function() {
				
				if($(this).val() == 1) {
					
					$("#one-month").show();
					$("#one-year").hide();
					var ab = $("#business option:selected").val();
					getGraphMonth(ab);
					
				} else if($(this).val() == 2) {
					
					$("#one-month").hide();
					$("#one-year").show();
					var ab = $("#business option:selected").val();
					getGraphYear(ab);
				}
			});
		});
	</script>
	
	<!-- BOF AMCHART SCRIPTS -->
	<script language="javascript">
		
		var id 		= $("#business option:selected").val();
		var chart	= AmCharts.makeChart("chartdiv",
		{
			"type": "serial",
			"dataLoader": {
				"url": "{{ lurl('/account/business/graph/day') }}/"+id
			},
			"categoryField": "category",
			"autoMarginOffset": 40,
			"marginRight": 70,
			"marginTop": 70,
			"startDuration": 1,
			"fontSize": 13,
			"theme": "light",
			"colors": [
				"#b40037",
				"#fdd400",
				"#ged400",
			],
			"categoryAxis": {
				"gridPosition": "start"
			},
			"export": {
				"enabled": true
			},
			"legend": {
				"enabled": true,
				"periodValueText": "( [[value.sum]] )",
				"valueAlign": "left",
				"fontSize": 13,
			},
			"guides": [],
			"valueAxes": [],
			"allLabels": [],
			"balloon": {},
			"titles": [],
			"trendLines": [],
			"graphs": [
				{
					"balloonText": "[[title]] @lang('global.in') [[category]] : [[value]]",
					"fillAlphas": 0.9,
					"id": "AmGraph-1",
					"title": "@lang('global.User Views')",
					"type": "column",
					"valueField": "column-1"
				},
				{
					"balloonText": "[[title]] @lang('global.in') [[category]] : [[value]]",
					"fillAlphas": 0.9,
					"id": "AmGraph-2",
					"title": "@lang('global.Gift Cards')",
					"type": "column",
					"valueField": "column-2"
				},
				{
					"balloonText": "[[title]] @lang('global.in') [[category]] : [[value]]",
					"fillAlphas": 0.9,
					"id": "AmGraph-3",
					"title": "@lang('global.Rating')",
					"type": "column",
					"valueField": "column-3"
				}
			]
		});
					
		function getGraphMonth(id) {
			
			AmCharts.loadFile("{{ lurl('/account/business/graph/day') }}/"+id, {}, function(data) {
				chart.dataProvider = AmCharts.parseJSON(data);
				chart.validateData();
			});
			return true;
		}
		
		function getGraphYear(id) {
			
			AmCharts.loadFile("{{ lurl('/account/business/graph/month') }}/"+id, {}, function(data) {
				chart.dataProvider = AmCharts.parseJSON(data);
				chart.validateData();
			});
			return true;
		}
		
	</script
	<!-- EOF AMCHART SCRIPTS -->
	
@endsection 
