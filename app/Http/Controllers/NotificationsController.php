<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationsController extends Controller
{
    protected $tag = 'Notifications :: ';

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function messages() {
        $notifications = Notifications::where('owner_id', Auth::id())->get();
        return view("notifications.messages", ['notifications' => $notifications]);
    }

    public function getMessage(Request $request) {
        if ($request->isMethod('post')) {
            $recordid = $request->input('id');
            $recordset =  Notifications::find($recordid);
            $message = $recordset->data;
            $title = "Viewing Message sent to <br /> " . $recordset->recipient . " on " . Carbon::parse($recordset->read_at)->toFormattedDateString();

            return response()->json([
                'id' => $recordid,
                'title' => $title,
                'data' => $message,
                'status' => 'success'
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function calendar()
    {
        return view('notifications.calendar');
    }

    public function mycalendarevents(Request $request) {
        $calendarEntry =  new \App\Models\Calendars();
        $calendarEntry = $calendarEntry
            ->where('owner', Auth::id())
            ->where('start', '>=', $request->input('start'))
            ->where('end', '<=', $request->input('end'))
            ->get();
        return response()->json($calendarEntry);
    }

    public function newEvent(Request $request) {
        if ($request->isMethod('post')) {
            $calendarEntry = new \App\Models\Calendars();
            $calendarEntry->owner = Auth::id();
            $calendarEntry->url = $request->input('url');
            $calendarEntry->end = $request->input('end');
            $calendarEntry->start = $request->input('start');
            $calendarEntry->title = $request->input('title');
            $calendarEntry->allDay = $request->input('allDay');
            $calendarEntry->classname = $request->input('classname');
            $data = $calendarEntry->save();

            if ($data == true) {
                return response()->json([
                    'status' => 'success',
                    'data' => $calendarEntry
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'error' => [
                        'message' => 'An error occurred while trying to save the record.',
                        'exception' => 'Unknown Error. Please try again later. Thank You.'
                    ]
                ], 500);
                log::error('newEvent Error = ' . json_encode($request->all()));
            }
        }
    }

    public function updateEvent(Request $request) {
        if ($request->isMethod('put')) {
            $recordid = $request->input('id');

            $calendarEntry = \App\Models\Calendars::find($recordid);
            $calendarEntry->owner = Auth::id();
            $calendarEntry->url = $request->input('url');
            $calendarEntry->end = $request->input('end');
            $calendarEntry->start = $request->input('start');
            $calendarEntry->title = $request->input('title');
            $calendarEntry->allDay = $request->input('allDay');
            $calendarEntry->classname = $request->input('classname');
            $data = $calendarEntry->save();

            if ($data == true) {
                return response()->json([
                    'status' => 'success',
                    'data' => $calendarEntry
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'error' => [
                        'message' => 'An error occurred while trying to modify the record.',
                        'exception' => 'Unknown Error. Please try again later. Thank You.'
                    ]
                ], 500);
                log::error('updateEvent Error = ' . json_encode($request->all()));
            }
        }
    }

    public function deleteEvent(Request $request) {
        if ($request->isMethod('delete')) {
            $recordid = $request->input('id');
            $calendarEntry = \App\Models\Calendars::find($recordid);
            $data = $calendarEntry->delete();
           
            if ($data == true) {
                return response()->json([
                    'status' => 'success',
                    'data' => $calendarEntry
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'error' => [
                        'message' => 'An error occurred while trying to save the record.',
                        'exception' => 'Unknown Error. Please try again later. Thank You.'
                    ]
                ], 500);
                log::error('deleteEvent Error = ' . json_encode($request->all()));
            }
        }
    }
}