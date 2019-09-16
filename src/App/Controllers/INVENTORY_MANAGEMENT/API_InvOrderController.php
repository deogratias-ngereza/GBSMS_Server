<?php
namespace App\Controllers\INVENTORY_MANAGEMENT;

use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\InvOrder;
use App\Models\InvOrderParticular;

class API_InvOrderController extends BaseController{


	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new InvOrder;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $InvOrder = InvOrder::all();
        $data = [
            "msg_data" => $InvOrder,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($InvOrder,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $InvOrder = InvOrder::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $InvOrder,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($InvOrder,200);
    }





    //find from given order no
    public function find_order_no($req,$res,$args){
        $InvOrder = InvOrder::where("order_no","=",$args['order_no'])->with(['creator','supplier'])->first();
        $InvParticulars = InvOrderParticular::where("order_no","=",$args['order_no'])->with(['product'])->get();
        $data = [
            "msg_data" => ["order"=>$InvOrder,"particulars"=>$InvParticulars],
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }








     //get delete
	public function delete($req,$res,$args){
		$InvOrder = InvOrder::where('id','=',$args['id'])->first();
		if(sizeof($InvOrder) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$InvOrder->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}



	//insert
	/*
		receive an order here
	*/
	public function insert($req,$res,$args){
		$order_summary = $req->getParsedBody()['summary'];
		$order_particulars = $req->getParsedBody()['order_particulars'];
		$order_creator = $req->getParsedBody()['worker_id'];

		//current date
		$Date =date('Y-m-d');

		//task 1 create new order 
		$inv_order = new InvOrder();
		$inv_order->supplier_id = $order_summary['supplier_id'];
		$inv_order->order_no = $order_summary['order_no'];
		$inv_order->total_exp_amt = $order_summary['total'];
		$inv_order->total_amt = 0;//default value before paid
		$inv_order->currency = $order_summary['currency'];
		$inv_order->exchange_rate = $order_summary['exchange_rate'];
		$inv_order->orders = $order_summary['orders_count'];
		$inv_order->created_by_worker_id = $order_creator;
		$inv_order->exp_delivery_date = date('Y-m-d', strtotime($Date. ' + '.$order_summary['lead_time'].' days'));//add lead_time date to get exp delivery to come
		$inv_order->save();

		//task 2 iterate over order particulars and set particulars
		for($i = 0; $i < sizeof($order_particulars);$i++){
			$invOrderParticular = new InvOrderParticular();
			$invOrderParticular->order_no = $order_summary['order_no'];
			$invOrderParticular->item_id = $order_particulars[$i]['item_id'];
			$invOrderParticular->qty_ordered = $order_particulars[$i]['qty'];
			$invOrderParticular->odered_date = $Date;
			$invOrderParticular->unit_price = $order_particulars[$i]['item_price'];
			$invOrderParticular->exp_purchase_price = $order_particulars[$i]['item_price'] * $order_particulars[$i]['qty'];
			$invOrderParticular->currency = $order_particulars[$i]['currency'];
			$invOrderParticular->exp_delivery_date =date('Y-m-d', strtotime($Date. ' + '.$order_particulars[$i]['lead_time'].' days'));;
			$invOrderParticular->lead_time = $order_particulars[$i]['lead_time'];
			$invOrderParticular->store_category = 'MAIN_STORE';
			$invOrderParticular->save();
		}
		$data = ["msg_data" => $inv_order,"msg_status" => "OK"];
		return $res->withJSON($data,200);
	}


//


	public function deep_search_single_order($req,$res,$args){
    	$qry = $req->getParsedBody()['search_key'];
        $InvOrder = InvOrder::whereRaw("order_no LIKE '%".$qry."%'")->take(10)->get();
        $data = [
            "msg_data" => $InvOrder,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }




	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = InvOrder::where('id',$args['id'])
						->update($updates);
		$results = InvOrder::where('id',$args['id'])->first();
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
		$InvOrder = InvOrder::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $InvOrder,
			"msg_status" => sizeof($InvOrder) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($InvOrder,200);
	}

}