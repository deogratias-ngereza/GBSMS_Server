<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Trip_Loading;

class API_TM_TripLoadingController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TM_Trip_Loading = new $TM_Trip_Loading;
        return $res->withJSON($TM_Trip_Loading->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $TM_Trip_Loading = TM_Trip_Loading::all();
        $data = [
            "msg_data" => $TM_Trip_Loading,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_Trip_Loading,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_Trip_Loading = TM_Trip_Loading::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_Trip_Loading,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_Trip_Loading,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_Trip_Loading = TM_Trip_Loading::where('id','=',$args['id'])->first();
		if(sizeof($TM_Trip_Loading) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_Trip_Loading->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_Trip_Loading = TM_Trip_Loading::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_Trip_Loading::all()->last(),
			"msg_status" => $TM_Trip_Loading == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_Trip_Loading::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_Trip_Loading::where('id',$args['id'])
						->update($updates);
		$results = TM_Trip_Loading::where('id',$args['id'])->first();
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
		$TM_Trip_Loading = TM_Trip_Loading::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_Trip_Loading,
			"msg_status" => sizeof($TM_Trip_Loading) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_Trip_Loading,200);
	}

}