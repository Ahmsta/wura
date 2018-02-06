@extends('layouts.wura')
@section('page_heading', "Card's Report")

@section('content')
<div class="row" style="margin-top:20px;">
        @foreach ($cards as $card)
            <?php
                $driver = \App\Models\Drivers::find($card->assignedto);
                if ($driver == null) {
                    $driver = new \App\Models\Drivers();
                    $driver->id = 0;
                    $imgPath = 'https://s3-eu-west-1.amazonaws.com/wurafleet/blank.jpg';
                    $driver->fullname = "Not assigned to any driver";
                } else {
                    $driver->fullname = $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname;
                }
            ?>
                     
            <div class="col-md-6 col-lg-6 col-xlg-4">
                <div class="card card-block">
                    <div class="row">
                        <div class="col-md-4 col-lg-3 text-center">
                            <a href="driverdetails?id={{ $driver->id }}" style="color:#01c0c8;">
                                <img src="{{ $driver->passportpath }}" title="{{ $driver->fullname }}'s Picture" alt="{{ $driver->fullname }}'s Picture" class="img-responsive img-circle img-thumbnail" style="width:91px; height:91px;" />
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-9" style="text-align:left; color: black; line-height:30px;">
                            <div class="sl-item">
                                <div class="sl-left">
                                <a href="transactions?cardid={{ $card->id }}" style="text-decoration;none; border-bottom: 2px dotted #01c0c8;">
                                    <strong>
                                        <i class="fa fa-credit-card" aria-hidden="true"> &nbsp; {{ $card->cardnos }} </i>
                                    </strong>
                                </a>    
                                </div>
                                <div class="sl-right">
                                    <div style="text-align:left;">
                                        <p class="m-t-10">
                                            @switch(strtolower($card->status))
                                                @case('processing request')
                                                    <?php $textcolor = "black" ?>
                                                    @break

                                                @case('activate')
                                                    <?php $textcolor = "blue" ?>
                                                    @break

                                                @default
                                                    <?php $textcolor = "red" ?>
                                            @endswitch

                                            <strong style="color:{{$textcolor}}">
                                                Status: {{ str_replace( 'dd', 'd', str_replace('e', 'ed', $card->status)) . "." }}
                                            </strong>
                                            <br />

                                            <span class="sl-date">
                                                Requested On: {{ Carbon\Carbon::parse($card->created_at)->toFormattedDateString() }}
                                            </span>
                                            <br />
                                            
                                            <span class="sl-date">
                                                Card Expires On: {{ Carbon\Carbon::parse($card->valid_until)->toFormattedDateString() }}
                                            </span>
                                            <br />
                                            
                                            Assigned To: <a href="#" id="assignedto" data-id="{{ $card->id }}" data-type="select" data-pk="{{ $card->assignedto }}" data-source="/getdrivers" 
                                            data-value="{{ $card->assignedto }}" data-title="Select Driver" class="assignedto editable editable-click" style="color:#01c0c8;">{{ $card->Fullname }}</a>
                                            <br /><br />

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
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection