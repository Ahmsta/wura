<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Notifications extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['type', 'recipient', 'data', 'read_at', 'ownerid', 'subject'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['type', 'recipient', 'data', 'read_at', 'ownerid', 'subject'];
  
    /**
     * {@inheritdoc}
    */
    public function transformAudit(array $data): array
    {
        $driver = null;
        if (strtolower($this->getAttribute('type')) == 'sms') {
            $driver = \App\Models\Drivers::where('mobilenumber', $this->getAttribute('recipient'))->first();
        } else if (strtolower($this->getAttribute('type')) == 'email') {
            $driver = \App\Models\Drivers::where('email', $this->getAttribute('recipient'))->first();
        }

        if ($driver == null) {
            $data['old_values']['driver_name'] = 'Invalid Driver Specified.';
            $data['new_values']['driver_name'] = 'Invalid Driver Specified.';
        } else {
            $data['old_values']['driver_name'] = $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname;
            $data['new_values']['driver_name'] = $driver->firstname . ' ' . $driver->middlename . ' ' . $driver->lastname;
        }
        return $data;
    }

    /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Notifications::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->whereBetween('updated_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->chunk(100, function($notifications) use (&$auditedData)
            {
                foreach($notifications as $notification) {
                    $auditedData[] = $notification->audits;
                }
            });
            return $auditedData;
        } catch (Exception $e) {
            log::error('Caught Notifications Audit exception: ' . $e .  "\n");
            return [];
        }
    }
}
