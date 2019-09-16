<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvOperationalCost;

class API_InvOperationalCostController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvOperationalCost;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $InvOperationalCost = InvOperationalCost::all();
        $data = [
            "msg_data" => $InvOperationalCost,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvOperationalCost,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvOperationalCost = InvOperationalCost::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvOperationalCost,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvOperationalCost,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$InvOperationalCost = InvOperationalCost::where('id','=',$args['id'])->first();
		if(sizeof($InvOperationalCost) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvOperationalCost->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$InvOperationalCost = InvOperationalCost::create($req->getParsedBody());
		$data = [
			"msg_data" => InvOperationalCost::all()->last(),
			"msg_status" => $InvOperationalCost == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(InvOperationalCost::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvOperationalCost::where('id',$args['id'])
						->update($updates);
		$results = InvOperationalCost::where('id',$args['id'])->first();
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
		$InvOperationalCost = InvOperationalCost::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvOperationalCost,
			"msg_status" => sizeof($InvOperationalCost) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvOperationalCost,200);
	}

}