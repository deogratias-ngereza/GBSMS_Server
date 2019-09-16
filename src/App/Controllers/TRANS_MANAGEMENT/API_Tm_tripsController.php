<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Tm_trips;

class API_Tm_tripsController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $Tm_trips = new $Tm_trips;
        return $res->withJSON($Tm_trips->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $Tm_trips = Tm_trips::all();
        $data = [
            "msg_data" => $Tm_trips,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($Tm_trips,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Tm_trips = Tm_trips::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Tm_trips,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($Tm_trips,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Tm_trips = Tm_trips::where('id','=',$args['id'])->first();
		if(sizeof($Tm_trips) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Tm_trips->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Tm_trips = Tm_trips::create($req->getParsedBody());
		$data = [
			"msg_data" => Tm_trips::all()->last(),
			"msg_status" => $Tm_trips == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Tm_trips::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Tm_trips::where('id',$args['id'])
						->update($updates);
		$results = Tm_trips::where('id',$args['id'])->first();
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
		$Tm_trips = Tm_trips::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Tm_trips,
			"msg_status" => sizeof($Tm_trips) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Tm_trips,200);
	}

}