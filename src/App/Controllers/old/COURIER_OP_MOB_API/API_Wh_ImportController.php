<?php
namespace App\Controllers\COURIER_OP_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Wh_Import;

class API_Wh_ImportController extends BaseController{

    //all for a given ware house id
    public function all_for_warehouse($req,$res,$args){
        $Wh_Import = Wh_Import::where('destination_warehouse_id',$args['id'])
        	->with(['product','supplier','worker','warehouse'])
        	->get();
        $data = [
            "msg_data" => $Wh_Import,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Wh_Import = Wh_Import::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Wh_Import,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Wh_Import,200);
    }

   

	//insert
	public function insert($req,$res,$args){
		$Wh_Import = Wh_Import::create($req->getParsedBody());
		$data = [
			"msg_data" => Wh_Import::all()->last(),
			"msg_status" => $Wh_Import == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Wh_Import::all()->last(),200);
	}

	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$Wh_Import = Wh_Import::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Wh_Import,
			"msg_status" => sizeof($Wh_Import) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Wh_Import,200);
	}

}