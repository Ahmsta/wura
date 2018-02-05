<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Calendars extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['title', 'allDay', 'start', 'end', 'url', 'classname', 'ownerid'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['title', 'allDay', 'start', 'end', 'url', 'classname', 'ownerid'];

    /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Calendars::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->whereBetween('updated_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->chunk(100, function($calendars) use (&$auditedData)
            {
                foreach($calendars as $calendar) {
                    $auditedData[] = $calendar->audits;
                }
            });
            return $auditedData;
        } catch (Exception $e) {
            log::error('Caught Calendars Audit exception: ' . $e .  "\n");
            return [];
        }
    }
}