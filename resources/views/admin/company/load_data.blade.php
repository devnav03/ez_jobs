<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>Site {!! lang('common.name') !!}</th>
    <th>Shift</th>
    <th width="6%" class="text-center">Status</th>
    <th class="text-center">{!! lang('common.action') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center" style="vertical-align: middle;">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td>{!! $detail->name !!}</td>
    <td>{!! $detail->shift_start_time !!} To {!! $detail->shift_end_time !!}</td>
    <td class="text-center">
        <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('company-master.toggle', $detail->id) !!}" title="@if($detail->status == 0) Deactive @else Active @endif">
            {!! Html::image('images/' . $detail->status . '.gif') !!}
        </a>
    </td>
    <td style="vertical-align: middle;" class="text-center col-md-1">
        <a class="btn btn-xs btn-primary" href="{{ route('company-master.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
        <a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{!! route('company-master.drop', [$detail->id]) !!}" data-message="{!! lang('messages.sure_delete', string_manip(lang('Construction Site'))) !!}" href="javascript:void(0)">
                <i class="fa fa-times"></i>
            </a>
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