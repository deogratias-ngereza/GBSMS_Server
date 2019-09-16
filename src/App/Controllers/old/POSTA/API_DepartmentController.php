<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Department;

class API_DepartmentController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Department = Department::all();
        $data = [
            "msg_data" => $Department,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Department,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Department = Department::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Department,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Department,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Department = Department::where('id','=',$args['id'])->first();
		if(sizeof($Department) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Department->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Department = Department::create($req->getParsedBody());
		$data = [
			"msg_data" => Department::all()->last(),
			"msg_status" => $Department == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Department::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Department::where('id',$args['id'])
						->update($updates);
		$results = Department::where('id',$args['id'])->first();
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
		$Department = Department::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Department,
			"msg_status" => sizeof($Department) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Department,200);
	}

}