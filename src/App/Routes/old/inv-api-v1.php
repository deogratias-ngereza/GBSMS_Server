<?php
/**/


/**
 * 
 * PROTECTED BY JWT
 * 
 */
$app->group('/inv-api-v1',function() use($app){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');

    $app->get('',function(){
        return "-- GTech inventory api v1 --";
    });


    $app->get('/',function(){
        return "-- GTech inventory api v1 --";
    });
    
    $app->get('/inv_dashboard_summary',\App\Controllers\INVENTORY_MANAGEMENT\API_InvDashboardController::class.':summary');



    
    $app->get('/inv_item_categories',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':all');
    $app->get('/inv_item_categories_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':find');
    $app->delete('/inv_item_categories_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':delete');
    $app->post('/inv_item_categories_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':insert');
    $app->put('/inv_item_categories_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':update');
    $app->get('/inv_item_categories_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':search');
    $app->get('/inv_item_categories_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemCategoryController::class.':tbl_fields');





    $app->get('/inv_items',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':all');
    $app->get('/inv_items_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':find');
    $app->delete('/inv_items_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':delete');
    $app->post('/inv_items_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':insert');
    $app->put('/inv_items_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':update');
    $app->get('/inv_items_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':search');
    $app->get('/inv_items_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':tbl_fields');
    $app->post('/inv_items_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemController::class.':search_item');



    
    $app->get('/inv_item_transactions',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':all');
    $app->get('/inv_item_transactions_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':find');
    $app->delete('/inv_item_transactions_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':delete');
    $app->post('/inv_item_transactions_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':insert');
    $app->put('/inv_item_transactions_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':update');
    $app->get('/inv_item_transactions_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':search');
    $app->get('/inv_item_transactions_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemTransactionController::class.':tbl_fields');

    
   
    
    $app->get('/inv_operational_costs',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':all');
    $app->get('/inv_operational_costs_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':find');
    $app->delete('/inv_operational_costs_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':delete');
    $app->post('/inv_operational_costs_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':insert');
    $app->put('/inv_operational_costs_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':update');
    $app->get('/inv_operational_costs_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':search');
    $app->get('/inv_operational_costs_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOperationalCostController::class.':tbl_fields');



    
    $app->get('/inv_order_particulars',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':all');
    $app->get('/inv_order_particulars_find/{order_no}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':find');
    $app->delete('/inv_order_particulars_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':delete');
    $app->post('/inv_order_particulars_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':insert');
    $app->put('/inv_order_particulars_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':update');
    $app->get('/inv_order_particulars_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':search');
    $app->get('/inv_order_particulars_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderParticularController::class.':tbl_fields');




    
    $app->get('/inv_order_payments',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':all');
    $app->get('/inv_order_payments_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':find');
    $app->delete('/inv_order_payments_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':delete');
    $app->post('/inv_order_payments_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':insert');
    $app->put('/inv_order_payments_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':update');
    $app->get('/inv_order_payments_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':search');
    $app->get('/inv_order_payments_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderPaymentController::class.':tbl_fields');



    
    $app->get('/inv_orders',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':all');
    $app->get('/inv_orders_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':find');
    $app->post('/inv_orders_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':deep_search_single_order');
    $app->get('/inv_orders_find_order_no/{order_no}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':find_order_no');
    $app->delete('/inv_orders_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':delete');
    $app->post('/inv_orders_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':insert');
    $app->put('/inv_orders_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':update');
    $app->get('/inv_orders_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':search');
    $app->get('/inv_orders_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvOrderController::class.':tbl_fields');




    $app->get('/inv_stores',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':all');
    $app->get('/inv_stores_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':find');
    $app->delete('/inv_stores_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':delete');
    $app->post('/inv_stores_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':insert');
    $app->put('/inv_stores_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':update');
    $app->get('/inv_stores_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':search');
    $app->get('/inv_stores_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':tbl_fields');


    

    $app->get('/inv_suppliers',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':all');
    $app->get('/inv_suppliers_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':find');
    $app->delete('/inv_suppliers_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':delete');
    $app->post('/inv_suppliers_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':insert');
    $app->put('/inv_suppliers_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':update');
    $app->get('/inv_suppliers_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':search');
    $app->get('/inv_suppliers_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvSupplierController::class.':tbl_fields');




    $app->get('/inv_workers',\App\Controllers\INVENTORY_MANAGEMENT\API_InvWorkerController::class.':all');
    $app->get('/inv_workers_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvWorkerController::class.':find');
    $app->delete('/inv_workers_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvWorkerController::class.':delete');
    $app->post('/inv_workers_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvWorkerController::class.':insert');
    $app->put('/inv_workers_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvWorkerController::class.':update');
    $app->get('/inv_workers_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvWorkerController::class.':search');
    $app->get('/inv_workers_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvStoreController::class.':tbl_fields');



    $app->get('/inv_issue_notes',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':all');
    $app->get('/inv_issue_notes_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':find');
    $app->delete('/inv_issue_notes_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':delete');
    $app->post('/inv_issue_notes_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':insert');
    $app->put('/inv_issue_notes_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':update');
    $app->get('/inv_issue_notes_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':search');
    $app->get('/inv_issue_notes_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvIssueNoteController::class.':tbl_fields');


    $app->get('/inv_item_leases',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':all');
    $app->get('/inv_item_leases_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':find');
    $app->delete('/inv_item_leases_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':delete');
    $app->post('/inv_item_leases_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':insert');
    $app->put('/inv_item_leases_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':update');
    $app->get('/inv_item_leases_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':search');
    $app->get('/inv_item_leases_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvItemLeaseController::class.':tbl_fields');


    $app->get('/inv_broken_n_lost_reports',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':all');
    $app->get('/inv_broken_n_lost_reports_find/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':find');
    $app->delete('/inv_broken_n_lost_reports_delete/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':delete');
    $app->post('/inv_broken_n_lost_reports_insert',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':insert');
    $app->put('/inv_broken_n_lost_reports_update/{id}',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':update');
    $app->get('/inv_broken_n_lost_reports_search',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':search');
    $app->get('/inv_broken_n_lost_reports_tbl_fields',\App\Controllers\INVENTORY_MANAGEMENT\API_InvBrokenLostController::class.':tbl_fields');




    
    


});//->add($jwt_middleware);






?>