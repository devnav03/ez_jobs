@extends('frontend.layouts.app')
@section('css')
{!! Html::script('js/nicEdit-latest.js') !!} 
<script type="text/javascript">
bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
</script>
@stop
@section('content')


<section class="job-post-index">
<div class="container"> 
<div class="row"> 
<div class="col-md-10 offset-md-1"> 
<form action="{{ route('update-job') }}" enctype="multipart/form-data" method="POST">
{{ csrf_field() }}
<input type="hidden" value="{{ $job->id }}" name="id">
<div class="profile-box"> 
<h1>Edit <span>Job</span></h1>
<div class="row"> 
<div class="col-md-6"> 
<label>Job Title<span>*</span></label>  
<input type="text" value="{{ $job->title }}" name="title" required="true" class="form-control">
@if($errors->has('title'))
<span class="text-danger">{{$errors->first('title')}}</span>
@endif
</div>

<div class="col-md-6"> 
<label>Job Type<span>*</span></label>  
<select name="job_type" class="form-control" required="true">
  <option value="">Select</option>
  <option value="Full Time" @if($job->job_type == 'Full Time') selected @endif>Full Time</option>
  <option value="Part Time" @if($job->job_type == 'Part Time') selected @endif>Part Time</option>
</select>
@if($errors->has('job_type'))
<span class="text-danger">{{$errors->first('job_type')}}</span>
@endif
</div>

<div class="col-md-6 mgn20">
    <label>Industry<span>*</span></label>   
    <select onChange="getSubcategory(this.value);" name="category_id" class="form-control" required="true">
      <option value="">Select</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}" @if($job->category_id == $category->id) selected @endif> {{ $category->name }}</option>
      @endforeach
    </select>
    @if($errors->has('category_id'))
    <span class="text-danger">{{$errors->first('category_id')}}</span>
    @endif
</div>
<div class="col-md-6 mgn20">
    <label>Functional Area<span>*</span></label>   
    <select name="sub_category" id="category-list" class="form-control" required="true">
      <option value="">Select</option>
      @foreach($sub_categories as $category)
      <option value="{{ $category->id }}" @if($job->sub_category == $category->id) selected @endif> {{ $category->name }}</option>
      @endforeach 
    </select>
    @if($errors->has('sub_category'))
      <span class="text-danger">{{$errors->first('sub_category')}}</span>
    @endif
</div>

<div class="col-md-6 mgn20">
    <label>State<span>*</span></label>   
    <select name="state_id" id="state" onChange="getCity(this.value);" class="form-control" required="true">
      <option value="">Select</option>
      @foreach($states as $state)
      <option value="{{ $state->id }}" @if($job->state_id == $state->id) selected @endif> {{ $state->name }}</option>
      @endforeach
    </select>
    @if($errors->has('state_id'))
    <span class="text-danger">{{$errors->first('state_id')}}</span>
    @endif
</div>
      <div class="col-md-6 mgn20">
        <label>City<span>*</span></label>   
        <select name="city_id" id="city" class="form-control" required="true">
          <option value="">Select</option>
          @foreach($cities as $category)
          <option value="{{ $category->id }}" @if($job->city_id == $category->id) selected @endif> {{ $category->name }}</option>
          @endforeach 
        </select>
        @if($errors->has('city_id'))
        <span class="text-danger">{{$errors->first('city_id')}}</span>
        @endif
      </div>
  <div class="col-md-6 mgn20"> 
    <label>Salary<span>*</span></label>  
    <input type="text" value="{{ $job->salary }}" name="salary" required="true" class="form-control">
    @if($errors->has('salary'))
    <span class="text-danger">{{$errors->first('salary')}}</span>
    @endif
  </div>
  <div class="col-md-6 mgn20">
    <label>Qualifications<span>*</span></label>   
    <select name="qualifications" class="form-control" required="true">
      <option value="">Select</option>
      @foreach($educations as $education)
      <option value="{{ $education->id }}"  @if($job->qualifications == $education->id) selected @endif> {{ $education->name }}</option>
      @endforeach
    </select>
    @if($errors->has('qualifications'))
    <span class="text-danger">{{$errors->first('qualifications')}}</span>
    @endif
  </div>

  <div class="col-md-6 mgn20"> 
    <label>Number of Positions<span>*</span></label>  
    <input type="text" value="{{ $job->number_of_positions }}" name="number_of_positions" required="true" class="form-control">
    @if($errors->has('number_of_positions'))
    <span class="text-danger">{{$errors->first('number_of_positions')}}</span>
    @endif
  </div>

  <div class="col-md-3 mgn20"> 
  <label>Experience From<span>*</span></label>  
  <select name="experience_from" class="form-control" required="true">
    <option value="">Select</option>
    <option value="0" @if($job->experience_from == 0) selected @endif>Fresher</option>
    <option value="0.5" @if($job->experience_from == 0.5) selected @endif>6 Months</option>
    <option value="1" @if($job->experience_from == 1) selected @endif>1 Year</option>
    <option value="2" @if($job->experience_from == 2) selected @endif>2 Years</option>
    <option value="3" @if($job->experience_from == 3) selected @endif>3 Years</option>
    <option value="4" @if($job->experience_from == 4) selected @endif>4 Years</option>
    <option value="5" @if($job->experience_from == 5) selected @endif>5 Years</option>
    <option value="6" @if($job->experience_from == 6) selected @endif>6 Years</option>
    <option value="7" @if($job->experience_from == 7) selected @endif>7 Years</option>
    <option value="8" @if($job->experience_from == 8) selected @endif>8 Years</option>
    <option value="9" @if($job->experience_from == 9) selected @endif>9 Years</option>
    <option value="10" @if($job->experience_from == 10) selected @endif>10 Years</option>
    <option value="11" @if($job->experience_from == 11) selected @endif>11 Years</option>
    <option value="12" @if($job->experience_from == 12) selected @endif>12 Years</option>
    <option value="13" @if($job->experience_from == 13) selected @endif>13 Years</option>
    <option value="14" @if($job->experience_from == 14) selected @endif>14 Years</option>
    <option value="15" @if($job->experience_from == 15) selected @endif>15 Years</option>
  </select>
  @if($errors->has('experience_from'))
  <span class="text-danger">{{$errors->first('experience_from')}}</span>
  @endif
  </div>

  <div class="col-md-3 mgn20"> 
  <label>Experience To</label>  
  <select name="experience_to" class="form-control">
    <option value="">Select</option>
    <option value="0.5" @if($job->experience_to == 0.5) selected @endif>6 Months</option>
    <option value="1" @if($job->experience_to == 1) selected @endif>1 Year</option>
    <option value="2" @if($job->experience_to == 2) selected @endif>2 Years</option>
    <option value="3" @if($job->experience_to == 3) selected @endif>3 Years</option>
    <option value="4" @if($job->experience_to == 4) selected @endif>4 Years</option>
    <option value="5" @if($job->experience_to == 5) selected @endif>5 Years</option>
    <option value="6" @if($job->experience_to == 6) selected @endif>6 Years</option>
    <option value="7" @if($job->experience_to == 7) selected @endif>7 Years</option>
    <option value="8" @if($job->experience_to == 8) selected @endif>8 Years</option>
    <option value="9" @if($job->experience_to == 9) selected @endif>9 Years</option>
    <option value="10" @if($job->experience_to == 10) selected @endif>10 Years</option>
    <option value="11" @if($job->experience_to == 11) selected @endif>11 Years</option>
    <option value="12" @if($job->experience_to == 12) selected @endif>12 Years</option>
    <option value="13" @if($job->experience_to == 13) selected @endif>13 Years</option>
    <option value="14" @if($job->experience_to == 14) selected @endif>14 Years</option>
    <option value="15" @if($job->experience_to == 15) selected @endif>15 Years</option>
    <option value="20" @if($job->experience_to == 20) selected @endif>20 Years</option>
  </select>
  @if($errors->has('experience_from'))
  <span class="text-danger">{{$errors->first('experience_from')}}</span>
  @endif
  </div>
  

  <div class="col-md-12 mgn20"> 
    <label>Job Description<span>*</span></label>  
    <textarea class="form-control" name="job_description">{{ $job->job_description }}</textarea>
    @if($errors->has('job_description'))
    <span class="text-danger">{{$errors->first('job_description')}}</span>
    @endif
  </div>

   <div class="col-md-12 submit_field mgn20">
    <input type="submit" name="submit" value="Update">
  </div>
</div>
</div>
</form>
</div>
</div>
</div>
</section>





@endsection    