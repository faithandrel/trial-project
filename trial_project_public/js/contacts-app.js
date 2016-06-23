var contactsApp = angular.module('contactsApp', []);

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