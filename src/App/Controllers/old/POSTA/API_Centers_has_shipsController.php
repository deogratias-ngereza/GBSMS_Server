<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Centers_has_Ships;

class API_Centers_has_shipsController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Centers_has_Ships = Centers_has_Ships::all();
        $data = [
            "msg_data" => $Centers_has_Ships,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Centers_has_Ships,200);
    }

    //find from given center_id
    public function find($req,$res,$args){
        $Centers_has_Ships = Centers_has_Ships::where("center_id","=",$args['id'])->get();
		return $res->withJSON($Centers_has_Ships,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Centers_has_Ships = Centers_has_Ships::where('id','=',$args['id'])->first();
		if(sizeof($Centers_has_Ships) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Centers_has_Ships->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Centers_has_Ships = Centers_has_Ships::create($req->getParsedBody());
		$data = [
			"msg_data" => Centers_has_Ships::all()->last(),
			"msg_status" => $Centers_has_Ships == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Centers_has_Ships::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Centers_has_Ships::where('id',$args['id'])
						->update($updates);
		$results = Centers_has_Ships::where('id',$args['id'])->first();
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
		$Centers_has_Ships = Centers_has_Ships::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Centers_has_Ships,
			"msg_status" => sizeof($Centers_has_Ships) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Centers_has_Ships,200);
	}



	 //get all ships info from the given center code
    public function get_center_ships($req,$res,$args){
        $Centers_has_Ships = Centers_has_Ships::where("center_id","=",$args['center_id'])->with('ship')->get();
        $data = [
            "msg_data" => $Centers_has_Ships,
            "msg_status" => "OK"
        ];
		return $res->withJSON($Centers_has_Ships,200);
    }

}