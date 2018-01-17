@extends('layouts.wura')
@section('page_heading', "Driver's Report")

@section('content')

    <div class="row" style="margin-top:20px;">

        @foreach ($drivers as $driver)
            <?php
                $imgPath = \Illuminate\Support\Facades\Storage::url($driver->passportpath);
            ?>
                     
            <div class="col-md-6 col-lg-6 col-xlg-4">
                <div class="card card-block">
                    <div class="row">
                        <div class="col-md-4 col-lg-3 text-center">
                            <a href="driverdetails?id={{ $driver->id }}">
                                <img src="{{ $imgPath }}" alt="{{ $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname }}'s Picture" class="img-responsive img-circle img-thumbnail"  />
                            </a>
                        </div>
                        <div class="col-md-8 col-lg-9" style="text-align:left; color: black; line-height:30px;">
                            <a href="driverdetails?id={{ $driver->id }}">
                                <h3 style="color:#01c0c8;" class="box-title m-b-0">{{ $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname }}</h3> 
                            </a>
                            <i class="fa fa-id-card-o" aria-hidden="true" title="Staff ID Number"></i> {{ $driver->idnumber }} 
                            <br />
                            <i class="fa fa-envelope-o" aria-hidden="true" title="Email Address"></i> {{ $driver->email }} 
                            <br />
                            <i class="fa fa-calendar" aria-hidden="true" title="Date of Birth"></i> {{ Carbon\Carbon::parse($driver->dateofbirth)->toFormattedDateString() }}
                            <br />
                            <i class="fa fa-phone" aria-hidden="true" title="Mobile Number"></i> {{ $driver->mobilenumber }}
                            
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
            </div>
        @endforeach

    </div>
@endsection