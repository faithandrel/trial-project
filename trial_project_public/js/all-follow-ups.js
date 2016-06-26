var listFollowUpsApp = angular.module('listFollowUpsApp', ['contactsApp','ngSanitize'])
                         .config(function($interpolateProvider){
                                $interpolateProvider.startSymbol('<%').endSymbol('%>');
                            }
                         );

listFollowUpsApp.filter('yesNo', function() {
    return function(input) {
       if (input) {
              return 'Yes';
       }
       else {
              return 'No';
       }
    }
});

listFollowUpsApp.filter('checkIfEmpty', function() {
    return function(input) {
       if ( input != undefined) {
              if (input == false || (input.length != undefined && input.length < 1)) {
                     return 'N/A';
              }
              else {
                     return input;
              }
       }
       else {
              return 'N/A';
       }
    }
});

listFollowUpsApp.controller('AllFollowUpsCtrl', function ($scope, $http, $timeout) {
       
    $scope.follow_up_list = [];
    
    $scope.loading = false;
    
    $scope.getAllFollowUps = function(sort,order) {
       $scope.loading = true;
       
       var url = 'get-all-follow-ups';
       if (sort) {
              url += '/' + sort;
       }
       if (order) {
              url += '/' + order;
       }
       
       $http.get(base_url+url).success(function(data, status) {
            $scope.loading = false;
            $scope.follow_up_list = data;
       });
       
    }
});