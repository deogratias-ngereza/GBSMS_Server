<?php
namespace App\Controllers\DESK_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ProductMovementHistory;

class API_ProductMovementHistoryController extends BaseController{

    //all
    public function all($req,$res,$args){
        $ProductMovementHistory = ProductMovementHistory::orderBy('id','desc')->get();
        $data = [
            "msg_data" => $ProductMovementHistory,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($ProductMovementHistory,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $ProductMovementHistory = ProductMovementHistory::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $ProductMovementHistory,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($ProductMovementHistory,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$ProductMovementHistory = ProductMovementHistory::where('id','=',$args['id'])->first();
		if(sizeof($ProductMovementHistory) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$ProductMovementHistory->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$ProductMovementHistory = ProductMovementHistory::create($req->getParsedBody());
		$data = [
			"msg_data" => ProductMovementHistory::all()->last(),
			"msg_status" => $ProductMovementHistory == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(ProductMovementHistory::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = ProductMovementHistory::where('id',$args['id'])
						->update($updates);
		$results = ProductMovementHistory::where('id',$args['id'])->first();
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
		$ProductMovementHistory = ProductMovementHistory::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $ProductMovementHistory,
			"msg_status" => sizeof($ProductMovementHistory) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($ProductMovementHistory,200);
	}

}