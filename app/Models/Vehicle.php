<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Vehicle extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['year', 'type', 'color', 'model', 'drive', 'doors', 'body', 'fuel_type', 'owner_name', 'transmission', 'purchase_date', 'license_plate_number', 'left_view', 'rear_view', 'right_view', 'frontal_view'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['year', 'type', 'color', 'model', 'drive', 'doors', 'body', 'fuel_type', 'owner_name', 'transmission', 'purchase_date', 'license_plate_number', 'left_view', 'rear_view', 'right_view', 'frontal_view'];

        /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Vehicle::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->whereBetween('updated_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->chunk(100, function($vehicles) use (&$auditedData)
            {
                foreach($vehicles as $vehicle) {
                    $auditedData[] = $vehicle->audits;
                }
            });
            return $auditedData;
        } catch (Exception $e) {
            log::error('Caught Vehicle Audit exception: ' . $e .  "\n");
            return [];
        }
    }
}
