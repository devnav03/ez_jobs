@extends('frontend.layouts.app')
@section('content')
<div class="row">
   <div class="full-height col-12 order-1 order-lg-0">
      <div class="container">
         <div class="row full-height align-items-center">
            <div class="col-xl-5 col-lg-8 col-md-9">
            @if(session()->has('message_reg'))
            <div class="alert alert-success" role="alert">Your Account has been created with ez-job.co. We have sent a confirmation link on your registered email Kindly check & Confirm.</div>
            @endif
               <div class="auth-box2">
                  <form class="rt-form" accept-charset="UTF-8" enctype="multipart/form-data" id="login_form" method="POST" action="{{ route('save-register') }}">
                   {{ csrf_field() }}
                     <div class="row">
                     <div class="col-lg-8 col-md-12">
                         <h4 class="rt-mb-20">Create Account</h4>
                         <span class="d-block body-font-3 text-gray-600 rt-mb-32">
                             Already have an account?
                             <span>
                                 <a href="{{ route('login') }}">Log In</a>
                             </span>
                          </span>
                          </div>
                                <div class="col-lg-4 col-md-12 align-self-center rt-mb-lg-20">
                                <select onChange="yesnoCheckEmployer(this);" name="role" class="rt-selectactive w-100-p select2-hidden-accessible">
                                 <option value="3">Candidate</option>
                                 <option value="2">Employer</option>
                                </select>
                                  @if($errors->has('role'))
                                  <span class="text-danger">{{$errors->first('role')}}</span>
                                  @endif
                                 </div>
                                </div>

                          <div class="row">
                                <div class="col-xl-12 col-lg-12 employer_name" style="display: none;">
                                  <div class="fromGroup rt-mb-15">
                                  <input name="employer_name" id="employer_name" value="{{ old('employer_name') }}" class="field form-control " type="text" placeholder="Company Name*">
                                  @if($errors->has('name'))
                                  <span class="text-danger">{{$errors->first('name')}}</span>
                                  @endif
                                  </div>
                                </div>


                                <!-- <div class="col-xl-6 col-lg-6">
                                  <div class="fromGroup rt-mb-15">
                                  <input name="name" id="name" required="" value="{{ old('name') }}" class="field form-control " type="text" placeholder="Full Name*">
                                  @if($errors->has('name'))
                                  <span class="text-danger">{{$errors->first('name')}}</span>
                                  @endif
                                  </div>
                                </div> -->
                                <div class="col-xl-6 col-lg-6">
                                  <div class="fromGroup rt-mb-15">
                                  <input name="first_name" id="first_name" required="" value="{{ old('first_name') }}" class="field form-control " type="text" placeholder="First Name*">
                                  @if($errors->has('first_name'))
                                  <span class="text-danger">{{$errors->first('first_name')}}</span>
                                  @endif
                                  </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                  <div class="fromGroup rt-mb-15">
                                  <input name="last_name" id="last_name" value="{{ old('last_name') }}" class="field form-control" type="text" placeholder="Last Name">
                                  @if($errors->has('last_name'))
                                  <span class="text-danger">{{$errors->first('last_name')}}</span>
                                  @endif
                                  </div>
                                </div>

                                <div class="col-xl-6 col-lg-6">
                                  <div class="fromGroup rt-mb-15">
                                  <input type="email" required="" id="email" value="{{ old('email') }}" name="email" class="field form-control" placeholder="Email Address*">
                                  @if($errors->has('email'))
                                  <span class="text-danger">{{$errors->first('email')}}</span>
                                  @endif
                                  </div>
                                </div> 
                                <div class="col-xl-6 col-lg-6 mg20">
                                  <select name="gender" class="rt-selectactive w-100-p select2-hidden-accessible" required="">
                                    <option value="">Select Gender*</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                  </select>
                                  @if($errors->has('gender'))
                                  <span class="text-danger">{{$errors->first('gender')}}</span>
                                  @endif
                                </div>

                                <div class="col-xl-6 col-lg-6 mg20">
                                  <input type="text" value="{{ old('date_of_birth') }}" required="" onfocus="(this.type='date')" id="bday" max="2004-08-01" name="date_of_birth" placeholder="Date Of Birth*">
                                  @if($errors->has('date_of_birth'))
                                  <span class="text-danger">{{$errors->first('date_of_birth')}}</span>
                                  @endif
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 mg20">
                                  <select onChange="getState(this.value);" name="country" class="rt-selectactive w-100-p select2-hidden-accessible" required="">
                                    <option value="">Select Country*</option>
                                      @foreach($countries as $country)
                                      <option value="{{ $country->id }}"> {{ $country->country_name }}</option>
                                      @endforeach
                                  </select>
                                  @if($errors->has('country'))
                                  <span class="text-danger">{{$errors->first('country')}}</span>
                                  @endif
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 mg20">
                                  <select name="state" id="state" onChange="getCity(this.value);" class="rt-selectactive w-100-p select2-hidden-accessible" required="">
                                    <option value="">Select State*</option>
                                  </select>
                                  @if($errors->has('state'))
                                  <span class="text-danger">{{$errors->first('state')}}</span>
                                  @endif
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 mg20">
                                  <select name="city" id="city" class="rt-selectactive w-100-p select2-hidden-accessible" required="">
                                    <option value="">Select City*</option>
                                  </select>
                                  @if($errors->has('state'))
                                  <span class="text-danger">{{$errors->first('state')}}</span>
                                  @endif
                                </div>

                                <div class="col-xl-6 col-lg-6 mg20">
                                  <input type="text" value="{{ old('address') }}" name="address" placeholder="Address*" required="">
                                </div>
                                <div class="col-xl-6 col-lg-6 mg20">
                                  <input type="number" value="{{ old('mobile') }}" name="mobile" placeholder="Mobile*" required="">
                                  @if($errors->has('mobile'))
                                  <span class="text-danger">{{$errors->first('mobile')}}</span>
                                  @endif
                                </div>

                                <div class="col-xl-6 col-lg-6 mg20" style="padding-top: 9px;">
                                  <label>Profile Image*</label><input style="max-width: 98px; margin-left: 15px;" type="file" name="profile_image" accept="image/png, image/jpeg" id="imgInp" required="">
                                  @if($errors->has('profile_image'))
                                  <span class="text-danger">{{$errors->first('profile_image')}}</span>
                                  @endif
                                </div>
                                
                                <div class="col-xl-6 col-lg-6 mg20">
                                <input type="password" name="password" value="{{ old('password') }}" id="password" class="form-control" placeholder="Password*">
                                @if($errors->has('password'))
                                  <span class="text-danger">{{$errors->first('password')}}</span>
                                @endif
                                </div>

                                <div class="col-xl-6 col-lg-6 mg20">
                                 <input name="confirm_password" value="{{ old('confirm_password') }}" id="confirm_password" class="form-control " type="password" placeholder="Confirm Password*">
                                 @if($errors->has('confirm_password'))
                                  <span class="text-danger">{{$errors->first('confirm_password')}}</span>
                                @endif
                                </div>
                                <div class="col-xl-12"> 
                                <img id="blah" style="max-width: 35%; margin-bottom: 15px;" src="#" alt="" />
                                </div>

                          </div>
                      
                     <div class="d-flex flex-wrap rt-mb-30">
                        <div class="flex-grow-1">
                           <div class="form-check from-chekbox-custom">
                              <input name="remember" required="" id="remember" class="form-check-input" type="checkbox" value="1">
                              <label class="form-check-label pointer text-gray-700 f-size-14" for="remember">
                              &nbsp;&nbsp;&nbsp; I've read and agree with <a href="#">Terms of Service</a>
                              </label>
                           </div>
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
                           <span class="button-text">Sign Up</span>
                        </span>
                     </button>
                  </form>
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