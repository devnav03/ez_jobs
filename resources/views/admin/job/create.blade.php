@extends('admin.layouts.master')
@section('content')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Job Details <a class="btn btn-sm btn-primary pull-right" href="{!! route('jobs-list.index') !!}"> <i class="fa fa-arrow-left"></i> All Jobs </a></h1>
                <div class="panel panel-widget forms-panel" style="float: left;width: 100%; padding-bottom: 20px;">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>{{ $job->title }}</h4>                        
                            </div>
                            <div class="form-body">
             
                                 <div class="row">
                                    <div class="col-md-2">
                                        {!! Html::image(($job->profile_image),'' ,array('width' => 150 , 'class'=>'img-responsive') ) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <ul>
                                            <li><span>Employer Name:</span> {{ $job->employer_name }}</li>
                                            <li><span>Member Name:</span> {{ $job->member_name }}</li>
                                            <li><span>Email ID:</span> {{ $job->email }}</li>
                                            <li><span>Mobile:</span> {{ $job->mobile }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul>
                                            <li><span>Job Title:</span> {{ $job->title }}</li>
                                            <li><span>Industry:</span> {{ $job->cat }}</li>
                                            <li><span>Functional Area:</span> {{ $job->sub_cat }}</li>
                                            <li><span>Job Type:</span> {{ $job->job_type }}</li>
                                            <li><span>Salary:</span> {{ $job->salary }}</li> 
                                            <li><span>Qualifications:</span> {{ $job->education }}</li> 
                                            <li><span>City:</span> {{ $job->city }}</li>
                                            <li><span>State:</span> {{ $job->state }}</li>
                                            <li><span>Job Status:</span> @if($job->status == 1) Active @else Inactive @endif</li>
                                            <li><span>Number of Positions:</span> {{ $job->number_of_positions }}</li>
                                            <li><span>Posted At:</span> {{ date('d M, Y', strtotime($job->created_at)) }}</li>
                                            <li><span>Appliers</span> {{ check_jobs_total_applied($job->id) }} <a href="{{ route('job_applies', $job->id) }}"><i style="background: #0a66cd; color: #fff; padding: 5px 8px; font-size: 13px;" class="fa fa-eye"></i></a> </li>
                                        </ul>
                                        
                                    </div>
                            </div>
                                 <p style="font-size: 18px;"><b>Job Description</b></p>
                                        {!! $job->job_description !!}   
                            
                            </div>
                        </div>
                    </div>
                </div> 

            </div>
        </div>
    </div>
</div>

<style type="text/css">
.form-body li{
    list-style: none;
    font-size: 14px;
    margin-bottom: 10px;
}
.form-body li span {
    color: #1777e5;
}
.form-body li span{
    width: 150px;
    display: inline-block;
}
</style>

@stop




