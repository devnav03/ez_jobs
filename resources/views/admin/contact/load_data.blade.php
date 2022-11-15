<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>Name</th>
    <th>Email</th>
    <th>Mobile No</th>
    <th>Phone Number</th>
    <th>Message</th>
    <th>Date</th>
    <th style="text-align: center;width: 90px;">Action</th>
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
    <td style="text-align: center;"><a title="{!! lang('common.delete') !!}" class="btn btn-xs btn-danger __drop" data-route="{!! route('contact-enquiry.drop', [$detail->id]) !!}" data-message="{!! lang('messages.sure_delete', string_manip(lang('Enquiry'))) !!}" href="javascript:void(0)"><i class="fa fa-times"></i></a>
    
    <a href="#" title="Reply" style="background: #1777e5;color: #fff;padding: 4px 2px;" data-toggle="modal" data-target="#exampleModal{{ $detail->id }}"><i style="width: 22px; font-size: 14px !important;" class="fa fa-reply"></i></a>

    <div class="modal fade" id="exampleModal{{ $detail->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-body">
                  
                                {!! Form::open(array('method' => 'POST', 'route' => array('contact-reply'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" value="{{ $detail->email }}" name="email">
                                        <div class="form-group" style="text-align: left;"> 
                                        {!! Form::label('type', lang('Subject'), array('class' => '')) !!}
                                        <input type="text" name="subject" class="form-control" required="true">
                                        </div> 
                                    </div>   
                                    <div class="col-md-12 mgn20">
                                         <div class="form-group" style="text-align: left;"> 
                                            {!! Form::label('message', lang('Message'), array('class' => '')) !!}
                                            <textarea style="height: 150px;" class="form-control" name="message" required="true"> </textarea>
                                        </div> 
                                    </div>                             
                                    </div>
                                      
                                <div class="row">
                                    <p>&nbsp;</p>
                                    <div class="col-md-12">
                                         <button type="submit" class="btn btn-default w3ls-button">Reply</button> 
                                    </div>
                                </div>
                                    
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
          </div>
        </div>
      </div>
    </div>

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