<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- Multiple Checkboxes -->
<style>
.#key_div{
	float:left;
	width:100%;
	padding:10px 0;
}
#key_div div{
	float:none !important;
	display:inline-block;
}
</style>
<div class="info">
	<input type="hidden" id="category_id_val" name="category_id_val" value="{{(isset($field['value']) && $field['value']!='')?$field['value']:''}}" />
	<label>{{ $field['label'] }}</label>
	<div id="key_div">
	
	</div>
</div>