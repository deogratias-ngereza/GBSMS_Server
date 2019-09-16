
COM.controller("SelectedTerminalController",["$timeout","$scope","$state","$stateParams","AuthService","BasicComService",
function($timeout,$scope,$state,$stateParams,AuthService,BasicComService){
    console.log("SelectedTerminalController");

    $scope.main_loader = 1;
    $scope.TerminalOBJ = {};
    $scope.TerminalBasicOBJ = {};
    $scope.show_paginator = 0;
    $scope.SIMPLE_SERVICES = {};
    $scope.selectedSERVICE = "any";//make sure its any by default




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
       runPage($scope.selectedSERVICE,$stateParams.tid,1,$scope.startDate,$scope.endDate,1);
    };
    $scope.onSet = function(){
       $scope.startDate = currentTime;
       $scope.endDate = currentTime;
       var s_date = document.getElementById("datepicker_start").value;
       var e_date = document.getElementById("datepicker_end").value;
       $scope.startDate = s_date;
       $scope.endDate = e_date;
    };




    function runPage($serv,$tid,$type,$startDate,$endDate,$page_no){
        //retrieve a single terminal
        var conn = BasicComService.getTerminalTransDataAPI($serv,$tid,$type,$startDate,$endDate,$page_no);
        conn.then(
            function(response){
                $scope.show_paginator = 1;
                $scope.main_loader = 0;
                console.log(response);
                $scope.TerminalOBJ = response.data;
                $scope.selectedSERVICE = response.data.selected_service;
                $scope.TerminalBasicOBJ = response.data.BASIC_INFO[0];
                $scope.SIMPLE_SERVICES = response.data.reg_services;
            },
            function(error){
                $scope.show_paginator = 0;
                $scope.main_loader = 1;
                $scope.main_loader_status = "Error Occured, Please refresh...";
                console.log(error);
            }
        );
    }
    $scope.startDate = currentTime;
    $scope.endDate = currentTime;
    runPage($scope.selectedSERVICE,$stateParams.tid,1,$scope.startDate,$scope.endDate,1);


    

    //refresh service
    $scope.refresh = function(){
       $scope.startDate = currentTime;
       $scope.endDate = currentTime;
       runPage($scope.selectedSERVICE,1);
    };



    //change the page
    $scope.goToPage = function($p){
        $url = ($p == +1) ? $scope.TerminalOBJ.transactions.next_page_url:$scope.TerminalOBJ.transactions.prev_page_url;
        if($url == null){return;}
        $scope.show_paginator = 0;
        var conn = BasicComService.getAPI($url);
        conn.then(
            function(response){
                $scope.show_paginator = 1;
                console.log(response);
                $scope.TerminalOBJ = response.data;
            },
            function(error){
                console.log(error);
            }
        );
    };


   
    $scope.getService = function(service_name){
        console.log("find this service:",service_name);
        $scope.startDate = currentTime;
        $scope.endDate = currentTime;
        runPage(service_name,$stateParams.tid,1,$scope.startDate,$scope.endDate,1);
    };




}]);
