<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AuditController extends Controller
{
    protected $tag = 'AuditLog :: ';

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
        return view('audit.index');
    }

    public function getlogs(Request $request) {
        // {"audit_enddate":"2017-12-30","audit_source":"User,Drivers","audit_startdate":"2017-12-01"}  

        // Validate the request...
        $validator = Validator::make($request->all(), AuthValidation::auditLogRules());
        if ($validator->fails())
        {
            $failedRules = $validator->failed();
            Log::info($this->tag . json_encode($failedRules));
            return response()->json($failedRules);
        }

        if ($request->isMethod('post')) {
            $audit_source = $request->input('audit_source');
            $audit_enddate = $request->input('audit_enddate');
            $audit_startdate = $request->input('audit_startdate');

            $source = explode(",", $audit_source);
            foreach ($source as &$value) {
                switch ($i) {
                    case "apple":
                        echo "i is apple";
                        break;
                    case "bar":
                        echo "i is bar";
                        break;
                    case "cake":
                        echo "i is cake";
                        break;
                }
                log::info($value);
            }
            // Get the logs for the user.
        // $user = Auth::user();
        //$wallet = \App\Models\Wallets::find(1);
        //$audit = $wallet->audits()->first();
        //$diff = $wallet->audits()->with('user')->get()->last();

        //var_dump($audit->getMetadata(true, JSON_PRETTY_PRINT));
        // var_dump($audit->getModified(true));
        }
    }
}
