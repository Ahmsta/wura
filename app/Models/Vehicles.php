<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Vehicles extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['year', 'make', 'model', 'trim', 'color', 'ownerid', 'owner_name', 'car_details', 'purchase_date', 'license_plate_number', 'left_view', 'rear_view', 'right_view', 'frontal_view', 'assigned_to'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['year', 'make', 'model', 'trim', 'color', 'ownerid', 'owner_name', 'car_details', 'purchase_date', 'license_plate_number', 'left_view', 'rear_view', 'right_view', 'frontal_view', 'assigned_to'];

    /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Vehicles::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
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