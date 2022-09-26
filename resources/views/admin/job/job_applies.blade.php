@extends('admin.layouts.master')
@section('content')
@section('css')
<link rel="stylesheet" type="text/css" href="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css"/>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
    $('#table').dataTable();
    } );
</script> 
<style type="text/css">
table tr td{
    padding: 12px 10px !important;
}    



</style>
@endsection
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">{{ $job->title }} <a class="btn btn-sm btn-primary pull-right" href="{{ route('jobs-list.edit', [$job->id]) }}"> <i class="fa fa-arrow-left"></i> Back </a></h1>
                <div class="panel panel-widget forms-panel" style="float: left;width: 100%; padding-bottom: 20px;">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Applied Candidates List</h4>                        
                            </div>
                            <div class="form-body">
                                
                                <table id="table" class="display">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">Name</th>
                                            <th style="text-align: left;">Designation</th>
                                            <th style="text-align: left;">Experience</th>
                                            <th style="text-align: left;">City</th>
                                            <th style="max-width: 180px;text-align: left;">Applied At</th>
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
                                            <td style="text-align: center;"><a href="{{ route('job-seekers.edit', [$plan->id]) }}" class="applyed_count"><i class="fa fa-eye"></i></a></td>
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            
                            </div>
                        </div>
                    </div>
                </div> 

            </div>
        </div>
    </div>
</div>

@stop




