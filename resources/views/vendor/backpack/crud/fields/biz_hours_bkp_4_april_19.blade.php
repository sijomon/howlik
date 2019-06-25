<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Business Hours -->
<div class="info">
	<?php
	/*$ticket = unserialize($field['value']);
	echo "<pre>";
	print_r($ticket);*/
	?>
	<label>{{ $field['label'] }}</label>
	<div class="biz-hours" id="biz-hours">
        <div class="biz-hours-box">
        	@if(isset($field['value']) && $field['value']!='')
				{{--*/ $bizhrs = unserialize($field['value']); /*--}}
				{{--*/ $bizDayA = array(0=>'Mon',1=>'Tue',2=>'Wed',3=>'Thu',4=>'Fri',5=>'Sat',6=>'Sun'); /*--}}
				@foreach($bizhrs as $key => $value)
					{{--*/ $bizhrsA = explode(' ', $value); /*--}}
					{{--*/ $timeSt = strtotime($bizhrsA[1]); /*--}}
					{{--*/ $timeEd = strtotime($bizhrsA[2]); /*--}}
					<div><span><b>{{$bizDayA[$bizhrsA[0]]}} </b></span><span>{{date("h:i A", strtotime($timeSt))}} </span><span>- </span><span>{{date("h:i A", strtotime($timeEd))}} {{($bizhrsA[2]=='00.00')?'(midnight next day) ':''}}</span><a href="#" class="rem-bh">Remove</a><input name="biz_hours[]" value="{{$value}}" type="hidden"></div>
				@endforeach
			@endif
		</div>
        <ul class="biz-hours-select">
            <li>{{--*/ $date = '2016-11-21' /*--}}
                <select class="bh-day" id="bh-day">
					@for ($i = 0; $i < 7; $i++)
						<option value="{{ $i }}">{{date("D", strtotime($date))}}</option>
						{{--*/ $date = date ("Y-m-d", strtotime("+1 day", strtotime($date))); /*--}}
					@endfor
                </select>
            </li>
            <li>{{--*/ $time = strtotime('12:00 AM'); /*--}}
                <select class="bh-start" id="bh-start">
					@for ($i = 0; $i < 48; $i++)
						<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}</option>
						{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
					@endfor
                </select>
            </li>
            <li>{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
                <select class="bh-end" id="bh-end" style="width:85px;">
					@for ($i = 0; $i < 48; $i++)
						<option value="{{date('H.i', strtotime($time))}}">{{date("h:i A", strtotime($time))}}@if($i==47){{ ' (midnight next day)'}}@endif</option>
						{{--*/ $time = date ("H:i", strtotime("+30 minutes", strtotime($time))); /*--}}
					@endfor
                </select>
            </li>
            <li>
                <button type="button" id="biz-hr-btn" class="btn btn-default ladda-button"><span>Add Hours</span></button>
            </li>
        </ul>
    </div>
</div>

<style>
	.biz-hours{
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
