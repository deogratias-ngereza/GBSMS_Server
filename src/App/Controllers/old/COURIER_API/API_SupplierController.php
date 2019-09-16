<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Supplier;

class API_SupplierController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Supplier = Supplier::all();
        $data = [
            "msg_data" => $Supplier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Supplier,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Supplier = Supplier::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Supplier,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Supplier,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Supplier = Supplier::where('id','=',$args['id'])->first();
		if(sizeof($Supplier) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Supplier->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Supplier = Supplier::create($req->getParsedBody());
		$data = [
			"msg_data" => Supplier::all()->last(),
			"msg_status" => $Supplier == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Supplier::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Supplier::where('id',$args['id'])
						->update($updates);
		$results = Supplier::where('id',$args['id'])->first();
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
		$Supplier = Supplier::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Supplier,
			"msg_status" => sizeof($Supplier) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Supplier,200);
	}

}