@php
    $route  = \Route::currentRouteName();    
@endphp
<section class="top-header">
    <div class="container">
    <div class="row">
    <div class="col-md-6 hide_in_phone">
        <ul>
            <li><a href="{{ route('home') }}" @if($route == 'home') class="active" @endif>Home</a></li>
            @if(\Auth::check())
               @if(((\Auth::user()->user_type)) == 2)
               <li><a href="{{ route('candidates') }}" @if($route == 'candidates') class="active" @endif>Candidates</a></li>
               <li><a href="{{ route('membership-plan') }}" @if($route == 'membership-plan') class="active" @endif>Plans</a></li>
               @endif

               @if(((\Auth::user()->user_type)) == 3)
               <li><a href="{{ route('jobs') }}" @if($route == 'jobs') class="active" @endif>Find Job</a></li>
               <li><a href="{{ route('companies') }}" @if($route == 'companies') class="active" @endif>Companies</a></li>
               @endif
            @else
            <li><a href="{{ route('jobs') }}" @if($route == 'jobs') class="active" @endif>Find Job</a></li>
            <li><a href="{{ route('candidates') }}" @if($route == 'candidates') class="active" @endif>Candidates</a></li>
            <li><a href="{{ route('companies') }}" @if($route == 'companies') class="active" @endif>Companies</a></li>
            @endif
            <li><a href="{{ route('blogs') }}" @if($route == 'blogs') class="active" @endif>Blog</a></li>

        </ul>


    </div>
    <div class="col-md-6">
    <ul class="right-menu">
      <li><a href="#" style="font-weight: 500; font-size: 14px; color: #18191c;"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9454 3.75C16.2169 4.09194 17.3761 4.76196 18.3071 5.69294C19.2381 6.62392 19.9081 7.78319 20.25 9.05462" stroke="#18191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M14.1687 6.64849C14.9316 6.85366 15.6271 7.25567 16.1857 7.81426C16.7443 8.37285 17.1463 9.06841 17.3515 9.83127" stroke="#18191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path><path d="M8.66965 11.7014C9.44762 13.2919 10.7369 14.5753 12.3309 15.346C12.4475 15.4013 12.5765 15.4253 12.7052 15.4155C12.8339 15.4058 12.9579 15.3627 13.0648 15.2905L15.4119 13.7254C15.5157 13.6562 15.6352 13.614 15.7594 13.6026C15.8837 13.5911 16.0088 13.6109 16.1235 13.6601L20.5144 15.5419C20.6636 15.6053 20.7881 15.7154 20.8693 15.8557C20.9504 15.996 20.9838 16.1588 20.9643 16.3197C20.8255 17.4057 20.2956 18.4039 19.4739 19.1274C18.6521 19.8508 17.5948 20.2499 16.5 20.25C13.1185 20.25 9.87548 18.9067 7.48439 16.5156C5.0933 14.1245 3.75 10.8815 3.75 7.5C3.75006 6.40516 4.14918 5.34789 4.87264 4.52613C5.5961 3.70438 6.59428 3.17451 7.68028 3.03572C7.84117 3.01625 8.00403 3.04959 8.14432 3.13073C8.28461 3.21186 8.39473 3.33639 8.4581 3.48555L10.3416 7.88035C10.3903 7.99403 10.4101 8.11799 10.3994 8.24119C10.3886 8.3644 10.3475 8.48302 10.2798 8.5865L8.72011 10.9696C8.64912 11.0768 8.60716 11.2006 8.59831 11.3289C8.58947 11.4571 8.61405 11.5855 8.66965 11.7014V11.7014Z" stroke="#18191C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg> 319-555-0115 </a></li>
      <li><a href="#" class="dropdown-toggle"><i class="flag-icon flag-icon-gb"></i> English &nbsp;</a></li>
    </ul>
    </div>
    </div>
    </div>
</section>

<header>
    <div class="container">
        <div class="row">
        <div class="col-md-2">
          <a href="{{ route('home') }}" class="logo"><img src="{!! asset('assets/frontend/images/logo.svg') !!}" class="img-fluid d-inline-block" alt="logo"></a>
        </div>
        <div class="col-md-6">
        <form id="labnol">
        <div class="row">    
        <div class="col-md-3">    
        <select name="country" onchange="getJobFilter(this.value)" id="cont_id">
            @foreach($countries as $country)
            <option value="{{ $country->id }}"> {{ $country->country_name }}</option>
            @endforeach
        </select>
        </div>
        <div class="col-md-8">

        @if(\Auth::check())
            @if((\Auth::user()->user_type) == 2)
                <input type="text" name="search" class="main-search" autocomplete="off" placeholder="Search Functional Area">
            @else
                <input type="text" name="search" class="main-search" autocomplete="off" placeholder="Job Title, Keyword">
            @endif
        @else    
        <input type="text" name="search" class="main-search" autocomplete="off" placeholder="Job Title, Keyword">
        @endif
        <ul id="total_records1"></ul>
        </div>
        </div>
        </form>
        </div>
        <div class="col-md-4">
            @if(\Auth::check())
            <div class="pro-menu">
            <a href="#" class="profile_btn"><img src="{!! asset(\Auth::user()->profile_image) !!}" class="user_img" alt=""> {{ \Auth::user()->name }} </a>

            <ul class="sub-menu">
            <li><a href="{{ route('my-profile') }}"> My Profile </a></li>
            @if((\Auth::user()->user_type) == 2)
            <li><a href="{{ route('job-post') }}">Job Post</a></li>
            <li><a href="{{ route('saved-job-seekers') }}">Saved Job Seekers</a></li>
            <li><a href="{{ route('billing-information') }}">Billings</a></li>
            @else 
            <li><a href="{{ route('saved-job') }}">Saved Jobs</a></li>
            <li><a href="{{ route('applied-job') }}">Applied Job</a></li>
            @endif
            
            <li><a href="{{ route('message') }}">Message</a></li>
            
            <li><a href="{{ route('change-password') }}">Change Password</a></li>
            <li><a href="{{ route('logout') }}"> Logout </a></li>
            </ul>
            </div>
           
            @else 
            <a href="{{ route('register') }}" class="sign-in-btn">Create Account</a>
            <a href="{{ route('login')}}" class="login-btn">Log In</a>
            @endif 
        </div>
        </div>
    </div>
</header>


