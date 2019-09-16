
/**
 * STEP final
 * getting:
 *      
 */
GET_PESA.controller("GP_LoanStepFinalController", ["$scope", "$state","$sce", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state,$sce,GP_DumpService, GP_BasicServices, GP_AuthService) {
        GP_DumpService.log(0, -1, "GP_LoanStepFinalController - " + $state.params.token);

       
       	//received token
       	$scope.RECEIVED_TOKEN = $state.params.token;	
       	$scope.loan_summary = {};
        $scope.summaryLoaderBlock = 1;
        $scope.summaryLoaderIndicator = 1;
        $scope.summaryMsg = "Loading ...";
        $scope.bankDetailsBlock = 0;


        //for bank details - CHECKOUT BankDetailsController for more
        $scope.COMPANY_OBJ = {};
        $scope.bankDetailsLoader = 1;
        $scope.bankDetailsLoaderMsg = "Loading ..";

       	//getting summary details
       	var get_summary_from_server = function(){
       		var conn = GP_BasicServices.get_loan_summary({token:$scope.RECEIVED_TOKEN});
       		conn.then((resp)=>{
       			GP_DumpService.log(0, -1, "Summary - " + JSON.stringify(resp.data));
            $scope.summaryLoaderIndicator = 0;
            if(resp.data.available == 1){
                $scope.loan_summary = resp.data.data;
                $scope.summaryLoader = 0;
                $scope.summaryLoaderBlock = 0;
                //now get banking informations
                get_bank_details_from_server($scope.loan_summary.company_id);
            }else{
                $scope.summaryLoader = 1;
                $scope.summaryMsg = "Sorry we could not match the given Token or it has expired!!";
            }
       		},(err)=>{
       			GP_DumpService.log(0, -1, "Summary error - " + err);
       		});
       	};
       	


        //start here..
        var start = function(){
            get_summary_from_server();
        };
        start();





        //for showing bank details section - CHECKOUT BankDetailsController for more
        var get_bank_details_from_server = function($b_id){
          $scope.bankDetailsBlock = 1;
          var conn = GP_BasicServices.get_bank_info_from_id({id:$b_id});
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
            GP_DumpService.log(0, -1, "BankDetails error - " + err);
          });
        };
        //set ui link - CHECKOUT BankDetailsController for more
        var set_google_map_link = function(_link){
            var mapsdata = '<iframe id="gFrame" src=' + _link + ' width="600" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>';
            $scope.map = $sce.trustAsHtml(mapsdata);
        };



}]);