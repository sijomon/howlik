<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Radio Group field -->
<div class="radio">
	<b>{{ $field['label'] }}</b>
	@foreach ($field['group'] as $key => $grp)
		<p>
		<input type="radio" name="{{ $field['name'] }}" 
			@foreach ($grp as $attribute => $value)
				@if( $attribute == 'value' )
					@if((int) $value == $field['value'])
					checked = "checked"
					@endif
				@endif
				{{ $attribute }}="{{ $value }}"
			@endforeach
		/><label>{!! $grp['label'] !!}</label>
		</p>
	@endforeach
</div>