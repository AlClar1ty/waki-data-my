<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mpc extends Model
{
    protected $fillable = [
        'code', 'registration_date', 'member_no', 'name', 'idcard', 'status', 'gender', 'birth_date', 'address', 'postcode', 'city', 'state', 'house_phone', 'mobile_phone', 'fb_name', 'email', 'active', 'branch_id', 'user_id',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}