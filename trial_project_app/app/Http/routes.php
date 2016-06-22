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
    }
    else {
        //Create new
        $contact = new Contact;
    }

    $contact->fill($data);

    $contact->save();
  
    return response()->json($contact);
});

Route::get('get-contacts/{sort?}/{order?}', function ($sort = 'name', $order = 'asc') {
    $contacts = Contact::orderBy($sort,$order)->get();
    
    return response()->json($contacts);
});

Route::get('get-contact/{id}', function ($id) {
    $contact = Contact::find($id);
    
    return response()->json($contact);
});
