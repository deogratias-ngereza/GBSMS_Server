<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Order;
use App\Models\TmExchangeRate;
use App\Models\TM_Customer;

class API_TM_OrderController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}

	
	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_Order;
        return $res->withJSON($TBL->tbl_fields(),200);
    }


    
    //all
    public function all($req,$res,$args){
        $TM_Order = TM_Order::all();
        $data = [
            "msg_data" => $TM_Order,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_Order,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_Order = TM_Order::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_Order,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_Order,200);
    }

    //find from given order_no
    public function find_order_no($req,$res,$args){
        $TM_Order = TM_Order::where("order_no","=",$args['order_no'])->with(['customer','checker','authorizer','attender','approver'])->first();
        $data = [
            "msg_data" => $TM_Order,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_Order = TM_Order::where('id','=',$args['id'])->first();
		if(sizeof($TM_Order) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_Order->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}
	

	//receive the attended order
	public function receive_attendend_order($req,$res,$args){
		$inputs  = $req->getParsedBody();

		$attendor_id = $args['attendor'];
		$order_no = $args['order_no'];

		//find order of given no
		$Order = TM_Order::where('order_no','=',$order_no)->first();
		$Order->exp_veh_comp_fills_json = json_encode($inputs,true);
		$Order->attended_date = $this->get_current_date();
		$Order->attended_by = $attendor_id;
		$Order->attended_status = "ATTENDED";
		$Order->update();

		//TODO:: remove vehicle from list of allocated vehicles

		$data = [
			"msg_data" => $inputs,
			"msg_status" => ""
		];
		return $res->withJSON($data,200); 
	}


	//insert new order
	public function insert($req,$res,$args){
		//$req->getParsedBody()
		$inputs  = $req->getParsedBody();

		//get current exchange rate which is set
		$rate = 2300;
		$exRate = TmExchangeRate::where('from','USD')->where('to','TZS')->first();
		if($exRate != null) $rate = $exRate->amt;

		//get customer currency
		$currency = 'USD'; 
		$customer = TM_Customer::where('id',(int)$inputs['customer_id'])->first();//
		if($customer != null) $currency = $customer->currency;

		$order = new TM_Order();
		$order->order_no = $inputs['order_no'];
		$order->customer_id = (int) $inputs['customer_id'];
		$order->currency = $currency;
		$order->current_exch_rate = $rate;
		$order->source_id = $inputs['source_id'];
		$order->destination_id = $inputs['destination_id'];
		$order->is_single_destination = $inputs['is_single_destination'];
		$order->status = "RECEIVED";
		$order->dests_with_qty_json = json_encode($inputs['dest_with_qty'],true);
		$order->qty_ago = $inputs['prod_total_summary']['total_ago'];
		$order->qty_pms = $inputs['prod_total_summary']['total_pms'];
		$order->qty_ik = $inputs['prod_total_summary']['total_ik'];
		$order->qty_lpg = $inputs['prod_total_summary']['total_lpg'];
		$order->qty_jet = $inputs['prod_total_summary']['total_jet'];
		$order->qty_other = $inputs['prod_total_summary']['total_other'];
		$order->total_qty = $inputs['overall_total'];
		$order->save();

		$data = [
			"msg_data" => $order,
			"msg_status" => ""
		];
		return $res->withJSON($data,200);
	}



	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_Order::where('id',$args['id'])
						->update($updates);
		$results = TM_Order::where('id',$args['id'])->first();
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
		$TM_Order = TM_Order::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_Order,
			"msg_status" => sizeof($TM_Order) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_Order,200);
	}

}