<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\Vehicles;
use Illuminate\Http\File;
use App\Models\VehicleDocs;
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
        if ($request->isMethod('put')) 
        {
            // Validate the request...
            $validator = Validator::make($request->all(), AuthValidation::registervehicle());

            if ($validator->fails())
            {
                Log::info($this->tag . json_encode($validator->failed()));
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $recordid = $request->input('id');
            $vehicle = Vehicles::find($recordid);
            
            if ($request->hasFile('left_view')) {
                $vehicle->left_view = Storage::putFile('public/cars', $request->file('left_view'));
            }

            if ($request->hasFile('rear_view')) {
                $vehicle->rear_view = Storage::putFile('public/cars', $request->file('rear_view'));
            }

            if ($request->hasFile('right_view')) {
                $vehicle->right_view = Storage::putFile('public/cars', $request->file('right_view'));
            }

            if ($request->hasFile('front_view_image')) {
                $vehicle->frontal_view = Storage::putFile('public/cars', $request->file('front_view_image'));
            }
            
            $vehicle->assigned_to = 0;
            $vehicle->owner = Auth::id();
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
                log::error($this->tag . json_encode($request->all()));
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
    }

    public function documents($id) {
        $vehicles = Vehicles::find($id);
        return view('vehicle.documents', ['vehicles' => $vehicles, 'defaultImg' => Storage::url('upload_image.png')]);
    }

    /**
     * Display a listing of the documents uploaded.
     *
     * @return \Illuminate\Http\Response
    */
    public function getDocuments($id)
    {
        $VehicleDocs = VehicleDocs::where('ownerid', Auth::id()) 
                                ->where('vehicleid', $id)
                                ->orderBy('id', 'asc')
                                ->orderBy('status', 'asc')
                                ->get();
        return response()->json([
            'status' => 'success',
            'vehicledocs' => $VehicleDocs
        ], 200);
    }

    public function documentsupload(Request $request)
    {
        if ($request->isMethod('post')) {
            // Validate the request...
            $validator = Validator::make($request->all(), AuthValidation::vehicleDocuments());

            if ($validator->fails())
            {
                log::info($this->tag . json_encode($validator->failed()));
                return response()->json([
                    'status' => 'error',
                    'error' => [
                        'exception' => json_encode($validator->failed()),
                        'message' => 'An error occurred while trying to upload the document.'
                    ]
                ], 500);
                // return redirect()->back()->withErrors($validator)->withInput();
            }

            // Find or create a new object based on the primary key.
            $vehicledoc = VehicleDocs::findOrNew($request->id);
            if ($request->hasFile('file')) {
                // $document = '/upload_image.png';
                $vehicledoc->docpath = Storage::putFile('public/documents', $request->file('file'));
            }

            $vehicledoc->status = 'active';
            $vehicledoc->ownerid = Auth::id();
            $vehicledoc->counter = $request->counter;
            $vehicledoc->doctypes = $request->doctypes;
            $vehicledoc->frequency = $request->frequency;
            $vehicledoc->vehicleid = $request->vehicleid;
            $vehicledoc->expirydate = $request->expirydate;
            $vehicledoc->notifytype = $request->notifytype;
            if (Carbon::now()->gt(Carbon::parse($request->expirydate))) {
                $vehicledoc->status = 'expired';
            }

            // Save the Record to the database.
            $data = $vehicledoc->save();

            // register in calendar alongside the reminder day
            if ($data == true) {
                return response()->json([
                    'status' => 'success',
                    'vehicledoc' => $vehicledoc
                ], 200);
            } else {
                log::error($this->tag . json_encode($request->all()));
                return response()->json([
                    'status' => 'error',
                    'error' => [
                        'data' => json_encode($vehicledoc),
                        'message' => 'An error occurred while trying to upload the document. Please try again later.'
                    ]
                ], 500);
            }
        }
    }

    public function deleteDocument($id) {
        // Find document based on the primary key passed in.
        $vehicledoc = VehicleDocs::find($id);
        $data = $vehicledoc->delete();

        if ($data == true) {
            return response()->json([
                'status' => 'success'
            ], 200);
        } else {
            log::error($this->tag . json_encode($id));
            return response()->json([
                'status' => 'error',
                'error' => [
                    'data' => json_encode($id),
                    'message' => 'An error occurred while trying to upload the document. Please try again later.'
                ]
            ], 500);
        }
    }
}
