<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Business Info Values -->

<div class="info" id="biz-info-vals">
	<label>{{ $field['label'] }}</label>
	<div class="biz-info" id="info-vals">
        <div class="info-vals-box">
        	@if(isset($field['value']) && $field['value']!='')
				{{--*/ $infovals = unserialize($field['value']); /*--}}
				@foreach($infovals as $key => $value)
					<div><span><b>{{$value}} </b></span><a href="#" class="rem-bh">Remove</a><input name="info_vals[]" value="{{$value}}" type="hidden"></div>
				@endforeach
			@endif
		</div>
        <ul class="info-select">
            <li>
				<input type="text" name="infoVal" id="infoVal" value="" />
            </li>
            <li>
                <button type="button" id="biz-info-btn" class="btn btn-default ladda-button"><span>Add Values</span></button>
            </li>
        </ul>
    </div>
</div>

<style>
	.biz-info{
		overflow:hidden;
	}
	.info-vals-box{
		overflow:hidden;
		margin-bottom:5px;
	}
	.info-select{
		list-style:none;
		padding-left:0;
		overflow:hidden;
	}
	.info-select li{
		float:left;
		margin-right:3px;
		width:46%;
	}
	.info-select input{
		padding:6px 4px;
		width:100%;
	}
</style>