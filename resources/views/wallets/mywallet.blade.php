@extends('layouts.wura')
@section('page_heading','My Wallets')
@section('content')

<?php
    $cnt = 0;
?>

    <div class="row" style="margin-bottom:20px;">
        <div class="col-md-12">
            <a href="#" data-toggle="modal" data-target="#newwallet" class="btn btn-wura pull-right" style="margin-top: -45px; margin-right:20px;">Register new Wallet</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            <table id='Tblwallets' class='table table-responsive dtable table-condensed table-striped table-bordered table-hover table-bordered'>
                <thead>
                    <tr>
                        <th nowrap="nowrap"> S / N </th>
                        <th> Name </th>
                        <th> Card Number </th>
                        <th> Card Holder </th>
                        <th> Amount funded </th>
                        <th> Amount Left </th>
                        <!-- <th> Card Status </th> -->
                        <th> Card Expires </th>
                        <th> Actions </th>
                    </tr>
                </thead>

                    @foreach ($wallets as $wallet) 
                        <?php
                            $cnt++;
                        ?>
                        <tr data-href="{{ $wallet->id }}">
                            <td>{{ $cnt }}</td>
                            <td>{{ $wallet->walletname }}</td>
                            <td>
                                <a href="#" id="cardnumber" data-id="{{ $wallet->id }}" data-type="select" data-pk="{{ $wallet->CardNumber }}" data-source="/getfreeCards" 
                                        data-value="{{ $wallet->CardNumber }}" data-title="Select Card" class="cardnumber editable editable-click">{{ $wallet->CardNumber }}</a>
                            </td>
                            <td>{{ $wallet->Fullname }}</td>
                            <td>
                                <a href="#" id="amount" data-id="{{ $wallet->id }}" data-type="text" data-pk="{{ $wallet->id }}" 
                                        data-value="{{ $wallet->amount }}" data-title="Enter desired amount" class="amount editable editable-click">₦{{ $wallet->amount }}</a>
                            </td>
                            <td>₦{{ $wallet->amount }}</td>
                            <!-- <td class="callback" data-status="{{ $wallet->id }}">{{ $wallet->CardStatus }} </td> -->
                            <td>{{ $wallet->CardExpires }} </td>
                            <td>
                                @switch(strtolower($wallet->status))
                                    @case(true)
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $wallet->id }}" data-module="walletstatus"> Suspend </button>
                                        @break

                                    @case(false)
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $wallet->id }}" data-module="walletstatus"> Activate </button>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                       
                    @endforeach
            </table>
        </div>
    </div>

    <div class="modal fade" id="newwallet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="walletForm" name="walletForm" class="form-horizontal" method="POST" action="{{ route('walletstore') }}">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel"> Wallet Registration. </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="margin-bottom:20px;">
                            <label for="walletname" class="col-md-4 control-label" style="text-align:left;"> Wallet Name </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" name="walletname" id="walletname"  placeholder="Enter your Wallet Name" value="{{ old('walletname') }}" tabindex="1" required autofocus />
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px;">
                            <label for="oncard" class="col-md-4 control-label" style="text-align:left;"> Assign to Card </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-money" aria-hidden="true"></i></span>
                                    <select class="form-control" name="oncard" id="oncard" tabindex="2" placeholder="Assign to Card" required autofocus>
                                        @foreach ($Cards as $card)
                                            <option value="{{ $card->value }}">{{ $card->text }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:20px;">
                            <label for="amount" class="col-md-4 control-label" style="text-align:left;"> Amount </label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">₦&nbsp;</span>
                                    <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Default Amount" value="{{ old('oncard') }}" tabindex="3" required autofocus />
                                    <span class="input-group-addon">.00</span>
                                </div>
                            </div>
                        </div>
                                
                        <div class="row" style="margin-bottom:20px;">
                            <label class="col-md-4 control-label" style="text-align:left;" for="status"> Activate Wallet </label>

                            <div class="col-md-8" data-toggle="buttons">
                                <input type="hidden" id="status" name="status" class="form-control required" value="true" />

                                <label class="clickable btn btn-md btn-wura active pull-left" data-val="true" data-parentctrl="status">
                                    <input type="radio" />
                                    <i class="fa fa-thumbs-o-up"> &nbsp; YES</i>
                                </label>

                                <label class="clickable btn btn-md btn-wura active pull-right" data-val="false" data-parentctrl="status">
                                    <input type="radio" />
                                    <i class="fa fa-thumbs-o-down"> &nbsp; NO</i>
                                </label>
                            </div>
                        </div>                          
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary submitForm" data-parentform="walletForm" data-dismiss="modal">
                            <i class="fa fa-save fa-5w">&nbsp;&nbsp;</i>
                            Register Wallet.
                        </button>
                    </div>
                </div>
            <form>
        </div>
    </div>

@endsection