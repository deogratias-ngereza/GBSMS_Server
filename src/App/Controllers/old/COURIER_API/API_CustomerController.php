<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Customer;

class API_CustomerController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Customer = Customer::with('manager')->orderBy('id','desc')->get();
        $data = [
            "msg_data" => $Customer,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Customer,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Customer = Customer::where("id","=",$args['id'])->first();
		return $res->withJSON($Customer,200);
    }




     //get delete
	public function delete($req,$res,$args){
		$Customer = Customer::where('id','=',$args['id'])->first();
		if(sizeof($Customer) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Customer->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Customer = Customer::create($req->getParsedBody());
		$data = [
			"msg_data" => Customer::all()->last(),
			"msg_status" => $Customer == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Customer::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Customer::where('id',$args['id'])
						->update($updates);
		$results = Customer::where('id',$args['id'])->first();
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
		$Customer = Customer::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Customer,
			"msg_status" => sizeof($Customer) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Customer,200);
	}

}