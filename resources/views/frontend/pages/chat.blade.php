@extends('frontend.layouts.app')
@section('content')


<section class="chat-index">
<div class="container">  
<div class="row">
<div class="col-md-3"> </div>
<div class="col-md-6"> 
<div class="chat-box">
<div class="chat-header">
<h5>{{ $user->name }}</h5>
<a href="{{ route('message') }}">Back</a>
</div>

<div class="chat">

@foreach($messages as $message)
<p  class=" @if($message->sent == $user_id) right_chat @else left_chat @endif ">  {{ $message->message }}</p>
<div style="width: 100%; float: left; height: 1px"></div>
@endforeach

</div>

<form method="post" action="{{ route('chat-send') }}">
  {{ csrf_field() }} 
<input type="text" name="message" placeholder="Type Message..." required="true">
<button type="submit">Send</button>
<input type="hidden" name="id" value="{{ $user->id }}">
</form>

</div>
</div>
</div>
</div>
</section>


@endsection    



