@extends('frontend.layouts.app')
@section('content')

<section class="candidate_profile">
<div class="container">  
<div class="row"> 
<div class="col-md-10 offset-md-1"> 
<div class="row">
<div class="col-md-3"> 
<img src="{{ $profile->profile_image }}" alt="Candidate Image">
<h6 style="text-transform: uppercase; color: #9199A3; font-size: 14px; margin-top: 45px; padding-bottom: 3px;">Education</h6>
<p style="font-size: 14px;">{{ $profile->education }}</p>
<h6 style="text-transform: uppercase; color: #9199A3; font-size: 14px; margin-top: 45px; padding-bottom: 3px;">Experience</h6>
<p style="font-size: 14px;">{{ $profile->experience_years }}.{{ $profile->experience_months }} Years</p>
<h6 style="text-transform: uppercase; color: #9199A3; font-size: 14px; margin-top: 45px; padding-bottom: 3px;">Current CTC</h6>
<p style="font-size: 14px;">{{ $profile->salary_lakhs }}.{{ $profile->salary_thousands }} LPA</p>
</div>
<div class="col-md-1"> </div>
<div class="col-md-8"> 
<div class="top-info">  
<h3>{{ $profile->name }} <span><i class="fa-solid fa-location-dot"></i> {{ $profile->city }}</span></h3>
<h6>{{ $profile->cat }}</h6>
<a class="send_message" href="{{ route('chat', $profile->id) }}"><i class="fa-solid fa-message"></i> Send Message</a>
<a class="send_call" href="tel:{{ $profile->mobile }}"><i class="fa-solid fa-phone-volume"></i> Call</a>
@if($profile->resume)
<a class="send_resume" target="_blank" href="{{ route('home') }}{{ @$profile->resume }}"><i class="fa-solid fa-download"></i> Resume</a>
@endif
@php
$save_status = get_candidate_save_status($profile->id);
@endphp
<div id="button{{ $profile->id }}" style="position: absolute; right: 0px; top: 0px;">
@if($save_status == 0)   
   <button value="{{ $profile->id}}" type="button" onclick="saveCandidate(this.value)" title="Save Candidate" class="hoverbg-primary-50 text-primary-500 plain-button icon-button"><svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
   </button>
@else
   <button value="{{ $profile->id}}" type="button" onclick="saveCandidate(this.value)" title="Remove Candidate from save" class="hoverbg-primary-50 text-primary-500 plain-button icon-button"><i class="fa-solid fa-bookmark"></i>
   </button>
@endif   
</div>
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
<h6>Skills</h6>
{!! $profile->key_skills !!}
</div>

</div>
</div>
</div>
</div>
</div>
</section>

@endsection    