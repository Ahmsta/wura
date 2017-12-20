<?php

namespace App\Http\Validations;

use Illuminate\Support\Facades\Validator;

class AuthValidation
{
    /**
     * Validation for Registering a new user.
     * @return mixed
    */
    public static function registerUser()
    {
        return [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'userrole' => 'required|string|min:3',
        ];
    }

    /**
     * Validation for Registering a new driver on the platform.
     * @return mixed
    */
    public static function registerDriver()
    {
        return [
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'idnumber' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'DOB' => 'required|date',
            'belongsTo' => 'required|numeric',
            'email' => 'required|string|email|max:255',
            'userrole' => 'required|string|min:3',
        ];
    }

    /**
     * Validation for company register endpoint
     * @return mixed
     */
    public static function registerCompanyRules()
    {
        return [
            'company_name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Validation for login endpoint
     * @return mixed
     */
    public static function loginRules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Validation for forgot password endpoint
     * @return mixed
     */
    public static function forgotPasswordRules()
    {
        return [
            'email' => 'required|string|email|max:255',
        ];
    }

    /**
     * Validation for reset password endpoint
     * @return mixed
     */
    public static function resetPasswordRules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'reset_token' => 'required|string|max:60',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
