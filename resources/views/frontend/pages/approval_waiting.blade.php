@extends('frontend.layouts.app')
@section('content')
<section class="breadcrum">
  <div class="container"> 
    <div class="row"> 
      <div class="col-md-6">
      <h1>Waiting For Approval</h1>
      </div>
      <div class="col-md-6">
      <ul>
      <li><a href="{{ route('home') }}">Home</a></li>
      <li>/ &nbsp; Waiting For Approval</li>
      </ul> 
      </div>
    </div>
  </div>
</section>

  <section class="waiting-for-approval">
    <div class="container">
      <div class="row"> 
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <h3>Dear {{ $user->name }}, </h3>
          <p>Kindly wait for admin approval.</p>
        </div>
      </div>
    </div>
  </section>
  @endsection  