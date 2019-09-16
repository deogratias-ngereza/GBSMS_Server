<?php
namespace App\Controllers\POSTA;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Io;

class API_IoController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Io = Io::all();
        $data = [
            "msg_data" => $Io,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Io,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Io = Io::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Io,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Io,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Io = Io::where('id','=',$args['id'])->first();
		if(sizeof($Io) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Io->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Io = Io::create($req->getParsedBody());
		$data = [
			"msg_data" => Io::all()->last(),
			"msg_status" => $Io == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Io::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Io::where('id',$args['id'])
						->update($updates);
		$results = Io::where('id',$args['id'])->first();
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
		$Io = Io::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Io,
			"msg_status" => sizeof($Io) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Io,200);
	}

}