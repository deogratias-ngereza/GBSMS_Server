/**
 * controller
 */

GET_PESA.controller("GP_LoginController", ["$scope", "$state", "GP_AuthService", "GP_DumpService",
    function($scope, $state, GP_AuthService, GP_DumpService) {
        console.log("Login Controller");

        //status
        $scope.showLoginFormStatus = 1; //initial on
        $scope.loginStatusMsg = "";
        $scope.retryRedy = 0;


        $scope.user = {
            email: 'get_pesa_user@gmail.com',
            password: 'password'
        };

        //login
        $scope.login = function() {

            $scope.loginStatusMsg = "Loading..";
            $scope.showLoginFormStatus = 0;
            $scope.retryRedy = 0;

            var conn = GP_AuthService.postLogin($scope.user);
            conn.then(
                (resp) => {
                    GP_DumpService.log(0, -1, resp);
                    var token = resp.data.data.token;
                    var user = resp.data.data.user;

                    $scope.retryRedy = 1;

                    switch (resp.status) {
                        case 200:
                            $scope.loginStatusMsg = "Login Success.";
                            GP_AuthService.saveCurrentUser(user);
                            GP_AuthService.saveCurrentWebToken(token);
                            //go to the main page..
                            $state.go('app');
                            break;
                        default:
                            $scope.loginStatusMsg = "Wait abit..";
                            break;
                    }

                }, (err) => {

                    GP_DumpService.log(0, -1, err);
                    $scope.retryRedy = 1;
                    switch (err.status) {
                        case 422:
                            $scope.loginStatusMsg = "Invalid Credentials";
                            break;
                        case 500:
                            $scope.loginStatusMsg = "Server Error";
                            break;
                        default:
                            $scope.loginStatusMsg = "Unknown error!";
                            break;
                    }

                }
            ); //end conn

        };

        //retry 
        $scope.retry = function() {
            if ($scope.retryRedy == 1) {
                $scope.loginStatusMsg = "";
                $scope.showLoginFormStatus = 1;
            }

        };



    }
]);