@extends('layouts.wura')
@section('page_heading','Vehicle Registration')

@section('content')
    <form class="form-horizontal" id="vehicleform" name="vehicleform" method="POST" action="{{ route('registervehicle') }}" enctype="multipart/form-data" >
        {{ csrf_field() }}
        <div class="panel panel-default">
            <div class="panel-body">

                <input type="hidden" id="vehicle_info" name="vehicle_info" value="" />

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Car Year">
                        <label for="car_year" style="color:white; text-align:left; float:left;">Year</label>
                        @if ($errors->has('car_year'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('car_year') }}</strong>
                            </span>
                        @endif
                        <br />
                        <select id="car_year" name="car_year" placeholder="Car Year" class="form-control required" width="100%"></select>
                    </div>

                    <div class="col-md-6" title="Car Make">
                        <label for="car_type" style="color:white; text-align:left; float:left;">Make</label>
                        @if ($errors->has('car_type'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('car_type') }}</strong>
                            </span>
                        @endif
                        <br />
                        <select id="car_type" name="car_type" placeholder="Car Make" class="form-control required" width="100%"></select>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Car Model">
                        <label for="car_model" style="color:white; text-align:left; float:left;">Model</label>
                        @if ($errors->has('car_model'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('car_model') }}</strong>
                            </span>
                        @endif
                        <br />
                        <select id="car_model" name="car_model" placeholder="Car Model" class="form-control required" width="100%"></select>
                    </div>

                    <div class="col-md-6" title="Car Model Trim">
                        <label for="car_model_trim" style="color:white; text-align:left; float:left;">Model Trim</label>
                        @if ($errors->has('car_model_trim'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('car_model_trim') }}</strong>
                            </span>
                        @endif
                        <br />
                        <select id="car_model_trim" name="car_model_trim" placeholder="Car Model Trim" class="form-control required" width="100%"></select>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Car Model Color">
                        <label for="car_model_color" style="color:white; text-align:left; float:left;">Model Color</label>
                        @if ($errors->has('car_model_color'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('car_model_color') }}</strong>
                            </span>
                        @endif
                        <br />
                        <select id="car_model_color" name="car_model_color" placeholder="Car Model Color" class="form-control required color" width="100%"></select>
                    </div>

                    <div class="col-md-6" title="Owner's Name">
                        <label for="owner_name" style="color:white; text-align:left; float:left;">Owner's Name</label>
                        @if ($errors->has('owner_name'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('owner_name') }}</strong>
                            </span>
                        @endif
                        <br />
                        <input id="owner_name" name="owner_name" value="{{ old('owner_name') }}" type="text" placeholder="Owner's Name" class="form-control required" />
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Purchase Date">
                        <label for="purchase_date" style="color:white; text-align:left; float:left;">Purchase Date</label>
                        @if ($errors->has('purchase_date'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('purchase_date') }}</strong>
                            </span>
                        @endif
                        <br />
                        <input id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" type="date" placeholder="Purchase Date" class="form-control required" />
                    </div>

                    <div class="col-md-6" title="License Plate Number">
                        <label for="license_plate_number" style="color:white; text-align:left; float:left;">License Plate Number</label>
                        @if ($errors->has('license_plate_number'))
                            <span class="text-danger pull-right">
                                <strong>{{ $errors->first('license_plate_number') }}</strong>
                            </span>
                        @endif
                        <br />
                        <input id="license_plate_number" name="license_plate_number" value="{{ old('license_plate_number') }}" type="text" placeholder="License Plate Number" class="form-control required" />
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">

                    <div class="col-md-3">
                        <label for="" style="color:white; text-align:center;">Front View</label>
                        <br />
                        <input type="file" id="front_view_image" name="front_view_image" data-preview="front_view_preview" accept="image/*" />
                        <br />
                        <label class="Picture" for="front_view_image">
                            <img id="front_view_preview" name="front_view_preview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="" style="color:white; text-align:center;">Right Hand Side View</label>
                        <br />
                        <input type="file" id="right_view" name="right_view" data-preview="right_view_preview" accept="image/*" />
                        <br />
                        <label class="Picture" for="right_view">
                            <img id="right_view_preview" name="right_view_preview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="" style="color:white; text-align:center;">Left Hand Side View</label>
                        <br />
                        <input type="file" id="left_view" name="left_view" data-preview="left_view_preview" accept="image/*" />
                        <br />
                        <label class="Picture" for="left_view">
                            <img id="left_view_preview" name="left_view_preview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="" style="color:white; text-align:center;">Rear View</label>
                        <br/>
                        <input type="file" id="rear_view" name="rear_view" data-preview="rear_view_preview" accept="image/*" />
                        <br />
                        <label class="Picture" for="rear_view">
                            <img id="rear_view_preview" name="rear_view_preview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary pull-right" id="submitRegistration" name="submitRegistration">
                    <i class="fa fa-save fa-5w">&nbsp;&nbsp;</i>
                    Submit Car Registration Details.
                </button>
            </div>
        </div>
    </form>

    <div class="modal fade" id="carModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel"> New Car Details Registration. </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom:20px;">
                        <label for="carmake" class="col-md-4 control-label" style="text-align:left;"> Car Make </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="carmake" id="carmake"  placeholder="Enter your Car Make" value="" tabindex="1" required autofocus />
                        </div>
                    </div>

                    <div class="row" style="margin-bottom:20px;">
                        <label for="carmodel" class="col-md-4 control-label" style="text-align:left;"> Car Model </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="carmodel" id="carmodel"  placeholder="Enter your Car Model" value="" tabindex="1" required autofocus />
                        </div>
                    </div>

                    <div class="row" style="margin-bottom:20px;">
                        <label for="modeltrim" class="col-md-4 control-label" style="text-align:left;"> Model Trim </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="modeltrim" id="modeltrim" placeholder="Enter your Model Trim" value="" tabindex="3" required autofocus />
                        </div>
                    </div>
                            
                    <div class="row" style="margin-bottom:20px;">
                        <label for="modelcolor" class="col-md-4 control-label" style="text-align:left;"> Model Color </label>
                        <div class="col-md-8">
                            <select id="modelcolor" name="modelcolor" placeholder="Car Model Color" class="form-control required color" width="100%" tabindex="3"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="carReg" name="carReg" data-dismiss="modal">
                        <i class="fa fa-save fa-5w">&nbsp;&nbsp;</i>
                        Register Car Details.
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/carquery.js') }}"></script>
@stop