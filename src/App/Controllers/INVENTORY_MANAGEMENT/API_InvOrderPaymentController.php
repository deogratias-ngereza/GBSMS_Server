<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvOrderPayment;

class API_InvOrderPaymentController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvOrderPayment;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $InvOrderPayment = InvOrderPayment::all();
        $data = [
            "msg_data" => $InvOrderPayment,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvOrderPayment,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvOrderPayment = InvOrderPayment::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvOrderPayment,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvOrderPayment,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$InvOrderPayment = InvOrderPayment::where('id','=',$args['id'])->first();
		if(sizeof($InvOrderPayment) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvOrderPayment->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$InvOrderPayment = InvOrderPayment::create($req->getParsedBody());
		$data = [
			"msg_data" => InvOrderPayment::all()->last(),
			"msg_status" => $InvOrderPayment == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(InvOrderPayment::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvOrderPayment::where('id',$args['id'])
						->update($updates);
		$results = InvOrderPayment::where('id',$args['id'])->first();
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
		$InvOrderPayment = InvOrderPayment::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvOrderPayment,
			"msg_status" => sizeof($InvOrderPayment) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvOrderPayment,200);
	}

}