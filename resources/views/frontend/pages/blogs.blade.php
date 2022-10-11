@extends('frontend.layouts.app')
@section('content')
@if(isset($sliders))
<section class="banner">
   <div id="main-slide" class="owl-carousel owl-theme">
      @foreach($sliders as $slider)
         <div class="item">
            <a href="{{ $slider->link }}">
            <img src="{!! asset($slider->image) !!}" alt="{{ $slider->title }}" draggable="false"></a>
         </div>
      @endforeach
   </div>
</section>
@endif
<section class="blog-index">
<div class="container">  
<h1>Blogs</h1>
<div class="row"> 
@foreach($blogs as $blog)
<div class="col-md-4">
<div class="blog-box">
<div class="blog-image">
<a href="{{ route('blog_details', $blog->url) }}">	
<img src="{!! asset($blog->image) !!}" alt="">
</a>
</div>
<h3><a href="{{ route('blog_details', $blog->url) }}">{{ $blog->title }}</a></h3>
</div>
</div>
@endforeach
</div>
</div>
</section>

@endsection    



