<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CashRequest;

class API_CashRequestController extends BaseController{

    //all
    public function all($req,$res,$args){
        $CashRequest = CashRequest::all();
        $data = [
            "msg_data" => $CashRequest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($CashRequest,200);
    }



    //all cash request for a given worker
    public function all_for_worker($req,$res,$args){
        $CashRequest = CashRequest::where('for_worker_id',$args['id'])->with(['customer','worker','creator','approver'])->get();
        $data = [
            "msg_data" => $CashRequest,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }



    //find from given id
    public function find($req,$res,$args){
        $CashRequest = CashRequest::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $CashRequest,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($CashRequest,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$CashRequest = CashRequest::where('id','=',$args['id'])->first();
		if(sizeof($CashRequest) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$CashRequest->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$CashRequest = CashRequest::create($req->getParsedBody());
		$data = [
			"msg_data" => CashRequest::all()->last(),
			"msg_status" => $CashRequest == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(CashRequest::all()->last(),200);
	}



	//update cash request
	public function approve_cash_request($req,$res,$args){
		$approver_id = trim($req->getParsedBody()['approver_id'],"'");
		$cash_req_id = trim($req->getParsedBody()['cash_req_id'],"'");

		$CashRequest = CashRequest::where('id',$cash_req_id)->first();
		$CashRequest->approved = 1;// approved
		$CashRequest->approved_by = $approver_id;
		$CashRequest->approved_date = $this->get_current_date_time();
		$CashRequest->update();

		$data = [
			"msg_data" => "CASH REQUEST UPDATED",
			"msg_status" => $CashRequest == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON($data,200);
	}


	//give cash to a person
	public function give_cash_request($req,$res,$args){
		$cashier_id = trim($req->getParsedBody()['cashier_id'],"'");
		$cash_req_id = trim($req->getParsedBody()['cash_req_id'],"'");

		$CashRequest = CashRequest::where('id',$cash_req_id)->first();
		$CashRequest->given = 1;// given
		$CashRequest->given_by = $cashier_id;
		$CashRequest->given_date = $this->get_current_date_time();
		$CashRequest->update();

		$data = [
			"msg_data" => "CASH REQUEST UPDATED",
			"msg_status" => $CashRequest == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON($data,200);
	}







	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = CashRequest::where('id',$args['id'])
						->update($updates);
		$results = CashRequest::where('id',$args['id'])->first();
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
		$CashRequest = CashRequest::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $CashRequest,
			"msg_status" => sizeof($CashRequest) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($CashRequest,200);
	}

}