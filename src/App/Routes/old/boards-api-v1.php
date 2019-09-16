<?php


use Slim\Http\Request;
use Slim\Http\Response;



/*
 * 
 * PROTECTED BY JWT
 * 
 */
$app->group('/boards-api-v1',function() use($app){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');


	//app
	$app->get('/',function($req,$res,$args) use ($app){
	   return "Grand Technologies LTD [ BOARDS API ]";
	});
	$app->get('',function($req,$res,$args) use ($app){
	   return "Grand Technologies LTD [ BOARDS API ]";
	});

	//api
	$app->get('/manifest_all_for_warehouse/{opt}/{id}',\App\Controllers\COURIER_BOARDS_API\API_BoardsController::class.':all_for_warehouse');






	/*render the boards ui*/
	$app->get('/dis_board_player/{warehouse_id}',\App\Controllers\COURIER_BOARDS_API\API_BoardsController::class.':custom_board_player');






    


    $app->get('/customers',\App\Controllers\DESK_API\API_CustomerController::class.':all');
    $app->get('/customer_find/{id}',\App\Controllers\DESK_API\API_CustomerController::class.':find');
    $app->delete('/customer_delete/{id}',\App\Controllers\DESK_API\API_CustomerController::class.':delete');
    $app->post('/customer_insert',\App\Controllers\DESK_API\API_CustomerController::class.':insert');
    $app->post('/customer_update/{id}',\App\Controllers\DESK_API\API_CustomerController::class.':update');
    $app->get('/customer_search',\App\Controllers\DESK_API\API_CustomerController::class.':search');
    



});//->add($jwt_middleware);