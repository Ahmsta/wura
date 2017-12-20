<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drivers extends Model
{
    // CreateDriversTable

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['firstname', 'middlename', 'lastname', 'idnumber', 'mobilenumber', 'dateofbirth', 'passportpath', 'identificationpath', 'belongsTo', 'status', 'email'];
}
