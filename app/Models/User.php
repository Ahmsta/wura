<?php

namespace App\Models;

use Auth;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\UserResolver;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable, UserResolver
{
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

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

    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }

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

    /**
     * Get all wallets owned by this user.
    */
    public function Wallets()
    {
        return $this->hasMany('App\Models\Wallets', 'belongsTo', 'id');
    }

    public static function ValidCards() {
        $result = self::with(['Cards' => function($q) {
            //$q->where('status', '=', 'Activate')
              $q->where('holder', '=', 1);
        }])->get();
        return $result;    
    }
}
