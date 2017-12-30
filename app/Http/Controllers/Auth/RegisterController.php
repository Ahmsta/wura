<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use App\Http\Validations\AuthValidation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * create a new method that overrides default register 
    */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();            
        event(new Registered($user = $this->create($request->all())));
    
        // $this->guard()->login($user); //this commented to avoid register user being auto logged in

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, AuthValidation::registerUser());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {        
        return User::create(
            [
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'userrole' => $data['userrole'],
            ]
        );
        //'iscoporate' => $data['iscoporate'] == 1 ? 'true' : 'false',     
    }

    /** 
     * We can also play with the registered user object thrown after registration using 
     * the registered method because you returned that method or redirectPath method in register method.
     *
     * @param Request $request
     * @param Object $user
     * @return \App\Models\User
    */
    public function registered(Request $request, $user)
    {
        try {
            $this->dispatch(new \App\Jobs\SendEmails($user['email'], array('Action' => $user['userrole'], 'User' => $user)));
        } catch (Exception $e) {
            Log::info($this->tag . json_encode($e));
        }
    }
}
