
COM.factory("BasicComService",["$rootScope","$http","BASE_URL",
function($rootScope,$http,BASE_URL){

    var OBJ = {};

    //call api to retrieve all the terminals
    OBJ.getAllTerminalAPI = function(pg_no){
        return $http.get(BASE_URL + 'api/terminal/get_all_terminals/' + '?page=' + pg_no, { cache : true});
    };


    
    //new::call api to retrieve single terminal
    OBJ.getTerminalTransDataAPI = function(sev,tid,type,s_date,e_date,pg_no){
        return $http.get(BASE_URL + 'api/terminal/get_specific_terminal_trans_details/' + sev + "/" + tid + "/" + type + "/" + s_date + "/" + e_date + '?page=' + pg_no, { cache : true});
    };
    //new::call api to retrieve single service
    OBJ.getServiceTransDataAPI = function(name,s_type,s_date,e_date,pg_no){
        return $http.get(BASE_URL + 'api/services/get_service_trans_details/'+ name + '/' + s_type + '/' + s_date + '/' + e_date + '/' + '?page=' + pg_no, { cache : true});
    };

     //search terminal
    OBJ.searchTerminalAPI = function(obj){
        return $http.post(BASE_URL + 'api/terminal/search_terminal/',obj, { cache : true});
    };

    //get this month overview
    OBJ.getCurrentMonthOverviewAPI = function(){
        return $http.get(BASE_URL + "api/terminal/get_this_month_oveview/", { cache : true});
    };
    //get this month overview
    OBJ.getOverviewAPI = function(s_date,e_date){
        return $http.get(BASE_URL + "api/terminal/get_oveview/" + s_date + "/" + e_date + "/", { cache : true});
    };

    //get services categories and brands (remove)
    OBJ.getServicesCatBrandsListAPI = function(){
        return $http.get(BASE_URL + "api/services/services_cat_brands/",{ cache : true});
    };

    //get all reg services
    OBJ.getAllRegServicesAPI = function(){
        return $http.get(BASE_URL + "api/services/get_all_registered_services", { cache : true});
    };

    //anyGetapi
    OBJ.getAPI = function(url){
        return $http.get(url);
    };





    /*
        custom service name from given table name
        ::TODO
    */
    OBJ.getCustomServiceName = function($service){
        switch($service){
			 case "Azam_Master" : return "AZAMTV";break;
			 case "ETOPUP_Master" : return "AIRTEL ";break;
			 case "Bol_Master" : return "BOL";break;
			 case "CMSA_TRAN" : return "CMSA";break;
             case "Dart_Master" : return "DART";break;
             case "Dstv_Master" : return "DSTV";break;
			 case "Halotel_Master" : return "HALOTEL";break;
             case "BANK_TRAN" : return "BANK('General')";break;
			 case "ElecToken_Master" : return "LUKU ";break;
			 case "NEWLGA_Master" : return "LGA ";break;
             case "SMILE_TRAN" : return "SMILE";break;
             case "Starsms_master" : return "STARTIMES";break;
             case "TCU_Master" : return "TCU";break;
             case "TIGOBUNDLE_Master" : return "TIGO BUNDDLE";break;
             case "TRA_TRAN" : return "TRA MAGARI";break;
             case "Ttcl_Master" : return "TTCL";break;
             case "TrafficChallan_Master" : return "TRAFFIC";break;
             case "epin_tigo_master" : return "TIGO";break;
             case "Tanesco_Master" : return "TANESCO";break;
             case "TTCL_Master" : return "TTCL";break;
			 case "PSPF_Master" : return "PSPF";break;
			 case "vodacom_New_Master" : return "VODA";break;
			 case "WATERBILL_TRAN" : return "WATER BILL";break;
			 case "Zantel_Master" : return "ZANTEL";break;
             case "ZUKU_TRAN" : return "ZUKU";break;
            

            default: return $service;
        }
    };
    

    



    return OBJ;
}]);

