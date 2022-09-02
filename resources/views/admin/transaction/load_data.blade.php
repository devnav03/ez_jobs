<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>Employer</th> 
    <th>Plan name</th>   
    <th>Category</th>  
    <th>Transaction ID</th> 
    <th>Price</th> 
    <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    <th>Date</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>



@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td>{!! $detail->employer_name !!}</td>
    <td>{!! $detail->plan !!}</td>
    <td> @if($detail->category == 1) Job Post @else Profile View @endif</td>
    <td>{!! $detail->transaction_id !!}</td>
    <td> @if($detail->category == 1) {!! $detail->price*$detail->quantity !!}  @else {!! $detail->price !!} @endif </td>
    <td class="text-center">{!! Html::image('images/' . $detail->status . '.gif') !!}</td> 
    <td>{!! date('d M, Y', strtotime($detail->created_at)) !!}</td>      
</tr>
@endforeach
@if (count($data) < 1)
<tr>
    <td class="text-center" colspan="8"> {!! lang('messages.no_data_found') !!} </td>
</tr>
@else
<tr>
    <td colspan="10">
        {!! paginationControls($page, $total, $perPage) !!}
    </td>
</tr>
@endif
</tbody>