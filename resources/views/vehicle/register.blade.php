@extends('layouts.wura')
@section('page_heading','Vehicle Registration')

@section('styles')
    <link href="{{ asset('css/float-label-control.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')

    <form class="form-horizontal" id="vehicleform" name="vehicleform" method="POST" action="{{ route('store') }}" enctype="multipart/form-data" >
        {{ csrf_field() }}
        
        <div class="panel panel-default">

            <div class="panel-body">

                <input type="hidden" id="vehicle_info" name="vehicle_info" />

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Car Year">
                        <label for="car_year" style="color:white; text-align:left; float:left;">Year</label>
                        <br />
                        <select id="car_year" name="car_year" placeholder="Car Year" class="form-control required" width="100%"></select>
                    </div>

                    <div class="col-md-6" title="Car Make">
                        <label for="car_type" style="color:white; text-align:left; float:left;">Make</label>
                        <br />
                        <select id="car_type" name="car_type" placeholder="Car Make" class="form-control required" width="100%"></select>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Car Model">
                        <label for="car_model" style="color:white; text-align:left; float:left;">Model</label>
                        <br />
                        <select id="car_model" name="car_model" placeholder="Car Model" class="form-control required" width="100%"></select>
                    </div>

                    <div class="col-md-6" title="Car Model Trim">
                        <label for="car_model_trim" style="color:white; text-align:left; float:left;">Model Trim</label>
                        <br />
                        <select id="car_model_trim" name="car_model_trim" placeholder="Car Model Trim" class="form-control required" width="100%"></select>
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">
                    <div class="col-md-6" title="Car Model Color">
                        <label for="car_model_color" style="color:white; text-align:left; float:left;">Model Color</label>
                        <br />
                        <select id="car_model_color" name="car_model_color" placeholder="Car Model Color" class="form-control required" width="100%"></select>
                    </div>

                    <div class="col-md-6" title="Owner's Name">
                        <label for="owner_name" style="color:white; text-align:left; float:left;">Owner's Name</label>
                        @if ($errors->has('owner_name'))
                            <span class="help-block text-danger">
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
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('purchase_date') }}</strong>
                            </span>
                        @endif
                        <br />
                        <input id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}" type="text" placeholder="Purchase Date" class="form-control required" />
                    </div>

                    <div class="col-md-6" title="License Plate Number">
                        <label for="license_plate_number" style="color:white; text-align:left; float:left;">License Plate Number</label>
                        @if ($errors->has('license_plate_number'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('license_plate_number') }}</strong>
                            </span>
                        @endif
                        <br />
                        <input id="license_plate_number" name="license_plate_number" value="{{ old('license_plate_number') }}" type="text" placeholder="License Plate Number" class="form-control required" />
                    </div>
                </div>

                <div class="row" style="margin-top:20px;">

                    <div class="col-md-3">
                        <label for="car_model_color" style="color:white; text-align:left; float:left;">Front View</label>
                        <br />
                        <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                        <br />
                        <label class="Picture" for="passpic">
                            <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="car_model_color" style="color:white; text-align:left; float:left;">Right Hand Side View</label>
                        <br />
                        <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                        <br />
                        <label class="Picture" for="passpic">
                            <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="car_model_color" style="color:white; text-align:left; float:left;">Left Hand Side View</label>
                        <br />
                        <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                        <br />
                        <label class="Picture" for="passpic">
                            <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                    <div class="col-md-3">
                        <label for="car_model_color" style="color:white; text-align:left; float:left;">Rear View</label>
                        <br/>
                        <input type="file" id="passpic" name="passpic" data-preview="ImgPreview" accept="image/*" />
                        <br />
                        <label class="Picture" for="passpic">
                            <img id="ImgPreview" name="ImgPreview" src="{{ $defaultImg }}" />
                        </label>
                    </div>

                </div>

            </div>

            <div id="modelData" name="modelData"></div>
        </div>

        <hr />

    </form>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/float-label-control.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/carquery.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            // $('select').select2({
            //     theme: "classic",
            //     allowClear: true,
            //     selectOnClose: true,
            //     placeholder: 'Select an option'
            // });

        });
    </script>
@stop