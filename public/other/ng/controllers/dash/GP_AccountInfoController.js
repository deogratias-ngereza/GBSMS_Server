/**
 * GP_AccountInfoDashController
 *  Dash controller
 */

GET_PESA.controller("GP_AccountInfoDashController", ["$scope","$rootScope", "$state", "GP_BasicServices","GP_AuthService", "GP_DumpService",
function($scope,$rootScope, $state,GP_BasicServices, GP_AuthService, GP_DumpService) {
    GP_DumpService.log(0, -1, "Account info DashBoard Controller");

    $scope.user_info = {};

 

    //get profile info from the server 
    var getProfileInfoFromServer = function(){

        var user = GP_AuthService.getCurrentUser();
        $conn = GP_BasicServices.get_user_with_profile_info({id : user.id });
        $conn.then((suc)=>{
            GP_DumpService.log(0, -1, "res: " + JSON.stringify(suc.data.user));
            $scope.user_info = suc.data.user;
        },(err)=>{
            GP_DumpService.log(0, -1, "res: " +err);
        });
       
    };
    //getProfileInfoFromServer();//TODO::on start loading


    //init 
    $scope.init = function(){
        getProfileInfoFromServer();
        GP_DumpService.log(0, -1, "Start Account info module");
    };
    $rootScope.$on("AccountInfoEvent",function(){
        $scope.init();
    });
}
]);