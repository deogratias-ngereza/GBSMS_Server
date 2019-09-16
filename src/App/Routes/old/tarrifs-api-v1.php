
<?php


/**
 * 
 * TARRIFS API
 * OPERATION
 *
 */


$app->group('/tarrifs-api-v1',function() use($app){   
    $app->get('',function(){
        return "-- Tarrifs api --";
    });
    $app->get('/',function(){
        return "-- Tarrifs api --";
    });


    //all other api grouped on tarrifs will follow here (any tarrif will apply)
    $app->get('/get_tarrif',\App\Controllers\TARRIFS_API\OperationalController::class.':get_tarrif_for');
    $app->get('/calculate_tarrif',\App\Controllers\TARRIFS_API\OperationalController::class.':get_tarrif_for');


    $app->get('/get_all_categorized_tarrifs',\App\Controllers\TARRIFS_API\OperationalController::class.':get_all_categorized_tarrifs');


    $app->get('/get_tarrifs_base_on_source',\App\Controllers\TARRIFS_API\OperationalController::class.':get_tarrifs_base_on_source_warehouse');
    $app->get('/get_tarrifs_base_on_destination',\App\Controllers\TARRIFS_API\OperationalController::class.':get_tarrifs_base_on_destination_warehouse');
    $app->get('/get_tarrifs_base_on_category_and_package',\App\Controllers\TARRIFS_API\OperationalController::class.':get_tarrifs_base_on_category_and_package');

    $app->post('/push_tarrif/{category}',\App\Controllers\TARRIFS_API\OperationalController::class.':push_tarrif');
    $app->post('/update_tarrif/{category}/{id}',\App\Controllers\TARRIFS_API\OperationalController::class.':update_tarrif');
    $app->delete('/delete_tarrif/{category}/{id}',\App\Controllers\TARRIFS_API\OperationalController::class.':delete_tarrif');



});//->add($jwt_middleware);


?>
