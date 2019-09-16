

COM.controller("WelcomeController",["$scope","$rootScope","$state","AuthService","BasicComService","BasicXlsxService",
function($scope,$rootScope,$state,AuthService,BasicComService,BasicXlsxService){
    console.log("Welcome Controller");

    $scope.loading = 1;
    $scope.main_loader = 1;
    $scope.dateChangeLoader = 1;
    $scope.main_loader_status = "This might take some times, wait (calculating ... )";
    $scope.GlobalOBJ = {};


    var dt = new Date();
    var currentTime = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();
    $scope.startDate = currentTime;
    $scope.endDate = currentTime;
        /*TIME SET*/
    $scope.onSetDate = function(){
       var s_date = document.getElementById("datepicker_start").value;
       var e_date = document.getElementById("datepicker_end").value;
       $scope.startDate = s_date;
       $scope.endDate = e_date;
       console.log("DATES::",$scope.startDate,"to",$scope.endDate);
       runPage();
    };
    $scope.onSet = function(){
       $scope.startDate = currentTime;
       $scope.endDate = currentTime;
       
       var s_date = document.getElementById("datepicker_start").value;
       var e_date = document.getElementById("datepicker_end").value;
       $scope.startDate = s_date;
       $scope.endDate = e_date;
    };







    
    function runPage(){
        $scope.loading = 1;
        $scope.main_loader = 1;
        $scope.dateChangeLoader = 1;
        $scope.main_loader_status = "This might take some times, wait (calculating ... )";
        var conn = BasicComService.getOverviewAPI($scope.startDate,$scope.endDate);
        conn.then(
            function(response){
                $scope.dateChangeLoader = 0;
                $scope.loading = 0;
                $scope.main_loader = 0;
                $scope.$parent.show_paginator = 1;
                console.log(response);
                $scope.GlobalOBJ = response.data;
                //BasicXlsxService.getExcelComOverview("commission_overview",$scope.GlobalOBJ);//remove later
            },
            function(error){
                $scope.loading = 1;
                $scope.main_loader = 1;
                console.log(error);
            }
        );
    }
    runPage();




    //refresh service
    $scope.refresh = function(){
        $scope.loading = 1;
        $scope.dateChangeLoader = 0;
        $scope.main_loader = 1;
        $scope.main_loader_status = "refreshing...";
        runPage();
    };
    

}]);

