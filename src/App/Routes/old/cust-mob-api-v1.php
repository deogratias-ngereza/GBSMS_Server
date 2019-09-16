<?php





/**
 * AUTH
 */
$app->post('/cust-mob-api-v1/register',\App\Controllers\CUSTOMER_MOB_API\API_AuthController::class.':register')->add($cust_mob_check_register_params);
$app->post('/cust-mob-api-v1/login_by_phone',\App\Controllers\CUSTOMER_MOB_API\API_AuthController::class.':login_by_phone')->add($cust_mob_check_login_params);
$app->post('/cust-mob-api-v1/request_password_recovery',\App\Controllers\CUSTOMER_MOB_API\API_AuthController::class.':request_password_recovery');
$app->post('/cust-mob-api-v1/verify_otp',\App\Controllers\CUSTOMER_MOB_API\API_AuthController::class.':verify_otp');
$app->post('/cust-mob-api-v1/reset_password',\App\Controllers\CUSTOMER_MOB_API\API_AuthController::class.':reset_password');
$app->post('/cust-mob-api-v1/resend_reg_otp',\App\Controllers\CUSTOMER_MOB_API\API_AuthController::class.':resend_reg_otp');




/**
 * 
 * COURIER MOBILE API
 * [ CUSTOMER ]
 *
 */
$app->group('/cust-mob-api-v1',function() use($app){   
    

    $app->get('',function(){
        return "-- Mobile [ customer ] api --";
    });
    $app->get('/',function(){
        return "-- Mobile [ customer ] api --";
    });




   // $app->get('/customer_addresses',\App\Controllers\COURIER_API\API_CustomerAddressController::class.':all');
    //$app->get('/customer_addresses_find/{id}',\App\Controllers\COURIER_API\API_CustomerAddressController::class.':find');
    //$app->delete('/customer_addresses_delete/{id}',\App\Controllers\COURIER_API\API_CustomerAddressController::class.':delete');
    $app->post('/customer_addresses_insert',\App\Controllers\CUSTOMER_MOB_API\API_CustomerAddressController::class.':insert');
    //$app->put('/customer_addresses_update/{id}',\App\Controllers\COURIER_API\API_CustomerAddressController::class.':update');
   // $app->get('/customer_addresses_search',\App\Controllers\COURIER_API\API_CustomerAddressController::class.':search');
    

    $app->put('/customer_update/{id}',\App\Controllers\CUSTOMER_MOB_API\API_CustomerController::class.':update');

    $app->get('/pickup_requests_for_customer/{customer_id}',\App\Controllers\CUSTOMER_MOB_API\API_PickupRequestController::class.':all_for_customer');
    $app->post('/pickup_request_insert',\App\Controllers\CUSTOMER_MOB_API\API_PickupRequestController::class.':insert');

    $app->get('/customer_manifest_search_by_id/{customer_id}',\App\Controllers\CUSTOMER_MOB_API\API_ManifestController::class.':get_all_customer_manifests_by_id');

    $app->get('/get_prod_mov_history/{manifest_id}',\App\Controllers\CUSTOMER_MOB_API\API_HistoryController::class.':all_for_product_id');
    $app->get('/get_history_for_manifest/{manifest_id}',\App\Controllers\CUSTOMER_MOB_API\API_HistoryController::class.':get_history_for_manifest');
    $app->get('/get_all_history_for_manifest_cust/{customer_id}',\App\Controllers\CUSTOMER_MOB_API\API_HistoryController::class.':get_history_for_manifest_customer');
   	$app->get('/get_all_customer_manifests_by_id_with_history/{customer_id}',\App\Controllers\CUSTOMER_MOB_API\API_ManifestController::class.':get_all_customer_manifests_by_id_with_history');


   	

//all_for_product_id 


});//->add($jwt_middleware);


?>