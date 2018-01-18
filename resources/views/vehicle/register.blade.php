@extends('layouts.wura')
@section('page_heading','Vehicle Registration')

@section('styles')
    <link href="{{ asset('css/float-label-control.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('content')

['year', 'type', 'color', 'model', 'drive', 'doors', 'body', 'fuel_type', 'owner_name', 'transmission', 'purchase_date', 'license_plate_number', 'left_view', 'rear_view', 'right_view', 'frontal_view'];

    <form class="form-horizontal" id="vehicleform" name="vehicleform" method="POST" action="{{ route('store') }}" enctype="multipart/form-data" >
        {{ csrf_field() }}
        
        <div class="panel panel-default">

            <div class="panel-body">

                <div class="row" style="margin-top:20px;">

                    <div class="col-md-4" title="Last Name">
                        <div class="">
                            <label for="Year">Year</label>
                            @if ($errors->has('Year'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Year') }}</strong>
                                </span>
                            @endif
                            <br />
                            <select id="Year" name="Year" placeholder="Year" class="form-control required"></select>
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="form-group{{ $errors->has('Username') ? ' has-error' : '' }} float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                </div>

                <div class="row" style="margin-top:20px;">

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Year</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="Year" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="form-group{{ $errors->has('Username') ? ' has-error' : '' }} float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                </div>

                <div class="row" style="margin-top:20px;">

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Year</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="Year" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="form-group{{ $errors->has('Username') ? ' has-error' : '' }} float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                </div>

                <div class="row" style="margin-top:20px;">

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Year</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="Year" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                    <div class="col-md-4" title="Last Name">
                        <div class="form-group{{ $errors->has('Username') ? ' has-error' : '' }} float-label-control">
                            <label for="">Username</label>
                            @if ($errors->has('Username'))
                                <span class="help-block text-danger">
                                    <strong>{{ $errors->first('Username') }}</strong>
                                </span>
                            @endif
                            <br />
                            <input id="Username" name="Username" value="{{ old('Username') }}" type="text" placeholder="User Name" class="form-control required" />
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <hr />

    </form>

<!-- <div class="col-md-6">
            <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
            <br />
            <label class="Picture" for="passpic">
                <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
            </label>
        </div> -->
                <!-- <h4 class="page-header">Default Implementation</h4>
                <form role="form">
                    <div class="form-group float-label-control">
                        <label for="">Username</label>
                        <input type="email" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Password</label>
                        <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Textarea</label>
                        <textarea class="form-control" placeholder="Textarea" rows="1"></textarea>
                    </div>
                </form>


                <h4 class="page-header">Bottom Labels</h4>
                <form role="form">
                    <div class="form-group float-label-control label-bottom">
                        <label for="">Username</label>
                        <input type="email" class="form-control" placeholder="Username">
                    </div>
                </form>


                <h4 class="page-header">Placeholder Overrides</h4>
                <form role="form">
                    <div class="form-group float-label-control">
                        <label for="">Email Address</label>
                        <input type="email" class="form-control" placeholder="What's your email address?">
                    </div>
                </form> -->

@endsection

@section('scripts')
    <!-- <script type="text/javascript" src="https://www.carqueryapi.com/js/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://www.carqueryapi.com/js/carquery.0.3.4.js"></script>
    <script type="text/javascript" src="{{ asset('js/float-label-control.js') }}"></script>
@stop