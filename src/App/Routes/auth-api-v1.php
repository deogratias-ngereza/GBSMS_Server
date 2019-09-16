<?php


/**
 * AUTH
 */

$app->post('/auth-api-v1/login',\App\Controllers\AUTH\API_AuthController::class.':login');
$app->post('/auth-api-v1/login_by_phone',\App\Controllers\AUTH\API_AuthController::class.':login_by_phone');
$app->post('/auth-api-v1/reset_password',\App\Controllers\AUTH\API_AuthController::class.':reset_password'); 
$app->get('/auth-api-v1/resetting_workers_password',\App\Controllers\AUTH\API_AuthController::class.':resetting_workers_password');

?>