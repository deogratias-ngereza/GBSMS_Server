<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Pod;

class API_PodController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Pod = Pod::orderBy('created_date', 'DESC')
        		->take($this->getLimitSize('XXL'))->get();
        $data = [
            "msg_data" => $Pod,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Pod,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Pod = Pod::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Pod,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Pod,200);
    }



    public function find_by_track_no($req,$res,$args){
        $Pod = Pod::where("manifest_track_no","=",$args['track_id'])->first();
		return $res->withJSON($Pod,200);
    }





     //get delete
	public function delete($req,$res,$args){
		$Pod = Pod::where('id','=',$args['id'])->first();
		if(sizeof($Pod) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Pod->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Pod = Pod::create($req->getParsedBody());
		$data = [
			"msg_data" => Pod::all()->last(),
			"msg_status" => $Pod == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Pod::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Pod::where('id',$args['id'])
						->update($updates);
		$results = Pod::where('id',$args['id'])->first();
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
		$Pod = Pod::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Pod,
			"msg_status" => sizeof($Pod) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Pod,200);
	}

}