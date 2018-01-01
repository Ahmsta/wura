<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

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
        // Validate the request...
        $validator = Validator::make($request->all(), AuthValidation::auditLogRules());
        if ($validator->fails())
        {
            $failedRules = $validator->failed();
            Log::info($this->tag . json_encode($failedRules));
            return response()->json($failedRules);
        }

        if ($request->isMethod('post')) {
            $auditedData = [];
            $audit_source = $request->input('audit_source');
            $audit_enddate = $request->input('audit_enddate');
            $audit_startdate = $request->input('audit_startdate');

            $source = explode(",", $audit_source);
            foreach ($source as &$value) {
                switch (strtolower($value)) {
                    case "user":
                        $auditedData[$value] = \App\Models\User::getAudits($audit_startdate, $audit_enddate);
                        break;

                    case "cards":
                        $auditedData[$value] = \App\Models\Cards::getAudits($audit_startdate, $audit_enddate);
                        break;

                    case "drivers":
                        $auditedData[$value] = \App\Models\Drivers::getAudits($audit_startdate, $audit_enddate);
                        break;

                    case "wallets":
                        $auditedData[$value] = \App\Models\Wallets::getAudits($audit_startdate, $audit_enddate);
                        break;

                    case "transactions":
                        $auditedData[$value] = \App\Models\Transactions::getAudits($audit_startdate, $audit_enddate);
                        break;

                    default:
                }
            }

            return response()->json([
                'status' => "success",
                'data' => $auditedData
            ]);
        }
    }
}
