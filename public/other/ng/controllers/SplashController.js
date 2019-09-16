COM.controller("SplashController",["$scope","$rootScope","$state","AuthService","BasicComService",
function($scope,$rootScope,$state,AuthService,BasicComService){
    console.log("Splash Controller");


    $scope.getServices = function(){
        $state.go("app.services_list");
    };
    $scope.getTerminals = function(){
        $state.go("app.terminal_list");
    };
    $scope.getCalc = function(){
        $state.go("app.calculator");
    };


}]);
