<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Cards;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;

class CardsController extends Controller
{
    protected $tag = 'Cards :: ';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Do not return cards that have expired and cards that have been deleted
        $cards = User::find(Auth::id());

        foreach ($cards->Cards as $card) {
            if ($card->assignedto == 0) {
                $card['Fullname'] = 'Yet to be assigned';
            } else {
                $carduser = Cards::find($card->id);
                $card['Fullname'] = $carduser->cardUser[0]['firstname'] . ' ' . $carduser->cardUser[0]['middlename'] . ' ' . $carduser->cardUser[0]['lastname'];
            }
        }
        return view('mycards', ['cards' => $cards->Cards]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('newcard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function newrequest(Request $request) {
        // We are normally supposed to call a 3rd Party application to register details.

        // Create a new object in the DB.
        $card = new Cards();

        $card->assignedto = 0;
        $card->holder = Auth::id();
        $card->valid_until = Carbon::today();
        $card->status = 'Processing Request';
        $card->cardnos = 'CARD-' . Auth::id() . Carbon::now();
  
        // Save the new card request to the DB.
        $card->save();

        return redirect()->action('CardsController@index');
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
        //$this->validator($request->all())->validate();
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

