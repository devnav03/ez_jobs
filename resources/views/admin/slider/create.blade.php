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
                <h1 class="page-header">Banner Carousels <a class="btn btn-sm btn-primary pull-right" href="{!! route('slider.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All Banner Carousels</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Banner Carousels Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'slider.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('slider.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'slider.edit')
                                    {!! Form::model($result, array('route' => array('slider.update', $result->id), 'method' => 'PATCH', 'id' => 'slider-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                          
                                    
                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('title', lang('Title'), array('class' => '')) !!}
                                            {!! Form::text('title', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('title'))
                                             <span class="text-danger">{{$errors->first('title')}}</span>
                                            @endif
                                        </div> 
                                    </div> 

                                    <div class="col-md-6">
                                         <div class="form-group"> 
                                            {!! Form::label('link', lang('Link'), array('class' => '')) !!}
                                            {!! Form::url('link', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('link'))
                                             <span class="text-danger">{{$errors->first('link')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('page', lang('Page'), array('class' => '')) !!}

                                            <select class="form-control" name="page" required="true">
                                                <option value="">Select</option>
                                                <option value="home" @if(isset($result)) @if($result->page == 'home') selected @endif @endif>Home</option>
                                                <option value="find_job" @if(isset($result)) @if($result->page == 'find_job') selected @endif @endif>Find Job</option>
                                                <option value="candidates" @if(isset($result)) @if($result->page == 'candidates') selected @endif @endif>Candidates</option>
                                                <option value="companies" @if(isset($result)) @if($result->page == 'companies') selected @endif @endif>Companies</option>
                                                <option value="blog" @if(isset($result)) @if($result->page == 'blog') selected @endif @endif>Blogs</option>
                                            </select>

                                            @if($errors->has('page'))
                                             <span class="text-danger">{{$errors->first('page')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('image', lang('Image (1600*500)'), array('class' => '')) !!}
                                            <input name="image" type='file' accept="image/png, image/jpeg" id="imgInp" />
                                            @if(isset($result))
                                            <img id="blah" src="{{ $result->image }}" style="max-width: 200px;margin-top: 10px;" alt="" />
                                            @else
                                            <img id="blah" src="#" style="max-width: 200px;margin-top: 10px;" alt="" />
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

