<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvWorker;

class API_InvWorkerController extends BaseController{

	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvWorker;
        return $res->withJSON($TBL->tbl_fields(),200);
    }



    //all
    public function all($req,$res,$args){
        $InvWorker = InvWorker::all();
        $data = [
            "msg_data" => $InvWorker,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvWorker,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvWorker = InvWorker::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvWorker,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvWorker,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$InvWorker = InvWorker::where('id','=',$args['id'])->first();
		if(sizeof($InvWorker) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvWorker->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$InvWorker = InvWorker::create($req->getParsedBody());
		$data = [
			"msg_data" => InvWorker::all()->last(),
			"msg_status" => $InvWorker == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(InvWorker::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvWorker::where('id',$args['id'])
						->update($updates);
		$results = InvWorker::where('id',$args['id'])->first();
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
		$InvWorker = InvWorker::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvWorker,
			"msg_status" => sizeof($InvWorker) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvWorker,200);
	}

}