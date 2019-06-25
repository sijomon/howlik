@if(Request::segment('2') != 'create')
<style>
	.bsnz_btn_dlt{
		background:#e40046;
		right:17px;
		top:2px;
		position:absolute;
		padding: 3px 6px;
		color:#FFF;
		cursor: pointer;
	}
	.height_100{
		height:100px;
		margin-bottom: 4%;
	}
	.bsnz_img{
		height:100%;
		width:100%;
	}
</style>
<div class="info">

	</br><label>{{ $field['label'] }}</label>
	
	{{--*/ $biz_id	=	''; /*--}}
	@if(isset($field['value']) && $field['value'] != '')
		{{--*/ $biz_id	=	$field['value']; /*--}}
	@endif
	{{--*/ $images	=	\DB::table('businessImages')->where('businessImages.biz_id', $biz_id)->where('businessImages.active', 1)->get(); /*--}}									
	@if(!empty($images))
		{{--*/ $margin = "style='margin-top:10px'"; /*--}}
	@else
		{{--*/ $margin = ''; /*--}}
	@endif
	
	<div class="col-md-12" {{ $margin }}>
		<div class="row">
			@if(!empty($images))
				@foreach($images as $key => $image)
					
					{{--*/ $picBigUrl = ''; /*--}}
					@if (is_file(public_path() . '/uploads/pictures/'. $image->filename))
						{{--*/ $picBigUrl = url('pic/x/cache/big/' . $image->filename); /*--}}
					@endif
					@if ($picBigUrl == '')
						@if (is_file(public_path() . '/'. $image->filename))
							{{--*/ $picBigUrl = url('pic/x/cache/big/' . $image->filename); /*--}}
						@endif
					@endif
					@if ($picBigUrl == '')
						{{--*/ $picBigUrl = url('pic/x/cache/big/' . config('larapen.laraclassified.picture')); /*--}}
					@endif
					
					<div class="col-md-3 height_100" id="img-{{$image->id}}">
						<img src="{{ $picBigUrl }}" class="bsnz_img"/>
						<a class="bsnz_btn_dlt" onclick="deleteBizPic({{$image->id}});"><i class="fa fa-trash"></i></a>
					</div>
					
				@endforeach
			@endif
			<div class="append-img-ajax"></div>
		</div>
	</div>
	
	<div class="col-md-12" style="margin-bottom:10px">	
		<div class="row">
			<div class="dropzone" style="margin-top: 2%;" id="postbizpics"> </div>
			<input type="hidden" value="{{ $biz_id }}" id="bizid" />
		</div>
	</div>
</div>
@endif