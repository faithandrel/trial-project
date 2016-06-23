var contactsApp = angular.module('contactsApp', ['ngSanitize'])
                         .config(function($interpolateProvider){
                                $interpolateProvider.startSymbol('<%').endSymbol('%>');
                            }
                         );

contactsApp.directive('datepicker', function ($timeout) {
    return {
        restrict: 'A',
        scope: {
            theModel: '=',
            dateAttribute: '@'
        },
        link: function postLink(scope, elem, attrs) {
            
            scope.getMyDate = function(theDay){
                var d = new Date();
                 
                if (theDay == 'yesterday') {
                    d.setDate(d.getDate() - 1);
                }
               
                var dd = d.getDate().toString();
                var mm =(d.getMonth()+1).toString();
                var yyyy = d.getFullYear().toString();

                return yyyy + '-' + (mm[1]?mm:"0"+mm[0]) + '-' + (dd[1]?dd:"0"+dd[0]); 
    
            }

            var todayAndYesterdayBtns = '<div class="contact-datepicker-buttons"><button id="datepicker-tday-btn" class="btn btn-primary btn-xs">Today</button>' +
                                        '<button id="datepicker-yday-btn" class="btn btn-primary btn-xs pull-right">Yesterday</button></div>';
             
            function addTdayYdayButtons() {
                if ($('#ui-datepicker-div .ui-datepicker-calendar').is(':visible')) {
                    $('#ui-datepicker-div').append(todayAndYesterdayBtns);
                    $('#datepicker-tday-btn').click(function() {
                        scope.theModel[scope.dateAttribute] = scope.getMyDate();
                        scope.$apply();
                    });
                    $('#datepicker-yday-btn').click(function() {
                        scope.theModel[scope.dateAttribute] = scope.getMyDate('yesterday');
                        scope.$apply();
                    });
                }
                else {
                    $timeout(function(){ addTdayYdayButtons(); }, 10);
                }
            }

            elem.datepicker({
                beforeShow: function(input, inst) {
                    addTdayYdayButtons();
                },
                dateFormat: "yy-mm-dd"

            });

        }
    };
});

contactsApp.filter('startFrom', function() {
    return function(input, start) {
        if(input) {
            start = +start; //parse to int
            return input.slice(start);
        }
        return [];
    }
});

contactsApp.controller('ContactsCtrl', function ($scope, $http, $timeout) {
    
    $scope.contact = {
        id: 0,
        name: '',
        nickname: '',
        date_met: '0000-00-00',
        notes: '',
        contact_method: 'method3',
	phone: '',
        email: '',
        contact_details: [
              { name: '', value: '' },
              { name: '', value: '' },
              { name: '', value: '' },
        ]
    };
    
    /*$scope.contact_details = [
      
    ];*/
    
    $scope.contacts = [];
    
    $scope.loading = true;
    $scope.open_add_contact = false;
    
    $scope.saveContact = function() {
        $scope.loading = true;
        $http.post(base_url+"save-contact", JSON.stringify($scope.contact)).success(function(data, status) {
              console.log(data);
            return $scope.getContacts(false, false);
        }).then(function(response) {
            $scope.loading = false;
        }, function(result) {
            
        }).finally(function(response) {
            $scope.resetContact();
        });
    };
    
    $scope.getContacts = function(sort,order) {
       var url = 'get-contacts';
       if (sort) {
              url += '/' + sort;
       }
       if (order) {
              url += '/' + order;
       }
       return $http.get(base_url+url).success(function(data, status) {
            $scope.contacts = data;
        })
    };
    
    $scope.getOneContact = function(id) {
        $scope.loading = true;
        $http.get(base_url+"get-contact/"+id).success(function(data, status) {
            $scope.loading = false;
            $scope.contact = data;
            
            while ($scope.contact.contact_details.length < 3) {
              $scope.addContactDetailField();
            }
            
            $scope.open_add_contact = true;
            window.scrollTo(0,0);
        });
    };
    
    $scope.toggleAddForm = function() {
       $scope.resetContact();
       if($scope.open_add_contact) {
              $scope.open_add_contact = false;
       }
       else {
              $scope.open_add_contact = true;
       }
    };
    
    $scope.clearContactDetail = function(detail) {
       detail.name = '';
       detail.value= '';
    };
    
    $scope.isEditing = function() {
       if ($scope.contact.id > 0) {
              return true;
       }
       else {
              return false;
       }
    };
    
    $scope.addContactDetailField = function() {
       $scope.contact.contact_details.push(
              { name: '', value: '' }
       );
    };
    
    $scope.resetContact = function() {
       $scope.contact = {
              id: 0,
              name: '',
              nickname: '',
              date_met: '0000-00-00',
              notes: '',
              contact_method: 'method3',
              phone: '',
              email: '',
              contact_details: [
                    { name: '', value: '' },
                    { name: '', value: '' },
                    { name: '', value: '' },
              ]
       };
    };
    
    
    
    $scope.getContacts(false, false).then(function(response) {
        $scope.loading = false;
    }, function(result) {
        
    }).finally(function(response) {
        
    });
   
    
});
