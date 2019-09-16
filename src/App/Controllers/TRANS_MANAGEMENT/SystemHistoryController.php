<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Models\TM_SYS_History;

class SystemHistoryController{


    public function record_customer_act($customer_id,$action,$description){
    	$history = new TM_SYS_History();
    	$history->history_for = 'CUSTOMER';
    	$history->action =  $action;
    	$history->description = $description;
    	$history->save();
    }


    public function record_rate_n_loss_act($action,$description){
    	$history = new TM_SYS_History();
    	$history->history_for = 'RATE_AND_PRODUCT_LOSS';
    	$history->action =  $action;
    	$history->description = $description;
    	$history->save();
    }









}