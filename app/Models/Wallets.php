<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Wallets extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['walletname', 'oncard', 'amount', 'status', 'ownerid'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude =  ['walletname', 'oncard', 'amount', 'status', 'ownerid'];

    /**
     * {@inheritdoc}
    */
    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.oncard')) {
            $cardnos = \App\Models\Cards::find($this->getOriginal('oncard'))->cardnos;
            if ($cardnos == null) {
                $data['old_values']['card_number'] = $cardnos;
                $data['new_values']['card_number'] = \App\Models\Cards::find($this->getAttribute('oncard'))->cardnos;
            } else {
                $data['old_values']['card_number'] = $cardnos;
                $data['new_values']['card_number'] = \App\Models\Cards::find($this->getAttribute('oncard'))->cardnos;
            }
        }

        return $data;
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
