
<?php



/*
* gateway sms api
* CHECK account field with api_key_ and account no
*/
$gateway_sms_mdw_chk_acc_and_api_key = function($req,$res,$next){
	$contentType = $req->getContentType();
	if (strpos($contentType, 'application/json') !== false) {
	    //is json
	    //return $res->withJson(["msg_data" => "JSON","msq_status" => "ERROR"])->withStatus(200);
	
		//check if account{account_no :'',api_key:''}
		if(isset($req->getParsedBody()['account'])){ 
			
			if(isset($req->getParsedBody()['account']['account_no']) && isset($req->getParsedBody()['account']['api_key'])){
				$response = $next($req,$res);
				return $response;
			}else{
				return $res->withJson([
					"code"=>4002,
					"code_status" => "ACC OR API_KEY FIELD NOT FOUND",
					"msg_status" => "INPUT_ERROR"
				])->withStatus(200);
			}
		}else{
			return $res->withJson([
				"code"=>4001,
				"code_status" => "ACCOUNT FIELD NOT FOUND",
				"msg_status" => "INPUT_ERROR"
			])->withStatus(200);
		}

		//check body 
	}
	else{
		return $res->withJson([
				"code"=>4000,
				"code_status" => "Invalid Json Header",
				"msg_status" => "HEADER_ERROR"
			])->withStatus(200);
	}
};


/*
	check single sms fields if they are all ok
	{text:'',recepient_phone:'',sender_name:''}
*/
$gateway_sms_mdw_chk_single_sms_body = function($req,$res,$next){
	$contentType = $req->getContentType();
	if(isset($req->getParsedBody()['message'])){ 
			
		if(isset($req->getParsedBody()['message']['recepient_phone']) && isset($req->getParsedBody()['message']['text']) && isset($req->getParsedBody()['message']['sender_name'])){
			$response = $next($req,$res);
			return $response;
		}else{
			return $res->withJson([
				"code"=>4011,
				"code_status" => "TEXT,REC PHONE OR SENDER_NAME FIELD NOT FOUND",
				"msg_status" => "INPUT_ERROR"
			])->withStatus(200);
		}
	}else{
		return $res->withJson([
				"code"=>4011,
				"code_status" => "MSG OBJ FIELD NOT FOUND",
				"msg_status" => "INPUT_ERROR"
			])->withStatus(200);
	}
};


/*
	check bulky sms fields if they are all ok
	sender_name:'',
	messages [ {text:'',recepient_phone:''} ]
*/
$gateway_sms_mdw_chk_bulky_sms_body = function($req,$res,$next){
	$contentType = $req->getContentType();
	if(isset($req->getParsedBody()['message'])){  
		if(isset($req->getParsedBody()['recepients'])){ 
			$response = $next($req,$res);
			return $response;
		}else{
			return $res->withJson([
				"code"=>4013,
				"code_status" => "Recepients field not found",
				"msg_status" => "INPUT_ERROR"
			])->withStatus(200);
		}
	}
	else{
		return $res->withJson([
				"code"=>4011,
				"code_status" => "MSG OBJ FIELD NOT FOUND",
				"msg_status" => "INPUT_ERROR"
			])->withStatus(200);
	}
	//sender name
};





/*
* gateway sms api DELETE THIS 
*/
$gateway_sms_api = function($req,$res,$next){
	//check if all login parameters are there
	/*if($req->getParsedBody()['phone_no'] ==  null || $req->getParsedBody()['password'] == null){
		return $res->withJson(["msg_data" => "Missing Parameters","msq_status" => "ERROR","msg_type" => "STRING"])->withStatus(401);
	}
	else{
		$response = $next($req,$res);
		return $response;
	}*/
	//return $res->withJson(["msg_data" => "Samahani, Namba ya simu imekwisha sajiliwa! Ingiza namba nyingine!","msq_status" => "ERROR"])->withStatus(401);


	//$response = $next($req,$res);
	//	return $response;

	$contentType = $req->getContentType();
	if (strpos($contentType, 'application/json') !== false) {
	    //is json
	    //return $res->withJson(["msg_data" => "JSON","msq_status" => "ERROR"])->withStatus(200);
	
		//check if account{account_no :'',api_key:''}
		if(isset($req->getParsedBody()['account'])){ 
			
			if(isset($req->getParsedBody()['account']['account_no']) && isset($req->getParsedBody()['account']['api_key'])){
				return $res->withJson(["msg_data" => "ACC & KEY VALID","msq_status" => "ERROR"])->withStatus(200);
			}else{
				return $res->withJson(["msg_data" => "ACC & KEY FIELD NOT FOUND","msq_status" => "ERROR"])->withStatus(200);
			}
		}else{
			return $res->withJson(["msg_data" => "ACCOUNT FIELD NOT FOUND","msq_status" => "ERROR"])->withStatus(200);
		}

		//check body 
	}
	else{
		return $res->withJson(["msg_data" => "!JSON","msq_status" => "ERROR"])->withStatus(200);
	}
};




?>