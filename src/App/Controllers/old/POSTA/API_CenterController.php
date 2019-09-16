<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Center;

class API_CenterController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Center = Center::all();
        $data = [
            "msg_data" => $Center,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Center,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Center = Center::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Center,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Center,200);
    }

    //find_center_code
    public function find_center_code($req,$res,$args){
        $Center = Center::where("center_code","=",$args['center_code'])->first();
        $data = [
            "msg_data" => $Center,
            "msg_status" => "OK"
        ];
		return $res->withJSON($Center,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Center = Center::where('id','=',$args['id'])->first();
		if(sizeof($Center) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Center->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Center = Center::create($req->getParsedBody());
		$data = [
			"msg_data" => Center::all()->last(),
			"msg_status" => $Center == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Center::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Center::where('id',$args['id'])
						->update($updates);
		$results = Center::where('id',$args['id'])->first();
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
		$Center = Center::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Center,
			"msg_status" => sizeof($Center) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Center,200);
	}

}