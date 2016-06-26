<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Contact;
use App\Models\ContactDetails;
use App\Models\FollowUp;
use App\Models\FollowUpDetail;

class FollowUpCtrl extends Controller
{
    public function getFollowUp($contact_id)
    {
        $contact = Contact::find($contact_id);
        $follow_up = $contact->follow_up;
    
        $follow_up_data = [];
        $follow_up_data['follow_up_details']  = [];
        
        if( !empty($follow_up) ) {
            $follow_up_data['follow_up_details'] = $contact->follow_up->follow_up_details;
            
            if($follow_up->recurring) {
                $follow_up->next_date = $follow_up->next_follow_up;
                $follow_up->days_to_next_date =  $follow_up->days_to_next_follow_up;
            }
            else {
                $follow_up->next_date = false;
            }
            
            $follow_up->last_follow_up = $follow_up->last_follow_up;
        }
        
        $follow_up_data['contact'] = $contact;
        $follow_up_data['follow_up'] = $follow_up;
        
        
        return response()->json($follow_up_data);
    }
    
    public function getAllFollowUps($sort = 'created_at', $order = 'desc')
    {
    
        if(in_array($sort, ['next_date','last_date','days_to_next'])) {
            $follow_ups = FollowUp::all();
        }
        else {
            $follow_ups = FollowUp::orderBy($sort, $order)->get();
        }
        
        
        $follow_up_array = [];
        foreach($follow_ups as $one_follow_up) {
    
            $one_follow_up->contact_name = $one_follow_up->contact->name;
            
            if($one_follow_up->recurring) {
                $one_follow_up->next_follow_up = $one_follow_up->next_follow_up;
                $one_follow_up->days_to_next_follow_up =  $one_follow_up->days_to_next_follow_up;
            }
            else {
                $one_follow_up->next_date = false;
            }
    
            $one_follow_up->last_follow_up = $one_follow_up->last_follow_up;
            $follow_up_array[] = $one_follow_up;
        }
        
        if($order == 'asc') {
            switch($sort) {
                case 'next_date':
                    usort($follow_up_array, array('App\Models\FollowUp', 'sortByNextDate'));
                    break;
                case 'last_date':
                     usort($follow_up_array, array('App\Models\FollowUp', 'sortByLastDate'));
                     break;
                case 'days_to_next':
                     usort($follow_up_array, array('App\Models\FollowUp', 'sortByDaysToNext'));
                     break;
                }
        }
        else {
            switch($sort) {
                case 'next_date':
                    usort($follow_up_array, array('App\Models\FollowUp', 'sortByNextDateDesc'));
                    break;
                case 'last_date':
                     usort($follow_up_array, array('App\Models\FollowUp', 'sortByLastDateDesc'));
                     break;
                case 'days_to_next':
                     usort($follow_up_array, array('App\Models\FollowUp', 'sortByDaysToNextDesc'));
                }
        }
        //echo var_dump($follow_up_array);
        return response()->json($follow_up_array);
    }
    
    public function saveFollowUp(Request $request)
    {
        $data = $request->input();
        
        if($data['id'] > 0) {
            //Edit existing
            $follow_up = FollowUp::find($data['id']);
        }
        else {
            //Create new
            $follow_up = new FollowUp;
        }
    
        $follow_up->fill($data);
        $follow_up->save();
        
        return response()->json($follow_up);
    }
    
    public function saveFollowUpDetail (Request $request)
    {
        $data = $request->input();
        
        $follow_up = new FollowUpDetail;
        
        $follow_up->fill($data);
        $follow_up->save();
        
        return response()->json($data);
    }
    
    public function completeFollowUp($id)
    {
        $follow_up = FollowUp::find($id);
        
        $follow_up->completed = true;
        $follow_up->save();
        
        return response()->json($follow_up);
    }
}
