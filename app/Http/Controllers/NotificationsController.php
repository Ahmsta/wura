<?php

namespace App\Http\Controllers;

use Auth;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function calendar()
    {
        $drivers = User::find(Auth::id());
        return view('mydrivers', ['drivers' => $drivers->Drivers]);
    }
}