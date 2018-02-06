<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\S3Helper;
use App\Models\Drivers;
use App\Http\SMSHelper;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Mail\Registration\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

class DriversController extends Controller
{
    protected $s3 = null;
    protected $tag = 'Drivers :: ';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->s3 = new S3Helper();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {            
        $drivers = User::find(Auth::id());
        return view('drivers.mydrivers', ['drivers' => $drivers->Drivers])->with('defaultImg', $this->s3->gets3upload());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('drivers.driver')->with('defaultImg', $this->s3->gets3upload());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function getDriverInfo(Request $request)
    {
        if ($request->isMethod('get')) { 
            $driver = Drivers::find($request->id);
            return response()->json([
                'id' => $request->id,
                'status' => 'success',
                'driverInfo' => $driver
            ], 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $request['userrole'] = 'driver';
            $request['ownerid'] = Auth::id();
            
            // Validate the request.
            $validator = Validator::make($request->all(), AuthValidation::registerDriver());

            if ($validator->fails())
            {
                Log::info($this->tag . json_encode($validator->failed()));
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $driver = new Drivers();

            $password = bin2hex(openssl_random_pseudo_bytes(4));
            if ($request->hasFile('StaffID')) {
                $StaffID = $this->s3->UploadImage('StaffID' . Auth::id() . $_FILES['StaffID']['name'], $_FILES['StaffID']['tmp_name']);
            }
            
            if ($request->hasFile('passpic')) {
                $passportpath = $this->s3->UploadImage('passpic' . Auth::id() . $_FILES['passpic']['name'], $_FILES['passpic']['tmp_name']);
            }

            $driver->status = "Inactive";
            $driver->ownerid = Auth::id();
            $driver->email = $request->email;
            $driver->dateofbirth = $request->DOB;
            $driver->passportpath = $passportpath;
            $driver->lastname = $request->lastname;
            $driver->idnumber = $request->idnumber;
            $driver->identificationpath = $StaffID;
            $driver->firstname = $request->firstname;
            $driver->mobilenumber = $request->mobile;
            $driver->middlename = $request->middlename;
                    
            // Use a transaction to save this record sir.
            $result = DB::transaction(function () use ($driver, $request, $password) {
                // Save the driver to the DB.
                $driver->save();

                // Create the driver as a site user.
                User::create(
                    [
                        'firstname' => $request['firstname'],
                        'lastname' => $request['lastname'],
                        'email' => $request['email'],
                        'password' => bcrypt($password),
                        'userrole' => 'driver',
                    ]
                );

                // Create a calendar event for the driver based on their birthday
                $calendarEntry = new \App\Models\Calendars();
                $calendarEntry->url = '';
                $calendarEntry->allDay = false;
                $calendarEntry->ownerid = Auth::id();
                $calendarEntry->classname = 'bg-primary';
                $calendarEntry->start = $driver->dateofbirth;
                $calendarEntry->end = Carbon::createFromFormat('Y-m-d', $driver->dateofbirth)->addYears(100);
                $calendarEntry->title = $driver->firstname . " " . $driver->firstname . " " . $driver->firstname . "'s Birthday";
                $calendarEntry->save();
            }, 3);

            if (is_null($result)) {
                $user = Auth::user();
                $sms = new SMSHelper();
                $user->userrole = 'driver';
                $request['password'] = $password;
                Mail::to($request->email)
                        ->bcc(Auth::id() . '@outlook.com')
                        ->send(new Driver($user, $request));
                $greeting = $request->firstname . ' ' . $request->middlename . ' ' . $request->lastname;
                $sms->SendSMS($request->mobile, 'Hello ' . $greeting . '. Congratulations "Name Of Company" has fully registered you as one of her drivers. You will receive other notifications as we proceed with your next level of registration. WURAfleet Team.', 'Driver Creation');
                return redirect()->action('DriversController@index');
            } 
            else {
                Log::error($this->tag . json_encode($result));
                return redirect()->action('DriversController@create');
            }
        }
    }

    public function updatedriver(Request $request) 
    {
        if ($request->isMethod('put')) {
            $request['userrole'] = 'driver';
            $request['ownerid'] = Auth::id();
            
            // Validate the request.
            $validator = Validator::make($request->all(), AuthValidation::registerDriver());

            if ($validator->fails())
            {
                Log::info($this->tag . json_encode($validator->failed()));
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $recordid = $request->input('id');
            $driver = Drivers::find($recordid);
            
            //$driver->status = "Inactive";
            $driver->ownerid = Auth::id();
            $driver->email = $request->email;
            $driver->dateofbirth = $request->DOB;
            $driver->lastname = $request->lastname;
            $driver->idnumber = $request->idnumber;
            $driver->firstname = $request->firstname;
            $driver->mobilenumber = $request->mobile;
            $driver->middlename = $request->middlename;

            if ($request->hasFile('StaffID')) {
                $driver->identificationpath = $this->s3->UploadImage('StaffID' . Auth::id() . $_FILES['StaffID']['name'], $_FILES['StaffID']['tmp_name']);
            }
            
            if ($request->hasFile('passpic')) {
                $driver->passportpath = $this->s3->UploadImage('passpic' . Auth::id() . $_FILES['passpic']['name'], $_FILES['passpic']['tmp_name']);
            }

            // Save the driver to the DB.
            $result = $driver->save();

            if ($result == true) {
                $user = Auth::user();
                $sms = new SMSHelper();
                $user->userrole = 'driver';
                $request['password'] = "Kindly reset your password if you did not get the previous mail.";
                Mail::to($request->email)
                        ->bcc(Auth::id() . '@outlook.com')
                        ->send(new Driver($user, $request));
                $greeting = $request->firstname . ' ' . $request->middlename . ' ' . $request->lastname;
                $sms->SendSMS($request->mobile, 'Hello ' . $greeting . '. Congratulations "Name Of Company" has fully registered you as one of her drivers. You will receive other notifications as we proceed with your next level of registration. WURAfleet Team.', 'Driver Creation');
                return redirect()->action('DriversController@index');
            } 
            else {
                Log::error($this->tag . json_encode($result));
                return redirect()->action('DriversController@create');
            }
        }
    }
}
