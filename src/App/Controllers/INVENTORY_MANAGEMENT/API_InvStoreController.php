<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvStore;

class API_InvStoreController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvStore;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $InvStore = InvStore::all();
        $data = [
            "msg_data" => $InvStore,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvStore,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvStore = InvStore::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvStore,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvStore,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$InvStore = InvStore::where('id','=',$args['id'])->first();
		if(sizeof($InvStore) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvStore->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$InvStore = InvStore::create($req->getParsedBody());
		$data = [
			"msg_data" => InvStore::all()->last(),
			"msg_status" => $InvStore == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(InvStore::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvStore::where('id',$args['id'])
						->update($updates);
		$results = InvStore::where('id',$args['id'])->first();
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
		$InvStore = InvStore::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvStore,
			"msg_status" => sizeof($InvStore) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvStore,200);
	}

}