/**
 * GP_DashMonitorController
 *  Dash controller
 */

GET_PESA.controller("GP_DashMonitorController", ["$scope","$rootScope" ,"$state", "GP_AuthService", "GP_DumpService",
function($scope,$rootScope, $state, GP_AuthService, GP_DumpService) {
    
    GP_DumpService.log(0, -1, "GP_DashMonitorCOntroller");

    /**variables */
    $scope.currentPage = "";
    
    //notify account info for the init
    $scope.goToPage = function(name){
        
        if($scope.currentPage == name){
            return ;
        }else{
            $scope.currentPage = name;
        }

        switch(name){
            case "ACCOUNT_INFO" : 
                $rootScope.$broadcast("AccountInfoEvent");//broadcasting
                break;
            case "ACCOUNT_INFO_EDIT" : 
                $rootScope.$broadcast("AccountInfoEditEvent");//broadcasting
                break;
            default: break;
        }
    };//end gotoPage
    



 


}
]);