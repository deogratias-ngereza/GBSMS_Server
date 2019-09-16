


/*
COM.controller("ServicesCatBrands",["$scope","$rootScope","$state","AuthService","BasicComService",
function($scope,$rootScope,$state,AuthService,BasicComService){
    console.log("Welcome Controller");

    $scope.loading = 1;
    $scope.GlobalOBJ = {};

    var conn = BasicComService.getServicesCatBrandsListAPI();
    conn.then(
        function(response){
            $scope.loading = 0;
            console.log(response);
            $scope.GlobalOBJ = response.data.data;
        },
        function(error){
            $scope.loading = 1;
            console.log(error);
        }
    );

}]);

*/