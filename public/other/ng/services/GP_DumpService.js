GET_PESA.factory("GP_DumpService", ["$rootScope", "GET_PESA_LOGGING",
    function($rootScope, GET_PESA_LOGGING) {

        var OBJ = {};
        OBJ.test = function() {
            console.log("test_ function");
        };

        OBJ.log = function(option, status, msg) {
            //options 0  and 1 0->default,1->individual
            if (option == 1) {
                console.log(msg);
            } else {
                //check global options
                if (GET_PESA_LOGGING == true) {
                    console.log(msg);
                }
            }

        };


        return OBJ;
    }
]);