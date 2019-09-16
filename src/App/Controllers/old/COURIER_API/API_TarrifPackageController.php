<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TarrifPackage;
use App\Models\Customer;

class API_TarrifPackageController extends BaseController{

    //all
    public function all($req,$res,$args){
        $TarrifPackage = TarrifPackage::all();
        $data = [
            "msg_data" => $TarrifPackage,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($TarrifPackage,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TarrifPackage = TarrifPackage::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TarrifPackage,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($TarrifPackage,200);
    }



    public function find_by_track_no($req,$res,$args){
        $TarrifPackage = TarrifPackage::where("manifest_track_no","=",$args['track_id'])->first();
		return $res->withJSON($TarrifPackage,200);
    }





     //get delete
	public function delete($req,$res,$args){
		$TarrifPackage = TarrifPackage::where('id','=',$args['id'])->first();
		if(sizeof($TarrifPackage) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TarrifPackage->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//assign tarrif_code to given customer_id
	public function assign_customer_tarrif($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Customer::where('id',$args['id'])
						->update($updates);
		$results = Customer::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		return $res->withJSON($results,200);
	}


	//insert
	public function insert($req,$res,$args){
		$TarrifPackage = TarrifPackage::create($req->getParsedBody());
		$data = [
			"msg_data" => TarrifPackage::all()->last(),
			"msg_status" => $TarrifPackage == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TarrifPackage::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TarrifPackage::where('id',$args['id'])
						->update($updates);
		$results = TarrifPackage::where('id',$args['id'])->first();
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
		$TarrifPackage = TarrifPackage::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TarrifPackage,
			"msg_status" => sizeof($TarrifPackage) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TarrifPackage,200);
	}

}