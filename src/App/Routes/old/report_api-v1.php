<?php


/**
 * 
 * REPORT API
 * OPERATION
 *
 */


$app->group('/report-api-v1',function() use($app){   
    $app->get('',function(){
        return "-- Report api --";
    });
    $app->get('/',function(){
        return "-- Report api --";
    });


    $app->get('/wh_products',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':all_wh_products');

    $app->get('/all_warehouses',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':all_warehouses');

    //get all the customers
    $app->get('/customers',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':all_customers');



    $app->get('/search_manifests',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':search_manifests');
    $app->get('/search_manifests_by_cust_date',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':search_manifests_by_cust_date');
    $app->get('/search_manifests_by_cust_date_product',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':search_manifests_by_cust_date_product');
    $app->get('/search_manifests_by_cust_date_product_warehouse',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':search_manifests_by_cust_date_product_warehouse');
    $app->get('/search_manifests_by_cust_date_n_sd',\App\Controllers\COURIER_REPORT_API\API_ReportController::class.':search_manifests_by_cust_date_sd');



    



});//->add($jwt_middleware);


?>
