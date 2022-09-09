@php
$i = 0;
@endphp

@foreach($companies as $company)
@php
$i++;
@endphp
         @if(\Auth::check())
         @if(((\Auth::user()->user_type)) != 2)

         <div class="col-xl-4 col-md-6 fade-in-bottom  condition_class rt-mb-24">
            <div class="card jobcardStyle1">
               <div class="card-body">
                  <div class="rt-single-icon-box">
                     <div class="icon-thumb company-logo">
                        <img src="{!! asset($company->profile_image) !!}" alt="" draggable="false">
                     </div>
                     <div class="iconbox-content">
                        <div class="body-font-1 rt-mb-12">
                           <a href="{{ route('company-details', $company->id) }}" class="text-gr2q  ay-900 hover:text-primary-500">{{ $company->employer_name }}</a>
                        </div>
                        <span class="loacton text-gray-400 ">
                        <i class="fa-solid fa-location-dot"></i> {{ $company->city }}</span>
                        <span class="loacton text-gray-400 ">
                        <i class="fa-solid fa-suitcase"></i> {{ $company->employer_name }} </span>
                     </div>
                  </div>
                  <div class="post-info d-flex">
                     <div class="flex-grow-1">
                        <a href="{{ route('company-details', $company->id) }}" type="button" class="btn btn-primary2-50 d-block">
                           <div class="button-content-wrapper ">
                              <span class="button-icon align-icon-right">
                              <i class="fa-solid fa-arrow-right-long"></i>
                              </span>
                              <span class="button-text"> Open Position</span>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endif
         @else

         <div class="col-xl-4 col-md-6 fade-in-bottom  condition_class rt-mb-24">
            <div class="card jobcardStyle1">
               <div class="card-body">
                  <div class="rt-single-icon-box">
                     <div class="icon-thumb company-logo">
                        <img src="{!! asset($company->profile_image) !!}" alt="" draggable="false">
                     </div>
                     <div class="iconbox-content">
                        <div class="body-font-1 rt-mb-12"><a href="{{ route('login') }}" class="text-gr2q  ay-900 hover:text-primary-500">{{ $company->employer_name }}</a>
                        </div>
                        <span class="loacton text-gray-400 ">
                        <i class="fa-solid fa-location-dot"></i> {{ $company->city }} </span>
                        <span class="loacton text-gray-400 ">
                        <i class="fa-solid fa-suitcase"></i> {{ $company->employer_name }}</span>
                     </div>
                  </div>
                  <div class="post-info d-flex">
                     <div class="flex-grow-1">
                        <a href="{{ route('login') }}" type="button" class="btn btn-primary2-50 d-block">
                           <div class="button-content-wrapper ">
                              <span class="button-icon align-icon-right">
                              <i class="fa-solid fa-arrow-right-long"></i>
                              </span>
                              <span class="button-text"> Open Position </span>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div> 

         @endif
      @endforeach

@if($i == 0)
<h4 style="text-align: center; font-size: 22px; width: 100%;">No Company Found</h4>
@endif













