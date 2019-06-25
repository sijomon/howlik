<!-- text input -->
  <div class="form-group">
    <label style="width:100%">{{ $field['label'] }}</label>
    <input
    	type="text"
    	class="form-control"
		@foreach ($field as $attribute => $value)
			{{ $attribute }}="{{ $value }}"
		@endforeach
    />
  </div>
