@extends('admin.layouts.master')
@section('css')

{!! Html::script('js/nicEdit-latest.js') !!}

<script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//]]>

</script>

@stop
@section('content')
@include('admin.layouts.messages')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Blog <a class="btn btn-sm btn-primary pull-right" href="{!! route('blogs.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All Blogs</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Blog Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'blogs.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('blogs.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'blogs.edit')
                                    {!! Form::model($result, array('route' => array('blogs.update', $result->id), 'method' => 'PATCH', 'id' => 'blogs-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-12">
                                         <div class="form-group"> 
                                            {!! Form::label('title', lang('Title'), array('class' => '')) !!}
                                            {!! Form::text('title', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if ($errors->has('title'))
                                            <span class="text-danger">{{$errors->first('title')}}</span>
                                            @endif
                                        </div> 
                                    </div>

                                    <div class="col-md-12 mgn20">
                                        <div class="form-group"> 
                                        <label for="content" class="">Content</label>
                                        {!! Form::textarea('content', null, array('class' => 'form-control')) !!}
                                        @if ($errors->has('content'))
                                        <span class="text-danger">{{$errors->first('content')}}</span>
                                        @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mgn20">
                                        <div class="form-group"> 
                                            <label>Banner<span>*</span></label> 
                                            @if(!empty($result->image))
                                            <input name="image" type='file' accept="image/png, image/jpeg" id="imgInp" />
                                            @else
                                            <input name="image" type='file' accept="image/png, image/jpeg" required="true" id="imgInp" />

                                            @endif
                                            @if ($errors->has('image'))
                                             <span class="text-danger">{{$errors->first('image')}}</span>
                                            @endif
                                            <img id="blah" src="#" style="max-width: 360px;margin-top: 10px;" alt="" />
                                        </div>
                                        @if(!empty($result->image))
                                            <div class="form-group"> 
                                                 {!! HTML::image(asset($result->image),'' ,array('width' => 360 ,'class'=>'img-responsive') ) !!}
                                            </div>
                                        @endif
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

<script type="text/javascript">
    
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}    

</script>

@stop

