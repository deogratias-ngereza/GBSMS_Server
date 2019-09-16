<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\SMSGroup;

class API_SMSGroupController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $SMSGroup = new SMSGroup;
        return $res->withJSON($SMSGroup->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $SMSGroup = SMSGroup::where("deleted",0)->get();
        $data = [
            "msg_data" => $SMSGroup,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($SMSGroup,200);
    }
    public function all_for_account($req,$res,$args){
    	$account_id = $args['account_id'];
        $SMSGroup = SMSGroup::where('customer_id',$account_id)->where("deleted",0)->withCount('contactIds')->get();
        $data = [
            "msg_data" => $SMSGroup,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }
    

    //find from given id
    public function find($req,$res,$args){
        $SMSGroup = SMSGroup::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $SMSGroup,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($SMSGroup,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$SMSGroup = SMSGroup::where('id','=',$args['id'])->first();
		if(sizeof($SMSGroup) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		//$SMSGroup->delete();
		$SMSGroup->deleted = 1;
		$SMSGroup->update();

		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$SMSGroup = SMSGroup::create($req->getParsedBody());
		$data = [
			"msg_data" => SMSGroup::all()->last(),
			"msg_status" => $SMSGroup == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(SMSGroup::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = SMSGroup::where('id',$args['id'])
						->update($updates);
		$results = SMSGroup::where('id',$args['id'])->first();
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
		$SMSGroup = SMSGroup::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $SMSGroup,
			"msg_status" => sizeof($SMSGroup) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($SMSGroup,200);
	}

}