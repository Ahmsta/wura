<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = ['cardnos', 'holder', 'status', 'valid_until', 'assignedto'];

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

}
