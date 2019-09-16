<?php
namespace App\Controllers\TRANS_MANAGEMENT;

use App\Controllers\BaseController;
use App\Controllers\TRANS_MANAGEMENT\SystemHistoryController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\TM_Trip;
use App\Models\TM_TripOffload;

class API_TM_TripController extends BaseController{

	protected $recorder;
	public function __construct(){
		$this->recorder = new SystemHistoryController();
	}


	
	//tbl fields
	public function tbl_fields($req,$res,$args){
        $TBL = new TM_Trip;
        return $res->withJSON($TBL->tbl_fields(),200);
    }

    
    //all
    public function all($req,$res,$args){
        $TM_Trip = TM_Trip::all();
        $data = [
            "msg_data" => $TM_Trip,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
        //return $res->withJSON($TM_Trip,200);
    }


    public function make_trip_n_trips_offloads($req,$res,$args){
    	$inputs = $req->getParsedBody();

    	//create a general trip(trips table)
    	

    	for($i = 0; $i < sizeof($inputs['order_trips']);$i++){
    		//create a single trip entry
    		$trip = new TM_Trip();
    		$trip->order_no = $inputs['order_no'];
    		$trip->trip_no = $inputs['order_trips'][$i]['trip_id'];
    		$trip->vehicle_id = $inputs['order_trips'][$i]['vehicle_id'];
    		$trip->vehicle_name = $inputs['order_trips'][$i]['vehicle_name'];
    		$trip->destinations = json_encode($inputs['order_trips'][$i]['destinations'],true);
    		$trip->created_by = $inputs['creator'];
    		$trip->status = "INITIATED";
    		$trip->save();

    		
    		for($tof = 0; $tof < sizeof($inputs['order_trips'][$i]['trips']);$tof++){
    			$current_tof = $inputs['order_trips'][$i]['trips'][$tof];
    			//now create trip offloads for each trip
	    		$trip_offload = new TM_TripOffload();
	    		$trip_offload->vehicle_id = $inputs['order_trips'][$i]['vehicle_id'];
	    		$trip_offload->order_no = $inputs['order_no'];
	    		$trip_offload->trip_base_no = $inputs['order_trips'][$i]['trip_id'];
	    		$trip_offload->trip_no = $current_tof['trip_id'];
	    		$trip_offload->dest_id = $current_tof['dest_id'];
	    		$trip_offload->dest_address = $current_tof['dest_name'];
	    		$trip_offload->created_by = $inputs['creator'];

	    		//find the products
	    		for($tof_prod = 0; $tof_prod < sizeof($current_tof['products']);$tof_prod++){
	    			$current_prod_obj = $current_tof['products'][$tof_prod];
	    			//dont save if 
	    			if ($current_prod_obj['product'] == 'pms')  $trip_offload->exp_offload_pms = $current_prod_obj['qty'];
	    			if ($current_prod_obj['product'] == 'ago')  $trip_offload->exp_offload_ago = $current_prod_obj['qty'];
	    			if ($current_prod_obj['product'] == 'lpg')  $trip_offload->exp_offload_lpg = $current_prod_obj['qty'];
	    			if ($current_prod_obj['product'] == 'jet')  $trip_offload->exp_offload_jet = $current_prod_obj['qty'];
	    			if ($current_prod_obj['product'] == 'ik')  $trip_offload->exp_offload_ik = $current_prod_obj['qty'];
	    			if ($current_prod_obj['product'] == 'other')  $trip_offload->exp_offload_other = $current_prod_obj['qty'];
	    		}
	    		//save if one of them is set 
	    		if($trip_offload->exp_offload_pms == 0 && $trip_offload->exp_offload_ago == 0 && $trip_offload->exp_offload_jet == 0 && $trip_offload->exp_offload_ik == 0 && $trip_offload->exp_offload_lpg == 0 && $trip_offload->exp_offload_other == 0){
	    			//please dont save dis
	    		}else { $trip_offload->save(); }
	    		
    		}

    	}

    	$data = [
            "msg_data" => $inputs,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
    }

    //find from given id
    public function find($req,$res,$args){
        $TM_Trip = TM_Trip::where("id","=",$args['id'])->first();
        $data = [
            "msg_data" => $TM_Trip,
            "msg_status" => "OK"
        ];
        return $res->withJSON($data,200);
		//return $res->withJSON($TM_Trip,200);
    }

     //get delete
	public function delete($req,$res,$args){
		$TM_Trip = TM_Trip::where('id','=',$args['id'])->first();
		if(sizeof($TM_Trip) == 0){
			$data = [ "msg_data" => "ALREADY DELETED","msg_status" => "FAILED"];
			return $res->withJSON($data,401);
		}
		$TM_Trip->delete();
		$data = ["msg_data" => "DATA DELETED","msg_status" => "OK"];
		return $res->withJSON($data,200);
	}

	//insert
	public function insert($req,$res,$args){
		$TM_Trip = TM_Trip::create($req->getParsedBody());
		$data = [
			"msg_data" => TM_Trip::all()->last(),
			"msg_status" => $TM_Trip == null ? "FAIL TO INSERT" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON(TM_Trip::all()->last(),200);
	}

	//update
	public function update($req,$res,$args){
		$updates = $req->getParsedBody();
		$update_status = TM_Trip::where('id',$args['id'])
						->update($updates);
		$results = TM_Trip::where('id',$args['id'])->first();
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
		$TM_Trip = TM_Trip::whereRaw("id LIKE '%".$key."%'")->get();
		$data = [
			"msg_data" => $TM_Trip,
			"msg_status" => sizeof($TM_Trip) == 0 ? "NO RESULTS FOUND" :"OK"
		];
		//return $res->withJSON($data,200);
		return $res->withJSON($TM_Trip,200);
	}

}