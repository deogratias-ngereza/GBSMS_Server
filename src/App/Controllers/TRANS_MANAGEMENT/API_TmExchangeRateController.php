<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TmExchangeRate;

class API_TmExchangeRateController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}
	
	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TmExchangeRate;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $TmExchangeRate = TmExchangeRate::all();
        $data = [
            "msg_data" => $TmExchangeRate,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TmExchangeRate,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TmExchangeRate = TmExchangeRate::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TmExchangeRate,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TmExchangeRate,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TmExchangeRate = TmExchangeRate::where('id','=',$args['id'])->first();
		if(sizeof($TmExchangeRate) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TmExchangeRate->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TmExchangeRate = TmExchangeRate::create($req->getParsedBody());
		$data = [
			"msg_data" => TmExchangeRate::all()->last(),
			"msg_status" => $TmExchangeRate == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TmExchangeRate::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TmExchangeRate::where('id',$args['id'])
						->update($updates);
		$results = TmExchangeRate::where('id',$args['id'])->first();
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
		$TmExchangeRate = TmExchangeRate::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TmExchangeRate,
			"msg_status" => sizeof($TmExchangeRate) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TmExchangeRate,200);
	}

}