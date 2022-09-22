@extends('frontend.layouts.app')
@section('content')

<div class="rt-about">
        <div class="container">
            <div class="rt-spacer-100 rt-spacer-md-50"></div>
            <div class="row">
                  <div class="col-md-6">
                    <div class="mx-646">
                        <span class="body-font-3 ft-wt-5 text-primary-500 rt-mb-15 d-inline-block">Who we are</span>
                        <h2 class="rt-mb-40">We’re highly skilled and professionals team.</h2>
                        <p class="body-font-2 text-gray-500 rt-mb-0">
                            Praesent non sem facilisis, hendrerit nisi vitae, volutpat quam. Aliquam metus mauris, semper eu eros vitae, blandit tristique metus. Vestibulum maximus nec justo sed maximus.
                        </p>
                    </div>
                  </div>
                  <div class="col-md-2"></div>
                  <div class="col-md-4 rt-pt-md-30">
                    <div class="about-counter">
                        <div class="card jobcardStyle1 counterbox2 rt-mb-40">
                            <div class="card-body">
                                <div class="rt-single-icon-box">
                                    <div class="icon-thumb rt-mr-24">
                                        <div class="icon-72">
                                            <i class="fa-solid fa-briefcase"></i>
                                        </div>
                                    </div>
                                    <div class="iconbox-content">
                                        <div class="f-size-24 ft-wt-5 rt-mb-12"><span class="counter">{{ $new_job }}</span></div>
                                        <span class="text-gray-900 f-size-16"> New Jobs </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card jobcardStyle1 counterbox2 rt-mb-40">
                            <div class="card-body">
                                <div class="rt-single-icon-box">
                                    <div class="icon-thumb rt-mr-24">
                                        <div class="icon-72">
                                            <i class="fa-solid fa-building"></i>
                                        </div>
                                    </div>
                                    <div class="iconbox-content">
                                        <div class="f-size-24 ft-wt-5 rt-mb-12"><span class="counter">{{ $companies_count }}</span></div>
                                        <span class="text-gray-900 f-size-16">Companies</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="card jobcardStyle1 counterbox2">
                                <div class="card-body">
                                    <div class="rt-single-icon-box">
                                        <div class="icon-thumb rt-mr-24">
                                            <div class="icon-72">
                                                <i class="fa-solid fa-users"></i>
                                            </div>
                                        </div>
                                        <div class="iconbox-content">
                                            <div class="f-size-24 ft-wt-5 rt-mb-12"><span class="counter">{{ $candidate_count }}</span></div>
                                            <span class="text-gray-900 f-size-16">Candidates</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rt-spacer-100 rt-spacer-md-50"></div>
        </div>
    </div>


<section class="gallery-about">
   <div class="container">
      <div class="row">
         <div class="col-md-4">
            <img src="{!! asset('assets/frontend/images/about-banner-1.jpg') !!}" alt="">
         </div>
         <div class="col-md-4">
            <img src="{!! asset('assets/frontend/images/about-banner-2.jpg') !!}" style="margin-bottom: 30px;" alt="">
            <img src="{!! asset('assets/frontend/images/about-banner-3.jpg') !!}" alt="">
         </div>
         <div class="col-md-4">
            <img src="{!! asset('assets/frontend/images/about-banner-4.jpg') !!}" alt="">
         </div>

      </div>
   </div>
</section>

<div class="mission">
<div class="container">
    <div class="row align-items-center">
        <div class="col-md-6">
            <span class="body-font-3 ft-wt-5 text-primary-500 rt-mb-15 d-inline-block">Our Mission</span>
            <h3 class="rt-mb-32">We’re highly skilled and professionals team.</h3>
            <p class="body-font-2 text-gray-500 rt-mb-0">
                Praesent non sem facilisis, hendrerit nisi vitae, volutpat quam. Aliquam metus mauris, semper eu eros vitae, blandit tristique metus. Vestibulum maximus nec justo sed maximus.
            </p>
        </div>
        <div class="col-md-6">
            <div>
                <img src="{!! asset('assets/frontend/images/about-banner-5.png') !!}" alt="" class="w-100">
            </div>
        </div>
    </div>
</div>
</div>


<section class="testimoinals-area bg-gray-20">
   <div class="rt-spacer-100 rt-spacer-md-50"></div>
   <div class="container">
   <div class="row">
      <div class="col-12 text-center">
         <h4>Clients Testimonial</h4>
      </div>
   </div>
   <div class="rt-spacer-40 rt-spacer-md-20"></div>
   <div class="row">
      <div class="col-12 position-parent">
         <div id="col-slide-test" class="owl-carousel owl-theme">
         @foreach($testimonials as $testimonial)
            <div class="testimonals-box">
               <div class="rt-mb-12">
                 @for($i = 0; $i < $testimonial->rating; $i++)
                  <i class="fa-solid fa-star" style="color:#FFAA00;"></i>
                 @endfor
               </div>
               <div class="text-gray-600 body-font-3">
                  {{ $testimonial->comment }}
               </div>
               <div class="rt-single-icon-box">
                  <div class="icon-thumb rt-mr-12">
                     <div class="userimage" style="margin-right: 10px; margin-top: 10px;">
                     @if($testimonial->image)
                     <img src="{!! asset($testimonial->image) !!}" alt="">
                     @else
                        <img src="https://jobpilot.templatecookie.com/backend/image/default.png" alt="" draggable="false">
                        @endif
                     </div>
                  </div>
                  <div class="iconbox-content">
                     <div class="body-font-3">{{ $testimonial->name }}</div>
                     <div class="body-font-4 text-gray-400">{{ $testimonial->designation }}
                     </div>
                  </div>
                  <div class="iconbox-extra">
                  <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M16 28C16 30.1217 15.1571 32.1566 13.6569 33.6569C12.1566 35.1571 10.1217 36 8 36C5.87827 36 3.84344 35.1571 2.34315 33.6569C0.842854 32.1566 0 30.1217 0 28C0 23.58 8 0 8 0H12L8 20C10.1217 20 12.1566 20.8429 13.6569 22.3431C15.1571 23.8434 16 25.8783 16 28ZM36 28C36 30.1217 35.1571 32.1566 33.6569 33.6569C32.1566 35.1571 30.1217 36 28 36C25.8783 36 23.8434 35.1571 22.3431 33.6569C20.8429 32.1566 20 30.1217 20 28C20 23.58 28 0 28 0H32L28 20C30.1217 20 32.1566 20.8429 33.6569 22.3431C35.1571 23.8434 36 25.8783 36 28Z" fill="#DADDE6"></path>
                  </svg>
                  </div>
               </div>
            </div>
         @endforeach
         </div>
      </div>
   </div>
</div>
   <div class="rt-spacer-100 rt-spacer-md-50"></div>
</section>
@if(\Auth::check())
@else
<section class="cta-area rt-pt-100 rt-mb-80 rt-pt-md-50 rt-mb-md-40">
   <div class="container">
      <div class="row">
         <div class="col-xl-6 rt-mb-24">
            <div class="back1 cta-1 ct-height bgprefix-cover">
               <h5 class="rt-mb-15">Become a Candidate</h5>
               <div class="body-font-4 rt-mb-24 text-gray-600 max-312">
                  Click the button below to get started with our candidate registration process. You will be able to post your resume and apply for jobs.
               </div>
               <form action="{{ route('register') }}">
                  <input class="d-none" type="text" name="user" value="candidate" id="">
                  <button type="submit" class="btn btn-light">
                     <span class="button-content-wrapper ">
                        <span class="button-icon align-icon-right">
                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M5 12H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                           </svg>
                        </span>
                        <span class="button-text">
                        Register Now
                        </span>
                     </span>
                  </button>
               </form>
            </div>
         </div>
         <div class="col-xl-6 rt-mb-24">
            <div class="back2 cta-1 ct-height bgprefix-cover">
               <h5 class="rt-mb-15 text-gray-10">Become a Employer</h5>
               <div class="body-font-4 rt-mb-24 text-gray-10 max-312">
                  Click the button below to get started with our employer registration process. You will be able to post jobs and get candidates for your job.
               </div>
               <form action="{{ route('register') }}">
                  <input class="d-none" type="text" name="user" value="company" id="">
                  <button type="submit" class="btn btn-light">
                     <span class="button-content-wrapper ">
                        <span class="button-icon align-icon-right">
                           <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M5 12H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                           </svg>
                        </span>
                        <span class="button-text">
                        Register Now
                        </span>
                     </span>
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@endif





@endsection