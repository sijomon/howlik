<!-- Your new field type -->
<div class="form-group">
	<label>{{ $field['label'] }}</label>
	<input
			type="file"
			class="file"
			id="{{ $field['name'] }}-fileinput"

	@foreach ($field as $attribute => $value)
		@if (in_array($attribute, ['name', 'value']))
			@if($attribute == 'value')
				{{ $attribute }}="{{ old($field['name']) ? old($field['name']) : $value }}"
			@else
				{{ $attribute }}="{{ $value }}"
			@endif
		@endif
	@endforeach
	>
</div>


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->checkIfFieldIsFirstOfItsType($field, $fields))

	{{-- FIELD CSS - will be loaded in the after_styles section --}}
	@push('crud_fields_styles')
	{{-- YOUR CSS HERE --}}
	@endpush

	{{-- FIELD JS - will be loaded in the after_scripts section --}}
	@push('crud_fields_scripts')
	<script language="javascript">
		/* Initialize fileinput values */
		$('#<?php echo $field['name']; ?>-fileinput').fileinput(
		{
			'showPreview':true,
			'allowedFileExtensions':[<?php echo $field['allowedFileExtensions']; ?>],
			'browseLabel':'Browse',
			'showUpload':false,
			'showRemove':false,
			'maxFileSize':1000,
			@if (isset($field['value']) and $field['value'] != '')
			@if (isset($field['preview']))
			/* setup initial preview with data keys */
			initialPreview: [
				@if (count($field['initialPreview']) > 0)
				@foreach($field['initialPreview'] as $srcUrl)
				'<img src="<?php echo $srcUrl; ?>" class="file-preview-image" data-no-retina>',
				@endforeach
				@endif
			],
			@endif
			@if (isset($field['initialPreviewConfig']))
			/* initial preview configuration */
			initialPreviewConfig: [
				{
					caption: '<?php echo (isset($field['initialPreviewConfig']['width']) ? $field['initialPreviewConfig']['width'] : ''); ?>',
					width: '<?php echo (isset($field['initialPreviewConfig']['width']) ? $field['initialPreviewConfig']['width'] : '120px'); ?>',
					url: '<?php echo $field['initialPreviewConfig']['url']; ?>',
					key: <?php echo (isset($field['initialPreviewConfig']['key']) ? $field['initialPreviewConfig']['key'] : 0); ?>,
					@if (isset($field['initialPreviewConfig']['extra']))
					extra: {id: <?php echo (isset($field['initialPreviewConfig']['extra']['id']) ? $field['initialPreviewConfig']['extra']['id'] : 0); ?>}
					@endif
				}
			]
			@endif
			@endif
		});
	</script>
	@endpush

@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}