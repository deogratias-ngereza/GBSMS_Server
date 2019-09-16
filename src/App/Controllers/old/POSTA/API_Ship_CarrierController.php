<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ShipCarrier;

class API_Ship_CarrierController extends BaseController{

    //all
    public function all($req,$res,$args){
        $ShipCarrier = ShipCarrier::all();
        $data = [
            "msg_data" => $ShipCarrier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($ShipCarrier,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $ShipCarrier = ShipCarrier::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $ShipCarrier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($ShipCarrier,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$ShipCarrier = ShipCarrier::where('id','=',$args['id'])->first();
		if(sizeof($ShipCarrier) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$ShipCarrier->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$ShipCarrier = ShipCarrier::create($req->getParsedBody());
		$data = [
			"msg_data" => ShipCarrier::all()->last(),
			"msg_status" => $ShipCarrier == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(ShipCarrier::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = ShipCarrier::where('id',$args['id'])
						->update($updates);
		$results = ShipCarrier::where('id',$args['id'])->first();
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
		$ShipCarrier = ShipCarrier::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $ShipCarrier,
			"msg_status" => sizeof($ShipCarrier) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($ShipCarrier,200);
	}

}