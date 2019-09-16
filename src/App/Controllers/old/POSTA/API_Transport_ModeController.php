<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TransportMode;

class API_Transport_ModeController extends BaseController{

    //all
    public function all($req,$res,$args){
        $TransportMode = TransportMode::all();
        $data = [
            "msg_data" => $TransportMode,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($TransportMode,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TransportMode = TransportMode::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TransportMode,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($TransportMode,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TransportMode = TransportMode::where('id','=',$args['id'])->first();
		if(sizeof($TransportMode) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TransportMode->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TransportMode = TransportMode::create($req->getParsedBody());
		$data = [
			"msg_data" => TransportMode::all()->last(),
			"msg_status" => $TransportMode == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TransportMode::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TransportMode::where('id',$args['id'])
						->update($updates);
		$results = TransportMode::where('id',$args['id'])->first();
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
		$TransportMode = TransportMode::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TransportMode,
			"msg_status" => sizeof($TransportMode) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TransportMode,200);
	}

}