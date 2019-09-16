<?php
namespace App\Controllers\GARAGE_FUEL_STOCK;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\GPS_VehicleRecord;



class API_GPS_VehicleRecordController extends BaseController{


	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}

	
    //all
    public function all($req,$res,$args){
        $GPS_VehicleRecord = GPS_VehicleRecord::all();
        $data = [
            "msg_data" => $GPS_VehicleRecord,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($GPS_VehicleRecord,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $GPS_VehicleRecord = GPS_VehicleRecord::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $GPS_VehicleRecord,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($GPS_VehicleRecord,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$GPS_VehicleRecord = GPS_VehicleRecord::where('id','=',$args['id'])->first();
		if(sizeof($GPS_VehicleRecord) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$GPS_VehicleRecord->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$GPS_VehicleRecord = GPS_VehicleRecord::create($req->getParsedBody());
		$data = [
			"msg_data" => GPS_VehicleRecord::all()->last(),
			"msg_status" => $GPS_VehicleRecord == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(GPS_VehicleRecord::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = GPS_VehicleRecord::where('id',$args['id'])
						->update($updates);
		$results = GPS_VehicleRecord::where('id',$args['id'])->first();
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
		$GPS_VehicleRecord = GPS_VehicleRecord::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $GPS_VehicleRecord,
			"msg_status" => sizeof($GPS_VehicleRecord) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($GPS_VehicleRecord,200);
	}

}