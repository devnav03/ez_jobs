@extends('frontend.layouts.app')
@section('content')

<section class="jobs-index appliers_list">
<div class="container">  
<div class="profile-box"> 


<h1 style="color: #0a66cd;">Appliers list for  {{ $job->title }} Post <span style="color: #000;">Posted at {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</span> </h1>

   <table id="table" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Industry</th>
            <th>Functional Area</th>
            <th>Appliers</th>
            <th>Status</th>
            <th>Posted At</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
  @foreach($candidates as $plan)
@php
$created_at = date('Y-m-d', strtotime($plan->created_at));
$earlier = new DateTime($created_at);
$today = date('Y-m-d');
$later = new DateTime($today);
$abs_diff = $later->diff($earlier)->format("%a");
$applyed_count = get_applyed_job_count($plan->id);
@endphp

    <tr>
        <td>{{ $plan->name }}</td>
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



