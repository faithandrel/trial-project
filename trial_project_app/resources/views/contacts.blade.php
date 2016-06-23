@extends('base')

@section('title', 'Contacts')    

@section('content')
    <div ng-cloak ng-app="contactsPageApp" ng-controller="ContactsCtrl" class="container">    
        <div class="content">
            <div id="contact-page-title" class="row">
                <span ng-show="!open_add_contact" >Contact Page</span>
                <span ng-show="!isEditing() && open_add_contact" >Add New Contact</span>
                <span ng-show="isEditing()" >Edit <span ng-bind="contact.name"></span></span>
                <img ng-show="loading" width=20 src="styles/images/loading_gif.gif" />
                
                <button ng-show="!isEditing() && open_add_contact" ng-click="toggleAddForm()"
                    class="btn btn-primary btn-sm pull-right">Close</button>
                <button ng-show="!isEditing() && !open_add_contact" ng-click="toggleAddForm()"
                    class="btn btn-primary btn-sm pull-right">Add Contact</button>
            </div>
            <div id="add-new-contact" ng-show="open_add_contact" class="row">
                <form>
                    <div class="col-md-6">
                    <input type="hidden" ng-model="contact.id">
                        <div class="form-group">
                          <label for="contact-name">Name</label>
                          <input required type="text" ng-model="contact.name" class="form-control" id="contact-name" placeholder="Name">
                        </div>
                        <div class="form-group">
                          <label for="contact-nickname">Nickname</label>
                          <input type="text" ng-model="contact.nickname" class="form-control" id="contact-nickname" placeholder="Nickname">
                        </div>
                        <div class="form-group">
                          <label for="contact-date-met">Date Met</label>
                          <input datepicker the-model="contact" date-attribute="date_met" type="text" ng-model="contact.date_met" class="form-control" id="contact-date-met" placeholder="Date">
                        </div>
                        <div class="form-group">
                          <label for="contact-notes">Notes</label>
                           <textarea id="contact-notes" ng-model="contact.notes" class="form-control" rows="3"></textarea>
                        </div>
            
                        <button type="submit" ng-click="saveContact()" class="btn btn-success btn-sm">Submit</button>
                        <button type="button" ng-show="isEditing()" ng-click="resetContact()"
                            class="btn btn-primary btn-sm">Clear</button>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Preferred Contact Method</label><br/>
                          <div class="radio-inline">
                            <label class="col-xs-4">
                              <input type="radio" ng-model="contact.contact_method" name="contact_method" value="method1">
                              Method 1
                            </label>
                            <label class="col-xs-4">
                              <input type="radio" ng-model="contact.contact_method" name="contact_method" value="method2">
                              Method 2
                            </label>
                            <label class="col-xs-4">
                              <input type="radio" ng-model="contact.contact_method" name="contact_method" value="method3">
                              Method 3
                            </label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="contact-phone">Phone</label>
                          <input type="text" ng-model="contact.phone" class="form-control" id="contact-phone" placeholder="Phone">
                        </div>
                        <div class="form-group">
                          <label for="contact-email">Email</label>
                          <input type="email" ng-model="contact.email" class="form-control" id="contact-email" placeholder="Email">
                        </div>
                        <div class="form-group other-contact" >
                          <label>Other Contact Info</label>
                                <div ng-repeat="one_detail in contact.contact_details | limitTo:2" class="form-inline">
                                    <input ng-model="one_detail.name" type="text" class="form-control other-contact-desc" placeholder="Description">
                                    <input ng-model="one_detail.value" type="text" class="form-control other-contact-val" placeholder="Value">
                                    <button type="button" ng-click="clearContactDetail(one_detail)"
                                        class="btn btn-default btn-xs">&times;</button>
                                </div>
                        </div>
                        <button type="button" data-toggle="modal" data-target=".bs-example-modal-sm"
                            class="btn btn-primary btn-xs">Add More</button>
                    </div>
                </form>
            </div>
            <br/>
            <div class="row">
                <table class="table table-striped">
                    <tr>
                        <th>
                            Name
                            <button ng-click="getContacts()"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getContacts('name','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>
                            Nickname
                            <button ng-click="getContacts('nickname','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getContacts('nickname','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>
                            Date Met
                            <button ng-click="getContacts('date_met','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getContacts('date_met','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>
                            Date Added
                            <button ng-click="getContacts('created_at','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getContacts('created_at','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>Actions</th>
                    </tr>
                    <tr ng-repeat="one in contacts">
                        <td ng-bind="one.name"></td>
                        <td ng-bind="one.nickname"></td>
                        <td ng-bind="one.date_met"></td>
                        <td ng-bind="one.created_at"></td>
                        <td><button ng-click="getOneContact(one.id)" class="btn btn-warning btn-xs">Edit</button></td>
                    </tr>
                </table>
            </div>
        </div>
            
        <!-- contact details modal -->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Other Contact</h4>
                </div>
                <div class="modal-body other-contact">
                    <div ng-repeat="one_detail in contact.contact_details | startFrom:2" class="form-inline">
                        <input ng-model="one_detail.name" type="text" class="form-control other-contact-desc" placeholder="Description">
                        <input ng-model="one_detail.value" type="text" class="form-control other-contact-val" placeholder="Value">
                        <button type="button" ng-click="clearContactDetail(one_detail)"
                            class="btn btn-default btn-xs">&times;</button>
                    </div>
                    <button type="button" ng-click="addContactDetailField()"
                            class="btn btn-primary btn-xs">Add More</button>
                </div>                
            </div>
          </div>
        </div>
    </div>
        
@endsection