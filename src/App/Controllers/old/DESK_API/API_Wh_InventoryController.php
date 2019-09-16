<?php
namespace App\Controllers\DESK_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Wh_Inventory;

class API_Wh_InventoryController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Wh_Inventory = Wh_Inventory::all();
        $data = [
            "msg_data" => $Wh_Inventory,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
       // return $res->withJSON($Wh_Inventory,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Wh_Inventory = Wh_Inventory::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Wh_Inventory,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Wh_Inventory,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Wh_Inventory = Wh_Inventory::where('id','=',$args['id'])->first();
		if(sizeof($Wh_Inventory) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Wh_Inventory->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Wh_Inventory = Wh_Inventory::create($req->getParsedBody());
		$data = [
			"msg_data" => Wh_Inventory::all()->last(),
			"msg_status" => $Wh_Inventory == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Wh_Inventory::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Wh_Inventory::where('id',$args['id'])
						->update($updates);
		$results = Wh_Inventory::where('id',$args['id'])->first();
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
		$Wh_Inventory = Wh_Inventory::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Wh_Inventory,
			"msg_status" => sizeof($Wh_Inventory) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Wh_Inventory,200);
	}

}