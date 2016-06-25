<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactDetails;
use App\Models\FollowUp;
use App\Models\FollowUpDetail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('contact-page', function () {
    return view('contacts');
});

Route::post('save-contact', function (Request $request) {
    $data = $request->input();
    
    if($data['id'] > 0) {
        //Edit existing
        $contact = Contact::find($data['id']);
        ContactDetails::where('contact_id', $contact->id)->delete();
    }
    else {
        //Create new
        $contact = new Contact;
    }

    $contact->fill($data);
    $contact->save();
    
    $contact_details = [];
    foreach($data['contact_details'] as $one_detail) {
        if(!empty($one_detail['name']) AND !empty($one_detail['value'])) {
            $contact_details[] = array('contact_id' => $contact->id,
                                       'name' => $one_detail['name'],
                                       'value' => $one_detail['value']);
        }
    }
    ContactDetails::insert($contact_details);
    
    return response()->json($data);
});

Route::get('get-contacts/{sort?}/{order?}', function ($sort = 'name', $order = 'asc') {
    $contacts = Contact::orderBy($sort,$order)->get();
    
    return response()->json($contacts);
});

Route::get('get-contact/{id}', function ($id) {
    $contact = Contact::find($id);
    
    $details = [];
    foreach($contact->contact_details as $detail) {
        $details[] = array('name'=>$detail->name, 'value'=>$detail['value']);
    }
    $contact->contact_details = $details;
    
    return response()->json($contact);
});

Route::get('follow-up-page/{id}', function ($id) {
    return view('followups', ['contact_id' => $id]);
});

Route::get('model-test/{id}', function ($id) {
     $contact = Contact::find($id);
     
     echo $contact->follow_up->next_contact();
});

Route::get('get-follow-up/{id}', function ($contact_id) {
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
});

Route::get('get-contacts/{sort?}/{order?}', function ($sort = 'name', $order = 'asc') {
    $contacts = Contact::orderBy($sort,$order)->get();
    
    return response()->json($contacts);
});

Route::get('get-all-follow-ups/{sort?}/{order?}', function ($sort = 'created_at', $order = 'asc') {
    $follow_ups = FollowUp::orderBy($sort,$order)->get();
    
    foreach($follow_ups as $one_follow_up) {

        //$one_follow_up->follow_up_detail = $one_follow_up->follow_up_details->sortByDesc('date')->first();
        
        if($one_follow_up->recurring) {
            $one_follow_up->next_follow_up = $one_follow_up->next_follow_up;
            $one_follow_up->days_to_next_follow_up =  $one_follow_up->days_to_next_follow_up;
        }
        else {
            $one_follow_up->next_date = false;
        }

        $one_follow_up->last_follow_up = $one_follow_up->last_follow_up;
        
    }
    
    return response()->json($follow_ups);
});

Route::post('save-follow-up', function (Request $request) {
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
});

Route::post('save-follow-up-detail', function (Request $request) {
    $data = $request->input();
    
    $follow_up = new FollowUpDetail;
    
    $follow_up->fill($data);
    $follow_up->save();
    
    return response()->json($data);
});