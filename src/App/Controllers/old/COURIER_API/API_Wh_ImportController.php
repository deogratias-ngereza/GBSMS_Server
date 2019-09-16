<?php
namespace App\Controllers\COURIER_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Wh_Import;
use App\Models\ProductMovementHistory;
use App\Models\Customer;


use App\Notify\NotifierProvider;

class API_Wh_ImportController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Wh_Import = Wh_Import::all();
        $data = [
            "msg_data" => $Wh_Import,
            "msg_status" => "OK"
        ];
        //return $res->withJSON($data,200);
        return $res->withJSON($Wh_Import,200);
    }



    //all for a given ware house id
    public function all_for_warehouse($req,$res,$args){
    	$option = null;
    	if(trim($req->getQueryParams()['opt'],"'") == 'source'){
    		$option = "source_warehouse_id";
    	}else{
    		$option = "destination_warehouse_id";
    	}

        $Wh_Import = Wh_Import::where($option,$args['id'])
        	->with(['product','supplier','worker','source_warehouse','destination_warehouse','customer'])
        	->get();
        $data = [
            "msg_data" => $Wh_Import,
            "msg_status" => "OK"
        ];
        return $res->withJSON($Wh_Import,200);
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

     //get delete
	public function delete($req,$res,$args){
		$Wh_Import = Wh_Import::where('id','=',$args['id'])->first();
		if(sizeof($Wh_Import) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Wh_Import->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
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

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Wh_Import::where('id',$args['id'])
						->update($updates);
		$results = Wh_Import::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($results,200);
	}

	public function receive_an_import($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Wh_Import::where('id',$args['id'])
						->update($updates);
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $req->getParsedBody()['track_no'];
		$mov_hist->wh_import_id = $args['id'];
		$mov_hist->worker_id = $req->getParsedBody()['receiver_worker_id'];
		$mov_hist->status = "RECEIVED";
		$mov_hist->description = "Product received on ".$req->getParsedBody()['received_date'];
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$req->getParsedBody()['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		$notifier->send_sms($customer->phone,"[ Received ] Thank you, we have received your product on ".$req->getParsedBody()['received_date'].", assigned TRACK-ID : (".$req->getParsedBody()['track_no'].") ");

		$results = Wh_Import::where('id',$args['id'])->first();
		$data = [
			"msg_data" => $results,
			"msg_status" => $update_status == 1 ? "FAIL TO UPDATE" :"OK"
		];
		return $res->withJSON($data,200);

	}

	//mark as received(update) with new track no
	public function receive_an_import_with_new_trackno($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Wh_Import::where('id',$args['id'])
						->update($updates);
		
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $req->getParsedBody()['track_no'];
		$mov_hist->wh_import_id = $args['id'];
		$mov_hist->worker_id = $req->getParsedBody()['receiver_worker_id'];
		$mov_hist->status = "TRACKED";
		$mov_hist->description = "Product track-id assigned on ".$req->getParsedBody()['received_date'];
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$req->getParsedBody()['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		$notifier->send_sms($customer->phone,"[TRACK-ID ASSIGNMENT] Thank you, your product on ".$req->getParsedBody()['received_date'].", assigned to TRACK-ID : (".$req->getParsedBody()['track_no'].") ");


		$results = Wh_Import::where('id',$args['id'])->first();
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
		$Wh_Import = Wh_Import::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Wh_Import,
			"msg_status" => sizeof($Wh_Import) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Wh_Import,200);
	}



	/*
	* EXPORT AN IMPOrt
	* new row entry and change previous status id
	*/
	public function export_an_import($req,$res,$args){
		$bodyData = $req->getParsedBody();
		$prev_id = $bodyData['id'];

		//find the older row id and update
		$older_import = Wh_Import::where('id',$bodyData['id'])->first();
		$older_import->status = "EXPORTED";
		$older_import->update();

		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $req->getParsedBody()['track_no'];
		$mov_hist->wh_import_id = $bodyData['id'];
		$mov_hist->worker_id = $req->getParsedBody()['by_worker_id'];
		$mov_hist->status = "EXPORTED";
		$mov_hist->description = "Product exported";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$req->getParsedBody()['customer_id'])->first();
		//send sms notification
		$notifier = new NotifierProvider();
		$notifier->send_sms($customer->phone,"[EXPORT] Your product with ID: (".$req->getParsedBody()['track_no']."), is currently on export.");



		//put a new row entry
		$Wh_Import = Wh_Import::create($bodyData);
		$data = [
			"msg_data" => Wh_Import::all()->last(),
			"msg_status" => $Wh_Import == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON($data,200);
	}

}