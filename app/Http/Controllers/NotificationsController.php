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

class NotificationsController extends Controller
{
    protected $tag = 'Notifications :: ';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        $drivers = User::find(Auth::id());
        return view('mydrivers', ['drivers' => $drivers->Drivers]);
    }
}