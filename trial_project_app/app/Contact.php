<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'nickname', 'date_met', 'notes', 'contact_method', 'phone', 'email'
    ];
}
