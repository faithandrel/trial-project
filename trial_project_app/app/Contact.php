<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'nickname', 'date_met', 'notes', 'contact_method', 'phone', 'email'
    ];
    
    public function contact_details()
    {
        return $this->hasMany('App\ContactDetails');
    }
}
