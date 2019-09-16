
COM.factory("BasicXlsxService",["$rootScope",
function($rootScope){

    var OBJ = {};

    OBJ.test = function(obj){
        alasql("CREATE TABLE cities (city string, population number)");
        alasql("INSERT INTO cities VALUES ('Rome',2863223),('Paris',2249975),('Berlin',3517424),('Madrid',3041579)");
        var res = alasql("SELECT * FROM cities");
        alasql('SELECT * INTO XLSX("commission_overview.xlsx",{headers:true}) FROM ?',[res]);
    };
   


   //overview function..
   OBJ.getExcelComOverview = function(xlsName,obj){
        alasql("CREATE TABLE commission_overview (id string, sale number, commission_value number)");


        //alasql("INSERT INTO commission_overview VALUES ('0',1000,0.2)");
        var services = obj.services;

        for(sev in services){
            console.log(sev);
            var cur_service = services[sev];
            var no_of_trans = Object.keys(cur_service).length;
            for(i = 0; i < no_of_trans;i++){
                alasql("INSERT INTO commission_overview VALUES (" + cur_service[i].ID + "," + cur_service[i].SALE + "," + cur_service[i].COMMISSION + ")");
            }
            
        }


        var res = alasql("SELECT * FROM commission_overview");
        alasql('SELECT * INTO XLSX("commission_overview.xlsx",{headers:true}) FROM ?',[res]);
        //console.log(res);
    };
    



    return OBJ;
}]);

