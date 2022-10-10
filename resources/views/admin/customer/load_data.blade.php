<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>Candidate Name</th>
    <th>{!! lang('common.email') !!}</th>    
    <th>{!! lang('common.mobile') !!}</th> 
    <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    <th class="text-center" style="width: 120px;">{!! lang('common.action') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>



@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td><a href="{!! route('job-seekers.edit', [$detail->id]) !!}">{!! $detail->name !!}</a></td>
    <td>{!! $detail->email !!}</td>
    <td>{!! $detail->mobile !!}</td>
    <td class="text-center">
        <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('customer.toggle', $detail->id) !!}" title="@if($detail->status == 0) Deactive @else Active @endif">
            {!! Html::image('images/' . $detail->status . '.gif') !!}
        </a>
    </td>
    <td class="text-center">
        <a class="btn btn-xs btn-primary" href="{{ route('job-seekers.edit', [$detail->id]) }}"><i class="fa fa-eye"></i></a>
        <a class="btn btn-xs btn-primary" href="{{ route('job-seekers.edit-update', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
        <a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{!! route('customer.drop', [$detail->id]) !!}" data-message="{!! lang('messages.sure_delete', string_manip(lang('Job Seekers'))) !!}" href="javascript:void(0)"><i class="fa fa-times"></i> </a>
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