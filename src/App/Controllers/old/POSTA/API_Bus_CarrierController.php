<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\BusCarrier;

class API_Bus_CarrierController extends BaseController{

    //all
    public function all($req,$res,$args){
        $BusCarrier = BusCarrier::all();
        $data = [
            "msg_data" => $BusCarrier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($BusCarrier,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $BusCarrier = BusCarrier::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $BusCarrier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($BusCarrier,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$BusCarrier = BusCarrier::where('id','=',$args['id'])->first();
		if(sizeof($BusCarrier) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$BusCarrier->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$BusCarrier = BusCarrier::create($req->getParsedBody());
		$data = [
			"msg_data" => BusCarrier::all()->last(),
			"msg_status" => $BusCarrier == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(BusCarrier::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = BusCarrier::where('id',$args['id'])
						->update($updates);
		$results = BusCarrier::where('id',$args['id'])->first();
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
		$BusCarrier = BusCarrier::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $BusCarrier,
			"msg_status" => sizeof($BusCarrier) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($BusCarrier,200);
	}

}