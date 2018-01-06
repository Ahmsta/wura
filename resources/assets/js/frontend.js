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
    auditenddate: '',
    auditstartdate: '',
    toastType : {
        Info: 'info',
        Error: 'error',
        Success: 'success',
        Warning: 'warning'
    },
    toastTitle: 'Wurafleet Notification Service'
};

var eventsMinDistance = 60;

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
    SetDateControl();
    Convert2DataTable();

    function SetActive() {
        var url = window.location;
        var element = $('li a').filter(function() {
            return this.href == url || url.href.indexOf(this.href) == 0;
        });
    
        element.addClass('linkactive').parent().parent().addClass('in').parent();
        if (element.is('li')) {
            element.addClass('linkactive');
        }
    }

    function SetTimeLines() {
        // Horizontal Timeline.
        var timelines = $('.cd-horizontal-timeline'), eventsMinDistance;
        (timelines.length > 0) && initTimeline(timelines);

        // var timelineBlocks = $('.cd-timeline-block'),
		// offset = 0.8;

        // //hide timeline blocks which are outside the viewport
        // hideBlocks(timelineBlocks, offset);

        // //on scolling, show/animate timeline blocks when enter the viewport
        // $(window).on('scroll', function(){
        //     (!window.requestAnimationFrame) 
        //         ? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
        //         : window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
        // });

        // function hideBlocks(blocks, offset) {
        //     blocks.each(function(){
        //         ( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
        //     });
        // }

        // function showBlocks(blocks, offset) {
        //     blocks.each(function(){
        //         ( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
        //     });
        // }
    }

    function SetDateControl() {
        var start = moment().subtract(29, 'days');
        var end = moment();
    
        function cb(start, end) {
            wurafleet.auditenddate = end.format('YYYY-MM-DD');
            wurafleet.auditstartdate = start.format('YYYY-MM-DD');

            $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
    
        $('#daterange').daterangepicker({
            showWeekNumbers: true,
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);
    
        cb(start, end);

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            wurafleet.auditenddate = picker.endDate.format('YYYY-MM-DD');
            wurafleet.auditstartdate = picker.startDate.format('YYYY-MM-DD');
        });

        $('.multiselect').multiselect({
            numberDisplayed: 6,
            disableIfEmpty: true,
            includeSelectAllOption: true,
            //disabledText: 'Disabled ...',
            buttonClass: 'btn btn-primary',
            nonSelectedText: 'Select Audit source(s)!',
            checkboxName: function(option) {
                return 'multiselect[]';
            }
        });
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
        let imageType = /image.*/;
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

    function Notify(toastType, toastMessage) {
        toastr[toastType](toastMessage, wurafleet.toastTitle);
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
    
    var editable = $('.cardnumber').editable({
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

    $(window).bind("load resize", function() {
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
    });

    $('.clickable').on('click', function() {
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
            console.log(response);
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

    $('#LogSearch').on('click', function() {
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
                $('#timelineheader a:first').tab('show')

                // Enable button.
                $('#LogSearch').removeAttr("disabled");
                Notify(wurafleet.toastType.Success, 'Request has been processed successfully!');                
            }
        });
    });
 
    $('#butDriver').on('click', function() {
        if ($('#passpic').get(0).files.length === 0) {
            Notify(wurafleet.toastType.Error, "No Passport Picture Selected.");
            return false;
        }

        if ($('#StaffID').get(0).files.length === 0) {
            Notify(wurafleet.toastType.Error, "No valid means of Identification provided.");
            return false;
        }

        $('#' + $(this).data('parentform')).validate();
    });

    $('.submitForm').on('click', function() {
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
    });

    $('input[type=file]').change(function() {
        readURL(this);
    });
    
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });

    $(".modal").on('hidden.bs.modal', function () {
        var modal = $(this);
        
        // Clear all inputs of their values
        $(this)
        .find("input,textarea,hidden")
           .val('')
           .end()
        .find("input[type=checkbox], input[type=radio]")
           .prop("checked", "")
           .end();
    });

    $('#messageview').on('show.bs.modal', function (event) {
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
    });

    // $('.components li, .components i').on('mouseout', function() {
    //     if ($('#sidebar').hasClass('active') === false) {
    //         return false;
    //     }
        
    //     if ($(this).children() === undefined || $(this).children()[1] === undefined) {
    //         return false;
    //     }
        
    //     $($(this).children()[1]).removeClass('in');
    //     $($(this).children()[0]).attr('aria-expanded', false);
    // });

    // $('.components li, .components i').on('mouseover', function() {
    //     if ($('#sidebar').hasClass('active') === false) {
    //         return false;
    //     }

    //     if ($(this).children() === undefined || $(this).children()[1] === undefined) {
    //         return false;
    //     }

    //     $($(this).children()[1]).addClass('in');
    //     $($(this).children()[0]).attr('aria-expanded', true);
    // });

    // Initially disable the button
    $("#ContinueButton").attr("disabled", "disabled");
 
    // Map the function below to the scroll event of our Terms DIV
    $("#Terms").scroll(function() {
         if ($("#Terms").AtEnd()) {
              // Enable the button once we reach the end of the DIV
              $("#ContinueButton").removeAttr("disabled");
         }
    });

    function initTimeline(timelines) {
        timelines.each(function(){
            var timeline = $(this),
                timelineComponents = {};
            // cache timeline components 
            timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
            timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.events');
            timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.filling-line');
            timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
            timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
            timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
            timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
            timelineComponents['eventsContent'] = timeline.children('.events-content');

            //assign a left postion to the single events along the timeline
            setDatePosition(timelineComponents, eventsMinDistance);

            //assign a width to the timeline
            var timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);
            
            //the timeline has been initialize - show it
            timeline.addClass('loaded');

            //detect click on the next arrow
            timelineComponents['timelineNavigation'].on('click', '.next', function(event){
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'next');
            });
            //detect click on the prev arrow
            timelineComponents['timelineNavigation'].on('click', '.prev', function(event){
                event.preventDefault();
                updateSlide(timelineComponents, timelineTotWidth, 'prev');
            });
            //detect click on the a single event - show new event content
            timelineComponents['eventsWrapper'].on('click', 'a', function(event){
                event.preventDefault();
                timelineComponents['timelineEvents'].removeClass('selected');
                $(this).addClass('selected');
                updateOlderEvents($(this));
                updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
                updateVisibleContent($(this), timelineComponents['eventsContent']);
            });

            //on swipe, show next/prev event content
            timelineComponents['eventsContent'].on('swipeleft', function(){
                var mq = checkMQ();
                ( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'next');
            });
            timelineComponents['eventsContent'].on('swiperight', function(){
                var mq = checkMQ();
                ( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'prev');
            });

            //keyboard navigation
            $(document).keyup(function(event){
                if(event.which=='37' && elementInViewport(timeline.get(0)) ) {
                    showNewContent(timelineComponents, timelineTotWidth, 'prev');
                } else if( event.which=='39' && elementInViewport(timeline.get(0))) {
                    showNewContent(timelineComponents, timelineTotWidth, 'next');
                }
            });
        });
    }

    function updateSlide(timelineComponents, timelineTotWidth, string) {
        //retrieve translateX value of timelineComponents['eventsWrapper']
        var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
            wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
        //translate the timeline to the left('next')/right('prev') 
        (string == 'next') 
            ? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
            : translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
    }

    function showNewContent(timelineComponents, timelineTotWidth, string) {
        //go from one event to the next/previous one
        var visibleContent =  timelineComponents['eventsContent'].find('.selected'),
            newContent = ( string == 'next' ) ? visibleContent.next() : visibleContent.prev();

        if ( newContent.length > 0 ) { //if there's a next/prev event - show it
            var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
                newEvent = ( string == 'next' ) ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');
            
            updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
            updateVisibleContent(newEvent, timelineComponents['eventsContent']);
            newEvent.addClass('selected');
            selectedDate.removeClass('selected');
            updateOlderEvents(newEvent);
            updateTimelinePosition(string, newEvent, timelineComponents);
        }
    }

    function updateTimelinePosition(string, event, timelineComponents) {
        //translate timeline to the left/right according to the position of the selected event
        var eventStyle = window.getComputedStyle(event.get(0), null),
            eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
            timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
            timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
        var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

        if( (string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < - timelineTranslate) ) {
            translateTimeline(timelineComponents, - eventLeft + timelineWidth/2, timelineWidth - timelineTotWidth);
        }
    }

    function translateTimeline(timelineComponents, value, totWidth) {
        var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
        value = (value > 0) ? 0 : value; //only negative translate value
        value = ( !(typeof totWidth === 'undefined') &&  value < totWidth ) ? totWidth : value; //do not translate more than timeline width
        setTransformValue(eventsWrapper, 'translateX', value+'px');
        //update navigation arrows visibility
        (value == 0 ) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
        (value == totWidth ) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
    }

    function updateFilling(selectedEvent, filling, totWidth) {
        //change .filling-line length according to the selected event
        var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
            eventLeft = eventStyle.getPropertyValue("left"),
            eventWidth = eventStyle.getPropertyValue("width");
        eventLeft = Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', ''))/2;
        var scaleValue = eventLeft/totWidth;
        setTransformValue(filling.get(0), 'scaleX', scaleValue);
    }

    function setDatePosition(timelineComponents, min) {
        for (i = 0; i < timelineComponents['timelineDates'].length; i++) { 
            var distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][i]),
                distanceNorm = Math.round(distance/timelineComponents['eventsMinLapse']) + 2;
            timelineComponents['timelineEvents'].eq(i).css('left', distanceNorm*min+'px');
        }
    }

    function setTimelineWidth(timelineComponents, width) {
        var timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][timelineComponents['timelineDates'].length-1]),
            timeSpanNorm = timeSpan/timelineComponents['eventsMinLapse'],
            timeSpanNorm = Math.round(timeSpanNorm) + 4,
            totalWidth = timeSpanNorm*width;
        timelineComponents['eventsWrapper'].css('width', totalWidth+'px');
        updateFilling(timelineComponents['eventsWrapper'].find('a.selected'), timelineComponents['fillingLine'], totalWidth);
        updateTimelinePosition('next', timelineComponents['eventsWrapper'].find('a.selected'), timelineComponents);

        return totalWidth;
    }

    function updateVisibleContent(event, eventsContent) {
        var eventDate = event.data('date'),
            visibleContent = eventsContent.find('.selected'),
            selectedContent = eventsContent.find('[data-date="'+ eventDate +'"]'),
            selectedContentHeight = selectedContent.height();

        if (selectedContent.index() > visibleContent.index()) {
            var classEnetering = 'selected enter-right',
                classLeaving = 'leave-left';
        } else {
            var classEnetering = 'selected enter-left',
                classLeaving = 'leave-right';
        }

        selectedContent.attr('class', classEnetering);
        visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
            visibleContent.removeClass('leave-right leave-left');
            selectedContent.removeClass('enter-left enter-right');
        });
        eventsContent.css('height', selectedContentHeight+'px');
    }

    function updateOlderEvents(event) {
        event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
    }

    function getTranslateValue(timeline) {
        var timelineStyle = window.getComputedStyle(timeline.get(0), null),
            timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
                timelineStyle.getPropertyValue("-moz-transform") ||
                timelineStyle.getPropertyValue("-ms-transform") ||
                timelineStyle.getPropertyValue("-o-transform") ||
                timelineStyle.getPropertyValue("transform");

        if( timelineTranslate.indexOf('(') >=0 ) {
            var timelineTranslate = timelineTranslate.split('(')[1];
            timelineTranslate = timelineTranslate.split(')')[0];
            timelineTranslate = timelineTranslate.split(',');
            var translateValue = timelineTranslate[4];
        } else {
            var translateValue = 0;
        }

        return Number(translateValue);
    }

    function setTransformValue(element, property, value) {
        element.style["-webkit-transform"] = property+"("+value+")";
        element.style["-moz-transform"] = property+"("+value+")";
        element.style["-ms-transform"] = property+"("+value+")";
        element.style["-o-transform"] = property+"("+value+")";
        element.style["transform"] = property+"("+value+")";
    }

    //based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
    function parseDate(events) {
        var dateArrays = [];
        events.each(function(){
            var singleDate = $(this),
                dateComp = singleDate.data('date').split('T');
            if( dateComp.length > 1 ) { //both DD/MM/YEAR and time are provided
                var dayComp = dateComp[0].split('/'),
                    timeComp = dateComp[1].split(':');
            } else if( dateComp[0].indexOf(':') >=0 ) { //only time is provide
                var dayComp = ["2000", "0", "0"],
                    timeComp = dateComp[0].split(':');
            } else { //only DD/MM/YEAR
                var dayComp = dateComp[0].split('/'),
                    timeComp = ["0", "0"];
            }
            var	newDate = new Date(dayComp[2], dayComp[1]-1, dayComp[0], timeComp[0], timeComp[1]);
            dateArrays.push(newDate);
        });
        return dateArrays;
    }

    function daydiff(first, second) {
        return Math.round((second-first));
    }

    function minLapse(dates) {
        //determine the minimum distance among events
        var dateDistances = [];
        for (i = 1; i < dates.length; i++) { 
            var distance = daydiff(dates[i-1], dates[i]);
            dateDistances.push(distance);
        }
        return Math.min.apply(null, dateDistances);
    }

    /*
        How to tell if a DOM element is visible in the current viewport?
        http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
    */
    function elementInViewport(el) {
        var top = el.offsetTop;
        var left = el.offsetLeft;
        var width = el.offsetWidth;
        var height = el.offsetHeight;

        while(el.offsetParent) {
            el = el.offsetParent;
            top += el.offsetTop;
            left += el.offsetLeft;
        }

        return (
            top < (window.pageYOffset + window.innerHeight) &&
            left < (window.pageXOffset + window.innerWidth) &&
            (top + height) > window.pageYOffset &&
            (left + width) > window.pageXOffset
        );
    }

    function checkMQ() {
        //check if mobile or desktop device
        return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
    }
});

$.fn.AtEnd = function() {
    return this[0].scrollTop + this.height() >= this[0].scrollHeight;
};