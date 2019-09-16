<?php
namespace App\Controllers\DESK_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Worker;

class API_WorkerController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Worker = Worker::all();
        $data = [
            "msg_data" => $Worker,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($Worker,200);
    }

    
    public function all_warehouse_workers($req,$res,$args){
        $Workers = Worker::where('warehouse_id',$args['id'])->get();
        return $res->withJSON($Workers,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Worker = Worker::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Worker,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Worker,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Worker = Worker::where('id','=',$args['id'])->first();
		if(sizeof($Worker) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Worker->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Worker = Worker::create($req->getParsedBody());
		$data = [
			"msg_data" => Worker::all()->last(),
			"msg_status" => $Worker == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Worker::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Worker::where('id',$args['id'])
						->update($updates);
		$results = Worker::where('id',$args['id'])->first();
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
		$Worker = Worker::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Worker,
			"msg_status" => sizeof($Worker) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Worker,200);
	}

}