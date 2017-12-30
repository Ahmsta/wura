<?php

namespace App\Models;

use Illuminate\Support\Arr;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Cards extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['cardnos', 'holder', 'status', 'valid_until', 'assignedto'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['cardnos', 'holder', 'status', 'valid_until', 'assignedto'];

    /**
     * Get all transactions owned by this card.
    */
    // public function Transactions()
    // {
    //     return $this->hasMany('App\Models\Transactions', 'cardnos', 'id');
    // }

    /**
     * Get all transactions owned by this card.
    */
    public function cardUser()
    {
        return $this->hasMany('App\Models\Drivers', 'id', 'assignedto');
    }

    /**
     * Get all transactions owned by this card.
    */
    public function cardOwner()
    {
        return $this->hasMany('App\Models\User', 'id', 'holder');
    }

    /**
     * {@inheritdoc}
    */
    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.assignedto')) {
            $olddriver = \App\Models\Drivers::find($this->getOriginal('assignedto'));
            $newdriver = \App\Models\Drivers::find($this->getAttribute('assignedto'));

            $data['old_values']['driver_name'] = $olddriver->firstname . ' ' . $olddriver->middlename . ' ' . $olddriver->lastname;
            $data['new_values']['driver_name'] = $newdriver->firstname . ' ' . $newdriver->middlename . ' ' . $newdriver->lastname;
        }

        return $data;
    }
}
