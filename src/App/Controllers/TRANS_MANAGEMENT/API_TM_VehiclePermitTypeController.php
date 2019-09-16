<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_VehiclePermitType;

class API_TM_VehiclePermitTypeController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}

	
	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_VehiclePermitType;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $TM_VehiclePermitType = TM_VehiclePermitType::all();
        $data = [
            "msg_data" => $TM_VehiclePermitType,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_VehiclePermitType,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_VehiclePermitType = TM_VehiclePermitType::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_VehiclePermitType,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_VehiclePermitType,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_VehiclePermitType = TM_VehiclePermitType::where('id','=',$args['id'])->first();
		if(sizeof($TM_VehiclePermitType) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_VehiclePermitType->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_VehiclePermitType = TM_VehiclePermitType::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_VehiclePermitType::all()->last(),
			"msg_status" => $TM_VehiclePermitType == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_VehiclePermitType::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_VehiclePermitType::where('id',$args['id'])
						->update($updates);
		$results = TM_VehiclePermitType::where('id',$args['id'])->first();
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
		$TM_VehiclePermitType = TM_VehiclePermitType::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_VehiclePermitType,
			"msg_status" => sizeof($TM_VehiclePermitType) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_VehiclePermitType,200);
	}

}