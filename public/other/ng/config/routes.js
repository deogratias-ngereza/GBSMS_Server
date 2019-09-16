GET_PESA.config(['$stateProvider', '$urlRouterProvider', '$locationProvider',
    function($stateProvider, $urlRouterProvider, $locationProvider) {

        $urlRouterProvider.otherwise('/');

        $stateProvider


            .state('login_user', {
            url: '/login_user',
            templateUrl: 'dist/ng/views/login_user.html',
            controller: 'GP_LoginController'
        })
        

        //main app layout
        .state('app', {
            url: '/',
            views: {
                '': { templateUrl: 'dist/ng/views/layout.html' },
                'nav@app': { templateUrl: 'dist/ng/views/components/main-nav.html' },
                'contents@app': { templateUrl: 'dist/ng/views/welcome.html' },
                'footer@app': { templateUrl: 'dist/ng/views/components/main-footer.html' },
            }
        })


        //staging steps to loans
        .state('app.loan_steps', {
                'url': 'loan_steps',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/loan-steps-layout.html',
                        controller: 'LoanStepsController'
                    }
                }
            })
            .state('app.loan_step_summary', {
                'url': 'loan_step_summary/:token',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/loan-step-final.html',controller:'GP_LoanStepFinalController'
                    }
                }
            })
            .state('app.about_us', {
                'url': 'about_us',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/about_us.html'
                    }
                }
            })
            .state('app.contact_us', {
                'url': 'contact_us',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/contact_us.html'
                    }
                }
            })
            .state('app.privacy', {
                'url': 'privacy',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/privacy.html'
                    }
                }
            })
            .state('app.thank_you', {
                'url': 'thank_you',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/thank_you.html'
                    }
                }
            })
            .state('app.bank', {
                'url': 'bank/:id',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/bank.html',controller:'GP_BankDetailsController'
                    }
                }
            })


            .state('app.dashboard', {
                'url': 'dashboard',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/dashboard.html',controller:'GP_DashMonitorController'
                    }
                }
            })

            .state('app.reset_password', {
                'url': 'reset_password',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/reset_password.html',//controller:'GP_DashMonitorController'
                    }
                }
            })

            .state('app.my_token', {
                'url': 'my_token',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/my_token.html',controller : function($scope,$state){
                            $scope.token = '';
                            $scope.view_summary = function(){
                                 if($scope.token.length >= 6){
                                    $state.go('app.loan_step_summary',{'token':$scope.token});
                                }else{
                                    swal({ title: "INVALID TOKEN",cancelButtonColor: "#DD6B55",confirmButtonColor: "#f37422"});
                                }
                            };
                        }
                    }
                }
            })



        //entrance to the app states...
        /*.state('app', {
                url: '/GET_PESAmission',
                views: {
                    '': { templateUrl: 'dist/ng/views/app.html', controller: 'MainGET_PESAController' },
                    'sidebar@app': { templateUrl: 'dist/ng/views/components/sidebar.html' },
                    //'contents@app' : { templateUrl : 'GET_PESA/dist/ng/views/welGET_PESAe.html', controller:'WelGET_PESAeController'}
                    'contents@app': { templateUrl: 'dist/ng/views/splash.html', controller: "SplashController" }
                }
            })
            //calculator
            .state('app.calculator', {
                'url': '/calculator',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/welGET_PESAe.html',
                        controller: 'WelGET_PESAeController'
                    }
                }
            })

        //search state
        .state('app.search', {
                'url': '/search',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/search.html',
                        controller: 'SearchController'
                    }
                }
            })
            //selected terminal state
            .state('app.terminal_id', {
                'url': '/terminal_id/:tid',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/selected_terminal.html',
                        controller: 'SelectedTerminalController'
                    }
                }
            })

        //selected service name(table name)
        .state('app.service_name', {
            'url': '/service_name/:name',
            views: {
                'contents@app': {
                    templateUrl: 'dist/ng/views/selected_service.html',
                    controller: 'SelectedServiceController'
                }
            }
        })

        //selected terminal state
        .state('app.terminal_list', {
                'url': '/terminal_list',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/list_all_terminals.html',
                        controller: 'ListAllTerminalController'
                    }
                }
            })
            //view list services and categories
            .state('app.services_list', {
                'url': '/services_list',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/services_list.html',
                        controller: 'ServiceListController'
                    }
                }
            })
            //about GET_PESAmission
            .state('app.about', {
                'url': '/about',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/about.html'
                    }
                }
            })










        //loading state
        .state('app.loading', {
                'url': '/loading',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/components/full_loading_page.html'
                    }
                }
            })
            //loading state
            .state('app.selected', {
                'url': '/selected',
                views: {
                    'contents@app': {
                        templateUrl: 'dist/ng/views/selected.html'
                    }
                }
            })

        //test state
        .state('app.test', {
            'url': 'app_test',
            views: {
                'contents@app': {
                    template: '<h1>app View</h1>'
                }
            }
        })*/

        //load all other shared routes here ..   

        ; //closing of the stateProvider..
    }
]);


GET_PESA.config(["$locationProvider", function($locationProvider) {
    $locationProvider.hashPrefix('');
}]);