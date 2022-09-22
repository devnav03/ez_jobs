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
            <th>Designation</th>
            <th>Experience</th>
            <th>City</th>
            <th style="max-width: 180px;">Applied At</th>
            <th>View</th>
        </tr>
    </thead>
    <tbody>
  @foreach($candidates as $plan)
    <tr>
        <td>{{ $plan->name }}</td>
        <td>{{ $plan->cat }}</td>
        <td>{{ $plan->experience_years }}y {{ $plan->experience_months }}m</td>
        <td>{{ $plan->city }}</td>
        <td>{{ date('d M, Y H:i A', strtotime($plan->created_at)) }} </td>
        <td><a href="{{ route('candidate-profile', $plan->id) }}" class="applyed_count"><i class="fa fa-eye"></i></a></td>
    </tr>
  @endforeach 
</tbody>
</table>


</div>
</div>
</section>















@endsection    



