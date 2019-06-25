@extends('classified.layouts.layout')

@section('content')
<div class="listing_holder">
  <div class="container">
    <div class="Trending_section">
      <div class="listing_head"> <span class="trending">{{ $offers->offer }}</span></div>
    </div>
    <div class="offer_holder class">
      <div class="offer_iimgsection">
        <img src="{{ url($offers->image) }}"/> </div>
      <div class="offer_desc">
        <p> {{ $offers->description }} </p>
        <div class="offer_perc"> <a target="_blank" href="{{ $offers->compony_url }}">{{ $offers->offer_percentage }}% {{ t('offer') }}</a></div>
      </div>
    </div>
  </div>
</div>
@stop