<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\SMSIncoming;

class API_SMSIncomingController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $SMSIncoming = new SMSIncoming;
        return $res->withJSON($SMSIncoming->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $SMSIncoming = SMSIncoming::orderBy('id','desc')->get();
        $data = [
            "msg_data" => $SMSIncoming,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($SMSIncoming,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $SMSIncoming = SMSIncoming::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $SMSIncoming,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($SMSIncoming,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$SMSIncoming = SMSIncoming::where('id','=',$args['id'])->first();
		if(sizeof($SMSIncoming) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$SMSIncoming->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$SMSIncoming = SMSIncoming::create($req->getParsedBody());
		$data = [
			"msg_data" => SMSIncoming::all()->last(),
			"msg_status" => $SMSIncoming == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(SMSIncoming::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = SMSIncoming::where('id',$args['id'])
						->update($updates);
		$results = SMSIncoming::where('id',$args['id'])->first();
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
		$SMSIncoming = SMSIncoming::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $SMSIncoming,
			"msg_status" => sizeof($SMSIncoming) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($SMSIncoming,200);
	}

}