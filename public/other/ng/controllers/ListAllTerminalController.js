
COM.controller("ListAllTerminalController",["$scope","$state","AuthService","BasicComService",
function($scope,$state,AuthService,BasicComService){
    console.log("ListAllTerminalController");

    $scope.main_loader = 1;
    $scope.main_loader_status = "Wait abit..";
    $scope.show_paginator = 0;

    $scope.TerminalListOBJ = {};
    $scope.TerminalModalOBJ = {};

    function runPage($page_no){
        //console.log("goto page:",);
        var conn = BasicComService.getAllTerminalAPI($page_no);
        conn.then(
            function(response){
                $scope.show_paginator = 1;
                $scope.main_loader = 0;
                console.log(response);
                $scope.TerminalListOBJ = response.data;
            },
            function(error){
                $scope.main_loader = 1;
                $scope.main_loader_status = "Error Occured, Please refresh...";
                console.log(error);
            }
        );
    }
    runPage(1);


    

    //function to set data in modal
    $scope.viewInModal = function(data){
        $scope.TerminalModalOBJ = data;
    };



    $scope.refresh = function(){
        $scope.main_loader = 1;
        $scope.main_loader_status = "Retry..";
         runPage(1);
    };



    //change the page
    $scope.goToPage = function($p){
        $url = ($p == +1) ? $scope.TerminalListOBJ.next_page_url:$scope.TerminalListOBJ.prev_page_url;
        if($url == null){return;}
        $scope.show_paginator = 0;
        var conn = BasicComService.getAPI($url);
        conn.then(
            function(response){
                $scope.show_paginator = 1;
                console.log(response);
                $scope.TerminalListOBJ = response.data;
            },
            function(error){
                console.log(error);
            }
        );
    };





}]);

