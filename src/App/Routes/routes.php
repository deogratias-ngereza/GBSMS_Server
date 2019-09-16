<?php


use Slim\Http\Request;
use Slim\Http\Response;

/*LOAD OTHER ROUTES*/
require __DIR__ . '/api-v1.php';//
require __DIR__ . '/auth-api-v1.php';//
require __DIR__ . '/sms-api-v1.php';


/*
require __DIR__ . '/desk-api-v1.php';//desktop application
require __DIR__ . '/boards-api-v1.php';//displaying board app
require __DIR__ . '/where_am_i.php';
require __DIR__ . '/tarrifs-api-v1.php';
require __DIR__ . '/report_api-v1.php';
require __DIR__ . '/cust-mob-api-v1.php';*/
//tarrifs-api-v1




//app
$app->get('/',function($req,$res,$args) use ($app){
    //$container = $app->getContainer();
    //return $container->renderer->render($res, 'where_am_i/index.html', $args);
    return "Grand Technologies Ltd";
    
}); 
$app->get('/g-test',function($req,$res,$args) use ($app){
    /*$Date =date('Y-m-d');//2010-09-17";
	return date('Y-m-d', strtotime($Date. ' + 20 days'));*/

	$Date = date('Y-m-d');
	$mDueDate = date('Y-m-') . 12;//this month due date
	if($mDueDate < $Date){
		$nextDueDate = date('Y-m-d', strtotime($mDueDate. ' + 1 months'));
		echo $Date . " >= " . $mDueDate . " due on [".$nextDueDate."]";
	}else{
		$nextDueDate = $mDueDate;
		echo $Date . " < " . $mDueDate . " due on [".$nextDueDate."]";
	}
	//return $Date;
}); 
    
$app->get('/more',\App\Controllers\MoreController::class.':test_resp');
//app
$app->get('/app',function(Request $req,Response $res,array $args){
	//return "Hello there";
	return "Grand Technologies Ltd";
});

$app->get('/users',\App\Controllers\UserController::class.':get_all_users');
$app->get('/jwt-test',\App\Controllers\TestController::class.':jwt_test')->add($jwt_middleware);
$app->get('/jwt-free',\App\Controllers\TestController::class.':free_token');
$app->get('/test_resp',\App\Controllers\MoreController::class.':test_resp');




$app->get('/sms',function(Request $req,Response $res,array $args){
	$ts = new App\Notify\TwillioSms;
	$ts->send_sms('+917259840692','Hello from grand framework again tried');
	return "Msg sent";
});
$app->get('/mail',function(Request $req,Response $res,array $args){
	$ts = new App\Notify\GMailer;
	//$ts->send_sms('+917259840692','Hello from twillio');
	$res = $ts->SEND_BASIC_EMAIL();
	return $res;
	//echo !extension_loaded('openssl')?"Not Available":"Available";
});































































// Routes
/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});*/

?>