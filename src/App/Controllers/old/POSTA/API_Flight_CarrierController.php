<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\FlightCarrier;

class API_Flight_CarrierController extends BaseController{

    //all
    public function all($req,$res,$args){
        $FlightCarrier = FlightCarrier::all();
        return $res->withJSON($FlightCarrier,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $FlightCarrier = FlightCarrier::where("id","=",$args['id'])->first();
		return $res->withJSON($FlightCarrier,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$FlightCarrier = FlightCarrier::where('id','=',$args['id'])->first();
		if(sizeof($FlightCarrier) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$FlightCarrier->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$FlightCarrier = FlightCarrier::create($req->getParsedBody());
		$data = [
			"msg_data" => FlightCarrier::all()->last(),
			"msg_status" => $FlightCarrier == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(FlightCarrier::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = FlightCarrier::where('id',$args['id'])
						->update($updates);
		$results = FlightCarrier::where('id',$args['id'])->first();
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
		$FlightCarrier = FlightCarrier::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $FlightCarrier,
			"msg_status" => sizeof($FlightCarrier) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($FlightCarrier,200);
	}

}