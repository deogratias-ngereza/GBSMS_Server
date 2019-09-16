


COM.controller("SearchController",["$scope","$state","AuthService","BasicComService",
function($scope,$state,AuthService,BasicComService){
    console.log("Search Controller");

    $scope.KEY = "";
    $scope.resOBJ = {};
    $scope.results_status = 0;
    $scope.results_msg = 0;

    //function to search..
    $scope.searchKey = function(KEY){
        if(KEY.length >= 3){
            $scope.resultViewer(1,0,"searching...");
            var conn = BasicComService.searchTerminalAPI({ 'searchKey' : KEY});
            conn.then(
                function(response){
                    $scope.resOBJ = response.data;
                    $scope.resultViewer(1,1,$scope.resOBJ);
                    console.log(response);
                },
                function(error){
                    $scope.resultViewer(0,0,"Error..");
                    console.log(error);
                }
            );
            
        }//end of if
        else{
            $scope.resOBJ = {};
            $scope.resultViewer(1,0,"Min 3 letters are required");
        }
    };

    //custome function to edit results view status 1 => show, type 1 => results no 0 => msg,obj => actual object or msg
    $scope.resultViewer = function(status,type,obj){
        $scope.results_status = status;//hide or show the msg
        if(type == 1){//its object given
            if(obj.length == 0){
                $scope.results_msg = "No match found";
            }else{
                $scope.results_msg = obj.length + "  Result" + (obj.length == 1 ? "" : "s");
            }
        }else{
            $scope.results_msg = obj;//actual msg
        }
        
    }

    

}]);
