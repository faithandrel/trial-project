<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactDetails extends Model
{
    protected $table = 'contact_details';
    
    protected $fillable = [
        'name', 'value',
    ];
}
