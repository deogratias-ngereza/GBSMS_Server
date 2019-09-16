
COM.controller("MainComController",["$scope","$rootScope","$state","AuthService","BasicComService",
function($scope,$rootScope,$state,AuthService,BasicComService){
    console.log("MainCom Controller");

    if(AuthService.getCurrentUser() != undefined){
        $scope.username = AuthService.getCurrentUser().username;
    }
    $scope.main_loader_status = "Loading..";
    $scope.show_paginator = 0;





    /*retrieve custom servie name */
    $rootScope.customServiceName = function(name){
        return BasicComService.getCustomServiceName(name);
    };
    
    

    



    $rootScope.initModals = function(){
         $('.modal-trigger').leanModal(); // Initialize the modals
    };
    $scope.logout = function(){
        AuthService.logout();
        $state.go("login");
    };


}]);

