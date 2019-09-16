<?php
namespace App\Controllers\CUSTOMER_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CustomerAddress;

class API_CustomerAddressController extends BaseController{

    //all
    public function all($req,$res,$args){
        $CustomerAddress = CustomerAddress::all();
        $data = [
            "msg_data" => $CustomerAddress,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($CustomerAddress,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $CustomerAddress = CustomerAddress::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $CustomerAddress,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($CustomerAddress,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$CustomerAddress = CustomerAddress::where('id','=',$args['id'])->first();
		if(sizeof($CustomerAddress) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$CustomerAddress->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}




	//insert / update the address
	public function insert($req,$res,$args){
		$customer_id = $req->getParsedBody()['customer_id'];
		$option = $req->getParsedBody()['address_for'];

		//check if exists update or insert
		$addrObj = CustomerAddress::where('customer_id',$customer_id)->Where('address_for',$option)->first();
		if($addrObj == null){
			$CustomerAddress = CustomerAddress::create($req->getParsedBody());
			$data = [
				"msg_data" => CustomerAddress::all()->last(),
				"msg_status" => $CustomerAddress == null ? "FAIL TO INSERT" :"OK"
			];
			return $res->withJSON(CustomerAddress::all()->last(),200);
		}else{
			$addrObj->region = $req->getParsedBody()['region'];
			$addrObj->district = $req->getParsedBody()['district'];
			$addrObj->phone = $req->getParsedBody()['phone'];
			$addrObj->location = $req->getParsedBody()['location'];
			$addrObj->address_for = $req->getParsedBody()['address_for'];
			$addrObj->update();
			return $res->withJSON("UPDATED",200);
		}

		
	}




	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = CustomerAddress::where('id',$args['id'])
						->update($updates);
		$results = CustomerAddress::where('id',$args['id'])->first();
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
		$CustomerAddress = CustomerAddress::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $CustomerAddress,
			"msg_status" => sizeof($CustomerAddress) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($CustomerAddress,200);
	}

}