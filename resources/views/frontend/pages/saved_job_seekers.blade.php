@extends('frontend.layouts.app')
@section('content')

<section class="jobs-index">
<div class="container">  
<div class="profile-box"> 
@if(session()->has('job_posted'))
      <div class="alert alert-success" role="alert">Job Successfully Posted</div>
@endif 

<h1>Saved Job Seekers</h1>

   <table id="table" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Functional Area</th>
            <th>Experience</th>
            <th>Salary</th>
            <th>City</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
  @foreach($candidates as $plan)
    <tr>
        <td>{{ $plan->name }}</td>
        <td>{{ $plan->cat }}</td>
        <td>{{ $plan->experience_years }}y {{ $plan->experience_months }}m</td>
        <td>{{ $plan->salary_lakhs }}.{{ $plan->salary_thousands }} LPA</td>
        <td>{{ $plan->city }}</td>

        <td><a style="background: #0a66cd; color: #fff; font-size: 13px; padding: 5px 7px;" href="{{ route('candidate-profile', $plan->id) }}">View</a> </td>
    </tr>
  @endforeach 
</tbody>
</table>

</div>
</div>
</section>

@endsection    



