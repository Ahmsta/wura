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
            
            if ($data >= 1) {
                $user = Auth::user();
                if (array_key_exists('assignedto', $recordset) && $recordset->assignedto >= 1) {

                    if (!empty($oldcarduser)) {
                        $recordset = DB::table('drivers')->where('id', $oldcarduser->assignedto)->first();

                        // Notify the former holder / user of the card that access has been revoked.
                        $title = "Your access to card " . $oldcarduser->cardnos . " has been deactivated.";
                        $greeting= $recordset->firstname . ' ' . $recordset->middlename . ' ' . $recordset->lastname;
                        $drivermsg = "We write to officially notify you that your access to card " . $oldcarduser->cardnos . " has been deactivated.";
                        $drivermsg .= '<br /><br />
                            <p style="background-color:#ea3a52; border-top-left-radius:5px; border-bottom-left-radius:5px; border-top-right-radius:5px; border-bottom-right-radius:5px; background-clip: padding-box; font-size:17px; font-family: Helvetica, Arial, sans-serif; text-align:center; color:#ffffff; font-weight: bold; letter-spacing: 1px; padding-left:42px; padding-right:42px;">
                                <span style="color: #ffffff; font-size:17px;">
                                    <a style="color: #ffffff; text-align:center;text-decoration: none;" href="#">Please do not attempt to use this card again as it is highly illegeal.</a>
                                </span>
                            </p>';
                        Mail::to($recordset->email)->send(new Notifications($title, $drivermsg, $greeting));
                    }

                    // Notify the new holder / user of the card of the status change.
                    $carduser = Cards::find($recordid);
                    $recordset = DB::table('drivers')->where('id', $carduser->assignedto)->first();

                    // Notify the former holder / user of the card that access has been revoked.
                    $title = "Your access to card ". $oldcarduser->cardnos . ' has been ' . str_replace('eed', 'ed', $recordset->status . 'ed');
                    $greeting= $recordset->firstname . ' ' . $recordset->middlename . ' ' . $recordset->lastname;
                    $drivermsg = "We write to officially notify you that your access to card " . $oldcarduser->cardnos . ' has been ' . str_replace('eed', 'ed', $recordset->status . 'ed');
                    Mail::to($recordset->email)->send(new Notifications($title, $drivermsg, $greeting));
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
