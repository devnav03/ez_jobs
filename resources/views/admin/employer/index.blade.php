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
                <h1 class="page-header">Employer Listing</h1>

                <div class="agile-tables">
                    <div class="w3l-table-info">

                        {{-- for message rendering --}}
                        @include('admin.layouts.messages')
                        <div class="panel panel-default">
                            <div class="panel-heading">Employer Filter</div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('employer.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Employer Name</label>
                                                {!! Form::text('employer_name', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="name" class="control-label">Member Name</label>
                                                {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                       <!--  <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Email</label>
                                                {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div> -->
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label for="product_type" class="control-label">Mobile</label>
                                                {!! Form::number('mobile', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3 margintop20">
                                            <div class="form-group">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit(lang('common.filter'), array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('employer.index') !!}" class="btn btn-success"> {!! lang('common.reset_filter') !!}</a>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>


                        <form action="{{ route('employer.action') }}" method="post">
                            <div class="col-md-3 text-right pull-right padding0 marginbottom10">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0 marginbottom10">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                               <!--  {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search employer by name')) !!} -->
                            </div>

                            <table id="paginate-load" data-route="{{ route('employer.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

