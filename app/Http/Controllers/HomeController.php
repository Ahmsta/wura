<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\SMSHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        DB::table('cards')
            ->where('valid_until', '<', Carbon::now())
            ->update(['status' => 'Expired']);

        $allUsersCount = DB::select('SELECT public."dashboard_info"(' . Auth::id() . ')');
        $allUsersCount = explode(",", trim($allUsersCount[0]->dashboard_info, '()'));

        $dashboardinfo = array(
            "expiredcards" => $allUsersCount[4],
            "deletedcards" => $allUsersCount[5],
            "activecards" => $allUsersCount[2],
            "inactivedcards" => $allUsersCount[3],
            "activedrivers" => $allUsersCount[0],
            "inactivedrivers" => $allUsersCount[1],
            "pendingcardrequest" => $allUsersCount[6],
            "disputedcards" => $allUsersCount[7],
            "activewallets" => $allUsersCount[8],
            "inactivewallets" => $allUsersCount[9],
            "registeredvehicles" => $allUsersCount[10],
            "expireddocuments" => 0
        );
        return view('home', ['dashboardinfo' => (object) $dashboardinfo]);
    }

    public function setstatus(Request $request) {
        if ($request->isMethod('post')) {

            $data = 0;
            $recordset = null;
            $oldcarduser = null;
            $sms = new SMSHelper();
            $recordid = $request->input('id');
            $updatefield = $request->input('request');
            $actonmodule = $request->input('module');

            switch (strtolower($actonmodule)) {
                case 'drivers':
                    $recordset = \App\Models\Drivers::find($recordid);
                    $recordset->status = $updatefield;
                    $data = $recordset->save();
                    break;

                case 'cards':
                    $recordset = \App\Models\Cards::find($recordid);
                    $recordset->status = $updatefield;
                    $data = $recordset->save();
                    break;

                case 'cardowner':
                    $oldcarduser = \App\Models\Cards::find($recordid);
                    $recordset = \App\Models\Cards::find($recordid);
                    $recordset->assignedto = $updatefield;
                    $data = $recordset->save();                        
                    break;

                case 'wallets':
                    $recordset = \App\Models\Wallets::find($recordid);
                    $recordset->oncard = $updatefield;
                    $data = $recordset->save();                        
                    break;

                case 'walletstatus':
                    if ($updatefield == "Activate") {
                        $recordset = \App\Models\Wallets::find($recordid);
                        $recordset->status = true;
                        $data = $recordset->save();
                    } else {
                        $recordset = \App\Models\Wallets::find($recordid);
                        $recordset->status = false;
                        $data = $recordset->save();
                    }
                    break;

                case 'funds':
                    $recordset = \App\Models\Wallets::find($recordid);
                    $recordset->amount = $recordset->amount + $updatefield;
                    $data = $recordset->save();
                    break;
            }
            
            if ($data == true) {
                $user = Auth::user();

                if (isset($recordset['assignedto']) && $recordset->assignedto >= 1) {
                    if (!empty($oldcarduser)) {
                        $recordset = DB::table('drivers')->where('id', $oldcarduser->assignedto)->first();

                        // Notify the former holder / user of the card that access has been revoked.
                        $title = "Your access to card " . $oldcarduser->cardnos . " has been deactivated.";
                        $greeting = $recordset->firstname . ' ' . $recordset->middlename . ' ' . $recordset->lastname;
                        $drivermsg = "We write to officially notify you that your access to card " . $oldcarduser->cardnos . " has been deactivated.";
                        $drivermsg .= '<br /><br />
                            <p style="background-color:#ea3a52; border-top-left-radius:5px; border-bottom-left-radius:5px; border-top-right-radius:5px; border-bottom-right-radius:5px; background-clip: padding-box; font-size:17px; font-family: Helvetica, Arial, sans-serif; text-align:center; color:#ffffff; font-weight: bold; letter-spacing: 1px; padding-left:42px; padding-right:42px;">
                                <span style="color: #ffffff; font-size:17px;">
                                    <a style="color: #ffffff; text-align:center;text-decoration: none;" href="#">Please do not attempt to use this card again as it is highly illegeal.</a>
                                </span>
                            </p>';
                        $this->dispatch(new \App\Jobs\SendEmails($recordset->email, array('Action' => 'Notifications', 'Title' => $title, 'Message' => $drivermsg, 'Greeting' => $greeting)));
                        $sms->SendSMS($recordset->mobilenumber, 'Hello ' . $greeting . '. Your access to card [' . $oldcarduser->cardnos . '] has been deactivated on WURAFleet platform. Kindly contact your admin to address this issue if you feel uncomfortable. WURAfleet Team.', 'Card Suspension.');
                    }
                    // Notify the new holder / user of the card of the status change.
                    $carduser = \App\Models\Cards::find($recordid);
                    $recordset = DB::table('drivers')->where('id', $carduser->assignedto)->first();
                    $title = "Your access to card ". $carduser->cardnos . ' has been ' . str_replace( 'dd', 'd', str_replace('e', 'ed', $recordset->status)) . ".";
                    $greeting= $recordset->firstname . ' ' . $recordset->middlename . ' ' . $recordset->lastname;
                    $drivermsg = "We write to officially notify you that your access to card " . $carduser->cardnos . ' has been ' . str_replace( 'dd', 'd', str_replace('e', 'ed', $recordset->status)) . ".";
                    $this->dispatch(new \App\Jobs\SendEmails($recordset->email, array('Action' => 'Notifications', 'Title' => $title, 'Message' => $drivermsg, 'Greeting' => $greeting)));

                    switch(strtolower(str_replace( 'dd', 'd', str_replace('e', 'ed', $recordset->status)) . ".")) {
                        case 'activated':
                            $sms->SendSMS($recordset->mobilenumber, 'Hello ' . $greeting . '. Congratulations. Your access to card [' . $carduser->cardnos . '] have been activated for you, you are now at liberty to drive & refuel at any filling station. WURAfleet Team.', 'Card Activation.');
                            break;

                        case 'suspended':
                            $sms->SendSMS($recordset->mobilenumber, 'Hello ' . $greeting . '. Your access to card [' . $carduser->cardnos . '] has been deactivated on WURAFleet platform. Kindly contact your admin to address this issue if you feel uncomfortable. WURAfleet Team.', 'Card Suspension.');
                            break;
                    }
                } else if (strtolower($actonmodule) == 'drivers') {
                    // A driver's status was just modified. Duly notify the Driver.
                    $title = "Your account has been " . str_replace( 'dd', 'd', str_replace('e', 'ed', $recordset->status)) . ".";
                    $greeting = $recordset->firstname . ' ' . $recordset->middlename . ' ' . $recordset->lastname;
                    $drivermsg = "We write to officially notify you that your account has been " . str_replace( 'dd', 'd', str_replace('e', 'ed', $recordset->status)) . "." . ".";
                    $this->dispatch(new \App\Jobs\SendEmails($recordset->email, array('Action' => 'Notifications', 'Title' => $title, 'Message' => $drivermsg, 'Greeting' => $greeting)));

                    switch(strtolower(str_replace( 'dd', 'd', str_replace('e', 'ed', $recordset->status)) . ".")) {
                        case 'activated':
                            $sms->SendSMS($recordset->mobilenumber, 'Hello ' . $greeting . '. You have been activated by {“Name Of Company”} on WURAFleet platform. In order for you to be fully part of {“Name Of Company”}’s drivers, you are required to download your app from the wurafleet website. User Name: "' . $recordset->email . '", Password: "' . $recordset->email . '". WURAfleet Team.', 'Driver Activation.');
                            break;

                        case 'suspended':
                            $sms->SendSMS($recordset->mobilenumber, 'Hello ' . $greeting . '. You have been suspended by {“Name Of Company”} on WURAFleet platform. If you think this is a technical issue, kindly contact your admin to raise this issue. WURAfleet Team.', 'Driver Suspension.');
                            break;
                    }
                } else if (strtolower($actonmodule) == 'wallets') {
                    
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
                    ->where([
                        ['belongsTo', '=', Auth::id()],
                        ['status', '=', 'Activate']
                    ])
                    ->orderBy('text')
                    ->get();

        return response()->json($users);
    }

    /**
     * Get all cards that belong to the currently logged in user and have not been assigned a wallet.
    */
    public function getfreeCards() {
        $freecards = DB::select('SELECT * from "get_freecards"(' . Auth::id() . ')');
        return response()->json($freecards);
    }

    public function search(Request $request) {
        if ($request->isMethod('post')) {
            $filter = ""; $searchResult;
            $searchText = $request->searchText;
            $filters = $request->input('filter.*');

            foreach ($filters as &$value) {
                switch ($value) {
                    case "0":
                        $filter = "";
                        break;
                    case "1":
                        $filter .= "Calendars, ";
                        break;
                    case "2":
                        $filter .= "Cards, ";
                        break;
                    case "3":
                        $filter .= "Drivers, ";
                        break;
                    case "4":
                        $filter .= "Notications, ";
                        break;
                    case "5":
                        $filter .= "Transactions, ";
                        break;
                    case "6":
                        $filter .= "Users, ";
                        break;
                    case "7":
                        $filter .= "Vehicles, ";
                        break;
                    case "8":
                        $filter .= "Wallets, ";
                        break;
                }
            }

            if ($filter == "") {
                $searchResult = DB::select("select * from search_columns('" . $searchText . "', '{}')");
            } else {
                $searchResult = DB::select("select * from search_columns('%" . $searchText . "%', '{" . substr($filter, 0, -2) . "}')");
            }
            // select * from search_columns('%Adegbenga%', '{}')
            return view('search', ['searchResults' => $searchResult]);
        }
    }
}