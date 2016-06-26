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
    return redirect('contact-page');
});

Route::get('contact-page', function () {
    return view('contacts');
});
Route::post('save-contact', 'ContactCtrl@saveContact');
Route::get('get-contacts/{sort?}/{order?}', 'ContactCtrl@getContacts');
Route::get('get-contact/{id}', 'ContactCtrl@getContact');



Route::get('follow-up-page/{id}', function ($id) {
    return view('followups', ['contact_id' => $id]);
});
Route::get('follow-up-list', function () {
    return view('allfollowups');
});
Route::get('get-follow-up/{id}', 'FollowUpCtrl@getFollowUp');
Route::get('get-all-follow-ups/{sort?}/{order?}', 'FollowUpCtrl@getAllFollowUps');
Route::post('save-follow-up', 'FollowUpCtrl@saveFollowUp');
Route::post('save-follow-up-detail', 'FollowUpCtrl@saveFollowUpDetail');
Route::get('complete-follow-up/{id}', 'FollowUpCtrl@completeFollowUp');
