@extends('frontend.layouts.app')
@section('content')

<section class="filter_index">
<div class="container">
        <div class="row align-items-center ">
            <div class="col-12 position-relative ">
                <div class="jobsearchBox  bg-gray-10 input-transparent with-advanced-filter height-auto-xl">
                    <div class="top-content d-flex flex-column flex-xl-row">
                        <div class="left-content">
<div class="search-col-4 fromGroup has-icon">
<input name="keyword" type="text" placeholder="Company Name" value="">
<div class="icon-badge">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M20.9999 21L16.6499 16.65" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
</div>

 <div class="sec_tool search-col fromGroup has-icon banner-select no-border">
<select class="rt-selectactive w-100-p select2-hidden-accessible" name="country" onChange="getState(this.value);">
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

<span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="select2-data-5-vvlq" style="width: 265px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-category-mk-container" aria-controls="select2-category-mk-container"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
<div class="icon-badge">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 17L12 22L22 17" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M2 12L12 17L22 12" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
</div>

<div class="search-col fromGroup has-icon banner-select no-border">
<select class="rt-selectactive w-100-p select2-hidden-accessible" id="city" name="city">
<option value=""> All Cities</option>
            
</select>

<span class="select2 select2-container select2-container--default select2-container--below" dir="ltr" data-select2-id="select2-data-5-vvlq" style="width: 265px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-category-mk-container" aria-controls="select2-category-mk-container"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
<div class="icon-badge">
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M2 17L12 22L22 17" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M2 12L12 17L22 12" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="#1777e5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
</div>
</div>


</div>
<div class="flex-grow-0">
<button type="submit" class="btn btn-primary d-block d-md-inline-block ">Find Company</button>
</div>
</div>


                </div>
            </div>
        </div>
    </div>
</section>

<section class="featurejob-area rt-pt-100 rt-pt-md-50" style="margin-bottom: 50px;padding-top: 70px;">
   <div class="container">
      <div class="row">
 
      @foreach($companies as $company)
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
                           <a href="#" class="text-gr2q  ay-900 hover:text-primary-500">{{ $company->employer_name }}</a>
                        </div>
                        <span class="loacton text-gray-400 ">
                        <i class="fa-solid fa-location-dot"></i> {{ $company->city }}</span>
                        <span class="loacton text-gray-400 ">
                        <i class="fa-solid fa-suitcase"></i> {{ $company->employer_name }} </span>
                     </div>
                  </div>
                  <div class="post-info d-flex">
                     <div class="flex-grow-1">
                        <a href="#" type="button" class="btn btn-primary2-50 d-block">
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

   <div class="pagination"> 
      {{ $companies->links() }}
   </div>
      </div>
   </div>
</section>



@endsection    