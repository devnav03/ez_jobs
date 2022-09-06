@extends('frontend.layouts.app')
@section('content')

<section class="candidate_profile">
<div class="container">  
<div class="row"> 
<div class="col-md-10 offset-md-1"> 
<div class="row">
<div class="col-md-3"> 
<img src="{{ $profile->profile_image }}" alt="Candidate Image">

</div>
<div class="col-md-1"> </div>
<div class="col-md-8"> 
<div class="top-info">  
<h3>{{ $profile->name }} <span><i class="fa-solid fa-location-dot"></i> {{ $profile->city }}</span></h3>
<h6>{{ $profile->cat }}</h6>
<a class="send_message" href="mailto:{{ $profile->email }}"><i class="fa-solid fa-message"></i> Send Message</a>
<a class="send_call" href="tel:{{ $profile->mobile }}"><i class="fa-solid fa-phone-volume"></i> Call</a>
@if($profile->resume)
<a class="send_resume" target="_blank" href="{{ route('home') }}{{ @$profile->resume }}"><i class="fa-solid fa-download"></i> Resume</a>
@endif
</div>
<div class="about-info">
<h5><i class="fa-solid fa-user"></i> About</h5>
<h6>Contact Information</h6>
<table>
<tr>
<td style="min-width: 130px;">Phone:</td>  
<td>{{ $profile->mobile }}</td> 
</tr>  
<tr>
<td>Email:</td>  
<td>{{ $profile->email }}</td> 
</tr>
<tr>
<td>Address:</td>  
<td>{{ $profile->address }}, {{ $profile->city }}, {{ $profile->state }}, {{ $profile->country }}</td> 
</tr> 
</table>
<h6>Basic Information</h6>
<table>
<tr>
<td style="min-width: 130px;">Birthday:</td>  
<td>{{ $profile->date_of_birth }}</td> 
</tr>  
<tr>
<td>Gender:</td>  
<td>{{ $profile->gender }}</td> 
</tr> 
</table>


</div>

</div>
</div>
</div>
</div>
</div>
</section>

@endsection    