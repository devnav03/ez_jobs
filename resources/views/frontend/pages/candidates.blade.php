@extends('frontend.layouts.app')
@section('content')
<section class="filter_index">
   <div class="container">
      <h6 class="f-size-18" style="margin-bottom: 20px;">Find Candidates</h6>
      <div class="row align-items-center ">
         <div class="col-12 position-relative ">
            <div class="jobsearchBox  bg-gray-10 input-transparent with-advanced-filter height-auto-xl">
               <div class="top-content d-flex flex-column flex-xl-row">
                  <div class="left-content">
                     <div class="sec_tool search-col fromGroup has-icon banner-select no-border" style="    margin-left: 5px;">
                        <select onChange="getState(this.value);" class="rt-selectactive w-100-p select2-hidden-accessible" name="country_name">
                           <option value="">All Country</option>
                           @foreach($countries as $country)
                           <option value="{{ $country->id }}"> {{ $country->country_name }}</option>
                           @endforeach
                        </select>
                        <div class="icon-badge">
                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                           </svg>
                        </div>
                     </div>

            <div class="search-col fromGroup has-icon banner-select no-border">
            <select onChange="getCity(this.value);" class="rt-selectactive w-100-p select2-hidden-accessible" id="state" name="state">
            <option value=""> All States</option>      
            </select>
<span class="select2 select2-container select2-container--default select2-container--below" style="width: 265px;"><span class="selection"><span class="select2-selection select2-selection--single"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
<div class="icon-badge">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 17L12 22L22 17" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M2 12L12 17L22 12" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
</div>
                     <div class="search-col fromGroup has-icon banner-select no-border">
                        <select onChange="getSubcategory(this.value);" class="rt-selectactive w-100-p select2-hidden-accessible" name="category">
                           <option value=""> All Industry</option>
                           @foreach($categories as $category)
                           <option value="{{ $category->id }}">{{ $category->name }}</option>
                           @endforeach  
                        </select>
                        <span class="select2 select2-container select2-container--default select2-container--below"  style="width: 265px;"><span class="selection"><span class="select2-selection select2-selection--single"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper"></span></span>
                        <div class="icon-badge">
                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M2 17L12 22L22 17" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M2 12L12 17L22 12" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                           </svg>
                        </div>
                     </div>

<div class="search-col fromGroup has-icon banner-select no-border">
<select class="rt-selectactive w-100-p select2-hidden-accessible" name="sub_category" id="category-list">
<option value=""> All Functional Area</option>      
</select>
<span class="select2 select2-container select2-container--default select2-container--below" style="width: 265px;"><span class="selection"><span class="select2-selection select2-selection--single"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
<div class="icon-badge">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 17L12 22L22 17" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M2 12L12 17L22 12" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
</div>
                  </div>
                  <div class="flex-grow-0">
                  <button onclick="CandidateFilter()" class="btn btn-primary d-block d-md-inline-block">Find Candidate</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="resume-list">
<div class="container">
   <div class="tab-content" id="nav-tabContent">
      <div class="tab-pane show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
         <div class="row" id="candidate-list">

         @foreach($candidates as $candidate)
@php
$save_status = get_candidate_save_status($candidate->id);
@endphp

         @if(((\Auth::user()->profile_view_limit)) == 0)
            <div class=" col-md-6 fade-in-bottom  condition_class rt-mb-24 col-xl-4 ">
               <div class="card jobcardStyle1 body-24">
                  <div class="card-body">
                     <div class="rt-single-icon-box icb-clmn-lg">
                        <div class="icon-thumb">
                           <div class="profile-image">
                              <img src="https://jobpilot.templatecookie.com/backend/image/default.png" alt="Candidate Image">
                           </div>
                        </div>
                        <div class="iconbox-content">
                           <div class="job-mini-title">
                              <a href="{{ route('membership-plan') }}">{{ $candidate->name }}</a>
                           </div>
                           <span class="loacton text-gray-400"> {{ $candidate->cat }} </span>
                           <span class="loacton text-gray-400"><i class="fa fa-clock"></i> {{ $candidate->experience_years }}y {{ $candidate->experience_months }}m &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-map-marker"></i> {{ $candidate->city }} </span>
                           <div class="bottom-link rt-pt-30">
                              <a href="{{ route('membership-plan') }}" class="body-font-4 text-primary-500"> View Profile
                                 <span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 5L19 12L12 19" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                 </span>
                              </a>
                           </div>
                        </div>
                        <div class="iconbox-extra">
                          @if($save_status == 0) 
                           <a title="Save Candidate" href="{{ route('membership-plan') }}" class="hoverbg-primary-50 text-primary-500 plain-button icon-button"><svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                           </a>
                           @else
                           <a title="Remove Candidate from save" href="{{ route('membership-plan') }}" class="hoverbg-primary-50 text-primary-500 plain-button icon-button"><i class="fa-solid fa-bookmark"></i></a>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @else

            <div class=" col-md-6 fade-in-bottom  condition_class rt-mb-24 col-xl-4">
               <div class="card jobcardStyle1 body-24">
                  <div class="card-body">
                     <div id="message{{ $candidate->id }}" style="position: absolute; top: 3px; left: 10px; color: green; font-size: 14px;"></div>
                     <div class="rt-single-icon-box icb-clmn-lg">
                        <div class="icon-thumb">
                           <div class="profile-image">
                              <img src="{{ $candidate->profile_image }}" alt="Candidate Image">
                           </div>
                        </div>
                        <div class="iconbox-content">
                           <div class="job-mini-title">
                              <a href="{{ route('candidate-profile', $candidate->id) }}">{{ $candidate->name }}</a>
                           </div>
                           <span class="loacton text-gray-400">{{ $candidate->cat }}</span>
                           <span class="loacton text-gray-400"><i class="fa fa-clock"></i> {{ $candidate->experience_years }}y {{ $candidate->experience_months }}m &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-map-marker"></i> {{ $candidate->city }} </span>
                           <div class="bottom-link rt-pt-30">
                              <a href="{{ route('candidate-profile', $candidate->id) }}" class="body-font-4 text-primary-500"> View Profile
                                 <span><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 5L19 12L12 19" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                 </span>
                              </a>
                           </div>
                        </div>
                        <div class="iconbox-extra">
                        <div id="button{{ $candidate->id }}">
                        @if($save_status == 0)   
                           <button value="{{ $candidate->id}}" type="button" onclick="saveCandidate(this.value)" title="Save Candidate" class="hoverbg-primary-50 text-primary-500 plain-button icon-button"><svg width="16" height="20" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 19L8 14L1 19V3C1 2.46957 1.21071 1.96086 1.58579 1.58579C1.96086 1.21071 2.46957 1 3 1H13C13.5304 1 14.0391 1.21071 14.4142 1.58579C14.7893 1.96086 15 2.46957 15 3V19Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                           </button>
                        @else
                           <button value="{{ $candidate->id}}" type="button" onclick="saveCandidate(this.value)" title="Remove Candidate from save" class="hoverbg-primary-50 text-primary-500 plain-button icon-button"><i class="fa-solid fa-bookmark"></i>
                           </button>
                        @endif   
                        </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif
         @endforeach  
         </div>
      </div>
      </div>
      </div>
      <div class="pagination">
         {{ $candidates->links() }}
      </div>
         </div>

      </div>
      
   </div>
</div>
</section>
@endsection