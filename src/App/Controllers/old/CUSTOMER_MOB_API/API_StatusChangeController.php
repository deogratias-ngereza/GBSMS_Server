<?php
namespace App\Controllers\CUSTOMER_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CustomerAddress;

use App\Models\Manifest;

use App\Models\ProductMovementHistory;
use App\Models\Customer;


use App\Notify\NotifierProvider;
use App\Models\Pod;




class API_StatusChangeController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Manifest = Manifest::with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->orderBy('created_date', 'DESC')
        		->take($this->getLimitSize('L'))
        		->get();
        return $res->withJSON($Manifest,200);
    }


    /* receive prod to warehouse */
	public function receive_to_warehouse($req,$res,$args){
        $data = [
			"msg_data" => "RECEiveD",
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
    }







}