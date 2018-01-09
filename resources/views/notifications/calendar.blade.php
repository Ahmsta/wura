@extends('layouts.wura')
@section('page_heading','Calendar Events')

@section('styles')
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- <link href="{{ asset('css/fullcalendar.print.min.css') }}" rel="stylesheet" type="text/css" /> -->
    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }

        .fc-view-container {
            background-color: #fff;
        }

        .fc-day-header {
            color: #000;
        }
    </style>
@stop

@section('content')
    <br/>

    <div id='calendar'></div>

    <div class="modal none-border" id="my-event">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-wura save-event">Create event</button>
                    <button type="button" class="btn btn-danger delete-event" data-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-white waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/fullcalendar.min.js') }}"></script>
    <script>
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

            /* on click on event */
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
                            // Post back to server
                            alert('POSTBACK');
                            return (ev._id == calEvent._id);
                        });
                        $this.$modal.modal('hide');
                    });
                    $this.$modal.find('form').on('submit', function () {
                        // Post back to server
                        alert('POSTBACK');
                        calEvent.title = form.find("input[type=text]").val();
                        $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                        $this.$modal.modal('hide');
                        return false;
                    });
            },

            /* on select */
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
                        // Post back to server
                        alert('POSTBACK');
                        $this.$modal.modal('hide');
                    }
                    else{
                        alert('You have to give a title to your event');
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
            /* Initializing */
            CalendarApp.prototype.init = function() {
                this.enableDrag();

                /*  Initialize the calendar  */
                var date = new Date();
                var d = date.getDate();
                var m = date.getMonth();
                var y = date.getFullYear();
                var form = '';
                var today = new Date($.now());
                var todayDate = moment().startOf('day');
                var YM = todayDate.format('YYYY-MM');
                var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

                var $this = this;
                var defaultEvents =  [
                    {
                        title: 'Released Ample Admin!',
                        start: new Date($.now() + 506800000),
                        className: 'bg-info'
                    }, {
                        title: 'This is today check date',
                        start: today,
                        end: today,
                        className: 'bg-danger'
                    }, {
                        title: 'This is your birthday',
                        start: new Date($.now() + 848000000),
                        className: 'bg-info'
                    },{
                        title: 'your meeting with john',
                        start: new Date($.now() - 1099000000),
                        end:  new Date($.now() - 919000000),
                        className: 'bg-warning'
                    },{
                        title: 'your meeting with john',
                        start: new Date($.now() - 1199000000),
                        end: new Date($.now() - 1199000000),
                        className: 'bg-purple'
                    },{
                        title: 'your meeting with john',
                        start: new Date($.now() - 399000000),
                        end: new Date($.now() - 219000000),
                        className: 'bg-info'
                    },{
                        title: 'Hanns birthday',
                        start: new Date($.now() + 868000000),
                        className: 'bg-danger'
                    },{
                        title: 'Like it?',
                        start: new Date($.now() + 348000000),
                        className: 'bg-success'
                    },{
                        title: 'All Day Event',
                        start: YM + '-01'
                    },{
                        title: 'Long Event',
                        start: YM + '-07',
                        end: YM + '-10'
                    },{
                        id: 999,
                        title: 'Repeating Event',
                        start: YM + '-09T16:00:00'
                    },{
                        id: 999,
                        title: 'Repeating Event',
                        start: YM + '-16T16:00:00'
                    },{
                        title: 'Conference',
                        start: YESTERDAY,
                        end: TOMORROW
                    },{
                        title: 'Meeting',
                        start: TODAY + 'T10:30:00',
                        end: TODAY + 'T12:30:00'
                    },{
                        title: 'Lunch',
                        start: TODAY + 'T12:00:00'
                    },{
                        title: 'Meeting',
                        start: TODAY + 'T14:30:00'
                    },{
                        title: 'Happy Hour',
                        start: TODAY + 'T17:30:00'
                    },{
                        title: 'Dinner',
                        start: TODAY + 'T20:00:00'
                    },{
                        title: 'Birthday Party',
                        start: TOMORROW + 'T07:00:00'
                    },{
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: YM + '-28'
                    }];

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
                    events: defaultEvents,
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

                //on new event
                this.$saveCategoryBtn.on('click', function(){
                    var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
                    var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
                    if (categoryName !== null && categoryName.length != 0) {
                        $this.$extEvents.append('<div class="calendar-events bg-' + categoryColor + '" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-move"></i>' + categoryName + '</div>')
                        $this.enableDrag();
                    }

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

    </script>
@stop