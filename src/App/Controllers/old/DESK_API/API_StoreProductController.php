<?php
namespace App\Controllers\DESK_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\StoreProduct;

class API_StoreProductController extends BaseController{

    //all
    public function all($req,$res,$args){
        $StoreProduct = StoreProduct::all();
        $data = [
            "msg_data" => $StoreProduct,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($StoreProduct,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $StoreProduct = StoreProduct::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $StoreProduct,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($StoreProduct,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$StoreProduct = StoreProduct::where('id','=',$args['id'])->first();
		if(sizeof($StoreProduct) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$StoreProduct->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$StoreProduct = StoreProduct::create($req->getParsedBody());
		$data = [
			"msg_data" => StoreProduct::all()->last(),
			"msg_status" => $StoreProduct == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(StoreProduct::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = StoreProduct::where('id',$args['id'])
						->update($updates);
		$results = StoreProduct::where('id',$args['id'])->first();
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
		$StoreProduct = StoreProduct::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $StoreProduct,
			"msg_status" => sizeof($StoreProduct) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($StoreProduct,200);
	}

}