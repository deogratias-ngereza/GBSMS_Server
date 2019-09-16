<?php
namespace App\Controllers\COURIER_OP_MOB_API;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\CustomerAddress;

use App\Models\Manifest;

use App\Models\ProductMovementHistory;
use App\Models\Customer;


use App\Notify\NotifierProvider;
use App\Models\Pod;




class API_StatusChangeController extends BaseController{

    //all
    public function all($req,$res,$args){
        $Manifest = Manifest::with(['product','customer','sender_worker','receiver_worker','source_warehouse','destination_warehouse','transporter'])
        		->orderBy('created_date', 'DESC')
        		->take($this->getLimitSize('L'))
        		->get();
        return $res->withJSON($Manifest,200);
    }


    /* receive prod to warehouse */
	public function xreceive_to_warehouse($req,$res,$args){
        $data = [
			"msg_data" => "RECEiveD",
			"msg_status" => "OK"
		];
		return $res->withJSON($data,200);
    }


    //update -- received by our agent
    public function receive_to_warehouse($req,$res,$args){
        $updates = $req->getParsedBody();
        $update_status = Manifest::where('manifest_track_no',$updates['manifest_track_no'])
                        ->update([
                            "received_by_worker_id" => $updates['received_by_worker_id'],
                            "status" => "RECEIVED_BY_AGENT"//TODO
                        ]);

        $update_status = Manifest::where('manifest_track_no',$updates['manifest_track_no'])
                        ->first();
        if($update_status == null){
            return $res->withJSON("NO ENTRY FOUND!",200);
        }
        //
        //create a mov history
        $mov_hist = new ProductMovementHistory;
        $mov_hist->track_no = $updates['manifest_track_no'];
        $mov_hist->manifest_id = $update_status->id;//$updates['id'];
        $mov_hist->worker_id = $updates['received_by_worker_id'];
        $mov_hist->status = "RECEIVED_BY_AGENT";
        $mov_hist->description = $update_status['item_name']." is currently received to post warehouse";
        $mov_hist->current_wh_id = $updates['current_wh_id'];
        $mov_hist->save();

        //find the customer to send email/sms to
        $customer = Customer::where('id',$update_status['customer_id'])->first();

        //send sms notification
        $notifier = new NotifierProvider();
        if($customer != null){
            $notifier->send_sms($customer->phone,"(Posta Mkononi) Your item (".$update_status['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") is currently at posta agent.");
        }
        //
        return $res->withJSON($update_status,200);
    }


    //update -- move on transit
    public function move_on_transit($req,$res,$args){
        $updates = $req->getParsedBody();
        $update_status = Manifest::where('manifest_track_no',$updates['manifest_track_no'])
                        ->update([
                            //"transported_by_worker_id" => $updates['transported_by_worker_id'],
                            "status" => "ON_TRANSIT"//TODO
                        ]);
        $update_status = Manifest::where('manifest_track_no',$updates['manifest_track_no'])
                        ->first();
        /**/
        //create a mov history
        $mov_hist = new ProductMovementHistory;
        $mov_hist->track_no = $updates['manifest_track_no'];
        $mov_hist->manifest_id = $update_status['id'];
        $mov_hist->worker_id = $updates['worker_id'];
        $mov_hist->status = "ON_TRANSIT";
        $mov_hist->current_wh_id = $updates['current_wh_id'];
        $mov_hist->description = $update_status['item_name']." is on transit by our transporter ";
        $mov_hist->save();

        //find the customer to send email/sms to
        $customer = Customer::where('id',$update_status['customer_id'])->first();

        //send sms notification
        $notifier = new NotifierProvider();
        if($customer != null){
            $notifier->send_sms($customer->phone,"(Posta Mkononi) Your item (".$update_status['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") is currently moved out from warehouse for processing.");
        }
        /**/
        return $res->withJSON($update_status,200);
    }

    //update -- move on transit
    public function move_2_inbox($req,$res,$args){
        $updates = $req->getParsedBody();
        /*$update_status = Manifest::where('manifest_track_no',$updates['manifest_track_no'])
                        ->update([
                            "transported_by_worker_id" => $updates['transported_by_worker_id'],
                            "status" => "ON_TRANSIT"//TODO
                        ]);*/
        $update_status = Manifest::where('manifest_track_no',$updates['manifest_track_no'])
                        ->first();
        /**/
        //create a mov history
        $mov_hist = new ProductMovementHistory;
        $mov_hist->track_no = $updates['manifest_track_no'];
        $mov_hist->manifest_id = $update_status['id'];
        $mov_hist->worker_id = $updates['worker_id'];
        $mov_hist->status = "ON_BOX";
        $mov_hist->current_wh_id = $updates['current_wh_id'];
        $mov_hist->description = $update_status['item_name']." is on your physical box";
        $mov_hist->save();

        //find the customer to send email/sms to
        $customer = Customer::where('id',$update_status['customer_id'])->first();

        //send sms notification
        $notifier = new NotifierProvider();
        if($customer != null){
            $notifier->send_sms($customer->phone,"(Posta Mkononi) Your item (".$update_status['item_name']."), with TRACK-ID (".$updates['manifest_track_no'].") is currently on your physical box");
        }
        /**/
        return $res->withJSON($update_status,200);
    }











}