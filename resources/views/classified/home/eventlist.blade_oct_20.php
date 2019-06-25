@extends('classified.layouts.layout')

@section('content')


<?php
              $event_types = DB::table("event_type")
						->select('name')
						->where("id", "=", $events[0]->event_type_id) // "=" is optional
						->get();
						
			 $event_type_name	= 		$event_types[0]->name;
			 
			 $image_url = "http://www.howlik.com/".$events[0]->event_image1;
		   
 ?>
 
 <div class="listing_holder">
    <div class="container">
      <div class="Trending_section">
        <div class="listing_head"> <span class="trending">{{ ucwords($event_type_name) }}</span></div>
      </div>
      <div class="offer_holder">
        <div class="offer_iimgsection eve"> <img src="{{ $image_url }}"/> </div>
        <div class="offer_desc events">
          <div class="dre">
            
               
            <h4>{{ ucwords($events[0]->event_name) }}</h4>
            <p><?php echo date('F d',strtotime($events[0]->event_date)); ?></p>
            
            
            
            
             </div>
             <div class="add_date">
          <div class="datee">
            <h4>DATE AND TIME</h4>
            <ul>
             <li><?php echo date('jS \of M Y h:i A',strtotime($events[0]->event_starttime)); ?></li>
             
             <li style="text-align:center;"> - </li>
              
              <li><?php echo date('jS \of M Y h:i A',strtotime($events[0]->event_endtime)); ?></li>
              
            </ul>
          </div>
          <div class="add">
            <h4>Location</h4>
            <ul>
              <li>{{ $events[0]->event_place }}</li>
              </ul>
          </div>
        </div>
        </div>
      </div>
      <div class="dre_holder">
        <div class="descre">
        <h4>DESCRIPTION</h4>
        
          {{ $events[0]->about_event }}
        </div>
        
      </div>
    </div>
  </div>
 
@stop