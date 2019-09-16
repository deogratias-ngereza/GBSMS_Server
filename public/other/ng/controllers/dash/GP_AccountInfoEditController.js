
/**
 * GP_AccountInfoEditController
 *  Dash controller
 */

GET_PESA.controller("GP_AccountInfoEditController", ["$scope","$rootScope" ,"$state", "GP_BasicServices", "GP_AuthService", "GP_DumpService",
function($scope,$rootScope, $state, GP_BasicServices,GP_AuthService, GP_DumpService) {
    
    GP_DumpService.log(0, -1, "GP_AccountInfoEditController");

    $scope.user_info ={};
    $scope.showUserBasicLoaders = 0;//disabled
    $scope.basicUserLoaderMsg = "getPesa";
    $scope.showUserProfileLoaders = 0;//disabled
    $scope.userProfileLoaderMsg = "getPesa";


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
    getProfileInfoFromServer();//TODO:: remove this line












    /**basic info updater */
    $scope.SaveBasicInfo = function(){
        var user_obj = {
            username : document.getElementById('username').value,
            email : document.getElementById('email').value,
            old_password : document.getElementById('old_password').value,
            new_password : document.getElementById('new_password').value
        };
        //TODO::validate the user input
        var reg = /^\w+([-+.']\ w+)*@\w+([-. ]\w+)*\.\w+([-. ]\w+)*$/;
        if(reg.test(user_obj.email) == false || user_obj.username.length == 0 || user_obj.email.length == 0 || user_obj.old_password.length == 0 || user_obj.new_password.length == 0){
            $scope.basicUserLoaderMsg = "Fill all fields as required !!!";
            $scope.showUserBasicLoaders = 1;
            return;
        }

        
        $scope.basicUserLoaderMsg = "Updating...";
        $scope.showUserBasicLoaders = 1;//disabled
        //go to the server and update this profile
        $conn = GP_BasicServices.update_basic_user_info(user_obj);
        $conn.then((suc)=>{
            $scope.basicUserLoaderMsg = "Updated.";
            $scope.showUserBasicLoaders = 0;//disabled
            GP_DumpService.log(0, -1, "res: " + JSON.stringify(suc));
        },(err)=>{

            $scope.basicUserLoaderMsg = "Something went wrong!!!";
            $scope.showUserBasicLoaders = 0;//disabled
            GP_DumpService.log(0, -1, "res: " +err);
        });

    };//








    /***Profile updater */
    $scope.SaveUserProfileInfo = function(){
        var prof_obj = {
            user_id : $scope.user_info.id,
            profile_id : $scope.user_info.profile_id,
            profile_set : $scope.user_info.profile_set,
            first_name : document.getElementById('first_name').value,
            last_name : document.getElementById('last_name').value,
            contact : document.getElementById('contact_phone').value,
            bank_name : document.getElementById('bank_name').value,
            city : document.getElementById('city').value,
            workstation : document.getElementById('workstation').value,
            occupation : document.getElementById('occupation').value,
            mns : document.getElementById('mns').value,
            taj : document.getElementById('taj').value,
            cet : document.getElementById('cet').value,
            dob : document.getElementById('dob').value,
            other_loan : document.getElementById('other_loan').value,
            status : document.getElementById('status').value,
            short_story : document.getElementById('short_story').value,
            more_description : document.getElementById('more_description').value,
            summary : document.getElementById('summary').value,

        };
        //TODO::validate the inputs
        var truth = prof_obj.first_name.length == 0 || prof_obj.last_name.length == 0 || prof_obj.contact.length == 0 || prof_obj.bank_name.length == 0 
                    || prof_obj.city == "NONE" || prof_obj.workstation == "NONE" || prof_obj.mns == "NONE" || prof_obj.taj == "NONE" 
                    || prof_obj.cet == "NONE" || prof_obj.dob.length < 6;
        if(truth){
            $scope.userProfileLoaderMsg = "Fill all fields as required !!!";
            $scope.showUserProfileLoaders = 1;
            return;
        }

        $scope.userProfileLoaderMsg = "Updating...";
        $scope.showUserProfileLoaders = 1;//disabled
        //go to the server and update this profile
        $conn = GP_BasicServices.update_user_profile(prof_obj);
        $conn.then((suc)=>{
            $scope.userProfileLoaderMsg = "Updated.";
            $scope.showUserProfileLoaders = 0;//disabled
            GP_DumpService.log(0, -1, "res: " + JSON.stringify(suc));
        },(err)=>{

            $scope.userProfileLoaderMsg = "Something went wrong!!!";
            $scope.showUserProfileLoaders = 0;//disabled
            GP_DumpService.log(0, -1, "res: " +err);
        });


    };
    


     //init 
    $scope.init = function(){
        getProfileInfoFromServer();//on start loading
        GP_DumpService.log(0, -1, "Start Account info Edit module");
    };
    $rootScope.$on("AccountInfoEditEvent",function(){
        $scope.init();
    });

}]);