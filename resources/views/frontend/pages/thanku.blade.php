@extends('frontend.layouts.app')
@section('content')


<section class="thanku-index">
<div class="container">  
<div class="thanku-box"> 

<img src="{!! asset('assets/frontend/images/succ.png') !!}" alt="succ">
<h1>Thank You!</h1>

@if($plan->category == 2)
<p>Your plan is successfully subscribed from {{ date('d M, Y') }} - {{ date('d M, Y', strtotime($expire_date)) }}</p>
@else
<p>Your plan is successfully subscribed</p>
@endif

<ul>
<li><b>Plan Name</b> {{ $plan->name }}</li>
@if($plan->category == 1)
<li><b>Job Post</b> {{ $plan->quantity }}</li>
@if($plan->job_description == 1)
<li>Detailed Job Description</li>
@else
<li>250 Characters in Job Description</li>  
@endif

@if($plan->city == 1)
<li>All Cities</li>
@else
<li>Non-Metro Cities</li>  
@endif

@if($plan->job_search == 1)
<li>Boost on Job Search Page</li>
@endif

@if($plan->job_branding == 1)
<li>Job Branding</li>
@endif

@else
<li><b>Profile View</b> {{ $plan->profile_view }}</li>
<li><b>Duration</b> {{ $plan->duration }} Days</li>
@endif
<li><b>Transaction ID</b> {{ $payment_id }}</li>
</ul>

</div>
</div>
</section>






@endsection    



