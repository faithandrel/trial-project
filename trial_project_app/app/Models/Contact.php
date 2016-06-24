<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'nickname', 'date_met', 'notes', 'contact_method', 'phone', 'email'
    ];
    
    public function contact_details()
    {
        return $this->hasMany('App\Models\ContactDetails');
    }
    
    public function follow_up()
    {
        return $this->hasOne('App\Models\FollowUp');
    }
}
