<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_TripFixedPckg;

class API_TM_TripFixedPckgController extends BaseController{
	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_TripFixedPckg;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $TM_TripFixedPckg = TM_TripFixedPckg::with(['source','destination'])->get();
        $data = [
            "msg_data" => $TM_TripFixedPckg,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_TripFixedPckg,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_TripFixedPckg = TM_TripFixedPckg::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_TripFixedPckg,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_TripFixedPckg,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_TripFixedPckg = TM_TripFixedPckg::where('id','=',$args['id'])->first();
		if(sizeof($TM_TripFixedPckg) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_TripFixedPckg->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_TripFixedPckg = TM_TripFixedPckg::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_TripFixedPckg::all()->last(),
			"msg_status" => $TM_TripFixedPckg == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_TripFixedPckg::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_TripFixedPckg::where('id',$args['id'])
						->update($updates);
		$results = TM_TripFixedPckg::where('id',$args['id'])->first();
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
		$TM_TripFixedPckg = TM_TripFixedPckg::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_TripFixedPckg,
			"msg_status" => sizeof($TM_TripFixedPckg) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_TripFixedPckg,200);
	}

}