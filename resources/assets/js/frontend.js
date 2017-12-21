var oTable;

var settings = {
    "async": true,
    "crossDomain": true,
    "url": '',
    "method": "POST",
    "processData": false,
    "data": ''
};

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

var wurafleet = {
    temp: '',
    toastType : {
        Info: 'info',
        Error: 'error',
        Success: 'success',
        Warning: 'warning'
    },
    toastTitle: 'Wurafleet Notification Service'
};

$(document).ready(function () {
    
    $.ajaxSetup({
        headers:
        { 
            "cache-control": "no-cache",
            "content-type": "application/json",
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });

    SetActive();
    Convert2DataTable();

    function SetActive() {
        var url = window.location;

        var element = $('ul.nav a').filter(function() {
            return this.href == url || url.href.indexOf(this.href) == 0;
        })
            .addClass('active')
            .parent()
            .parent()
            .addClass('in')
            .parent();

        if (element.is('li')) {
            element.addClass('active');
        }
    }

    function readURL(input) {
        var PreviewContainer = $(input).data('preview');
        if (input.files && input.files[0]) {
            checkType(input.files[0]);
                
            var reader = new FileReader();
        
            reader.onload = function(e) {
                $('#' + PreviewContainer).attr('src', reader.result);
            }
        
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function checkType(file){
        let imageType = /image.*/;
        if (!file.type.match(imageType)) {
            Notify(wurafleet.toastType.Error, 'File is not a picture');
        } else if (!file){
            Notify(wurafleet.toastType.Error, 'No picture selected');
        } else {
            return;
        }
    }

    function Convert2DataTable() {

        var tables = $.fn.dataTable.fnTables(true);         
        
        $(tables).each(function () {
            $(this).dataTable().fnDestroy();
        });

        // Create a new Instance of the DataTable.
        oTable = $('.dtable').DataTable({
            destroy: true,
        });
    }

    function Notify(toastType, toastMessage) {
        toastr[toastType](toastMessage, wurafleet.toastTitle);
    }

    var editable = $('.assignedto').editable({
        'mode': 'inline',
        showbuttons: true,
        emptytext: "No Driver has been registered",
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
            settings.data = JSON.stringify({
                "request": value,
                "module": 'cardowner',
                "id": $(this).data('id')
            });
            wurafleet.temp = $('.editable-input').find(':selected').text();
            settings.url = window.location.protocol + '//' + window.location.hostname + '/setstatus';
            $.ajax(settings).done(function (response) {
                if (response.status.toLowerCase() === 'success') {
                    Notify(wurafleet.toastType.Success, 'Card has been successfully assigned to ' + wurafleet.temp);                
                }
            });
        }
    });
    
    $('.callback').on('click', function() {
        // Disable button.
        $(this).attr("disabled", "disabled");
        var _module = $(this).data('module');
        settings.data = JSON.stringify(
            {
                "id": $(this).data('id'),
                "request": $(this).text(),
                "module": $(this).data('module')
            }
        );
        settings.url = window.location.protocol + '//' + window.location.hostname + '/setstatus';

        
        $.ajax(settings).done(function (response) {
            if (response.status.toLowerCase() === 'success') {

                var _display, _cardStatus;
                switch (response.old_status.toLowerCase()) {
                    case "activate":
                        _display = "Suspend";
                        _cardStatus = "Activated";
                        break;
                    case "suspend":
                        _display = "Activate";
                        _cardStatus = "Suspended";
                        break;
                    case "cancel":
                        _display = "Activate";
                        _cardStatus = "Cancelled";
                        break;
                    case 'processing request':
                        _display = "Cancel";
                        _cardStatus = "Processing Request";
                        break;
                }

                // Set the Button text.
                $('.callback[data-id="' + response.id + '"]').text(_display);              
                if ($('.callback[data-status="' + response.id + '"]').length > 0) {
                    $('.callback[data-status="' + response.id + '"]').html(_cardStatus);
                }

                // Enable button.
                $('.callback[data-id="' + response.id + '"]').removeAttr("disabled");
                Notify(wurafleet.toastType.Success, 'Request has been processed successfully!');                
            }
        });
    });

    $('input[type=file]').change(function() {
        readURL(this);
    });
    
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    // Initially disable the button
    $("#ContinueButton").attr("disabled", "disabled");
 
    // Map the function below to the scroll event of our Terms DIV
    $("#Terms").scroll(function() {
         if ($("#Terms").AtEnd()) {
              // Enable the button once we reach the end of the DIV
              $("#ContinueButton").removeAttr("disabled");
         }
    });

    
    // $(".expand").on( "click", function() {
    //     $expand = $(this).find(">:first-child");
        
    //     if($expand.text() == "+") {
    //       $expand.text("-");
    //     } else {
    //       $expand.text("+");
    //     }
    //   });
});

$.fn.AtEnd = function() {
    return this[0].scrollTop + this.height() >= this[0].scrollHeight;
};