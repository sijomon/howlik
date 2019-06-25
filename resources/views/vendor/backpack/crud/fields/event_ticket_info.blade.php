<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Information field -->
<div class="info" style="text-align:right;">
	<?php
	//echo "<pre>";
	//print_r($field);
	$ticket = unserialize($field['value']);
	//print_r($ticket);$ticket_details = array('tickets'=>$request->input('paid_tickets'), 'price'=>$request->input('ticket_price'), 'currency'=>$request->input('ticket_price'));
	?>
	<b style="color:#0066FF;">{{ $field['label'] }}:</b>
	<span style="color:#FF00FF;">
	@if( isset($ticket['price']) )
		{!! '<b>'.$ticket['tickets']. '</b> Paid tickets. <b>'!!}
		@if( isset($ticket['currency']) )
		{!! $ticket['currency'].$ticket['price'].'</b> for one ticket.' !!}
		@endif
	@elseif( isset($ticket['tickets']) )
		{!! '<b>'.$ticket['tickets']. '</b> Free tickets.' !!}
	@else
		{{'No Tickets.'}}
	@endif
	</span>
</div>