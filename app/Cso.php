<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cso extends Model
{
    protected $fillable = [
        'code', 'registration_date', 'unregistration_date', 'name', 'address', 'phone', 'komisi', 'no_rekening', 'province', 'district', 'branch_id', 'active', 
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function historyUndangan()
    {
        return $this->hasMany('App\HistoryUndangan');
    }

    public function dataTherapy()
    {
        return $this->hasMany('App\DataTherapy');
    }

    public function dataOutsite()
    {
        return $this->hasMany('App\DataOutsite');
    }
}
