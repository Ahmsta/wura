@extends('layouts.wura')
@section('page_heading','Register New Driver')

@section('styles')
    <link href="{{ asset('css/float-label-control.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .float-label-control label {
            position: absolute;
            font-weight: normal;
            top: -1.3em;
            left: 1em;
            color: #fff;
        }
    </style>
@stop

@section('content')
    <h3> Basic Information </h3>
    <br />

    <div class="row">
        <div class="col-md-12">
            <form class="form-horizontal" id="driverform" name="driverform" method="POST" action="{{ route('store') }}" enctype="multipart/form-data" >
                {{ csrf_field() }}

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row" style="margin-bottom:15px;">
                            <div class="col-md-6">
                                <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                                <br />
                                <label class="Picture" for="passpic">
                                    <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 form-group{{ $errors->has('firstname') ? ' has-error' : '' }} float-label-control" title="First Name">
                                        <label for="">First Name</label>
                                        @if ($errors->has('firstname'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('firstname') }}</strong>
                                            </span>
                                        @endif
                                        <input id="firstname" name="firstname" value="{{ old('firstname') }}" type="text" placeholder="First Name" class="form-control required" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 float-label-control form-group{{ $errors->has('middlename') ? ' has-error' : '' }}" title="Middle Name">
                                        <label for="">Middle Name</label>
                                        @if ($errors->has('middlename'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('middlename') }}</strong>
                                            </span>
                                        @endif
                                        <input id="middlename" name="middlename" value="{{ old('middlename') }}" type="text" placeholder="Middle Name" class="form-control required" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 float-label-control form-group{{ $errors->has('lastname') ? ' has-error' : '' }}" title="Last Name">
                                        <label for="">Last Name</label>
                                        @if ($errors->has('lastname'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                        @endif
                                        <input id="lastname" name="lastname" value="{{ old('lastname') }}" type="text" placeholder="Last Name" class="form-control required" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3> Business Information </h3>
                        <br />

                        <div class="row" style="margin-bottom:15px;">
                            <div class="col-md-6">
                                <input type="file" id="StaffID" name="StaffID" data-preview="IDPreview" accept="image/*" />
                                <br />
                                <label class="Picture" for="StaffID">
                                    <img id="IDPreview" name="IDPreview" src="" required />
                                </label>
                                <p style="margin-top:30px;">
                                    Upload Staff ID Card or means of Identification.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 float-label-control form-group{{ $errors->has('idnumber') ? ' has-error' : '' }}" title="Staff ID Number">
                                        <label for="">Staff ID Number</label>
                                        @if ($errors->has('idnumber'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('idnumber') }}</strong>
                                            </span>
                                        @endif
                                        <input id="idnumber" name="idnumber" value="{{ old('idnumber') }}" type="text" placeholder="Staff ID Number" class="form-control required" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 float-label-control form-group{{ $errors->has('mobile') ? ' has-error' : '' }}" title="Mobile Number">
                                        <label for="">Mobile Number</label>
                                        @if ($errors->has('mobile'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('mobile') }}</strong>
                                            </span>
                                        @endif
                                        <input id="mobile" name="mobile" value="{{ old('mobile') }}" type="text" placeholder="Mobile Number" class="form-control required" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 float-label-control form-group{{ $errors->has('dateofbirth') ? ' has-error' : '' }}" title="Date Of Birth">
                                        <label for="">Date Of Birth</label>
                                        @if ($errors->has('dateofbirth'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('dateofbirth') }}</strong>
                                            </span>
                                        @endif
                                        <input id="DOB" name="DOB" value="{{ old('dateofbirth') }}" type="date" placeholder="Date of Birth" class="form-control required" />
                                    </div>                             
                                </div>
                                <div class="row" style="margin-bottom:15px;">
                                    <div class="col-md-12 float-label-control form-group{{ $errors->has('email') ? ' has-error' : '' }}" title="Email Address">
                                        <label for="">Email Address</label>
                                        @if ($errors->has('email'))
                                            <span class="help-block text-danger pull-right">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                        <input id="email" name="email" value="{{ old('email') }}" type="text" placeholder="Email Address" class="form-control required" />
                                    </div>                                
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:15px;">
                            <button type="submit" id="butDriver" name="butDriver" data-parentform="driverform" class="btn btn-wura btn-lg">Register Driver</button>                 
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/float-label-control.js') }}"></script>
@stop