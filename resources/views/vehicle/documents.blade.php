@extends('layouts.wura')
@section('page_heading', "Car Documents.")

@section('styles')
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" /> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/basic.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
    <div class="row">
        <div class="col-md-23">

            <div id="actions" class="row">
                <div class="col-md-5">
                    <span class="fileupload-process">
                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </span>
                </div>

                <div class="col-md-7">
                    <p class="pull-right">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Add files...</span>
                        </span>
                    </p>
                </div>
            </div>
            <hr />

            <div id="previews" class="row">
                <div id="template">
                    <div id="Div" class="col-md-4">
                        <!-- This is used as the file preview template -->
                        <div class="pull-left">
                            <span class="preview">
                                File Name: <label class="name" data-dz-name></label>
                                <br />
                                File Size: <label class="size" data-dz-size></label>
                                <br />
                                <span id="ButRemove" onclick="RemoveDiv();" class="btn btn-danger glyphicon glyphicon-trash pull-right"></span>
                                <br />
                                <img data-dz-thumbnail class="img-responsive img-thumbnail" alt="Uploaded Image Preview" />
                                <select id="DocTypes" class="form-control input-lg" data-width="100%">
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
                            </span>
                        </div>

                        <div>
                            <strong class="error text-danger" data-dz-errormessage></strong>
                        </div>

                        <div>
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
@endsection

@section('scripts')
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/min/dropzone.min.js"></script>
    <script>
            // $.fn.select2.defaults.set( "width", "100%" );
        $(document).ready(function () {
            
            // Get the template HTML and remove it from the doument
            var previewNode = document.querySelector("#template");

            if (previewNode !== null) {
                previewNode.id = "";
                var previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);

                var myDropzone = new Dropzone(document.body, 
                {
                    // Make the whole body a dropzone
                    maxFiles: 100,
                    autoQueue: false,
                    maxFilesize: 500,
                    thumbnailWidth: 450,
                    parallelUploads: 1,
                    thumbnailHeight: 250,
                    autoProcessQueue: false,
                    acceptedFiles: "image/*",
                    paramName: "PropertyImage",
                    clickable: ".fileinput-button",
                    previewsContainer: "#previews",
                    previewTemplate: previewTemplate,
                    url: '#',
                    dictMaxFilesExceeded: "You can only upload up to 100 images",
                    dictCancelUploadConfirmation: "Are you sure to cancel upload?",
                });

                myDropzone.on("addedfile", function (file) {
                    //myDropzone.uploadFile(file);

                    // // Hack to convert the dropdown to a valid select2.
                    // $(file.previewTemplate.children.Div.children['0'].children['0'].children.DocTypes).select2({
                    //     theme: "bootstrap",
                    //     allowClear: true,
                    //     selectOnClose: true,
                    //     placeholder: 'Select an option'
                    // });
                });

                // Update the total progress bar
                myDropzone.on("totaluploadprogress", function (progress) {
                    document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
                });

                myDropzone.on("sending", function (file, xhr, formData) {

                    // Show the total progress bar when upload starts
                    document.querySelector("#total-progress").style.opacity = "1";

                    //if ($('#PropertyImageCategory :selected').text().toLowerCase() == "select your property image category") {
                    //    toastr.error('Invalid Property Category Selected.', CareTakerDirectJs.Title);
                    //    // Cancel the Upload and remove the file.
                    //    myDropzone.cancelUpload(file);
                    //    myDropzone.removeFile(file);
                    //}
                    //else {
                    //    formData.append("MakeDefault", $('#ImgDefault').is(':checked'));
                    //    formData.append("Image_Category", $('#PropertyImageCategory').val());
                    //}
                    // Close the Dialog box.
                    //$('#PropertyImageCategoryModal').modal('hide');
                });

                // Hide the total progress bar when nothing's uploading anymore
                myDropzone.on("queuecomplete", function (progress) {
                    document.querySelector("#total-progress").style.opacity = "0";
                });

                // Handle the successful uploading of the file to the server.
                myDropzone.on("success", function (file, response) {

                    if (response.status.toLowerCase() == 'success') {
                        // Log the File Details.
                        CareTakerDirectJs.Attached_files[response.Message] = file;

                        // Hide the progress bar.
                        file.previewTemplate.childNodes['1'].children['2'].style.opacity = "0";
                    }
                    else {
                        file.status = "error";
                        file.accepted = false;
                        file.previewElement.classList.add("dz-error");

                        var _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                        _ref[0].textContent = response.Message;
                    }

                });
                //$(self._select2).parent().find(".select2-container").css('width', '');
            }

            // $('select').select2({
            //     theme: "classic",
            //     allowClear: true,
            //     selectOnClose: true,
            //     placeholder: 'Select an option'
            // });

            // select2 select2-container select2-container--classic select2-container--above select2-container--focus
        });
    </script>
@stop