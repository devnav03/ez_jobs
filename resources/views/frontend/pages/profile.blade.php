@extends('frontend.layouts.app')
@section('content')

@if($user->user_type == 3)
<section class="profile">
<div class="container">  
<div class="row">  
<div class="col-md-10 offset-md-1">
<div class="profile-box">
 @if(session()->has('profile_update'))
      <div class="alert alert-success" role="alert">Your profile has been successfully updated</div>
 @endif 
<form action="{{ route('update-profile') }}" enctype="multipart/form-data" method="POST">
  {{ csrf_field() }}
<div class="row">  
<div class="col-md-3">
  <img class="img-fluid mx-auto d-block" src="{!! asset($user->profile_image) !!}" alt="">
  <input type="file" accept="image/png, image/jpeg, image/png" class="mgn20"  name="profile_image"> 
</div>
<div class="col-md-9">
<div class="row">   
<div class="col-md-6">
<label>Name</label>  
<input type="text" value="{{ $user->name }}" name="name" required="true" class="form-control">
@if ($errors->has('name'))
<span class="text-danger">{{$errors->first('name')}}</span>
@endif
</div>
<div class="col-md-6">
<label>Email</label>  
<input type="email" value="{{ $user->email }}" name="email" required="true" class="form-control">
@if ($errors->has('email'))
<span class="text-danger">{{$errors->first('email')}}</span>
@endif
</div>

<div class="col-md-6 mgn20">
<label>Mobile</label>  
<input type="number" value="{{ $user->mobile }}" name="mobile" required="true" class="form-control">
@if ($errors->has('mobile'))
<span class="text-danger">{{$errors->first('mobile')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>Address</label>  
<input type="text" value="{{ $user->address }}" name="address" required="true" class="form-control">
@if ($errors->has('address'))
<span class="text-danger">{{$errors->first('address')}}</span>
@endif
</div>

<div class="col-md-6 mgn20">
<label>Gender</label>  
<select name="gender" class="form-control" required="true">
  <option value="Male" @if($user->gender == 'Male') selected @endif>Male</option>
  <option value="Female" @if($user->gender == 'Female') selected @endif>Female</option>
  <option value="Other" @if($user->gender == 'Other') selected @endif>Other</option>
</select>
@if($errors->has('gender'))
  <span class="text-danger">{{$errors->first('gender')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>DOB</label>  
<input type="text" onfocus="(this.type='date')" max="2004-08-01" value="{{ date('d M, Y', strtotime($user->date_of_birth)) }}" name="date_of_birth" required="true" class="form-control">
@if ($errors->has('date_of_birth'))
<span class="text-danger">{{$errors->first('date_of_birth')}}</span>
@endif
</div>
</div>
</div>
</div>

<div class="row">  
  <div class="col-md-3 mgn20">
    <label>Country</label>   
    <select onChange="getState(this.value);" name="country" class="form-control" required="true">
      @foreach($countries as $country)
      <option value="{{ $country->id }}" @if($user->country == $country->id) selected @endif> {{ $country->country_name }}</option>
      @endforeach
    </select>
    @if($errors->has('country'))
    <span class="text-danger">{{$errors->first('country')}}</span>
    @endif
  </div>
  <div class="col-md-9">
    <div class="row"> 
      <div class="col-md-6 mgn20">
        <label>State</label>   
        <select name="state" id="state" onChange="getCity(this.value);" class="form-control" required="true">
          @foreach($states as $state)
          <option value="{{ $state->id }}" @if($user->state == $state->id) selected @endif> {{ $state->name }}</option>
          @endforeach
        </select>
        @if($errors->has('state'))
        <span class="text-danger">{{$errors->first('state')}}</span>
        @endif
      </div>
      <div class="col-md-6 mgn20">
        <label>City</label>   
        <select name="city" id="city" class="form-control" required="true">
          @foreach($cities as $city)
          <option value="{{ $city->id }}" @if($user->city == $city->id) selected @endif> {{ $city->name }}</option>
          @endforeach
        </select>
        @if($errors->has('city'))
        <span class="text-danger">{{$errors->first('city')}}</span>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row">  
  <div class="col-md-3 mgn20">
    <label>Industry</label>   
    <select onChange="getSubcategory(this.value);" name="category" class="form-control" required="true">
      <option value="">Select</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}" @if(@$details->category == $category->id) selected @endif> {{ $category->name }}</option>
      @endforeach
    </select>
    @if($errors->has('category'))
    <span class="text-danger">{{$errors->first('category')}}</span>
    @endif
  </div>
  <div class="col-md-9">
    <div class="row"> 
      <div class="col-md-6 mgn20">
        <label>Functional Area</label>   
        <select name="sub_category" id="category-list" class="form-control" required="true">
          <option value="">Select</option>
          @foreach($sub_categories as $sub_category)
          <option value="{{ $sub_category->id }}" @if(@$details->sub_category == $sub_category->id) selected @endif> {{ $sub_category->name }}</option>
          @endforeach
        </select>
        @if($errors->has('sub_category'))
        <span class="text-danger">{{$errors->first('sub_category')}}</span>
        @endif
      </div>
      <div class="col-md-6 mgn20">
        <label>Job Role</label>   
        <select name="designation_id" id="designation_id" class="form-control" required="true">
          <option value="">Select</option>
          @foreach($designations as $designation)
          <option value="{{ $designation->id }}" @if(@$details->designation_id == $designation->id) selected @endif> {{ $designation->name }}</option>
          @endforeach
        </select>
        @if($errors->has('designation_id'))
        <span class="text-danger">{{$errors->first('designation_id')}}</span>
        @endif
      </div>
    </div>
  </div>
</div>


<div class="row">  
  <div class="col-md-3 mgn20">
    <label>Education</label>   
    <select name="education" class="form-control" required="true">
      <option value="">Select</option>
      @foreach($educations as $education)
      <option value="{{ $education->id }}" @if(@$details->education == $education->id) selected @endif> {{ $education->name }}</option>
      @endforeach
    </select>
    @if($errors->has('education'))
    <span class="text-danger">{{$errors->first('education')}}</span>
    @endif
  </div>
  <div class="col-md-9">
    <div class="row"> 
      <div class="col-md-3 mgn20">
        <label>Experience In Years</label>   
        <select name="experience_years" id="experience_years" class="form-control" required="true">
          <option value="">Select</option>
          <option value="0" @if(@$details->experience_years == '0') selected @endif>0</option>
          <option value="1" @if(@$details->experience_years == 1) selected @endif>1</option>
          <option value="2" @if(@$details->experience_years == 2) selected @endif>2</option>
          <option value="3" @if(@$details->experience_years == 3) selected @endif>3</option>
          <option value="4" @if(@$details->experience_years == 4) selected @endif>4</option>
          <option value="5" @if(@$details->experience_years == 5) selected @endif>5</option>
          <option value="6" @if(@$details->experience_years == 6) selected @endif>6</option>
          <option value="7" @if(@$details->experience_years == 7) selected @endif>7</option>
          <option value="8" @if(@$details->experience_years == 8) selected @endif>8</option>
          <option value="9" @if(@$details->experience_years == 9) selected @endif>9</option>
          <option value="10" @if(@$details->experience_years == 10) selected @endif>10</option>
          <option value="11" @if(@$details->experience_years == 11) selected @endif>11</option>
          <option value="12" @if(@$details->experience_years == 12) selected @endif>12</option>
          <option value="13" @if(@$details->experience_years == 13) selected @endif>13</option>
          <option value="14" @if(@$details->experience_years == 14) selected @endif>14</option>
          <option value="15" @if(@$details->experience_years == 15) selected @endif>15</option>
        </select>
        @if($errors->has('experience_years'))
        <span class="text-danger">{{$errors->first('experience_years')}}</span>
        @endif
      </div>
      <div class="col-md-3 mgn20">
        <label>Experience In Months</label>   
        <select name="experience_months" id="experience_months" class="form-control" required="true">
          <option value="">Select</option>
          <option value="0" @if(@$details->experience_months == '0') selected @endif>0</option>
          <option value="1" @if(@$details->experience_months == '1') selected @endif>1</option>
          <option value="2" @if(@$details->experience_months == 2) selected @endif>2</option>
          <option value="3" @if(@$details->experience_months == 3) selected @endif>3</option>
          <option value="4" @if(@$details->experience_months == 4) selected @endif>4</option>
          <option value="5" @if(@$details->experience_months == 5) selected @endif>5</option>
          <option value="6" @if(@$details->experience_months == 6) selected @endif>6</option>
          <option value="7" @if(@$details->experience_months == 7) selected @endif>7</option>
          <option value="8" @if(@$details->experience_months == 8) selected @endif>8</option>
          <option value="9" @if(@$details->experience_months == 9) selected @endif>9</option>
          <option value="10" @if(@$details->experience_months == 10) selected @endif>10</option>
          <option value="11" @if(@$details->experience_months == 11) selected @endif>11</option>
        </select>
        @if($errors->has('experience_months'))
        <span class="text-danger">{{$errors->first('experience_months')}}</span>
        @endif
      </div>

      <div class="col-md-3 mgn20">
        <label>Current Salary In Lakhs</label>   
        <select name="salary_lakhs" id="salary_lakhs" class="form-control" required="true">
          <option value="">Select</option>
          <option value="0" @if(@$details->salary_lakhs == '0') selected @endif>0</option>
          <option value="1" @if(@$details->salary_lakhs == 1) selected @endif>1</option>
          <option value="2" @if(@$details->salary_lakhs == 2) selected @endif>2</option>
          <option value="3" @if(@$details->salary_lakhs == 3) selected @endif>3</option>
          <option value="4" @if(@$details->salary_lakhs == 4) selected @endif>4</option>
          <option value="5" @if(@$details->salary_lakhs == 5) selected @endif>5</option>
          <option value="6" @if(@$details->salary_lakhs == 6) selected @endif>6</option>
          <option value="7" @if(@$details->salary_lakhs == 7) selected @endif>7</option>
          <option value="8" @if(@$details->salary_lakhs == 8) selected @endif>8</option>
          <option value="9" @if(@$details->salary_lakhs == 9) selected @endif>9</option>
          <option value="10" @if(@$details->salary_lakhs == 10) selected @endif>10</option>
          <option value="11" @if(@$details->salary_lakhs == 11) selected @endif>11</option>
          <option value="12" @if(@$details->salary_lakhs == 12) selected @endif>12</option>
          <option value="13" @if(@$details->salary_lakhs == 13) selected @endif>13</option>
          <option value="14" @if(@$details->salary_lakhs == 14) selected @endif>14</option>
          <option value="15" @if(@$details->salary_lakhs == 15) selected @endif>15</option>
        </select>
        @if($errors->has('salary_lakhs'))
        <span class="text-danger">{{$errors->first('salary_lakhs')}}</span>
        @endif
      </div>
      <div class="col-md-3 mgn20">
        <label>Salary In Thousands</label>   
        <select name="salary_thousands" id="salary_thousands" class="form-control" required="true">
          <option value="">Select</option>
          <option value="0" @if(@$details->salary_thousands == '0') selected @endif>0</option>
          <option value="5" @if(@$details->salary_thousands == '5') selected @endif>5</option>
          <option value="10" @if(@$details->salary_thousands == 10) selected @endif>10</option>
          <option value="15" @if(@$details->salary_thousands == 15) selected @endif>15</option>
          <option value="20" @if(@$details->salary_thousands == 20) selected @endif>20</option>
          <option value="25" @if(@$details->salary_thousands == 25) selected @endif>25</option>
          <option value="30" @if(@$details->salary_thousands == 30) selected @endif>30</option>
          <option value="35" @if(@$details->salary_thousands == 35) selected @endif>35</option>
          <option value="40" @if(@$details->salary_thousands == 40) selected @endif>40</option>
          <option value="45" @if(@$details->salary_thousands == 45) selected @endif>45</option>
          <option value="50" @if(@$details->salary_thousands == 50) selected @endif>50</option>
          <option value="55" @if(@$details->salary_thousands == 55) selected @endif>55</option>

          <option value="60" @if(@$details->salary_thousands == '60') selected @endif>60</option>
          <option value="65" @if(@$details->salary_thousands == 65) selected @endif>65</option>
          <option value="70" @if(@$details->salary_thousands == 70) selected @endif>70</option>
          <option value="75" @if(@$details->salary_thousands == 75) selected @endif>75</option>
          <option value="80" @if(@$details->salary_thousands == 80) selected @endif>80</option>
          <option value="85" @if(@$details->salary_thousands == 85) selected @endif>85</option>
          <option value="90" @if(@$details->salary_thousands == 90) selected @endif>90</option>
          <option value="95" @if(@$details->salary_thousands == 95) selected @endif>95</option>

        </select>
        @if($errors->has('salary_thousands'))
        <span class="text-danger">{{$errors->first('salary_thousands')}}</span>
        @endif
      </div>
    </div>
  </div>
</div>

<div class="row">  
  <div class="col-md-3 mgn20">
    <label>Upload Resume</label>   
    @if(@$details->resume)
    <a target="_blank" href="{{ route('home') }}{{ @$details->resume }}"><img src="{!! asset('assets/frontend/images/CV-or-Resume-Icon-Graphics.png') !!}" style="max-height: 90px;
    margin-bottom: 15px;" class="img-fluid" alt="resume"></a>

    <input type="file" accept=".pdf, .doc, .docx, image/png, image/jpeg"  name="resume">   
    @else
    <input type="file" accept=".pdf, .doc, .docx, image/png, image/jpeg"  name="resume" required="true"> 
    @endif
    @if($errors->has('resume'))
    <span class="text-danger">{{$errors->first('resume')}}</span>
    @endif
  </div>
  <div class="col-md-9 mgn20">
      <label>Key Skills</label>   
      <textarea class="form-control" required="true" name="key_skills">{{ @$details->key_skills }}</textarea>
      @if($errors->has('key_skills'))
      <span class="text-danger">{{$errors->first('key_skills')}}</span>
      @endif
 
  </div>
  <div class="col-md-12 submit_field mgn20">
    <input type="submit" name="submit" value="Update">
  </div>
</div>
</form>
</div>

</div>
</div>
</div>
</section>

@else
<section class="profile">
<div class="container">  
<div class="row">  
<div class="col-md-10 offset-md-1">
<div class="profile-box">
 @if(session()->has('profile_update'))
      <div class="alert alert-success" role="alert">Your profile has been successfully updated</div>
 @endif 
<form action="{{ route('employer-profile-update') }}" enctype="multipart/form-data" method="POST">
  {{ csrf_field() }}
<div class="row">  
<div class="col-md-3">
  <img class="img-fluid mx-auto d-block" src="{!! asset($user->profile_image) !!}" alt="">
  <input type="file" accept="image/png, image/jpeg, image/png" class="mgn20"  name="profile_image"> 

@if($user->video)
<video width="100%" controls style="margin-top: 30px;">
  <source src="{{ $user->video }}" type="video/mp4">
  <source src="{{ $user->video }}" type="video/ogg">
  Your browser does not support HTML video.
</video>
@endif

</div>
<div class="col-md-9">

<div class="row">  
<div class="col-md-6">
<label>Employer Name</label>  
<input type="text" value="{{ $user->employer_name }}" name="employer_name" required="true" class="form-control">
@if ($errors->has('employer_name'))
<span class="text-danger">{{$errors->first('employer_name')}}</span>
@endif
</div> 
<div class="col-md-6">
<label>Member Name</label>  
<input type="text" value="{{ $user->name }}" name="name" required="true" class="form-control">
@if ($errors->has('name'))
<span class="text-danger">{{$errors->first('name')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>Email</label>  
<input type="email" value="{{ $user->email }}" name="email" required="true" class="form-control">
@if ($errors->has('email'))
<span class="text-danger">{{$errors->first('email')}}</span>
@endif
</div>

<div class="col-md-6 mgn20">
<label>Mobile</label>  
<input type="number" value="{{ $user->mobile }}" name="mobile" required="true" class="form-control">
@if ($errors->has('mobile'))
<span class="text-danger">{{$errors->first('mobile')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>Address</label>  
<input type="text" value="{{ $user->address }}" name="address" required="true" class="form-control">
@if ($errors->has('address'))
<span class="text-danger">{{$errors->first('address')}}</span>
@endif
</div>


<div class="col-md-6 mgn20">
<label>Gender</label>  
<select name="gender" class="form-control" required="true">
  <option value="Male" @if($user->gender == 'Male') selected @endif>Male</option>
  <option value="Female" @if($user->gender == 'Female') selected @endif>Female</option>
  <option value="Other" @if($user->gender == 'Other') selected @endif>Other</option>
</select>
@if($errors->has('gender'))
  <span class="text-danger">{{$errors->first('gender')}}</span>
@endif
</div>
<div class="col-md-6 mgn20">
<label>DOB</label>  
<input type="text" onfocus="(this.type='date')" max="2004-08-01" value="{{ date('d M, Y', strtotime($user->date_of_birth)) }}" name="date_of_birth" required="true" class="form-control">
@if ($errors->has('date_of_birth'))
<span class="text-danger">{{$errors->first('date_of_birth')}}</span>
@endif
</div>

  <div class="col-md-6 mgn20">
    <label>Country</label>   
    <select onChange="getState(this.value);" name="country" class="form-control" required="true">
      @foreach($countries as $country)
      <option value="{{ $country->id }}" @if($user->country == $country->id) selected @endif> {{ $country->country_name }}</option>
      @endforeach
    </select>
    @if($errors->has('country'))
    <span class="text-danger">{{$errors->first('country')}}</span>
    @endif
  </div>


      <div class="col-md-6 mgn20">
        <label>State</label>   
        <select name="state" id="state" onChange="getCity(this.value);" class="form-control" required="true">
          @foreach($states as $state)
          <option value="{{ $state->id }}" @if($user->state == $state->id) selected @endif> {{ $state->name }}</option>
          @endforeach
        </select>
        @if($errors->has('state'))
        <span class="text-danger">{{$errors->first('state')}}</span>
        @endif
      </div>
      <div class="col-md-6 mgn20">
        <label>City</label>   
        <select name="city" id="city" class="form-control" required="true">
          @foreach($cities as $city)
          <option value="{{ $city->id }}" @if($user->city == $city->id) selected @endif> {{ $city->name }}</option>
          @endforeach
        </select>
        @if($errors->has('city'))
        <span class="text-danger">{{$errors->first('city')}}</span>
        @endif
      </div>

      <div class="col-md-6 mgn20">
        <label>Vacancy Available</label>  
        <select name="vacancy" class="form-control" required="true">
          <option value="">Select</option>
          <option value="1" @if($user->vacancy == '1') selected @endif>Yes</option>
          <option value="0" @if($user->vacancy == '0') selected @endif>No</option>
        </select>
        @if($errors->has('vacancy'))
          <span class="text-danger">{{$errors->first('vacancy')}}</span>
        @endif
      </div>

      @if($user->plan_expire)
        <div class="col-md-6 mgn20">
          <label>Current Plan Expire</label>  
          <input type="text" value="{{ $user->plan_expire }}" required="true" readonly="" class="form-control">
        </div>
      @endif
        <div class="col-md-6 mgn20">
          <label>Upload Video (max size 50MB)</label>  
          <input type="file" accept="video/mp4,video/x-m4v,video/*" name="video"> 
          @if($errors->has('video'))
          <span class="text-danger" style="display: block;">{{$errors->first('video')}}</span>
          @endif
        </div>
      <div class="col-md-12 submit_field mgn20">
        <input type="submit" name="submit" value="Update">
      </div>
 
</div>


</div>

</div>
</form>
</div>
</div>
</div>
</div>
</section>



@endif


@endsection    