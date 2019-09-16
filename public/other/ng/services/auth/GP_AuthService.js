GET_PESA.factory("GP_AuthService", ["$rootScope", "$http", "BASE_SERVER_URL", "GP_DumpService", "$cookies", "$location", "$window",
    function($rootScope, $http, BASE_SERVER_URL, GP_DumpService, $cookies, $location, $window) {

        var OBJ = {};
        var now = new Date();
        var expiresValue = new Date(now); //for cookies

        var expTimeOne = expiresValue.setSeconds(now.getSeconds() + 86400); //in 24 hrs
        var expTimeTwo = expiresValue.setSeconds(now.getSeconds() + 604800); //in 1week


        //post login
        OBJ.postLogin = function(_data) {
            return $http.post(BASE_SERVER_URL + "api/auth/login", _data);
            /*return $http({
                url: BASE_SERVER_URL + "api/auth/login",
                method: 'POST',
                data: _data,
                headers: { 'Content-Type': 'application/json' },
                withCredentials: true
            });*/
        };


        //retrieve user from cookie
        OBJ.getCurrentUser = function() {
            return $cookies.getObject("GET_PESA_CUR_USER");
        };
        //save user to the cookie
        OBJ.saveCurrentUser = function(data) {
            $cookies.putObject("GET_PESA_CUR_USER", data, { 'expires.toUTCString': expTimeTwo });
            GP_DumpService.log(0, -1, "USER SAVED:" + $cookies.getObject("GET_PESA_CUR_USER"));
        };
        //save web token to the cookie
        OBJ.saveCurrentWebToken = function(data) {
            $cookies.putObject("GET_PESA_WEB_TOKEN", data, { 'expires.toUTCString': expTimeTwo });
            //$http.defaults.headers.common.Authorization = 'Bearer ' + data;//http://jasonwatmore.com/post/2016/04/05/angularjs-jwt-authentication-example-tutorial
            GP_DumpService.log(0, -1, "WEB TOKEN SAVED:" + $cookies.getObject("GET_PESA_WEB_TOKEN"));
        };
        //get web token to the cookie
        OBJ.getCurrentWebToken = function() {
            return $cookies.getObject("GET_PESA_WEB_TOKEN");
        };
        //logout the user..
        OBJ.logout = function() {
            $cookies.remove("GET_PESA_WEB_TOKEN");
            $cookies.remove("GET_PESA_CUR_USER");
        };
        //redirect to the login page
        OBJ.goToLoginPage = function() {
            $window.location.href = BASE_URL;
        };



        return OBJ;
    }
]);