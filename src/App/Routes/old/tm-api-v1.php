<?php

/**
 * 
 * PROTECTED BY JWT
 * 
 */
$app->group('/tm-api-v1',function() use($app){

    //$container = $app->getContainer();
    //$container->logger->warning('This is just info');

    $app->get('',function(){
        return "-- GTech tm operation api v1 --";
    });


    $app->get('/',function(){
        return "-- GTech tm operation api v1 --";
    });


    //exchange rate
    $app->get('/tm_proxy_exchange_rate/{from}/{to}',\App\Controllers\TRANS_MANAGEMENT\ExchRateController::class.':get_real_rate');



    $app->get('/tm_dashboard_summary',\App\Controllers\TRANS_MANAGEMENT\API_TM_DashboardController::class.':summary');





    
    $app->get('/tm_vehicle_owners',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':all');
    $app->get('/tm_vehicle_owners_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':find');
    $app->delete('/tm_vehicle_owners_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':delete');
    $app->post('/tm_vehicle_owners_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':insert');
    $app->put('/tm_vehicle_owners_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':update');
    $app->get('/tm_vehicle_owners_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':search');
    $app->get('/tm_vehicle_owners_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleOwnerController::class.':tbl_fields');

   
    $app->get('/tm_cust_rates_n_product_allowable_losses',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':all');
    $app->get('/tm_cust_rates_n_product_allowable_losses_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':find');
    $app->delete('/tm_cust_rates_n_product_allowable_losses_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':delete');
    $app->post('/tm_cust_rates_n_product_allowable_losses_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':insert');
    $app->put('/tm_cust_rates_n_product_allowable_losses_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':update');
    $app->get('/tm_cust_rates_n_product_allowable_losses_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':search');
    $app->get('/tm_cust_rates_n_product_allowable_losses_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustRate_N_Product_AllowableLosseController::class.':tbl_fields');
    



    $app->get('/tm_customers',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':all');
    $app->get('/tm_customers_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':find');
    $app->delete('/tm_customers_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':delete');
    $app->post('/tm_customers_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':insert');
    $app->put('/tm_customers_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':update');
    $app->get('/tm_customers_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':search');
    $app->get('/tm_customers_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_CustomerController::class.':tbl_fields');



    
    $app->get('/tm_driver_loans',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':all');
    $app->get('/tm_driver_loans_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':find');
    $app->delete('/tm_driver_loans_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':delete');
    $app->post('/tm_driver_loans_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':insert');
    $app->put('/tm_driver_loans_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':update');
    $app->get('/tm_driver_loans_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':search');
    $app->get('/tm_driver_loans_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_Driver_LoanController::class.':tbl_fields');



    
    $app->get('/tm_drivers',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':all');
    $app->get('/tm_drivers/free',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':all_free_drivers');
    $app->get('/tm_drivers/free/preview',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':all_free_drivers_preview');
    $app->get('/tm_drivers_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':find');
    $app->delete('/tm_drivers_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':delete');
    $app->post('/tm_drivers_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':insert');
    $app->put('/tm_drivers_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':update');
    $app->get('/tm_drivers_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':search');
    $app->get('/tm_drivers_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_DriverController::class.':tbl_fields');


    
    $app->get('/tm_invoices',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':all');
    $app->get('/tm_invoices_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':find');
    $app->delete('/tm_invoices_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':delete');
    $app->post('/tm_invoices_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':insert');
    $app->put('/tm_invoices_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':update');
    $app->get('/tm_invoices_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':search');
    $app->get('/tm_invoices_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_InvoiceController::class.':tbl_fields');


    
    $app->get('/tm_order_advance_payments',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':all');
    $app->get('/tm_order_advance_payments_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':find');
    $app->delete('/tm_order_advance_payments_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':delete');
    $app->post('/tm_order_advance_payments_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':insert');
    $app->put('/tm_order_advance_payments_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':update');
    $app->get('/tm_order_advance_payments_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':search');
    $app->get('/tm_order_advance_payments_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderAdvancePaymentController::class.':tbl_fields');



    
    $app->get('/tm_orders',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':all');
    $app->get('/tm_orders_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':find');
    $app->get('/tm_orders_find_order_no/{order_no}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':find_order_no');
    $app->post('/tm_orders_attend_order/{attendor}/{order_no}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':receive_attendend_order');
    $app->delete('/tm_orders_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':delete');
    $app->post('/tm_orders_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':insert');
    $app->put('/tm_orders_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':update');
    $app->get('/tm_orders_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':search');
    $app->get('/tm_orders_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_OrderController::class.':tbl_fields');


    
    $app->get('/tm_prod_loss_statements',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':all');
    $app->get('/tm_prod_loss_statements_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':find');
    $app->delete('/tm_prod_loss_statements_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':delete');
    $app->post('/tm_prod_loss_statements_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':insert');
    $app->put('/tm_prod_loss_statements_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':update');
    $app->get('/tm_prod_loss_statements_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':search');
    $app->get('/tm_prod_loss_statements_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_ProdLossStatementController::class.':tbl_fields');



    
    $app->get('/tm_sys_history',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':all');
    $app->get('/tm_sys_history_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':find');
    $app->delete('/tm_sys_history_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':delete');
    $app->post('/tm_sys_history_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':insert');
    $app->put('/tm_sys_history_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':update');
    $app->get('/tm_sys_history_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':search');
    $app->get('/tm_sys_history_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_SYS_HistoryController::class.':tbl_fields');



    
    $app->get('/tm_trailers',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':all');
    $app->get('/tm_trailers_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':find');
    $app->delete('/tm_trailers_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':delete');
    $app->post('/tm_trailers_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':insert');
    $app->put('/tm_trailer_attach_to_head/{trailer_id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':attach_to_truck');
    $app->put('/tm_trailer_detach_from_head/{trailer_id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':detach_from_truck');
    $app->put('/tm_trailers_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':update');
    $app->get('/tm_trailers_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':search');
    $app->get('/tm_trailers_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TrailerController::class.':tbl_fields');



    
    $app->get('/tm_trip_costings',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':all');
    $app->get('/tm_trip_costings_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':find');
    $app->delete('/tm_trip_costings_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':delete');
    $app->post('/tm_trip_costings_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':insert');
    $app->put('/tm_trip_costings_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':update');
    $app->get('/tm_trip_costings_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':search');
    $app->get('/tm_trip_costings_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripCostingsController::class.':tbl_fields');



    
    $app->get('/tm_trip_destination_points',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':all');
    $app->get('/tm_trip_destination_points_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':find');
    $app->delete('/tm_trip_destination_points_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':delete');
    $app->post('/tm_trip_destination_points_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':insert');
    $app->put('/tm_trip_destination_points_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':update');
    $app->get('/tm_trip_destination_points_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':search');
    $app->get('/tm_trip_destination_points_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripDestinationPointController::class.':tbl_fields');




    
    $app->get('/tm_trip_fixed_pckgs',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':all');
    $app->get('/tm_trip_fixed_pckgs_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':find');
    $app->delete('/tm_trip_fixed_pckgs_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':delete');
    $app->post('/tm_trip_fixed_pckgs_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':insert');
    $app->put('/tm_trip_fixed_pckgs_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':update');
    $app->get('/tm_trip_fixed_pckgs_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':search');
    $app->get('/tm_trip_fixed_pckgs_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripFixedPckgController::class.':tbl_fields');



    
    $app->get('/tm_trip_path_points',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':all');
    $app->get('/tm_trip_path_points_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':find');
    $app->delete('/tm_trip_path_points_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':delete');
    $app->post('/tm_trip_path_points_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':insert');
    $app->put('/tm_trip_path_points_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':update');
    $app->get('/tm_trip_path_points_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':search');
    $app->get('/tm_trip_path_points_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripPathPointController::class.':tbl_fields');



    
    $app->get('/tm_trips',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':all');
    $app->get('/tm_trips_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':find');
    $app->delete('/tm_trips_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':delete');
    $app->post('/tm_trips_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':insert');
    $app->put('/tm_trips_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':update');
    $app->get('/tm_trips_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':search');
    $app->get('/tm_trips_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':tbl_fields');


    //create both trips and trips offloads
    $app->post('/tm_make_trips/{order_no}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripController::class.':make_trip_n_trips_offloads');


    $app->get('/tm_trip_loadings',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':all');
    $app->get('/tm_trip_loadings_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':find');
    $app->delete('/tm_trip_loadings_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':delete');
    $app->post('/tm_trip_loadings_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':insert');
    $app->put('/tm_trip_loadings_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':update');
    $app->get('/tm_trip_loadings_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':search');
    $app->get('/tm_trip_loadings_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripLoadingController::class.':tbl_fields');


    $app->get('/tm_trip_offloads',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':all');
    $app->get('/tm_trip_offloads_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':find');
    $app->delete('/tm_trip_offloads_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':delete');
    $app->post('/tm_trip_offloads_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':insert');
    $app->put('/tm_trip_offloads_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':update');
    $app->get('/tm_trip_offloads_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':search');
    $app->get('/tm_trip_offloads_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_TripOffloadController::class.':tbl_fields');



    $app->get('/tm_vehicle_has_trailers',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':all');
    $app->get('/tm_vehicle_has_trailers_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':find');
    $app->delete('/tm_vehicle_has_trailers_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':delete');
    $app->post('/tm_vehicle_has_trailers_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':insert');
    $app->put('/tm_vehicle_has_trailers_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':update');
    $app->get('/tm_vehicle_has_trailers_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':search');
    $app->get('/tm_vehicle_has_trailers_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_Vehicle_Has_TrailerController::class.':tbl_fields');



    
    $app->get('/tm_vehicle_permits',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':all');
    $app->get('/tm_vehicle_permits/{option}/{vehicle_id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':all_for_vehicle');
    $app->get('/tm_vehicle_permits_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':find');
    $app->delete('/tm_vehicle_permits_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':delete');
    $app->post('/tm_vehicle_permits_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':insert');
    $app->put('/tm_vehicle_permits_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':update');
    $app->get('/tm_vehicle_permits_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':search');
    $app->get('/tm_vehicle_permits_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitController::class.':tbl_fields');




    
    $app->get('/tm_vehicle_permits_types',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':all');
    $app->get('/tm_vehicle_permits_types_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':find');
    $app->delete('/tm_vehicle_permits_types_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':delete');
    $app->post('/tm_vehicle_permits_types_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':insert');
    $app->put('/tm_vehicle_permits_types_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':update');
    $app->get('/tm_vehicle_permits_types_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':search');
    $app->get('/tm_vehicle_permits_types_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehiclePermitTypeController::class.':tbl_fields');




    
    $app->get('/tm_vehicles',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':all');
    $app->get('/tm_vehicles/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':single_vehicle_details');
    $app->get('/tm_vehicles_free_2_allocate',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':all_free_vehicle_2_allocate');
     $app->post('/tm_vehicles_details_from_list',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':get_details_for_vehicles_id_list');
    $app->post('/tm_vehicles_assign_driver/{vehicle_id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':assign_driver');
    $app->post('/tm_vehicles_remove_driver/{vehicle_id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':remove_vehicles_driver');
    $app->delete('/tm_vehicles_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':delete');
    $app->post('/tm_vehicles_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':insert');
    $app->put('/tm_vehicles_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':update');
    $app->get('/tm_vehicles_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':search');
    $app->get('/tm_vehicles_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_VehicleController::class.':tbl_fields');



    
    $app->get('/tm_workers',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':all');
    $app->get('/tm_workers_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':find');
    $app->delete('/tm_workers_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':delete');
    $app->post('/tm_workers_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':insert');
    $app->put('/tm_workers_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':update');
    $app->get('/tm_workers_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':search');
    $app->get('/tm_workers_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_WorkerController::class.':tbl_fields');



    


    $app->get('/tm_exchange_rates',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':all');
    $app->get('/tm_exchange_rates_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':find');
    $app->delete('/tm_exchange_rates_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':delete');
    $app->post('/tm_exchange_rates_insert',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':insert');
    $app->put('/tm_exchange_rates_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':update');
    $app->get('/tm_exchange_rates_search',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':search');
    $app->get('/tm_exchange_rates_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TmExchangeRateController::class.':tbl_fields');



    $app->get('/tm_companies',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':all');
    $app->get('/tm_companies_find/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':find');
    $app->delete('/tm_companies_delete/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':delete');
    $app->post('/tm_companies_insert',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':insert');
    $app->put('/tm_companies_update/{id}',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':update');
    $app->get('/tm_companies_search',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':search');
    $app->get('/tm_companies_tbl_fields',\App\Controllers\TRANS_MANAGEMENT\API_TM_CompanyController::class.':tbl_fields');

});//->add($jwt_middleware);






?>