<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\SMSOutgoing;

class API_SMSOutgoingController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $SMSOutgoing = new SMSOutgoing;
        return $res->withJSON($SMSOutgoing->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $SMSOutgoing = SMSOutgoing::all();
        $data = [
            "msg_data" => $SMSOutgoing,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($SMSOutgoing,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $SMSOutgoing = SMSOutgoing::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $SMSOutgoing,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($SMSOutgoing,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$SMSOutgoing = SMSOutgoing::where('id','=',$args['id'])->first();
		if(sizeof($SMSOutgoing) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$SMSOutgoing->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$SMSOutgoing = SMSOutgoing::create($req->getParsedBody());
		$data = [
			"msg_data" => SMSOutgoing::all()->last(),
			"msg_status" => $SMSOutgoing == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(SMSOutgoing::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = SMSOutgoing::where('id',$args['id'])
						->update($updates);
		$results = SMSOutgoing::where('id',$args['id'])->first();
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
		$SMSOutgoing = SMSOutgoing::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $SMSOutgoing,
			"msg_status" => sizeof($SMSOutgoing) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($SMSOutgoing,200);
	}

}