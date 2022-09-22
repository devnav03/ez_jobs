@extends('frontend.layouts.app')
@section('content')

<section class="blog-details-index">
<div class="container"> 
<div class="row"> 
<div class="col-md-1"></div>	
<div class="col-md-10"> 	
<h2>{{ $blog->title }}</h2>	
<img src="{!! asset($blog->image) !!}" alt="">
<div class="content">

{!! $blog->content !!}

</div>
</div>
</div>
</div>
</section>















@endsection 