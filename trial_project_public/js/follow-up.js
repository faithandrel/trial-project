var followUpsApp = angular.module('followUpsApp', ['contactsApp','ngSanitize'])
                         .config(function($interpolateProvider){
                                $interpolateProvider.startSymbol('<%').endSymbol('%>');
                            }
                         );

followUpsApp.controller('FollowUpCtrl', function ($scope, $http, $timeout) {
       $scope.contact_id = 0;
       $scope.contact_name = '';
       
       $scope.recurrence = ['weekly', 'monthly', 'yearly'];
       
       $scope.getNumber = function(num) {
              var num_array = [];
              
              for (i=0; i < num; i++) {
                     num_array.push(i+1);
              }
              
              return num_array;
       }
       
       $scope.follow_up = {
              id: 0,
              contact_id: 0,
              date: '0000-00-00',
              recurring: false,
              recurrence_unit:  $scope.recurrence[0],
              recurrence_value: 1
       };
       
       $scope.follow_up_detail = {
                     method: 'method3',
                     reason: '',
                     pre_meeting_notes: '',
                     post_meeting_notes: '',
                     date: '0000-00-00',
                     completed: false,
                     follow_up_id: 0
              };
       
       $scope.follow_up_detail_list = [];
       
       $scope.loading = false;
       
       $scope.saveFollowUp = function() {
              $scope.loading = true;
              $http.post(base_url+"save-follow-up", JSON.stringify($scope.follow_up)).success(function(data, status) {
                    console.log(data);
                  return $scope.getContacts(false, false);
              }).then(function(response) {
                  $scope.loading = false;
              }, function(result) {
                  
              }).finally(function(response) {
                  
              });
       };
       
       $scope.prepFollowUpDetail = function() {
              $scope.follow_up_detail.follow_up_id = $scope.follow_up.id;
              if(!$scope.follow_up.recurring) {
                     $scope.follow_up_detail.date = $scope.follow_up.date;
              }
       };
       
       $scope.getFollowUp = function(id) {
              $scope.loading = true;
              return $http.get(base_url+"get-follow-up/"+id).success(function(data, status) {
                     console.log(new Date(data.follow_up.date));
                     $scope.loading = false;
                     $scope.contact_name = data.contact.name;
                     $scope.follow_up_detail_list = data.follow_up_details;
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
                     $http.post(base_url+"save-follow-up", JSON.stringify($scope.follow_up)).success(function(data, status) {
                            console.log(data);
                            $scope.follow_up_detail.follow_up_id = data.id;
                           return $http.post(base_url+"save-follow-up-detail", JSON.stringify($scope.follow_up_detail)).success(function(data, status) {
                          
                            });
                     }).then(function(response) {
                          return $scope.getFollowUp($scope.follow_up.contact_id);
                     }).then(function(response) {
                         $scope.loading = false;
                     }, function(result) {
                         
                     }).finally(function(response) {
                         $('.modal').modal('hide')
                     });
              }
              
              
       };
       
});