@extends('layouts.wura')
@section('page_heading','Moderate Drivers')
@section('content')

<?php
    $cnt = 0;
?>

    <div class="row">

        <div class="col-md-12">
           
            <table id='TblRecords' class='table dtable table-condensed table-striped table-bordered table-hover table-bordered'>
                <thead>
                    <tr>
                        <th> S / N </th>
                        <th> Passport </th>
                        <th> Staff ID </th>
                        <th> Full Name </th>
                        <th> Mobile Number </th>
                        <th> Date of Birth </th>
                        <th> Action </th>
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach ($drivers as $driver)
                        <?php
                            $cnt++;
                            $imgPath = \Illuminate\Support\Facades\Storage::url($driver->passportpath);
                        ?>
                        <tr data-href="{{ $driver->id }}">
                            <td>{{ $cnt }}</td>
                            <td> <img src="{{ $imgPath }}" alt="{{ $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname }}'s Picture" class="img-responsive img-thumbnail" style="width:50px; height:50px;" /></td>
                            <td>{{ $driver->idnumber }} </td>
                            <td>{{ $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname }} </td>
                            <td>{{ $driver->mobilenumber }} </td>
                            <td>{{ $driver->dateofbirth }} </td>
                            <td>
                                @switch(strtolower($driver->status))
                                    @case('activate')
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $driver->id }}" data-module="drivers"> Suspend </button>
                                        @break

                                    @default
                                        <button type="button" class="callback btn btn-primary" data-id="{{ $driver->id }}" data-module="drivers"> Activate </button>
                                        @endswitch
                            </td>
                        </tr>
                       
                    @endforeach
                    
                </tbody>
            </table>

        </div>

    </div>

@endsection