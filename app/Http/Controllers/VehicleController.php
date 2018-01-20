<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Vehicles;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    protected $tag = 'Vehicles :: ';

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
    public function index()
    {
        $vehicles = Vehicles::where('owner', Auth::id())->get();
        return view('vehicle.index', ['vehicles' => $vehicles, 'defaultImg' => Storage::url('upload_image.png')]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function getInfo(Request $request)
    {
        $vehicles = Vehicles::find($request->id);
        return response()->json([
            'id' => $request->id,
            'status' => 'success',
            'vehicleInfo' => $vehicles
        ], 200);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function registerform()
    {
        return view('vehicle.register')->with('defaultImg', Storage::url('upload_image.png'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function registervehicle(Request $request)
    { 
        if ($request->isMethod('post')) 
        {
            // Validate the request...
            $validator = Validator::make($request->all(), AuthValidation::registervehicle());

            if ($validator->fails())
            {
                Log::info($this->tag . json_encode($validator->failed()));
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $left_view = '/upload_image.png';
            if ($request->hasFile('left_view')) {
                $left_view = Storage::putFile('public/cars', $request->file('left_view'));
            }

            $rear_view = '/upload_image.png';
            if ($request->hasFile('rear_view')) {
                $rear_view = Storage::putFile('public/cars', $request->file('rear_view'));
            }

            $right_view = '/upload_image.png';
            if ($request->hasFile('right_view')) {
                $right_view = Storage::putFile('public/cars', $request->file('right_view'));
            }

            $frontal_view = '/upload_image.png';
            if ($request->hasFile('front_view_image')) {
                $frontal_view = Storage::putFile('public/cars', $request->file('front_view_image'));
            }
            
            $vehicle = new Vehicles();
            $vehicle->assigned_to = 0;
            $vehicle->owner = Auth::id();
            $vehicle->left_view = $left_view;
            $vehicle->rear_view = $rear_view;
            $vehicle->right_view = $right_view;
            $vehicle->frontal_view = $frontal_view;
            $vehicle->year = $request->car_year;
            $vehicle->make = $request->car_type;
            $vehicle->model = $request->car_model;
            $vehicle->trim = $request->car_model_trim;
            $vehicle->color = $request->car_model_color;
            $vehicle->owner_name = $request->owner_name;
            $vehicle->car_details = $request->vehicle_info;
            $vehicle->purchase_date = $request->purchase_date;
            $vehicle->license_plate_number = $request->license_plate_number;

            // Save the vehicle details to the DB.
            $vehicle->save();

            return redirect()->action('VehicleController@registerform');
        }
    }

    public function updatevehicle(Request $request) {
        if ($request->isMethod('put')) {
            
            // Validate the request...
            $validator = Validator::make($request->all(), AuthValidation::registervehicle());

            if ($validator->fails())
            {
                Log::info($this->tag . json_encode($validator->failed()));
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $recordid = $request->input('id');
            $vehicle = Vehicles::find($recordid);
            
            $left_view = '/upload_image.png';
            if ($request->hasFile('left_view')) {
                $left_view = Storage::putFile('public/cars', $request->file('left_view'));
            }

            $rear_view = '/upload_image.png';
            if ($request->hasFile('rear_view')) {
                $rear_view = Storage::putFile('public/cars', $request->file('rear_view'));
            }

            $right_view = '/upload_image.png';
            if ($request->hasFile('right_view')) {
                $right_view = Storage::putFile('public/cars', $request->file('right_view'));
            }

            $frontal_view = '/upload_image.png';
            if ($request->hasFile('front_view_image')) {
                $frontal_view = Storage::putFile('public/cars', $request->file('front_view_image'));
            }
            
            $vehicle->assigned_to = 0;
            $vehicle->owner = Auth::id();
            $vehicle->left_view = $left_view;
            $vehicle->rear_view = $rear_view;
            $vehicle->right_view = $right_view;
            $vehicle->frontal_view = $frontal_view;
            $vehicle->year = $request->car_year;
            $vehicle->make = $request->car_type;
            $vehicle->model = $request->car_model;
            $vehicle->trim = $request->car_model_trim;
            $vehicle->color = $request->car_model_color;
            $vehicle->owner_name = $request->owner_name;
            $vehicle->car_details = $request->vehicle_info;
            $vehicle->purchase_date = $request->purchase_date;
            $vehicle->license_plate_number = $request->license_plate_number;
            $data = $vehicle->save();

            if ($data == true) {
                return redirect()->action('VehicleController@index');
            } else {
                return redirect()->back()->withErrors($validator)->withInput();
                log::error($this->tag . json_encode($request->all()));
            }
        }
    }
}
