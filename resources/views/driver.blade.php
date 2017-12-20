@extends('layouts.wura')
@section('page_heading','Register New Driver')
@section('content')

<div class="container">

    <h3> Basic Information </h3>

    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{ route('store') }}" enctype="multipart/form-data" >
                {{ csrf_field() }}

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-6">
                                <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                                <br />
                                <label class="Picture" for="passpic">
                                    <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                                </label>
                            </div>
                            <div class="col-md-6">
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-md-12 form-group{{ $errors->has('firstname') ? ' has-error' : '' }}" title="First Name">
                                        @if ($errors->has('firstname'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('firstname') }}</strong>
                                            </span>
                                        @endif
                                        <input id="firstname" name="firstname" value="{{ old('firstname') }}" type="text" placeholder="First Name" class="form-control required" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-md-12 form-group{{ $errors->has('middlename') ? ' has-error' : '' }}" title="Middle Name">
                                        @if ($errors->has('middlename'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('middlename') }}</strong>
                                            </span>
                                        @endif
                                        <input id="middlename" name="middlename" value="{{ old('middlename') }}" type="text" placeholder="Middle Name" class="form-control required" />
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-md-12 form-group{{ $errors->has('lastname') ? ' has-error' : '' }}" title="Last Name">
                                        @if ($errors->has('lastname'))
                                            <span class="help-block text-danger">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                        @endif
                                        <input id="lastname" name="lastname" value="{{ old('lastname') }}" type="text" placeholder="Last Name" class="form-control required" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />

                        <h3> Business Information </h3>

                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-6 {{ $errors->has('idnumber') ? ' has-error' : '' }}" title="Staff ID Number">
                                @if ($errors->has('idnumber'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('idnumber') }}</strong>
                                    </span>
                                @endif
                                <input id="idnumber" name="idnumber" value="{{ old('idnumber') }}" type="text" placeholder="Staff ID Number" class="form-control required" />
                            </div>
                            <div class="col-md-6 {{ $errors->has('mobile') ? ' has-error' : '' }}" title="Mobile Number">
                                @if ($errors->has('mobile'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('mobile') }}</strong>
                                    </span>
                                @endif
                                <input id="mobile" name="mobile" value="{{ old('mobile') }}" type="text" placeholder="Mobile Number" class="form-control required" />
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-6 {{ $errors->has('dateofbirth') ? ' has-error' : '' }}" title="Date Of Birth">
                                @if ($errors->has('dateofbirth'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('dateofbirth') }}</strong>
                                    </span>
                                @endif
                                <input id="DOB" name="DOB" value="{{ old('dateofbirth') }}" type="date" placeholder="Date of Birth" class="form-control required" />
                            </div>
                            <div class="col-md-6 {{ $errors->has('email') ? ' has-error' : '' }}" title="Email Address">
                                @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <input id="email" name="email" value="{{ old('email') }}" type="text" placeholder="Email Address" class="form-control required" />
                            </div>
                        </div>
                    
                        <hr />

                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-12">
                                <p>
                                    Upload Staff ID Card or means of Identification.
                                </p>
                                <input type="file" id="StaffID" name="StaffID" data-preview="IDPreview" accept="image/*" />
                                <br />
                                <label class="Picture" for="StaffID">
                                    <img id="IDPreview" name="IDPreview" src="" />
                                </label>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom:10px;">
                            <button type="submit" class="btn btn-wura btn-lg pull-right">Register Driver</button>                 
                        </div>
                    </div>

                </div>

            </form>
        </div>

    </div>

</div>

@endsection