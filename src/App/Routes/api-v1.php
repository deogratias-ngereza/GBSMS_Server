<?php
/**/

//session_write_close(true);
/**
 * PING ME
 */
$app->get('/test-api-v1/ping_me',function(){
    $data = ["msg_data" => "LIVE","msg_status" => "OK"];
    return $data;
});
$app->get('/test-api-v1/time_zone',function(){
    $data = ["msg_data" => date("Y/m/d h:i:sa"),"msg_status" => "OK"];
    //return $data;
    echo date("Y/m/d h:i:sa");
});


$app->get('/ping-api-v1',function(){
    $data = ["msg_data" => "LIVE","msg_status" => "OK"];
    return json_encode($data,true);
});



/**
 * AUTH
 */
$app->post('/op-mob-api-v1/login',\App\Controllers\COURIER_OP_MOB_API\API_AuthController::class.':login')->add($op_mob_check_login_params);
$app->post('/op-mob-api-v1/login_by_phone',\App\Controllers\COURIER_OP_MOB_API\API_AuthController::class.':login_by_phone')->add($op_mob_check_login_params);


$app->post('/api-v1/login',\App\Controllers\COURIER_API\API_AuthController::class.':login');
$app->post('/api-v1/login_by_phone',\App\Controllers\COURIER_API\API_AuthController::class.':login_by_phone');
$app->post('/api-v1/reset_password',\App\Controllers\COURIER_API\API_AuthController::class.':reset_password');
$app->get('/api-v1/resetting_workers_password',\App\Controllers\COURIER_API\API_AuthController::class.':resetting_workers_password');

$app->post('/xlogin',function($req,$res,$args){
    $data = ["msg_data" => "LIVE","msg_status" => "OK"];
    return json_encode($data,true);
});





/**
 * DOCUMENTATIONS
 */
$app->get('/api_documentation',\App\Controllers\DocController::class.':get_api_documentation');









/**
 * 
 * COURIER MOBILE API
 * OPERATION
 *
 */
$app->group('/op-mob-api-v1',function() use($app){   
    $app->get('',function(){
        return "-- Mobile operation api --";
    });


    //App\Controllers\COURIER_OP_MOB_API


});//->add($jwt_middleware);





/**
 * 
 * PROTECTED BY JWT
 * 
 */
$app->group('/api-v1',function() use($app){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');

    $app->get('',function(){
        return "-- GTech api v1 --";
    });


    $app->get('/',function(){
        return "-- GTech api v1 --";
    });
    


    //direct send sms
    $app->post('/send_sms',\App\Controllers\GB_SMS\SMS_DirectSend::class.':send_sms_direct');
   




    
    $app->get('/customer_accounts',\App\Controllers\GB_SMS\API_CustomerAccController::class.':all');
    $app->get('/customer_accounts_find/{id}',\App\Controllers\GB_SMS\API_CustomerAccController::class.':find');
    $app->delete('/customer_accounts_delete/{id}',\App\Controllers\GB_SMS\API_CustomerAccController::class.':delete');
    $app->post('/customer_accounts_insert',\App\Controllers\GB_SMS\API_CustomerAccController::class.':insert');
    $app->put('/customer_accounts_update/{id}',\App\Controllers\GB_SMS\API_CustomerAccController::class.':update');
    $app->get('/customer_accounts_search',\App\Controllers\GB_SMS\API_CustomerAccController::class.':search');
    $app->get('/customer_accounts_tbl_fields',\App\Controllers\GB_SMS\API_CustomerAccController::class.':tbl_fields');
    


    $app->get('/sms_contacts',\App\Controllers\GB_SMS\API_SMSContactController::class.':all');
    $app->get('/sms_contacts_for_account/{account_id}/{group_id}',\App\Controllers\GB_SMS\API_SMSContactController::class.':all_for_account');
    $app->get('/sms_contacts_find/{id}',\App\Controllers\GB_SMS\API_SMSContactController::class.':find');
    $app->delete('/sms_contacts_delete/{id}',\App\Controllers\GB_SMS\API_SMSContactController::class.':delete');
    $app->post('/sms_contacts_insert',\App\Controllers\GB_SMS\API_SMSContactController::class.':insert');
    $app->put('/sms_contacts_update/{id}',\App\Controllers\GB_SMS\API_SMSContactController::class.':update');
    $app->get('/sms_contacts_search',\App\Controllers\GB_SMS\API_SMSContactController::class.':search');
    $app->get('/sms_contacts_tbl_fields',\App\Controllers\GB_SMS\API_SMSContactController::class.':tbl_fields');


    
    $app->get('/sms_drafts',\App\Controllers\GB_SMS\API_SMSDraftController::class.':all');
    $app->get('/sms_drafts_find/{id}',\App\Controllers\GB_SMS\API_SMSDraftController::class.':find');
    $app->delete('/sms_drafts_delete/{id}',\App\Controllers\GB_SMS\API_SMSDraftController::class.':delete');
    $app->post('/sms_drafts_insert',\App\Controllers\GB_SMS\API_SMSDraftController::class.':insert');
    $app->put('/sms_drafts_update/{id}',\App\Controllers\GB_SMS\API_SMSDraftController::class.':update');
    $app->get('/sms_drafts_search',\App\Controllers\GB_SMS\API_SMSDraftController::class.':search');
    $app->get('/sms_drafts_tbl_fields',\App\Controllers\GB_SMS\API_SMSDraftController::class.':tbl_fields');
    
    $app->get('/sms_groups_for_account/{account_id}',\App\Controllers\GB_SMS\API_SMSGroupController::class.':all_for_account');
    $app->get('/sms_groups',\App\Controllers\GB_SMS\API_SMSGroupController::class.':all');
    $app->get('/sms_groups_find/{id}',\App\Controllers\GB_SMS\API_SMSGroupController::class.':find');
    $app->delete('/sms_groups_delete/{id}',\App\Controllers\GB_SMS\API_SMSGroupController::class.':delete');
    $app->post('/sms_groups_insert',\App\Controllers\GB_SMS\API_SMSGroupController::class.':insert');
    $app->put('/sms_groups_update/{id}',\App\Controllers\GB_SMS\API_SMSGroupController::class.':update');
    $app->get('/sms_groups_search',\App\Controllers\GB_SMS\API_SMSGroupController::class.':search');
    $app->get('/sms_groups_tbl_fields',\App\Controllers\GB_SMS\API_SMSGroupController::class.':tbl_fields');
    


    $app->get('/sms_histories',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':all');
    $app->get('/sms_histories_find/{id}',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':find');
    $app->delete('/sms_histories_delete/{id}',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':delete');
    $app->post('/sms_histories_insert',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':insert');
    $app->put('/sms_histories_update/{id}',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':update');
    $app->get('/sms_histories_search',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':search');
    $app->get('/sms_histories_tbl_fields',\App\Controllers\GB_SMS\API_SMSHistoryController::class.':tbl_fields');



    
    $app->get('/sms_incomings',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':all');
    $app->get('/sms_incomings_find/{id}',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':find');
    $app->delete('/sms_incomings_delete/{id}',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':delete');
    $app->post('/sms_incomings_insert',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':insert');
    $app->put('/sms_incomings_update/{id}',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':update');
    $app->get('/sms_incomings_search',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':search');
    $app->get('/sms_incomings_tbl_fields',\App\Controllers\GB_SMS\API_SMSIncomingController::class.':tbl_fields');



    
    $app->get('/sms_outgoings',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':all');
    $app->get('/sms_outgoings_find/{id}',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':find');
    $app->delete('/sms_outgoings_delete/{id}',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':delete');
    $app->post('/sms_outgoings_insert',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':insert');
    $app->put('/sms_outgoings_update/{id}',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':update');
    $app->get('/sms_outgoings_search',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':search');
    $app->get('/sms_outgoings_tbl_fields',\App\Controllers\GB_SMS\API_SMSOutgoingController::class.':tbl_fields');
    

});//->add($jwt_middleware);






?>