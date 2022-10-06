@extends('frontend.layouts.app')
@section('content')

<section class="breadcrum">
<div class="container"> 
<div class="row"> 
<div class="col-md-6">
<h1>Contact Us</h1>
</div>
<div class="col-md-6">
<ul>
<li><a href="{{ route('home') }}">Home</a></li>
<li>/ &nbsp; Contact Us</li>
</ul> 
</div>
</div>
</div>
</section>


<div class="rt-contact">
        <div class="container">
            @if(session()->has('enquiry_sub'))
            <li class="alert alert-success" style="list-style: none; line-height: 30px; font-size: 18px; padding: 1px 10px;  margin: 0px 0px 30px 0px;">Your enquiry has been received and we will be contacting you shortly to follow-up.</li>
            @endif  
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 rt-mb-lg-30 ">
                    <div class="pl30">
                      <span class="body-font-3 ft-wt-5 text-primary-500 rt-mb-15 d-inline-block">Who we are</span>
                      <h2 class="rt-mb-32">We care about customer services</h2>
                      <p class="body-font-2 text-gray-500 rt-mb-32">Want to chat? We’d love to hear from you! Get in touch with our Customer Success Team to inquire about speaking events, advertising rates, or just say hello.</p>
                      <a href="mailto:navjot@shailersolutions.com" target="__blank" class="btn btn-primary btn-lg">Email Support</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="contact-auth-box">
                        <form action="{{ route('contact-enquiry') }}" method="post">
                            {{ csrf_field() }}
                            <h5 class="rt-mb-32">Get In Touch</h5>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fromGroup rt-mb-15">
                                        <input id="first_name" class=" form-control" type="text" placeholder="First Name*" name="first_name" value="{{ old('first_name') }}" required="true">
                                        @if($errors->has('first_name'))
                                          <span class="text-danger">{{$errors->first('first_name')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fromGroup rt-mb-15">
                                        <input id="last_name" class=" form-control" type="text" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}">
                                        <input type="hidden" name="two" value="{{ $two }}">
                                        <input type="hidden" name="three" value="{{ $three }}">
                                        @if($errors->has('last_name'))
                                          <span class="text-danger">{{$errors->first('last_name')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="fromGroup rt-mb-15">
                                        <input id="email" class="form-control " type="email" placeholder="Email*" name="email" value="{{ old('email') }}" required="true">
                                        @if($errors->has('email'))
                                          <span class="text-danger">{{$errors->first('email')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fromGroup rt-mb-15">
                                        <input id="mobile" class="form-control " type="number" placeholder="Mobile No*" name="mobile" value="{{ old('mobile') }}" required="true">
                                        @if($errors->has('mobile'))
                                          <span class="text-danger">{{$errors->first('mobile')}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="fromGroup rt-mb-15">
                                        <input id="phone_number" class="form-control " type="number" placeholder="Phone Number" name="phone_number" value="{{ old('phone_number') }}">
                                        @if($errors->has('phone_number'))
                                          <span class="text-danger">{{$errors->first('phone_number')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="rt-mb-30 tarea-dafault">
                                <textarea id="message" class="form-control " type="text" placeholder="Message*" name="message">{{ old('message') }}</textarea>
                                @if($errors->has('message'))
                                  <span class="text-danger">{{$errors->first('message')}}</span>
                                @endif
                           </div>
                           <div class="col-md-12">
                            <p style="float: left; margin-top: 20px; margin-right: 10px;color: #f00;">Fill Captcha</p>
                            <p style="float: left; margin-top: 20px; margin-right: 10px;">{{ $three }} + {{ $two }} = </p> <input style="float: left; width: 75px; text-align: center; margin-top: 10px; margin-bottom: 15px;" required="true" type="number" name="rec_value"> 
                            
                           @if(session()->has('recap_sub'))
                               <span class="text-danger" style="margin-top: -10px; width: 100%;float: left;">recaptcha not valid </span>
                           @endif
                           </div>

                            <button type="submit" class="btn btn-primary d-block rt-mb-15" id="submitButton">
                                <span class="button-content-wrapper ">
                                    <span class="button-icon align-icon-right">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 2L11 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                    <span class="button-text rt-mr-8">
                                        Send Message
                                    </span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3179623.383705635!2d-3.8531728754248045!3d38.89880650713678!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd422997800a3c81%3A0xc436dec1618c2269!2sMadrid%2C%20Spain!5e0!3m2!1sen!2sin!4v1663755613627!5m2!1sen!2sin" width="100%" height="536" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
@endsection