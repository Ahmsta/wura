@extends('layouts.wura')
@section('page_heading','My Cards')
@section('content')

<?php
    $cnt = 0;
?>

    <div class="row">

        <div class="col-md-12">
           
            <table id='TblCards' class='table table-responsive dtable table-condensed table-striped table-bordered table-hover table-bordered'>
                <thead>
                    <tr>
                        <th> S / N </th>
                        <th> Card Number </th>
                        <th> AssignedTo </th>
                        <th> Requested On </th>
                        <th> Valid Until </th>
                        <th> Status </th>
                        <th> Actions </th>
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach ($cards as $card) 
                        <?php
                            $cnt++;
                        ?>
                        <tr data-href="{{ $card->id }}">
                            <td>{{ $cnt }}</td>
                            <td>{{ $card->cardnos }}</td>
                            <td>
                                @switch(strtolower($card->status))
                                    @case('suspend')
                                    @case('activate')
                                        <a href="#" id="assignedto" data-id="{{ $card->id }}" data-type="select" data-pk="{{ $card->assignedto }}" data-source="/getdrivers" 
                                        data-value="{{ $card->assignedto }}" data-title="Select Driver" class="assignedto editable editable-click">{{ $card->Fullname }}</a>
                                        @break

                                    @default
                                        {{ $card->Fullname }}
                                @endswitch
                            </td>
                            <td>{{ $card->created_at }} </td>
                            <td>{{ $card->valid_until }} </td>
                            <td class="callback" data-status="{{ $card->id }}">{{ $card->status }} </td>
                            <td>
                                @switch(strtolower($card->status))
                                    @case('processing request')
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $card->id }}" data-module="cards"> Cancel </button>
                                        @break

                                    @case('activate')
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $card->id }}" data-module="cards"> Suspend </button>
                                        @break

                                    @default
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $card->id }}" data-module="cards"> Activate </button>
                                @endswitch
                            </td>
                        </tr>
                       
                    @endforeach
                    
                </tbody>
            </table>

        </div>

    </div>

@endsection