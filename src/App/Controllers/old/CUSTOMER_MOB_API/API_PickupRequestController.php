<?php
namespace App\Controllers\CUSTOMER_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\PickupRequest;

class API_PickupRequestController extends BaseController{

    //all
    public function all($req,$res,$args){
        $PickupRequest = PickupRequest::all();
        $data = [
            "msg_data" => $PickupRequest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($PickupRequest,200);
    }

     public function all_for_customer($req,$res,$args){
        $PickupRequest = PickupRequest::where('customer_id',$args['customer_id'])->orderBy('created_at','DESC')->get();
        $data = [
            "msg_data" => $PickupRequest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($PickupRequest,200);
    }

	//insert
	public function insert($req,$res,$args){
		$PickupRequest = PickupRequest::create($req->getParsedBody());
		$data = [
			"msg_data" => PickupRequest::all()->last(),
			"msg_status" => $PickupRequest == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON(PickupRequest::all()->last(),200);
	}


}