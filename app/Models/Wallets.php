<?php

namespace App\Models;

use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
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
    protected $fillable = ['walletname', 'oncard', 'amount', 'status', 'belongsTo'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude =  ['walletname', 'oncard', 'amount', 'status', 'belongsTo'];

    /**
     * {@inheritdoc}
    */
    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.oncard')) {
            $data['old_values']['card_number'] = \App\Models\Cards::find($this->getOriginal('oncard'))->cardnos;
            $data['new_values']['card_number'] = \App\Models\Cards::find($this->getAttribute('oncard'))->cardnos;
        }

        return $data;
    }
}
