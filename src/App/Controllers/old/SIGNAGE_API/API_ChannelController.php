<?php
namespace App\Controllers\SIGNAGE_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Channel;
use App\Models\Company;

class API_ChannelController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Channel = Channel::all();
        $data = [
            "msg_data" => $Channel,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Channel,200);
    }

    //all
    public function all_for_company($req,$res,$args){
    	//$this->log("warning","test msg info");
        $Channel = Channel::where('company_id',$args['id'])->with('medias')->get();
        $data = [
            "msg_data" => $Channel,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Channel,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Channel = Channel::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Channel,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Channel,200);
    }

     //get delete
	public function delete($req,$res,$args){

		$Channel = Channel::where('id','=',$args['id'])->first();
		if(sizeof($Channel) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Channel->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}



	//insert
	public function insert($req,$res,$args){

		$company_obj = Company::where('id',$req->getParsedBody()["company_id"])->first();
		//return $res->withJSON(["res"=>$company_obj],200);
		$company_fcode = $company_obj->fcode;

		$channel_fcode = $req->getParsedBody()["fcode"];
		mkdir($this->get_media_uploads_path()."/".$company_fcode.'/'.$channel_fcode);

		$Channel = Channel::create($req->getParsedBody());
		$data = [
			"msg_data" => Channel::all()->last(),
			"msg_status" => $Channel == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Channel::all()->last(),200);
	}



	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Channel::where('id',$args['id'])
						->update($updates);
		$results = Channel::where('id',$args['id'])->first();
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
		$Channel = Channel::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Channel,
			"msg_status" => sizeof($Channel) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Channel,200);
	}

}