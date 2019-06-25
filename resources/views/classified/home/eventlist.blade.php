@extends('classified.layouts.layout')

@section('content')
<?php
	$month           =   date('F',strtotime($events->event_date));
	$year            =   date('Y',strtotime($events->event_date));
	$date_1          =   date('d',strtotime($events->event_date));
	$event_month     =   date('M',strtotime($events->event_starttime)); 
	$event_time      =   date('h:i A',strtotime($events->event_starttime)); 
	$event_date      =   date('d',strtotime($events->event_starttime));
	$event_day       =   date('l',strtotime($events->event_starttime));
	$event_end_time  =   date('h:i A',strtotime($events->event_endtime)); 
	$event_end_date  =   date('d',strtotime($events->event_endtime));
	$event_end_day   =   date('l',strtotime($events->event_endtime));
?>
<div class="listing_holder">
  <div class="container">
    <div class="Trending_section">
      <div class="listing_head"> </div>
    </div>
    <div class="event_holsection">
      <div class="section_event_holder">
        <h4>{{ $month }} , {{ $year }}</h4>
        <div class="date_holder1">
          <div class="top_date"> <span class="da_no"> {{ $date_1 }} </span> <span class="month"> {{ $event_month }} </span> <span class="tim_me"> {{ $event_time }} </span> </div>
          <div class="date_hed">
            <h4> {{ ucwords($events->event_name) }}</h4>
            <i class="fa fa-map-marker" aria-hidden="true"></i><span>{{ ucwords($events->event_type_name) }} </span> </div>
        </div>
        <div class="list_event"> <img src="{{ url($events->event_image1) }}"/>
          <h4>{{ ucwords($events->event_name) }}</h4>
          {!! $events->about_event !!} </div>
        <div class="time_holder">
          <ul>
            <li>Time</li>
            <li>{{ $event_month }} {{ $event_date }}  ( {{ ucwords($event_day) }}) {{ $event_time }}</li>
            <li> to </li>
            <li>{{ $event_month }} {{ $event_end_date }}  ( {{ ucwords($event_end_day) }}) {{ $event_end_time }}</li>
          </ul>
        </div>
        <div class="location">
          <ul>
            <li>Location</li>
            <li>{{ $events->event_place }}</li>
            <li>{{ $events->country_name }}</li>
          </ul>
        </div>
      </div>
      <div class="section_event_list">
        <div class="list-category">
          <h4>{{t('events')}}</h4>
          <div class="main_eveholder"> @foreach ($all_events as $events)
            <a href="{{ lurl('events/'.$events->id) }}">
            <div class="img_eve">
              <div class="im_eve"> <img src="{{ url($events->event_image1) }}"/> </div>
              <div class="event_listcontent">
                <p>{{ ucwords($events->event_name) }}</p>
                <span class="img_wid lib_float event"><img src="url(assets/frontend/images/location-pin.svg)"></span> <span class="im_tst">{{ $events->event_place }}</span> </div>
            </div>
            </a> @endforeach </div>
        </div>
      </div>
    </div>
    <!--<div class="location_map" id="map" > -->
  </div>
</div>
</div>
<div id="address" style="margin-left:50px;">
  <script type="text/javascript" src="https://www.webestools.com/google_map_gen.js?lati=42.31&long=-1.32&zoom=7&width=1255&height=400&mapType=normal&map_btn_normal=yes&map_btn_satelite=yes&map_btn_mixte=yes&map_small=yes&marqueur=yes&info_bulle="></script>
</div>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&amp;language=en"></script>
@stop
