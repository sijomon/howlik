@extends('classified.layouts.layout')
<?php
// Get city for Google Maps
$city = \App\Larapen\Models\City::where('country_code', $country->get('code'))->orderBy('population', 'desc')->first();
?>
@section('javascript-top')
	@parent
	<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.googlemaps.key') }}" type="text/javascript"></script>
@endsection

@section('search')
	@parent
	@include('classified.pages.inc.contact-intro')
@endsection

@section('content')
	
    <div class="listing_holder">
    <div class="container">
    
         @if (count($errors) > 0)
					<div class="col-lg-12">
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

				@if (Session::has('flash_notification.message'))
					<div class="container" style="margin-bottom: -10px; margin-top: -10px;">
						<div class="row">
							<div class="col-lg-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
    
    
    
    
    
      <div class="Trending_section aut">
        <div class="listing_head conta"> <span class="trending abut">{{ t('Contact Howlik') }}</span>
          <h6>{{ t('Please fill up the contact form below and we will get back to you as soon as possible') }}</h6>
        </div>
      </div>
      <div class="contact_holder">
        
          <form class="form-horizontal" method="post" action="{{ lurl(trans('routes.contact')) }}">
          
          <div class="conta_col1">
          {!! csrf_field() !!}
            <label>{{ t('First Name') }}<font>*</font></label>
            <input id="first_name" name="first_name" type="text" placeholder="{{ t('First Name') }}"
													   class="form-control" value="{{ old('first_name') }}">
            <label>{{ t('Last Name') }}<font>*</font></label> 
            <input id="last_name" name="last_name" type="text" placeholder="{{ t('Last Name') }}"
													   class="form-control" value="{{ old('last_name') }}">        
            <!--<label>Company Name<font>*</font></label>                    
            <input id="company_name" name="company_name" type="text" placeholder="{{ t('Company Name') }}"
													   class="form-control" value="{{ old('company_name') }}"> -->                                 
            <label>{{ t('Email Address') }}<font>*</font></label>
            <input id="email" name="email" type="text" placeholder="{{ t('Email Address') }}" class="form-control"
													   value="{{ old('email') }}">
            <label>{{ t('Mobile') }}</label>
            <input type="text"  id="mobile" name="mobile" >
            <label>{{ t('Type Of Feedback') }}</label>
            <select>
              <option value="email">{{ t('Email') }}</option>
              <option value="phone">{{ t('Phone') }}</option>
            </select>
        
        </div>
        <div class="conta_col2">
         
            <label>{{ t('Message') }}<font>*</font></label>
            <textarea class="form-control" id="message" name="message" placeholder="{{ t('Message') }}"
													  rows="7">{{ old('message') }}</textarea>
          </div>	
           <!-- <a href="#">Submit</a>-->
            
            <button type="submit" class="btn btn-primary btn-lg">{{ t('Submit') }}</button>
            
          </form>
        </div>
      </div>
    </div>
 
    
    
@endsection

@section('javascript')
	@parent
	<script src="{{ url('assets/js/form-validation.js') }}"></script>
	
@endsection
