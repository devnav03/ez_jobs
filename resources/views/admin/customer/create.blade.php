@extends('admin.layouts.master')
@section('content')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Job Seekers <a class="btn btn-sm btn-primary pull-right" href="{!! route('job-seekers.index') !!}"> <i class="fa fa-arrow-left"></i> All job seekers </a></h1>
                <div class="panel panel-widget forms-panel" style="float: left;width: 100%; padding-bottom: 20px;">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Job Seekers Information</h4>                        
                            </div>
                            <div class="form-body">
             
                                 <div class="row">
                                    <div class="col-md-2">
                                        {!! Html::image(($result->profile_image),'' ,array('width' => 150 , 'class'=>'img-responsive') ) !!}
                                    </div>
                                    <div class="col-md-9">
                                        <ul>
                                            <li><span>Candidate Name:</span> {{ $result->name }}</li>
                                            <li><span>Email ID:</span> {{ $result->email }}</li>
                                            <li><span>Mobile:</span> {{ $result->mobile }}</li>
                                            <li><span>Gender:</span> {{ $result->gender }}</li>
                                            <li><span>Date of Birth:</span> {{ date('d M, Y', strtotime( $result->date_of_birth)) }}</li>
                                            <li><span>Address:</span> {{ $result->address }}</li>
                                            <li><span>City:</span> {{ $city->name }}</li>
                                            <li><span>State:</span> {{ $state->name }}</li>
                                            <li><span>Country:</span> {{ $country->name }}</li>
                                           
                                            <li><span>Status:</span> @if($result->status == 1) Active @else Inactive @endif</li>
                                        </ul>
                                    </div>
                            </div>
                                    
                            
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
    font-size: 16px;
    margin-bottom: 10px;
}
.form-body li span {
    color: #1777e5;
}
</style>

@stop




