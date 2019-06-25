@extends('classified.layouts.layout')

@section('content')
<?php //echo "<pre>";print_r($all_offers); exit; ?>


 <div class="event_tab">
        <div class="container">
          <ul class="nav nav-tabs">
            <li @if (!count($errors) > 0)class="active" @endif><a data-toggle="tab" href="#home"> {{ t('Lastest offers') }} </a></li>
            <li><a data-toggle="tab" href="#menu1"> {{ t('Popular Offers') }}</a></li>
            <li><a data-toggle="tab" href="#menu3">{{ t('Gift Cards') }}</a></li>
            <li @if (count($errors) != 0) class="active" @endif ><a data-toggle="tab" href="#menu2"> {{ t('Post an Offer') }}</a></li>
          </ul>
          <div class="tab-content">
            <div id="home" class="tab-pane fade <?php if (!count($errors) > 0): echo 'in active'; endif; ?>">
              <div class="special_offerrs">
			  <?php $pos= 0; 
				/*$i=1;
				$j=4*$i;*/
				?>
			  @foreach ($all_offers as $offers)
			  
			   <?php 
						      $pos = $pos + 1 ;
						      $offer_image  = "http://localhost/Classified/".$offers->image;
                              $company_logo = "http://localhost/Classified/".$offers->company_logo;
							  $offer_link  = "http://localhost/Classified/offers/".$offers->id;
							  
                         ?>
			  <?php //echo "<pre>";print_r($offers);?>
			@if($offers->giftCard == 0 && $offers->active == 1)
                <div class="offer_holder">
                  <div class="top_con">
                    <p>{{$offers->company_name}}</p>
                   <span>{{$offers->city_name}}</span>
                    </div>
				<a href="{{lurl('/offers/'.$offers->id)}}"> 
                  <div class="hovereffect"> <img src="{{ url($offers->image) }}" pagespeed_url_hash="2541112653" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>
                    <div class="overlay">
                      <h2>{{$offers->offer_percentage}}%</h2>
                    </div>
                  </div>
				  </a>
                  <div class="bottom_con">
                    <p><strong>{{$offers->offer_percentage}}% off</strong> {{ str_limit($offers->description,50) }}</p>
                  </div>
                </div>
				@endif
				@endforeach
              
              </div>
            </div>
            <div id="menu1" class="tab-pane fade">
              <h3>Menu 1</h3>
              <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>
			<div id="menu3" class="tab-pane fade">
              
			   <div class="special_offerrs">
			  <?php $pos= 0; 
				/*$i=1;
				$j=4*$i;*/
				?>
			  @foreach ($all_offers as $offers)
			  
			   <?php 
						      $pos = $pos + 1 ;
						      $offer_image  = "http://localhost/Classified/".$offers->image;
                              $company_logo = "http://localhost/Classified/".$offers->company_logo;
							  $offer_link  = "http://localhost/Classified/offers/".$offers->id;
							  
                         ?>
			  <?php //echo "<pre>";print_r($offers);?>
			 @if($offers->giftCard == 1 && $offers->active == 1)
                <div class="offer_holder">
                  <div class="top_con">
                    <p>{{$offers->company_name}}</p>
                    <span>{{$offers->city_name}}</span>
                    </div>
				<a href="{{lurl('/offers/'.$offers->id)}}"> 
                  <div class="hovereffect"> <img src="{{ url($offers->image) }}" pagespeed_url_hash="2541112653" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>
                    <div class="overlay">
                      <h2>{{$offers->offer_percentage}}%</h2>
                    </div>
                  </div>
				  </a>
                  <div class="bottom_con">
                    <p><strong>{{$offers->offer_percentage}}% off</strong> {{ str_limit($offers->description,50) }}</p>
                  </div>
                </div>
				@endif
				@endforeach
             
              </div>
			  
			  
            </div>
            <div id="menu2" class="tab-pane fade <?php if (count($errors) > 0): echo 'in active'; endif; ?>">
            
			<div class="event_tab_holder"> 

		  @if (count($errors) > 0)
					<div class="">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('Oops ! An error has occurred. Please correct the red fields in the form') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif
				
		  
<form method="POST" action="{{lurl('post-offer')}}"  enctype='multipart/form-data'>
    <div class="event_detail_section offer">
      <div class="detai_section">
        <div class="top_head"> <span>1</span>
          <h4>{{ t('Post an Offer')}}</h4>
        </div>
        <div class="eve_conte">
          <!--<form>-->
		  
            <label>{{ t('offer title')}}*</label>
            <input type="text" class="form-control" name="offer_title" placeholder="{{ t('give it a short distinct name')}}">
			
           <!-- <label>{{ t('offer location')}}*</label>
            <input type="text" class="form-control" name="offer_location" placeholder="{{ t('specify where its held')}}">
			-->
			<!-- Country -->
			@if(!$ip_country)
				<div class="form-group required <?php echo ($errors->has('country')) ? 'has-error' : ''; ?>">
					<label class="col-md-3 control-label" for="country">{{ t('Your Country') }} <sup>*</sup></label>
					<div class="col-md-8">
						<select id="country" name="country" class="form-control sselecter">
							<option value="0" {{ (!old('country') or old('country')==0) ? 'selected="selected"' : '' }}> {{ t('Select your Country') }} </option>
							@foreach ($countries as $item)
								<option value="{{ $item->get('code') }}" {{ (old('country', ($country) ? $country->get('code') : 0)==$item->get('code')) ? 'selected="selected"' : '' }}>{{ $item->get('name') }}</option>
							@endforeach
						</select>
					</div>
				</div>
			@else
				<input id="country" name="country" type="hidden" value="{{ $country->get('code') }}">
			@endif
			<div id="locationBox"
				 class="form-group required <?php echo ($errors->has('location')) ? 'has-error' : ''; ?>">
				<!--<label class="col-md-3 control-label form-control" for="location">{{ t('Location') }} <sup>*</sup></label>-->
				<label>{{ t('offer location')}}*</label>
				
					<select id="location" name="location" class="form-control sselecter">
						<option value="0" {{ (!old('location') or old('location')==0) ? 'selected="selected"' : '' }}> {{ t('Select your Location') }} </option>
					</select>
				
			</div>
			
			<input type="hidden" id="sub_location" name="sub_location" value="" />
			<input type="hidden" id="has_children" name="has_children" value="{{ old('has_children') }}">

			<!-- City -->
			<div id="city_box"
				 class="form-group required <?php echo ($errors->has('city')) ? 'has-error' : ''; ?>">
				<!--<label class="col-md-3 control-label" for="city">{{ t('City') }} <sup>*</sup></label>-->
				<label>{{ t('City') }}*</label>
					<select id="city" name="offer_location" class="form-control sselecter">
						<option value="0" {{ (!old('city') or old('city')==0) ? 'selected="selected"' : '' }}> {{ t('Please select your location before') }} </option>
					</select>
				
			</div>
			
			
            <div class="span_holder"> <!--<span><i class="fa fa-desktop" aria-hidden="true"></i>online event</span> <span><i class="fa fa-map-marker marker_section" aria-hidden="true"></i>enter address</span>-->
			</div>
            
			<label>{{ t('Offer percentage')}}*</label>
            <input type="text" class="form-control" name="percentage" placeholder="{{ t('specify the offer percentage')}}">
			
			<div class="gift">
            
				<label class="libin"><input type="checkbox" name="gift" id="gift" class="gift_checkbox" value="1">{{ t('Gift Card')}}</label>
			  <input id="gift_code"  name="gift_code" class="form-control" type="text" placeholder="{{ t('Enter coupen code if any')}}"/>
            </div>
			
						
			<div class="span_holder"><!-- <span><i class="fa fa-desktop" aria-hidden="true"></i>schedule multiple events </span> <span><i class="fa fa-map-marker" aria-hidden="true"></i> time & date setting(AST)</span>--> </div>
             <label>{{ t('offer image')}}</label>
			<div class="image_drop">
			
             
              <!--<img src="images/upload-files-here.png" pagespeed_url_hash="19921898" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>
				-->
				  <div class="dropzone" id="Offermydropzone" name="mydropzone">
					
				  </div>
			
            </div>
			<input type="hidden" id="offer_image" name="offer_image" value=""/>
			
          <!--</form>-->
        </div>
      </div>
      <div class="descreption"> 
          <label>{{ t('Offer descreption')}}</label>
<style>
.cke_top, .cke_contents, .cke_bottom {
    display: block;
    overflow: hidden !important;
    width: 100% !important;
}
.tst_area {
    width: 100%;
    float: left;
}
label.libin {
    float: left;
    width: 106px;
}
</style>    
		  
		  <!--<img src="images/html_editor.jpg" pagespeed_url_hash="3410061205" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>-->
	<div class="tst_area">

		<textarea id="messageArea" name="messageArea" rows="7" class="form-control ckeditor" placeholder="Write your message.."></textarea>
		
	</div>
	      <div class="descre_box">
			
			<label>{{ t('Company name')}}</label>
            <input type="text" class="form-control" name="company_name" placeholder="{{ t('give it a short distinct name')}}">
			
			<label>{{ t('Company url')}}</label>
            <input type="text" class="form-control" name="company_url" placeholder="{{ t('give it a short distinct name')}}">
			
          </div>
		
		<label>{{ t('Company logo')}}</label>
		<div class="image_drop">
			            
              <!--<img src="images/upload-files-here.png" pagespeed_url_hash="19921898" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"/>
				-->
				  <div class="dropzone" id="mydropzone1" name="mydropzone1">
					
				  </div>
				 <button type="submit" class="btn btn-primary btn-lg offer">{{ t('Submit')}}</button>
        </div>
		<input type="hidden" id="company_logo" name="company_logo" value=""/>
		
	 </div>
	 
	
    </div>
    
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	
</form>
	</div>
			
            
			
			</div>
          </div>
        </div>
      </div>
	  
	   <script language="javascript">
			//var countries = {};
			var countries = <?php echo (isset($countries)) ? $countries->toJson() : '{}'; ?>;
			var countryCode = '<?php echo old('country', ($country) ? $country->get('code') : 0); ?>';
			//alert(countryCode);
			//var countryCode = 'IN';
			var lang = {
				'select': {
					'country': "Select a country",
					'loc': "Select a location",
					'subLocation': "Select a sub-location",
					'city': "Select a city"
				}
			};
			
			var loc = '0';
			var subLocation = '0';
			var city = '0';
			var hasChildren = '';
			</script>
	  
	  <script src="{{ url('/assets/js/app/d.select.location.js') }}"></script>
@stop