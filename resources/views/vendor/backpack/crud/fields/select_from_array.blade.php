<!-- select -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <select
    	class="form-control"

    	@foreach ($field as $attribute => $value)
            @if (!is_array($value))
    		{{ $attribute }}="{{ $value }}"
            @endif
    	@endforeach
    	>

        @if (isset($field['allows_null']) && $field['allows_null']==true)
            <option value="">-</option>
        @endif
<?php
if (is_string($field['options'])) {
    $field['options'] = json_decode($field['options'], true);
}
?>
	    	@if (count($field['options']))
	    		@foreach ($field['options'] as $key => $value)
	    			<option value="{{ $key }}"
						@if (isset($field['value']) && $key==$field['value'])
							 selected
						@endif
	    			>{{ $value }}</option>
	    		@endforeach
	    	@endif
	</select>
  </div>