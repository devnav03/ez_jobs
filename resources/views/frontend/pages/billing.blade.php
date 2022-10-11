@extends('frontend.layouts.app')
@section('content')


<section class="billing-index">
<div class="container">  
<div class="billing-box"> 
<div class="row">  
<div class="col-md-4">
<div class="membership_box">
<h5>Membership Status</h5>
@php
$today = date('Y-m-d');
@endphp
@if(\Auth::user()->plan_expire)
@if($today <= \Auth::user()->plan_expire)
<h6>Active</h6>
@else
<h6>Inactive</h6>
@endif
@else
<h6>Pending</h6>
@endif
</div>
</div>

<div class="col-md-4">
<div class="membership_box">
<h5>Balance Views</h5>
@if($today <= \Auth::user()->plan_expire)
<h6>{{ \Auth::user()->profile_view_limit }}</h6>
@else
<h6>0</h6>
@endif
</div>
</div>

<div class="col-md-4">
<div class="membership_box">
<h5>Balance Job Post</h5>
@if(\Auth::user()->job_post_limit)
<h6>{{ \Auth::user()->job_post_limit }}</h6>
@else
<h6>0</h6>
@endif
</div>
</div>
</div>

<h1 style="font-size: 24px;">All Transactions</h1>
<table>
<tr style="border: 2px solid #000;">
  <th style="text-align: center;">Sr. No</th>
  <th>Plan Name</th>
  <th>Plan For</th>
  <th>Price</th>
  <th>Payment ID</th>
  <th>Date</th>
</tr>
@php
$i = 0;
@endphp   
  @foreach($billings as $billing)
@php
$i++;
@endphp     
<tr>
  <td style="text-align: center;">{{ $i }}</td>
  <td>{{ $billing->plan }}</td>
  @if($billing->category == 1)
  <td>Job Post</td>
  @else
  <td>Profile View</td>
  @endif
  <td>@if($billing->category == 1) {{ $billing->price*$billing->quantity }} @else {{ $billing->price }} @endif </td>
  <td>{{ $billing->transaction_id }}</td>
  <td>{{ date('d M, Y', strtotime($billing->created_at)) }}</td>
</tr>

  @endforeach 
</table>
@if($i == 0)
<h6 style="padding: 25px 0px; font-size: 18px;">No Transactions</h6>
@endif
</div>
</div>

</section>















@endsection    



