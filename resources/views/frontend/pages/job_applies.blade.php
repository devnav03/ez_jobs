@extends('frontend.layouts.app')
@section('content')


@if(count($jobs) == 0)
<h1 style="text-align: center; font-size: 22px; padding-top: 20px; margin-bottom: 0px;">No Jobs Found</h1>
@endif

<section class="jobs-index">
<div class="container">  
<div class="profile-box">

<h1>Applied Job's List </h1>

   <table id="table" class="display">
    <thead>
        <tr>
            <th>Job Title</th>
            <th>Employer Name </th>
            <th>Industry</th>
            <th>Functional Area</th>
            <th>Experience</th>
            <th>Salary</th>
            <th>Date Applied</th>
            <th>Status</th>
            <th style="text-align: center;">View</th>
        </tr>
    </thead>
    <tbody>
  @foreach($jobs as $plan)
    <tr>
        <td><a style="color: #212529;" href="{{ route('job-details', $plan->id) }}">{{ $plan->title }}</a></td>
        <td>{{ $plan->employer_name }}</td>
        <td>{{ $plan->cat }}</td>
        <td>{{ $plan->sub_cat }}</td>
        <td> </td>
        <td>{{ $plan->salary }} </td>
        <td>{{ date('d M, Y', strtotime($plan->created_at)) }} </td>
        <td> @if($plan->status == 1) Pending @elseif($plan->status == 2) Considered @else  Rejected @endif </td>
        <td style="text-align: center;"><a href="{{ route('job-details', $plan->id) }}"><i class="fa fa-eye"></i> </a></td>
    </tr>
  @endforeach 
</tbody>
</table>


</div>
</div>
</section>





@endsection    