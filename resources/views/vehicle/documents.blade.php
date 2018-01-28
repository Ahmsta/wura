@extends('layouts.wura')
@section('page_heading', "Car Documents.")

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/basic.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <script>
        var _hdr = '{{ $vehicles->year . ' ' . $vehicles->make . ' ' . $vehicles->model . ' ' . explode(":", $vehicles->trim)[1] }}';
    </script>

    <div class="row"></div>
        <div class="col-md-23">
            <div id="previews" class="row">
                <div id="template">
                    <div id="Div" class="col-md-4">
                        <!-- This is used as the file preview template -->
                        <div class="pull-left">
                            <span class="preview">
                                <div class="card-content">   
                                    <span class="card-title pull-left" style="color:white; font-size:14px;">
                                        <label class="name truncate" data-dz-name></label>
                                        <br />
                                    </span>
                                    <span id="ButRemove" onclick="RemoveDiv();" class="btn btn-danger glyphicon glyphicon-trash pull-right"></span>
                                    <br />
                                    <img data-dz-thumbnail class="img-responsive img-thumbnail" onmouseenter="cardReveal(this);" alt="Uploaded Image Preview" />
                                </div>

                                <div class="card-reveal hide">
                                    <span class="card-title">
                                        <label class="name" data-dz-name></label>
                                    </span>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cardHide(this,event);" >
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    <p>
                                        <span class="pull-left" style="text-align:left;">
                                            <input type="hidden" value="" id="id" name="id" />
                                            <div class="row">
                                                <div class="col-md-12" style="text-align:left;">
                                                    Select Desired Document Category.
                                                    <select id="DocTypes" name="DocTypes" class="form-control input-lg">
                                                        <option value="0">Select Desired Document Category.</option>
                                                        <optgroup label="Car Registration Documents">
                                                            <option>Proof of ownership</option>
                                                            <option>Means of identification</option>
                                                            <option>Vehicle last Renewed Licence</option>
                                                            <option>Allocation of plate number form</option>
                                                            <option>Transfer of ownership agreement</option>
                                                        </optgroup>
                                                        <optgroup label="Car change of ownership">
                                                            <option>Police CMR</option>
                                                            <option>Vehicle license</option>
                                                            <option>Treasury receipt</option>
                                                            <option>3rd party Insurance</option>
                                                            <option>Vehicle Plate Number</option>
                                                            <option>Road worthiness certificate</option>
                                                            <option>Allocation of new number plate</option>
                                                            <option>Proof of ownership certificate</option>
                                                        </optgroup>
                                                        <optgroup label="Other Documents">
                                                            <option>Vehicle License</option>
                                                            <option>Road worthiness certificate</option>
                                                            <option>Third party insurance</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <span class="col-md-12" style="text-align:left;">Document Expiry Date:</span>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input id="ExpiryDate" name="ExpiryDate" value="" type="date" placeholder="Expiry Date" class="form-control input-lg required" />
                                                </div>
                                            </div>

                                            <div class="row">
                                                <span class="col-md-12" style="text-align:left;">Set Reminder for: </span>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select id="notifyType" name="notifyType" class="col-md-4 input-lg">
                                                        <option>Email</option>
                                                        <option selected>Notification</option>
                                                    </select>
                                                    <input id="counter" name="counter" type="number" placeholder="1" class="col-md-4 input-lg required" value="1" />
                                                    <select id="frequency" name="frequency" class="col-md-4 input-lg">
                                                        <option selected>minutes</option>
                                                        <option>hours</option>
                                                        <option>days</option>
                                                        <option>weeks</option>
                                                    </select>
                                                </div>
                                            </div>                                     
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                </div>

                                <div>
                                    <span class="fileupload-process">
                                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                                        </div>
                                    </span>
                                </div>
                                <hr />
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/vehicledocument.js') }}"></script>
@stop