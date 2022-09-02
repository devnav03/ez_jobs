@extends('admin.layouts.master')
@section('content')
@include('admin.layouts.messages')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-9">
                <h1 class="page-header">Construction Site <a class="btn btn-sm btn-primary pull-right" href="{!! route('company-master.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All Construction Site</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>Construction Site Information</h4>                        
                            </div>
                            <div class="form-body">
                                @if($route == 'company-master.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('company-master.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'company-master.edit')
                                    {!! Form::model($result, array('route' => array('company-master.update', $result->id), 'method' => 'PATCH', 'id' => 'company-master-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-12">
                                         <div class="form-group"> 
                                            {!! Form::label('name', 'Site Name', array('class' => '')) !!}
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-6" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            {!! Form::label('shift_start_time', 'Shift Start Time', array('class' => '')) !!}
                                            {!! Form::time('shift_start_time', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-6" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            {!! Form::label('shift_end_time', 'Shift End Time', array('class' => '')) !!}
                                            {!! Form::time('shift_end_time', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-6" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            {!! Form::label('latitude', 'Latitude', array('class' => '')) !!}
                                            {!! Form::text('latitude', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>

                                    <div class="col-md-6" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            {!! Form::label('longitude', 'Longitude', array('class' => '')) !!}
                                            {!! Form::text('longitude', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                        </div> 
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px;">
                                    <div id="googleMap" style="width:100%;height:400px;"></div>

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
#map {
  width: 100%;
  height: 500px;
  border: 1px solid #000;
}
</style>


<script>
function myMap() {
var mapProp= {
    center:new google.maps.LatLng(51.508742,-0.120850),
    zoom:5,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

google.maps.event.addListener(map, 'click', function(event) {
     $("#latitude").val(event.latLng.lat);
     $("#longitude").val(event.latLng.lng);
     
     
     
//alert(event.latLng.lat() + ", " + event.latLng.lng());
});

}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrI6D4RwGPR7a6iCCzZu3z8DnzP8tYcpo&callback=myMap"></script>

@stop

