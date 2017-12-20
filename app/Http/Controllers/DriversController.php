<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Drivers;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Mail\Registration\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

class DriversController extends Controller
{
    protected $tag = 'Drivers :: ';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = User::find(Auth::id());
        return view('mydrivers', ['drivers' => $drivers->Drivers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('driver')->with('defaultImg', Storage::url('upload.png'));
    }

    /**
     * Get a validator for an incoming driver registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $data['userrole'] = 'driver';
        $data['belongsTo'] = Auth::id();
        $validator = Validator::make($data, AuthValidation::registerDriver());
        if ($validator->fails())
        {
            $failedRules = $validator->failed();
            Log::info($this->tag . json_encode($failedRules));   
        }
        return $validator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request...
        $this->validator($request->all())->validate();

        $driver = new Drivers();

        $password = bin2hex(openssl_random_pseudo_bytes(4));
        $StaffID = Storage::putFile('public/staffid', $request->file('StaffID'));
        $passportpath = Storage::putFile('public/passports', $request->file('passpic'));

        $driver->status = "Inactive";
        $driver->belongsTo = Auth::id();
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
        }, 3);

        if (is_null($result)) {
            $user = Auth::user();
            $user->userrole = 'driver';
            $request['password'] = $password;
            Mail::to($request->email)->send(new Driver($user, $request));
            return redirect()->action('DriversController@index');
        } 
        else {
            Log::info($this->tag . json_encode($result));
            return redirect()->action('DriversController@create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function show(drivers $drivers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function edit(drivers $drivers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, drivers $drivers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\drivers  $drivers
     * @return \Illuminate\Http\Response
     */
    public function destroy(drivers $drivers)
    {
        //
    }
}
