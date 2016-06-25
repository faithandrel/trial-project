var listFollowUpsApp = angular.module('listFollowUpsApp', ['contactsApp','ngSanitize'])
                         .config(function($interpolateProvider){
                                $interpolateProvider.startSymbol('<%').endSymbol('%>');
                            }
                         );


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