@extends('base')

@section('title', 'All Follow Ups')    

@section('content')
    <div ng-app="listFollowUpsApp" ng-controller="AllFollowUpsCtrl" class="container"> 
        <div id="follow-up-main" class="content">
            <div id="contact-page-title" class="row">
                <span>All Follow Ups</span>
                <img ng-show="loading" width=20 src="{{ url('/') }}/styles/images/loading_gif.gif" />
            </div>
            <div class="row" ng-init="getAllFollowUps(0,0)">
                <table class="table table-striped">
                    <tr>  
                        <th>Contact</th>
                        <th>
                            Completed
                            <button ng-click="getAllFollowUps('completed','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getAllFollowUps('completed','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>
                            Last Follow-up
                            <button ng-click="getAllFollowUps('last_date','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getAllFollowUps('last_date','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>
                            Date of Next Follow-up
                            <button ng-click="getAllFollowUps('next_date','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getAllFollowUps('next_date','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>
                            No. of days to next Follow-up
                            <button ng-click="getAllFollowUps('days_to_next','asc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></button>
                            <button ng-click="getAllFollowUps('days_to_next','desc')"
                                class="btn btn-default btn-xs"><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></button>
                        </th>
                        <th>Actions</th>
                    </tr>
                    <tr ng-repeat="follow_up in follow_up_list">
                        <td ng-bind="follow_up.contact_name"></td>
                        <td >
                            <span ng-class="{'label label-success': follow_up.completed, 'label label-danger':!follow_up.completed}"
                                  ng-bind="follow_up.completed | yesNo">
                                  </span>
                        </td>
                        <td ng-bind="follow_up.last_follow_up | checkIfEmpty"></td>
                        <td ng-bind="follow_up.next_follow_up | checkIfEmpty"></td>
                        <td ng-bind="follow_up.days_to_next_follow_up | checkIfEmpty"></td>
                        <td><a class="btn btn-primary btn-xs" href='{{ url('follow-up-page') }}/<% follow_up.contact.id %>'>
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp Open
                        </a></td>
                    </tr>
                </table>
            </div>
        </div>
        
    </div>
@endsection