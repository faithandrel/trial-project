var followUpsApp = angular.module('followUpsApp', ['contactsApp','ngSanitize'])
                         .config(function($interpolateProvider){
                                $interpolateProvider.startSymbol('<%').endSymbol('%>');
                            }
                         );
                         
followUpsApp.filter('recurrenceUnit', function() {
    return function(input) {
       var result = '';
       switch(input) {
              case 'weekly':
                     result = 'week/s';
                     break;
              case 'monthly':
                     result = 'month/s';
                     break;
              case 'yearly':
                     result = 'year';
                     break;
       }
       return result;
    }
});

followUpsApp.controller('FollowUpCtrl', function ($scope, $http, $timeout) {
       $scope.contact_id = 0;
       $scope.contact_name = '';
       
       $scope.recurrence = ['weekly', 'monthly', 'yearly'];

       $scope.follow_up = {
              id: 0,
              contact_id: 0,
              date: '',
              recurring: false,
              recurrence_unit:  $scope.recurrence[0],
              recurrence_value: 1
       };
       
       $scope.follow_up_detail = {
                     method: 'method3',
                     reason: '',
                     pre_meeting_notes: '',
                     post_meeting_notes: '',
                     date: '',
                     completed: false,
                     follow_up_id: 0
              };
       
       $scope.follow_up_detail_list = [];
       
       $scope.loading = false;
       
       $scope.getNumber = function() {
              var num = 6;
              
              if ($scope.follow_up.recurrence_unit == 'monthly') {
                     num = 10;
              }
              
              var num_array = [];
              
              for (i=0; i < num; i++) {
                     num_array.push(i+1);
              }
              
              return num_array;
       }
       
       $scope.saveFollowUp = function() {
              $scope.loading = true;
              $http.post(base_url+"save-follow-up", JSON.stringify($scope.follow_up)).success(function(data, status) {
                  return $scope.getFollowUp($scope.follow_up.contact_id);
              }).then(function(response) {
                  $scope.loading = false;
              }, function(result) {
                  
              }).finally(function(response) {
                  
              });
       };
       
       $scope.prepFollowUpDetail = function() {
              $scope.follow_up_detail.follow_up_id = $scope.follow_up.id;
              if ($scope.follow_up.recurring && $scope.follow_up.next_date != undefined && $scope.follow_up.next_date != false) {
                     $scope.follow_up_detail.date = $scope.follow_up.next_date;
              }
              else {
                     $scope.follow_up_detail.date = $scope.follow_up.date;
              }
       };
       
       $scope.getFollowUp = function(id) {
              $scope.loading = true;
              return $http.get(base_url+"get-follow-up/"+id).success(function(data, status) {
                     $scope.loading = false;
                     $scope.contact_name = data.contact.name;
                     $scope.follow_up_detail_list = data.follow_up_details;
                     console.log(data);
                     if (data.follow_up != null) {
                            $scope.follow_up = data.follow_up;
                            
                            if (data.follow_up.recurring > 0) {
                                   $scope.follow_up.recurring = true;
                            }
                            else {
                                   $scope.follow_up.recurring = false;
                            }
                     }
                     else {
                            $scope.follow_up.contact_id = data.contact.id;
                     }
              });
       };
       
       $scope.saveFollowUpDetail = function() {
              $scope.loading = true;
              
              if ($scope.follow_up.id > 0 ) {
                     $http.post(base_url+"save-follow-up-detail", JSON.stringify($scope.follow_up_detail)).success(function(data, status) { 
                          return $scope.getFollowUp($scope.follow_up.contact_id);
                      }).then(function(response) {
                          $scope.loading = false;
                      }, function(result) {
                          
                      }).finally(function(response) {
                         $('.modal').modal('hide')
                     });
              }
              else {
                     $http.post(base_url+"save-follow-up", JSON.stringify($scope.follow_up)).then(function(response) {
                            console.log(response.data);
                            $scope.follow_up_detail.follow_up_id = response.data.id;
                           return $http.post(base_url+"save-follow-up-detail", JSON.stringify($scope.follow_up_detail));
                     }).then(function(response) {
                            return $scope.getFollowUp($scope.follow_up.contact_id);
                     }, function(result) {
                         
                     }).finally(function(response) {
                            $scope.loading = false;
                            $('.modal').modal('hide')
                     });
              }
              
              
       };
       
       $scope.allowAddNotesButton = function() {
              if ($scope.follow_up.recurring && !$scope.follow_up.completed) {
                     return true;
              }
              else if (!$scope.follow_up.recurring && $scope.follow_up_detail_list.length < 1) {
                     return true;
              }
              else {
                     return false
              }
       }
});