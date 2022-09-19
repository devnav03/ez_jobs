@extends('frontend.layouts.app')
@section('content')


@if(count($jobs) == 0)
<h1 style="text-align: center; font-size: 22px; padding-top: 20px; margin-bottom: 0px;">No Jobs Found</h1>
@endif

<section class="featurejob-area rt-pt-40 rt-pt-md-20" style="padding-bottom: 50px;">
   <div class="container">
      <div class="row">
         <div class="col-12">
            <ul class="rt-list" id="jobs-list" style="padding: 0px;">
            @foreach($jobs as $job)   
               <li class="d-block fade-in-bottom  rt-mb-24">
                  <div class="card iconxl-size jobcardStyle1 ">
                     <div class="card-body">
                        <div style="text-align: right; color: green; position: absolute; right: 30px; top: 10px;" id="message{{ $job->id }}"></div>
                        <div class="rt-single-icon-box icb-clmn-lg ">
                           <div class="icon-thumb">
                              <img src="{!! asset("$job->profile_image") !!}" alt="" draggable="false">
                           </div>
                           <a href="{{ route('job-details', $job->id) }}" class="iconbox-content">
                              <div class="post-info2">
                                 <div class="post-main-title">{{ $job->title }}<span class="badge rounded-pill bg-primary-50 text-primary-500" style="margin-left: 10px;">{{ $job->job_type }}</span>
                                 </div>
                                 <div class="body-font-4 text-gray-600 pt-2">
                                    <span class="info-tools">
                                       <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#C5C9D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#C5C9D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                       </svg>
                                       {{ $job->city }} |
                                    </span>
                                    <span class="info-tools">
                                       {{ $job->salary }}
                                    </span>
                                    <span class="info-tools">
<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.875 3.4375H4.125C3.7453 3.4375 3.4375 3.7453 3.4375 4.125V17.875C3.4375 18.2547 3.7453 18.5625 4.125 18.5625H17.875C18.2547 18.5625 18.5625 18.2547 18.5625 17.875V4.125C18.5625 3.7453 18.2547 3.4375 17.875 3.4375Z" stroke="#C5C9D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M15.125 2.0625V4.8125" stroke="#C5C9D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M6.875 2.0625V4.8125" stroke="#C5C9D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M3.4375 7.5625H18.5625" stroke="#C5C9D6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </svg>
                                       <span class="text-danger">{{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</span>
                                    </span>
                                 </div>
                              </div>
                           </a>
                           <div class="iconbox-extra align-self-center">
                              <div>
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
                           <button title="delete from save" value="{{ $job->id }}" onclick="SaveJob(this.value)" class="text-primary-500 hoverbg-primary-50 plain-button icon-button">
                              <i class="fa-solid fa-bookmark"></i></button> 
                           @endif         

                              </div>
                              </div>
                              @if($applied == 0)
                              <div id="apply_button{{$job->id}}">
                              <button value="{{ $job->id }}" onclick="ApplyJob(this.value)" class="btn btn-primary2-50">
                              <span class="button-icon align-icon-right" style="margin-right: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span><span class="button-text">Apply Now</span></button></div>
                              @else
                              <button class="btn btn-primary2-50" style="background:#d6d8d9;">
                              <span class="button-icon align-icon-right" style="margin-right: 6px;"><i class="fa-solid fa-arrow-right-long"></i></span><span class="button-text">Applied</span></button>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
               </li>
            @endforeach
            </ul>
         </div>
      </div>
   </div>
</section>



@endsection    