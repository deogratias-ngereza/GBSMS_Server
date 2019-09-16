GET_PESA.factory("GP_BasicServices", ["$rootScope", "$http", "GET_PESA_LOGGING", "BASE_SERVER_URL",
    function($rootScope, $http, GET_PESA_LOGGING, BASE_SERVER_URL) {

        var OBJ = {};

        //list of purposes
        OBJ.get_list_of_purposes = function() {
            return $http.get(BASE_SERVER_URL + 'api/gp/list_of_purposes_with_loan_sub', { cache: true });
        };

        
        //pid and amount
        OBJ.get_list_of_companies_with_pid_and_amount = function(data) {
            return $http.get(BASE_SERVER_URL + 'api/gp/list_companies_with_given_purpose/' + data.pid + '/' + data.amount + '/', { cache: true });
        };

        //user profile infos
        OBJ.get_user_with_profile_info = function(data){
            return $http.get(BASE_SERVER_URL + 'api/gp/account_info/' + data.id);
        };


        //is user profile set
        OBJ.is_user_profile_set = function(data){
            return $http.get(BASE_SERVER_URL + 'api/gp/is_user_profile_set/' + data.id);
        };
        //get user profile
        OBJ.get_profile = function(data){
            return $http.get(BASE_SERVER_URL + 'api/gp/get_profile_data/' + data.id);
        };


        //update_basic_user_info
        OBJ.update_basic_user_info = function(data){
            return $http.post(BASE_SERVER_URL + 'api/gp/account_basic_user_update/',data);
        };
        //update_user_profile
        OBJ.update_user_profile = function(data){
            return $http.post(BASE_SERVER_URL + 'api/gp/account_user_profile_update/',data);
        };
        //check if the user do exists
        OBJ.check_if_mail_exists = function(data){
            return $http.get(BASE_SERVER_URL + 'api/gp/is_email_available/' + data.email);
        };
        //get bank info from id
        OBJ.get_bank_info_from_id = function(data){
            return $http.get(BASE_SERVER_URL + 'api/gp/get_company_with_id/' + data.id);
        };
        //get loan summary
        OBJ.get_loan_summary = function(data){
            return $http.get(BASE_SERVER_URL + 'api/gp/get_loan_summary/' + data.token);
        };




        return OBJ;
    }
]);