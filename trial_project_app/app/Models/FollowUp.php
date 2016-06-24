<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'follow_ups';
     
    protected $fillable = [
        'contact_id', 'date', 'recurring', 'recurrence_unit', 'recurrence_value',
    ];
    
    public function follow_up_details()
    {
        return $this->hasMany('App\Models\FollowUpDetail', 'follow_up_id');
    }
    
    public function next_follow_up()
    {
        if($this->recurring) {
           $details =   $this->follow_up_details;
         
           if(count($details) < 1) {
                return $this->date;
           }
           else {
                return $details->sortByDesc('date')->first()->date;
           }
           
        }
        else return false;
    }
}
