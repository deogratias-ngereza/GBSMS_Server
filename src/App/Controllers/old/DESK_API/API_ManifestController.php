<?php
namespace App\Controllers\DESK_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Manifest;

use App\Models\ProductMovementHistory;
use App\Models\Customer;


use App\Notify\NotifierProvider;

class API_ManifestController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Manifest = Manifest::with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])->get();
        //return $res->withJSON($Manifest,200);
        $data = [
            "msg_data" => $Customer,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }




    //all for warehouse
    public function all_for_warehouse($req,$res,$args){
    	$Manifest = null;
    	if($args['opt'] == "in"){//incomming
    		$Manifest = Manifest::where('destination_warehouse_id',$args['id'])
        		->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->get();
    	}else{
    		$Manifest = Manifest::where('source_warehouse_id',$args['id'])
        		->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->get();
    	}
        return $res->withJSON($Manifest,200);
    }



    //find from given id
    public function find($req,$res,$args){
        $Manifest = Manifest::where("id","=",$args['id'])
        	->with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse'])->first();
		return $res->withJSON($Manifest,200);
    }




     //get delete
	public function delete($req,$res,$args){
		$Manifest = Manifest::where('id','=',$args['id'])->first();
		if(sizeof($Manifest) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$Manifest->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}



	//insert
	public function insert($req,$res,$args){
		$Manifest = Manifest::create($req->getParsedBody());
		$m = Manifest::where('manifest_track_no',$req->getParsedBody()['manifest_track_no'])->first();
		/**/
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $req->getParsedBody()['manifest_track_no'];
		$mov_hist->manifest_id = $m->id;
		$mov_hist->worker_id = $req->getParsedBody()['created_by_worker_id'];
		$mov_hist->status = "ON_PROCESS";
		$mov_hist->description = $req->getParsedBody()['item_name']." is under process by our agent ";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$req->getParsedBody()['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		$notifier->send_sms($customer->phone,"[ On Process ] Thank you, we have received your product (".$req->getParsedBody()['item_name']."), product is under process and assigned TRACK-ID is (".$req->getParsedBody()['manifest_track_no'].") ");

		/**/
		$data = [
			"msg_data" => $m,
			"msg_status" => $Manifest == null ? "FAIL TO INSERT" :"OK"
		];
		return $res->withJSON($m,200);
	}





	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Manifest::where('id',$args['id'])
						->update($updates);
		$results = Manifest::where('id',$args['id'])->first();
		return $res->withJSON($results,200);
	}




	//update -- move on transit
	public function move_on_transit($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Manifest::where('id',$args['id'])
						->update($updates);
		/**/
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $updates['manifest_track_no'];
		$mov_hist->manifest_id = $updates['id'];
		$mov_hist->worker_id = $updates['transported_by_worker_id'];
		$mov_hist->status = "ON_TRANSIT";
		$mov_hist->description = $updates['item_name']." is on transit by our transporter ";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$updates['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		if($customer != null){
			$notifier->send_sms($customer->phone,"[ On Transit ] Your product (".$updates['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") is currently on transit.");
		}
		/**/
		$results = Manifest::where('id',$args['id'])->first();
		return $res->withJSON($results,200);
	}


	//update -- received by our agent
	public function received_by_agent($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Manifest::where('id',$args['id'])
						->update($updates);
		/**/
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $updates['manifest_track_no'];
		$mov_hist->manifest_id = $updates['id'];
		$mov_hist->worker_id = $updates['received_by_worker_id'];
		$mov_hist->status = "RECEIVED_BY_AGENT";
		$mov_hist->description = $updates['item_name']." is currently received to our agent.";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$updates['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		if($customer != null){
			$notifier->send_sms($customer->phone,"[ Received ] Your product (".$updates['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") is currently received by nearly agent.");
		}
		/**/
		$results = Manifest::where('id',$args['id'])->first();
		return $res->withJSON($results,200);
	}




	//update -- out for delivery
	public function put_out_for_delivery($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Manifest::where('id',$args['id'])
						->update($updates);
		/**/
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $updates['manifest_track_no'];
		$mov_hist->manifest_id = $updates['id'];
		$mov_hist->worker_id = $updates['transported_by_worker_id'];
		$mov_hist->status = "OUT_FOR_DELIVERY";
		$mov_hist->description = $updates['item_name']." is currently out for delivery.";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$updates['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		if($customer != null){
			$notifier->send_sms($customer->phone,"[ Out for delivery ] Your product (".$updates['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].")  is currently out for delivery.");
		}
		/**/
		$results = Manifest::where('id',$args['id'])->first();
		return $res->withJSON($results,200);
	}


	//update -- delivery failed
	public function put_ofd_failed($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Manifest::where('id',$args['id'])
						->update($updates);
		/**/
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $updates['manifest_track_no'];
		$mov_hist->manifest_id = $updates['id'];
		$mov_hist->worker_id = $updates['transported_by_worker_id'];
		$mov_hist->status = "DELIVERY_FAILED";
		$mov_hist->description = $updates['item_name']." failed to reach receiver.";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$updates['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		if($customer != null){
			$notifier->send_sms($customer->phone,"[ Delivery failed ] Sorry,your product (".$updates['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") failed to be delivered reason - ".$updates['remarks']);
		}
		/**/
		$results = Manifest::where('id',$args['id'])->first();
		return $res->withJSON($results,200);
	}


	//update -- return manifest after several delivery failures
	public function put_return_manifest($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = Manifest::where('id',$args['id'])
						->update($updates);
		/**/
		//create a mov history
		$mov_hist = new ProductMovementHistory;
		$mov_hist->track_no = $updates['manifest_track_no'];
		$mov_hist->manifest_id = $updates['id'];
		$mov_hist->worker_id = $updates['created_by_worker_id'];
		$mov_hist->status = "RETURNED";
		$mov_hist->description = $updates['item_name']." is returned back.";
		$mov_hist->save();

		//find the customer to send email/sms to
		$customer = Customer::where('id',$updates['customer_id'])->first();

		//send sms notification
		$notifier = new NotifierProvider();
		if($customer != null){
			$notifier->send_sms($customer->phone,"[ Returned ] Sorry,your product (".$updates['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") is returned reason - ".$updates['remarks']);
		}
		/**/
		$results = Manifest::where('id',$args['id'])->first();
		return $res->withJSON($results,200);
	}






	//search
	public function search($req,$res,$args){
		$key = trim($req->getQueryParams()['key'],"'");
		$Manifest = Manifest::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $Manifest,
			"msg_status" => sizeof($Manifest) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($Manifest,200);
	}

}