<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile No</th>
    <th>Phone Number</th>
    <th>Message</th>
    <th>Date</th>
    <th style="text-align: center;">Action</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@foreach($data as $detail)
<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td>{!! $detail->name !!}</td>
    <td>{!! $detail->email !!}</td>
    <td>{!! $detail->mobile !!}</td>
    <td>{!! $detail->phone_number !!}</td> 
    <td>{!! $detail->message !!}</td> 
    <td>{!! date('d M, Y', strtotime($detail->created_at)) !!}</td>  
    <td style="text-align: center;"><a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{!! route('contact-enquiry.drop', [$detail->id]) !!}" data-message="{!! lang('messages.sure_delete', string_manip(lang('Enquiry'))) !!}" href="javascript:void(0)">
                <i class="fa fa-times"></i>
            </a></td> 
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