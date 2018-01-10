@extends('layouts.wura')
@section('page_heading','Calendar Events')

@section('styles')
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
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
    <script type="text/javascript" src="{{ asset('js/mycalendar.js') }}"></script>
@stop