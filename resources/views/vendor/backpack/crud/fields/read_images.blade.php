<!-- read_images -->
<div class="form-group">
	<input type="hidden" name="edit_url" value="{{ Request::url() }}">
	<label>{{ $field['label'] }}</label>
	<?php $entity_model = $crud['model']::find(\Illuminate\Support\Facades\Request::segment(3)); ?>

	<div style="display: block; text-align: center;">
	@if (!is_null($entity_model))
		@foreach ($entity_model->{$field['entity']} as $connected_entity_entry)
			<div style="margin: 10px 5px; display: inline-block;">
				<img src="{{ url('pic/x/cache/medium/' . $connected_entity_entry->{$field['attribute']}) }}">
				<div style="text-align: center; margin-top: 10px;">
					<a href="{{ url('/admin/picture/' . $connected_entity_entry->id . '/edit') }}" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a>&nbsp;
					<a href="{{ url('/admin/picture/' . $connected_entity_entry->id) }}" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>
				</div>
			</div>
		@endforeach
	@else
		No image.
	@endif
	</div>
	<div style="clear: both;"></div>
</div>