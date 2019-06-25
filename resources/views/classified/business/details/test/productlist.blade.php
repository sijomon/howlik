@extends('classified.layouts.layout')
@section('content')
<!-- CONTENTS STARTS HERE -->
<div class="content-holder">
	<div class="container"> 
		<div class="row">
			<div class="col-lg-12 margin-tb">
				<div id="product_container">
					@include('classified.business.details.test.presult')
				</div>
			</div>
		</div>
	</div>
</div>
<!-- CONTENTS ENDS HERE --> 
@endsection
@section('javascript')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$(document).on('click', '.pagination a',function(event)
		{
			event.preventDefault();
			var url = $(this).attr('href');
			getData(url);
			window.history.pushState("", "", url);
		});
	}); 
	
	function getData(url) {
		$.ajax({
			url : url			
		}).done(function (data) {
			$('#product_container').html(data);
		}).fail(function () {
			alert('global.Data could not be loaded.');
		});
	}
</script>
@endsection