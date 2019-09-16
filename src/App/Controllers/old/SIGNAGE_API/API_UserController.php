<?php
namespace App\Controllers\SIGNAGE_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\User;

class API_UserController extends BaseController{

    //all
    public function all($req,$res,$args){
        $User = User::all();
        $data = [
            "msg_data" => $User,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($User,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $User = User::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $User,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($User,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$User = User::where('id','=',$args['id'])->first();
		if(sizeof($User) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$User->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$User = User::create($req->getParsedBody());
		$data = [
			"msg_data" => User::all()->last(),
			"msg_status" => $User == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(User::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = User::where('id',$args['id'])
						->update($updates);
		$results = User::where('id',$args['id'])->first();
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
		$User = User::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $User,
			"msg_status" => sizeof($User) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($User,200);
	}

}