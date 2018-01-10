!function($) {
    "use strict";

    var CalendarApp = function() {
        this.$body = $("body")
        this.$modal = $('#my-event'),
        this.$calendar = $('#calendar'),
        this.$extEvents = $('#calendar-events'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$categoryForm = $('#add-new-event form'),
        this.$event = ('#calendar-events div.calendar-events'),
        this.$calendarObj = null
    };

    /* on drop */
    CalendarApp.prototype.onDrop = function (eventObj, date) { 
        var $this = this;
            // retrieve the dropped element's stored Event Object
            var originalEventObject = eventObj.data('eventObject');
            var $categoryClass = eventObj.attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
            // render the event on the calendar
            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                eventObj.remove();
            }
    },

    /* on click on event for either Editing or deletion. */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
        var $this = this;
        var form = $("<form></form>");
        form.append("<label>Change event name</label>");
        form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>");
        $this.$modal.modal({
            backdrop: 'static'
        });
        $this.$modal.find('.modal-title').html('<strong>Update Event for ' + calEvent.start.format('Do of MMM, YYYY') + '.</strong>');
        $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
        $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
            if (ev._id === calEvent._id) {
                settings.method = 'DELETE';
                settings.data = JSON.stringify({
                    url: '',
                    allDay: false,
                    id: calEvent.id,
                    end: calEvent.end,
                    title: calEvent.title,
                    start: calEvent.start,
                    classname: calEvent.classname
                });
                settings.url = window.location.protocol + '//' + window.location.hostname + '/deleteEvent';
                $this.notifyServer();
            }
            return (ev._id == calEvent._id);
        });
        $this.$modal.modal('hide');
        });
        $this.$modal.find('form').on('submit', function (e) {
            calEvent.title = form.find("input[type=text]").val();
            $this.$calendarObj.fullCalendar('updateEvent', calEvent);
            settings.method = 'PUT';
            settings.data = JSON.stringify({
                url: '',
                id: calEvent.id,
                end: calEvent.end,
                title: calEvent.title,
                start: calEvent.start,
                allDay: calEvent.allDay,
                classname: calEvent.classname
            });
            settings.url = window.location.protocol + '//' + window.location.hostname + '/updateEvent';
            $this.notifyServer();
            $this.$modal.modal('hide');
            return false;
        });
    },

    /* on select for new Event */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
        var $this = this;
        $this.$modal.modal({
            backdrop: 'static'
        });
        var form = $("<form></form>");
        form.append("<div class='row'></div>");
        form.find(".row")
            .append("<div class='row'>")
            .append("<div class='col-md-12'><div class='form-group'><label class='control-label pull-left'>Event Name</label><input class='form-control' placeholder='Insert Event Name' type='text' name='title'/></div></div></div>")
            .append("<div class='row'>")
            .append("<div class='col-md-12'><div class='form-group'><label class='control-label pull-left'>Category</label><select class='form-control' name='category'></select></div></div></div>")
            .find("select[name='category']")
            .append("<option value='bg-danger'>Danger</option>")
            .append("<option value='bg-success'>Success</option>")
            .append("<option value='bg-purple'>Purple</option>")
            .append("<option value='bg-primary'>Primary</option>")
            .append("<option value='bg-pink'>Pink</option>")
            .append("<option value='bg-info'>Info</option>")
            .append("<option value='bg-warning'>Warning</option></div></div>");

        $this.$modal.find('.modal-title').html('<strong>Register Event for ' + start.format('Do of MMM, YYYY') + '.</strong>');
        $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
            form.submit();
        });
        $this.$modal.find('form').on('submit', function () {
            var title = form.find("input[name='title']").val();
            var beginning = form.find("input[name='beginning']").val();
            var ending = form.find("input[name='ending']").val();
            var categoryClass = form.find("select[name='category'] option:checked").val();
            if (title !== null && title.length != 0) {
                $this.$calendarObj.fullCalendar('renderEvent', {
                    title: title,
                    start:start,
                    end: end,
                    allDay: false,
                    className: categoryClass
                }, true);
                settings.method = 'POST';
                settings.data = JSON.stringify({
                    url: '',
                    end: end,
                    start:start,
                    title: title,
                    allDay: false,
                    classname: categoryClass
                });
                settings.url = window.location.protocol + '//' + window.location.hostname + '/newEvent';
                $this.notifyServer();
                $this.$modal.modal('hide');
            }
            else{
                Notify(wurafleet.toastType.Error, 'You have to give a title to your event');
            }
            return false;
            
        });
        $this.$calendarObj.fullCalendar('unselect');
    },

    CalendarApp.prototype.enableDrag = function() {
        //init events
        $(this.$event).each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
    }

    CalendarApp.prototype.notifyServer = function() {
        // Post back to server title, allDay, start, end, url, classname
        $.ajaxSetup({
            headers:
            { 
                "cache-control": "no-cache",
                "content-type": "application/json",
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax(settings)
            .fail(function(jqXHR, textStatus) {
                Notify(wurafleet.toastType.Error, 'Request Failed: ' + textStatus + '. Server responsed with ' + jqXHR.responseText);
            })
            .done(function (response) {
                if (response.status.toLowerCase() === 'success') {
                    Notify(wurafleet.toastType.Success, 'Event has been successfully registered.');
                }
            }
        );
    }

    /* Initializing */
    CalendarApp.prototype.init = function() {
        this.enableDrag();

        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';

        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:15:00', /* If we want to split day time each 15minutes */
            minTime: '08:00:00',
            maxTime: '19:00:00',  
            defaultView: 'month',  
            handleWindowResize: true,
            header: {
                left: 'prevYear,prev,next,nextYear today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek '
            },
            events: '/mycalendarevents',
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            weekNumbers: true,
            themeSystem: 'bootstrap3',
            drop: function(date) { $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); }
        });
    },

    // Init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);

