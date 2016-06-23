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
use App\Contact;
use App\ContactDetails;

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
        App\ContactDetails::where('contact_id', $contact->id)->delete();
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
