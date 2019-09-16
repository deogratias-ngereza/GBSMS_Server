<!doctype html>
<html lang="en" class="no-js" ng-app="APP">
<head>
  <meta charset="utf-8">
  <!--[if IE]><![endif]-->

  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Courier Inbounds And Outbounds</title>
  <meta name="description" content="Posta Arrivals & Departures">
  <meta name="author" content="Deogracious D Ngereza">
  <!--<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">-->
  <!-- Latest compiled and minified CSS -->
   <link rel="stylesheet" href="./../../../../../../displaying_boards/css/bootstrap.min.css">
  <link rel="stylesheet" href="./../../../../../../displaying_boards/css/style.css?v=1">
  <script src="./../../../../../../displaying_boards/js/modernizr-1.5.min.js"></script>

  
  
  <style>
      
      .board_data_row td{
        color:white;
        font-family: 'TransportHeavyRegular';
        padding: 10px 20px;
        text-align: left;
        background-color:#292828;
        /*text-shadow: 0 1px 0 #DFDFDF;*/
      }
       /*.ng-enter {
        transition:all ease-in 1s;
        height: 0px;
       }*/
        tr {
            opacity: 1;
        }
        tr.ng-enter {
            -webkit-transition: 3s;
            transition: 3s;
            opacity: 0;
            
        }
        tr.ng-enter-active {
            opacity: 1;
        }
        /*.ng-move,
        .ng-enter,
        .ng-leave {
            -webkit-transition:all linear 0.5s;
            transition:all linear 0.5s;
        }*/

  </style>
</head>
<!--[if lt IE 7 ]> <body class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <body class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <body class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <body class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <body style="margin:20px;background-color:#333131;" <!--<![endif]-->
<!--<div class="load-bar" style="margin-top:0px;">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
        </div>-->
  <div id="container">
    <div id="date_time">
        <p id="flag">
          <img src="./../../../../../../displaying_boards/images/tz_flag.gif" class="img img-responsive" width="50px">
          <!--<img src="./images/logo.jpg" class="img img-responsive" width="50px">-->
        </p>
        <p id="cat_heading">(MSS-DAR)</p>
        <p id="time"></p>
        <p id="date"></p>
    </div>
    <header>
        <div class="row">
            <div class="col-md-6" id="left_header">
                <span class="glyphicon glyphicon-arrow-down blink" style="color:green;"></span>
                Inbounds {{temp_exposed_dt}}
            </div>
            <div class="col-md-6" id="right_header">
                <span class="glyphicon glyphicon-arrow-up blink2" style="color:red;"></span>
                Outbounds
            </div>
        </div>
    </header>
   
    <div id="main">
        
        <div class="row" ng-controller="MAIN_CONTROLLER">
                
                <div class="col-md-6" ng-controller="ARRIVAL_CONTROLLER">
                    
                    <table id="xdepartures" style="width: 100%;" ng-cloak>
                           <thead ng-cloak>
                                <tr class="board_data_row" ng-cloak>
                                    <!--<th>TIME</th>-->
                                    <th style="width: 20%">FROM</th>
                                    <th style="width: 40%">TRACK</th>
                                    <th style="width: 20%">NAME</th>
                                    <th style="width: 20%">STATUS</th>
                                </tr>
                            </thead>
                    </table>
                    <table id="xdepartures" style="width: 100%;" ng-cloak>
                             
                            <tbody ng-cloak>
                                <!-- ******************************************* -->
                                <tr class="board_data_row" ng-repeat="route in ARRIVALS_LIST">
                                    <!--<td ><span class="glyphicon glyphicon-time" style="color:rgb(27, 141, 255);"></span>&nbsp&nbspTime</td>-->
                                    <td style="width: 20%">{{ route.source_warehouse.name }}</td>
                                    <td style="width: 40%" id="from_field">{{route.manifest_track_no}}</td>

                                    <td style="width: 20%" ng-if="route.customer.is_company">{{route.customer.company_name}}</td>
                                    <td style="width: 20%" ng-if="!route.customer.is_company">{{route.customer.first_name}}</td>

                                    <td style="width: 20%;color:{{getStatusColor(route.status)}};" >{{route.status}}</td>
                                </tr>
                                <!-- /******************************************* -->
                            </tbody>
                        </table>
                </div>



                <div class="col-md-6" ng-controller="DEPARTURE_CONTROLLER">
                    
                    <table id="departures" style="width:100%;" ng-cloak>
                            <thead>
                                <tr class="board_data_row" ng-cloak>
                                    <!--<th>TIME</th>-->
                                    <th style="width: 20%">TO</th>
                                    <th style="width: 40%">TRACK</th>
                                    <th style="width: 20%">NAME</th>
                                    <th style="width: 20%">STATUS</th>
                                </tr>
                            </thead>
                    </table>
                    <table id="departures" style="width: 100%;" ng-cloak>
                            <tbody ng-cloak>
                                <!-- ******************************************* -->
                                <tr class="board_data_row" ng-repeat="route in ARRIVALS_LIST">
                                    <!--<td ><span class="glyphicon glyphicon-time" style="color:rgb(27, 141, 255);"></span>&nbsp&nbspTime</td>-->
                                    <td style="width: 20%">{{ route.destination_warehouse.name }}</td>
                                    <td style="width: 40%" id="from_field">{{route.manifest_track_no}}</td>

                                    <td style="width: 20%" ng-if="route.customer.is_company">{{route.customer.company_name}}</td>
                                    <td style="width: 20%" ng-if="!route.customer.is_company">{{route.customer.first_name}}</td>

                                    <td style="width: 20%;color:{{getStatusColor(route.status)}};" >{{route.status}}</td>
                                </tr>
                                <!-- /******************************************* -->
                            </tbody>
                        </table>
                </div>
        </div>
		
    
    
    </div>
    
    <footer>

    </footer>
  </div> <!-- end of #container -->



 	<!--[if lt IE 7 ]>
    <script src="js/dd_belatedpng.js?v=1"></script>
  <![endif]-->
  <script src="./../../../../../../displaying_boards/js/jquery-1.7.2.min.js"></script>
  <script src="./../../../../../../displaying_boards/js/jquery.ngclock.0.1.js"></script>
  <script src="./../../../../../../displaying_boards/js/script.js?v=1"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular-animate.js"></script>

  <script src="./../../../../../../displaying_boards/ng/app.js"></script>


  <script type="text/javascript">
    APP.constant("DASH_CONSTANTS",{
        /*"SINGLE_GROUP_COUNTS":<?= $data['center_info']['board_constants']['grp_counts'];?>,//no of itms in a single board_side
        "REFRESH_DELAY" : <?= $data['center_info']['board_constants']['page_delay'];?>,//10000, //seconds,
        "PULL_SERVER_DATA_DELAY" : <?= $data['center_info']['board_constants']['pull_delay'];?>,//30000,


        //custom center info
        "CENTER_CODE" : <?= "'".$data['center_info']['center_code']."'";?>,
        "REC_DEPARTMENT_ID" : <?= $data['department_id'];?>,
        "CENTER_ID":<?= $data['center_info']['id'];?>,
        "IO_MODE" : <?= "'".$data['io_mode']."'";?>*/



        "SINGLE_GROUP_COUNTS":10,//no of itms in a single board_side
        "REFRESH_DELAY" : 5000,//10000, //seconds,
        "PULL_SERVER_DATA_DELAY" : 10000,//30000,


        //custom center info
        "WAREHOUSE_ID" : <?= $data['warehouse_id'];?> 
    });
  </script>
  
</body>
</html>