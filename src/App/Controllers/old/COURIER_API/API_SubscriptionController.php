<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Subscription;

class API_SubscriptionController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Subscription = Subscription::all();
        $data = [
            "msg_data" => $Subscription,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($Subscription,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $Subscription = Subscription::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Subscription,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($Subscription,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$Subscription = Subscription::where('id','=',$args['id'])->first();
		if(sizeof($Subscription) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Subscription->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Subscription = Subscription::create($req->getParsedBody());
		$data = [
			"msg_data" => Subscription::all()->last(),
			"msg_status" => $Subscription == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Subscription::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Subscription::where('id',$args['id'])
						->update($updates);
		$results = Subscription::where('id',$args['id'])->first();
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
		$Subscription = Subscription::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Subscription,
			"msg_status" => sizeof($Subscription) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Subscription,200);
	}

}