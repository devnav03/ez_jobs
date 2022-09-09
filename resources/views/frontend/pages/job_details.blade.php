@extends('frontend.layouts.app')
@section('content')
<section class="breadcrum">
<div class="container">	
<div class="row">	
<div class="col-md-6">
<h1>Job Details</h1>
</div>
<div class="col-md-6">
<ul>
<li><a href="{{ route('home') }}">Home</a></li>
<li>/ &nbsp; Job Details</li>
</ul>	
</div>
</div>
</div>
</section>

<section class="job_details">
<div class="container">	
<div class="row">	
<div class="col-md-8">
<div style="color: green; position: absolute; left: 15px; top: -45px; font-size: 17px;" id="message{{ $job->id }}"></div>	
<div class="row">
<div class="col-md-1" style="padding-right: 0px;">
<img src="{!! asset($job->profile_image) !!}" style="border-radius: 8px;" alt="">
</div>
<div class="col-md-11">
<h3>{{ $job->employer_name }} <span style="background: hsl(111deg, 55%, 95%);color: #0BA02C;">Verified</span> <span style="color: #0a65cc;background: #eef5fc;">Featured</span></h3>

</div>
</div>
</div>
<div class="col-md-4">

@if(\Auth::check())
@if(((\Auth::user()->user_type)) != 2)

 <div class="iconbox-extra align-self-center">
                              <div class="pull-left">
                              <div id="button{{$job->id}}">
@php
$saved = check_job_save($job->id);
$applied = check_job_applied($job->id);
@endphp  
                           @if($saved == 0)
                           <button title="Save Job" value="{{ $job->id }}" onclick="SaveJob(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                              <svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#0a66cd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </svg></button> 
                           @else
                           <button title="delete from save" style="margin-right: 10px; margin-top: 1px;" value="{{ $job->id }}" onclick="SaveJob(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                              <i class="fa-solid fa-bookmark"></i></button> 
                           @endif         

                              </div>
                              </div>
                              @if($applied == 0)
                              <div id="apply_button{{$job->id}}" class="pull-right">
                              <button value="{{ $job->id }}" style="background: #0a66cd; color: #fff;padding: 12px 30px;" onclick="ApplyJob(this.value)" class="btn btn-primary2-50">
                              <span class="button-text">Apply Now</span><span class="button-icon align-icon-right" style="margin-left: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span></button></div>
                              @else
                              <button disabled class="btn btn-primary2-50 pull-right" style="background:#d6d8d9;padding: 12px 30px;">
                              <span class="button-text">Applied</span><span class="button-icon align-icon-right" style="margin-left: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span></button>
                              @endif
                           </div>
@endif
@else

<div class="iconbox-extra align-self-center">
<div class="pull-left">
<a href="{{ route('login') }}" style="margin-right: 10px;
    margin-top: 1px;" title="Save Job" class="text-primary-500 hoverbg-primary-50 plain-button icon-button"> 
<svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#0a66cd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg></a>
</div>
<a href="{{ route('login') }}" class="btn btn-primary2-50 pull-right" style="background: #0a66cd; color: #fff;padding: 12px 30px;">
<span class="button-text">Apply Now</span><span class="button-icon align-icon-right" style="margin-left: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span></a>
</div>

@endif



</div>
</div>

<div class="row">	
<div class="col-md-7">
<h4>Job Description</h4>
{!! $job->job_description !!}

<div class="share-job rt-pt-50">
<ul class="rt-list gap-8">
    <li class="d-inline-block body-font-3 text-gray-900">
        Share This Job:
    </li>
    <li class="d-inline-block ms-3">
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('job-details', $job->id) }}">
            <button class="btn btn-outline-plain">
                <span class="f-size-18 text-primary-500"> <span class="iconify" data-icon="bx:bxl-facebook"></span></span>
                <span class="text-primary-500">Facebook</span>
            </button>
        </a>
    </li>
    <li class="d-inline-block">
        <a href="https://twitter.com/intent/tweet?text={{ route('job-details', $job->id) }}">
            <button class="btn btn-outline-plain">
                <span class="f-size-18 text-twitter"> <span class="iconify" data-icon="bx:bxl-twitter"></span></span>
                <span class="text-twitter" style="color: #1da1f2;">Twitter</span>
            </button>
        </a>
    </li>
    <li class="d-inline-block my-lg-2 my-0">
        <a href="http://pinterest.com/pin/create/button/?url={{ route('job-details', $job->id) }}">
            <button class="btn btn-outline-plain">
                <span class="f-size-18 text-pinterest me-1"> <span class="iconify" data-icon="bi:pinterest"></span></span>
                <span class="text-pinterest" style="color: #ca2127;">Pinterest</span>
            </button>
        </a>
    </li>
</ul>
</div>

</div>
<div class="col-md-5">
<div class="job-overview">
<h5>Job Overview</h5>
<div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 rt-mb-32">
                                <div class="single-jSidebarWidget">
                                    <div class="icon-thumb">
                                        <i class="fa-solid fa-calendar"></i>
                                    </div>
                                    <div class="iconbox-content">
                                        <div class="f-size-12">Job Posted</div>
                                        <span class="d-block f-size-14">{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 rt-mb-32">
                                <div class="single-jSidebarWidget">
                                    <div class="icon-thumb">
                                        <i class="fa-solid fa-suitcase"></i>
                                    </div>
                                    <div class="iconbox-content">
                                        <div class="f-size-12">Job Type</div>
                                        <span class="d-block f-size-14">{{ $job->job_type }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 rt-mb-32">
                                <div class="single-jSidebarWidget">
                                    <div class="icon-thumb">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="iconbox-content">
                                        <div class="f-size-12">Job Role</div>
                                        <span class="d-block f-size-14">{{ $job->sub_cat }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 rt-mb-32">
                                    <div class="single-jSidebarWidget">
                                        <div class="icon-thumb rt-mr-17">
                                            <i class="fa-solid fa-graduation-cap"></i>
                                        </div>
                                        <div class="iconbox-content">
                                            <div class="f-size-12 ">Education</div>
                                            <span class="d-block">{{ $job->education }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 rt-mb-32">
                                    <div class="single-jSidebarWidget">
                                        <div class="icon-thumb rt-mr-17">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </div>
                                        <div class="iconbox-content">
                                            <div class="f-size-12">Salary</div>
                                            <span class="d-block">{{ $job->salary }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 rt-mb-32">
                                    <div class="single-jSidebarWidget">
                                        <div class="icon-thumb rt-mr-17">
                                            <i class="fa-solid fa-location-dot"></i>
                                        </div>
                                        <div class="iconbox-content">
                                            <div class="f-size-12">Location</div>
                                            <span class="d-block">{{ $job->city }}, {{ $job->state }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
</div>

</div>
</div>
</div>
</section>






@endsection