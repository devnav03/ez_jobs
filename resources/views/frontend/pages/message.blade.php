@extends('frontend.layouts.app')
@section('content')


<section class="chat-index">
<div class="container">  
<div class="row">
<div class="col-md-3"> </div>
<div class="col-md-6"> 
<div class="chat-box">
<div class="chat-header">
<h5>Message</h5>
</div>
<div class="chat">
<ul style="padding: 0px; margin-bottom: 0px; list-style: none;">
@foreach($messages as $message)
@php
if($user_type == 2){
	$user = user_message_info($message->from_id);
	$mes = user_message($message->from_id);
	$id = $message->from_id;
} else {
	$user = user_message_info($message->user_id);
	$mes = emp_message($message->user_id);
	$id = $message->user_id;
}
@endphp

<li @if($mes->seen == 1) class="white_back" @endif style="padding: 15px; border-bottom: 1px solid;">
<a href="{{ route('chat', $id) }}">	
<h6 style="color: #000;"> {{ $user->name }}</h6>
<p style="color: #555;"> {{ $mes->message }}</p>
</a>
</li>
@endforeach
</ul>
</div>

</div>
</div>
</div>
</div>
</section>


@endsection    



