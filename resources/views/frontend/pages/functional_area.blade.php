@extends('frontend.layouts.app')
@section('content')


<div class="most-popular-area rt-pt-100 rt-pt-md-50" style="background: #f3f3f3;
    padding-top: 50px;">
   <div class="container">
      <h4 style="color: #0a66cd;">Functional Area Of  {{ $job->name }}</h4>
        <div class="rt-spacer-40 rt-spacer-md-20"></div>
        <div class="row">
        @foreach($categories as $vacanc)
        @php
		    $job = check_subcat_job($vacanc->id);
		@endphp 

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="most-popular-wrap">
                <div class="most-popular-item">
                  <h3><a href="{{ route('job-by-functional-area', $vacanc->id) }}">{{ $vacanc->name }}</a></h3>
                  <p>{{ $job }} Open Positions</p>
                </div>
            </div>
        </div>
        @endforeach   
        </div>
    </div>
   <div class="rt-spacer-90 rt-spacer-md-50"></div>
</div>














@endsection    



