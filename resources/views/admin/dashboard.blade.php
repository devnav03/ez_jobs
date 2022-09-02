@extends('admin.layouts.master')
@section('content')
@section('css')
<!-- tables -->
<!-- <link rel="stylesheet" type="text/css" href="{!! asset('css/table-style.css') !!}" /> -->
<!-- //tables -->
@endsection
  <div class="social grid">
    <div class="grid-info">
        <!-- <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments">
                <div class="comments-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="comments-info">
                    <h3>0</h3>
                    <a href="#">Total Ads</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments">
                <div class="comments-icon">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="comments-info">
                    <h3>0</h3>
                    <a href="#">New Ads</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> -->
        <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments likes">
                <div class="comments-icon">
                    <i class="fa fa-user"></i>
                </div>
                <div class="comments-info likes-info">
                    <h3>0</h3>
                    <a href="#"> <!-- Total Users --> </a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments likes">
                <div class="comments-icon">
                    <i class="fa fa-user"></i>
                </div>
                <div class="comments-info likes-info">
                    <h3>{!! $newusers !!}</h3>
                    <a href="#"> <!-- New Users --> </a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div>
       
     <!--    <div class="col-md-3 top-comment-grid" style="margin-top: 1rem;">
          <a href="#">
            <div class="comments tweets">
                <div class="comments-icon">
                    <img src="{{ url('/') }}/images/product_ic.png" class="side_icon">
                </div>
                <div class="comments-info tweets-info">
                    <h3>0</h3>
                    <a href="#">Total Plan</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments tweets">
                <div class="comments-icon">
                    <img src="{{ url('/') }}/images/product_ic.png" class="side_icon">
                </div>
                <div class="comments-info tweets-info">
                    <h3>0</h3>
                    <a href="#">New Plan</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> -->

  <!--       <div class="col-md-3 top-comment-grid">
          <a href="#">
            <div class="comments views">
                <div class="comments-icon">
                    <i class="fa fa-dollar" style="color: #fff; font-size: 4em !important;margin: 0;padding: 0;"></i>
                </div>
                <div class="comments-info views-info">
                    <h3>0</h3>
                    <a href="#">Total Income</a>
                </div>
                <div class="clearfix"> </div>
            </div>
          </a>
        </div> -->
        
        <div class="clearfix"> </div>
    </div>
  </div>
  
@endsection