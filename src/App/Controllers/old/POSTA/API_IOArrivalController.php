<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\IOArrival;

class API_IOArrivalController extends BaseController{

    //all
    public function all($req,$res,$args){
        $IOArrival = IOArrival::all();
        return $res->withJSON($IOArrival,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $IOArrival = IOArrival::where("id","=",$args['id'])->first();
		return $res->withJSON($IOArrival,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$IOArrival = IOArrival::where('id','=',$args['id'])->first();
		if(sizeof($IOArrival) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$IOArrival->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$inputs = $req->getParsedBody();
		$inputs["from"] = $req->getParsedBody()['transporter']['route_arrival'];//TODO

		$IOArrival = IOArrival::create($inputs);
		return $res->withJSON($IOArrival == null ? "FAIL TO INSERT" : IOArrival::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = IOArrival::where('id',$args['id'])
						->update($updates);
		$results = IOArrival::where('id',$args['id'])->first();
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
		$IOArrival = IOArrival::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $IOArrival,
			"msg_status" => sizeof($IOArrival) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($IOArrival,200);
	}

}