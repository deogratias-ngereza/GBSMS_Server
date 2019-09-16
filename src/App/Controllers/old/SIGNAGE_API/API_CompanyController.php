<?php
namespace App\Controllers\SIGNAGE_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Company;

class API_CompanyController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Company = Company::all();
        $data = [
            "msg_data" => $Company,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Company,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Company = Company::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Company,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Company,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Company = Company::where('id','=',$args['id'])->first();
		if(sizeof($Company) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Company->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}



	//insert
	public function insert($req,$res,$args){
		$fcode = $req->getParsedBody()["fcode"];
		mkdir($this->get_media_uploads_path()."/".$fcode);
		
		$Company = Company::create($req->getParsedBody());
		$data = [
			"msg_data" => Company::all()->last(),
			"msg_status" => $Company == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Company::all()->last(),200);
	}



	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Company::where('id',$args['id'])
						->update($updates);
		$results = Company::where('id',$args['id'])->first();
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
		$Company = Company::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Company,
			"msg_status" => sizeof($Company) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Company,200);
	}

}