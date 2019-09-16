<?php


use Slim\Http\Request;
use Slim\Http\Response;



/*
 * 
 * PROTECTED BY JWT
 * 
 */
$app->group('/desk-api-v1',function() use($app){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');


	//app
	$app->get('/',function($req,$res,$args) use ($app){
	   return "Grand Technologies LTD";
	});
	$app->get('',function($req,$res,$args) use ($app){
	   return "Grand Technologies LTD";
	});

    


    $app->get('/customers',\App\Controllers\DESK_API\API_CustomerController::class.':all');
    $app->get('/customer_find/{id}',\App\Controllers\DESK_API\API_CustomerController::class.':find');
    $app->delete('/customer_delete/{id}',\App\Controllers\DESK_API\API_CustomerController::class.':delete');
    $app->post('/customer_insert',\App\Controllers\DESK_API\API_CustomerController::class.':insert');
    $app->post('/customer_update/{id}',\App\Controllers\DESK_API\API_CustomerController::class.':update');
    $app->get('/customer_search',\App\Controllers\DESK_API\API_CustomerController::class.':search');
    







    $app->get('/manifests',\App\Controllers\DESK_API\API_ManifestController::class.':all');
    $app->get('/manifest_all_for_warehouse/{opt}/{id}',\App\Controllers\DESK_API\API_ManifestController::class.':all_for_warehouse');
    $app->get('/manifest_find/{id}',\App\Controllers\DESK_API\API_ManifestController::class.':find');
    $app->delete('/manifest_delete/{id}',\App\Controllers\DESK_API\API_ManifestController::class.':delete');
    $app->post('/manifest_insert',\App\Controllers\DESK_API\API_ManifestController::class.':insert');
    $app->put('/manifest_update/{id}',\App\Controllers\DESK_API\API_ManifestController::class.':update');

    



    $app->get('/pods',\App\Controllers\DESK_API\API_PodController::class.':all');
    $app->get('/pod_find/{id}',\App\Controllers\DESK_API\API_PodController::class.':find');
    $app->get('/find_by_track_no/{track_id}',\App\Controllers\DESK_API\API_PodController::class.':find_by_track_no');
    $app->delete('/pod_delete/{id}',\App\Controllers\DESK_API\API_PodController::class.':delete');
    $app->post('/pod_insert',\App\Controllers\DESK_API\API_PodController::class.':insert');
    $app->put('/pod_update/{id}',\App\Controllers\DESK_API\API_PodController::class.':update');
    $app->get('/pod_search',\App\Controllers\DESK_API\API_PodController::class.':search');
    


    $app->get('/product_movement_historys',\App\Controllers\DESK_API\API_ProductMovementHistoryController::class.':all');
    $app->get('/product_movement_history_find/{id}',\App\Controllers\DESK_API\API_ProductMovementHistoryController::class.':find');
    $app->delete('/product_movement_history_delete/{id}',\App\Controllers\DESK_API\API_ProductMovementHistoryController::class.':delete');
    $app->post('/product_movement_history_insert',\App\Controllers\DESK_API\API_ProductMovementHistoryController::class.':insert');
    $app->put('/product_movement_history_update/{id}',\App\Controllers\DESK_API\API_ProductMovementHistoryController::class.':update');
    $app->get('/product_movement_history_search',\App\Controllers\DESK_API\API_ProductMovementHistoryController::class.':search');
    


    $app->get('/suppliers',\App\Controllers\DESK_API\API_SupplierController::class.':all');
    $app->get('/supplier_find/{id}',\App\Controllers\DESK_API\API_SupplierController::class.':find');
    $app->delete('/supplier_delete/{id}',\App\Controllers\DESK_API\API_SupplierController::class.':delete');
    $app->post('/supplier_insert',\App\Controllers\DESK_API\API_SupplierController::class.':insert');
    $app->put('/supplier_update/{id}',\App\Controllers\DESK_API\API_SupplierController::class.':update');
    $app->get('/supplier_search',\App\Controllers\DESK_API\API_SupplierController::class.':search');
    


    $app->get('/warehouses',\App\Controllers\DESK_API\API_WarehouseController::class.':all');
    $app->get('/warehouses_find/{id}',\App\Controllers\DESK_API\API_WarehouseController::class.':find');
    $app->delete('/warehouses_delete/{id}',\App\Controllers\DESK_API\API_WarehouseController::class.':delete');
    $app->post('/warehouses_insert',\App\Controllers\DESK_API\API_WarehouseController::class.':insert');
    $app->put('/warehouses_update/{id}',\App\Controllers\DESK_API\API_WarehouseController::class.':update');
    $app->get('/warehouses_search',\App\Controllers\DESK_API\API_WarehouseController::class.':search');
    

    $app->get('/wh_imports',\App\Controllers\DESK_API\API_Wh_ImportController::class.':all');
    $app->get('/wh_imports/{id}',\App\Controllers\DESK_API\API_Wh_ImportController::class.':all_for_warehouse');
    $app->get('/wh_import_find/{id}',\App\Controllers\DESK_API\API_Wh_ImportController::class.':find');
    $app->delete('/wh_import_delete/{id}',\App\Controllers\DESK_API\API_Wh_ImportController::class.':delete');
    $app->post('/wh_import_insert',\App\Controllers\DESK_API\API_Wh_ImportController::class.':insert');
    $app->put('/wh_import_update/{id}',\App\Controllers\DESK_API\API_Wh_ImportController::class.':update');
    $app->get('/wh_import_search',\App\Controllers\DESK_API\API_Wh_ImportController::class.':search');



    $app->get('/wh_inventorys',\App\Controllers\DESK_API\API_Wh_InventoryController::class.':all');
    $app->get('/wh_inventory_find/{id}',\App\Controllers\DESK_API\API_Wh_InventoryController::class.':find');
    $app->delete('/wh_inventory_delete/{id}',\App\Controllers\DESK_API\API_Wh_InventoryController::class.':delete');
    $app->post('/wh_inventory_insert',\App\Controllers\DESK_API\API_Wh_InventoryController::class.':insert');
    $app->put('/wh_inventory_update/{id}',\App\Controllers\DESK_API\API_Wh_InventoryController::class.':update');
    $app->get('/wh_inventory_search',\App\Controllers\DESK_API\API_Wh_InventoryController::class.':search');
    



    $app->get('/wh_products',\App\Controllers\DESK_API\API_Wh_ProductController::class.':all');
    $app->get('/wh_product_find/{id}',\App\Controllers\DESK_API\API_Wh_ProductController::class.':find');
    $app->delete('/wh_product_delete/{id}',\App\Controllers\DESK_API\API_Wh_ProductController::class.':delete');
    $app->post('/wh_product_insert',\App\Controllers\DESK_API\API_Wh_ProductController::class.':insert');
    $app->put('/wh_product_update/{id}',\App\Controllers\DESK_API\API_Wh_ProductController::class.':update');
    $app->get('/wh_product_search',\App\Controllers\DESK_API\API_Wh_ProductController::class.':search');




    $app->get('/store_products',\App\Controllers\DESK_API\API_StoreProductController::class.':all');
    $app->get('/store_product_find/{id}',\App\Controllers\DESK_API\API_StoreProductController::class.':find');
    $app->delete('/store_product_delete/{id}',\App\Controllers\DESK_API\API_StoreProductController::class.':delete');
    $app->post('/store_product_insert',\App\Controllers\DESK_API\API_StoreProductController::class.':insert');
    $app->put('/store_product_update/{id}',\App\Controllers\DESK_API\API_StoreProductController::class.':update');
    $app->get('/store_product_search',\App\Controllers\DESK_API\API_StoreProductController::class.':search');



    
    $app->get('/workers',\App\Controllers\DESK_API\API_WorkerController::class.':all');
    $app->get('/warehouse_workers/{id}',\App\Controllers\DESK_API\API_WorkerController::class.':all_warehouse_workers');
    $app->get('/worker_find/{id}',\App\Controllers\DESK_API\API_WorkerController::class.':find');
    $app->delete('/worker_delete/{id}',\App\Controllers\DESK_API\API_WorkerController::class.':delete');
    $app->post('/worker_insert',\App\Controllers\DESK_API\API_WorkerController::class.':insert');
    $app->put('/worker_update/{id}',\App\Controllers\DESK_API\API_WorkerController::class.':update');
    $app->get('/worker_search',\App\Controllers\DESK_API\API_WorkerController::class.':search');




});//->add($jwt_middleware);