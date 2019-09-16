<?php

namespace App\Notify;

use Twilio\Rest\Client;

class TwillioSms{

	private $account_sid = "AC8e72d02e5d5b6caada297c32281acfe5";
	private $auth_token = "8379f6e2afca1a8781366edadd80749e";
	private $twilio_phone_number = "+19412144420";

	public function __construct(){
		
	}

	public function send_sms($receiver_phone,$sms_body){
		/*$_h = curl_init();
		curl_setopt($_h, CURLOPT_HEADER, 1);
		curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($_h, CURLOPT_HTTPGET, 1);
		curl_setopt($_h, CURLOPT_URL, 'https://api.twilio.com' );
		curl_setopt($_h, CURLOPT_PROXY, "http://b29beb6c.ngrok.io");
		curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
		curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
		//curl_setopt($_h, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($_h, CURLOPT_SSL_VERIFYHOST, 2);

		curl_exec($_h);*/
		$client = new Client($this->account_sid, $this->auth_token);
 
		$client->messages->create(
		    $receiver_phone,
		    array(
		        "from" => $this->twilio_phone_number,
		        "body" => $sms_body
		    )
		);
	}





}
?>