<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\OTP;

class API_OTPController extends BaseController{

    //all
    public function all($req,$res,$args){
        $OTP = OTP::all();
        $data = [
            "msg_data" => $OTP,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($OTP,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $OTP = OTP::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $OTP,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($OTP,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$OTP = OTP::where('id','=',$args['id'])->first();
		if(sizeof($OTP) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$OTP->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$OTP = OTP::create($req->getParsedBody());
		$data = [
			"msg_data" => OTP::all()->last(),
			"msg_status" => $OTP == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(OTP::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = OTP::where('id',$args['id'])
						->update($updates);
		$results = OTP::where('id',$args['id'])->first();
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
		$OTP = OTP::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $OTP,
			"msg_status" => sizeof($OTP) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($OTP,200);
	}

}