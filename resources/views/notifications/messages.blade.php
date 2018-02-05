@extends('layouts.wura')
@section('page_heading','Message Logs.')
@section('content')

<?php
    $cnt = 0;
?>

<div class="row">

    <div class="col-md-12">
        <div class="table-responsive">
            <table id='TblRecords' class='table dtable table-hover table-condensed table-bordered'>
                <thead>
                    <tr>
                        <th> S / N </th>
                        <th> Message Type </th>
                        <th> Subject </th>
                        <th> Recipient </th>
                        <th> Sent On </th>
                        <th> Action </th>
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach ($notifications as $notification)
                        <?php
                            $cnt++;
                        ?>
                        <tr data-href="{{ $notification->id }}">
                            <td> {{ $cnt }} </td>
                            <td> {{ ucwords($notification->type) }} </td>
                            <td> {{ $notification->subject }} </td>
                            <td> {{ $notification->recipient }} </td>
                            <td> {{ Carbon\Carbon::parse($notification->read_at)->toFormattedDateString() }} </td>
                            <td> 
                                <a href="#" data-toggle="modal" data-target="#messageview" class="btn btn-default msgbutton" data-id="{{ $notification->id }}"
                                    style="color: black;border-color: grey;">
                                    <i class="fa fa-eye" aria-hidden="true"></i> 
                                    View Message 
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="messageview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="max-height: 450px; height: 450px; overflow:scroll;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-wura" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection