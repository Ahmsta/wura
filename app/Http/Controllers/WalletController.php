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

class WalletController extends Controller
{
    protected $tag = 'Wallet :: ';

}
