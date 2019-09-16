<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Trailer;
use App\Models\TM_Vehicle;

class API_TM_TrailerController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}

	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_Trailer;
        return $res->withJSON($TBL->tbl_fields(),200);
    }



    //attach given trailer to given truck
    public function attach_to_truck($req,$res,$args){
    	$update_status = TM_Trailer::where('id',$args['trailer_id'])
						->update($req->getParsedBody());
        $data = [
            "msg_data" => $update_status,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }


    //detach given trailer from given truck
    public function detach_from_truck($req,$res,$args){
    	$update_status = TM_Trailer::where('id',$args['trailer_id'])
						->update(["truck_id" => -1 ]);//back to -1
        $data = [
            "msg_data" => $update_status,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }


    
    //all
    public function all($req,$res,$args){
        $TM_Trailer = TM_Trailer::with(['truck'])->get();
        $data = [
            "msg_data" => $TM_Trailer,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_Trailer,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_Trailer = TM_Trailer::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_Trailer,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_Trailer,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_Trailer = TM_Trailer::where('id','=',$args['id'])->first();
		if(sizeof($TM_Trailer) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_Trailer->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_Trailer = TM_Trailer::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_Trailer::all()->last(),
			"msg_status" => $TM_Trailer == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_Trailer::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_Trailer::where('id',$args['id'])
						->update($updates);
		$results = TM_Trailer::where('id',$args['id'])->first();
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
		$TM_Trailer = TM_Trailer::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_Trailer,
			"msg_status" => sizeof($TM_Trailer) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_Trailer,200);
	}

}