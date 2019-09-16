
COM.controller("LoginController",["$scope","$state","AuthService",function($scope,$state,AuthService){
    console.log("Login Controller");

    $scope.loginOBJ = {};
    $scope.s_loading_msg = "Loading";
    $scope.loading = 0;



    //function to login user
    $scope.login = function(){
        $scope.loading = 1;
        $scope.s_loading_msg = "Signing in";
        var conn = AuthService.postLogin($scope.loginOBJ);
        conn.then(
            function(response){
                $scope.s_loading_msg = "Success";
                $scope.loading = 1;
                AuthService.saveCurrentWebToken(response.data.data.token);
                AuthService.saveCurrentUser(response.data.data.user);
                $state.go("app");
            },
            function(error){
                console.log(error);
                $scope.s_loading_msg = "Check your Credentials";
                $scope.loading = 1;
            }
        );
    };





}]);
