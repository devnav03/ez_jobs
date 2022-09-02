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
                <h1 class="page-header">Jobs List</h1>

                <div class="agile-tables">
                    <div class="w3l-table-info">

                        {{-- for message rendering --}}
                        @include('admin.layouts.messages')
                        <div class="panel panel-default">
                            <div class="panel-heading">Jobs Filter</div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    {!! Form::open(array('method' => 'POST',
                                    'route' => array('jobs-list.paginate'), 'id' => 'ajaxForm')) !!}
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="title" class="control-label">Title</label>
                                                {!! Form::text('title', null, array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="category_id" class="control-label">Industry</label>
                                                <select onChange="getSubcategory(this.value);" name="category_id" class="form-control">
                                                    <option value="">select</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="sub_category" class="control-label">Functional Area</label>
                                                <select name="sub_category" id="category-list" class="form-control">
                                                    <option value="">select</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="country_id" class="control-label">Country</label>
                                                <select onChange="getState(this.value);" name="country" class="form-control">
                                                  <option value="">Select</option>  
                                                  @foreach($countries as $country)
                                                  <option value="{{ $country->id }}"> {{ $country->country_name }}</option>
                                                  @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="state_id" class="control-label">State</label>
                                                <select name="state_id" id="state" onChange="getCity(this.value);" class="form-control">
                                                    <option value="">Select</option> 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2">
                                            <div class="form-group">
                                                <label for="city_id" class="control-label">City</label>
                                                <select name="city_id" id="city" class="form-control">
                                                    <option value="">Select</option> 
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2 mgn20">
                                            <div class="form-group">
                                            <label for="qualifications" class="control-label">Qualifications</label>
                                            <select name="qualifications" class="form-control">
                                            <option value="">Select</option>  
                                            @foreach($education as $education)
                                            <option value="{{ $education->id }}">{{ $education->name }}</option>   
                                            @endforeach
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2 mgn20">
                                            <div class="form-group">
                                            <label for="employer_id" class="control-label">Employer</label>
                                            <select name="employer_id" class="form-control">
                                            <option value="">Select</option> 
                                            @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>   
                                            @endforeach
                                            </select>
                                            </div>
                                        </div>


                                        
                                        <div class="col-sm-3 margintop20">
                                            <div class="form-group mgn20">
                                                {!! Form::hidden('form-search', 1) !!}
                                                {!! Form::submit(lang('common.filter'), array('class' => 'btn btn-primary')) !!}
                                                <a href="{!! route('jobs-list.index') !!}" class="btn btn-success"> {!! lang('common.reset_filter') !!}</a>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>


                        <form action="{{ route('jobs-list.action') }}" method="post">
                            <div class="col-md-3 text-right pull-right padding0 marginbottom10">
                                {!! lang('Show') !!} {!! Form::select('name', ['20' => '20', '40' => '40', '100' => '100', '200' => '200', '300' => '300'], '20', ['id' => 'per-page']) !!} {!! lang('entries') !!}
                            </div>
                            <div class="col-md-3 padding0 marginbottom10">
                                {!! Form::hidden('page', 'search') !!}
                                {!! Form::hidden('_token', csrf_token()) !!}
                               <!--  {!! Form::text('name', null, array('class' => 'form-control live-search', 'placeholder' => 'Search customer by name')) !!} -->
                            </div>

                            <table id="paginate-load" data-route="{{ route('jobs-list.paginate') }}" class="table table-hover">
                            </table>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

