<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'userrole'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the Drivers for this user.
    */
    public function Drivers()
    {
        return $this->hasMany('App\Models\Drivers', 'belongsTo', 'id');
    }

    /**
     * Get all cards owned by this user.
    */
    public function Cards()
    {
        return $this->hasMany('App\Models\Cards', 'holder', 'id');
    }
}
