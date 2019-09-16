<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Admin;

use App\Utilities\G_PasswordUtility as GHash;

class API_AdminController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Admin = Admin::all();
        $data = [
            "msg_data" => $Admin,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Admin,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Admin = Admin::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Admin,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Admin,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Admin = Admin::where('id','=',$args['id'])->first();
		if(sizeof($Admin) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Admin->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$inputs = $req->getParsedBody();
		$hash = new GHash();
		$inputs['password'] = $hash->encrypt($inputs['password']);
		$Admin = Admin::create($inputs);
		$data = [
			"msg_data" => Admin::all()->last(),
			"msg_status" => $Admin == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON(Admin::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$inputs = $req->getParsedBody();
		$update_status = Admin::where('id',$args['id'])
						->update($inputs);
		$results = Admin::where('id',$args['id'])->first();
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
		$Admin = Admin::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Admin,
			"msg_status" => sizeof($Admin) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Admin,200);
	}



	//reset_password
	public function reset_password($req,$res,$args){
		$inputs = $req->getParsedBody();
		$hash = new GHash();
		$inputs['password'] = $hash->encrypt($inputs['password']);
		$update_status = Admin::where('id',$args['id'])
						->update($inputs);
		$results = Admin::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($results,200);
	}







}