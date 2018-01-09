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
}