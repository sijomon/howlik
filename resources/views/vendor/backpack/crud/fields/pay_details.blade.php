<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Payment Details -->

	<?php
	$payDet = unserialize($field['value']);
	/*echo "<pre>";
	print_r($payDet);*/
	?>

<label>Merchant Email</label>
<input class="form-control" name="{{$field['name']}}[merch_email]" label="Merchant Email" value="{{$payDet['merch_email']}}" type="text">

<style>
	.pay-details{
		overflow:hidden;
	}
	.biz-hours-box{
		overflow:hidden;
		margin-bottom:5px;
	}
	.biz-hours-select{
		float:left;
		list-style:none;
		padding-left:0;
	}
	.biz-hours-select li{
		float:left;
		margin-right:3px;
	}
	.biz-hours-select select{
		padding:7px 4px;
	}
</style>