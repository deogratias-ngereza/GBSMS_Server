<?php
namespace App\Controllers\COURIER_API;

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

    //find from given id
    public function find($req,$res,$args){
        $PickupRequest = PickupRequest::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $PickupRequest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($PickupRequest,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$PickupRequest = PickupRequest::where('id','=',$args['id'])->first();
		if(sizeof($PickupRequest) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$PickupRequest->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$PickupRequest = PickupRequest::create($req->getParsedBody());
		$data = [
			"msg_data" => PickupRequest::all()->last(),
			"msg_status" => $PickupRequest == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(PickupRequest::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = PickupRequest::where('id',$args['id'])
						->update($updates);
		$results = PickupRequest::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($results,200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$PickupRequest = PickupRequest::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $PickupRequest,
			"msg_status" => sizeof($PickupRequest) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($PickupRequest,200);
	}

}