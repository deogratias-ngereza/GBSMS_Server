<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CustomerAccount;

class API_CustomerAccController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $CustomerAccount = new CustomerAccount;
        return $res->withJSON($CustomerAccount->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $CustomerAccount = CustomerAccount::all();
        $data = [
            "msg_data" => $CustomerAccount,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($CustomerAccount,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $CustomerAccount = CustomerAccount::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $CustomerAccount,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($CustomerAccount,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$CustomerAccount = CustomerAccount::where('id','=',$args['id'])->first();
		if(sizeof($CustomerAccount) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$CustomerAccount->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$CustomerAccount = CustomerAccount::create($req->getParsedBody());
		$data = [
			"msg_data" => CustomerAccount::all()->last(),
			"msg_status" => $CustomerAccount == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(CustomerAccount::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = CustomerAccount::where('id',$args['id'])
						->update($updates);
		$results = CustomerAccount::where('id',$args['id'])->first();
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
		$CustomerAccount = CustomerAccount::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $CustomerAccount,
			"msg_status" => sizeof($CustomerAccount) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($CustomerAccount,200);
	}

}