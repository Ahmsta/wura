<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Transactions extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['cardnos', 'amount', 'merchant'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['cardnos', 'amount', 'merchant'];

    /**
     * {@inheritdoc}
    */
    public static function getAudits($audit_startdate, $audit_enddate) {
        try {
            $auditedData = [];
            Transactions::whereBetween('created_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->whereBetween('updated_at', [new Carbon($audit_startdate), new Carbon($audit_enddate)])
            ->chunk(100, function($transactions) use (&$auditedData)
            {
                foreach($transactions as $transaction) {
                    $auditedData[] = $transaction->audits;
                }
            });
            return $auditedData;
        } catch (Exception $e) {
            log::error('Caught Transactions Audit exception: ' . $e .  "\n");
            return [];
        }
    }    
}
