<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>Title</th>
    <th>Industry</th>    
    <th>Functional Area</th> 
    <th>Salary</th> 
    <th>Qualifications</th> 
    <th>Employer</th> 
    

    <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    <th class="text-center">{!! lang('common.action') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>



@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td>{!! $detail->title !!}</td>
    <td>{!! $detail->cat !!}</td>
    <td>{!! $detail->sub_cat !!}</td>
    <td>{!! $detail->salary !!}</td>
    <td>{!! $detail->education !!}</td>
    <td>{!! $detail->employer_name !!}</td> 


    <td class="text-center">{!! Html::image('images/' . $detail->status . '.gif') !!}</td>
    <td class="text-center col-md-1">
        <a class="btn btn-xs btn-primary" href="{{ route('jobs-list.edit', [$detail->id]) }}"><i class="fa fa-eye"></i></a>
        
        
    </td>    
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