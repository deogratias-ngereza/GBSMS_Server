<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Centers_has_Flights;

class API_Centers_has_flightsController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Centers_has_Flights = Centers_has_Flights::all();
        $data = [
            "msg_data" => $Centers_has_Flights,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Centers_has_Flights,200);
    }

    //find from given center_id
    public function find($req,$res,$args){
        $Centers_has_Flights = Centers_has_Flights::where("center_id","=",$args['id'])->get();
		return $res->withJSON($Centers_has_Flights,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Centers_has_Flights = Centers_has_Flights::where('id','=',$args['id'])->first();
		if(sizeof($Centers_has_Flights) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Centers_has_Flights->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Centers_has_Flights = Centers_has_Flights::create($req->getParsedBody());
		$data = [
			"msg_data" => Centers_has_Flights::all()->last(),
			"msg_status" => $Centers_has_Flights == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON(Centers_has_Flights::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Centers_has_Flights::where('id','=',$args['id'])->update($updates);
		$results = Centers_has_Flights::where('id','=',$args['id'])->first();
		return $res->withJSON($results,200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$Centers_has_Flights = Centers_has_Flights::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Centers_has_Flights,
			"msg_status" => sizeof($Centers_has_Flights) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Centers_has_Flights,200);
	}







	//get all flights info from the given center code
    public function get_center_flights($req,$res,$args){
        $Centers_has_Flights = Centers_has_Flights::where("center_id","=",$args['center_id'])->with('flight')->get();
        $data = [
            "msg_data" => $Centers_has_Flights,
            "msg_status" => "OK"
        ];
		return $res->withJSON($Centers_has_Flights,200);
    }

}