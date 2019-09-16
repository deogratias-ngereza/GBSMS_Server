
/**
 * STEP final
 * getting:
 *      
 */
GET_PESA.controller("GP_BankDetailsController", ["$scope", "$state","$sce", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state,$sce, GP_DumpService, GP_BasicServices, GP_AuthService) {
        GP_DumpService.log(0, -1, "GP_BankDetailsController");

        //received token
        $scope.RECEIVED_BANK_ID = $state.params.id;    
        $scope.COMPANY_OBJ = {};
        //shared vars
        $scope.bankDetailsLoader = 1;
        $scope.bankDetailsLoaderMsg = "Loading ..";

        
        


        $scope.get_bank_info = function(bank_id){
            var conn = GP_BasicServices.get_bank_info_from_id({id : bank_id});
            conn.then((resp)=>{

                if(resp.data.availability == 1){
                    $scope.bankDetailsLoader = 0;
                    GP_DumpService.log(0, -1, "bank-data- " + JSON.stringify(resp.data.data));
                    $scope.COMPANY_OBJ = resp.data.data;
                    
                    //set map link
                    set_google_map_link($scope.COMPANY_OBJ.g_map_link);
                }else{
                    $scope.bankDetailsLoader = 1;
                    $scope.bankDetailsLoaderMsg = resp.data.msg;
                }
                

            },(err)=>{
                alert(err);
            });
        };

        //start here..
        var start = function(){
            $scope.get_bank_info($scope.RECEIVED_BANK_ID);
        };
        start();



        //set ui link
        var set_google_map_link = function(_link){
            var mapsdata = '<iframe id="gFrame" src=' + _link + ' width="600" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>';
            $scope.map = $sce.trustAsHtml(mapsdata);
        };



}]);