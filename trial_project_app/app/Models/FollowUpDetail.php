<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUpDetail extends Model
{
    protected $table = 'follow_up_details';
     
    protected $fillable = [
        'follow_up_id', 'method', 'reason', 'pre_meeting_notes', 'post_meeting_notes',
        'date',
    ];
    

}
