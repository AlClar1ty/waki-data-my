<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mpc extends Model
{
    protected $fillable = [
        'registration_date', 'member_no', 'name', 'idcard', 'status', 'gender', 'birth_date', 'address', 'postcode', 'city', 'state', 'country', 'house_phone', 'mobile_phone','contact_method', 'fb_name', 'email', 'active', 'branch_id', 'user_id',
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