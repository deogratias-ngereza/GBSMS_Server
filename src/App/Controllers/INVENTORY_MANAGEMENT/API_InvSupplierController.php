<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvSupplier;

class API_InvSupplierController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvSupplier;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $InvSupplier = InvSupplier::all();
        $data = [
            "msg_data" => $InvSupplier,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvSupplier,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvSupplier = InvSupplier::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvSupplier,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvSupplier,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$InvSupplier = InvSupplier::where('id','=',$args['id'])->first();
		if(sizeof($InvSupplier) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvSupplier->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$InvSupplier = InvSupplier::create($req->getParsedBody());
		$data = [
			"msg_data" => InvSupplier::all()->last(),
			"msg_status" => $InvSupplier == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(InvSupplier::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvSupplier::where('id',$args['id'])
						->update($updates);
		$results = InvSupplier::where('id',$args['id'])->first();
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
		$InvSupplier = InvSupplier::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvSupplier,
			"msg_status" => sizeof($InvSupplier) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvSupplier,200);
	}

}