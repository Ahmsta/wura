@extends('layouts.wura')
@section('page_heading','Moderate Drivers')
@section('content')

    <?php
        $cnt = 0;
    ?>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">       
                <table id='TblRecords' class='table dtable table-condensed table-hover table-bordered'>
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
                                <td>{{ Carbon\Carbon::parse($driver->dateofbirth)->toFormattedDateString() }} </td>
                                <td>
                                    @switch(strtolower($driver->status))
                                        @case('activate')
                                            <button type="button" class="callback btn btn-primary" data-id="{{ $driver->id }}" data-module="drivers"> Suspend </button>
                                            @break

                                        @default
                                            <button type="button" class="callback btn btn-primary" data-id="{{ $driver->id }}" data-module="drivers"> Activate </button>
                                    @endswitch
                                    <button type="button" class="btn btn-primary driverEdit" data-id="{{ $driver->id }}"> 
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit    
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="driverEditModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"> Modify Driver Details. </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="driverform" name="driverform" method="POST" action="{{ route('updatedriver') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="id" id="id" value="" />

                        <div class="row container-fluid">
                            <h3> Basic Information </h3>
                            <div class="row" style="margin-bottom:5px;">
                                <div class="col-md-6" title="First Name">
                                    <label style="text-align:left; float: left;">First Name</label>
                                    @if ($errors->has('firstname'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                    @endif
                                    <input id="firstname" name="firstname" value="{{ old('firstname') }}" type="text" placeholder="First Name" class="form-control required" />
                                </div>
                                <div class="col-md-6" title="Middle Name">
                                    <label style="text-align:left; float: left;">Driver Status</label>
                                    @if ($errors->has('middlename'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('middlename') }}</strong>
                                        </span>
                                    @endif
                                    <input id="middlename" name="middlename" value="{{ old('middlename') }}" type="text" placeholder="Middle Name" class="form-control required" required />
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:5px;">
                                <div class="col-md-6" title="Last Name">
                                    <label style="text-align:left; float: left;">Last Name</label>
                                    @if ($errors->has('lastname'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                    @endif
                                    <input id="lastname" name="lastname" value="{{ old('lastname') }}" type="text" placeholder="Last Name" class="form-control required" />
                                </div>
                                <div class="col-md-6" title="Driver Status:">                                    
                                    <label style="text-align:left; float: left;">Driver Status</label>
                                    <br /><br />
                                    <label id="driverStatus" class="control-label pull-left" style="padding-top: 0px; color:black;">Current Status:</label>
                                    <!-- <button type="button" id="statusButton" class="callback btn btn-primary pull-right" data-id="{{ $driver->id }}" data-module="drivers" style="margin-top: -15px;"> Activate </button> -->
                                </div>
                            </div> 

                            <h3> Business Information </h3>

                            <div class="row" style="margin-bottom:5px;">
                                <div class="col-md-6" title="Staff ID Number">
                                    <label style="text-align:left; float: left;">Staff ID Number</label>
                                    @if ($errors->has('idnumber'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('idnumber') }}</strong>
                                        </span>
                                    @endif
                                    <input id="idnumber" name="idnumber" value="{{ old('idnumber') }}" type="text" placeholder="Staff ID Number" class="form-control required" />
                                </div>
                                <div class="col-md-6" title="Mobile Number">
                                    <label style="text-align:left; float: left;">Mobile Number</label>
                                    @if ($errors->has('mobile'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @endif
                                    <input id="mobile" name="mobile" value="{{ old('mobile') }}" type="text" placeholder="Mobile Number" class="form-control required" />
                                </div>
                            </div>

                            <div class="row" style="margin-bottom:5px;">
                                <div class="col-md-6" title="Date Of Birth">
                                    <label style="text-align:left; float: left;">Date Of Birth</label>
                                    @if ($errors->has('dateofbirth'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('dateofbirth') }}</strong>
                                        </span>
                                    @endif
                                    <input id="DOB" name="DOB" value="{{ old('dateofbirth') }}" type="date" placeholder="Date of Birth" class="form-control required" />
                                </div>                             
                                <div class="col-md-6" title="Email Address">
                                    <label style="text-align:left; float: left;">Email Address</label>
                                    @if ($errors->has('email'))
                                        <span class="help-block text-danger pull-right">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    <input id="email" name="email" value="{{ old('email') }}" type="text" placeholder="Email Address" class="form-control required" />
                                </div>                                
                            </div>

                            <h3> Images </h3>
                            <div class="row" style="margin-bottom:5px;">
                                <div class="col-md-6">
                                    Upload Staff Passport / Picture.
                                    <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                                    <br /><br />
                                    <label class="Picture" for="passpic">
                                        <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    Upload ID Card / means of Identification.
                                    <input type="file" id="StaffID" name="StaffID" data-preview="IDPreview" accept="image/*" />
                                    <br /><br />
                                    <label class="Picture" for="StaffID">
                                        <img id="IDPreview" name="IDPreview" src="{{ $defaultImg }}" />
                                    </label>                        
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="updateDriver" name="updateDriver">
                        <i class="fa fa-save fa-5w">&nbsp;&nbsp;</i>
                        Update Driver Details.
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
@endsection