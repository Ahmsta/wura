<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Cards;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    protected $tag = 'Wallet :: ';

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
        $user = User::find(Auth::id());
        foreach ($user->Wallets as $wallet) {
            $carduser = Cards::find($wallet->oncard);
            $wallet['CardStatus'] = $carduser->status;
            $wallet['CardNumber'] = $carduser->cardnos;
            $wallet['CardExpires'] = $carduser->valid_until;

            if (empty($playerlist)) {
                $wallet['Fullname'] = 'Yet to be assigned.';
            } else
            {
                $wallet['Fullname'] = $carduser->cardUser[0]['firstname'] . ' ' . $carduser->cardUser[0]['middlename'] . ' ' . $carduser->cardUser[0]['lastname'];
            }
        }

        // Get all cards that don't have a wallet assigned to them.
        $Cards = app('App\Http\Controllers\HomeController')->getfreeCards();
        return view('wallets.mywallet', ['wallets' => $user->Wallets, 'Cards' => $Cards->original]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, AuthValidation::walletRegistrationRules());
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
    public function store(Request $request) {
        try {
            // Validate the request...
            $this->validator($request->all())->validate();

            $wallet = new Wallets();
            $wallet->ownerid = Auth::id();
            $wallet->oncard = $request->oncard;
            $wallet->amount = $request->amount;
            $wallet->status = $request->status;
            $wallet->walletname = $request->walletname;

            // Save the wallet details to the DB.
            $wallet->save();
            return redirect()->action('WalletController@index');
        } catch (Exception $e) {
            Log::info($this->tag . json_encode($e));
        }
    }
}
