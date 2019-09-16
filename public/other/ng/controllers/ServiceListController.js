

COM.controller("ServiceListController",["$scope","$rootScope","$state","AuthService","BasicComService",
function($scope,$rootScope,$state,AuthService,BasicComService){
    console.log("ServiceListController");

    $scope.ServicesListOBJ = {};

    $scope.loading = 1;
    $scope.GlobalOBJ = {};
    $scope.ServicesListOBJ = {};

    var conn = BasicComService.getAllRegServicesAPI();
    conn.then(
        function(response){
            $scope.loading = 0;
            console.log(response);
            $scope.GlobalOBJ = response.data;
            $scope.ServicesListOBJ = response.data.services_list;
        },
        function(error){
            $scope.loading = 1;
            console.log(error);
        }
    );


}]);

