@extends('frontend.layouts.app')
@section('content')
<section class="breadcrum">
<div class="container"> 
<div class="row"> 
<div class="col-md-6">
<h1>Terms and Conditions</h1>
</div>
<div class="col-md-6">
<ul>
<li><a href="{{ route('home') }}">Home</a></li>
<li>/ &nbsp; Terms and Conditions</li>
</ul> 
</div>
</div>
</div>
</section>

<div class="clearfix"></div>

  <!-- ABOUT-MAIN STARTS -->
    <section class="terms_condition">
      <div class="container">
        <div class="row">
          <div class="col-md-12">  
            {!! $terms_and_conditions->terms_condition !!}
          </div>
        </div>
      </div>
    </section>
  <!-- CONTACT-MAIN ENDS -->
@endsection  