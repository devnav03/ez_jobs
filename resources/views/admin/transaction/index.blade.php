@extends('admin.layouts.master')
@section('css')
<!-- tables -->
<link rel="stylesheet" type="text/css" href="{!! asset('css/table-style.css') !!}" />
<!-- //tables -->
@endsection
@section('content')

<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">                
                <h1 class="page-header">Transactions Listing</h1>

                <div class="agile-tables">
                    <div class="w3l-table-info">
    

                        {{-- for message rendering --}}
                        @include('admin.layouts.messages')
                        <div class="panel panel-default">
                            <div class="panel-heading">Transactions Filter</div>
                            <div class="panel-body">
                                <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('transaction.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Employer</label>
                                                <select class="form-control" name="employer">
                                                    <option value="">Select</option>
                                                    @foreach($employers as $employer)
                                                    <option value="{{ $employer->id }}">{{ $employer->employer_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Plans</label>
                                                <select class="form-control" name="plan_id">
                                                    <option value="">Select</option>
                                                    @foreach($plans as $plan)
                                                        <option value="{{ $plan->id }}">{{ $plan->name }} @if($plan->category == 2) - Resume @else - Job Post @endif </option>
                                                    @endforeach
                                                </select>                                                
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">From</label>
                                                {!! Form::date('from', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2" style="padding-right: 0px;">
                                            <div class="form-group">
                                                <label for="to" class="control-label">To</label>
                                                {!! Form::date('to', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                            <label for="product_type" class="control-label">Payment Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="">Select</option>
                                                    <option value="1">Complete</option>
                                                    <option value="2">Pending</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 margintop20" style="padding-right: 0px; padding-left: 0px;">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit(lang('common.filter'), array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('transaction.index') !!}" class="btn btn-success"> Refresh<!-- {!! lang('common.reset_filter') !!} --></a>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('transaction.action') }}" method="post">
                            <div class="col-md-3 text-right pull-right padding0 marginbottom10">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!} 
                            </div>
                            <div class="col-md-3 padding0 marginbottom10">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                                <!-- {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search employer name')) !!} -->
                            </div>
                            <table id="paginate-load" data-route="{{ route('transaction.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

