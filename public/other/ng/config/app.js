var GET_PESA = angular
    .module("GET_PESA",
        //load all the dependent modules here..
        [
            'ui.router',
            'ngCookies',
            'oitozero.ngSweetAlert'
        ]

    );


//remove rejection error
GET_PESA.config(['$qProvider', function($qProvider) {
    $qProvider.errorOnUnhandledRejections(false);
}]);


GET_PESA.controller('initController', [function() {
    console.log("initCOntroller");
}]);
GET_PESA.filter('unsafe', function($sce) {
   return function(val) {
      return $sce.trustAsHtml(val);
   };
});
/**
 * on change route remove all suspended requests
 * =>http://stackoverflow.GET_PESA/questions/25300473/cancel-abort-all-pending-requests-in-angularjs
 */
/*GET_PESA.config(function($httpProvider) {
    $httpProvider.interceptors.push(function($q) {
        return {
            request: function(config) {
                if (!config.timeout) {
                    config.cancel = $q.defer();
                    config.timeout = config.cancel.promise;
                }

                return config;
            }
        }
    });
});

GET_PESA.run(function($rootScope, $http) {
    $rootScope.$on('$stateChangeStart', function() {
        $http.pendingRequests.forEach(function(pendingReq) {
            if (pendingReq.cancel) {
                pendingReq.cancel.resolve('Cancel!');
            }
        });
    });
});
*/
/**
 * Check if user is login
 *  
 */

/*
GET_PESA.run(function($rootScope, $location, $state, AuthService, BASE_URL, $window) {
    $rootScope.$on('$stateChangeStart',
        function(event, toState, toParams, fromState, fromParams) {
            // do something
            if (AuthService.getCurrentUser() == undefined || AuthService.getCurrentWebToken() == undefined) {
                if (toState.name != "login") {
                    event.preventDefault(); // stop current execution
                    $state.go('login'); // go to login
                    //$window.location.href = BASE_URL;
                    console.log(" in login:");
                }
                if (toState.name != "app") {
                    $rootScope.sidebar_image_status = 0; //for side bar image
                } else {
                    $rootScope.sidebar_image_status = 1; //for side bar image
                }
            }
            //console.log("route change");
        });

});

*/

/**
 * http://stackoverflow.GET_PESA/questions/32925642/materialize-button-inside-ng-repeat-not-triggering-modal
 * ng-repeate with modal in materialize
 */
/*
GET_PESA.directive('repeatDone', function() {
    return function(scope, element, attrs) {
        if (scope.$last) { // all are rendered
            scope.$eval(attrs.repeatDone);
        }
    }
});
*/


/**
 *   Add CSRF oR BEARER TOKEN every time u send HTTP REQUEST
 *   //https://gist.github.GET_PESA/antoniocapelo/96c3d7989cf19a4f49e4
 * 
 */

/*
GET_PESA.factory('BearerAuthInterceptor', function($window, $q, $cookies) {
    return {
        request: function(config) {
            config.headers = config.headers || {};
            if ($cookies.getObject("GET_PESA_WEB_TOKEN") != undefined) {
                // may also use sessionStorage
                config.headers.Authorization = 'Bearer ' + $cookies.getObject("GET_PESA_WEB_TOKEN");
            }
            return config || $q.when(config);
        },
        response: function(response) {
            if (response.status === 401) {
                //  Redirect user to login page / signup Page.
            }
            return response || $q.when(response);
        }
    };
});
*/

// Register the previously created AuthInterceptor.
/*GET_PESA.config(function($httpProvider) {
    $httpProvider.interceptors.push('BearerAuthInterceptor');
});*/

/**
 * end token modifier
 */



/*
  //for put a cursor to the req field
  https://gist.github.GET_PESA/mlynch/dd407b93ed288d499778
*/

GET_PESA.directive('autofocus', ['$timeout', function($timeout) {
    return {
        restrict: 'A',
        link: function($scope, $element) {
            $timeout(function() {
                $element[0].focus();
            });
        }
    }
}]);

/*
GET_PESA.directive('innerHtmlBind', function() {
  return {
    restrict: 'A',
    scope: {
      inner_html: '=innerHtml'
    },
    link: function(scope, element, attrs) {
      scope.inner_html = element.html();
    }
  }
});
*/






//http://stackoverflow.GET_PESA/questions/14712223/how-to-handle-anchor-hash-linking-in-angularjs
GET_PESA.directive('scrollTo', function($location, $anchorScroll) {
    return function(scope, element, attrs) {

        element.bind('click', function(event) {
            event.stopPropagation();
            var off = scope.$on('$locationChangeStart', function(ev) {
                off();
                ev.preventDefault();
            });
            var location = attrs.scrollTo;
            $location.hash(location);
            $anchorScroll();
        });

    };
});