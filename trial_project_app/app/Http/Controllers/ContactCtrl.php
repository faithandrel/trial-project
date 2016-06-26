<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Contact;
use App\Models\ContactDetails;
use App\Models\FollowUp;
use App\Models\FollowUpDetail;

class ContactCtrl extends Controller
{
    public function getContacts($sort = 'name', $order = 'asc')
    {
        $contacts = Contact::orderBy($sort,$order)->get();
    
        return response()->json($contacts);
    }
    
    public function saveContact(Request $request)
    {
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
    }
    
    public function getContact($id)
    {
        $contact = Contact::find($id);
        
        $details = [];
        foreach($contact->contact_details as $detail) {
            $details[] = array('name'=>$detail->name, 'value'=>$detail['value']);
        }
        $contact->contact_details = $details;
        
        return response()->json($contact);
    }
}
