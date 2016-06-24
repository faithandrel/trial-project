var contactsPageApp = angular.module('contactsPageApp', ['contactsApp','ngSanitize'])
                         .config(function($interpolateProvider){
                                $interpolateProvider.startSymbol('<%').endSymbol('%>');
                            }
                         );


contactsPageApp.controller('ContactsCtrl', function ($scope, $http, $timeout) {
    
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
    
    $scope.contacts = [];
    
    $scope.loading = true;
    $scope.open_add_contact = false;
    
    $scope.saveContact = function() {
        $scope.loading = true;
        $http.post(base_url+"save-contact", JSON.stringify($scope.contact)).success(function(data, status) {
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
