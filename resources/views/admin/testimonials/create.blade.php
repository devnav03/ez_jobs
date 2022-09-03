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
                <h1 class="page-header">Testimonial <a class="btn btn-sm btn-primary pull-right" href="{!! route('testimonials.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All Testimonials</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Testimonial Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'testimonials.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('testimonials.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'testimonials.edit')
                                    {!! Form::model($result, array('route' => array('testimonials.update', $result->id), 'method' => 'PATCH', 'id' => 'testimonials-form', 'class' => '', 'files'=>'true')) !!}
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
                                            {!! Form::label('designation', lang('Designation'), array('class' => '')) !!}
                                            {!! Form::text('designation', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('designation'))
                                             <span class="text-danger">{{$errors->first('designation')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <div class="form-group"> 
                                            <label for="category">Category</label>
                                            <select class="form-control" name="category" required="true">
                                                <option value="">Select</option>
                                                <option value="1" @if(isset($result)) @if($result->category == 1) selected @endif @endif>Employer</option>
                                                <option value="2" @if(isset($result)) @if($result->category == 2) selected @endif @endif>Job Seeker</option>
                                            </select>
                                            @if($errors->has('category'))
                                             <span class="text-danger">{{$errors->first('category')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <div class="form-group"> 
                                            {!! Form::label('rating', lang('Rating'), array('class' => '')) !!}
                                            <select class="form-control" name="rating" required="true">
                                                <option value="">Select</option>
                                                <option value="1" @if(isset($result)) @if($result->rating == 1) selected @endif @endif>1</option>
                                                <option value="2" @if(isset($result)) @if($result->rating == 2) selected @endif @endif>2</option>
                                                <option value="3" @if(isset($result)) @if($result->rating == 3) selected @endif @endif>3</option>
                                                <option value="4" @if(isset($result)) @if($result->rating == 4) selected @endif @endif>4</option>
                                                <option value="5" @if(isset($result)) @if($result->rating == 5) selected @endif @endif>5</option>
                                            </select>
                                            @if($errors->has('rating'))
                                             <span class="text-danger">{{$errors->first('rating')}}</span>
                                            @endif
                                        </div> 
                                    </div> 

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('comment', lang('Comment'), array('class' => '')) !!}
                                            {!! Form::textarea('comment', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>
                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('image', lang('Image'), array('class' => '')) !!}
                                            <input name="image" type='file' accept="image/png, image/jpeg" id="imgInp" />
                                            @if(isset($result))
                                            <img id="blah" src="{{ $result->image }}" style="max-width: 100px;margin-top: 10px;" alt="" />
                                            @else
                                            <img id="blah" src="#" style="max-width: 100px;margin-top: 10px;" alt="" />
                                            @endif
                                        </div> 
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
textarea {
    resize: none;
    height: 125px !important;
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

