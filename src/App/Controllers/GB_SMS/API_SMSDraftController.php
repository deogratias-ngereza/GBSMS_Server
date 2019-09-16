<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\SMSDraft;

class API_SMSDraftController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $SMSDraft = new SMSDraft;
        return $res->withJSON($SMSDraft->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $SMSDraft = SMSDraft::all();
        $data = [
            "msg_data" => $SMSDraft,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($SMSDraft,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $SMSDraft = SMSDraft::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $SMSDraft,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($SMSDraft,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$SMSDraft = SMSDraft::where('id','=',$args['id'])->first();
		if(sizeof($SMSDraft) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$SMSDraft->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$SMSDraft = SMSDraft::create($req->getParsedBody());
		$data = [
			"msg_data" => SMSDraft::all()->last(),
			"msg_status" => $SMSDraft == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(SMSDraft::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = SMSDraft::where('id',$args['id'])
						->update($updates);
		$results = SMSDraft::where('id',$args['id'])->first();
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
		$SMSDraft = SMSDraft::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $SMSDraft,
			"msg_status" => sizeof($SMSDraft) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($SMSDraft,200);
	}

}