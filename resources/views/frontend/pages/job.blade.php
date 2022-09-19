@extends('frontend.layouts.app')
@section('content')

<section class="jobs-index">
<div class="container">  
<div class="profile-box"> 
@if(session()->has('job_posted'))
      <div class="alert alert-success" role="alert">Job Successfully Posted</div>
@endif 
@if(session()->has('job_updated'))
      <div class="alert alert-success" role="alert">Job Successfully Updated</div>
@endif
@if(session()->has('upgrade_plan'))
      <div class="alert alert-danger" role="alert">Kindly Upgrade Your Plan</div>
@endif 
@if(session()->has('job_expire'))
      <div class="alert alert-danger" role="alert">Job is Expired</div>
@endif 

<h1>All Posted Jobs <a href="{{ route('post-a-new-job') }}">Post New Job</a></h1>

   <table id="table" class="display">
    <thead>
        <tr>
            <th>Title</th>
            <th>Industry</th>
            <th>Functional Area</th>
            <th>Appliers</th>
            <th>Status</th>
            <th>Posted At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
  @foreach($plans as $plan)
@php
$created_at = date('Y-m-d', strtotime($plan->created_at));
$earlier = new DateTime($created_at);
$today = date('Y-m-d');
$later = new DateTime($today);
$abs_diff = $later->diff($earlier)->format("%a");
$applyed_count = get_applyed_job_count($plan->id);
@endphp

    <tr>
        <td>{{ $plan->title }}</td>
        <td>{{ $plan->cat }}</td>
        <td>{{ $plan->sub_cat }}</td>
        <td>{{ $applyed_count }} @if($applyed_count != 0) <a class="applyed_count" href="{{ route('appliers-list', $plan->id) }}"><i class="fa fa-eye"></i></a>  @endif </td>
        <td>@if($abs_diff > 30) Inactive @else @if($plan->status == 1) Active @else Inactive @endif @endif </td>
        <td>{{ date('d M, Y', strtotime($plan->created_at)) }} </td>
        <td>@if($abs_diff <= 30) <a href="{{ route('edit-job', $plan->id) }}">Edit</a> @endif</td>
    </tr>
  @endforeach 
</tbody>
</table>


</div>
</div>
</section>















@endsection    



