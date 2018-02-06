var hashtable = {};
var myDropzone = "";
var errorList = '<ol>';
var vehicleid = location.pathname.substring(location.pathname.lastIndexOf("/") + 1, location.pathname.length);

$(document).ready(function () {
    $.ajaxSetup({
        headers:
        { 
            "cache-control": "no-cache",
            "content-type": "application/json",
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#pgheader')
        .css('text-decoration', 'underline')
        .html(_hdr + ' <span class="btn btn-success fileinput-button pull-right"><i class="glyphicon glyphicon-plus"></i><span>&nbsp;Upload supporting documents...</span></span>');
    
    // Get the template HTML and remove it from the doument
    var previewNode = document.querySelector("#template");

    if (previewNode !== null) {
        previewNode.id = "";
        var previewTemplate = previewNode.parentNode.innerHTML;
        previewNode.parentNode.removeChild(previewNode);

        myDropzone = new Dropzone(document.body, 
        {
            // Make the whole body a dropzone
            maxFiles: 100,
            autoQueue: false,
            maxFilesize: 500,
            paramName: "file",
            parallelUploads: 1,
            thumbnailWidth: 450,
            thumbnailHeight: 250,
            autoProcessQueue: false,
            url: '/documentsupload',
            acceptedFiles: "image/*",
            clickable: ".fileinput-button",
            previewsContainer: "#previews",
            previewTemplate: previewTemplate,
            dictMaxFilesExceeded: "You can only upload up to 100 images",
            dictCancelUploadConfirmation: "Are you sure to cancel upload?",
            init:
                function () {
                    thisDropzone = this;
                    $.get('/getDocuments/' + vehicleid, function (data) {
                        if (data == null) {
                            return;
                        }

                        $.each(data.vehicledocs, function (key, value) {
                            var mockFile = { name: value.status.toLowerCase() + ' ' + value.doctypes + ' Document', size: 1, id: value.id };
                            thisDropzone.emit("addedfile", mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.docpath);

                            $(mockFile.previewTemplate).find("input,select,hidden").filter(function() {
                                $(this).val(value[this.id.toLowerCase()]);
                            });

                            if (value.status.toLowerCase() === 'expired') {
                                $(mockFile.previewElement).find('div#Div').css('background-color', 'red');
                            }

                            // Make sure that there is no progress bar, etc...
                            thisDropzone.emit("complete", mockFile);
                        });
                    });
                },
        });
        
        myDropzone.on("addedfile", 
            function (file) {
                if (file.name.indexOf('.') === -1) {
                    hashtable[file.id] = file;
                } else {
                    hashtable[file.name] = file;
                }
            }
        );

        myDropzone.on("sending", 
            function (file, xhr, formData) {
                formData.append("vehicleid", vehicleid);
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

                $(file.previewTemplate).find("input,select,hidden").each(
                    function() {
                        formData.append(this.id.toLowerCase(), $(this).val());
                    }
                );

                // Show the total progress bar when upload starts
                document.querySelector("#total-progress").style.opacity = "1";
            }
        );

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", 
            function (progress) {
                document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
            }
        );

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", 
            function (progress) {
                document.querySelector("#total-progress").style.opacity = "0";
            }
        );

        myDropzone.on("error",
            function(file, errormessage, xhr) {
                if (xhr) {
                    var response = JSON.parse(xhr.responseText);
                    Notify(wurafleet.toastType.Error, response.error.message);
                    file.status = "error";
                    file.accepted = false;
                    file.previewElement.classList.add("dz-error");

                    var _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
                    _ref[0].textContent = response.error.message;
                }
            }
        );

        // Handle the successful uploading of the file to the server.
        myDropzone.on("success", 
            function (file, response) {
                if (response.status.toLowerCase() == 'success') {
                    file.id = response.vehicledoc.id;
                }
            }
        );

        myDropzone.on("maxfilesexceeded", 
            function(file) {
                Notify(wurafleet.toastType.Error, 'You have exceeded the allowed max upload of ' + myDropzone.maxFiles + ' files.');
                myDropzone.removeFile(file);
            }
        );
    }
});

// Remove the Div from the DOM.
function RemoveDiv() {
    var file = null;
    var span_hidden = $(event.srcElement.parentElement.parentElement);
    var lbl_id = $(span_hidden).find(".card-reveal.hide").find('input#id').val();
    var lbl = $($(event.srcElement.parentElement).find('.name.truncate')).html();

    if (lbl.indexOf('.') !== -1) {
        // File has not been uploaded to the server, remove the local copy.
        //myDropzone.removeFile(file);
        $(event.srcElement.parentElement.parentElement.parentElement.parentElement).remove();
        return;
    }

    $.getJSON(window.location.protocol + '//' + window.location.hostname + '/deleteDocument/' + lbl_id, 
        function(data) {
            if (data.status.toLowerCase() === 'success') {
                $(event.srcElement.parentElement.parentElement.parentElement.parentElement).remove();
                // myDropzone.removeFile(file);  
            }
        }
    );
}

function cardHide(Ctrl, event) {
    var lbl_id = 0;
    var errorList = '<ol>';
    var divCtrl = $(Ctrl).parent();
    var lbl = $($(divCtrl).find(".name")[0]).html();
    $(divCtrl).parent().css('background-color', 'transparent');

    $(divCtrl).find("input,select,hidden").each(
        function() {
            switch(this.id.toLowerCase()) {
                case 'id':
                    lbl_id = $(this).val();
                    break;

                case 'doctypes':
                    if ($(this).val() == "0" || $(this).val() == "") {
                        errorList += '<li>Please select a valid Document Category.</li>';
                    }
                    break;
                
                case 'expirydate':
                    if ($(this).val() == "0" || $(this).val() == "") {
                        errorList += '<li>Please select a valid document Expiry Date.</li>';
                    }
                    break;

                case 'counter':
                    if ($(this).val() == "0" || $(this).val() == "") {
                        errorList += '<li>Please enter a valid Duration.</li>';
                    }
                    break;

                case 'frequency':
                    if ($(this).val() == "0" || $(this).val() == "") {
                        errorList += '<li>Please select a valid Notification Frequency.</li>';
                    }
                    break;
                
                case 'notifyType':
                    if ($(this).val() == "0" || $(this).val() == "") {
                        errorList += '<li>Please select a valid Notification Type.</li>';
                    }
                    break;
            }
        }
    );
    errorList += '</ol>';

    if (errorList != "<ol></ol>") {
        $(divCtrl).parent().css('background-color', 'red');
        Notify(wurafleet.toastType.Info, '<strong>' + errorList + '</strong>');
    } else {
        if (lbl.indexOf('.') === -1) {
            var _data = {};
            var file = hashtable[lbl_id];

            _data["vehicleid"] =  vehicleid;
            _data["_token"] = $('meta[name="csrf-token"]').attr('content');
            $(file.previewTemplate).find("input,select,hidden").each(
                function() {
                    _data[this.id.toLowerCase()] = $(this).val();
                }
            );

            settings.method = "POST";
            settings.data = JSON.stringify( _data );
            settings.url = window.location.protocol + '//' + window.location.hostname + '/documentsupload';
            $.ajax(settings)
                .fail(function(jqXHR, textStatus) {
                    Notify(wurafleet.toastType.Error, 'Request Failed: ' + textStatus + '. Server responsed with ' + jqXHR.responseText);
                })
                .done(function (response) {
                    if (response.status.toLowerCase() === 'success') {
                        Notify(wurafleet.toastType.Success, 'Document has been successfully updated.');
                    }
                }
            );
        } else {
            myDropzone.uploadFile(hashtable[lbl])
        }
    }
    $(divCtrl).fadeOut('slow').addClass('hide');
}

function cardReveal(Ctrl) {
    var divCtrl = $(Ctrl).parent().parent().find(".card-reveal.hide")[0];
    $(divCtrl).fadeIn('slow').removeClass('hide');
}