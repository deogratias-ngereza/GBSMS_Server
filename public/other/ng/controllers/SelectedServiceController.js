

COM.controller("SelectedServiceController",["$timeout","$scope","$state","$stateParams","AuthService","BasicComService",
function($timeout,$scope,$state,$stateParams,AuthService,BasicComService){
    console.log("SelectedServiceController");

    $scope.main_loader = 1;
    $scope.serviceNAME = $stateParams.name;
    $scope.serviceOBJ = [{AMT:"",COMMISSION:"",ID:"",RESPONCE_CODE:""}];
    $scope.show_paginator = 0;
    $scope.dateChangeLoader = 1;
    $scope.SIMPLE_SERVICES = {};




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
       runPage($scope.serviceNAME,1,$scope.startDate,$scope.endDate,1);
    };
    $scope.onSet = function(){
       $scope.startDate = currentTime;
       $scope.endDate = currentTime;
       
       var s_date = document.getElementById("datepicker_start").value;
       var e_date = document.getElementById("datepicker_end").value;
       $scope.startDate = s_date;
       $scope.endDate = e_date;
    };








    function runPage($serv,$s_type,$s_date,$e_date,$page_no){
        $scope.main_loader = 1;
        $scope.dateChangeLoader = 1;
        //retrieve a single service given from url
        var conn = BasicComService.getServiceTransDataAPI($serv,$s_type,$s_date,$e_date,$page_no);
        conn.then(
            function(response){
                $scope.show_paginator = 1;
                $scope.main_loader = 0;
                $scope.dateChangeLoader = 0;//hide date change loader
                console.log(response);
                $scope.serviceOBJ = response.data;
                $scope.SIMPLE_SERVICES = response.data.reg_services;
            },
            function(error){
                $scope.show_paginator = 0;
                $scope.main_loader = 1;
                $scope.main_loader_status = "Error Occured, Please refresh...";
                console.log(error);
            }
        );
        $scope.main_loader = 0;
    }
    console.log("START DATE :",$scope.startDate);
    console.log("END DATE :",$scope.endDate);
    $scope.startDate = currentTime;
    $scope.endDate = currentTime;
    runPage($scope.serviceNAME,1,$scope.startDate,$scope.endDate,1);



    //refresh service
    $scope.refresh = function(){
        $scope.startDate = currentTime;
        $scope.endDate = currentTime;
        runPage($scope.serviceNAME,1,$scope.startDate,$scope.endDate,1);
    };



    //change the page
    $scope.goToPage = function($p){
        console.log("go to",$p);
        $url = ($p == +1) ? $scope.serviceOBJ.transactions.next_page_url:$scope.serviceOBJ.transactions.prev_page_url;
        if($url == null){return;}
        $scope.show_paginator = 0;
        var conn = BasicComService.getAPI($url);
        conn.then(
            function(response){
                $scope.show_paginator = 1;
                console.log(response);
                $scope.serviceOBJ = response.data;
            },
            function(error){
                console.log(error);
            }
        );
    };








}]);
