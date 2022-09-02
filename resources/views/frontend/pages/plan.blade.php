@extends('frontend.layouts.app')
@section('content')


<section class="membership-index">
<div class="container">  
<div class="profile-box"> 
<h1>Quick & Easy Job Posting - Get Quality Applies</h1>
<div class="row">
@php
$i = 0;
@endphp   
@foreach($job_plans as $plan)
@php
$i++;
@endphp   
    <div class="col-md-4 mx-auto">
      <div class="plan-box">
        <h6><i class="fa-solid fa-indian-rupee-sign"></i>  {{ $plan->price }}</h6>
        <h5>{{ $plan->name }}</h5>
        <p>{{ $plan->description }}</p>
        <ul>
          @if($plan->job_description == 1)
          <li><i class="fa-solid fa-circle-check"></i> Detailed Job Description </li>
          @else
          <li><i class="fa-solid fa-circle-check"></i> 250 Characters in Job Description </li>
          @endif 

          @if($plan->job_search == 1)
          <li><i class="fa-solid fa-circle-check"></i> Boost On Job Search Page </li>
          @else
          <li class="grey"><i class="fa-solid fa-circle-xmark"></i> Boost On Job Search Page </li>
          @endif 

          @if($plan->job_branding == 1)
          <li><i class="fa-solid fa-circle-check"></i> Job Branding</li>
          @else
          <li class="grey"><i class="fa-solid fa-circle-xmark"></i> Job Branding</li>
          @endif 

          @if($plan->city == 1)
          <li><i class="fa-solid fa-circle-check"></i> For All Cities </li>
          @else
          <li><i class="fa-solid fa-circle-check"></i> For Non-Metro Cities </li>
          @endif 
        </ul>
        <form method="POST" action="{{ route('buy') }}">
          {{ csrf_field() }}
        <ul class="quantity_box">
          <li><label>Quantity:</label> 
            <select name="quantity" onChange="getQuantity{{$i}}(this.value);">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select> 
          </li>
          <input type="hidden" value="{{ $plan->price }}" name="price" class="price{{ $i }}">
          <li><span class="pull-right" id="price{{ $i }}"><i class="fa-solid fa-indian-rupee-sign"></i>{{ $plan->price }}</span> <label class="pull-right">Total:</label>

          </li>
        </ul>
          <input type="hidden" value="{{ $plan->id }}" name="plan_id"> 
          <button type="submit">Buy Now</button>
        </form>
      </div>
    </div>
  @endforeach 
</div>
</div>
<div class="profile-box"> 
<h1>Get A Comprehensive Job Search Pack</h1>
<div class="row">
@php
$i = 0;
@endphp   
@foreach($profile_plans as $plan)
@php
$i++;
@endphp   
    <div class="col-md-4 mx-auto">
      <div class="plan-box">
        <h6><i class="fa-solid fa-indian-rupee-sign"></i>  {{ $plan->price }}</h6>
        <h5>{{ $plan->name }}</h5>
        <p>{{ $plan->description }}</p>
        <ul>
          <li><i class="fa-solid fa-circle-check"></i> {{ $plan->profile_view }} Profile Views </li>
          <li><i class="fa-solid fa-circle-check"></i> {{ $plan->duration }} Days  </li>
        </ul>
        <form method="POST" action="{{ route('buy') }}">
          {{ csrf_field() }}
          <input type="hidden" value="{{ $plan->id }}" name="plan_id"> 
          <button type="submit">Buy Now</button>
        </form>
      </div>
    </div>
  @endforeach 
</div>
</div>
</div>
</section>












@endsection    



