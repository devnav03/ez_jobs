@extends('frontend.layouts.app')
@section('content')

<section class="breadcrum">
<div class="container"> 
<div class="row"> 
<div class="col-md-6">
<h1>FAQ's</h1>
</div>
<div class="col-md-6">
<ul>
<li><a href="{{ route('home') }}">Home</a></li>
<li>/ &nbsp; FAQ's</li>
</ul> 
</div>
</div>
</div>
</section>

<section class="faq-index">
<div class="container"> 
<div class="row">

<div class="accordion" id="accordionExample">
@php
$i = 0;
@endphp  
@foreach($faqs as $faq)
@php
$i++;
@endphp
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-link @if($i != 1) collapsed @endif" type="button" data-toggle="collapse" data-target="#collapseOne{{ $i }}" aria-expanded="true" aria-controls="collapseOne{{ $i }}">{{ $faq->title }}</button>
      </h2>
    </div>

    <div id="collapseOne{{ $i }}" class="collapse @if($i == 1) show @endif" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
        {!! $faq->description !!}
      </div>
    </div>
  </div>
@endforeach

  
</div>


</div>
</div>
</section>

@stop