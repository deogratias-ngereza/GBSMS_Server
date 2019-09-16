<?php
namespace App\Controllers\GB_SMS;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\SMSContact;



class API_SMSContactController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $SMSContact = new SMSContact;
        return $res->withJSON($SMSContact->tbl_fields(),200);
    }


    //all
    public function all($req,$res,$args){
        $SMSContact = SMSContact::all();
        $data = [
            "msg_data" => $SMSContact,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($SMSContact,200);
    }


    
    public function all_for_account($req,$res,$args){
    	$account_id = $args['account_id'];
    	$group_id = isset($args['group_id']) ? $args['account_id'] : -1;

    	$SMSContacts = null;
    	if($group_id == -1){
    		$SMSContacts = SMSContact::where('deleted',0)->where('customer_id',$account_id)->with(['groups.group'])->get();
    	}
    	else{
    		$SMSContacts = SMSContact::where('deleted',0)->where('customer_id',$account_id)
    		->whereHas('groups',function($query) use ($group_id){
    			$query->where('group_id','=',$group_id);
    		})
    		//->with(['groups.group'])
    		->get();
    	}

        
        $data = [
            "msg_data" => $SMSContacts,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $SMSContact = SMSContact::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $SMSContact,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($SMSContact,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$SMSContact = SMSContact::where('id','=',$args['id'])->first();
		if(sizeof($SMSContact) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$SMSContact->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$SMSContact = SMSContact::create($req->getParsedBody());
		$data = [
			"msg_data" => SMSContact::all()->last(),
			"msg_status" => $SMSContact == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(SMSContact::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = SMSContact::where('id',$args['id'])
						->update($updates);
		$results = SMSContact::where('id',$args['id'])->first();
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
		$SMSContact = SMSContact::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $SMSContact,
			"msg_status" => sizeof($SMSContact) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($SMSContact,200);
	}

}