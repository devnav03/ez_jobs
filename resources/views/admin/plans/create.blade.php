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
                <h1 class="page-header">Plan <a class="btn btn-sm btn-primary pull-right" href="{!! route('plans.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All Plans</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Plan Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'plans.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('plans.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'plans.edit')
                                    {!! Form::model($result, array('route' => array('plans.update', $result->id), 'method' => 'PATCH', 'id' => 'plans-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('name', lang('common.name'), array('class' => '')) !!}
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div> 

                                    <div class="col-md-6">
                                        <div class="form-group"> 
                                        {!! Form::label('name', lang('Plan For'), array('class' => '')) !!}
                                            <select class="form-control" onChange="CategoryChange(this);" name="category" id="category" required="true">
                                            <option value="">Select</option>
                                            <option value="1" @if(isset($result)) @if($result->category == 1) selected @endif @endif>Job Post</option>
                                            <option value="2" @if(isset($result)) @if($result->category == 2) selected @endif @endif>Profile View</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('price', lang('Price'), array('class' => '')) !!}
                                            {!! Form::number('price', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div> 
                                    <div class="col-md-6 mgn20 profile_view" @if(isset($result)) @if($result->category == 1) style="display: none;" @endif  @else  style="display: none;" @endif>
                                         <div class="form-group"> 
                                            {!! Form::label('profile_view', lang('No of Profile View'), array('class' => '')) !!}
                                            {!! Form::number('profile_view', null, array('class' => 'form-control')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('description', lang('Description'), array('class' => '')) !!}
                                            {!! Form::text('description', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20 profile_view" @if(isset($result)) @if($result->category == 1) style="display: none;" @endif  @else  style="display: none;" @endif>
                                         <div class="form-group"> 
                                            {!! Form::label('duration', lang('Duration (In Days)'), array('class' => '')) !!}
                                            {!! Form::number('duration', null, array('class' => 'form-control')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-12 job_post" @if(isset($result)) @if($result->category == 2) style="display: none;" @endif  @else  style="display: none;" @endif>
                                        <ul>
                                            <li>
                                            <input type="radio" name="job_description"  @if(isset($result)) @if($result->job_description == 1) checked="" @endif @else checked="" @endif  value="1"> 
                                            <label>Detailed Job Description</label>
                                            </li>
                                            <li>
                                            <input type="radio" name="job_description" value="0" @if(isset($result)) @if($result->job_description == 0) checked="" @endif @endif> 
                                            <label>250 Characters in Job Description</label>
                                            </li>

                                            <li class="w-100">
                                            <input type="checkbox" name="job_search" value="1" @if(isset($result)) @if($result->job_search == 1) checked="true" @endif @endif> 
                                            <label>Boost on Job Search Page</label>
                                            </li>
                                            <li class="w-100">
                                            <input type="checkbox" name="job_branding" value="1" @if(isset($result)) @if($result->job_branding == 1) checked="true" @endif @endif> 
                                            <label>Job Branding</label>
                                            </li>

                                            <li>
                                            <input type="radio" name="city" checked="" value="1" @if(isset($result)) @if($result->city == 1) checked="" @endif @else checked="" @endif> 
                                            <label>All Cities</label>
                                            </li>
                                            <li>
                                            <input type="radio" name="city" value="0" @if(isset($result)) @if($result->city == 0) checked="" @endif @endif> 
                                            <label>Non-Metro Cities</label>
                                            </li>
                                        </ul>     
                                    </div>



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
.job_post ul{
    list-style: none;
    padding-top: 20px;
}    

.job_post ul li {
    padding-bottom: 20px;
    font-size: 14px;
    float: left;
    width: 28%;
}
.w-100{
    width: 100% !important;
}
.job_post ul li input[type="radio"] {
    float: left;
    margin-right: 7px;
    margin-top: 3px;
    width: 15px;
    height: 15px;
}
.job_post ul li input[type="checkbox"] {
    width: 14px;
    height: 14px;
    margin-right: 6px;
    margin-top: 2px;
    float: left;
}



</style>

<script type="text/javascript">
    
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}   

function CategoryChange(that) {
    if (that.value == "1") {
        $(".job_post").show();
        $(".profile_view").hide();
    } else {
        $(".profile_view").show();
        $(".job_post").hide();
    }
   
} 

</script>

@stop

