<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\SMSHistory;

class API_SMSHistoryController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $SMSHistory = new SMSHistory;
        return $res->withJSON($SMSHistory->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $SMSHistory = SMSHistory::all();
        $data = [
            "msg_data" => $SMSHistory,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($SMSHistory,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $SMSHistory = SMSHistory::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $SMSHistory,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($SMSHistory,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$SMSHistory = SMSHistory::where('id','=',$args['id'])->first();
		if(sizeof($SMSHistory) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$SMSHistory->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$SMSHistory = SMSHistory::create($req->getParsedBody());
		$data = [
			"msg_data" => SMSHistory::all()->last(),
			"msg_status" => $SMSHistory == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(SMSHistory::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = SMSHistory::where('id',$args['id'])
						->update($updates);
		$results = SMSHistory::where('id',$args['id'])->first();
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
		$SMSHistory = SMSHistory::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $SMSHistory,
			"msg_status" => sizeof($SMSHistory) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($SMSHistory,200);
	}

}