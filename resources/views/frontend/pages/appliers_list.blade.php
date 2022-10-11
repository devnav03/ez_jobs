@extends('frontend.layouts.app')
@section('content')

<section class="jobs-index appliers_list">
<div class="container">  
<div class="profile-box"> 

@if(session()->has('applier_consider'))
      <div class="alert alert-success" role="alert">Applier Successfully Considered For Job</div>
@endif 
@if(session()->has('applier_reject'))
      <div class="alert alert-success" role="alert">Applier Successfully Rejected From Job</div>
@endif 

<h1 style="color: #0a66cd;">Appliers list for  {{ $job->title }} Post <span style="color: #000;">Posted at {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans() }}</span> </h1>

   <table id="table" class="display">
    <thead>
        <tr>
            <th>Name</th>
            <th>Designation</th>
            <th>Experience</th>
            <th>City</th>
            <th style="max-width: 180px;">Applied At</th>
            <th>Action</th>
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
        <td><a href="{{ route('candidate-profile', $plan->id) }}" class="applyed_count"><i class="fa fa-eye"></i></a>
        
        @if($plan->status == 1)
            <a href="{{ route('applier-consider', $plan->apl_id) }}" style="background: #4BB543; color: #fff;font-size: 14px; padding: 3px 16px; border-radius: 6px;">Consider</a>
            <a href="{{ route('applier-reject', $plan->apl_id) }}" style="background: #f00; color: #fff;font-size: 14px; padding: 3px 16px; border-radius: 6px;">Reject</a> 
        @else
        @if($plan->status == 2)
            <a href="#" style="background: #4BB543; color: #fff;font-size: 14px; padding: 3px 16px; border-radius: 6px;">Consider</a>
        @else
            <a href="#" style="background: #f00; color: #fff;font-size: 14px; padding: 3px 16px; border-radius: 6px;">Reject</a> 
        @endif
        @endif
        </td>
    </tr>
  @endforeach 
</tbody>
</table>


</div>
</div>
</section>















@endsection    



