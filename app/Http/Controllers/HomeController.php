<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Cards;
use App\Mail\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    protected $tag = 'Home Controller :: ';

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function setstatus(Request $request) {
        
        // Activate, suspend, cancel
        if ($request->isMethod('post')) {

            $data = 0;
            $recordset = null;
            $oldcarduser = null;
            $recordid = $request->input('id');
            $updatefield = $request->input('request');
            $actonmodule = $request->input('module');

            switch (strtolower($actonmodule)) {
                case 'drivers':
                    $data = DB::table('drivers')
                        ->where('id', $recordid)
                        ->update(['status' => $updatefield]);
                    $recordset = DB::table('drivers')->where('id', $recordid)->first();
                    break;

                case 'cards':
                    $data = DB::table('cards')
                        ->where('id', $recordid)
                        ->update(['status' => $updatefield]);
                    $recordset = DB::table('cards')->where('id', $recordid)->first();
                    break;

                case 'cardowner':
                    $oldcarduser = Cards::find($recordid);
                    $data = DB::table('cards')
                        ->where('id', $recordid)
                        ->update(['assignedto' => $updatefield]);
                    $recordset = DB::table('cards')->where('id', $recordid)->first();
                    break;
            }
            
            // $book = new stdClass;
            // $book->title = "Harry Potter and the Prisoner of Azkaban";
            // $book->author = "J. K. Rowling";
            // $book->publisher = "Arthur A. Levine Books";
            // $book->amazon_link = "http://www.amazon.com/dp/0439136369/";

            if ($data >= 1) {

                $user = Auth::user();
                if (array_key_exists('assignedto', $recordset) && $recordset->assignedto >= 1) {

                    if ($oldcarduser = null) {
                        // Notify the former holder / user of the card that access has been revoked
                        // $oldcarduser

                        // 'title' => $manager,
                        //     'message' => $password,                        
                        //     'greeting' => $greeting,
                    }

                    // Notify the new holder / user of the card of the status change.
                    log::info($actonmodule . ' === ' . $recordset->assignedto); 

                    $carduser = Cards::find($recordid);
                    // $card['Fullname'] = $carduser->cardUser[0]['firstname'] . ' ' . $carduser->cardUser[0]['middlename'] . ' ' . $carduser->cardUser[0]['lastname'];
                } else {
                    // A driver's status was just modified. Duly notify the Driver.
                    $title = "Your account has been " . str_replace('eed', 'ed', $recordset->status . 'ed');
                    $greeting= $recordset->firstname . ' ' . $recordset->middlename . ' ' . $recordset->lastname;
                    $drivermsg = "We write to officially notify you that your account has been " . str_replace('eed', 'ed', $recordset->status . 'ed') . ".";
                    Mail::to($recordset->email)->send(new Notifications($title, $drivermsg, $greeting));
                }

                return response()->json([
                    'id' => $recordid,
                    'status' => 'success',
                    'old_status' => $updatefield
                ]);
            } else {
                return response()->json([
                    'status' => 'error'
                ]);
            }
        }
    }

    /**
     * Get all drivers that belong to the currently logged in user.
    */
    public function getdrivers() {
        $users = DB::table('drivers')
                    ->selectRaw('id as value, firstname || \' \' || middlename || \' \' || lastname as text')
                    ->where('belongsTo', Auth::id())
                    ->get();

        return response()->json($users);
    }
}
