<!-- Created : vineeth.kk@shrishtionline.com -->
<!-- More Inof in Business listing -->
<div class="info"></br>

	<?php
		//$ticket = unserialize($field['value']);
		//echo "<pre>";
		//print_r($field);
	?>
	<label>{{ $field['label'] }}</label></br></br>

	<div>
		
		@if(isset($field['value']) && $field['value']!='')
		
			{{--*/ $more_infoA = unserialize($field['value']); /*--}}
			
		@endif
		
		{{--*/ $informations	= \DB::table('businessInfo')->where('businessInfo.translation_lang', 'en')->where('businessInfo.active', 1)->get(); /*--}}									
		
		@if(isset($informations))
		
			{{--*/ $i = '1' /*--}}
			@foreach ($informations as $info)

				<div class="col-md-6">
					<table class="table table-reponsive">
						
						<tr>
							<td style="width: 50%;"> {{ $info->info_title }} </td>
							<td style="width: 50%;"> 
							
								{{--*/ $valuess = unserialize($info->info_vals); /*--}}
								{{--*/ $count	= count($valuess) /*--}}
							
								@if($info->info_type == 1)
									
									@if(isset($more_infoA[$info->translation_of]) && $more_infoA[$info->translation_of] != '')
									
										{{ Form::text('more_info['.$info->translation_of.']', $more_infoA[$info->translation_of], array('class' => 'form-control','id' => 'text_box_'.$i,'placeholder' => $info->info_title )) }}
									
									@else	
										
										{{ Form::text('more_info['.$info->translation_of.']', null, array('class' => 'form-control','id' => 'text_box_'.$i,'placeholder' => $info->info_title )) }}
									
									@endif
									
								@elseif($info->info_type == 2)
									
									@if($count>1)
									
										<select name="more_info[{{$info->translation_of}}]" class="form-control" id="select_box_{{ $i }}" >

											@if(isset($more_infoA[$info->translation_of]) && $more_infoA[$info->translation_of] != '')
											
												<option disabled="disabled"> - - select - - </option>
												
												@for($j = 0; $j < $count; $j++)
												
													<option <?php if($more_infoA[$info->translation_of] == $valuess[$j]) { echo 'selected=selected'; } ?> value="{{ $valuess[$j] }}"> {{ $valuess[$j] }} </option>
													
												@endfor
												
											@else
											
												<option selected="selected" disabled="disabled"> - - select - - </option>
												
												@for($j = 0; $j < $count; $j++)
												
													<option value="{{ $valuess[$j] }}"> {{ $valuess[$j] }} </option>
													
												@endfor
												
											@endif
											
										</select>
										
									@endif
									
								@elseif($info->info_type == 3)
								
									{{--*/ $yesV	= false; /*--}}
									{{--*/ $noV		= true; /*--}}
									
									@if(isset($more_infoA[$info->translation_of]) && $more_infoA[$info->translation_of]==0)
										{{--*/ $yesV	= true; /*--}}
										{{--*/ $noV		= false; /*--}}
									@endif
									
									<label>
									
										{{ Form::radio('more_info['.$info->translation_of.']', 0, $yesV, ['id' => 'radio_'.$i]) }} &nbsp;&nbsp;&nbsp; Yes &nbsp;&nbsp;&nbsp;
										{{ Form::radio('more_info['.$info->translation_of.']', 1, $noV, ['id' => 'radio_'.$i]) }} &nbsp;&nbsp;&nbsp; No
									
									</label>
									
								@endif
								
							</td>
						</tr>
						
					</table>
				</div>
				
			{{--*/ $i ++ /*--}}	
			@endforeach
			
		@endif
		
	</div>
	
</div>
