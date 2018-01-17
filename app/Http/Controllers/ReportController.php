<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected $tag = 'Reports :: ';

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function drivers()
    {
        $recordset = \App\Models\Drivers::where("belongsTo", Auth::id())
                                        ->whereNull('deleted_at')
                                        ->get();
        return view('reports.driversreport', ['drivers' => $recordset]);
    }

    public function driverdetails(Request $request)
    {
        $recordid = $request->input('id');
        $recordset = \App\Models\Drivers::find($recordid);

        $cards = \App\Models\Cards::where("assignedto", $recordid)->get();
        return view('reports.driverdetails', ['driver' => $recordset, 'cards' => $cards]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function cards()
    {
        return view('reports.cardsreport');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function expired()
    {
        return view('reports.expiredreport');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function info()
    {
        return view('reports.cardsinfo');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function walletsummary()
    {
        return view('reports.walletsummary');
    }
    // driverdetails, carddetails
}