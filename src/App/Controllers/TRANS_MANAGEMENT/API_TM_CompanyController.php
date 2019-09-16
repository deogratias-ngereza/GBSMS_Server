<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Company;

class API_TM_CompanyController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TM_Company = new $TM_Company;
        return $res->withJSON($TM_Company->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $TM_Company = TM_Company::all();
        $data = [
            "msg_data" => $TM_Company,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_Company,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_Company = TM_Company::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_Company,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_Company,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_Company = TM_Company::where('id','=',$args['id'])->first();
		if(sizeof($TM_Company) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_Company->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_Company = TM_Company::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_Company::all()->last(),
			"msg_status" => $TM_Company == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_Company::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_Company::where('id',$args['id'])
						->update($updates);
		$results = TM_Company::where('id',$args['id'])->first();
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
		$TM_Company = TM_Company::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_Company,
			"msg_status" => sizeof($TM_Company) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_Company,200);
	}

}