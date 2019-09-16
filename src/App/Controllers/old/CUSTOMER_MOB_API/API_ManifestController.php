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




class API_ManifestController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Manifest = Manifest::with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->orderBy('created_date', 'DESC')
        		->take($this->getLimitSize('L'))
        		->get();
        return $res->withJSON($Manifest,200);
    }



    //get all manifests for customer base on selection
    public function get_all_customer_manifests_by_id($req,$res,$args){
    	$Manifest = Manifest::with(['source_warehouse','destination_warehouse'])
    			->where('customer_id',$args['customer_id'])
    			->orWhere('receiver_customer_id',$args['customer_id'])
        		->orderBy('created_date', 'DESC')
        		->take($this->getLimitSize('L'))
        		->get();
    	$data = [
			"msg_data" => $Manifest,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
    }

    //get all manifests for customer base on selection
    public function get_all_customer_manifests_by_id_with_history($req,$res,$args){
    	$Manifest = Manifest::with(['source_warehouse','destination_warehouse','prod_history'])
    			->where('customer_id',$args['customer_id'])
    			->orWhere('receiver_customer_id',$args['customer_id'])
        		->orderBy('created_date', 'DESC')
        		->take($this->getLimitSize('L'))
        		->get();
    	$data = [
			"msg_data" => $Manifest,
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
    }




}