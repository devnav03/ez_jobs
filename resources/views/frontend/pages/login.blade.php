@extends('frontend.layouts.app')
@section('content')
<div class="row">
   <div class="full-height col-12 order-1 order-lg-0">
      <div class="container">
         <div class="row full-height align-items-center">
            <div class="col-xl-5 col-lg-8 col-md-9">
               <div class="auth-box2">
                  <form class="rt-form" action="{{ route('log-in') }}" method="POST" id="login_form">
                     {{ csrf_field() }}
                     @if(session()->has('failed_login'))
                <p style="background: rgb(214 20 58);color: #fff;padding: 5px 10px;border-radius: 9px;margin-top: 0px;">Invalid login credentials</p>
              @endif
                     <h4 class="rt-mb-20">Log In</h4>
                     <span class="d-block body-font-3 text-gray-600 rt-mb-32"> Don't have an account? <span>
                     <a href="{{ route('register') }}">Create Account</a>
                     </span>
                     </span>
                     <div class="fromGroup rt-mb-15">
                        <input type="email" name="email" id="email" class="form-control " value="{{ old('email') }}" placeholder="Email Address">
                     </div>
                     <div class="rt-mb-15">
                        <div class="d-flex fromGroup">
                           <input name="password" id="password" value="{{ old('password') }}" class="form-control " type="password" placeholder="Password">
                           <div onclick="passToText('password','eyeIcon')" id="eyeIcon" class="has-badge">
                              <i class="ph-eye "></i>
                           </div>
                        </div>
                     </div>
                     <div class="d-flex flex-wrap rt-mb-30">
                        <div class="flex-grow-1">
                           <div class="form-check from-chekbox-custom">
                              <input name="remember" id="remember" class="form-check-input" type="checkbox" value="1">
                              <label class="form-check-label pointer text-gray-700 f-size-14" for="remember">
                              &nbsp;&nbsp;&nbsp; Keep me logged in</label>
                           </div>
                        </div>
                        <div class="flex-grow-0">
                           <span class="body-font-4">
                           <a href="{{ route('forgot.password') }}" class="text-primary-500">Forget Password</a>
                           </span>
                        </div>
                     </div>
                     <button id="submitButton" type="submit" class="btn btn-primary d-block rt-mb-15">
                        <span class="button-content-wrapper ">
                           <span class="button-icon align-icon-right">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M5 12H19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M12 5L19 12L12 19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </svg>
                           </span>
                           <span class="button-text">Log In</span>
                        </span>
                     </button>
                  </form>
                  <div class="">
                     <div class="row">
                        <!-- <div class="justify-content-center col-sm-6 col-md-6 mb-1">
                           <a href="https://jobpilot.templatecookie.com/auth/google/redirect" class="btn btn-outline-plain d-block custom-padding me-3 rt-mb-xs-10 ">
                              <span class="button-content-wrapper ">
                                 <span class="button-icon align-icon-left">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M4.43242 12.0855L3.73625 14.6845L1.19176 14.7383C0.431328 13.3279 0 11.7141 0 9.9993C0 8.34105 0.403281 6.7773 1.11812 5.40039H1.11867L3.38398 5.8157L4.37633 8.06742C4.16863 8.67293 4.05543 9.32293 4.05543 9.9993C4.05551 10.7334 4.18848 11.4367 4.43242 12.0855Z" fill="#FBBB00"></path>
                                       <path d="M19.8261 8.13281C19.941 8.73773 20.0009 9.36246 20.0009 10.0009C20.0009 10.7169 19.9256 11.4152 19.7822 12.0889C19.2954 14.3812 18.0234 16.3828 16.2613 17.7993L16.2608 17.7987L13.4075 17.6532L13.0037 15.1323C14.1729 14.4466 15.0866 13.3735 15.568 12.0889H10.2207V8.13281H15.646H19.8261Z" fill="#518EF8"></path>
                                       <path d="M16.2595 17.7975L16.2601 17.798C14.5464 19.1755 12.3694 19.9996 9.99965 19.9996C6.19141 19.9996 2.88043 17.8711 1.19141 14.7387L4.43207 12.0859C5.27656 14.3398 7.45074 15.9442 9.99965 15.9442C11.0952 15.9442 12.1216 15.648 13.0024 15.131L16.2595 17.7975Z" fill="#28B446"></path>
                                       <path d="M16.382 2.30219L13.1425 4.95437C12.2309 4.38461 11.1534 4.05547 9.99906 4.05547C7.39246 4.05547 5.17762 5.73348 4.37543 8.06812L1.11773 5.40109H1.11719C2.78148 2.1923 6.13422 0 9.99906 0C12.4254 0 14.6502 0.864297 16.382 2.30219Z" fill="#F14336"></path>
                                    </svg>
                                 </span>
                                 <span class="button-text">
                                 Login with Google
                                 </span>
                              </span>
                           </a>
                        </div> -->
                      <!--   <div class="justify-content-center col-sm-6 col-md-6 mb-1">
                           <a href="https://jobpilot.templatecookie.com/auth/github/redirect" class="btn btn-outline-plain d-block custom-padding me-3 rt-mb-xs-10 ">
                              <span class="button-content-wrapper ">
                                 <span class="button-icon align-icon-left">
                                    <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px">
                                       <path d="M10.9,2.1c-4.6,0.5-8.3,4.2-8.8,8.7c-0.5,4.7,2.2,8.9,6.3,10.5C8.7,21.4,9,21.2,9,20.8v-1.6c0,0-0.4,0.1-0.9,0.1 c-1.4,0-2-1.2-2.1-1.9c-0.1-0.4-0.3-0.7-0.6-1C5.1,16.3,5,16.3,5,16.2C5,16,5.3,16,5.4,16c0.6,0,1.1,0.7,1.3,1c0.5,0.8,1.1,1,1.4,1 c0.4,0,0.7-0.1,0.9-0.2c0.1-0.7,0.4-1.4,1-1.8c-2.3-0.5-4-1.8-4-4c0-1.1,0.5-2.2,1.2-3C7.1,8.8,7,8.3,7,7.6c0-0.4,0-0.9,0.2-1.3 C7.2,6.1,7.4,6,7.5,6c0,0,0.1,0,0.1,0C8.1,6.1,9.1,6.4,10,7.3C10.6,7.1,11.3,7,12,7s1.4,0.1,2,0.3c0.9-0.9,2-1.2,2.5-1.3 c0,0,0.1,0,0.1,0c0.2,0,0.3,0.1,0.4,0.3C17,6.7,17,7.2,17,7.6c0,0.8-0.1,1.2-0.2,1.4c0.7,0.8,1.2,1.8,1.2,3c0,2.2-1.7,3.5-4,4 c0.6,0.5,1,1.4,1,2.3v2.6c0,0.3,0.3,0.6,0.7,0.5c3.7-1.5,6.3-5.1,6.3-9.3C22,6.1,16.9,1.4,10.9,2.1z"></path>
                                    </svg>
                                 </span>
                                 <span class="button-text">
                                 Login with Github
                                 </span>
                              </span>
                           </a>
                        </div> -->
             
                              <!-- <div class="rt-single-icon-box">
                                 <div class="iconbox-content">
                                     <div class="body-font-1 rt-mb-12">
                                         <h5>Login Credentials</h5>
                                     </div>
                                 </div>
                                 </div> -->
                                 <!--     <div class="col-md-6">
                                    <button onclick="loginCredentials('candidate')" type="button" class="btn btn-primary d-block rt-mb-15">
                                        <span class="button-content-wrapper ">
                                            <span class="button-icon align-icon-right">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                            </span>
                                            <span class="button-text">
                                                Login with Candidate
                                            </span>
                                        </span>
                                    </button>
                                    </div> -->
                                 <!--  <div class="col-md-6">
                                    <button onclick="loginCredentials('company')" type="button" class="btn btn-primary d-block rt-mb-15">
                                        <span class="button-content-wrapper ">
                                            <span class="button-icon align-icon-right">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M12 5L19 12L12 19" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                            </span>
                                            <span class="button-text">
                                                Login with Employer
                                            </span>
                                        </span>
                                    </button>
                                    </div> -->
                           
                       
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="auth-right-sidebar order-lg-1 order-0">
      <div class="sidebar-bg" style="background-image: url(https://jobpilot.templatecookie.com/frontend/assets/images/all-img/auth-img.png)">
         <div class="sidebar-content">
            <h4 class="text-gray-10 rt-mb-50">0 Open jobs waiting for you</h4>
            <div class="d-flex">
               <div class="flex-grow-1 rt-mb-24">
                  <div class="card jobcardStyle1 counterbox4">
                     <div class="card-body">
                        <div class="rt-single-icon-box icon-center2">
                           <div class="icon-thumb">
                              <div class="icon-64">
                                 <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.001 9H5.00098C4.44869 9 4.00098 9.44772 4.00098 10V26C4.00098 26.5523 4.44869 27 5.00098 27H27.001C27.5533 27 28.001 26.5523 28.001 26V10C28.001 9.44772 27.5533 9 27.001 9Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path opacity="0.2" d="M16 19.0004C11.7872 19.007 7.64764 17.8995 4.00098 15.7902V26.0004C4.00098 26.1318 4.02684 26.2618 4.0771 26.3831C4.12735 26.5044 4.20101 26.6147 4.29387 26.7075C4.38673 26.8004 4.49697 26.8741 4.61829 26.9243C4.73962 26.9746 4.86965 27.0004 5.00098 27.0004H27.001C27.1323 27.0004 27.2623 26.9746 27.3837 26.9243C27.505 26.8741 27.6152 26.8004 27.7081 26.7075C27.8009 26.6147 27.8746 26.5044 27.9249 26.3831C27.9751 26.2618 28.001 26.1318 28.001 26.0004V15.7891C24.3539 17.8991 20.2135 19.0071 16 19.0004Z" fill="white"></path>
                                    <path d="M27.001 9H5.00098C4.44869 9 4.00098 9.44772 4.00098 10V26C4.00098 26.5523 4.44869 27 5.00098 27H27.001C27.5533 27 28.001 26.5523 28.001 26V10C28.001 9.44772 27.5533 9 27.001 9Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21 9V7C21 6.46957 20.7893 5.96086 20.4142 5.58579C20.0391 5.21071 19.5304 5 19 5H13C12.4696 5 11.9609 5.21071 11.5858 5.58579C11.2107 5.96086 11 6.46957 11 7V9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M28.0012 15.7891C24.354 17.8991 20.2137 19.007 16.0002 19.0004C11.7873 19.007 7.64768 17.8995 4.00098 15.7901" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14.5 15H17.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 </svg>
                              </div>
                           </div>
                           <div class="iconbox-content">
                              <div class="f-size-20 ft-wt-5"><span class="number" style="--from: 0; --to: 38; --duration: 2s;"></span></div>
                              <span class=" f-size-14">Live Job</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="flex-grow-1  rt-mb-24">
                  <div class="card jobcardStyle1 counterbox4">
                     <div class="card-body">
                        <div class="rt-single-icon-box icon-center2">
                           <div class="icon-thumb">
                              <div class="icon-64">
                                 <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.2" d="M17.999 26.998V4.99805C17.999 4.73283 17.8937 4.47848 17.7061 4.29094C17.5186 4.1034 17.2642 3.99805 16.999 3.99805H4.99902C4.73381 3.99805 4.47945 4.1034 4.29192 4.29094C4.10438 4.47848 3.99902 4.73283 3.99902 4.99805V26.998" fill="white"></path>
                                    <path d="M2 26.998H30" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M17.999 26.998V4.99805C17.999 4.73283 17.8937 4.47848 17.7061 4.29094C17.5186 4.1034 17.2642 3.99805 16.999 3.99805H4.99902C4.73381 3.99805 4.47945 4.1034 4.29192 4.29094C4.10438 4.47848 3.99902 4.73283 3.99902 4.99805V26.998" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M27.999 26.998V12.998C27.999 12.7328 27.8937 12.4785 27.7061 12.2909C27.5186 12.1034 27.2642 11.998 26.999 11.998H17.999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7.99902 8.99805H11.999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9.99902 16.998H13.999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7.99902 21.998H11.999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21.999 21.998H23.999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21.999 16.998H23.999" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 </svg>
                              </div>
                           </div>
                           <div class="iconbox-content">
                              <div class="f-size-20 ft-wt-5"><span class="number" style="--from: 0; --to: 73; --duration: 2s;"></span></div>
                              <span class=" f-size-14">Companies</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="flex-grow-1 rt-mb-24">
                  <div class="card jobcardStyle1 counterbox4">
                     <div class="card-body">
                        <div class="rt-single-icon-box icon-center2">
                           <div class="icon-thumb">
                              <div class="icon-64">
                                 <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.2" d="M16 19.0004C11.7872 19.007 7.64764 17.8995 4.00098 15.7902V26.0004C4.00098 26.1318 4.02684 26.2618 4.0771 26.3831C4.12735 26.5044 4.20101 26.6147 4.29387 26.7075C4.38673 26.8004 4.49697 26.8741 4.61829 26.9243C4.73962 26.9746 4.86965 27.0004 5.00098 27.0004H27.001C27.1323 27.0004 27.2623 26.9746 27.3837 26.9243C27.505 26.8741 27.6152 26.8004 27.7081 26.7075C27.8009 26.6147 27.8746 26.5044 27.9249 26.3831C27.9751 26.2618 28.001 26.1318 28.001 26.0004V15.7891C24.3539 17.8991 20.2135 19.0071 16 19.0004Z" fill="white"></path>
                                    <path d="M27.001 9H5.00098C4.44869 9 4.00098 9.44772 4.00098 10V26C4.00098 26.5523 4.44869 27 5.00098 27H27.001C27.5533 27 28.001 26.5523 28.001 26V10C28.001 9.44772 27.5533 9 27.001 9Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21 9V7C21 6.46957 20.7893 5.96086 20.4142 5.58579C20.0391 5.21071 19.5304 5 19 5H13C12.4696 5 11.9609 5.21071 11.5858 5.58579C11.2107 5.96086 11 6.46957 11 7V9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M28.0012 15.7891C24.354 17.8991 20.2137 19.007 16.0002 19.0004C11.7873 19.007 7.64768 17.8995 4.00098 15.7901" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14.5 15H17.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 </svg>
                              </div>
                           </div>
                           <div class="iconbox-content">
                              <div class="f-size-20 ft-wt-5"><span class="number" style="--from: 0; --to: 0; --duration: 2s;"></span></div>
                              <span class=" f-size-14">New Jobs</span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection