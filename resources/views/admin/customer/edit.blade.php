@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.messages')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Job Seekers <a class="btn btn-sm btn-primary pull-right" href="{!! route('job-seekers.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All Job Seekers</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Job Seekers Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'job-seekers.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('job-seekers.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'job-seekers.edit-update')
                                    {!! Form::model($result, array('route' => array('job-seekers.update', $result->id), 'method' => 'PATCH', 'id' => 'job-seekers-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('name', lang('common.name'), array('class' => '')) !!}
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('name'))
                                             <span class="text-danger">{{$errors->first('name')}}</span>
                                            @endif
                                        </div> 
                                    </div> 

                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('email', lang('Email'), array('class' => '')) !!}
                                            {!! Form::email('email', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('email'))
                                             <span class="text-danger">{{$errors->first('email')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('mobile', lang('Mobile'), array('class' => '')) !!}
                                            {!! Form::number('mobile', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('mobile'))
                                             <span class="text-danger">{{$errors->first('mobile')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <div class="form-group"> 
                                            <label for="category">Gender</label>
                                            <select class="form-control" name="category" required="true">
                                                <option value="">Select</option>
                                                <option value="Male" @if(isset($result)) @if($result->gender == 'Male') selected @endif @endif>Male</option>
                                                <option value="Female" @if(isset($result)) @if($result->gender == 'Female') selected @endif @endif>Female</option>
                                                <option value="Other" @if(isset($result)) @if($result->gender == 'Other') selected @endif @endif>Other</option>
                                            </select>
                                            @if($errors->has('category'))
                                             <span class="text-danger">{{$errors->first('category')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <div class="form-group">
                                        <label for="date_of_birth">DOB</label>    
                                        @if(isset($result))    
                                        <input type="text" onfocus="(this.type='date')" max="2004-08-01" value="{{ date('d M, Y', strtotime($result->date_of_birth)) }}" name="date_of_birth" required="true" class="form-control">
                                        @else
                                        {!! Form::date('date_of_birth', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        @endif
                                        @if($errors->has('mobile'))
                                            <span class="text-danger">{{$errors->first('mobile')}}</span>
                                        @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <div class="form-group">
                                            <label for="country">Country</label>  
                                            <select onChange="getState(this.value);" name="country" class="form-control" required="true">
                                              <option value="">Select</option>  
                                              @foreach($countries as $country)
                                              <option value="{{ $country->id }}" @if(@$result->country == $country->id) selected @endif> {{ $country->country_name }}</option>
                                              @endforeach
                                            </select>
                                            @if($errors->has('country'))
                                            <span class="text-danger">{{$errors->first('country')}}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <label>State</label>   
                                        <select name="state" id="state" onChange="getCity(this.value);" class="form-control" required="true">
                                            <option value="">Select</option>
                                          @foreach($states as $state)
                                          <option value="{{ $state->id }}" @if(@$result->state == $state->id) selected @endif> {{ $state->name }}</option>
                                          @endforeach
                                        </select>
                                        @if($errors->has('state'))
                                        <span class="text-danger">{{$errors->first('state')}}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <label>City</label>   
                                        <select name="city" id="city" class="form-control" required="true">
                                            <option value="">Select</option>
                                          @foreach($city as $city)
                                          <option value="{{ $city->id }}" @if(@$result->city == $city->id) selected @endif> {{ $city->name }}</option>
                                          @endforeach
                                        </select>
                                        @if($errors->has('city'))
                                        <span class="text-danger">{{$errors->first('city')}}</span>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('address', lang('Address'), array('class' => '')) !!}
                                            {!! Form::text('address', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('address'))
                                             <span class="text-danger">{{$errors->first('address')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    @if($route == 'job-seekers.create')

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('password', lang('Password'), array('class' => '')) !!}
                                            {!! Form::password('password', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('password'))
                                             <span class="text-danger">{{$errors->first('password')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    @endif




                                    </div>
                                    
                                <div class="row">
                                    <p>&nbsp;</p>
                                    <div class="col-md-12">
                                         <button type="submit" class="btn btn-default w3ls-button">Submit</button> 
                                    </div>
                                </div>
                                    
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
textarea {
    resize: none;
    height: 125px !important;
}
#password {
    height: 40px;
    border-radius: 0px;
}   

</style>

<script type="text/javascript">
    
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}   

</script>

@stop

