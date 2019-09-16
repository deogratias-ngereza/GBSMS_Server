<?php

namespace App\Notify;

use App\Notify\TwillioSms;

class NotifierProvider{

	private $default_sms_provider = "TWILLIO";

	private $sms_activated = false;

	public function __construct(){
		
	}




	public function send_sms($receiver_phone,$sms_body){

		if($this->sms_activated == false) return "";

		switch ($this->default_sms_provider) {

			case 'TWILLIO':
				$smsProvider = new TwillioSms();
				try{
					$smsProvider->send_sms($this->getValidPhoneNo(trim($receiver_phone)),$sms_body);
				}catch(Exception $e){
					//::TODO record sms error
				}
				break;
			
			default:
				# code...
				break;
		}
	}




	public function getValidPhoneNo($phone){
		if($phone[0] == '0'){
			$valid_phone = '+255'.ltrim($phone, '0');//TZ country code no
			return $valid_phone;
		}else{
			return $phone;
		}
	}







}
?>