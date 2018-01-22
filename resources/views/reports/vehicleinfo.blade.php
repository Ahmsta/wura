@extends('layouts.wura')
@section('page_heading', "Comphrensive Vehicle Information")

@section('content')
    <div class="row" style="margin-top:20px;">
        @foreach ($vehicle as $info)
            <?php
                $left_view = \Illuminate\Support\Facades\Storage::url($info->left_view);
                $rear_view = \Illuminate\Support\Facades\Storage::url($info->rear_view);
                $right_view = \Illuminate\Support\Facades\Storage::url($info->right_view);
                $frontal_view = \Illuminate\Support\Facades\Storage::url($info->frontal_view);
            ?>
            <script>
                var data = <?php echo json_encode($info->car_details); ?>;
            </script>

            <div class="col-md-2 col-lg-2">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-12 col-lg-12">
                        <label class="control-label" style="color:white;"> Front View </label>
                        <br />
                        <img style="height: 100px;" src="{{ $frontal_view }}" alt="Front view of {{ $info->license_plate_number }}." class="img-responsive img-thumbnail pull-left" />
                    </div>
                </div>

                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-12 col-lg-12">
                        <label class="control-label" style="color:white;"> Right Hand Side View </label>
                        <br />
                        <img style="height: 100px;" src="{{ $right_view }}" alt="Right Hand side view of {{ $info->license_plate_number }}." class="img-responsive img-thumbnail pull-left" />
                    </div>
                </div>

                <div class="row move" style="margin-bottom: 5px;">
                    <div class="col-md-12 col-lg-12">
                        <label class="control-label" style="color:white;"> Rear View </label>
                        <br />
                        <img style="height: 100px;" src="{{ $rear_view }}" alt="Rear view of {{ $info->license_plate_number }}." class="img-responsive img-thumbnail pull-left" />
                    </div>
                </div>

                <div class="row move" style="margin-bottom: 5px;">
                    <div class="col-md-12 col-lg-12">
                        <label class="control-label" style="color:white;"> Left Hand Side <br />View </label>
                        <br />
                        <img style="height: 100px;" src="{{ $left_view }}" alt="Left Hand side view of {{ $info->license_plate_number }}." class="img-responsive img-thumbnail pull-left" />
                    </div>
                </div>

            </div>

            <div class="col-md-5 col-lg-5" id="modelData" name="modelData"></div>

            <div class="col-md-5 col-lg-5">
                <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-12 col-lg-12" style="text-align: left;">
                        <label class="control-label"> Year Manufactured: <i style="color:white;"> {{ $info->year }} </i></label><br />
                        <label class="control-label"> Car Make: <i style="color:white;"> {{ $info->make }} </i></label><br />
                        <label class="control-label"> Car Model: <i style="color:white;"> {{ $info->model }} </i></label><br />
                        <label class="control-label"> Car Trim: <i style="color:white;"> {{ explode(":", $info->trim)[1] }} </i></label><br />
                        <label class="control-label"> Car Color: <i style="color:white;"> {{ $info->color }} </i></label><br />
                        <label class="control-label"> Owner's Name: <i style="color:white;"> {{ $info->owner_name }} </i></label><br />
                        <label class="control-label"> Date Purchased: <i style="color:white;"> {{ Carbon\Carbon::parse($info->purchase_date)->toFormattedDateString() }} </i></label><br />
                        <label class="control-label"> Licensed Plate Number: <i style="color:white;"> {{ $info->license_plate_number }} </i></label>
                    </div>
                </div>
                <div id="modelInfo" name="modelInfo"></div>
            </div>

        @endforeach
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/carquery.js') }}"></script>
    <script>
        carDataHTML();
        $('#pgheader')
                    .css('text-decoration', 'underline')
                    .html('{{$vehicle[0]->year}} {{$info->make}} {{$info->model}} {{explode(":", $info->trim)[1]}}');
    </script>
@stop