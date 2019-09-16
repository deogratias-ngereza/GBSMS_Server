<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_TripPathPoint;

class API_TM_TripPathPointController extends BaseController{
	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_TripPathPoint;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $TM_TripPathPoint = TM_TripPathPoint::with(['source','destination'])->get();
        $data = [
            "msg_data" => $TM_TripPathPoint,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_TripPathPoint,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_TripPathPoint = TM_TripPathPoint::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_TripPathPoint,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_TripPathPoint,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_TripPathPoint = TM_TripPathPoint::where('id','=',$args['id'])->first();
		if(sizeof($TM_TripPathPoint) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_TripPathPoint->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_TripPathPoint = TM_TripPathPoint::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_TripPathPoint::all()->last(),
			"msg_status" => $TM_TripPathPoint == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_TripPathPoint::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_TripPathPoint::where('id',$args['id'])
						->update($updates);
		$results = TM_TripPathPoint::where('id',$args['id'])->first();
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
		$TM_TripPathPoint = TM_TripPathPoint::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_TripPathPoint,
			"msg_status" => sizeof($TM_TripPathPoint) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_TripPathPoint,200);
	}

}