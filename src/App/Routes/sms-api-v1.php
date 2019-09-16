<?php




/**
 * 
 * PROTECTED BY JWT
 * 
 */ 
$app->group('/gmtech-sms-api',function() use($app,$gateway_sms_mdw_chk_single_sms_body,$gateway_sms_mdw_chk_bulky_sms_body){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');

    $app->get('',function(){
        $msg = "<b>-- GMTech sms-api v1 --</b><br><br>";
        $msg .= "<br>-----------------------<br>";
        $msg .= "www.gmtech.co.tz<br>";
        $msg .= "Samaki wabichi house,Mbezi Beach,along Goba Road<br>";
        $msg .= "P.O.BOX 77960<br>";
        $msg .= "DSM, Tanzania<br>";
        $msg .= "+255 688059688 / +255788449030<br>";
        return $msg;
    });


    $app->get('/',function(){
        return "-- GTech sms-api v1 --";
    });
    

    /*
        Account info
    */
    $app->post('/account',\App\Controllers\GB_CSMS_API\API_ReportController::class.':account'); 

    /*
        sms sending route
    */
    $app->post('/send_sms',\App\Controllers\GB_CSMS_API\API_GeneralController::class.':send_sms')->add($gateway_sms_mdw_chk_single_sms_body);

    $app->post('/send_bulky_sms',\App\Controllers\GB_CSMS_API\API_GeneralController::class.':send_bulky_sms')->add($gateway_sms_mdw_chk_bulky_sms_body);




    


    //date report
    $app->post('/history/{start_date}/{end_date}/{status}',\App\Controllers\GB_CSMS_API\API_ReportController::class.':sms_history');   

    //delivery report
    $app->post('/dlr/{receipt_no}',\App\Controllers\GB_CSMS_API\API_ReportController::class.':dlr');
    
    //batch report
    $app->post('/batch_dlr/{batch_no}',\App\Controllers\GB_CSMS_API\API_ReportController::class.':batch_dlr');  

    
    
    $app->post('/xsend_sms',function(){
        /*$data = [
            "sms_quota" => 0,
            "receipt_no" =>md5('password'),
            "msg" => "Message sent to 1 receipient",
            "total_sms_sent"=>0,
            "total_recepient"=>0,
            "response_code"=>'000',
            "response_text"=> 'Success'
        ];  
        return json_encode($data,true);*/
        return md5("password")."password"."pass2";
    });


  // send_sms


})->add($gateway_sms_mdw_chk_acc_and_api_key);//check account_no and api key if set






?>