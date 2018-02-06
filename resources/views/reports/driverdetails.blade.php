@extends('layouts.wura')
@section('page_heading', "$driver->firstname  $driver->middlename $driver->lastname's Info.")

@section('content')

    <?php
        $textcolor = "black"; 
    ?>

    <div class="row" style="margin-top:20px;">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card"> 
                <img class="card-img" src="../images/socialbg.jpg" alt="Card image" />
                <div class="card-img-overlay card-inverse social-profile d-flex ">
                    <div class="align-self-center"> 
                        <img src="{{ $driver->passportpath }}" alt="{{ $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname }}'s Picture" class="img-responsive img-circle img-thumbnail" style="width:100px; height:100px;"  />
                        <h4 class="card-title">{{ $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname }}</h4>
                        <h6 class="card-subtitle">Driver</h6>
                        <p class="text-white">
                            Date of Birth: {{ Carbon\Carbon::parse($driver->dateofbirth)->toFormattedDateString() }}
                            <br />
                            Registered on: {{ Carbon\Carbon::parse($driver->created_at)->toFormattedDateString() }}
                            <br />
                            Profile Last Updated on: {{ Carbon\Carbon::parse($driver->updated_at)->toFormattedDateString() }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-block"> 
                    <small class="text-muted">Email address </small>
                    <h6>{{ $driver->email }} </h6> 
                    <small class="text-muted p-t-30 db">Phone</small>
                    <h6>{{ $driver->mobilenumber }}</h6> 
                    <small class="text-muted p-t-30 db">Staff ID Number</small>
                    <h6>{{ $driver->idnumber }}</h6>
                    <br />
                    @switch(strtolower($driver->status))
                        @case('activate')
                            <button type="button" class="callback btn btn-primary" data-id="{{ $driver->id }}" data-module="drivers"> Suspend </button>
                            @break

                        @default
                            <button type="button" class="callback btn btn-primary" data-id="{{ $driver->id }}" data-module="drivers"> Activate </button>
                    @endswitch
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <ul class="nav nav-tabs profile-tab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#cards" role="tab" aria-expanded="false">Cards</a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#transactions" role="tab" aria-expanded="true">Transactions</a> </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="cards" role="tabpanel" aria-expanded="false">
                        <div class="card-block">
                            <div class="profiletimeline">
                                @foreach ($cards as $card)
                                    <div class="sl-item">
                                        <div class="sl-left"> 
                                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        </div>
                                        <div class="sl-right">
                                            <div style="text-align:left;">
                                                <a href="#" class="link">{{ $card->cardnos }}</a>
                                                <br /><br />
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
                                                    data-value="{{ $card->assignedto }}" data-title="Select Driver" class="assignedto editable editable-click">{{ $card->Fullname }}</a>
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
                                    <hr />
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="transactions" role="tabpanel" aria-expanded="true">
                        <div class="card-block">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection