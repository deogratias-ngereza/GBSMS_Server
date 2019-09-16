<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SMS_DirectSend extends BaseController{



    //send_sms_direct
    public function send_sms_direct($req,$res,$args){
    	$inputs = $req->getParsedBody();

    	//save the msg to db


        $sms_url = "http://192.168.43.1:5025/SendSMS/user=DFLT&password=123456&phoneNumber=".$inputs['phone']."&msg=".$inputs['msg_body'];
        /**/
        // Get cURL resource
		//$curl = curl_init(); 
		/*curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $sms_url
		    //CURLOPT_USERAGENT => 'Codular Sample cURL Request'
		));*/
		//curl_setopt($curl, CURLOPT_URL, $sms_url);
		//$resp = curl_exec($curl);
		//curl_close($curl);
		$curl = curl_init($sms_url);
		/**/

		$data = [
            "msg_data" => "",
            "inputs"=>$inputs['phone'],"str"=>$sms_url,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }





}