<?php
/**/


/**
 * 
 * PROTECTED BY JWT
 * 
 */
$app->group('/gfs-api-v1',function() use($app){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');

    $app->get('',function(){
        return "-- GTech Garage Fuel Stock api v1 --";
    });


    $app->get('/',function(){
        return "-- GTech Garage Fuel Stock api v1 --";
    });
    

 	$app->get('/gfs_constants',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_ConstantController::class.':all');
    $app->get('/gfs_constants_find/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_ConstantController::class.':find');
    $app->delete('/gfs_constants_delete/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_ConstantController::class.':delete');
    $app->post('/gfs_constants_insert',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_ConstantController::class.':insert');
    $app->put('/gfs_constants_update/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_ConstantController::class.':update');
    $app->get('/gfs_constants_search',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_ConstantController::class.':search');
    

    $app->get('/gfs_fuel_refills',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_Fuel_RefillController::class.':all');
    $app->get('/gfs_fuel_refills_find/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_Fuel_RefillController::class.':find');
    $app->delete('/gfs_fuel_refills_delete/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_Fuel_RefillController::class.':delete');
    $app->post('/gfs_fuel_refills_insert',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_Fuel_RefillController::class.':insert');
    $app->put('/gfs_fuel_refills_update/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_Fuel_RefillController::class.':update');
    $app->get('/gfs_fuel_refills_search',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_Fuel_RefillController::class.':search');
    
    
    $app->get('/gfs_issue_notes',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_issue_notesController::class.':all');
    $app->get('/gfs_issue_notes_find/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_issue_notesController::class.':find');
    $app->delete('/gfs_issue_notes_delete/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_issue_notesController::class.':delete');
    $app->post('/gfs_issue_notes_insert',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_issue_notesController::class.':insert');
    $app->put('/gfs_issue_notes_update/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_issue_notesController::class.':update');
    $app->get('/gfs_issue_notes_search',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_issue_notesController::class.':search');
    
    $app->get('/gfs_user_groups',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_user_groupsController::class.':all');
    $app->get('/gfs_user_groups_find/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_user_groupsController::class.':find');
    $app->delete('/gfs_user_groups_delete/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_user_groupsController::class.':delete');
    $app->post('/gfs_user_groups_insert',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_user_groupsController::class.':insert');
    $app->put('/gfs_user_groups_update/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_user_groupsController::class.':update');
    $app->get('/gfs_user_groups_search',\App\Controllers\GARAGE_FUEL_STOCK\API_GFS_user_groupsController::class.':search');
    
    $app->get('/gps_vehicles_records',\App\Controllers\GARAGE_FUEL_STOCK\API_GPS_VehicleRecordController::class.':all');
    $app->get('/gps_vehicles_records_find/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GPS_VehicleRecordController::class.':find');
    $app->delete('/gps_vehicles_records_delete/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GPS_VehicleRecordController::class.':delete');
    $app->post('/gps_vehicles_records_insert',\App\Controllers\GARAGE_FUEL_STOCK\API_GPS_VehicleRecordController::class.':insert');
    $app->put('/gps_vehicles_records_update/{id}',\App\Controllers\GARAGE_FUEL_STOCK\API_GPS_VehicleRecordController::class.':update');
    $app->get('/gps_vehicles_records_search',\App\Controllers\GARAGE_FUEL_STOCK\API_GPS_VehicleRecordController::class.':search');
    
    


});//->add($jwt_middleware);






?>