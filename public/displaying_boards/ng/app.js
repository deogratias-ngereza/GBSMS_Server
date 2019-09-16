var APP = angular.module('APP',['ngAnimate']);
APP.constant("BASE_SERVER_URL","http://192.168.1.22:5001/");
APP.constant("BASE_URL","http://192.168.43.192:7878/");

//http://192.168.43.192:5001/api-v1/manifest_all_for_warehouse/out/1
/*DATE SERVICES*/
APP.factory("DATE_SERVICE",[function(){
    var OBJ = {};
    OBJ.getTodaysDate = ()=>{
        var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    };
    OBJ.getYesterdaysDate = ()=>{
        var date = new Date();
        date.setDate(date.getDate()-1);
        return date.getFullYear() + '-' + (date.getMonth()+1) + '-' + date.getDate();
    };
    OBJ.getTomorrowsDate = ()=>{
        var currentDate = new Date();
        currentDate.setDate(currentDate.getDate() + 1);
        var day = currentDate.getDate();
        var month = currentDate.getMonth() + 1;
        var year = currentDate.getFullYear();
        return year + "-" + month + "-" + day;
    };
    return OBJ;
}]);


/**
 * SERVICE
 */
APP.factory("BOARD_SERVICE",["$http","BASE_SERVER_URL","DASH_CONSTANTS",function($http,BASE_SERVER_URL,DASH_CONSTANTS){
    var OBJ = {};
    OBJ.arrivals_api = function(dt,id,code){//manifest_all_for_warehouse/out/1
        //return $http.get(BASE_SERVER_URL + 'api-v1/boards_arrivals_api/' + dt + '/' + dt + '/' +  DASH_CONSTANTS.IO_MODE + '/' + id + "/" + code + "/" + DASH_CONSTANTS.REC_DEPARTMENT_ID, { cache : false});
        return $http.get(BASE_SERVER_URL + 'api-v1/manifest_all_for_warehouse/out/' + DASH_CONSTANTS.WAREHOUSE_ID, { cache : false});
    };
    OBJ.departures_api = function(dt,id,code){
        //return $http.get(BASE_SERVER_URL + 'api-v1/boards_departures_api/' + dt + '/' + dt + '/' +  DASH_CONSTANTS.IO_MODE + '/'  + id + "/" + code + "/"+ DASH_CONSTANTS.REC_DEPARTMENT_ID, { cache : false});
        return $http.get(BASE_SERVER_URL + 'api-v1/manifest_all_for_warehouse/in/' + DASH_CONSTANTS.WAREHOUSE_ID, { cache : false});
    };
    return OBJ;
}]);


/*MAIN CONTROLLER*/
APP.controller("MAIN_CONTROLLER",["$scope","$rootScope","$document","$timeout","$interval","BOARD_SERVICE","DATE_SERVICE","DASH_CONSTANTS",function($scope,$rootScope,$document,$timeout,$interval,BOARD_SERVICE,DATE_SERVICE,DASH_CONSTANTS){
    console.log("MAIN_CONTROLLER");
    var ARRIVALS_LIST = {};
    var DEPARTURES_LIST = {};
    //$scope.DATES_OPTIONS = [ DATE_SERVICE.getYesterdaysDate(),DATE_SERVICE.getTodaysDate(),DATE_SERVICE.getTomorrowsDate()];
    $scope.DATES_OPTIONS = [ DATE_SERVICE.getTodaysDate() ];
    $scope.CURRENT_DATE_INDEX = 0;

    var getArrivals = function(_dt){
        $conn = BOARD_SERVICE.arrivals_api(_dt,DASH_CONSTANTS.CENTER_ID,DASH_CONSTANTS.CENTER_CODE);
        $conn.then((resp)=>{
            $rootScope.temp_exposed_dt = _dt;//u can delete no effect here......
            if(resp.data.length >= 1) ARRIVALS_LIST = resp.data;//.msg_data;//only when there is data
            console.log("=>" + JSON.stringify(ARRIVALS_LIST));
        },(err)=>{
            console.log("DATA FAILED TO LOAD");
        });
        //notify
        $scope.$broadcast("NEW_ARRIVALS",ARRIVALS_LIST);
    };
    var getDepartures = function(_dt){
        $conn = BOARD_SERVICE.departures_api(_dt,DASH_CONSTANTS.CENTER_ID,DASH_CONSTANTS.CENTER_CODE);
        $conn.then((resp)=>{
            $rootScope.temp_exposed_dt = _dt;//u can delete no effect here......
            if(resp.data.length >= 1) DEPARTURES_LIST = resp.data;//.msg_data;//only when there is data
        },(err)=>{
            console.log("DATA FAILED TO LOAD");
        });
        //notify
        $scope.$broadcast("NEW_DEPARTURES",DEPARTURES_LIST);
    };

    $interval(()=>{
        $scope.CURRENT_DATE_INDEX++;
        if($scope.CURRENT_DATE_INDEX == 2) $scope.CURRENT_DATE_INDEX=0;
        console.log("refresh server data - " + $scope.DATES_OPTIONS[$scope.CURRENT_DATE_INDEX] );
        getArrivals($scope.DATES_OPTIONS[$scope.CURRENT_DATE_INDEX]);
        getDepartures($scope.DATES_OPTIONS[$scope.CURRENT_DATE_INDEX]);
    },DASH_CONSTANTS.PULL_SERVER_DATA_DELAY);

    getDepartures($scope.DATES_OPTIONS[$scope.CURRENT_DATE_INDEX]);
    getArrivals($scope.DATES_OPTIONS[$scope.CURRENT_DATE_INDEX]);

}]);



/**
 * ARRIVAL CONTROLLER
 */
APP.controller("ARRIVAL_CONTROLLER",["$scope","$document","$timeout","$interval","BOARD_SERVICE","DASH_CONSTANTS",function($scope,$document,$timeout,$interval,BOARD_SERVICE,DASH_CONSTANTS){
    console.log("ARRIVAL_CONTROLLER");
    //$document.ready(function(){});
    $scope.ARRIVALS_LIST = {};
    $scope.CURRENT_SIDE_NO = 0;
    $scope.DISPLAY_GROUPS = [];
    $scope.MAX_SIDES = 0;

    var partition = function(data){
        var single_temp_group = [];
        var _groups = [];
        var temp_data = data;
        while (data.length > 0){
            _groups.push(data.splice(0, DASH_CONSTANTS.SINGLE_GROUP_COUNTS));
        }
        $scope.DISPLAY_GROUPS = _groups;
        $scope.MAX_SIDES = _groups.length;
        $scope.CURRENT_SIDE_NO = 0;
    };

    $interval(()=>{
        console.log("refresh");
        var temp = $scope.ARRIVALS_LIST;
        $scope.ARRIVALS_LIST = {};
        $scope.display_next_data(temp);
    },DASH_CONSTANTS.REFRESH_DELAY);

    $scope.display_next_data = function(_data){
        $timeout(()=>{
            console.log("SIDE\n" + $scope.CURRENT_SIDE_NO);
            if($scope.CURRENT_SIDE_NO == $scope.MAX_SIDES){
                $scope.CURRENT_SIDE_NO = 0;
                $scope.ARRIVALS_LIST = $scope.DISPLAY_GROUPS[0];
            }else{
                $scope.ARRIVALS_LIST = $scope.DISPLAY_GROUPS[$scope.CURRENT_SIDE_NO];
                $scope.CURRENT_SIDE_NO += 1;
            }
        },100);
    };


    //LISTENER
    $scope.$on("NEW_ARRIVALS",function(evt,data){
        $scope.ARRIVALS_LIST = data;
        partition($scope.ARRIVALS_LIST);
    });

    //colors
    $scope.getStatusColor = function(status){
        switch(status){
            case "DELIVERED" : return "#1de549";break;
            case "DELIVERY_FAILED" : return "#f44a1a";break;
            case "ON_TRANSIT" : return "pink";break;
            case "ON_PROCESS" : return "orange";break;
            default : return "white";
        }
    };
    
}]);

/**
 * DEPARTURE CONTROLLER
 */
APP.controller("DEPARTURE_CONTROLLER",["$scope","$document","$timeout","$interval","BOARD_SERVICE","DASH_CONSTANTS",function($scope,$document,$timeout,$interval,BOARD_SERVICE,DASH_CONSTANTS){
    console.log("DEPARTURE_CONTROLLER");
    //$document.ready(function(){});
    $scope.ARRIVALS_LIST = {};
    $scope.CURRENT_SIDE_NO = 0;
    $scope.DISPLAY_GROUPS = [];
    $scope.MAX_SIDES = 0;
    var partition = function(data){
        var single_temp_group = [];
        var _groups = [];
        var temp_data = data;
        while (data.length > 0){
            _groups.push(data.splice(0, DASH_CONSTANTS.SINGLE_GROUP_COUNTS));
        }
        $scope.DISPLAY_GROUPS = _groups;
        $scope.MAX_SIDES = _groups.length;
        $scope.CURRENT_SIDE_NO = 0;
    };

    $interval(()=>{
        console.log("refresh");
        var temp = $scope.ARRIVALS_LIST;
        $scope.ARRIVALS_LIST = {};
        $scope.display_next_data(temp);
    },DASH_CONSTANTS.REFRESH_DELAY);

    $scope.display_next_data = function(_data){
        $timeout(()=>{
            console.log("SIDE\n" + $scope.CURRENT_SIDE_NO);
            if($scope.CURRENT_SIDE_NO == $scope.MAX_SIDES){
                $scope.CURRENT_SIDE_NO = 0;
                $scope.ARRIVALS_LIST = $scope.DISPLAY_GROUPS[0];
            }else{
                $scope.ARRIVALS_LIST = $scope.DISPLAY_GROUPS[$scope.CURRENT_SIDE_NO];
                $scope.CURRENT_SIDE_NO += 1;
            }
        },100);
    };

    //LISTENER
    $scope.$on("NEW_DEPARTURES",function(evt,data){
        //alert("new data " + JSON.stringify(data));
        $scope.ARRIVALS_LIST = data;
        partition($scope.ARRIVALS_LIST);
    });

     //colors
    $scope.getStatusColor = function(status){
        switch(status){
            case "DELIVERED" : return "#1de549";break;
            case "DELIVERY_FAILED" : return "#f44a1a";break;
            case "ON_TRANSIT" : return "pink";break;
            case "ON_PROCESS" : return "orange";break;
            default : return "white";
        }
    };
    
}]);

