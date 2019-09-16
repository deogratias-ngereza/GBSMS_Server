<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\ServingArea;

class API_Serving_AreaController extends BaseController{

    //all
    public function all($req,$res,$args){
        $ServingArea = ServingArea::all();
        $data = [
            "msg_data" => $ServingArea,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($ServingArea,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $ServingArea = ServingArea::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $ServingArea,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($ServingArea,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$ServingArea = ServingArea::where('id','=',$args['id'])->first();
		if(sizeof($ServingArea) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$ServingArea->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$ServingArea = ServingArea::create($req->getParsedBody());
		$data = [
			"msg_data" => ServingArea::all()->last(),
			"msg_status" => $ServingArea == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(ServingArea::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = ServingArea::where('id',$args['id'])
						->update($updates);
		$results = ServingArea::where('id',$args['id'])->first();
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
		$ServingArea = ServingArea::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $ServingArea,
			"msg_status" => sizeof($ServingArea) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($ServingArea,200);
	}

}