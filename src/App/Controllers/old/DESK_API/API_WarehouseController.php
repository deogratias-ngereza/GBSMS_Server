<?php
namespace App\Controllers\DESK_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Warehouse;

class API_WarehouseController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Warehouse = Warehouse::all();
        $data = [
            "msg_data" => $Warehouse,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($Warehouse,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Warehouse = Warehouse::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Warehouse,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Warehouse,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Warehouse = Warehouse::where('id','=',$args['id'])->first();
		if(sizeof($Warehouse) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Warehouse->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Warehouse = Warehouse::create($req->getParsedBody());
		$data = [
			"msg_data" => Warehouse::all()->last(),
			"msg_status" => $Warehouse == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Warehouse::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Warehouse::where('id',$args['id'])
						->update($updates);
		$results = Warehouse::where('id',$args['id'])->first();
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
		$Warehouse = Warehouse::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Warehouse,
			"msg_status" => sizeof($Warehouse) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Warehouse,200);
	}

}