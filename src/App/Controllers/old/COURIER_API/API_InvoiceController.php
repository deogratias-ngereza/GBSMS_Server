<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Invoice;

class API_InvoiceController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Invoice = Invoice::orderBy('created_at','DESC')->get();
        $data = [
            "msg_data" => $Invoice,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //all_for_customer
    public function all_for_customer($req,$res,$args){
        $Invoices = Invoice::where('customer_id',$args['cust_id'])->with(['receiver','creator'])
        ->orderBy('created_at','DESC')->get();
        $data = [
            "msg_data" => $Invoices,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //all_for_customer overdue
    public function all_overdue_for_customer($req,$res,$args){
        $Invoices = Invoice::where('customer_id',$args['cust_id'])
        ->where('due_date','<',date('Y-m-d'))//TODO <= or <
        ->where('cleared','=',0)        ->with(['receiver','creator'])
        ->orderBy('created_at','DESC')->get();
        $data = [
            "msg_data" => $Invoices,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }


    //find from given id
    public function find($req,$res,$args){
        $Invoice = Invoice::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $Invoice,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
		return $res->withJSON($Invoice,200);
    }



    public function find_by_track_no($req,$res,$args){
        $Invoice = Invoice::where("manifest_track_no","=",$args['track_id'])->first();
		return $res->withJSON($Invoice,200);
    }





     //get delete
	public function delete($req,$res,$args){
		$Invoice = Invoice::where('id','=',$args['id'])->first();
		if(sizeof($Invoice) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Invoice->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$Invoice = Invoice::create($req->getParsedBody());
		$data = [
			"msg_data" => Invoice::all()->last(),
			"msg_status" => $Invoice == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(Invoice::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Invoice::where('id',$args['id'])
						->update($updates);
		$results = Invoice::where('id',$args['id'])->first();
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
		$Invoice = Invoice::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Invoice,
			"msg_status" => sizeof($Invoice) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Invoice,200);
	}

}