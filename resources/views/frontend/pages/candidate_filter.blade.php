@php
$i = 0;
@endphp

@foreach($candidates as $candidate) 
@php
$i++;
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
                              <a href="{{ route('login') }}">{{ $candidate->name }}</a>
                           </div>
                           <span class="loacton text-gray-400"> {{ $candidate->cat }} </span>
                           <span class="loacton text-gray-400"><i class="fa fa-clock"></i> {{ $candidate->experience_years }}y {{ $candidate->experience_months }}m &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-map-marker"></i> {{ $candidate->city }} </span>
                           <div class="bottom-link rt-pt-30">
                              <a href="{{ route('login') }}" class="body-font-4 text-primary-500"> View Profile
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
                              <a href="#">{{ $candidate->name }}</a>
                           </div>
                           <span class="loacton text-gray-400">{{ $candidate->cat }}</span>
                           <span class="loacton text-gray-400"><i class="fa fa-clock"></i> {{ $candidate->experience_years }}y {{ $candidate->experience_months }}m &nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-map-marker"></i> {{ $candidate->city }} </span>
                           <div class="bottom-link rt-pt-30">
                              <a href="#" class="body-font-4 text-primary-500"> View Profile
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
@if($i == 0)
<div class="col-md-12">
<h4 style="font-size: 26px; text-align: center;">No Candidate Found</h4>
</div>
@endif