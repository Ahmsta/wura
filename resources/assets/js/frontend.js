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
        var element = $('nav li a').filter(function() {
            return this.href == url; // || url.href.indexOf(this.href) == 0;
        });
    
        element.addClass('linkactive').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('linkactive');
        }
    }

    function readURL(input) {
        var PreviewContainer = $(input).data('preview');
        if (input.files && input.files[0]) {
            checkType(input.files[0]);
                
            var reader = new FileReader();
        
            reader.onload = function(e) {
                $('#' + PreviewContainer).attr('src', reader.result);
            };
        
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function PopulatePanel(TabText, JsonObject) {
        if (!$.isEmptyObject(JsonObject)) {
            $.each(JsonObject, function(parentIndex, parentElement) {
                var createdates = parentElement.map(
                    a => moment(a.created_at).format("DD/MM/YYYY")
                );
                var uniquedates = createdates.filter(function(allItems,i,a) {
                    return i==a.indexOf(allItems);
                });

                timeline = '    <div class="row">';
                timeline += '        <div class="col-md-12">';
                timeline += '        <div class="card">';
                timeline += '            <div class="card-block">';
                timeline += '                <section class="cd-horizontal-timeline">';
                timeline += '                    <div class="timeline">';
                timeline += '                        <div class="events-wrapper">';
                timeline += '                            <div class="events" style="width:100%;">';
                timeline += '                                <ol id="eventdates" name="eventdates">';
                $.each(uniquedates, function(index, element) {
                    var displaydate = moment(element.created_at).format("DD MMM");
                    var datadate = moment(element.created_at).format("DD/MM/YYYY");
                    if (index === 0) {
                        timeline += '                                    <li><a href="#0" data-date="' + datadate.toString() + '" class="selected">' + displaydate.toString() + '</a></li>';
                    } else {
                        timeline += '                                    <li><a href="#0" data-date="' + datadate.toString() + '">' + displaydate.toString() + '</a></li>';
                    }
                });
                timeline += '                                </ol>';
                timeline += '                                <span class="filling-line" aria-hidden="true"></span>';
                timeline += '                           </div>';
                timeline += '                        </div>';
                timeline += '                        <ul class="cd-timeline-navigation">';
                timeline += '                            <li><a href="#0" class="prev inactive">Prev</a></li>';
                timeline += '                            <li><a href="#0" class="next">Next</a></li>';
                timeline += '                        </ul>';
                timeline += '                    </div>';
                timeline += '                    <div class="events-content">';
                timeline += '                        <ol>';
                timeline += '                            <li class="selected" data-date="03/01/2018">';
                timeline += '                                <h2><img class="img-circle pull-left m-r-20 m-b-10" width="60" alt="user" src="../assets/images/users/1.jpg" alt="user"> Horizontal Timeline<br/><small>January 16th, 2014</small></h2>';
                timeline += '                                <hr class="m-t-40">';
                timeline += '                                <p class="m-t-40">';
                timeline += '                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.';
                timeline += '                                    <button class="btn btn-info btn-rounded btn-outline m-t-20">Read more</button>';
                timeline += '                                </p>';
                timeline += '                            </li>';
                timeline += '                            <li data-date="03/03/2015">';
                timeline += '                                <h2>Event title here</h2>';
                timeline += '                                <em>March 3rd, 2015</em>';
                timeline += '                                <p>';
                timeline += '                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum praesentium officia, fugit recusandae ipsa, quia velit nulla adipisci? Consequuntur aspernatur at, eaque hic repellendus sit dicta consequatur quae, ut harum ipsam molestias maxime non nisi reiciendis eligendi! Doloremque quia pariatur harum ea amet quibusdam quisquam, quae, temporibus dolores porro doloribus.';
                timeline += '                                </p>';
                timeline += '                            </li>';
                timeline += '                        </ol>';
                timeline += '                    </div>';
                timeline += '                </section>';
                timeline += '            </div>';
                timeline += '        </div>';
                timeline += '    </div>';
                timeline += '</div>';

                SetTimeLines();
            });
            return timeline;
        } else {
            return "There has been no content change";
        }
    }

    function checkType(file){
        var imageType = /image.*/;
        if (!file.type.match(imageType)) {
            Notify(wurafleet.toastType.Error, 'File is not an Image.');
        } else if (!file){
            Notify(wurafleet.toastType.Error, 'No Image selected');
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

    $('.amount').editable({
        allowClear: true,
        'mode': 'inline',
        placeholder: "Enter Valid Amount",
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
            settings.data = JSON.stringify({
                "request": value,
                "module": 'funds',
                "id": $(this).data('id')
            });
            wurafleet.temp = value;
            settings.url = window.location.protocol + '//' + window.location.hostname + '/setstatus';
            $.ajax(settings).done(function (response) {
                if (response.status.toLowerCase() === 'success') {
                    Notify(wurafleet.toastType.Success, 'Funds has been successfully added to ' + wurafleet.temp);
                    window.location.reload(true);
                }
            });
        }
    });

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
    
    var editable1 = $('.cardnumber').editable({
        'mode': 'inline',
        showbuttons: true,
        emptytext: "No Card has been registered",
        validate: function(value) {
            if($.trim(value) == '') {
                return 'This field is required';
            }
            settings.data = JSON.stringify({
                "request": value,
                "module": 'wallets',
                "id": $(this).data('id')
            });
            wurafleet.temp = $('.editable-input').find(':selected').text();
            settings.url = window.location.protocol + '//' + window.location.hostname + '/setstatus';
            $.ajax(settings).done(function (response) {
                if (response.status.toLowerCase() === 'success') {
                    Notify(wurafleet.toastType.Success, 'Card has been successfully changed to ' + wurafleet.temp);
                    window.location.reload(true);
                }
            });
        }
    });
    
    $(window).bind("load resize", 
        function() {
            topOffset = 50;
            width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
            if (width < 768) {
                $('nav.navbar-collapse').addClass('collapse');
                topOffset = 100; // 2-row-menu
            } else {
                $('nav.navbar-collapse').removeClass('collapse');
            }

            height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
            height = height - topOffset;
            if (height < 1) height = 1;
            if (height > topOffset) {
                $("#wrapper").css("min-height", (height) + "px");
            }
        }
    );

    $(".datepicker").datepicker({
        format: "yyyy-mm-dd",
        weekStart: 0,
        todayBtn: "linked",
        calendarWeeks: true,
        autoclose: true,
        todayHighlight: true
    });

    $('.datepicker').on("keypress", 
        function () {
            return false;
        }
    );

    $('.clickable').on('click', 
        function() {
            var ctrlVal = $(this).data('val');
            var parent = $(this).data('parentctrl');

            $('#' + parent).val(ctrlVal);

            var element = $('.clickable').filter(function() {
                $(this).removeClass('btn-wura').removeClass('btn-primary').removeClass('btn-danger').removeClass('active');
            });

            if (ctrlVal === true) {
                $(this).addClass('btn-primary').addClass('active');
            } else {
                $(this).addClass('btn-danger').addClass('active');
            }
        }
    );

    $('.callback').on('click', 
        function() {
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
        }
    );

    $('#LogSearch').on('click', 
        function() {
            // Disable button.
            $(this).attr("disabled", "disabled");
            
            // get all option element values
            var _selectedValues = $('#auditsources option:selected').map(
                function(a, item){
                    return item.value;
                }
            ).get();

            // Perform a quick validation at the client side.
            if (_selectedValues.length === 0) {
                Notify(wurafleet.toastType.Info, "You are yet to select a valid audit Source.");
                return false;
            }

            if (wurafleet.auditstartdate === "") {
                Notify(wurafleet.toastType.Info, "You are yet to select a valid Audit Start Date.");
                return false;
            }

            if (wurafleet.auditenddate === "") {
                Notify(wurafleet.toastType.Info, "You are yet to select a valid Audit End Date.");
                return false;
            }

            // Validation passed. Kindly post to the server.
            settings.data = JSON.stringify(
                {
                    "audit_enddate": wurafleet.auditenddate,
                    "audit_source": _selectedValues.join(","),
                    "audit_startdate": wurafleet.auditstartdate
                }
            );
            settings.url = window.location.protocol + '//' + window.location.hostname + '/getlogs';
        
            $.ajax(settings).done(function (response) {
                if (response.status.toLowerCase() === 'success') {
                    // Clear the contents of the timelineheader and timelinepanel.
                    $('#timelinepanel').empty();
                    $('#timelineheader').empty();
                    
                    $.each(response.data, function(TabText, JsonObject) {
                        $('#timelineheader').append('<li role="presentation"><a href="#' + TabText + '" aria-controls="' + TabText + '" role="tab" data-toggle="tab">' + TabText + '</a></li>');
                        $('#timelinepanel').append('<div role="tabpanel" class="tab-pane active" id="' + TabText + '">' + PopulatePanel(TabText, JsonObject) + '</div>');
                    });

                    $('#timelineheader').removeAttr("style");
                    $('#timelineheader a:first').tab('show');

                    // Enable button.
                    $('#LogSearch').removeAttr("disabled");
                    Notify(wurafleet.toastType.Success, 'Request has been processed successfully!');                
                }
            });
        }
    );
 
    $('#butDriver').on('click', 
        function() {
            if ($('#passpic').get(0).files.length === 0) {
                Notify(wurafleet.toastType.Error, "No Passport Picture Selected.");
                return false;
            }

            if ($('#StaffID').get(0).files.length === 0) {
                Notify(wurafleet.toastType.Error, "No valid means of Identification provided.");
                return false;
            }

            $('#' + $(this).data('parentform')).validate();
        }
    );

    $('.submitForm').on('click', 
        function() {
            var errorList = '<ol>';
            var parentForm = $('#' + $(this).data('parentform'))[0];

            if ($('#walletname').val() === "") {
                errorList += '<li>Please enter a valid Wallet Name.</li>';
            }

            if ($('#oncard').val() === "null" || $('#oncard').val() === null) {
                errorList += '<li>Kindly setup a new Card.</li>';
            }

            if ($('#amount').val() === "") {
                errorList += '<li>Please enter a Valid Amount.</li>';
            }

            if ($('#status').val() === "") {
                errorList += '<li>Please indicate if you will like to activate the wallet or not.</li>';
            }
            errorList += '</ol>';

            if (errorList !== "<ol></ol>") {
                Notify(wurafleet.toastType.Error, '<strong>' + errorList + '<li>Kindly fix the errors and try creating the wallet again.</li></strong>');
                e.preventDefault();
                return false;
            }
            else {
                $(parentForm).submit();
            }
        }
    );

    $('input[type=file]').change(
        function() {
            readURL(this);
        }
    );
    
    $('#sidebarCollapse').on('click', 
        function () {
            $('#sidebar').toggleClass('active');
        }
    );

    $(".modal").on('hidden.bs.modal', 
        function () {
            var modal = $(this);
            
            // Clear all inputs of their values
            $(this)
                .find("input,textarea,hidden")
                .val('')
                .end()
                .find("input[type=checkbox], input[type=radio]")
                .prop("checked", "")
                .end();
        }
    );

    $('#messageview').on('show.bs.modal', 
        function (event) {
            // Button that triggered the modal
            var button = $(event.relatedTarget);

            // Disable button.
            $(button).attr("disabled", "disabled");

            // Update the modal's content.
            var modal = $(this);

            settings.data = JSON.stringify(
                {
                    "id": button.data('id')
                }
            );
            settings.url = window.location.protocol + '//' + window.location.hostname + '/getMessage';
        
            $.ajax(settings).done(function (response) {
                if (response.status.toLowerCase() === 'success') {
                    $('.modal-body').html(response.data);
                    $('.modal-title').html(response.title);

                    // Enable button.
                    $('.msgbutton[data-id="' + response.id + '"]').removeAttr("disabled");
                    Notify(wurafleet.toastType.Success, 'Request has been processed successfully!');                
                }
            });
        }
    );

    $('.components a, .components li').on('mouseover', 
        function() {
            if ($('#sidebar').hasClass('active') === false) {
                return false;
            }

            if ($(this).children() === undefined || $(this).children()[1] === undefined) {
                return false;
            }

            // Remove classes from other buttons, put on new active one
            $($('.components li').children()).removeClass('in');
            $($('.components li').children()).attr('aria-expanded', false);

            // Add required class for li element and set the aria-expanded attribute
            $($(this).children()[1]).addClass('in');
            $($(this).children()[0]).attr('aria-expanded', true);
        }
    );

    $('.filter').on('click',
        function() {
            var checked = $(this).prop('checked');
            if (this.value == 0 && checked == true) {
                $('.filter').each(function() { 
                    this.checked = !checked; 
                });
                this.checked = checked;
            } else {
                $('input:checkbox[value="0"]').prop('checked', false);
            }
        }
    );

    $('#searchButton').on('click', 
        function() {
            var form = $("#searchForm");
            form.validate();

            if (form.valid()) {
                $(form).submit();
            }
        }
    );

    $('.driverEdit').on('click', 
        function() {
            var recordId = $(this).data('id');
            $.getJSON(window.location.protocol + '//' + window.location.hostname + '/getDriverInfo/' + recordId, {id:recordId}, 
                function(data) {
                    if (data.status.toLowerCase() === 'success') {
                        $('#id').val(data.driverInfo.id);
                        $("#email").val(data.driverInfo.email);
                        $('#idnumber').val(data.driverInfo.idnumber);
                        $("#lastname").val(data.driverInfo.lastname);
                        $('#mobile').val(data.driverInfo.mobilenumber);
                        $('#firstname').val(data.driverInfo.firstname);
                        switch(data.driverInfo.status.toLowerCase()) {
                            case 'activate':
                                //$('#statusButton').html('Suspend');
                                $('#driverStatus').html('Current Status: Activated');
                            break;

                            default:
                                //$('#statusButton').html('Activate');
                                $('#driverStatus').html('Current Status: Suspended');
                        }
                        $('#middlename').val(data.driverInfo.middlename);
                        $("#dateofbirth").val(moment(data.driverInfo.dateofbirth).format('D-MM-YYYY'));
                        $("#ImgPreview").attr("src", data.driverInfo.passportpath.replace('public', '/storage'));
                        $("#IDPreview").attr("src", data.driverInfo.identificationpath.replace('public', '/storage'));
                        $('#driverEditModal').modal('show');
                    }
                }
            );
        }
    );

    $('#updateDriver').on('click', 
        function() {
            // if ($('#ImgPreview').get(0).files.length === 0) {
            //     Notify(wurafleet.toastType.Error, "No Passport Picture Selected.");
            //     return false;
            // }

            // if ($('#IDPreview').get(0).files.length === 0) {
            //     Notify(wurafleet.toastType.Error, "No valid means of Identification provided.");
            //     return false;
            // }

            var form = $("#driverform");
            form.validate();

            if (form.valid()) {
                $(form).submit();
            }
        }
    );
    // Initially disable the button
    $("#ContinueButton").attr("disabled", "disabled");
 
    // Map the function below to the scroll event of our Terms DIV
    $("#Terms").scroll(
        function() {
         if ($("#Terms").AtEnd()) {
              // Enable the button once we reach the end of the DIV
              $("#ContinueButton").removeAttr("disabled");
         }
        }
    );
});

$.fn.AtEnd = function() {
    return this[0].scrollTop + this.height() >= this[0].scrollHeight;
};
