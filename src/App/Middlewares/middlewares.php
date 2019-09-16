<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);



/*
	APPLICATION LEVEL MIDDLEWARE.
*/
/*$app->add(function($request,$response,$next){
	//$response->getBody()->write("Before");
	$response = $next($request,$response);
	//$response->getBody()->write("After");
	return $response;
});
*/

/*
CORS
*/
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
    		//->withHeader("Content-Type", "application/json")
            //->withHeader('Access-Control-Allow-Origin', 'http://localhost:2222/')
    		->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,PATCH,OPTIONS');
}); 

/* 
	ROUTE LEVEL MIDDLEWARE
*/
$testRouteMiddleware = function($request,$response,$next){
	//$response->getBody()->write("Before - ");
	$response = $next($request,$response);
	//$response->getBody()->write(" - After");
	return $response;
};


/*JWT MIDDLE WARE*/
$jwt_middleware = function($req,$res,$next){
	$authHeader = $req->getHeader('Authorization');
    try{
    	if ($authHeader) {
	        $total_len = strlen((string)$authHeader[0]);
	        $jwt = substr((string)$authHeader[0],7,$total_len);

	        $G_JWT = new \App\Utilities\G_JWT;
	        $truth = $G_JWT->is_token_valid($jwt);
	        if($truth){
				//return $res->withJson(["msg_data" => "Valid Token!",""])->withStatus(200);
				$response = $next($request,$response);
				return $response;
	        }else{
	        	return $res->withJson(["msg_data" => "Token Expired!","msq_status" => "ERROR"])->withStatus(401);
	        }
	    }else{
	    	return $res->withJson(["msg_data" => "Token Not Recognized","msq_status" => "ERROR"])->withStatus(401);
	    }
    }catch(Exception $e){
    	return $res->withJson(["msg_data" => "Token Not Recognized","msq_status" => "ERROR"])->withStatus(401);
    }   
};


?>