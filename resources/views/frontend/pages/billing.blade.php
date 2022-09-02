@extends('frontend.layouts.app')
@section('content')


<section class="billing-index">
<div class="container">  
<div class="billing-box"> 
<h1>All Transactions</h1>
<table>
<tr style="border: 2px solid #000;">
  <th style="text-align: center;">Sr. No</th>
  <th>Plan Name</th>
  <th>Plan For</th>
  <th>Price</th>
  <th>Payment ID</th>
  <th>Date</th>
</tr>
@php
$i = 0;
@endphp   
  @foreach($billings as $billing)
@php
$i++;
@endphp     
<tr>
  <td style="text-align: center;">{{ $i }}</td>
  <td>{{ $billing->plan }}</td>
  @if($billing->category == 1)
  <td>Job Post</td>
  @else
  <td>Profile View</td>
  @endif
  <td>@if($billing->category == 1) {{ $billing->price*$billing->quantity }} @else {{ $billing->price }} @endif </td>
  <td>{{ $billing->transaction_id }}</td>
  <td>{{ date('d M, Y', strtotime($billing->created_at)) }}</td>
</tr>

  @endforeach 
</table>
</div>
</div>

</section>















@endsection    



