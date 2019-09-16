<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TrainCarrier;

class API_Train_CarrierController extends BaseController{

    //all
    public function all($req,$res,$args){
        $TrainCarrier = TrainCarrier::all();
        $data = [
            "msg_data" => $TrainCarrier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($TrainCarrier,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TrainCarrier = TrainCarrier::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TrainCarrier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($TrainCarrier,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TrainCarrier = TrainCarrier::where('id','=',$args['id'])->first();
		if(sizeof($TrainCarrier) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TrainCarrier->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TrainCarrier = TrainCarrier::create($req->getParsedBody());
		$data = [
			"msg_data" => TrainCarrier::all()->last(),
			"msg_status" => $TrainCarrier == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TrainCarrier::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TrainCarrier::where('id',$args['id'])
						->update($updates);
		$results = TrainCarrier::where('id',$args['id'])->first();
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
		$TrainCarrier = TrainCarrier::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TrainCarrier,
			"msg_status" => sizeof($TrainCarrier) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TrainCarrier,200);
	}

}