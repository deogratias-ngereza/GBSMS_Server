<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\VirtualBox;

class API_VirtualBoxController extends BaseController{

    //all
    public function all($req,$res,$args){
        $VirtualBox = VirtualBox::all();
        $data = [
            "msg_data" => $VirtualBox,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($VirtualBox,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $VirtualBox = VirtualBox::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $VirtualBox,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($VirtualBox,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$VirtualBox = VirtualBox::where('id','=',$args['id'])->first();
		if(sizeof($VirtualBox) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$VirtualBox->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$VirtualBox = VirtualBox::create($req->getParsedBody());
		$data = [
			"msg_data" => VirtualBox::all()->last(),
			"msg_status" => $VirtualBox == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(VirtualBox::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = VirtualBox::where('id',$args['id'])
						->update($updates);
		$results = VirtualBox::where('id',$args['id'])->first();
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
		$VirtualBox = VirtualBox::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $VirtualBox,
			"msg_status" => sizeof($VirtualBox) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($VirtualBox,200);
	}

}