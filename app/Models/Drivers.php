<?php

namespace App\Models;

use OwenIt\Auditing\Auditable;
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
    protected $fillable = ['firstname', 'middlename', 'lastname', 'idnumber', 'mobilenumber', 'dateofbirth', 'passportpath', 'identificationpath', 'belongsTo', 'status', 'email'];

    /**
     * Attributes to include in the Audit.
     *
     * @var array
     */
    protected $auditInclude = ['firstname', 'middlename', 'lastname', 'idnumber', 'mobilenumber', 'dateofbirth', 'passportpath', 'identificationpath', 'belongsTo', 'status', 'email'];
}
