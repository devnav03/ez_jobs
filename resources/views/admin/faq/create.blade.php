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
                <h1 class="page-header">Faq's <a class="btn btn-sm btn-primary pull-right" href="{!! route('faqs.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> Faq's List</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Faq's Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'faqs.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('faqs.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'faqs.edit')
                                    {!! Form::model($result, array('route' => array('faqs.update', $result->id), 'method' => 'PATCH', 'id' => 'faqs-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group"> 
                                            {!! Form::label('title', lang('Title'), array('class' => '')) !!}
                                            {!! Form::text('title', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>   
                                    <div class="col-md-12 mgn20">
                                        <div class="form-group"> 
                                            {!! Form::label('description', lang('Description'), array('class' => '')) !!}
                                            {!! Form::textarea('description', null, array('class' => 'form-control', 'required' => 'true')) !!}
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

<script type="text/javascript">
    
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}    

</script>

<style type="text/css">
textarea{
    resize: none;
}    
</style>

@stop

