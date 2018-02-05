<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Drivers extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['firstname', 'middlename', 'lastname', 'idnumber', 'mobilenumber', 'dateofbirth', 'passportpath', 'identificationpath', 'ownerid', 'status', 'email'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['firstname', 'middlename', 'lastname', 'idnumber', 'mobilenumber', 'dateofbirth', 'passportpath', 'identificationpath', 'ownerid', 'status', 'email'];

    /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Drivers::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->whereBetween('updated_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->chunk(100, function($drivers) use (&$auditedData)
            {
                foreach($drivers as $driver) {
                    $auditedData[] = $driver->audits;
                }
            });
            return $auditedData;
        } catch (Exception $e) {
            log::error('Caught Driver Audit exception: ' . $e .  "\n");
            return [];
        }
    }
}
