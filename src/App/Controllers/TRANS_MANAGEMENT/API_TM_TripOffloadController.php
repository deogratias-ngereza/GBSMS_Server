<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_TripOffload;

class API_TM_TripOffloadController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TM_TripOffload = new $TM_TripOffload;
        return $res->withJSON($TM_TripOffload->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $TM_TripOffload = TM_TripOffload::all();
        $data = [
            "msg_data" => $TM_TripOffload,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_TripOffload,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_TripOffload = TM_TripOffload::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_TripOffload,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_TripOffload,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_TripOffload = TM_TripOffload::where('id','=',$args['id'])->first();
		if(sizeof($TM_TripOffload) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_TripOffload->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_TripOffload = TM_TripOffload::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_TripOffload::all()->last(),
			"msg_status" => $TM_TripOffload == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_TripOffload::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_TripOffload::where('id',$args['id'])
						->update($updates);
		$results = TM_TripOffload::where('id',$args['id'])->first();
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
		$TM_TripOffload = TM_TripOffload::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_TripOffload,
			"msg_status" => sizeof($TM_TripOffload) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_TripOffload,200);
	}

}