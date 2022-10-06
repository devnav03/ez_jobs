@extends('frontend.layouts.app')
@section('content')
<section class="breadcrum">
<div class="container"> 
<div class="row"> 
<div class="col-md-6">
<h1>Change Password</h1>
</div>
<div class="col-md-6">
<ul>
<li><a href="{{ route('home') }}">Home</a></li>
<li>/ &nbsp; Change Password</li>
</ul> 
</div>
</div>
</div>
</section>

<div class="clearfix"></div>
<div class="page main-signin-wrapper">
<div class="container">
      <div class="row signpages text-center top70">
        <div class="col-md-6 offset-md-3">
          <div class="card">
                <div class="container-fluid">
                    <div class="card-body mt-2 mb-2">
                      <h5 class="text-left mb-2" style="color: #0a66cd;font-size: 18px;margin-bottom: 20px !important; font-weight: 700;">Change Password</h5>
                     <form action="{{ route('change-password.store') }}" method="POST">
                        {{ csrf_field() }}
                        @if(session()->has('old_password_not_match'))
                            <p style="color: #f00;text-align: left; font-size: 16px;">Old Password is not Match</p>
                        @endif
                        @if(session()->has('password_change'))
                        <p style="color: green; text-align: left; font-size: 16px;">Your password has been changed successfully.</p>
                        @endif
                        <div class="form-group text-left">
                          <label>Old Password</label>
                          <input id="old_password" class="form-control" type="password" placeholder="Enter Old Password" required="true" name="old_password">
                          @if($errors->has('old_password'))
                            <span class="text-danger">{{$errors->first('old_password')}}</span>
                          @endif 
                        </div>
       
                        <div class="form-group text-left">
                          <label>New Password</label>
                          <input class="form-control" type="password" placeholder="Enter New Password" required="true" name="new_password">
                          @if($errors->has('new_password'))
                            <span class="text-danger">{{$errors->first('new_password')}}</span>
                          @endif
                        </div>

                        <div class="form-group text-left">
                          <label>Confirm New Password</label>
                          <input class="form-control" type="password" placeholder="Enter New Password" required="true" name="new_password_confirmation">
                          @if($errors->has('new_password_confirmation'))
                            <span class="text-danger">{{$errors->first('new_password_confirmation')}}</span>
                          @endif
                        </div>
                        <button class="btn ripple btn-main-primary btn-block">Save Changes</button>
                      </form>
                    </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


                
@endsection