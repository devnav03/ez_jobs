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
                <h1 class="page-header">{!! lang('category.category') !!} <a class="btn btn-sm btn-primary pull-right" href="{!! route('category.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All {!! lang('category.categories') !!}</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>{!! lang('category.category_info') !!}</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'category.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('category.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'category.edit')
                                    {!! Form::model($result, array('route' => array('category.update', $result->id), 'method' => 'PATCH', 'id' => 'category-form', 'class' => '', 'files'=>'true')) !!}
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
                                    {!! Form::label('parent_id', lang('category.parent_category'), array('class' => '')) !!}
                                    <select class="select2 form-control1" id="parent_id" name="parent_id">

                                        <option value="" selected="selected">-Select Category-</option>
                                        @foreach($parent_cats as $parent_cat)
                                        <option value="{{ $parent_cat->id }}" @if(isset($result)) @if($result->parent_id == $parent_cat->id) selected @endif  @endif >{{ $parent_cat->name }}</option>

                                       <!--  @foreach(get_setp1_cat($parent_cat->id) as $val_cat)
                                         <option value="{{ $val_cat->id }}" @if(isset($result)) @if($result->parent_id == $val_cat->id) selected @endif  @endif style="font-size: 15px;">&nbsp;&nbsp; {{ $val_cat->name }}</option>

                                        @foreach(get_setp1_cat($val_cat->id) as $val_cat2)
                                         <option value="{{ $val_cat2->id }}" @if(isset($result)) @if($result->parent_id == $val_cat2->id) selected @endif @endif style="font-size: 16px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $val_cat2->name }}</option>
                                         
                                        @foreach(get_setp1_cat($val_cat2->id) as $val_cat3)
                                         <option value="{{ $val_cat3->id }}" @if(isset($result)) @if($result->parent_id == $val_cat3->id) selected @endif  @endif style="font-size: 14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $val_cat3->name }}</option>
                                        
                                        @foreach(get_setp1_cat($val_cat3->id) as $val_cat4)
                                         <option value="{{ $val_cat4->id }}" @if(isset($result)) @if($result->parent_id == $val_cat4->id) selected @endif  @endif style="font-size: 13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $val_cat4->name }}</option>

                                        @foreach(get_setp1_cat($val_cat4->id) as $val_cat5)
                                         <option value="{{ $val_cat5->id }}" @if(isset($result)) @if($result->parent_id == $val_cat5->id) selected @endif  @endif style="font-size: 12px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $val_cat5->name }}</option>
                                         
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                        @endforeach
                                        @endforeach -->
                                        @endforeach
                                    </select>
                                    </div>
                                    </div>

                      <!--               <div class="col-md-6 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('icon', lang('Icon'), array('class' => '')) !!}
                                            {!! Form::text('icon', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div> -->

                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                            {!! Form::label('icon', lang('Icon'), array('class' => '')) !!}
                                            @if(!empty($result->icon))
                                            <input name="icon" type='file' accept="image/png, image/jpeg" id="imgInp" />
                                            @else
                                            <input name="icon" type='file' accept="image/png, image/jpeg" required="true" id="imgInp" />
                                            @endif
                                            <img id="blah" style="max-width: 55%;margin-top:10px;" src="#" alt="" />
                                        </div>
                                        @if(!empty($result->icon))
                                            <div class="form-group"> 
                                                 {!! Html::image(asset($result->icon),'' ,array('width' => 80 ,'class'=>'img-responsive') ) !!}
           
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

