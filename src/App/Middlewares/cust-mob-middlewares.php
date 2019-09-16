<?php

/*
* check registration if well filled and check if the phone do exists
*/
$cust_mob_check_register_params = function($req,$res,$next){
	//check if all reg parameters are there
	if($req->getParsedBody()['first_name'] ==  null || $req->getParsedBody()['last_name'] == null || $req->getParsedBody()['email']== null || $req->getParsedBody()['phone_no'] == null || $req->getParsedBody()['address'] == null || $req->getParsedBody()['password'] == null){
		return $res->withJson(["msg_data" => "Missing Parameters","msq_status" => "ERROR"])->withStatus(401);
	}
	//check if the user phone is registered to the system
	$is_phone_exists = \App\Models\Customer::is_phone_exists($req->getParsedBody()['phone_no']);
	if(!$is_phone_exists){
		//return $res->withJson(["msg_data" => "FINE","msq_status" => "OK"])->withStatus(200);
		$response = $next($req,$res);
		return $response;
	}else{
		return $res->withJson(["msg_data" => "Samahani, Namba ya simu imekwisha sajiliwa! Ingiza namba nyingine!","msq_status" => "ERROR"])->withStatus(401);
	}
};


/*
* check if login fields exists
*/
$cust_mob_check_login_params = function($req,$res,$next){
	//check if all login parameters are there
	if($req->getParsedBody()['phone_no'] ==  null || $req->getParsedBody()['password'] == null){
		return $res->withJson(["msg_data" => "Missing Parameters","msq_status" => "ERROR","msg_type" => "STRING"])->withStatus(401);
	}
	else{
		$response = $next($req,$res);
		return $response;
	}
};










?>

