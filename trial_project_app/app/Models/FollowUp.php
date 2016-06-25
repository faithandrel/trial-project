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
    
    public function getLastFollowUpAttribute()
    {
        if($this->recurring) {
            $details = $this->follow_up_details;
            if(count($details) < 1) {
               return false;
            }
            return $details->sortByDesc('date')->first()->date;
        }
        else {
            return $this->date;
        }
    }
    
    public function getNextFollowUpAttribute()
    {
        if($this->recurring) {
           $details = $this->follow_up_details;
         
           if(count($details) < 1) {
                return $this->date;
           }
           else {
                $last_date = $details->sortByDesc('date')->first()->date;    
                $no_of_days = 0;
                switch($this->recurrence_unit) {
                    case 'weekly':
                        $no_of_days = $this->recurrence_value*7;
                        break;
                    case 'monthly':
                        $no_of_days = $this->recurrence_value*30;
                        break;
                    case 'yearly':
                        $no_of_days = 365;
                        break;
                }
                
                $next_date = strtotime("+".$no_of_days." days", strtotime($last_date));
                return date('Y-m-d',$next_date);
           }
           
        }
        else {
            return false;
        }
    }
    
    public function getDaysToNextFollowUpAttribute()
    {
        $next_follow_up = $this->getNextFollowUpAttribute();
        if($next_follow_up) {
            $now = time(); 
            $your_date = strtotime($next_follow_up);
            if($now < $your_date) {
                $datediff = abs($your_date-$now);
                return floor($datediff/(60*60*24));
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}
