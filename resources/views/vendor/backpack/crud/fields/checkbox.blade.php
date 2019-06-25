<!-- checkbox field -->
<div class="col-md-12 checkbox">
	<label>
	  <input type="hidden" name="{{ $field['name'] }}" value="0">
	  <input type="checkbox" @foreach ($field as $attribute => $value)
    		@if( $attribute == 'value' )
    			@if((int) $value == 1)
    			checked = "checked"
    			@endif
    			{{ $attribute }}= "1"
    		@else
    			{{ $attribute }}="{{ $value }}"
    		@endif
			@if (!array_key_exists("value",$field))
				value="1"
			@endif
    	@endforeach> {{ $field['label'] }}
	</label>
</div>
