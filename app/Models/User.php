<?php

namespace App\Models;

use Auth;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Contracts\UserResolver;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Authenticatable implements AuditableContract, UserResolver
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
        return $this->hasMany('App\Models\Drivers', 'ownerid', 'id');
    }

    /**
     * Get all cards owned by this user.
    */
    public function Cards()
    {
        return $this->hasMany('App\Models\Cards', 'ownerid', 'id');
    }

    /**
     * Get all wallets owned by this user.
    */
    public function Wallets()
    {
        return $this->hasMany('App\Models\Wallets', 'ownerid', 'id');
    }

    public static function ValidCards() {
        $result = self::with(['Cards' => function($q) {
            //$q->where('status', '=', 'Activate')
              $q->where('ownerid', '=', 1);
        }])->get();
        return $result;    
    }

    /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Wallets::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->whereBetween('updated_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->chunk(100, function($wallets) use (&$auditedData)
            {
                foreach($wallets as $wallet) {
                    $auditedData[] = $wallet->audits;
                }
            });
            return $auditedData;
        } catch (Exception $e) {
            log::error('Caught Wallet Audit exception: ' . $e .  "\n");
            return [];
        }
    }
}
