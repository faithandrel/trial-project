@extends('base')

@section('title', 'Follow Ups')    

@section('content')
    <div ng-app="followUpsApp" ng-controller="FollowUpCtrl" class="container">
    
        <div id="follow-up-main" class="content" ng-init="contact_id={{ $contact_id }}; getFollowUp(contact_id)">
            <div class="row">
                 <img ng-show="loading" width=20 src="{{ url('/') }}/styles/images/loading_gif.gif" />
            </div>
            <div ng-if="follow_up.id == 0" class="row">
                <div class="col-md-6">
                    <input type="hidden" ng-model="follow_up.id" />
                    <input type="hidden" ng-model="follow_up.contact_id" />
                    <div class="form-group">
                        <label for="follow-up-date">Follow-up Date</label>
                        <input datepicker the-model="follow_up" date-attribute="date"
                                ng-model="follow_up.date"  type="text"
                                class="form-control" id="follow-up-date" placeholder="Date">
                    </div>
                        
                    <div class="checkbox">
                        <label>
                          <input ng-model="follow_up.recurring" type="checkbox"> Recurring
                        </label>
                    </div>

                    <button type="submit" ng-click="saveFollowUp()" class="btn btn-success btn-sm">Submit</button>
                </div>
                    
                <div class="col-md-6">
                    <div ng-show="follow_up.recurring">
                        <div class="form-group">
                            <label for="recurrence">Recurrence</label>
                            <select ng-options="item for item in recurrence" ng-model="follow_up.recurrence_unit"
                                    class="form-control" id="recurrence"></select>
                        </div>
                        
                        <div ng-show="follow_up.recurrence_unit != 'yearly'" class="form-group form-inline">
                            <label for="recurrence-value">Every&nbsp&nbsp</label>
                            <select ng-options="item for item in getNumber()" ng-model="follow_up.recurrence_value"
                                    class="form-control" id="recurrence-value"></select>
                            <label>&nbsp&nbsp<span ng-bind="follow_up.recurrence_unit | recurrenceUnit"></span></label>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="row">
                <button ng-if="allowAddNotesButton()" type="button" ng-click="prepFollowUpDetail()" data-toggle="modal" data-target=".bs-example-modal-sm"
                            class="btn btn-primary btn-xs">Add Notes</button>
                <button ng-if="!follow_up.completed" ng-click="saveCompletedFollowUp()" class="btn btn-primary btn-xs pull-right" href='#'>
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp Complete
                </button>
                <span  ng-if="follow_up.completed" class="label label-success pull-right">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>&nbsp Completed
                </span>
                    
                <br/><br/>
                <table class="table table-striped">
                    <tr>
                        <th>Follow-up for <span ng-bind="contact_name"></span></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <td><strong>Date: </strong></td>
                        <td ng-bind="follow_up.date"></td>
                        <td><strong>Recurring: </strong></td>
                        <td ng-bind="follow_up.recurring.toString().charAt(0).toUpperCase() + follow_up.recurring.toString().slice(1)"></td>
                    </tr>
                    <tr>
                        <td><strong>Date Created: </strong></td>
                        <td ng-bind="follow_up.created_at"></td>
                        <td><strong>Recurrence: </strong></td>
                         <td>
                            <span ng-if="follow_up.recurring">
                                Every <span ng-if="follow_up.recurrence_unit != 'yearly'" ng-bind="follow_up.recurrence_value"></span>
                                    <span ng-bind="follow_up.recurrence_unit | recurrenceUnit"></span>
                            </span>
                         </td>
                    </tr>
                        
                </table>
            </div>
                
             <div ng-if="follow_up_detail_list.length > 0" class="row">
                <table class="table table-striped">
                    <tr>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Method</th>
                        <th>Pre-meeting Notes</th>
                        <th>Post-meeting Notes</th>
                    </tr>
                    
                    <tr ng-repeat="detail in follow_up_detail_list">
                        <td ng-bind="detail.date"></td>
                        <td ng-bind="detail.reason"></td>
                        <td ng-bind="detail.method"></td>
                        <td ng-bind="detail.pre_meeting_notes"></td>
                        <td ng-bind="detail.post_meeting_notes"></td>
                    </tr>   
                </table>
            </div>
            
        </div>
            
        <!-- follow up details modal -->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Follow-up Details</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Preferred Follow-up Method</label><br/>
                        <div class="radio-inline">
                            <label class="col-xs-4">
                              <input type="radio" ng-model="follow_up_detail.method"
                                name="follow_up_method" value="method1">
                              Method 1
                            </label>
                            <label class="col-xs-4">
                              <input type="radio"  ng-model="follow_up_detail.method"
                                name="follow_up_method" value="method2">
                              Method 2
                            </label>
                            <label class="col-xs-4">
                              <input type="radio" ng-model="follow_up_detail.method"
                                name="follow_up_method" value="method3">
                              Method 3
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-notes">Reason</label>
                        <textarea id="contact-notes" ng-model="follow_up_detail.reason"
                            class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-notes">Pre-meeting Notes</label>
                        <textarea id="contact-notes" ng-model="follow_up_detail.pre_meeting_notes"
                            class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-notes">Post-meeting Notes</label>
                        <textarea id="contact-notes" ng-model="follow_up_detail.post_meeting_notes"
                            class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="follow-up-detail-date">Date</label>
                        <input datepicker the-model="follow_up_detail" date-attribute="date"
                                ng-model="follow_up_detail.date" ng-disabled="!follow_up.recurring" type="text"
                                class="form-control" id="follow-up-detail-date" placeholder="Date">
                    </div>

                    <button type="button" ng-click="saveFollowUpDetail()"
                            class="btn btn-success btn-sm">Save</button>
                </div>                
            </div>
          </div>
        </div>
        
    </div>
@endsection