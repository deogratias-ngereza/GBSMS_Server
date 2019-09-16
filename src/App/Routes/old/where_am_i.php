<?php

use Slim\Http\Request;
use Slim\Http\Response;


/**
 * WHERE AM I
 */
$app->group('/where_am_i',function() use($app){   


    $app->get('',function($req,$res,$args) use ($app){
        //return "-- Grand Technologies LTD --";
        $container = $app->getContainer();
    	return $container->renderer->render($res, 'where_am_i/index.html', $args);
    });


    $app->get('/api_search/{track_id}',\App\Controllers\WHERE_AM_I\API_ProductMovementHistoryController::class.':search');


});//


?>