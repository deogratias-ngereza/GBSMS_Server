/**
 * controller
 * 
 * -> 4 stages
 */

GET_PESA.controller("LoanStepsController", ["$scope", "$state", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state, GP_DumpService, GP_BasicServices, GP_AuthService) {
        console.log("Loan Step Controller");

        $scope.CURRENT_STEP_NO = 4;//default start from step 1
        //$scope.STEP_HELPER_DATA = {};
        $scope.STEP_1_DATA = {};
        $scope.STEP_2_DATA = {};
        $scope.STEP_3_DATA = {};
        $scope.STEP_4_DATA = {};
        

        //go to step function
        $scope.goToStep = function(step_no) {
            $scope.CURRENT_STEP_NO = step_no;
        };

        


        /**MANAGING THE VIEWS with includes (steps) */
        $scope.isThisActiveStep = function(step_no) {
            return ($scope.CURRENT_STEP_NO == step_no) ? true : false;
        };


        //data from different steps change
        $scope.updateStepData = function(s_no,data){
            if(s_no == 1) $scope.STEP_1_DATA = data;
            else if(s_no == 2) $scope.STEP_2_DATA = data;
            else if(s_no == 3) $scope.STEP_3_DATA = data;
            else if(s_no == 4) $scope.STEP_4_DATA = data;
            else ;
        };

        //retrive step data
        $scope.getStepData = function(s_no){
            if(s_no == 1) return $scope.STEP_1_DATA;
            else if(s_no == 2) return $scope.STEP_2_DATA;
            else if(s_no == 3) return $scope.STEP_3_DATA;
            else if(s_no == 4) return $scope.STEP_4_DATA;
            else return -1;
        };




        //check if user 
        


    }
]);






















/**
 * STEP 1
 * getting:
 *      -> purpose-id & p_name
 *      -> sub-purpose-id & sub_p_name
 *      -> email
 *      -> amount
 */
GET_PESA.controller("GP_LoanStep1Controller", ["$scope", "$state", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state, GP_DumpService, GP_BasicServices, GP_AuthService) {
        GP_DumpService.log(0, -1, "Loan Step 1 Controller");

        $scope.list_of_purposes = {};
        $scope.list_of_sub_purposes = {};
        $scope.loadingStatus = 1;
        $scope.allRetry = 0;
        $scope.loadingMsg = "loading...";
        $scope.showEmptyEmailField = 1;
        $scope.isUserLoggedIn = 0;

        $scope.showSubLoanCatStatus = 0; //hide subloan field

        //aims
        $scope.SELECTED_PID = -1;
        $scope.SELECTED_PID_NAME = '';
        $scope.SELECTED_SUB_PID = -1;
        $scope.SELECTED_SUB_PID_NAME = '';
        //$scope.SELECTED_MAIL = 'xyz';
        $scope.SELECTED_AMOUNT = 0;


        //$scope.selectedPurpose = 'Other';
        //TODO::load default list prepared...

        //check if the user is login
        var cur_user = GP_AuthService.getCurrentUser();
        if(cur_user == null || undefined){
            //show empty mail fields
            $scope.showEmptyEmailField = 1; 
            $scope.isUserLoggedIn = 0;
        }else{
            //show un-empty mail fields
            $scope.showEmptyEmailField = 0;
            $scope.selectedMail = cur_user.email;
            $scope.isUserLoggedIn = 1;
        }//



        var getPurposesFromServer = function() {
            $scope.loadingStatus = 1;
            $scope.loadingMsg = "loading...";

            //get the list of purposes from the server...
            var conn = GP_BasicServices.get_list_of_purposes();
            conn.then((resp) => {

                GP_DumpService.log(0, -1, resp);
                $scope.loadingStatus = 0; //hide loader
                if (resp.status == 200) {
                    $scope.list_of_purposes = resp.data.purposes;
                    console.log("PS:" + resp.data.purposes);
                } else {
                    //TODO:: default lists
                }
            }, (err) => {
                $scope.loadingStatus = 1; //show loader
                $scope.allRetry = 1;
                $scope.loadingMsg = "Something went wrong...";
                GP_DumpService.log(0, -1, err);
            });
        };
        getPurposesFromServer(); //call API



        //retry
        $scope.retry = function() {
            if ($scope.allRetry == 1) {
                getPurposesFromServer(); //call API
            }
        };


        //when purpose is changed
        $scope.purposeChanged = function() {
            var p = document.getElementById('Loan_purpose');
            $scope.SELECTED_PID = p.value; //set pid here

            var p = document.getElementById('Loan_purpose');
            GP_DumpService.log(0, -1, "purpose changed to : " + p.value);

            if (p.value == -1) {
                $scope.SELECTED_SUB_PID = -1; //set pid here for subloans
                $scope.SELECTED_SUB_PID_NAME = 'NOT_DEFINED'; //set name here for subloans
                return;
            }
            //continue
            var selectedPurpose = getSelectedPurposeFromID(p.value);
            var subLoans = selectedPurpose.loan_sub_cats; //if not -1
            $scope.SELECTED_PID_NAME = selectedPurpose.p_name; //set name here
            if (subLoans.length > 0) {
                $scope.showSubLoanCatStatus = 1; //show subloan field
                $scope.list_of_sub_purposes = subLoans;
                GP_DumpService.log(0, -1, "has subloans");
            } else {
                $scope.showSubLoanCatStatus = 0; //show subloan field
                $scope.SELECTED_SUB_PID = -1; //default
                GP_DumpService.log(0, -1, "has no subloans");
            }
        };

        $scope.sub_purposeChanged = function() {
            //
            var p = document.getElementById('Sub_loan_purpose');
            $scope.SELECTED_SUB_PID = p.value; //set pid here
            GP_DumpService.log(0, -1, "sub purpose changed to : " + p.value);
            if (p.value == -1) {
                $scope.SELECTED_SUB_PID_NAME = 'NOT_DEFINED'; //set name here
                return;
            }
            //continue 
            var selectedSubPurpose = getSelectedSubPurposeFromID(p.value);
            $scope.SELECTED_SUB_PID_NAME = selectedSubPurpose.loan_name; //set name here
            GP_DumpService.log(0, -1, "sub loans is :" + $scope.SELECTED_SUB_PID_NAME);

        };

        //helper function to get the list of subloans
        var getSelectedPurposeFromID = function($id) {
            var objs = $scope.list_of_purposes;
            var pObject = {}; //
            function analyze(item, counter, objs) {
                if ($id == item.p_id) {
                    GP_DumpService.log(0, -1, "sub_loans ->" + item.loan_sub_cats);
                    pObject = item;
                }
            }
            objs.forEach(analyze);
            return pObject;
        }; //
        var getSelectedSubPurposeFromID = function($id) {
            var objs = $scope.list_of_sub_purposes;
            var pObject = {}; //
            function analyze(item, counter, objs) {
                if ($id == item.loan_id) {
                    pObject = item;
                }
            }
            objs.forEach(analyze);
            return pObject;
        }; //

        //check
        var step1_clean_up = function() {
            var data = {
                purpose_name: $scope.SELECTED_PID_NAME,
                purpose_id: $scope.SELECTED_PID,
                sub_purpose_name: $scope.SELECTED_SUB_PID_NAME,
                sub_purpose_id: $scope.SELECTED_SUB_PID,
                email: document.getElementById('Email_address').value,//$scope.selectedMail,
                amount: document.getElementById('Loan_amount').value
            };
            
            $scope.$parent.updateStepData(1,data);//assign data to the parent
            GP_DumpService.log(0, -1, "summary ->" + data);
        };

        $scope.goToStep2 = function() {

            //check if mail exists in the server
            var mail = document.getElementById('Email_address').value;
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if(!re.test(mail)){
                swal({ title: "INVALID INPUT",text: "INVALID EMAIL",cancelButtonColor: "#DD6B55",confirmButtonColor: "#f37422"});
                return;
            }

            if($scope.isUserLoggedIn == 0){
                var conn = GP_BasicServices.check_if_mail_exists({email : mail});
                conn.then((resp)=>{
                    GP_DumpService.log(0, -1, "check ->" + JSON.stringify(resp.data));
                    if(resp.data.availability == 0){//not available
                        //call parent controller for the next step
                        step1_clean_up();
                        if($scope.SELECTED_PID == '-1' || document.getElementById('Loan_amount').value <= 0){//TODO::validate
                            swal({ title: "INVALID INPUTS",cancelButtonColor: "#DD6B55",confirmButtonColor: "#f37422"});
                            return ;
                        }else{
                           $scope.$parent.goToStep(2); 
                       }
                        /////////////
                    }else{
                        swal({ title: "ACCOUNT ALREADY EXISTS",confirmButtonText: 'Sign In / Reset',cancelButtonText: 'Back',showCancelButton: true,cancelButtonColor: "#DD6B55",confirmButtonColor: "#f37422",closeOnConfirm: true,closeOnCancel: true,allowOutsideClick: "true",animation: true}, function(isConfirm) {
                          if (isConfirm) {
                            //deleted
                            $state.go('login_user');
                          } else {
                            //cancelled
                          }
                        });
                        return;
                    }
                    
                },(err)=>{
                    alert("Error while validating the email");
                    return;
                });  
            }//if user is login
            else{
                step1_clean_up();
                if($scope.SELECTED_PID == '-1' || document.getElementById('Loan_amount').value <= 0){//TODO::validate
                    swal({ title: "INVALID INPUTS",cancelButtonColor: "#DD6B55",confirmButtonColor: "#f37422"});
                    return ;
                }else{
                   $scope.$parent.goToStep(2); 
               }
            }

        };//end step 2





    }
]);
//end step1 controller



































































/**
 * STEP 2
 * getting:
 *      
 */
GET_PESA.controller("GP_LoanStep2Controller", ["$scope", "$state", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state, GP_DumpService, GP_BasicServices, GP_AuthService) {
        GP_DumpService.log(0, -1, "Loan Step 2 Controller");


        $scope.loadingStatus = 1;//show on start
        $scope.showFillingFormsStatus = 1;
        $scope.fillingProfData = {};
        $scope.isUserLoggedIn = 0;
        $scope.isUserProfSet = 0;

        //check if the user is login and has filled profile details
        var cur_user = GP_AuthService.getCurrentUser();
        if(cur_user == null || undefined){
            //show the filling forms
            $scope.showFillingFormsStatus = 1;
            $scope.loadingStatus = 0;
        }else{
            var conn = GP_BasicServices.is_user_profile_set({ id: cur_user.id});
            conn.then((resp)=>{
                $scope.loadingStatus = 0;//hide loader
                GP_DumpService.log(0, -1, resp);
                if(resp.data.available != 1){
                    //show the filling forms
                    $scope.showFillingFormsStatus = 1;
                }else{
                    //ask the user if information are valid and direct to dashboard
                    $scope.showFillingFormsStatus = 0;
                    $scope.fillingProfData = resp.data.data;
                    $scope.isUserProfSet = 1;
                }
            },(err)=>{
                GP_DumpService.log(0, -1, err);
            });
        }//










        $scope.SELECTED_FIRST_NAME = '';
        $scope.SELECTED_LAST_NAME = '';
        $scope.SELECTED_CONTACT = '';
        $scope.SELECTED_CITY = '';
        $scope.SELECTED_WORKSTATION = '';
        $scope.SELECTED_MONTHLY_NET_SALARY = 0;
        $scope.SELECTED_OCCUPATION = '';
        $scope.SELECTED_LOAN_b4 = 'NO';
        $scope.SELECTED_TIME_AT_JOB = '';
        $scope.SELECTED_CONT_EMP_TIME = '';
        $scope.SELECTED_DATE = '00-00-0000';

        console.log("step 2 : data(parent) -> "+ JSON.stringify($scope.$parent.getStepData(1)));


        //on any field changed
        $scope.changer = function(option) {
            GP_DumpService.log(0, -1, "OPT : " + option);
            switch (option) {
                case 'City':
                    $scope.SELECTED_CITY = document.getElementById('City').value;
                    break;
                case 'Workstation':
                    $scope.SELECTED_WORKSTATION = document.getElementById('Workstation').value;
                    break;
                case 'Monthly_net_salary':
                    $scope.SELECTED_MONTHLY_NET_SALARY = document.getElementById('Monthly_net_salary').value;
                    break;
                case 'Occupation':
                    $scope.SELECTED_OCCUPATION = document.getElementById('Occupation').value;
                    break;
                case 'Time_at_job':
                    $scope.SELECTED_TIME_AT_JOB = document.getElementById('Time_at_job').value;
                    break;
                case 'Cont_emp_time':
                    $scope.SELECTED_CONT_EMP_TIME = document.getElementById('Cont_emp_time').value;
                    break;
                case 'Other_loans':
                    $scope.SELECTED_LOAN_b4 = document.getElementById('Other_loans').value;
                    break;
                default:
                    break;
            }
        };

        //check
        var step2_clean_up = function() {
            var data = {
                //first_name : document.getElementById('first_name').value,
                //last_name : document.getElementById('last_name').value,
                //contact : document.getElementById('_contact').value,
                city: $scope.SELECTED_CITY,
                workstation: $scope.SELECTED_WORKSTATION,
                monthly_net_salary: $scope.SELECTED_MONTHLY_NET_SALARY,
                occupation: $scope.SELECTED_OCCUPATION,
                loan_b4: $scope.SELECTED_LOAN_b4,
                time_at_job: $scope.SELECTED_TIME_AT_JOB,
                cont_emp_time: $scope.SELECTED_CONT_EMP_TIME,
                date: document.getElementById('DoB').value
            };
            //sumary TODO:: validation
            GP_DumpService.log(0, -1, "test summary ->" + JSON.stringify(data));
            var truth1 = data.city == '-1' || data.workstation == '-1' || data.monthly_net_salary == '-1' || data.loan_b4 == '-1' 
                        || data.time_at_job == '-1' || data.occupation == '-1' || data.date.length < 8;
            var truth2 = data.city == "" || data.workstation == "" || data.monthly_net_salary == "" || data.loan_b4 == "" 
                        || data.time_at_job == "" || data.occupation == "" || data.date == "00-00-0000";
            //var truth3 = data.first_name == '' || data.last_name == '' || data.contact == '';
                    

            //check if user profile is set
            if($scope.isUserProfSet == 1){
                $scope.$parent.updateStepData(2,data);//assign data to the parent
                GP_DumpService.log(0, -1, "summary ->" + JSON.stringify(data));
                $scope.$parent.goToStep(3);
                return;
            }    
            //


            if(truth1 || truth2){
                swal({ title: "Fill all fields properly",cancelButtonColor: "#DD6B55",confirmButtonColor: "#f37422"});
                return ;
            }else{
                $scope.$parent.updateStepData(2,data);//assign data to the parent
                GP_DumpService.log(0, -1, "summary ->" + JSON.stringify(data));
                $scope.$parent.goToStep(3);
            }
        };

        $scope.goToStep3 = function() {
            //call parent controller for the next step


            step2_clean_up();
        };




    
}]);






































































/**
 * STEP 3
 * getting:
 *      
 */
GET_PESA.controller("GP_LoanStep3Controller", ["$scope", "$state", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state, GP_DumpService, GP_BasicServices, GP_AuthService) {
        GP_DumpService.log(0, -1, "Loan Step 3 Controller");


        $scope.loadingStatus = 1;//true
        $scope.loadingMsg = 'loading ...';
        $scope.AMOUNT_GIVEN = 1000000;//from step 1

        $scope.list_of_banks = {};
        $scope.purpose_info = {};
        $scope.application_info = {};



        //detailed id
        $scope.currentDetailedID = -1;



        //get list from the server..
        var getListOfCompaniesWithAmountAndPid = function(pid,amount){
            var conn = GP_BasicServices.get_list_of_companies_with_pid_and_amount({pid,amount});
            conn.then((resp)=>{
                $scope.loadingStatus = 0;//hide loader
                GP_DumpService.log(0, -1, resp);
                $scope.list_of_banks = resp.data.list;
                $scope.purpose_info = resp.data.purpose;
            },(err)=>{
                GP_DumpService.log(0, -1, err);
            });
        };


        //TODO::take from step 1
        getListOfCompaniesWithAmountAndPid(1,1000);

        $scope.applyFor = function(bData){
            $scope.application_info = bData;
            $scope.goToStep4();
        };

        $scope.getInfoFor = function(id){
            if($scope.currentDetailedID == id){
                $scope.currentDetailedID = -1;
                return;
            }
            $scope.currentDetailedID = id;
        };

        $scope.isThisDetailedId = function(id){
            return $scope.currentDetailedID == id ? true : false;
        };


         //check
         var step3_clean_up = function() {
            var data = {
                purpose_info : $scope.purpose_info,
                application_data : $scope.application_info
            };
            //sumary TODO::
            $scope.$parent.updateStepData(3,data);//assign data to the parent
            GP_DumpService.log(0, -1, "summary ->" + data);
        };

        $scope.goToStep4 = function() {
            //call parent controller for the next step
            step3_clean_up();
            $scope.$parent.goToStep(4);
        };


    }
]);



































































































/**
 * STEP 4
 * getting:
 *      
 */
GET_PESA.controller("GP_LoanStep4Controller", ["$scope", "$state", "GP_DumpService", "GP_BasicServices", "GP_AuthService",
    function($scope, $state, GP_DumpService, GP_BasicServices, GP_AuthService) {
        GP_DumpService.log(0, -1, "Loan Step 4 Controller");

        $scope.loadingStatus = 1;//loading
        $scope.PROFILE = {};



        



        //retun profile from user id
        $scope.get_user_profile_from_server = function($id){
            //
            var conn = GP_BasicServices.get_profile({id : $id});
            conn.then((resp)=>{
                GP_DumpService.log(0, -1, "prof : " + JSON.stringify(resp));

                $scope.PROFILE = resp.data.data;
                
            },(err)=>{
                GP_DumpService.log(0, -1, "prof - err : " + JSON.stringify(err));
            });

        };

        //check if the user is login
        var cur_user = GP_AuthService.getCurrentUser();
        if(cur_user == null || undefined){
            //
        }else{
            //check if is login and filled the profile set
            if(cur_user.profile_set == 1){
                $scope.get_user_profile_from_server(cur_user.profile_id);
            }
        }//








    
}]);//end step4Controller