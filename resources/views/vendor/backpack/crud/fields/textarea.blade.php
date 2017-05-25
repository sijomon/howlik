<!-- textarea -->
  <div class="form-group">
    <label>{{ $field['label'] }}</label>
    <textarea
    	class="form-control"

    	@foreach ($field as $attribute => $value)
    		{{ $attribute }}="{{ $value }}"
    	@endforeach

    	>{{ (isset($field['value'])) ? stripcslashes($field['value']) : '' }}</textarea>
  </div>